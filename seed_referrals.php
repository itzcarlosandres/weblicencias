<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

\App\Models\User::whereNull('referral_code')->get()->each(function ($u) {
    $u->update(['referral_code' => \Illuminate\Support\Str::random(10)]);
});
echo "Referral codes generated.";
