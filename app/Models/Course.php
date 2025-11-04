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

    public function mainCategory()
        {
            return $this->belongsTo(Category::class, 'category_id');
        }

    // public function subCategory()
    //     {
    //         return $this->belongsTo(Category::class, 'sub_category_id');
    //     }

}
