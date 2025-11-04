<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            // Category relationships
            $table->foreignId('main_category_id')->constrained('categories')->onDelete('cascade');
            // $table->foreignId('sub_category_id')->constrained('categories')->onDelete('cascade');
            $table->unsignedBigInteger('sub_category_id')->nullable();

            
            // Basic course info
            $table->string('course_code')->unique();
            $table->string('course_title');
            $table->text('course_description')->nullable();
            
            // Course settings
            $table->tinyInteger('course_methodology'); // 1=Classroom, 2=Skill Dev, 3=One on One, 4=Corporate
            $table->tinyInteger('course_type'); // 1=Live, 2=On Demand, 3=Webinar
            $table->tinyInteger('course_level')->default(1); // 1=Beginner, 2=Intermediate, 3=Advanced, 4=Expert, 5=NA
            $table->tinyInteger('course_subscription_method')->nullable(); // 1=Monthly, 2=One time, 3=Quarterly, 4=Annual, 5=Free
            
            // Duration & pricing
            $table->integer('course_duration'); // in months
            $table->decimal('course_fee', 10, 2)->nullable();
            $table->decimal('discount_price', 10, 2)->nullable();
            
            // Images
            $table->string('course_thumbnail')->nullable();
            $table->string('course_desktop_cover_image')->nullable();
            $table->string('course_mobile_cover_image')->nullable();
            
            // Additional fields
            $table->string('youtube_link')->nullable();
            $table->string('language')->default('English');
            $table->text('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            
            // Status
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            
            $table->softDeletes(); // For soft deletes if needed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
