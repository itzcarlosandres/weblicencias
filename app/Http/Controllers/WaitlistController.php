<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Waitlist;

class WaitlistController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'product_id' => 'required|exists:products,id'
        ]);

        Waitlist::firstOrCreate([
            'email' => $request->email,
            'product_id' => $request->product_id
        ]);

        return back()->with('success', '¡Anotado! Te avisaremos por correo en cuanto tengamos más stock disponible.');
    }
}
