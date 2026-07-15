<?php

namespace App\Http\Controllers;

use App\Models\Housing;
use App\Models\Testimonial;
use App\Models\Blog;
use App\Models\Contact;
use App\Models\HeroSection;
use App\Models\SurveyLokasi;
use App\Models\ProsesAkad;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        $heroSection = Cache::rememberForever('home_hero_section', function () {
            return HeroSection::active()->with('images')->first();
        });

        $featuredHousings = Cache::rememberForever('home_featured_housings', function () {
            return Housing::featured()->take(6)->get();
        });

        $testimonials = Cache::rememberForever('home_testimonials', function () {
            return Testimonial::active()->get();
        });

        $recentBlogs = Cache::rememberForever('home_recent_blogs', function () {
            return Blog::published()->latest('published_at')->take(3)->get();
        });

        $surveyLokasi = Cache::rememberForever('home_survey_lokasi', function () {
            return SurveyLokasi::active()->with('images')->first();
        });

        $prosesAkad = Cache::rememberForever('home_proses_akad', function () {
            return ProsesAkad::active()->with('images')->first();
        });

        return view('home', compact('heroSection', 'featuredHousings', 'testimonials', 'recentBlogs', 'surveyLokasi', 'prosesAkad'));
    }

    public function storeContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string',
        ]);

        Contact::create($validated);

        return back()->with('success', 'Terima kasih! Pesan Anda telah terkirim.');
    }
}
