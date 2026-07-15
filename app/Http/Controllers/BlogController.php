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
        $page = $request->get('page', 1);
        $cacheKey = "blog_index_tag_" . ($tag ?? 'all') . "_page_" . $page;

        $blogs = Cache::rememberForever($cacheKey, function () use ($tag) {
            $query = Blog::published()->latest('published_at');
            
            // Filter by tag if provided
            if ($tag) {
                $query->where('meta_keywords', 'LIKE', '%' . $tag . '%');
            }
            
            return $query->paginate(6);
        });
        
        return view('blog.index', compact('blogs'));
    }

    public function show($slug)
    {
        $blog = Cache::rememberForever("blog_show_{$slug}", function () use ($slug) {
            return Blog::where('slug', $slug)
                       ->where('is_published', true)
                       ->firstOrFail();
        });
        
        // Increment view counter (this updates DB directly, and our observer will ignore it from clearing cache)
        $blog->incrementViews();
        
        // Get related posts
        $relatedBlogs = Cache::rememberForever("blog_related_to_{$blog->id}", function () use ($blog) {
            return Blog::published()
                       ->where('id', '!=', $blog->id)
                       ->latest('published_at')
                       ->take(3)
                       ->get();
        });
        
        // Get random active ad from cache
        $ads = Cache::rememberForever('active_blog_ads', function () {
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
