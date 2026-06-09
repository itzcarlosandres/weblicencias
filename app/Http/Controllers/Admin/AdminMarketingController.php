<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\MarketingEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdminMarketingController extends Controller
{
    public function create()
    {
        return view('admin.marketing.create');
    }

    public function send(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'button_text' => 'nullable|string|max:50',
            'button_url' => 'nullable|url|max:255',
        ]);

        // En un entorno de producción real esto debería usar Queues/Jobs
        // Para este MVP, obtenemos todos los usuarios y enviamos en bucle
        $users = User::all();
        $count = 0;

        foreach ($users as $user) {
            try {
                Mail::to($user->email)->send(new MarketingEmail(
                    $request->subject,
                    $request->title,
                    $request->content,
                    $request->button_text,
                    $request->button_url
                ));
                $count++;
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Error enviando marketing a ' . $user->email . ': ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.marketing.create')->with('success', "Campaña enviada exitosamente a {$count} usuarios.");
    }
}
