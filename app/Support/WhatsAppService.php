<?php

namespace App\Support;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected string $baseUrl;
    protected int $timeout;

    public function __construct()
    {
        $this->baseUrl = config('whatsapp.service_url', 'http://127.0.0.1:3001');
        $this->timeout = config('whatsapp.timeout', 10);
    }

    /**
     * Cek status koneksi WhatsApp service.
     */
    public function status(): array
    {
        $res = Http::timeout($this->timeout)->get("{$this->baseUrl}/status");
        return $res->json();
    }

    /**
     * Request pairing code untuk nomor telepon.
     */
    public function pair(string $number): array
    {
        $number = preg_replace('/[^0-9]/', '', $number);
        $res = Http::timeout(30)->get("{$this->baseUrl}/pair/{$number}");
        return $res->json();
    }

    /**
     * Kirim pesan WhatsApp.
     *
     * @param  string  $to  Nomor tujuan (08xxx atau 628xxx)
     * @param  string  $text  Isi pesan
     */
    public function send(string $to, string $text): array
    {
        // Pastikan format internasional
        if (str_starts_with($to, '0')) {
            $to = '62' . substr($to, 1);
        }

        $res = Http::timeout($this->timeout)
            ->post("{$this->baseUrl}/send", [
                'to'   => $to,
                'text' => $text,
            ]);

        return $res->json();
    }

    /**
     * Kirim notifikasi bin penuh ke nomor/grup yang ditentukan.
     */
    public function sendBinFullNotification(string $to, string $binName, string $location, int $capacity): array
    {
        $text = "🚨 *BIN PENUH*\n\n"
              . "📍 {$binName} — {$location}\n"
              . "📊 Kapasitas: {$capacity}%\n"
              . "⏰ " . now()->translatedFormat('l, d F Y H:i') . "\n\n"
              . "Segera kosongkan tong sampah.";

        return $this->send($to, $text);
    }

    /**
     * Kirim notifikasi sensor error.
     */
    public function sendSensorErrorNotification(string $to, string $binName, string $location): array
    {
        $text = "⚠️ *SENSOR ERROR*\n\n"
              . "📍 {$binName} — {$location}\n"
              . "🔧 HC-SR04 sensor tidak merespons.\n"
              . "⏰ " . now()->translatedFormat('l, d F Y H:i') . "\n\n"
              . "Periksa sensor segera.";

        return $this->send($to, $text);
    }

    /**
     * Daftar semua grup WhatsApp.
     */
    public function groups(): array
    {
        $res = Http::timeout($this->timeout)->get("{$this->baseUrl}/groups");
        return $res->json();
    }
}
