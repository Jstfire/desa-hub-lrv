<?php

require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Output header
echo "===================================\n";
echo "Team Memberships Check\n";
echo "===================================\n\n";

// Mendapatkan semua tim
$teams = \App\Models\Team::all();

foreach ($teams as $team) {
    echo "Team ID: {$team->id}\n";
    echo "Team Name: {$team->name}\n";
    echo "Team Owner ID: {$team->user_id}\n";

    // Dapatkan informasi owner
    $owner = \App\Models\User::find($team->user_id);
    echo "Team Owner: {$owner->name} ({$owner->email})\n";

    // Dapatkan desa terkait
    $desa = \App\Models\Desa::where('team_id', $team->id)->first();
    if ($desa) {
        echo "Linked to: {$desa->jenis} {$desa->nama} (URI: {$desa->uri})\n";
        echo "Desa Admin ID: {$desa->admin_id}\n";
        echo "Desa Operator ID: " . ($desa->operator_id ? $desa->operator_id : "N/A") . "\n";

        // Info admin desa
        $admin = \App\Models\User::find($desa->admin_id);
        echo "Desa Admin: " . ($admin ? "{$admin->name} ({$admin->email})" : "N/A") . "\n";

        // Info operator desa
        if ($desa->operator_id) {
            $operator = \App\Models\User::find($desa->operator_id);
            echo "Desa Operator: " . ($operator ? "{$operator->name} ({$operator->email})" : "N/A") . "\n";
        }
    }

    // Dapatkan anggota tim
    $members = $team->users;
    echo "Team Members (" . count($members) . "):\n";

    foreach ($members as $member) {
        $role = $member->pivot->role;
        echo "- {$member->name} ({$member->email}) [Role: {$role}]\n";
    }

    echo "\n-----------------------------------\n\n";
}

// Cek duplikasi di tabel team_user
echo "Checking for duplicates in team_user table...\n";
$duplicates = \Illuminate\Support\Facades\DB::table('team_user')
    ->select('team_id', 'user_id', \Illuminate\Support\Facades\DB::raw('COUNT(*) as count'))
    ->groupBy('team_id', 'user_id')
    ->having('count', '>', 1)
    ->get();

if (count($duplicates) > 0) {
    echo "Duplicates found:\n";
    foreach ($duplicates as $duplicate) {
        echo "Team ID: {$duplicate->team_id}, User ID: {$duplicate->user_id}, Count: {$duplicate->count}\n";

        // Get details about the duplicate entries
        $entries = \Illuminate\Support\Facades\DB::table('team_user')
            ->where('team_id', $duplicate->team_id)
            ->where('user_id', $duplicate->user_id)
            ->get();

        foreach ($entries as $i => $entry) {
            echo "  Entry " . ($i + 1) . ": ID: {$entry->id}, Role: {$entry->role}, Created: {$entry->created_at}\n";
        }
    }
} else {
    echo "No duplicates found in team_user table.\n";
}

echo "\n===================================\n";
echo "Check completed.\n";
echo "===================================\n";
