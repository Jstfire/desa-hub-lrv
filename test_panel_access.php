<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "\nTesting Panel Access for different users:\n";

// Find users by their roles instead of emails to ensure we get the correct ones
$superadmin = \App\Models\User::role('superadmin')->first();
echo "Superadmin: {$superadmin->name} ({$superadmin->email})\n";

$adminDesa = \App\Models\User::role('admin_desa')->first();
echo "Admin Desa: {$adminDesa->name} ({$adminDesa->email})\n";

$operatorDesa = \App\Models\User::role('operator_desa')->first();
echo "Operator Desa: {$operatorDesa->name} ({$operatorDesa->email})\n";

echo "\nVerifying roles and associated desa for each user:\n";

echo "Superadmin roles: " . implode(', ', $superadmin->getRoleNames()->toArray()) . "\n";
$superadminDesa = \App\Models\Desa::where('admin_id', $superadmin->id)->get();
echo "Superadmin manages " . $superadminDesa->count() . " desas:\n";
foreach ($superadminDesa as $desa) {
    echo " - {$desa->nama} ({$desa->jenis})\n";
}

echo "\nAdmin Desa roles: " . implode(', ', $adminDesa->getRoleNames()->toArray()) . "\n";
$adminDesaDesa = \App\Models\Desa::where('admin_id', $adminDesa->id)->get();
echo "Admin Desa manages " . $adminDesaDesa->count() . " desas:\n";
foreach ($adminDesaDesa as $desa) {
    echo " - {$desa->nama} ({$desa->jenis})\n";
}

echo "\nOperator Desa roles: " . implode(', ', $operatorDesa->getRoleNames()->toArray()) . "\n";
$operatorDesaDesa = \App\Models\Desa::where('operator_id', $operatorDesa->id)->get();
echo "Operator Desa operates " . $operatorDesaDesa->count() . " desas:\n";
foreach ($operatorDesaDesa as $desa) {
    echo " - {$desa->nama} ({$desa->jenis})\n";
}

echo "\nListing teams for each user:\n";

echo "Superadmin teams:\n";
foreach ($superadmin->teams as $team) {
    echo " - {$team->name} (role: {$team->membership->role})\n";
}

echo "\nAdmin Desa teams:\n";
foreach ($adminDesa->teams as $team) {
    echo " - {$team->name} (role: {$team->membership->role})\n";
}

echo "\nOperator Desa teams:\n";
foreach ($operatorDesa->teams as $team) {
    echo " - {$team->name} (role: {$team->membership->role})\n";
}

// Let's check the User model implementation of canAccessPanel
echo "\nVerifying User model canAccessPanel implementation:\n";
echo file_get_contents('app/Models/User.php');
