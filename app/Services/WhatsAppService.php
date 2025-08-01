<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class WhatsAppService
{
    private $apiUrl;
    private $token;

    public function __construct()
    {
        $this->apiUrl = config('services.whatsapp.api_url', 'https://api.fonnte.com/send');
        $this->token = config('services.whatsapp.token');
    }

    /**
     * Kirim pesan WhatsApp
     *
     * @param string|array $target Nomor telepon atau array nomor dengan format
     * @param string $message Pesan yang akan dikirim
     * @param array $options Opsi tambahan
     * @return array
     */
    public function sendMessage($target, $message, $options = [])
    {
        try {
            $data = [
                'target' => is_array($target) ? implode(',', $target) : $target,
                'message' => $message,
                'countryCode' => $options['countryCode'] ?? '62',
                'delay' => $options['delay'] ?? '2',
                'typing' => $options['typing'] ?? false,
                'schedule' => $options['schedule'] ?? 0,
                'followup' => $options['followup'] ?? 0,
            ];

            // Tambahkan URL jika ada
            if (isset($options['url'])) {
                $data['url'] = $options['url'];
            }

            // Tambahkan filename jika ada
            if (isset($options['filename'])) {
                $data['filename'] = $options['filename'];
            }

            // Tambahkan lokasi jika ada
            if (isset($options['location'])) {
                $data['location'] = $options['location'];
            }

            $response = Http::withHeaders([
                'Authorization' => $this->token
            ])->post($this->apiUrl, $data);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json(),
                    'message' => 'Pesan berhasil dikirim'
                ];
            }

            return [
                'success' => false,
                'error' => $response->body(),
                'message' => 'Gagal mengirim pesan'
            ];
        } catch (Exception $e) {
            Log::error('WhatsApp Service Error: ' . $e->getMessage());

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'message' => 'Terjadi kesalahan saat mengirim pesan'
            ];
        }
    }

    /**
     * Kirim pesan dengan file
     *
     * @param string|array $target Nomor telepon
     * @param string $message Pesan
     * @param string $filePath Path file yang akan dikirim
     * @param array $options Opsi tambahan
     * @return array
     */
    public function sendMessageWithFile($target, $message, $filePath, $options = [])
    {
        try {
            $data = [
                'target' => is_array($target) ? implode(',', $target) : $target,
                'message' => $message,
                'countryCode' => $options['countryCode'] ?? '62',
                'delay' => $options['delay'] ?? '2',
                'typing' => $options['typing'] ?? false,
                'schedule' => $options['schedule'] ?? 0,
                'followup' => $options['followup'] ?? 0,
            ];

            // Tambahkan filename jika ada
            if (isset($options['filename'])) {
                $data['filename'] = $options['filename'];
            }

            $response = Http::withHeaders([
                'Authorization' => $this->token
            ])->attach('file', file_get_contents($filePath), basename($filePath))
                ->post($this->apiUrl, $data);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json(),
                    'message' => 'Pesan dengan file berhasil dikirim'
                ];
            }

            return [
                'success' => false,
                'error' => $response->body(),
                'message' => 'Gagal mengirim pesan dengan file'
            ];
        } catch (Exception $e) {
            Log::error('WhatsApp Service Error: ' . $e->getMessage());

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'message' => 'Terjadi kesalahan saat mengirim pesan dengan file'
            ];
        }
    }

    /**
     * Kirim pesan ke multiple target dengan personalisasi
     *
     * @param array $targets Array dengan format ['phone|name|variable', ...]
     * @param string $message Template pesan dengan placeholder {name}, {var1}, dll
     * @param array $options Opsi tambahan
     * @return array
     */
    public function sendPersonalizedMessage($targets, $message, $options = [])
    {
        $targetString = is_array($targets) ? implode(',', $targets) : $targets;

        return $this->sendMessage($targetString, $message, $options);
    }

    /**
     * Kirim pesan dengan lokasi
     *
     * @param string|array $target Nomor telepon
     * @param string $message Pesan
     * @param float $latitude Latitude
     * @param float $longitude Longitude
     * @param array $options Opsi tambahan
     * @return array
     */
    public function sendLocation($target, $message, $latitude, $longitude, $options = [])
    {
        $options['location'] = $latitude . ', ' . $longitude;

        return $this->sendMessage($target, $message, $options);
    }

    /**
     * Kirim pesan terjadwal
     *
     * @param string|array $target Nomor telepon
     * @param string $message Pesan
     * @param int $scheduleTimestamp Unix timestamp
     * @param array $options Opsi tambahan
     * @return array
     */
    public function sendScheduledMessage($target, $message, $scheduleTimestamp, $options = [])
    {
        $options['schedule'] = $scheduleTimestamp;

        return $this->sendMessage($target, $message, $options);
    }

    /**
     * Format nomor telepon Indonesia
     *
     * @param string $phone Nomor telepon
     * @return string
     */
    public function formatPhoneNumber($phone)
    {
        // Hapus semua karakter non-digit
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Jika dimulai dengan 0, ganti dengan 62
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }

        // Jika belum dimulai dengan 62, tambahkan 62
        if (substr($phone, 0, 2) !== '62') {
            $phone = '62' . $phone;
        }

        return $phone;
    }

    /**
     * Validasi token
     *
     * @return array
     */
    public function validateToken()
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token
            ])->get('https://api.fonnte.com/validate');

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json(),
                    'message' => 'Token valid'
                ];
            }

            return [
                'success' => false,
                'error' => $response->body(),
                'message' => 'Token tidak valid'
            ];
        } catch (Exception $e) {
            Log::error('WhatsApp Token Validation Error: ' . $e->getMessage());

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'message' => 'Gagal validasi token'
            ];
        }
    }
}
