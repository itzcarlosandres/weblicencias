<?php

$file = __DIR__ . '/resources/views/pages/products/index.blade.php';
$content = file_get_contents($file);

// Remove dark classes
$content = preg_replace('/\bdark:[^\s"\']+\s*/', '', $content);

// Replace custom text classes
$content = str_replace('text-text-primary', 'text-gray-900', $content);
$content = str_replace('text-text-secondary', 'text-gray-600', $content);
$content = str_replace('text-text-muted', 'text-gray-500', $content);
$content = str_replace('bg-surface-dark', 'bg-white', $content);

file_put_contents($file, $content);
echo "Cleaned " . basename($file) . "\n";
