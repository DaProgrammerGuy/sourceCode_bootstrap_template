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
       
    // 1️⃣ Validate
    $validated = $request->validate([
        'main_category_id' => 'required|exists:categories,id',
        'sub_category_id' => 'nullable|exists:categories,id',
        'course_code' => 'required|unique:courses,course_code',
        'course_title' => 'required|string|max:255',
        'course_description' => 'nullable|string',
        'course_methodology' => 'required|integer', // 1=Classroom, 2=Skill Dev, etc.
        'course_type' => 'required|integer',        // 1=Live, 2=On Demand, etc.
        'course_level' => 'required|integer|min:1|max:5', // matches 1–5 range in migration
        'course_subscription_method' => 'nullable|integer|min:1|max:5',
        'course_duration' => 'required|numeric',
        'course_fee' => 'nullable|numeric',
        'discount_price' => 'nullable|numeric',
        'course_thumbnail' => 'nullable|image',
        'course_desktop_cover_image' => 'nullable|image',
        'course_mobile_cover_image' => 'nullable|image',
        'youtube_link' => 'nullable|url',
        'language' => 'nullable|string|max:50',
        'meta_title' => 'nullable|string',
        'meta_description' => 'nullable|string',
        'meta_keywords' => 'nullable|string',
        'is_active' => 'sometimes|boolean',
        'is_featured' => 'sometimes|boolean',
    ]);

    // 2️⃣ Handle file uploads
    if ($request->hasFile('course_thumbnail')) {
        $validated['course_thumbnail'] = $request->file('course_thumbnail')
            ->store('courses/thumbnails', 'public');
    }

    if ($request->hasFile('course_desktop_cover_image')) {
        $validated['course_desktop_cover_image'] = $request->file('course_desktop_cover_image')
            ->store('courses/desktop', 'public');
    }

    if ($request->hasFile('course_mobile_cover_image')) {
        $validated['course_mobile_cover_image'] = $request->file('course_mobile_cover_image')
            ->store('courses/mobile', 'public');
    }

    // 3️⃣ Create course
    Course::create($validated);

    // 4️⃣ Redirect
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
