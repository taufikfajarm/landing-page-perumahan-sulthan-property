<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HousingController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\MarketingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\WhatsAppClickController;
use App\Http\Controllers\SitemapController;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Housing
Route::get('/perumahan', [HousingController::class, 'index'])->name('housing.index');
Route::get('/perumahan/{slug}', [HousingController::class, 'show'])->name('housing.show');
Route::get('/perumahan/{housing}/{type}', [HousingController::class, 'showType'])->name('housing.type');

// Blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Marketing
Route::get('/marketing', [MarketingController::class, 'index'])->name('marketing.index');

// About
Route::get('/about', [AboutController::class, 'index'])->name('about');

// Contact
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// WhatsApp Click Tracking
Route::post('/track-whatsapp-click', [WhatsAppClickController::class, 'track'])->name('whatsapp.track');

// Blog Ad Click Tracking
Route::get('/blog-ad/{id}/click', [BlogController::class, 'trackAdClick'])->name('blog-ad.click');

