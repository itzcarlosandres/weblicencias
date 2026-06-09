<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'sometimes|required|string|max:255',
            'site_tagline' => 'nullable|string|max:255',
            'site_description' => 'nullable|string|max:500',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:50',
            'currency' => 'nullable|string|max:10',
            'currency_symbol' => 'nullable|string|max:5',
            'exchange_rate_cop' => 'nullable|numeric|min:0',
            'logo' => 'nullable|file|mimes:png,jpg,jpeg,svg,webp,avif|max:2048',
            'favicon' => 'nullable|file|mimes:png,ico,svg,webp,avif|max:1024',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'footer_text' => 'nullable|string|max:500',
            'primary_color' => 'nullable|string|max:20',
            'home_grid_columns' => 'nullable|integer|min:2|max:6',
            'home_featured_count' => 'nullable|integer|min:4|max:24',
            'catalog_grid_columns' => 'nullable|integer|min:2|max:6',
            'hero_badge' => 'nullable|string|max:255',
            'hero_title' => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string|max:255',
            'hero_description' => 'nullable|string|max:500',
            'hero_feature_1' => 'nullable|string|max:255',
            'hero_feature_2' => 'nullable|string|max:255',
            'hero_feature_3' => 'nullable|string|max:255',
            'points_enabled' => 'nullable|boolean',
            'points_per_dollar' => 'nullable|integer|min:1|max:100',
            'points_redemption_rate' => 'nullable|integer|min:1|max:10000',
            'points_discount_per_redemption' => 'nullable|numeric|min:0.01|max:100',
            'points_min_redeem' => 'nullable|integer|min:1|max:10000',
            'points_expiry_days' => 'nullable|integer|min:1|max:3650',
            'payment_paypal_enabled' => 'nullable|boolean',
            'payment_mercadopago_enabled' => 'nullable|boolean',
            'payment_wompi_enabled' => 'nullable|boolean',
            'wompi_public_key' => 'nullable|string|max:500',
            'wompi_private_key' => 'nullable|string|max:500',
            'wompi_events_secret' => 'nullable|string|max:500',
            'wompi_sandbox_mode' => 'nullable|boolean',
            'gemini_api_key' => 'nullable|string|max:500',
            'announcement_enabled' => 'nullable|boolean',
            'announcement_mode' => 'nullable|string|in:top_bar,floating',
            'announcement_text' => 'nullable|string|max:500',
            'announcement_link' => 'nullable|string|max:500',
            'announcement_color' => 'nullable|string|max:20',
            
            // Popups
            'exit_intent_enabled' => 'nullable|boolean',
            'exit_intent_title' => 'nullable|string|max:255',
            'exit_intent_text' => 'nullable|string',
            'exit_intent_coupon' => 'nullable|string|max:50',
            'exit_intent_timer' => 'nullable|integer|min:1|max:60',
            
            // Referrals
            'referral_welcome_points' => 'nullable|integer|min:0',
            'referral_reward_points' => 'nullable|integer|min:0',
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $oldLogo = Setting::get('logo');
            if ($oldLogo && Storage::disk('public')->exists('settings/' . $oldLogo)) {
                Storage::disk('public')->delete('settings/' . $oldLogo);
            }
            $logo = $request->file('logo')->store('settings', 'public');
            $validated['logo'] = basename($logo);
            unset($validated['logo']);
            Setting::set('logo', basename($logo), 'appearance');
        }
        unset($validated['logo']);

        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            $oldFavicon = Setting::get('favicon');
            if ($oldFavicon && Storage::disk('public')->exists('settings/' . $oldFavicon)) {
                Storage::disk('public')->delete('settings/' . $oldFavicon);
            }
            $favicon = $request->file('favicon')->store('settings', 'public');
            $validated['favicon'] = basename($favicon);
            unset($validated['favicon']);
            Setting::set('favicon', basename($favicon), 'appearance');
        }
        unset($validated['favicon']);

        // Save general settings
        $generalFields = ['site_name', 'site_tagline', 'site_description', 'contact_email', 'contact_phone', 'currency', 'currency_symbol', 'exchange_rate_cop', 'home_grid_columns', 'home_featured_count', 'catalog_grid_columns'];
        foreach ($generalFields as $field) {
            if ($request->has($field) || array_key_exists($field, $validated)) {
                Setting::set($field, $request->input($field, ''), 'general');
            }
        }

        // Save SEO settings
        $seoFields = ['meta_title', 'meta_description', 'meta_keywords', 'footer_text'];
        foreach ($seoFields as $field) {
            if ($request->exists($field)) {
                Setting::set($field, $request->input($field, ''), 'seo');
            }
        }

        // Save appearance settings
        if ($request->exists('primary_color')) {
            Setting::set('primary_color', $validated['primary_color'], 'appearance');
        }

        // Save hero settings
        $heroFields = ['hero_badge', 'hero_title', 'hero_subtitle', 'hero_description', 'hero_feature_1', 'hero_feature_2', 'hero_feature_3'];
        foreach ($heroFields as $field) {
            if ($request->exists($field)) {
                Setting::set($field, $request->input($field, ''), 'appearance');
            }
        }

        // Save points settings
        $pointsFields = ['points_enabled', 'points_per_dollar', 'points_redemption_rate', 'points_discount_per_redemption', 'points_min_redeem', 'points_expiry_days'];
        foreach ($pointsFields as $field) {
            if ($request->exists($field)) {
                Setting::set($field, $request->input($field, ''), 'points');
            }
        }

        // Save payment settings
        $paymentFields = ['payment_paypal_enabled', 'payment_mercadopago_enabled', 'payment_wompi_enabled', 'wompi_public_key', 'wompi_private_key', 'wompi_events_secret', 'wompi_sandbox_mode'];
        foreach ($paymentFields as $field) {
            if ($request->exists($field)) {
                Setting::set($field, $request->input($field), 'payment');
            }
        }

        // Save AI settings
        $aiFields = ['gemini_api_key'];
        foreach ($aiFields as $field) {
            if ($request->exists($field)) {
                Setting::set($field, $request->input($field, ''), 'ai');
            }
        }

        // Save announcement settings
        $announcementFields = ['announcement_enabled', 'announcement_mode', 'announcement_text', 'announcement_link', 'announcement_color'];
        foreach ($announcementFields as $field) {
            if ($request->exists($field)) {
                Setting::set($field, $request->input($field, ''), 'appearance');
            }
        }
        
        // Save popup settings
        $popupFields = ['exit_intent_enabled', 'exit_intent_title', 'exit_intent_text', 'exit_intent_coupon', 'exit_intent_timer'];
        foreach ($popupFields as $field) {
            if ($request->exists($field)) {
                Setting::set($field, $request->input($field, ''), 'appearance');
            }
        }
        
        // Save referrals settings
        $referralFields = ['referral_welcome_points', 'referral_reward_points'];
        foreach ($referralFields as $field) {
            if ($request->exists($field)) {
                Setting::set($field, $request->input($field, ''), 'points');
            }
        }

        return back()->with('success', 'Configuración actualizada correctamente')->with('active_tab', $request->input('active_tab', 'general'));
    }
}
