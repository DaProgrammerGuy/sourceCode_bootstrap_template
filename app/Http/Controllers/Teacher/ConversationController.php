<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\WhatsappMessage;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    protected $whatsappService;

    public function __construct(WhatsAppService $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }

    // List teacher's conversations
    public function index()
    {
        $conversations = Conversation::with('messages')
            ->where('teacher_id', auth()->id())
            ->whereIn('status', ['active', 'pending'])
            ->latest('last_message_at')
            ->paginate(20);

        return view('teacher.conversations.index', compact('conversations'));
    }

    // View single conversation
    public function show(Conversation $conversation)
    {
        // Check if this teacher owns the conversation
        if ($conversation->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $conversation->load('messages');
        
        return view('teacher.conversations.show', compact('conversation'));
    }

    // Send reply
    public function reply(Request $request, Conversation $conversation)
    {
        // Check ownership
        if ($conversation->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        // Send WhatsApp message
        $sid = $this->whatsappService->sendMessage(
            $conversation->user_phone,
            $request->message
        );

        // Store message
        WhatsappMessage::create([
            'conversation_id' => $conversation->id,
            'sender_type' => 'teacher',
            'direction' => 'outbound',
            'message_body' => $request->message,
            'twilio_sid' => $sid
        ]);

        // Update conversation timestamp
        $conversation->update(['last_message_at' => now()]);

        return back()->with('success', 'Reply sent!');
    }
}