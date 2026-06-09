<?php
$updates = [
    'VPN' => 'fa-duotone fa-shield-halved',
    'Software' => 'fa-duotone fa-floppy-disk',
    'Windows' => 'fa-brands fa-windows',
    'Office' => 'fa-duotone fa-file-word',
    'Antivirus' => 'fa-duotone fa-shield-virus',
    'Gift Cards' => 'fa-duotone fa-gift',
    'Streaming' => 'fa-duotone fa-tv'
];

foreach ($updates as $name => $icon) {
    \App\Models\Category::where('name', $name)->update(['icon' => $icon]);
    echo "Updated $name to $icon\n";
}
