<?php

namespace App\Traits;

use App\Events\PusherNotification;
use App\Models\Contact;
use App\Models\Notification;
use App\Models\User;

trait SendNotification
{
    public function sendNotification($users = [], $message = null, $message_type = 'success', $url = null, $details = null): bool
    {
        foreach ($users as $user) {
            $notification              = new Notification();
            $notification->user_id     = $user;
            $notification->title       = $message;
            $notification->description = $details;
            $notification->url         = $url;
            $notification->created_by  = auth()->id();
            $notification->save();
        }

        try {
            if (setting('is_pusher_notification_active')) {
                foreach ($users as $user) {
                    event(new PusherNotification($user, $message, $message_type, $url, $details));
                }
            }
        } catch (\Exception $e) {
            logError('Error: ', $e);
        }

        return true;
    }

    public function pushNotification($data)
    {
        $onesignalRestApiKey = setting('onesignal_rest_api_key');
        $onesignalAppId = setting('onesignal_app_id');
        
        // Determine API format based on key type
        $isNewApiKey = str_starts_with($onesignalRestApiKey, 'os_v2_app_');
        
        // Set correct auth header format
        if ($isNewApiKey) {
            $authHeader = 'Key ' . $onesignalRestApiKey;
            $apiUrl = 'https://api.onesignal.com/notifications';
        } else {
            $authHeader = 'Basic ' . $onesignalRestApiKey;
            $apiUrl = 'https://onesignal.com/api/v1/notifications';
        }

        $headers = [
            'Authorization' => $authHeader,
            'accept'        => 'application/json',
            'content-type'  => 'application/json',
        ];

        // Ensure IDs is an array
        $playerIds = $data['ids'];
        if (!is_array($playerIds)) {
            $playerIds = !empty($playerIds) ? [$playerIds] : [];
        }
        $playerIds = array_filter($playerIds);
        $playerIds = array_values($playerIds);
        
        if (empty($playerIds)) {
            \Log::warning('📱 [PUSH] No player IDs to send notification to');
            return ['error' => 'No player IDs'];
        }

        $body = [
            'contents'            => [
                'en' => $data['message'],
            ],
            'headings'            => [
                'en' => $data['heading'],
            ],
            'app_id'              => $onesignalAppId,
            'url'                 => $data['url'],
            'data'                => [
                'contact_id' => $data['contact_id'] ?? null,
            ],
        ];
        
        // Use correct field name based on API version
        if ($isNewApiKey) {
            $body['include_subscription_ids'] = $playerIds;
            $body['target_channel'] = 'push';
        } else {
            $body['include_player_ids'] = $playerIds;
        }

        \Log::info('📱 [PUSH] Sending to OneSignal', [
            'api_url' => $apiUrl,
            'auth_type' => $isNewApiKey ? 'Key (v2)' : 'Basic (legacy)',
            'player_ids_count' => count($playerIds),
            'heading' => $data['heading'],
        ]);

        $result = httpRequest($apiUrl, $body, $headers);
        
        \Log::info('📱 [PUSH] OneSignal response', ['result' => $result]);
        
        return $result;
    }

    public function sendAdminNotifications($data)
    {
        $admin   = User::find(1); 
        $message = $data['message'];

        try {
            $this->sendNotification([$admin->id], $message);
        } catch (\Exception $e) {
            logError('Admin sendNotification error: ', $e);
        }

        try {
            $this->pushNotification([
                'ids'        => $admin->onesignal_player_id,
                'message'    => $message,
                'heading'    => $data['heading'],
                'url'        => $data['url'],
                // ✅ Pass contact_id if available, else null
                'contact_id' => $data['contact_id'] ?? null,
            ]);
        } catch (\Exception $e) {
            logError('Admin pushNotification error: ', $e);
        }
    }
}
