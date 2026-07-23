<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendWhatsAppJob implements ShouldQueue
{
    use Queueable;

    protected $telepon;
    protected $pesan;

    /**
     * Create a new job instance.
     */
    public function __construct($telepon, $pesan)
    {
        $this->telepon = $telepon;
        $this->pesan = $pesan;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $waService = new \App\Services\FonnteService();
        $waService->sendMessage($this->telepon, $this->pesan);
    }
}
