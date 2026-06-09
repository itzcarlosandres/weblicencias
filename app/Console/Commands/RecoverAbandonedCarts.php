<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AbandonedCart;
use Illuminate\Support\Facades\Mail;
use App\Mail\AbandonedCartMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class RecoverAbandonedCarts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:recover-carts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends email reminders to users with abandoned carts older than 2 hours.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Encontrar carritos que llevan más de 2 horas inactivos y aún no se ha enviado el correo
        $threshold = Carbon::now()->subHours(2);

        $abandonedCarts = AbandonedCart::where('last_active_at', '<=', $threshold)
            ->where('email_sent', false)
            ->with('user')
            ->get();

        $count = 0;

        foreach ($abandonedCarts as $cart) {
            if ($cart->user && $cart->user->email) {
                try {
                    Mail::to($cart->user->email)->send(new AbandonedCartMail($cart));
                    $cart->update(['email_sent' => true]);
                    $count++;
                    $this->info("Mail sent to: {$cart->user->email}");
                } catch (\Exception $e) {
                    Log::error("Failed to send abandoned cart email to {$cart->user->email}: " . $e->getMessage());
                    $this->error("Failed to send to: {$cart->user->email}");
                }
            }
        }

        $this->info("Abandoned cart recovery process finished. Sent: $count emails.");
    }
}
