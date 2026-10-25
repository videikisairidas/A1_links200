<?php
namespace App\Services\Notifications;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NotificationsServices
{
    public static function send($event, $data)
    {
        $url = config('services.node_server.url_notification');
        $secret = config('services.node_server.secret');

        $payload = [
            'event' => $event,
            'data' => $data,
            'timestamp' => now()->toIso8601String()
        ];

        $jsonPayload = json_encode($payload);
        $signature = hash_hmac('sha256', $jsonPayload, $secret);

        $response = Http::withHeaders([
            'x-laravel-signature' => $signature,
            'Content-Type' => 'application/json',
        ])
        ->timeout(3)
        ->post($url, $payload);

        if ($response->failed()) {
            Log::error('Node server delivery failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
        }

        return $response->successful();
    }
}