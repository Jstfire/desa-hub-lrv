<?php

namespace App\Observers;

use App\Models\Pengaduan;
use App\Mail\PengaduanSubmittedMail;
use App\Mail\PengaduanStatusUpdatedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class PengaduanObserver
{
    /**
     * Handle the Pengaduan "created" event.
     */
    public function created(Pengaduan $pengaduan): void
    {
        // Send notification to admins about new pengaduan
        try {
            // Get desa admin emails
            $desaAdminEmails = $pengaduan->desa->users()
                ->whereHas('roles', function ($query) {
                    $query->whereIn('name', ['superadmin', 'admin_desa']);
                })
                ->pluck('email')
                ->toArray();

            if (!empty($desaAdminEmails)) {
                Mail::to($desaAdminEmails)->send(new PengaduanSubmittedMail($pengaduan));
            }
        } catch (\Exception $e) {
            Log::error('Failed to send pengaduan notification email: ' . $e->getMessage());
        }
    }

    /**
     * Handle the Pengaduan "updating" event.
     */
    public function updating(Pengaduan $pengaduan): void
    {
        // Store the old status to compare
        $pengaduan->oldStatus = $pengaduan->getOriginal('status');
    }

    /**
     * Handle the Pengaduan "updated" event.
     */
    public function updated(Pengaduan $pengaduan): void
    {
        // If status has changed, notify the user who submitted the pengaduan
        if (isset($pengaduan->oldStatus) && $pengaduan->oldStatus != $pengaduan->status && $pengaduan->email) {
            try {
                Mail::to($pengaduan->email)->send(new PengaduanStatusUpdatedMail($pengaduan, $pengaduan->oldStatus));
            } catch (\Exception $e) {
                Log::error('Failed to send pengaduan status update email: ' . $e->getMessage());
            }
        }
    }
}
