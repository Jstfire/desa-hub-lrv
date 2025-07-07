<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Mail;

// Send a test email
try {
    Mail::raw('Test email from DesaHub', function ($message) {
        $message->to('thepowerofchange1508@gmail.com')
            ->subject('Test Email');
    });
    echo "Test email sent successfully!\n";
} catch (Exception $e) {
    echo "Error sending email: " . $e->getMessage() . "\n";
}
