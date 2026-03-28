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

class HomeController extends Controller
{
    public function index()
    {
        $heroSection = HeroSection::active()->with('images')->first();
        $featuredHousings = Housing::featured()->take(6)->get();
        $testimonials = Testimonial::active()->get();
        $recentBlogs = Blog::published()->latest('published_at')->take(3)->get();
        $surveyLokasi = SurveyLokasi::active()->with('images')->first();
        $prosesAkad = ProsesAkad::active()->with('images')->first();

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
