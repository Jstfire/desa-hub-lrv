<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Desa;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewDesaAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $desa;
    public $password;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, Desa $desa, ?string $password = null)
    {
        $this->user = $user;
        $this->desa = $desa;
        $this->password = $password; // Only included for new users
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Anda Ditunjuk Sebagai Admin Desa {$this->desa->nama}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.new-desa-admin',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
