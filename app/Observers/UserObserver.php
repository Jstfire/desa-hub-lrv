<?php

namespace App\Observers;

use App\Models\User;
use App\Mail\WelcomeUserMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        // Send welcome email to new user
        if ($user->email) {
            try {
                Mail::to($user->email)->send(new WelcomeUserMail($user));
            } catch (\Exception $e) {
                // Log error but don't break the process
                Log::error('Failed to send welcome email: ' . $e->getMessage());
            }
        }
    }
}
