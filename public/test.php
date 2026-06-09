<?php
require 'vendor/autoload.php';
require_once 'bootstrap/app.php';
$app = app();
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
\App\Models\Setting::set('meta_title', 'Simulated Title', 'seo');
print_r(\Illuminate\Support\Facades\DB::table('settings')->where('key', 'meta_title')->get()->toArray());
