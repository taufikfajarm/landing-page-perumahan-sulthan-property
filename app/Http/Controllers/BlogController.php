<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogAd;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cache;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $tag = $request->get('tag');
        $query = Blog::published()->latest('published_at');
        
        // Filter by tag if provided
        if ($tag) {
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
        $blog->views += 1;
        
        // Get related posts
        $relatedBlogs = Blog::published()
                   ->where('id', '!=', $blog->id)
                   ->latest('published_at')
                   ->take(3)
                   ->get();
        
        // Get random active ad from cache
        $ads = Cache::remember('active_blog_ads', 300, function () {
            return BlogAd::active()
                        ->with(['housing', 'marketing'])
                        ->get();
        });
        
        $ad = $ads->isNotEmpty() ? $ads->random() : null;
        
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
