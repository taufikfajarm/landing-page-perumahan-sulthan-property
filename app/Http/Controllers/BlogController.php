<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogAd;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::published()->latest('published_at');
        
        // Filter by tag if provided
        if ($request->has('tag')) {
            $tag = $request->get('tag');
            $query->where('meta_keywords', 'LIKE', '%' . $tag . '%');
        }
        
        $blogs = $query->paginate(6);
        
        return view('blog.index', compact('blogs'));
    }

    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)
                   ->where('is_published', true)
                   ->firstOrFail();
        
        // Increment view counter
        $blog->incrementViews();
        
        // Get related posts
        $relatedBlogs = Blog::published()
                           ->where('id', '!=', $blog->id)
                           ->latest('published_at')
                           ->take(3)
                           ->get();
        
        // Get random active ad
        $ad = BlogAd::active()
                    ->with(['housing', 'marketing'])
                    ->inRandomOrder()
                    ->first();
        
        // Increment ad views if ad exists
        if ($ad) {
            $ad->incrementViews();
        }
        
        return view('blog.show', compact('blog', 'relatedBlogs', 'ad'));
    }

    public function trackAdClick($id)
    {
        $ad = BlogAd::findOrFail($id);
        
        // Increment click counter
        $ad->incrementClicks();
        
        // Redirect to WhatsApp
        return redirect($ad->whatsapp_url);
    }
}
