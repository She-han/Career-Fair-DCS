<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Admin Users in Database ===\n\n";

$admins = \App\Models\User::where('role', 'admin')->get(['id', 'name', 'email']);

foreach ($admins as $admin) {
    echo "✓ {$admin->name}\n";
    echo "  Email: {$admin->email}\n";
    echo "  ID: {$admin->id}\n\n";
}

echo "Total: {$admins->count()} admin user(s)\n";
