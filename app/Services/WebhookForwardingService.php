<?php

namespace App\Services;

use App\Models\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class WebhookForwardingService
{
    /**
     * Media types that can have attachments
     */
    protected array $mediaTypes = ['image', 'video', 'audio', 'document', 'sticker'];

    /**
     * Forward incoming message payload to client's webhook URL
     *
     * @param Client $client
     * @param array $payload - The original WhatsApp payload
     * @param array $processedData - Processed message data
     * @return void
     */
    public function forwardIncomingMessage(Client $client, array $payload, array $processedData = []): void
    {
        // Check if webhook is enabled and URL is set
        if (!$client->webhook_enabled || empty($client->webhook_url)) {
            return;
        }

        try {
            // Process media URLs in the data
            $processedData = $this->addPublicMediaUrls($processedData);

            $webhookPayload = [
                'event' => 'incoming_message',
                'timestamp' => now()->toIso8601String(),
                'data' => $processedData,
                'raw_payload' => $payload,
            ];

            $headers = [
                'Content-Type' => 'application/json',
                'X-Webhook-Event' => 'incoming_message',
                'User-Agent' => 'WhatsAppNinja-Webhook/1.0',
            ];

            // Add signature if secret is configured
            if (!empty($client->webhook_secret)) {
                $signature = hash_hmac('sha256', json_encode($webhookPayload), $client->webhook_secret);
                $headers['X-Webhook-Signature'] = 'sha256=' . $signature;
            }

            // Send webhook asynchronously (fire and forget)
            // Using Laravel's HTTP client with a short timeout
            Http::timeout(5)
                ->withHeaders($headers)
                ->post($client->webhook_url, $webhookPayload);

            Log::info('Webhook forwarded successfully', [
                'client_id' => $client->id,
                'webhook_url' => $client->webhook_url,
            ]);

        } catch (\Exception $e) {
            // Log the error but don't interrupt the main flow
            Log::error('Webhook forwarding failed', [
                'client_id' => $client->id,
                'webhook_url' => $client->webhook_url,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Add public URLs for media files
     *
     * @param array $data
     * @return array
     */
    protected function addPublicMediaUrls(array $data): array
    {
        $baseUrl = rtrim(config('app.url'), '/');
        
        // Check message type and add public URL if it's a media type
        $type = $data['type'] ?? null;
        
        if ($type && in_array($type, $this->mediaTypes)) {
            // If there's a local file path stored in the message
            if (isset($data['file_path']) && !empty($data['file_path'])) {
                $data['public_url'] = $baseUrl . '/storage/' . ltrim($data['file_path'], '/');
            }
            
            // Also check within the media type array (e.g., $data['image'], $data['video'])
            if (isset($data[$type]) && is_array($data[$type])) {
                // Add public_url to the media object if file_path exists
                if (isset($data[$type]['file_path']) && !empty($data[$type]['file_path'])) {
                    $data[$type]['public_url'] = $baseUrl . '/storage/' . ltrim($data[$type]['file_path'], '/');
                }
                
                // If there's a local_path field
                if (isset($data[$type]['local_path']) && !empty($data[$type]['local_path'])) {
                    $data[$type]['public_url'] = $baseUrl . '/storage/' . ltrim($data[$type]['local_path'], '/');
                }
            }
        }
        
        // Check for attachment field
        if (isset($data['attachment']) && !empty($data['attachment'])) {
            $data['attachment_url'] = $baseUrl . '/storage/' . ltrim($data['attachment'], '/');
        }
        
        // Check for media field
        if (isset($data['media']) && !empty($data['media'])) {
            $data['media_url'] = $baseUrl . '/storage/' . ltrim($data['media'], '/');
        }

        return $data;
    }

    /**
     * Forward status update to client's webhook URL
     *
     * @param Client $client
     * @param array $statusData
     * @return void
     */
    public function forwardStatusUpdate(Client $client, array $statusData): void
    {
        // Check if webhook is enabled and URL is set
        if (!$client->webhook_enabled || empty($client->webhook_url)) {
            return;
        }

        try {
            $webhookPayload = [
                'event' => 'message_status_update',
                'timestamp' => now()->toIso8601String(),
                'data' => $statusData,
            ];

            $headers = [
                'Content-Type' => 'application/json',
                'X-Webhook-Event' => 'message_status_update',
                'User-Agent' => 'WhatsAppNinja-Webhook/1.0',
            ];

            // Add signature if secret is configured
            if (!empty($client->webhook_secret)) {
                $signature = hash_hmac('sha256', json_encode($webhookPayload), $client->webhook_secret);
                $headers['X-Webhook-Signature'] = 'sha256=' . $signature;
            }

            Http::timeout(5)
                ->withHeaders($headers)
                ->post($client->webhook_url, $webhookPayload);

        } catch (\Exception $e) {
            Log::error('Webhook status update forwarding failed', [
                'client_id' => $client->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
