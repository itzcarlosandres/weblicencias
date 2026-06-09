<?php

namespace App\Services;

use App\Models\Setting;

class WompiService
{
    /**
     * Get Wompi public key
     */
    public function getPublicKey(): string
    {
        return Setting::get('wompi_public_key', '');
    }

    /**
     * Get Wompi environment (sandbox or production)
     */
    public function getEnvironment(): string
    {
        return Setting::get('wompi_sandbox_mode', '1') == '1' ? 'test' : 'prod';
    }

    /**
     * Generate Wompi integrity signature for the checkout widget
     */
    public function generateSignature(string $reference, float $amountInCop, string $currency = 'COP'): string
    {
        $integritySecret = Setting::get('wompi_events_secret', ''); // or integrity secret if different
        $amountInCents = $amountInCop * 100;
        
        $stringToHash = $reference . $amountInCents . $currency . $integritySecret;
        return hash('sha256', $stringToHash);
    }
}
