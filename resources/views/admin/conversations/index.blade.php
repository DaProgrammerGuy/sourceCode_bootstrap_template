@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">WhatsApp Conversations</h1>
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

        <!-- DataTales -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All Conversations</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Phone Number</th>
                                <th>Teacher</th>
                                <th>Status</th>
                                <th>Last Message</th>
                                <th>Total Messages</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($conversations as $conversation)
                                <tr>
                                    <td>{{ $conversation->user_phone }}</td>
                                    <td>{{ $conversation->teacher->name ?? 'Not Assigned' }}</td>
                                    <td>
                                        @if ($conversation->status === 'active')
                                            <span class="badge badge-success">Active</span>
                                        @elseif($conversation->status === 'pending')
                                            <span class="badge badge-warning">Pending</span>
                                        @else
                                            <span class="badge badge-secondary">Closed</span>
                                        @endif
                                    </td>
                                    <td>{{ $conversation->last_message_at?->diffForHumans() ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge badge-info">{{ $conversation->messages->count() }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.conversations.show', $conversation) }}"
                                            class="btn btn-primary btn-sm">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No conversations found</td>
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
    @endsection
