@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"><b>Edit</b> Course</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">Courses</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
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

        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Edit Course: {{ $course->course_title }}</h6>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('courses.update', $course) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <!-- Top Row 4 Selects -->
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <label class="form-label">Main Category *</label>
                                    <select name="main_category_id" id="main_category_id" 
                                            class="form-control select2 @error('main_category_id') is-invalid @enderror"
                                            data-placeholder="Select Main Category" required>
                                        <option value=""></option>
                                        @foreach ($mainCategories as $cat)
                                            <option value="{{ $cat->id }}"
                                                {{ (old('main_category_id', $course->main_category_id) == $cat->id) ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('main_category_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Sub Category *</label>
                                    <select name="sub_category_id" id="sub_category_id" 
                                            class="form-control select2 @error('sub_category_id') is-invalid @enderror"
                                            data-placeholder="Select Sub Category" required>
                                        <option value=""></option>
                                        @foreach ($subCategories as $subCat)
                                            <option value="{{ $subCat->id }}"
                                                {{ (old('sub_category_id', $course->sub_category_id) == $subCat->id) ? 'selected' : '' }}>
                                                {{ $subCat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('sub_category_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Course Methodology *</label>
                                    <select name="course_methodology" 
                                            class="form-control select2 @error('course_methodology') is-invalid @enderror"
                                            data-placeholder="Select" required>
                                        <option value=""></option>
                                        <option value="1" {{ old('course_methodology', $course->course_methodology) == 1 ? 'selected' : '' }}>Classroom</option>
                                        <option value="2" {{ old('course_methodology', $course->course_methodology) == 2 ? 'selected' : '' }}>Skill Development</option>
                                        <option value="3" {{ old('course_methodology', $course->course_methodology) == 3 ? 'selected' : '' }}>One on One</option>
                                        <option value="4" {{ old('course_methodology', $course->course_methodology) == 4 ? 'selected' : '' }}>Corporate</option>
                                    </select>
                                    @error('course_methodology')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Course Type *</label>
                                    <select name="course_type" 
                                            class="form-control select2 @error('course_type') is-invalid @enderror"
                                            data-placeholder="Select" required>
                                        <option value=""></option>
                                        <option value="1" {{ old('course_type', $course->course_type) == 1 ? 'selected' : '' }}>Live Sessions</option>
                                        <option value="2" {{ old('course_type', $course->course_type) == 2 ? 'selected' : '' }}>On Demand</option>
                                        <option value="3" {{ old('course_type', $course->course_type) == 3 ? 'selected' : '' }}>Webinar</option>
                                    </select>
                                    @error('course_type')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <!-- Left Panel Course Details -->
                                <div class="col-md-9">
                                    <h6 class="font-weight-bold text-primary mb-3">Course Detail</h6>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Course Code *</label>
                                            <input type="text" name="course_code" 
                                                   class="form-control @error('course_code') is-invalid @enderror"
                                                   value="{{ old('course_code', $course->course_code) }}" required>
                                            @error('course_code')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Course Level *</label>
                                            <select name="course_level" 
                                                    class="form-control select2 @error('course_level') is-invalid @enderror" required>
                                                <option value="">Select</option>
                                                <option value="1" {{ old('course_level', $course->course_level) == 1 ? 'selected' : '' }}>Beginner</option>
                                                <option value="2" {{ old('course_level', $course->course_level) == 2 ? 'selected' : '' }}>Intermediate</option>
                                                <option value="3" {{ old('course_level', $course->course_level) == 3 ? 'selected' : '' }}>Advanced</option>
                                                <option value="4" {{ old('course_level', $course->course_level) == 4 ? 'selected' : '' }}>Expert</option>
                                                <option value="5" {{ old('course_level', $course->course_level) == 5 ? 'selected' : '' }}>NA</option>
                                            </select>
                                            @error('course_level')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Course Title *</label>
                                        <input type="text" name="course_title" 
                                               class="form-control @error('course_title') is-invalid @enderror"
                                               value="{{ old('course_title', $course->course_title) }}" required>
                                        @error('course_title')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Subscription</label>
                                            <select name="course_subscription_method" 
                                                    class="form-control select2 @error('course_subscription_method') is-invalid @enderror">
                                                <option value="">Select</option>
                                                <option value="1" {{ old('course_subscription_method', $course->course_subscription_method) == 1 ? 'selected' : '' }}>Monthly</option>
                                                <option value="2" {{ old('course_subscription_method', $course->course_subscription_method) == 2 ? 'selected' : '' }}>One time</option>
                                                <option value="3" {{ old('course_subscription_method', $course->course_subscription_method) == 3 ? 'selected' : '' }}>Quarterly</option>
                                                <option value="4" {{ old('course_subscription_method', $course->course_subscription_method) == 4 ? 'selected' : '' }}>Annual</option>
                                                <option value="5" {{ old('course_subscription_method', $course->course_subscription_method) == 5 ? 'selected' : '' }}>Free</option>
                                            </select>
                                            @error('course_subscription_method')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Duration (Months) *</label>
                                            <input type="number" name="course_duration" 
                                                   class="form-control @error('course_duration') is-invalid @enderror"
                                                   value="{{ old('course_duration', $course->course_duration) }}" min="1" required>
                                            @error('course_duration')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Course Fee</label>
                                            <input type="number" name="course_fee" step="0.01"
                                                   class="form-control @error('course_fee') is-invalid @enderror"
                                                   value="{{ old('course_fee', $course->course_fee) }}">
                                            @error('course_fee')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Discount Price</label>
                                            <input type="number" name="discount_price" step="0.01"
                                                   class="form-control @error('discount_price') is-invalid @enderror"
                                                   value="{{ old('discount_price', $course->discount_price) }}">
                                            @error('discount_price')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea name="course_description" rows="3" 
                                                  class="form-control @error('course_description') is-invalid @enderror">{{ old('course_description', $course->course_description) }}</textarea>
                                        @error('course_description')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="is_active" value="1" 
                                                       class="custom-control-input" id="is_active" 
                                                       {{ old('is_active', $course->is_active) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="is_active">Active</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="is_featured" value="1" 
                                                       class="custom-control-input" id="is_featured" 
                                                       {{ old('is_featured', $course->is_featured) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="is_featured">Featured</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Panel Images -->
                                <div class="col-md-3">
                                    <h6 class="font-weight-bold text-primary mb-3">Course Images</h6>

                                    <div class="mb-3">
                                        <label class="form-label">Thumbnail (650x450)</label>
                                        <input type="file" name="course_thumbnail"
                                               class="form-control dropify @error('course_thumbnail') is-invalid @enderror" 
                                               accept="image/*"
                                               data-default-file="{{ $course->course_thumbnail ? asset('storage/' . $course->course_thumbnail) : '' }}">
                                        @error('course_thumbnail')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                        <small class="text-muted">Leave empty to keep current image</small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Desktop Cover (650x450)</label>
                                        <input type="file" name="course_desktop_cover_image"
                                               class="form-control dropify @error('course_desktop_cover_image') is-invalid @enderror" 
                                               accept="image/*"
                                               data-default-file="{{ $course->course_desktop_cover_image ? asset('storage/' . $course->course_desktop_cover_image) : '' }}">
                                        @error('course_desktop_cover_image')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                        <small class="text-muted">Leave empty to keep current image</small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Mobile Cover (480x791)</label>
                                        <input type="file" name="course_mobile_cover_image"
                                               class="form-control dropify @error('course_mobile_cover_image') is-invalid @enderror" 
                                               accept="image/*"
                                               data-default-file="{{ $course->course_mobile_cover_image ? asset('storage/' . $course->course_mobile_cover_image) : '' }}">
                                        @error('course_mobile_cover_image')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                        <small class="text-muted">Leave empty to keep current image</small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">YouTube Link</label>
                                        <input type="url" name="youtube_link" 
                                               class="form-control @error('youtube_link') is-invalid @enderror"
                                               value="{{ old('youtube_link', $course->youtube_link) }}">
                                        @error('youtube_link')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="row mt-4">
                                <div class="col-12 text-right">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update Course
                                    </button>
                                    <a href="{{ route('courses.index') }}" class="btn btn-secondary ml-2">
                                        <i class="fas fa-times"></i> Cancel
                                    </a>
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
    <script>
        // On page load, if main category is selected, keep the subcategory selected
        $(document).ready(function() {
            var mainCategoryId = $('#main_category_id').val();
            var selectedSubCategoryId = {{ $course->sub_category_id }};
            
            if (mainCategoryId && selectedSubCategoryId) {
                // The subcategories are already loaded from the controller
                // Just make sure Select2 is initialized
                $('#sub_category_id').trigger('change.select2');
            }
        });
    </script>
@endsection