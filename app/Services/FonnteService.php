<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteService
{
    protected $token;

    public function __construct()
    {
        $this->token = env('FONNTE_TOKEN');
    }

    /**
     * Send WhatsApp Message using Fonnte API
     *
     * @param string $target WhatsApp Number
     * @param string $message Message to send
     * @return bool
     */
    public function sendMessage($target, $message)
    {
        if (empty($this->token)) {
            Log::warning('Fonnte token is not set. WhatsApp message not sent.', [
                'target' => $target,
                'message' => $message,
            ]);
            return false;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token,
            ])->post('https://api.fonnte.com/send', [
                'target' => $target,
                'message' => $message,
            ]);

            if ($response->successful() && $response->json('status') == true) {
                return true;
            }

            Log::error('Fonnte API Error: ' . $response->body());
            return false;

        } catch (\Exception $e) {
            Log::error('Fonnte Exception: ' . $e->getMessage());
            return false;
        }
    }
}
