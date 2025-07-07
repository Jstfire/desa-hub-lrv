<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "\n===== Final Verification of Admin/Operator Access =====\n";

// Clear any caches
\Illuminate\Support\Facades\Artisan::call('cache:clear');
\Illuminate\Support\Facades\Artisan::call('config:clear');
\Illuminate\Support\Facades\Artisan::call('route:clear');
\Illuminate\Support\Facades\Artisan::call('view:clear');
echo "All caches cleared.\n";

// Get users
$superadmin = \App\Models\User::role('superadmin')->first();
$adminDesa = \App\Models\User::role('admin_desa')->first();
$operatorDesa = \App\Models\User::role('operator_desa')->first();

echo "\n1. User Roles:\n";
echo "Superadmin ({$superadmin->email}): " . implode(', ', $superadmin->getRoleNames()->toArray()) . "\n";
echo "Admin Desa ({$adminDesa->email}): " . implode(', ', $adminDesa->getRoleNames()->toArray()) . "\n";
echo "Operator Desa ({$operatorDesa->email}): " . implode(', ', $operatorDesa->getRoleNames()->toArray()) . "\n";

echo "\n2. Desa Assignments:\n";
$superadminDesa = \App\Models\Desa::where('admin_id', $superadmin->id)->get();
echo "Superadmin manages " . $superadminDesa->count() . " desa(s)\n";

$adminDesaDesa = \App\Models\Desa::where('admin_id', $adminDesa->id)->get();
echo "Admin Desa manages " . $adminDesaDesa->count() . " desa(s)\n";

$operatorDesaDesa = \App\Models\Desa::where('operator_id', $operatorDesa->id)->get();
echo "Operator Desa operates " . $operatorDesaDesa->count() . " desa(s)\n";

echo "\n3. Team Memberships:\n";
foreach ($superadmin->teams as $team) {
    echo "Superadmin belongs to team: {$team->name} (role: {$team->membership->role})\n";
}

foreach ($adminDesa->teams as $team) {
    echo "Admin Desa belongs to team: {$team->name} (role: {$team->membership->role})\n";
}

foreach ($operatorDesa->teams as $team) {
    echo "Operator Desa belongs to team: {$team->name} (role: {$team->membership->role})\n";
}

echo "\n4. hasRole Test for Dashboard Access:\n";
echo "Superadmin has role ['superadmin', 'admin_desa', 'operator_desa']: " . ($superadmin->hasRole(['superadmin', 'admin_desa', 'operator_desa']) ? 'YES' : 'NO') . "\n";
echo "Admin Desa has role ['superadmin', 'admin_desa', 'operator_desa']: " . ($adminDesa->hasRole(['superadmin', 'admin_desa', 'operator_desa']) ? 'YES' : 'NO') . "\n";
echo "Operator Desa has role ['superadmin', 'admin_desa', 'operator_desa']: " . ($operatorDesa->hasRole(['superadmin', 'admin_desa', 'operator_desa']) ? 'YES' : 'NO') . "\n";

echo "\n5. User Model Config:\n";
$userModel = new \ReflectionClass(\App\Models\User::class);
$canAccessPanel = $userModel->getMethod('canAccessPanel');
$startLine = $canAccessPanel->getStartLine();
$endLine = $canAccessPanel->getEndLine();
$file = file($canAccessPanel->getFileName());
$code = implode('', array_slice($file, $startLine - 1, $endLine - $startLine + 1));
echo "canAccessPanel method implementation:\n$code\n";

echo "\n===== Verification Complete =====\n";
