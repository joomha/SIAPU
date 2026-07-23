<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\PengajuanSurat;

class StatusPengajuanMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $pengajuan;

    /**
     * Create a new message instance.
     */
    public function __construct(PengajuanSurat $pengajuan)
    {
        $this->pengajuan = $pengajuan;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Status Pengajuan Surat - ' . $this->pengajuan->status,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.status_pengajuan',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];

        if ($this->pengajuan->status === 'Selesai') {
            $pdfContent = $this->pengajuan->generatePdf();
            if ($pdfContent) {
                $filename = 'Surat_' . str_replace(' ', '_', $this->pengajuan->jenisSurat->nama_surat) . '_' . $this->pengajuan->warga->nama . '.pdf';
                $attachments[] = Attachment::fromData(fn () => $pdfContent, $filename)
                    ->withMime('application/pdf');
            }
        }

        return $attachments;
    }
}
