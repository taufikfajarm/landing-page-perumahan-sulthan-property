<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 20 published blog posts
        Blog::factory()->count(20)->published()->create();
        
        // Optionally, create a few unpublished drafts
        // Blog::factory()->count(3)->unpublished()->create();
    }
}
