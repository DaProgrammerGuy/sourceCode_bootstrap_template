@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        {{-- <h1 class="h3 text-gray-800">Create Course</h1> --}}

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"><b>Course</b> Management</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">Courses</a></li>
                    <li class="breadcrumb-item active">New</li>
                </ol>
            </nav>
        </div>

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
                                    <select name="main_category_id" class="form-control select2 course-required">
                                        <option value="0">Select Main Category</option>
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
                                    <select name="sub_category_id" class="form-control select2 course-required">
                                        <option value="">Select Sub Category</option>
                                        <!-- Filled via JS -->
                                    </select>
                                    @error('sub_category_id')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Course Methodology *</label>
                                    <select name="course_methodology" class="form-control select2">
                                        <option value="0">Select</option>
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
                                    <select name="course_type" class="form-control select2">
                                        <option value="0">Select</option>
                                        <option value="1" {{ old('course_type') == 1 ? 'selected' : '' }}>Live
                                            sessions</option>
                                        <option value="2" {{ old('course_type') == 2 ? 'selected' : '' }}>On Demand
                                        </option>
                                        <option value="3" {{ old('course_type') == 3 ? 'selected' : '' }}>Webinar
                                        </option>
                                    </select>
                                </div>
                            </div>
                        @endsection
