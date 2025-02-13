<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifikasiDokumenSewa extends Mailable
{
    use Queueable, SerializesModels;
    public $listSertifikat;
    /**
     * Create a new message instance.
     */
    public function __construct($listSertifikat)
    {
        $this->listSertifikat=$listSertifikat;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Notifikasi Dokumen Sewa',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'email.notif-dokumen-sewa',
            with: [
                'listSertifikat' => $this->listSertifikat,
                // 'user' =>$this->user
                ],
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
