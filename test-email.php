<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Mail;
use App\Mail\TemporaryPasswordMail;
use App\Models\User;

echo "\n=== Testing Email Configuration ===\n\n";

// Check mail config
echo "MAIL_HOST: " . config('mail.mailers.smtp.host') . "\n";
echo "MAIL_PORT: " . config('mail.mailers.smtp.port') . "\n";
echo "MAIL_USERNAME: " . config('mail.mailers.smtp.username') . "\n";
echo "MAIL_ENCRYPTION: " . config('mail.mailers.smtp.encryption') . "\n";
echo "MAIL_FROM: " . config('mail.from.address') . "\n\n";

// Find admin user
$user = User::where('email', 'admin@careerfair.com')->first();

if (!$user) {
    echo "❌ Error: Admin user not found!\n";
    exit(1);
}

echo "✓ Found user: {$user->name} ({$user->email})\n\n";

// Try to send test email
echo "Attempting to send test email...\n";

try {
    Mail::to($user->email)->send(new TemporaryPasswordMail($user, 'Test1234'));
    echo "\n✅ SUCCESS! Test email sent to: {$user->email}\n";
    echo "\nCheck your inbox (and spam folder) for the email.\n\n";
} catch (Exception $e) {
    echo "\n❌ ERROR sending email:\n";
    echo $e->getMessage() . "\n\n";
    echo "Please check:\n";
    echo "1. Gmail app password is correct (16 characters, no spaces)\n";
    echo "2. Gmail account has 2-Step Verification enabled\n";
    echo "3. Internet connection is working\n\n";
}
