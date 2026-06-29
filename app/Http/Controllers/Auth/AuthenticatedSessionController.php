<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $rules = [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ];

        if (env('RECAPTCHA_SITE_KEY') && env('RECAPTCHA_SECRET_KEY')) {
            $rules['g-recaptcha-response'] = ['required', function ($attribute, $value, $fail) {
                $secret = env('RECAPTCHA_SECRET_KEY');
                $response = \Illuminate\Support\Facades\Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => $secret,
                    'response' => $value,
                    'remoteip' => request()->ip()
                ]);

                if (!$response->successful() || !$response->json('success')) {
                    $fail('El reCAPTCHA es inválido o ha expirado. Por favor, inténtalo de nuevo.');
                }
            }];
        }

        $credentials = $request->validate($rules);

        // Remover g-recaptcha-response de credentials si existe
        unset($credentials['g-recaptcha-response']);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => ['Las credenciales proporcionadas no son correctas.'],
            ]);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->intended(route('customer.dashboard'));
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
