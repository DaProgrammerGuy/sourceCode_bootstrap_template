@extends('layouts.app')

@section('content')
<div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Conversation with {{ $conversation->user_phone }}</h1>
    <a href="{{ route('admin.conversations.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Back to List
    </a>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<!-- Conversation Info -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Teacher</div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">
                            {{ $conversation->teacher->name ?? 'Not Assigned' }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Status</div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">
                            {{ ucfirst($conversation->status) }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Last Message</div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">
                            {{ $conversation->last_message_at?->diffForHumans() ?? 'N/A' }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Messages</div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">
                            {{ $conversation->messages->count() }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-comments fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Close Button -->
@if($conversation->status !== 'closed')
    <div class="mb-4">
        <form action="{{ route('admin.conversations.close', $conversation) }}" method="POST" 
              onsubmit="return confirm('Are you sure you want to close this conversation?')">
            @csrf
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-times-circle"></i> Close Conversation
            </button>
        </form>
    </div>
@endif

<!-- Messages Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Messages</h6>
    </div>
    <div class="card-body">
        <div class="chat-container" style="max-height: 500px; overflow-y: auto;">
            @forelse($conversation->messages as $message)
                <div class="d-flex mb-3 {{ $message->direction === 'outbound' ? 'justify-content-end' : 'justify-content-start' }}">
                    <div class="message-bubble {{ $message->direction === 'outbound' ? 'bg-primary text-white' : 'bg-light' }}" 
                         style="max-width: 70%; padding: 10px 15px; border-radius: 15px;">
                        <div class="message-header mb-1">
                            <small class="{{ $message->direction === 'outbound' ? 'text-white-50' : 'text-muted' }}">
                                <strong>{{ ucfirst($message->sender_type) }}</strong> • 
                                {{ $message->created_at->format('M d, H:i') }}
                            </small>
                        </div>
                        <div class="message-body">
                            {{ $message->message_body }}
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted">No messages yet</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Reply Form -->
@if($conversation->status === 'active')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Send Reply</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.conversations.reply', $conversation) }}" method="POST">
                @csrf
                <div class="form-group">
                    <textarea name="message" class="form-control" rows="4" 
                              placeholder="Type your message here..." required></textarea>
                    @error('message')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i> Send Reply
                </button>
            </form>
        </div>
    </div>
@else
    <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle"></i> 
        This conversation is {{ $conversation->status }}. You cannot send replies.
    </div>
@endif
</div>

<script>
    // Auto-scroll to bottom of chat
    document.addEventListener('DOMContentLoaded', function() {
        const chatContainer = document.querySelector('.chat-container');
        if (chatContainer) {
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }
    });
</script>
@endsection