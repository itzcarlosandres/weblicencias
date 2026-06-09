<?php

$dir = __DIR__ . '/resources/views';

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

$count = 0;
foreach ($iterator as $file) {
    if ($file->isFile() && str_ends_with($file->getFilename(), '.blade.php')) {
        $content = file_get_contents($file->getPathname());
        
        // Match ${{ number_format(EXPRESSION, 2) }}
        // The EXPRESSION shouldn't contain commas to avoid matching multiple args unexpectedly,
        // but it might contain function calls. Let's use a non-greedy match.
        // E.g. ${{ number_format($product->discounted_price, 2) }} -> {{ currency_format($product->discounted_price) }}
        $newContent = preg_replace('/\\$\\{\\{\s*number_format\((.+?),\s*2\)\s*\\}\\}/', '{{ currency_format($1) }}', $content);
        
        // Also handle cases without the $ outside: e.g. number_format($order->total, 2) if it was just ${{ number_format...
        // Wait, some places might have $<span x-text="newTotal">{{ number_format($total, 2) }}</span>
        $newContent = preg_replace('/\\$<span(.*?)>\\{\\{\s*number_format\((.+?),\s*2\)\s*\\}\\}/', '<span$1>{{ currency_format($2) }}', $newContent);

        // Also check for -${{ number_format...
        $newContent = preg_replace('/-\\$\\{\\{\s*number_format\((.+?),\s*2\)\s*\\}\\}/', '-{{ currency_format($1) }}', $newContent);
        
        if ($content !== $newContent) {
            file_put_contents($file->getPathname(), $newContent);
            echo "Updated: " . $file->getPathname() . "\n";
            $count++;
        }
    }
}

echo "Done. Updated $count files.\n";
