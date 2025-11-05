@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"><b>Course</b> Details</h1>
            <div>
                <a href="{{ route('courses.edit', $course) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('courses.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Main Content -->
            <div class="col-md-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">{{ $course->course_title }}</h6>
                        <div>
                            @if($course->is_active)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-secondary">Inactive</span>
                            @endif
                            @if($course->is_featured)
                                <span class="badge badge-warning">Featured</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Course Code:</strong>
                                <p>{{ $course->course_code }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Level:</strong>
                                <p><span class="badge badge-info">{{ $course->course_level_name }}</span></p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Main Category:</strong>
                                <p>{{ $course->mainCategory->name ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Sub Category:</strong>
                                <p>{{ $course->subCategory->name ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Methodology:</strong>
                                <p>{{ $course->course_methodology_name }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Course Type:</strong>
                                <p>{{ $course->course_type_name }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Duration:</strong>
                                <p>{{ $course->course_duration }} months</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Subscription:</strong>
                                <p>{{ $course->subscription_name }}</p>
                            </div>
                        </div>

                        @if($course->course_fee)
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Course Fee:</strong>
                                <p>${{ number_format($course->course_fee, 2) }}</p>
                            </div>
                            @if($course->discount_price)
                            <div class="col-md-6">
                                <strong>Discount Price:</strong>
                                <p class="text-success">${{ number_format($course->discount_price, 2) }}</p>
                            </div>
                            @endif
                        </div>
                        @endif

                        @if($course->course_description)
                        <div class="mb-3">
                            <strong>Description:</strong>
                            <p>{{ $course->course_description }}</p>
                        </div>
                        @endif

                        @if($course->youtube_link)
                        <div class="mb-3">
                            <strong>YouTube Link:</strong>
                            <p><a href="{{ $course->youtube_link }}" target="_blank">{{ $course->youtube_link }}</a></p>
                        </div>
                        @endif

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <strong>Created:</strong>
                                <p>{{ $course->created_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Images Sidebar -->
            <div class="col-md-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Course Images</h6>
                    </div>
                    <div class="card-body">
                        @if($course->course_thumbnail)
                        <div class="mb-3">
                            <strong>Thumbnail:</strong>
                            <img src="{{ asset('storage/' . $course->course_thumbnail) }}" 
                                 alt="Thumbnail" class="img-fluid rounded mt-2">
                        </div>
                        @endif

                        @if($course->course_desktop_cover_image)
                        <div class="mb-3">
                            <strong>Desktop Cover:</strong>
                            <img src="{{ asset('storage/' . $course->course_desktop_cover_image) }}" 
                                 alt="Desktop Cover" class="img-fluid rounded mt-2">
                        </div>
                        @endif

                        @if($course->course_mobile_cover_image)
                        <div class="mb-3">
                            <strong>Mobile Cover:</strong>
                            <img src="{{ asset('storage/' . $course->course_mobile_cover_image) }}" 
                                 alt="Mobile Cover" class="img-fluid rounded mt-2">
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection