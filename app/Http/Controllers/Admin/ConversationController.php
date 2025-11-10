<?php

namespace App\Http\Controllers\Admin;

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

    // List all conversations
    public function index()
    {
        $conversations = Conversation::with(['teacher', 'messages'])
            ->latest('last_message_at')
            ->paginate(20);

        return view('admin.conversations.index', compact('conversations'));
    }

    // View single conversation
    public function show(Conversation $conversation)
    {
        $conversation->load(['teacher', 'messages']);
        
        return view('admin.conversations.show', compact('conversation'));
    }

    // Send reply from teacher
    public function reply(Request $request, Conversation $conversation)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        // Check if user is the assigned teacher or admin
        $user = auth()->user();
        
        if (!$user->hasRole('admin') && $conversation->teacher_id !== $user->id) {
            return back()->with('error', 'You cannot reply to this conversation.');
        }

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

        return back()->with('success', 'Reply sent successfully!');
    }

    // Close conversation
    public function close(Conversation $conversation)
    {
        $conversation->update(['status' => 'closed']);

        return back()->with('success', 'Conversation closed.');
    }
}