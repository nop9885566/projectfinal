<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LineBotService
{
    protected $token;
    protected $adminUserId;
    protected $apiUrl = 'https://api.line.me/v2/bot/message/push';

    public function __construct()
    {
        $this->token = config('services.line.bot_channel_access_token');
        $this->adminUserId = config('services.line.admin_user_id');
    }

    /**
     * Send a text message to the admin.
     *
     * @param string $message
     * @return bool
     */
    public function sendTextMessage(string $message): bool
    {
        if (!$this->isConfigured()) {
            return false;
        }

        $adminIds = explode(',', $this->adminUserId);
        $success = true;

        foreach ($adminIds as $adminId) {
            $adminId = trim($adminId);
            if (empty($adminId)) continue;

            $response = Http::withToken($this->token)->post($this->apiUrl, [
                'to' => $adminId,
                'messages' => [
                    [
                        'type' => 'text',
                        'text' => $message,
                    ],
                ],
            ]);

            if ($response->failed()) {
                Log::error('LINE Bot API Error (Text) for ' . $adminId . ': ' . $response->body());
                $success = false;
            }
        }

        return $success;
    }

    /**
     * Send a text message along with an image (e.g. payment slip).
     *
     * @param string $message
     * @param string $imageUrl
     * @return bool
     */
    public function sendImageMessage(string $message, string $imageUrl): bool
    {
        if (!$this->isConfigured()) {
            return false;
        }

        $adminIds = explode(',', $this->adminUserId);
        $success = true;

        foreach ($adminIds as $adminId) {
            $adminId = trim($adminId);
            if (empty($adminId)) continue;

            $response = Http::withToken($this->token)->post($this->apiUrl, [
                'to' => $adminId,
                'messages' => [
                    [
                        'type' => 'text',
                        'text' => $message,
                    ],
                    [
                        'type' => 'image',
                        'originalContentUrl' => $imageUrl,
                        'previewImageUrl' => $imageUrl,
                    ],
                ],
            ]);

            if ($response->failed()) {
                Log::error('LINE Bot API Error (Image) for ' . $adminId . ': ' . $response->body());
                $success = false;
            }
        }

        return $success;
    }

    /**
     * Check if LINE Bot is configured.
     *
     * @return bool
     */
    protected function isConfigured(): bool
    {
        if (empty($this->token) || empty($this->adminUserId)) {
            Log::warning('LINE Bot is not configured. Missing token or admin user ID.');
            return false;
        }
        return true;
    }
}
