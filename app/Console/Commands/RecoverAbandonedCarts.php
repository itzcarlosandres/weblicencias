<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\AbandonedCart;
use App\Mail\AbandonedCartMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;

#[Signature('cart:recover')]
#[Description('Sends email to users who abandoned their carts for more than 24 hours')]
class RecoverAbandonedCarts extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Encontrar carritos inactivos por más de 24 horas a los que no se les haya enviado correo
        $cutoffTime = Carbon::now()->subHours(24);
        
        $abandonedCarts = AbandonedCart::where('last_active_at', '<', $cutoffTime)
            ->where('email_sent', false)
            ->with('user')
            ->get();

        $count = 0;
        foreach ($abandonedCarts as $cart) {
            // Asegurarse de que el carrito no esté vacío
            if (!empty($cart->cart_data) && $cart->user) {
                Mail::to($cart->user->email)->queue(new AbandonedCartMail($cart));
                
                $cart->update(['email_sent' => true]);
                $count++;
            }
        }

        $this->info("Se enviaron correos a {$count} carritos abandonados.");
    }
}
