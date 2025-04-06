<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    protected $apiKey;
    protected $senderId;
    protected $apiUrl;

    public function __construct()
    {
        $this->apiKey = config('services.sendx.api_key');
        $this->senderId = config('services.sendx.sender_id');
        $this->apiUrl = config('services.sendx.api_url');
    }

    public function sendSms($phoneNumber, $message)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl . '/send', [
                'sender_id' => $this->senderId,
                'recipient' => $phoneNumber,
                'message' => $message,
            ]);

            if ($response->successful()) {
                Log::info('SMS sent successfully', [
                    'phone' => $phoneNumber,
                    'message' => $message,
                ]);
                return true;
            }

            Log::error('Failed to send SMS', [
                'phone' => $phoneNumber,
                'message' => $message,
                'error' => $response->json(),
            ]);
            return false;
        } catch (\Exception $e) {
            Log::error('SMS sending error', [
                'phone' => $phoneNumber,
                'message' => $message,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    public function sendAdvanceRequestApproval($phoneNumber, $amount)
    {
        $message = "Your salary advance request for LKR {$amount} has been approved.";
        return $this->sendSms($phoneNumber, $message);
    }

    public function sendAdvanceRequestRejection($phoneNumber, $amount, $reason)
    {
        $message = "Your salary advance request for LKR {$amount} was rejected. Reason: {$reason}";
        return $this->sendSms($phoneNumber, $message);
    }
} 