<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;

class courseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $courses = Course::with(['mainCategory', 'subCategory'])
        $courses = Course::with(['mainCategory'])
            ->latest()
            ->paginate(10);
            
        return view('courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $mainCategories = Category::whereNull('parent_id')->get();
        return view('courses.create', compact('mainCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    
    public function store(Request $request)
    {
        // Validate
        $validated = $request->validate([
            'main_category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:categories,id',
            'course_methodology' => 'required',
            'course_type' => 'required',
            'course_code' => 'required|unique:courses',
            'course_title' => 'required',
            'course_duration' => 'required|numeric',
            'course_thumbnail' => 'required|image',
            'course_desktop_cover_image' => 'required|image',
            'course_mobile_cover_image' => 'nullable|image',
        ]);

        // Handle file uploads
        if($request->hasFile('course_thumbnail')) {
            $validated['thumbnail'] = $request->file('course_thumbnail')
                ->store('courses/thumbnails', 'public');
        }

        // Create course
        $course = Course::create($validated);

        return redirect()->route('courses.index')
            ->with('success', 'Course created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
