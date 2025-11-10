@extends('layouts.app')

@php
    URL::forceScheme('https');
@endphp

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Assign Roles</h1>

        <div id="alert-box"></div>

        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Verified</th> <!-- new column -->
                                <th>Current Role</th>
                                <th>Change Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (\App\Models\User::all() as $user)
                                <tr id="user-{{ $user->id }}">
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if ($user->email_verified_at)
                                            <span class="badge badge-success">Verified</span>
                                        @else
                                            <span class="badge badge-warning">Not Verified</span>
                                        @endif
                                    </td>
                                    <td class="current-role">
                                        @if ($user->hasRole('admin'))
                                            <span class="badge badge-danger">Admin</span>
                                        @elseif ($user->hasRole('teacher'))
                                            <span class="badge badge-warning">Teacher</span>
                                        @elseif ($user->hasRole('user'))
                                            <span class="badge badge-primary">User</span>
                                        @else
                                            <span class="badge badge-secondary">None</span>
                                        @endif
                                    </td>
                                    <td>
                                        <select class="form-control form-control-sm change-role"
                                            data-id="{{ $user->id }}">
                                            <option value="" disabled {{ $user->roles->isEmpty() ? 'selected' : '' }}>
                                                Select role</option>
                                            <option value="user" {{ $user->hasRole('user') ? 'selected' : '' }}>User
                                            </option>
                                            <option value="admin" {{ $user->hasRole('admin') ? 'selected' : '' }}>Admin
                                            </option>
                                            <option value="teacher" {{ $user->hasRole('teacher') ? 'selected' : '' }}>
                                                Teacher
                                            </option>
                                        </select>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- AJAX Script --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(function() {
            $('.change-role').on('change', function() {
                let userId = $(this).data('id');
                let role = $(this).val();

                $.ajax({
                    url: "{{ secure_url(route('assign.role')) }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        user_id: userId,
                        role: role
                    },
                    success: function(response) {
                        $('#alert-box').html(
                            `<div class="alert alert-success alert-dismissible fade show">
                            ${response.message}
                            <button type="button" class="close" data-dismiss="alert">×</button>
                         </div>`
                        );

                        // ---- BADGE UPDATE FIX ----
                        let badgeHtml = '';
                        if (role === 'admin') {
                            badgeHtml = '<span class="badge badge-danger">Admin</span>';
                        } else if (role === 'teacher') {
                            badgeHtml = '<span class="badge badge-warning">Teacher</span>';
                        } else if (role === 'user') {
                            badgeHtml = '<span class="badge badge-primary">User</span>';
                        } else {
                            badgeHtml = '<span class="badge badge-secondary">None</span>';
                        }

                        $('#user-' + userId + ' .current-role').html(badgeHtml);
                        // --------------------------

                        setTimeout(() => $('#alert-box').empty(), 4000);
                    },
                    error: function() {
                        $('#alert-box').html(
                            `<div class="alert alert-danger">Failed! Check console.</div>`
                        );
                    }
                });
            });
        });
    </script>
    
@endsection
