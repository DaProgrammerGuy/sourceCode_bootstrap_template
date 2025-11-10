<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\User;
use App\Models\WhatsappMessage;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;

class WhatsAppController extends Controller
{
    protected $whatsappService;

    public function __construct(WhatsAppService $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }

    public function webhook(Request $request)
    {
        // Get incoming message data
        $from = str_replace('whatsapp:', '', $request->From);
        $body = trim($request->Body);
        $messageSid = $request->MessageSid;

        \Illuminate\Support\Facades\Log::info('WhatsApp Incoming', ['from' => $from, 'body' => $body]);

        // Handle the message
        $this->handleIncomingMessage($from, $body, $messageSid);

        return response('', 200);
    }

    protected function handleIncomingMessage($userPhone, $messageBody, $twilioSid)
    {
        // Check if user wants to reset/go to menu
        if (strtoupper($messageBody) === 'MENU') {
            $this->resetConversation($userPhone);

            // Create new pending conversation
            $conversation = Conversation::create([
                'user_phone' => $userPhone,
                'status' => 'pending',
                'last_message_at' => now(),
            ]);

            // Store the MENU message
            WhatsappMessage::create([
                'conversation_id' => $conversation->id,
                'sender_type' => 'user',
                'direction' => 'inbound',
                'message_body' => $messageBody,
                'twilio_sid' => $twilioSid,
            ]);

            $this->sendTeacherMenu($userPhone);

            return; // IMPORTANT: Stop here
        }

        // Get or create conversation
        $conversation = Conversation::where('user_phone', $userPhone)
            ->whereIn('status', ['pending', 'active'])
            ->first();

        // If no conversation or session expired
        if (! $conversation || $conversation->isSessionExpired()) {
            $this->startNewConversation($userPhone, $messageBody, $twilioSid);

            return;
        }

        // Store incoming message for existing conversation
        WhatsappMessage::create([
            'conversation_id' => $conversation->id,
            'sender_type' => 'user',
            'direction' => 'inbound',
            'message_body' => $messageBody,
            'twilio_sid' => $twilioSid,
        ]);

        // If teacher not selected (pending status)
        if ($conversation->status === 'pending') {
            $this->handleTeacherSelection($conversation, $messageBody);

            return;
        }

        // If teacher already selected (active status)
        if ($conversation->status === 'active') {
            $this->routeToTeacher($conversation, $messageBody);

            return;
        }
    }

    protected function startNewConversation($userPhone, $messageBody, $twilioSid)
    {
        // Create new conversation
        $conversation = Conversation::create([
            'user_phone' => $userPhone,
            'status' => 'pending',
            'last_message_at' => now(),
        ]);

        // Store message
        WhatsappMessage::create([
            'conversation_id' => $conversation->id,
            'sender_type' => 'user',
            'direction' => 'inbound',
            'message_body' => $messageBody,
            'twilio_sid' => $twilioSid,
        ]);

        // Send teacher menu
        $this->sendTeacherMenu($userPhone);
    }

    protected function sendTeacherMenu($userPhone)
    {
        $menuMessage = $this->whatsappService->getTeacherMenuMessage();
        $sid = $this->whatsappService->sendMessage($userPhone, $menuMessage);

        // Store system message
        $conversation = Conversation::where('user_phone', $userPhone)
            ->latest()
            ->first();

        if ($conversation) {
            WhatsappMessage::create([
                'conversation_id' => $conversation->id,
                'sender_type' => 'system',
                'direction' => 'outbound',
                'message_body' => $menuMessage,
                'twilio_sid' => $sid,
            ]);
        }
    }

    protected function handleTeacherSelection($conversation, $messageBody)
    {
        // Validate if number
        if (! is_numeric($messageBody)) {
            $this->whatsappService->sendMessage(
                $conversation->user_phone,
                '❌ Please reply with a valid number.'
            );

            return;
        }

        $selectedNumber = (int) $messageBody;

        // Get users with teacher role
        $teachers = User::role('teacher')->get();

        // Validate range
        if ($selectedNumber < 1 || $selectedNumber > $teachers->count()) {
            $this->whatsappService->sendMessage(
                $conversation->user_phone,
                "❌ Invalid selection. Please choose between 1-{$teachers->count()}"
            );

            return;
        }

        // Assign teacher
        $teacher = $teachers[$selectedNumber - 1];
        $conversation->update([
            'teacher_id' => $teacher->id,
            'status' => 'active',
            'last_message_at' => now(),
        ]);

        // Send confirmation
        $confirmMessage = "✅ You're now connected to {$teacher->name}.\n\nYou can start chatting. Type MENU to change teacher.";
        $sid = $this->whatsappService->sendMessage($conversation->user_phone, $confirmMessage);

        WhatsappMessage::create([
            'conversation_id' => $conversation->id,
            'sender_type' => 'system',
            'direction' => 'outbound',
            'message_body' => $confirmMessage,
            'twilio_sid' => $sid,
        ]);
    }

    protected function routeToTeacher($conversation, $messageBody)
    {
        // Update last message time
        $conversation->update(['last_message_at' => now()]);

        // Here you would notify the teacher
        // For now, just acknowledge
        $response = "📩 Your message has been sent to {$conversation->teacher->name}. They will reply soon.";

        $sid = $this->whatsappService->sendMessage($conversation->user_phone, $response);

        WhatsappMessage::create([
            'conversation_id' => $conversation->id,
            'sender_type' => 'system',
            'direction' => 'outbound',
            'message_body' => $response,
            'twilio_sid' => $sid,
        ]);
    }

    protected function resetConversation($userPhone)
    {
        Conversation::where('user_phone', $userPhone)
            ->whereIn('status', ['pending', 'active'])
            ->update(['status' => 'closed']);
    }
}
