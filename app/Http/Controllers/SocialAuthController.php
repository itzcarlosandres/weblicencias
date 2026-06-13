<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;

class SocialAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            $user = User::where('email', $googleUser->email)->first();

            if ($user) {
                // El usuario existe, vincular google_id si no lo tiene
                if (!$user->google_id) {
                    $user->update([
                        'google_id' => $googleUser->id,
                        'avatar' => $user->avatar ?? $googleUser->avatar
                    ]);
                }
                
                Auth::login($user);
            } else {
                // Crear un nuevo usuario
                $newUser = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => bcrypt(Str::random(24)), // Random password
                    'avatar' => $googleUser->avatar,
                    'email_verified_at' => Carbon::now(), // Emails from Google are pre-verified
                    'referral_code' => Str::random(8),
                ]);

                // Asignar rol de cliente
                $customerRole = Role::where('name', 'customer')->first();
                if ($customerRole) {
                    $newUser->assignRole($customerRole);
                }

                Auth::login($newUser);
            }

            return redirect()->route('customer.dashboard')->with('success', 'Sesión iniciada con Google exitosamente.');

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Google Login Error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Hubo un error al iniciar sesión con Google. Por favor, intenta de nuevo.');
        }
    }

    public function oneTapCallback(Request $request)
    {
        try {
            $credential = $request->input('credential');
            
            if (!$credential) {
                return redirect()->back()->with('error', 'Token de Google no recibido.');
            }

            // Verificar el token usando el endpoint de Google
            $response = \Illuminate\Support\Facades\Http::get('https://oauth2.googleapis.com/tokeninfo?id_token=' . $credential);
            
            if (!$response->successful()) {
                return redirect()->back()->with('error', 'El token de Google es inválido.');
            }

            $googleUser = $response->json();

            // Opcional: Verificar que el 'aud' (Audience) coincide con nuestro Client ID
            $clientId = config('services.google.client_id') ?: env('GOOGLE_CLIENT_ID');
            if ($clientId && $googleUser['aud'] !== $clientId) {
                return redirect()->back()->with('error', 'El token de Google no pertenece a esta aplicación.');
            }

            $user = User::where('email', $googleUser['email'])->first();

            if ($user) {
                if (!$user->google_id) {
                    $user->update([
                        'google_id' => $googleUser['sub'],
                        'avatar' => $user->avatar ?? ($googleUser['picture'] ?? null)
                    ]);
                }
                Auth::login($user);
            } else {
                $newUser = User::create([
                    'name' => $googleUser['name'] ?? 'Usuario Google',
                    'email' => $googleUser['email'],
                    'google_id' => $googleUser['sub'],
                    'password' => bcrypt(Str::random(24)),
                    'avatar' => $googleUser['picture'] ?? null,
                    'email_verified_at' => Carbon::now(),
                    'referral_code' => Str::random(8),
                ]);

                $customerRole = Role::where('name', 'customer')->first();
                if ($customerRole) {
                    $newUser->assignRole($customerRole);
                }

                Auth::login($newUser);
            }

            return redirect()->route('customer.dashboard')->with('success', 'Bienvenido de nuevo a TodoKeys!');

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Google One Tap Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Hubo un error con el inicio de sesión automático.');
        }
    }
}
