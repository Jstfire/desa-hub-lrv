<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "\nVerifying Desa-Operator relationship:\n";
$desa = \App\Models\Desa::where('nama', 'Bangun')->first();
echo "Desa: {$desa->nama}\n";
echo "Admin ID: {$desa->admin_id}\n";
echo "Operator ID: {$desa->operator_id}\n";

$admin = \App\Models\User::find($desa->admin_id);
echo "Admin Name: {$admin->name}\n";
echo "Admin Email: {$admin->email}\n";

$operator = \App\Models\User::find($desa->operator_id);
echo "Operator Name: {$operator->name}\n";
echo "Operator Email: {$operator->email}\n";

echo "\nVerifying Team-User relationship:\n";
$team = \App\Models\Team::find($desa->team_id);
echo "Team: {$team->name}\n";
echo "Team Members:\n";
foreach ($team->users as $user) {
    echo " - {$user->name} ({$user->email}) - Role: {$user->membership->role}\n";
}

echo "\nVerifying User Roles:\n";
$adminUser = \App\Models\User::where('email', 'admin@mail.id')->first();
echo "Admin Roles: " . implode(', ', $adminUser->getRoleNames()->toArray()) . "\n";

$operatorUser = \App\Models\User::where('email', 'operator@mail.id')->first();
echo "Operator Roles: " . implode(', ', $operatorUser->getRoleNames()->toArray()) . "\n";
