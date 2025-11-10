<?php

namespace App\Services;

use Twilio\Rest\Client;

class WhatsAppService
{
    protected $twilio;

    protected $from;

    public function __construct()
    {
        $this->twilio = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );
        $this->from = config('services.twilio.whatsapp_from');
    }

    public function sendMessage($to, $message)
    {
        try {
            $response = $this->twilio->messages->create(
                "whatsapp:{$to}",
                [
                    'from' => $this->from,
                    'body' => $message,
                ]
            );

            return $response->sid;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('WhatsApp Send Error: '.$e->getMessage());

            return null;
        }
    }

    public function getTeacherMenuMessage()
    {
        // Get users with 'teacher' role
        $teachers = \App\Models\User::role('teacher')->get();

        $message = "👋 Welcome! Please select your teacher:\n\n";

        foreach ($teachers as $index => $teacher) {
            $message .= ($index + 1).". {$teacher->name}\n";
        }

        $message .= "\nReply with the number (1-".$teachers->count().')';
        $message .= "\n\nType MENU anytime to change teacher.";

        return $message;
    }
}
