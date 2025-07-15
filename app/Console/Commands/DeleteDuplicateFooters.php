<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DeleteDuplicateFooters extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'footers:delete-duplicates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $duplicates = \App\Models\Footer::select('desa_id', 'section', \DB::raw('COUNT(*) as count'))
            ->groupBy('desa_id', 'section')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($duplicates as $duplicate) {
            $this->info("Found duplicate for desa_id: {$duplicate->desa_id}, section: {$duplicate->section}");
            $footers = \App\Models\Footer::where('desa_id', $duplicate->desa_id)
                ->where('section', $duplicate->section)
                ->orderBy('id', 'asc')
                ->get();

            // Keep the first one, delete the rest
            $footers->shift();

            foreach ($footers as $footer) {
                $this->info("Deleting footer with id: {$footer->id}");
                $footer->delete();
            }
        }

        $this->info('Duplicate footers deleted successfully.');
    }
}
