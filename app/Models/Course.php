<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    //
    
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'main_category_id',
        'sub_category_id',
        'course_code',
        'course_title',
        'course_description',
        'course_methodology',
        'course_type',
        'course_level',
        'course_subscription_method',
        'course_duration',
        'course_fee',
        'discount_price',
        'course_thumbnail',
        'course_desktop_cover_image',
        'course_mobile_cover_image',
        'youtube_link',
        'language',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_active',
        'is_featured',
    ];

      protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'course_fee' => 'decimal:2',
        'discount_price' => 'decimal:2',
    ];

      /**
     * Get the main category of the course
     */
    public function mainCategory()
    {
        return $this->belongsTo(Category::class, 'main_category_id');
    }

    /**
     * Get the sub category of the course
     */
    public function subCategory()
    {
        return $this->belongsTo(Category::class, 'sub_category_id');
    }

    /**
     * Scope to get active courses
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get featured courses
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

public static $methodologyLabels = [
    1 => 'Classroom',
    2 => 'Skill Development',
    3 => 'One on One',
    4 => 'Corporate',
];

public static $typeLabels = [
    1 => 'Live',
    2 => 'On Demand',
    3 => 'Webinar',
];

public static $levelLabels = [
    1 => 'Beginner',
    2 => 'Intermediate',
    3 => 'Advanced',
    4 => 'Expert',
    5 => 'N/A',
];

/**
     * Get human-readable subscription method
     */
    public function getSubscriptionNameAttribute()
    {
        return match($this->course_subscription_method) {
            1 => 'Monthly',
            2 => 'One Time',
            3 => 'Quarterly',
            4 => 'Annual',
            5 => 'Free',
            default => 'Unknown'
        };
    }

public function getCourseMethodologyNameAttribute()
{
    return self::$methodologyLabels[$this->course_methodology] ?? 'Unknown';
}

public function getCourseTypeNameAttribute()
{
    return self::$typeLabels[$this->course_type] ?? 'Unknown';
}

public function getCourseLevelNameAttribute()
{
    return self::$levelLabels[$this->course_level] ?? 'Unknown';
}




}
