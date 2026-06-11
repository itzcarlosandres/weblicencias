<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        $activeTab = $request->query('tab', 'general');
        $saved = $request->session()->get('_settings_saved', false);

        return view('admin.settings.index', [
            'settings' => $settings,
            'activeTab' => $activeTab,
            'saved' => $saved,
        ]);
    }

    public function update(Request $request)
    {
        $activeTab = $request->input('tab', 'general');

        // Always fetch current COP rate from API when currency is COP
        if ($request->input('currency') === 'COP') {
            \App\Services\CurrencyService::refreshRate();
        }

        // Logo upload
        if ($request->hasFile('logo')) {
            $old = Setting::get('logo');
            if ($old) Storage::disk('public')->delete('settings/' . $old);
            $file = $request->file('logo');
            Setting::set('logo', $file->getClientOriginalName(), 'appearance');
        }

        // Favicon upload
        if ($request->hasFile('favicon')) {
            $old = Setting::get('favicon');
            if ($old) Storage::disk('public')->delete('settings/' . $old);
            $file = $request->file('favicon');
            Setting::set('favicon', $file->getClientOriginalName(), 'appearance');
        }

        // Save all text fields
        $fields = [
            // General
            'site_name', 'site_tagline', 'site_description', 'contact_email', 'contact_phone',
            'currency', 'currency_symbol', 'exchange_rate_cop',
            'home_grid_columns', 'home_featured_count', 'catalog_grid_columns',
            // SEO
            'meta_title', 'meta_description', 'meta_keywords', 'footer_text',
            // Appearance
            'primary_color', 'hero_badge', 'hero_title', 'hero_subtitle',
            'hero_description', 'hero_feature_1', 'hero_feature_2', 'hero_feature_3',
            // Announcements
            'announcement_enabled', 'announcement_mode', 'announcement_text',
            'announcement_link', 'announcement_color',
            // Exit Intent
            'exit_intent_enabled', 'exit_intent_title', 'exit_intent_text',
            'exit_intent_coupon', 'exit_intent_timer',
            // Points
            'points_enabled', 'points_per_dollar', 'points_redemption_rate',
            'points_discount_per_redemption', 'points_min_redeem', 'points_expiry_days',
            // Referrals
            'referral_welcome_points', 'referral_reward_points',
            // Payment
            'payment_paypal_enabled', 'payment_mercadopago_enabled', 'payment_wompi_enabled',
            'wompi_public_key', 'wompi_private_key', 'wompi_events_secret', 'wompi_sandbox_mode',
            // AI
            'gemini_api_key',
            // Mail
            'mail_host', 'mail_port', 'mail_username', 'mail_password',
            'mail_encryption', 'mail_from_address',
        ];

        foreach ($fields as $field) {
            $value = $request->input($field);
            // Skip exchange_rate_cop when currency is COP - we already fetched fresh rate above
            if ($field === 'exchange_rate_cop' && $request->input('currency') === 'COP') {
                continue;
            }
            if ($request->has($field)) {
                Setting::set($field, $value, $this->groupFor($field));
            }
        }

        return redirect()
            ->to('/admin/configuracion?tab=' . $activeTab . '&saved=1#top')
            ->with('_settings_saved', true);
    }

    private function groupFor(string $field): string
    {
        $map = [
            'site_name' => 'general', 'site_tagline' => 'general', 'site_description' => 'general',
            'contact_email' => 'general', 'contact_phone' => 'general', 'currency' => 'general',
            'currency_symbol' => 'general', 'exchange_rate_cop' => 'general',
            'home_grid_columns' => 'general', 'home_featured_count' => 'general', 'catalog_grid_columns' => 'general',
            'meta_title' => 'seo', 'meta_description' => 'seo', 'meta_keywords' => 'seo', 'footer_text' => 'seo',
            'primary_color' => 'appearance', 'hero_badge' => 'appearance', 'hero_title' => 'appearance',
            'hero_subtitle' => 'appearance', 'hero_description' => 'appearance',
            'hero_feature_1' => 'appearance', 'hero_feature_2' => 'appearance', 'hero_feature_3' => 'appearance',
            'logo' => 'appearance', 'favicon' => 'appearance',
            'announcement_enabled' => 'appearance', 'announcement_mode' => 'appearance',
            'announcement_text' => 'appearance', 'announcement_link' => 'appearance', 'announcement_color' => 'appearance',
            'exit_intent_enabled' => 'appearance', 'exit_intent_title' => 'appearance',
            'exit_intent_text' => 'appearance', 'exit_intent_coupon' => 'appearance', 'exit_intent_timer' => 'appearance',
            'points_enabled' => 'points', 'points_per_dollar' => 'points', 'points_redemption_rate' => 'points',
            'points_discount_per_redemption' => 'points', 'points_min_redeem' => 'points', 'points_expiry_days' => 'points',
            'referral_welcome_points' => 'points', 'referral_reward_points' => 'points',
            'payment_paypal_enabled' => 'payment', 'payment_mercadopago_enabled' => 'payment',
            'payment_wompi_enabled' => 'payment', 'wompi_public_key' => 'payment',
            'wompi_private_key' => 'payment', 'wompi_events_secret' => 'payment', 'wompi_sandbox_mode' => 'payment',
            'gemini_api_key' => 'ai',
            'mail_host' => 'emails', 'mail_port' => 'emails', 'mail_username' => 'emails',
            'mail_password' => 'emails', 'mail_encryption' => 'emails', 'mail_from_address' => 'emails',
        ];
        return $map[$field] ?? 'general';
    }
}