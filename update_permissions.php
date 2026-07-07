<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Spatie\Permission\Models\Permission;

$updates = [
    'subsidy' => 'subsidy-info-read',
    'dashboard' => 'dashboard-read'
];

foreach ($updates as $old => $new) {
    $p = Permission::where('name', $old)->first();
    if ($p) {
        $p->name = $new;
        $p->save();
        echo "Updated $old to $new\n";
    }
}
echo "Done.\n";
