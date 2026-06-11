<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:recover-carts')->hourly();

// Actualiza la tasa USD/COP desde APIs gratuitas cada 6 horas
Schedule::command('currency:update-rate')->everySixHours();
