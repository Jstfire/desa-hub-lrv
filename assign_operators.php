<?php

require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Output header
echo "===================================\n";
echo "Assigning Operators to Desa\n";
echo "===================================\n\n";

// Get the operator desa user
$operatorDesa = \App\Models\User::where('email', 'operator@mail.id')->first();

if (!$operatorDesa) {
    echo "Error: Operator desa user not found.\n";
    exit(1);
}

// Get all desas
$desas = \App\Models\Desa::all();

foreach ($desas as $desa) {
    echo "Processing {$desa->jenis} {$desa->nama}...\n";

    // Check if desa has operator_id column
    try {
        if (!\Illuminate\Support\Facades\Schema::hasColumn('desa', 'operator_id')) {
            echo "Error: operator_id column does not exist in desa table.\n";
            echo "Please run the migration to add this column first.\n";
            exit(1);
        }

        // Only assign operator to first desa (Desa Bangun)
        if ($desa->nama === 'Bangun') {
            echo "- Assigning operator to {$desa->jenis} {$desa->nama}\n";
            $desa->operator_id = $operatorDesa->id;
            $desa->save();

            // Also add operator to the team
            $team = \App\Models\Team::find($desa->team_id);

            // Check if already a member
            $isMember = $team->users()->where('user_id', $operatorDesa->id)->exists();

            if (!$isMember) {
                $team->users()->attach($operatorDesa->id, ['role' => 'operator']);
                echo "- Added operator to team {$team->name}\n";
            } else {
                echo "- Operator already a member of team {$team->name}\n";
            }
        }

        echo "- Done.\n";
    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

    echo "\n";
}

echo "===================================\n";
echo "Assignment completed.\n";
echo "===================================\n";
