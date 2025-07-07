<?php

namespace App\Observers;

use App\Models\Desa;
use App\Models\User;
use App\Mail\NewDesaAdminMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class DesaObserver
{
    /**
     * Handle the Desa "created" event.
     */
    public function created(Desa $desa): void
    {
        // If an admin is already assigned during creation
        if ($desa->admin_id && $desa->team_id) {
            // Add admin to the team if not already a member
            if ($desa->team && $desa->admin) {
                $isMember = $desa->team->users()->where('user_id', $desa->admin_id)->exists();

                if (!$isMember) {
                    // Add the admin to the team
                    $desa->team->users()->attach($desa->admin_id, ['role' => 'admin']);

                    // Set this team as the current team for the admin user
                    $desa->admin->update(['current_team_id' => $desa->team_id]);
                }
            }
        }
    }

    /**
     * Handle the Desa "updated" event.
     */
    public function updated(Desa $desa): void
    {
        // If the admin_id has changed
        if ($desa->isDirty('admin_id') && $desa->admin) {
            // Add admin to the team
            if ($desa->team && $desa->admin) {
                // First check if already a member
                $isMember = $desa->team->users()->where('user_id', $desa->admin_id)->exists();

                if (!$isMember) {
                    // Add the admin to the team
                    $desa->team->users()->attach($desa->admin, ['role' => 'admin']);
                }
            }

            // Send notification email
            try {
                Mail::to($desa->admin->email)->send(new NewDesaAdminMail($desa->admin, $desa));
            } catch (\Exception $e) {
                Log::error('Failed to send new desa admin notification: ' . $e->getMessage());
            }
        }
    }
}
