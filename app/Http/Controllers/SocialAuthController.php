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
}
