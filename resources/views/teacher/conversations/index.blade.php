@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">My Conversations</h1>
            <div>
                <span class="badge badge-primary badge-lg">
                    {{ $conversations->total() }} Total
                </span>
            </div>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Conversations Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Active Conversations</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Student Phone</th>
                                <th>Status</th>
                                <th>Last Message</th>
                                <th>Messages</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($conversations as $conversation)
                                <tr>
                                    <td class="font-weight-bold">
                                        <i class="fas fa-phone text-primary"></i>
                                        {{ $conversation->user_phone }}
                                    </td>
                                    <td>
                                        @if ($conversation->status === 'active')
                                            <span class="badge badge-success">
                                                <i class="fas fa-check-circle"></i> Active
                                            </span>
                                        @else
                                            <span class="badge badge-warning">
                                                <i class="fas fa-clock"></i> Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <i class="far fa-clock"></i>
                                            {{ $conversation->last_message_at?->diffForHumans() ?? 'N/A' }}
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-info badge-pill">
                                            {{ $conversation->messages->count() }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('teacher.conversations.show', $conversation) }}"
                                            class="btn btn-primary btn-sm btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-comments"></i>
                                            </span>
                                            <span class="text">View Chat</span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <div class="py-4">
                                            <i class="fas fa-inbox fa-3x text-gray-300 mb-3"></i>
                                            <p class="text-muted">No conversations assigned yet</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $conversations->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
