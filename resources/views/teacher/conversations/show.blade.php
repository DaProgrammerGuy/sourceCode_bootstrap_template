@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-comments text-primary"></i> Chat with {{ $conversation->user_phone }}
            </h1>
            <a href="{{ route('teacher.conversations.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back to Conversations
            </a>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Chat Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Messages</h6>
                <span class="badge badge-{{ $conversation->status === 'active' ? 'success' : 'warning' }}">
                    {{ ucfirst($conversation->status) }}
                </span>
            </div>
            <div class="card-body" style="background-color: #f8f9fc;">
                <!-- Messages Container -->
                <div id="chatMessages" class="chat-messages mb-3" style="height: 450px; overflow-y: auto; padding: 15px;">
                    @forelse($conversation->messages as $message)
                        <div
                            class="message-wrapper mb-3 d-flex {{ $message->direction === 'outbound' ? 'justify-content-end' : 'justify-content-start' }}">
                            <div class="message {{ $message->direction === 'outbound' ? 'sent' : 'received' }}"
                                style="max-width: 70%;">
                                <div
                                    class="message-bubble p-3 rounded shadow-sm
                            {{ $message->direction === 'outbound' ? 'bg-primary text-white' : 'bg-white' }}">
                                    <div class="message-meta mb-2">
                                        <small
                                            class="{{ $message->direction === 'outbound' ? 'text-white-50' : 'text-muted' }}">
                                            <i class="fas fa-user-circle"></i>
                                            <strong>{{ ucfirst($message->sender_type) }}</strong>
                                            <span class="mx-1">•</span>
                                            <i class="far fa-clock"></i>
                                            {{ $message->created_at->format('M d, H:i A') }}
                                        </small>
                                    </div>
                                    <div class="message-text">
                                        {{ $message->message_body }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="fas fa-comment-slash fa-3x text-gray-300 mb-3"></i>
                            <p class="text-muted">No messages yet. Start the conversation!</p>
                        </div>
                    @endforelse
                </div>

                <!-- Reply Form -->
                @if ($conversation->status === 'active')
                    <div class="reply-section border-top pt-3">
                        <form action="{{ route('teacher.conversations.reply', $conversation) }}" method="POST"
                            id="replyForm">
                            @csrf
                            <div class="input-group">
                                <textarea name="message" class="form-control" rows="2" placeholder="Type your message here..." required></textarea>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="fas fa-paper-plane"></i> Send
                                    </button>
                                </div>
                            </div>
                            @error('message')
                                <small class="text-danger mt-1 d-block">{{ $message }}</small>
                            @enderror
                        </form>
                    </div>
                @else
                    <div class="alert alert-warning mb-0">
                        <i class="fas fa-exclamation-triangle"></i>
                        This conversation is {{ $conversation->status }}. You cannot send replies at this time.
                    </div>
                @endif
            </div>
        </div>

        <!-- Conversation Info Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Conversation Details</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <p class="mb-1"><strong>Student Phone:</strong></p>
                        <p class="text-muted">{{ $conversation->user_phone }}</p>
                    </div>
                    <div class="col-md-4">
                        <p class="mb-1"><strong>Started:</strong></p>
                        <p class="text-muted">{{ $conversation->created_at->format('M d, Y H:i A') }}</p>
                    </div>
                    <div class="col-md-4">
                        <p class="mb-1"><strong>Last Activity:</strong></p>
                        <p class="text-muted">{{ $conversation->last_message_at?->diffForHumans() ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .chat-messages::-webkit-scrollbar {
            width: 6px;
        }

        .chat-messages::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .chat-messages::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 3px;
        }

        .chat-messages::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .message-bubble {
            word-wrap: break-word;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-scroll to bottom
            const chatMessages = document.getElementById('chatMessages');
            if (chatMessages) {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }

            // Focus on textarea
            const textarea = document.querySelector('textarea[name="message"]');
            if (textarea) {
                textarea.focus();
            }

            // Submit on Ctrl+Enter
            textarea?.addEventListener('keydown', function(e) {
                if (e.ctrlKey && e.key === 'Enter') {
                    document.getElementById('replyForm').submit();
                }
            });
        });
    </script>
@endsection
