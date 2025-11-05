@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        {{-- <h1 class="h3 text-gray-800">Create Course</h1> --}}

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"><b>Course</b> Management</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">Courses</a></li>
                    <li class="breadcrumb-item active">New</li>
                </ol>
            </nav>
        </div>

        <!-- Top Row 4 Selects -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">New Course</h6>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data"
                            id="course_form">
                            @csrf
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <label class="form-label">Main Category *</label>
                                    <select name="main_category_id" class="form-control select2 course-required"
                                        data-placeholder="Select Main Category">
                                        <option value=""></option>
                                        @foreach ($mainCategories as $cat)
                                            <option value="{{ $cat->id }}"
                                                {{ old('main_category_id') == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('main_category_id')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Sub Category *</label>
                                    <select name="sub_category_id" class="form-control select2"
                                        data-placeholder="Select Sub Category">
                                        <option value=""></option>
                                        <!-- Filled via JS -->
                                    </select>
                                    @error('sub_category_id')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Course Methodology *</label>
                                    <select name="course_methodology" class="form-control select2"
                                        data-placeholder="Select">
                                        <option value=""></option>
                                        <option value="1" {{ old('course_methodology') == 1 ? 'selected' : '' }}>
                                            Classroom</option>
                                        <option value="2" {{ old('course_methodology') == 2 ? 'selected' : '' }}>Skill
                                            Development</option>
                                        <option value="3" {{ old('course_methodology') == 3 ? 'selected' : '' }}>One
                                            on One</option>
                                        <option value="4" {{ old('course_methodology') == 4 ? 'selected' : '' }}>
                                            Corporate</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Course Type *</label>
                                    <select name="course_type" class="form-control select2" data-placeholder="Select">
                                        <option value=""></option>
                                        <option value="1" {{ old('course_type') == 1 ? 'selected' : '' }}>Live
                                            sessions</option>
                                        <option value="2" {{ old('course_type') == 2 ? 'selected' : '' }}>On Demand
                                        </option>
                                        <option value="3" {{ old('course_type') == 3 ? 'selected' : '' }}>Webinar
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <!-- Left Panel Course Details -->
                            <div class="row">
                                <div class="col-md-9">
                                    <h6 class="font-weight-bold text-primary mb-3">Course Detail</h6>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Course Code *</label>
                                            <input type="text" name="course_code" class="form-control course-required"
                                                value="{{ old('course_code') }}">
                                            @error('course_code')
                                                <span class="text-danger small">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Course Level *</label>
                                            <select name="course_level" class="form-control select2 course-required">
                                                <option value="0">Select</option>
                                                <option value="1" {{ old('course_level') == 1 ? 'selected' : '' }}>
                                                    Beginner</option>
                                                <option value="2" {{ old('course_level') == 2 ? 'selected' : '' }}>
                                                    Intermediate</option>
                                                <option value="3" {{ old('course_level') == 3 ? 'selected' : '' }}>
                                                    Advanced</option>
                                                <option value="4" {{ old('course_level') == 4 ? 'selected' : '' }}>
                                                    Expert</option>
                                                <option value="5" {{ old('course_level') == 5 ? 'selected' : '' }}>NA
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Course Title *</label>
                                        <input type="text" name="course_title" class="form-control course-required"
                                            value="{{ old('course_title') }}">
                                        @error('course_title')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Subscription</label>
                                            <select name="course_subscription_method" class="form-control select2">
                                                <option value="">Select</option>
                                                <option value="1"
                                                    {{ old('course_subscription_method') == 1 ? 'selected' : '' }}>Monthly
                                                </option>
                                                <option value="2"
                                                    {{ old('course_subscription_method') == 2 ? 'selected' : '' }}>One time
                                                </option>
                                                <option value="3"
                                                    {{ old('course_subscription_method') == 3 ? 'selected' : '' }}>
                                                    Quarterly</option>
                                                <option value="4"
                                                    {{ old('course_subscription_method') == 4 ? 'selected' : '' }}>Annual
                                                </option>
                                                <option value="5"
                                                    {{ old('course_subscription_method') == 5 ? 'selected' : '' }}>Free
                                                </option>
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Duration (Months) *</label>
                                            <input type="text" name="course_duration"
                                                class="form-control course-required numeric"
                                                value="{{ old('course_duration') }}">
                                        </div>
                                    </div>

                                    <!-- Add more fields: fees, languages, SEO, etc. -->
                                </div>

                                <!-- Right Panel Images -->
                                <div class="col-md-3">
                                        <h6 class="font-weight-bold text-primary mb-3">Course Images</h6>

                                        <div class="mb-3">
                                            <label class="form-label">Thumbnail (650x450) *</label>
                                            <input type="file" name="course_thumbnail"
                                                class="form-control dropify course-required" accept="image/*">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Desktop Cover (650x450) *</label>
                                            <input type="file" name="course_desktop_cover_image"
                                                class="form-control dropify course-required" accept="image/*">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Mobile Cover (480x791)</label>
                                            <input type="file" name="course_mobile_cover_image"
                                                class="form-control dropify" accept="image/*">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">YouTube Link</label>
                                            <input type="text" name="youtube_link" class="form-control"
                                                value="{{ old('youtube_link') }}">
                                        </div>
                                    </div>
                                </div>

                            <!-- Submit Button -->
                            <div class="row mt-4">
                                <div class="col-12 text-right">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <a href="{{ route('courses.index') }}" class="btn btn-secondary ml-2">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('form-plugins')
    <!-- This triggers the plugin init -->
@endsection
