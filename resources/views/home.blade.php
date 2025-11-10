@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 text-gray-800">Good Morning!</h1>
        <p>Here’s what’s happening today.</p>

        <div class="row">


            <!-- New Signups -->
            <div class="col-md-4 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    New SignUps
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $signups ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- New Enrollments -->
            <div class="col-md-4 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">New Enrollments</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $enrollments ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-check fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Active Students -->
            <div class="col-md-4 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Active Students</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $activeStudents ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            @role('admin')
                <!-- Add Course -->
                <div class="col-3 mb-4">
                    <a href={{ route('courses.create') }} class="text-decoration-none">
                        <div class="card shadow h-100 py-3 border-left-success">
                            <div class="card-body d-flex align-items-center">
                                <div>
                                    <h4 class="font-weight-bold text-dark mb-1">Add Course</h4>
                                    <small class="text-muted">Create new course</small>
                                </div>

                                <i class="fas fa-book-open fa-2x text-gray-300 ml-auto"></i>
                            </div>
                        </div>
                    </a>
                </div>
            @endrole

            <!-- Add Teacher -->
            <div class="col-3 mb-4">
                <a href="https://cms.sourcecode.academy/teacher-create" class="text-decoration-none">
                    <div class="card shadow h-100 py-3 border-left-success">
                        <div class="card-body d-flex align-items-center">
                            <div>
                                <h4 class="font-weight-bold text-dark mb-1">Add Teacher</h4>
                                <small class="text-muted">Register new instructor</small>
                            </div>
                            <i class="fas fa-chalkboard-teacher fa-2x text-gray-300 ml-auto"></i>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Add Student -->
            <div class="col-3 mb-4">
                <a href="https://cms.sourcecode.academy/student-create" class="text-decoration-none">
                    <div class="card shadow h-100 py-3 border-left-success">
                        <div class="card-body d-flex align-items-center">
                            <div>
                                <h4 class="font-weight-bold text-dark mb-1">Add Student</h4>
                                <small class="text-muted">Enroll new learner</small>
                            </div>
                            <i class="fas fa-user-graduate fa-2x text-gray-300 ml-auto"></i>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Add Enrollment -->
            <div class="col-3 mb-4">
                <a href="https://cms.sourcecode.academy/create-enrollment" class="text-decoration-none">
                    <div class="card shadow h-100 py-3 border-left-success">
                        <div class="card-body d-flex align-items-center">
                            <div>
                                <h4 class="font-weight-bold text-dark mb-1">Add Enrollment</h4>
                                <small class="text-muted">Assign student to course</small>
                            </div>
                            <i class="fas fa-clipboard-check fa-2x text-gray-300 ml-auto"></i>
                        </div>
                    </div>
                </a>

            </div>

            <!-- Quiz List -->
            <div class="col-3 mb-4">
                <a href="https://cms.sourcecode.academy/quizzes" class="text-decoration-none">
                    <div class="card shadow h-100 py-3 border-left-success">
                        <div class="card-body d-flex align-items-center">
                            <div>
                                <h4 class="font-weight-bold text-dark mb-1">Quiz List</h4>
                            </div>
                            <i class="fas fa-book-open fa-2x text-gray-300 ml-auto"></i>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Web Inquiries -->
            <div class="col-3 mb-4">
                <a href="https://cms.sourcecode.academy/leads" class="text-decoration-none">
                    <div class="card shadow h-100 py-3 border-left-success">
                        <div class="card-body d-flex align-items-center">
                            <div>
                                <h4 class="font-weight-bold text-dark mb-1">Web Inquiries</h4>
                            </div>
                            <i class="fas fa-chalkboard-teacher fa-2x text-gray-300 ml-auto"></i>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Complaint List -->
            <div class="col-3 mb-4">
                <a href="https://cms.sourcecode.academy/complaints" class="text-decoration-none">
                    <div class="card shadow h-100 py-3 border-left-success">
                        <div class="card-body d-flex align-items-center">
                            <div>
                                <h4 class="font-weight-bold text-dark mb-1">Complaint List</h4>
                            </div>
                            <i class="fas fa-user-graduate fa-2x text-gray-300 ml-auto"></i>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Manage Payments -->
            <div class="col-3 mb-4">
                <a href="https://cms.sourcecode.academy/payments" class="text-decoration-none">
                    <div class="card shadow h-100 py-3 border-left-success">
                        <div class="card-body d-flex align-items-center">
                            <div>
                                <h4 class="font-weight-bold text-dark mb-1">Manage Payments</h4>
                            </div>
                            <i class="fas fa-clipboard-check fa-2x text-gray-300 ml-auto"></i>
                        </div>
                    </div>
                </a>

            </div>
        </div>

        <script src="https://js.pusher.com/8.2/pusher.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>

        <script>
            window.Pusher = Pusher;

            window.Echo = new Echo({
                broadcaster: 'pusher',
                key: "392f0f626c92ba579db1", // your Pusher key
                cluster: "us2", // your Pusher cluster
                forceTLS: true
            });

            // Listen to role changes
            Echo.channel('public-chat')
                .listen('.role.changed', e => {
                    console.log('Role changed:', e);
                    alert(`${e.user} is now ${e.role}`);
                });
        </script>
    @endsection
