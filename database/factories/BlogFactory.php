<?php

namespace Database\Factories;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(rand(4, 8));
        $slug = Str::slug($title);
        
        // Generate realistic property/real estate related content
        $topics = [
            'Tips Membeli Rumah',
            'Investasi Properti',
            'Desain Interior',
            'Tren Properti',
            'Panduan KPR',
            'Renovasi Rumah',
            'Hunian Modern',
            'Properti Syariah',
            'Lokasi Strategis',
            'Properti Impian'
        ];
        
        $propertyTitle = fake()->randomElement($topics) . ' ' . fake()->words(rand(2, 4), true);
        $propertySlug = Str::slug($propertyTitle);
        
        // Generate paragraphs for content
        $paragraphs = fake()->paragraphs(rand(8, 15));
        $content = '<p>' . implode('</p><p>', $paragraphs) . '</p>';
        
        // Add some headings and lists to make it more realistic
        $content .= '<h2>Keuntungan dan Manfaat</h2>';
        $content .= '<ul>';
        for ($i = 0; $i < rand(3, 5); $i++) {
            $content .= '<li>' . fake()->sentence() . '</li>';
        }
        $content .= '</ul>';
        
        $content .= '<p>' . fake()->paragraph() . '</p>';
        
        $content .= '<h2>Tips dan Saran</h2>';
        $content .= '<ol>';
        for ($i = 0; $i < rand(3, 5); $i++) {
            $content .= '<li>' . fake()->sentence() . '</li>';
        }
        $content .= '</ol>';
        
        $content .= '<p>' . fake()->paragraph() . '</p>';
        
        $excerpt = fake()->paragraph(3);
        
        // Keywords related to property
        $keywords = [
            'properti', 'rumah', 'hunian', 'investasi', 'KPR', 
            'desain', 'interior', 'modern', 'strategis', 'syariah',
            'renovasi', 'tips', 'panduan', 'tren', 'lokasi'
        ];
        
        $selectedKeywords = fake()->randomElements($keywords, rand(3, 6));
        
        return [
            'title' => $propertyTitle,
            'slug' => $propertySlug,
            'excerpt' => $excerpt,
            'content' => $content,
            'featured_image' => null, // You can add image path if needed
            'meta_title' => $propertyTitle,
            'meta_description' => Str::limit($excerpt, 160),
            'meta_keywords' => implode(', ', $selectedKeywords),
            'views' => fake()->numberBetween(0, 1000),
            'is_published' => true,
            'published_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ];
    }
    
    /**
     * Indicate that the blog is unpublished.
     */
    public function unpublished(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => false,
            'published_at' => null,
        ]);
    }
    
    /**
     * Indicate that the blog is published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => true,
            'published_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ]);
    }
}
