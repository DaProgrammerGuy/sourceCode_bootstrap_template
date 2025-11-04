<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
                // Main Categories
        $thought = Category::create(['name' => 'The Thought']);
        $eloquence = Category::create(['name' => 'The Eloquence']);

        // Sub Categories for The Thought
        Category::create(['name' => 'Philosophy', 'parent_id' => $thought->id]);
        Category::create(['name' => 'Psychology', 'parent_id' => $thought->id]);

        // Sub Categories for The Eloquence
        Category::create(['name' => 'Public Speaking', 'parent_id' => $eloquence->id]);
        Category::create(['name' => 'Writing', 'parent_id' => $eloquence->id]);
    }
}
