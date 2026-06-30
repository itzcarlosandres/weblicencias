<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    public function create(Request $request)
    {
        if ($request->has('ref')) {
            session(['referral_code' => $request->get('ref')]);
        }
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $referrerId = null;
        if ($refCode = session('referral_code')) {
            $referrer = User::where('referral_code', $refCode)->first();
            if ($referrer) {
                $referrerId = $referrer->id;
            }
        }

        $ip = $request->ip();
        $country = null;
        if ($ip && !in_array($ip, ['127.0.0.1', '::1', 'localhost'])) {
            try {
                $response = \Illuminate\Support\Facades\Http::timeout(3)->get("http://ip-api.com/json/{$ip}?fields=country");
                if ($response->successful()) {
                    $country = $response->json('country');
                }
            } catch (\Exception $e) {}
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'email_verified_at' => now(),
            'referral_code' => \Illuminate\Support\Str::random(10),
            'referred_by' => $referrerId,
            'ip_address' => $ip,
            'country' => $country,
        ]);

        $user->assignRole('user');

        if ($referrerId) {
            $referrer = User::find($referrerId);
            if ($referrer) {
                $user->referred_by = $referrer->id;
                $user->save();

                // Get points setting or default 500
                $welcomePoints = (int)\App\Models\Setting::get('referral_welcome_points', '500');

                if ($welcomePoints > 0) {
                    // Give points to the new user for registering via referral
                    $pointsService = app(\App\Services\PointsService::class);
                    $pointsService->awardPoints(
                        $user, 
                        $welcomePoints, 
                        "Bono de bienvenida por registro con referido"
                    );
                }
            }
        }

        try {
            if (\App\Models\Setting::get('mail_host')) {
                \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\WelcomeEmail($user));
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('No se pudo enviar el correo de bienvenida: ' . $e->getMessage());
        }

        Auth::login($user);

        return redirect()->route('customer.dashboard')->with('success', '¡Bienvenido! Tu cuenta ha sido creada exitosamente.');
    }
}
