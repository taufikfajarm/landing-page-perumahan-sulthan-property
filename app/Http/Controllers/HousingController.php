<?php

namespace App\Http\Controllers;

use App\Models\Housing;
use App\Models\HousingType;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cache;

class HousingController extends Controller
{
    public function index()
    {
        $housings = Cache::rememberForever('housing_index', function () {
            return Housing::latest()->get();
        });
        
        return view('housing.index', compact('housings'));
    }

    public function show($slug)
    {
        $housing = Cache::remember("housing_show_{$slug}", 3600, function () use ($slug) {
            return Housing::where('slug', $slug)
                ->with(['types.installmentPlans', 'types.bankPartners', 'facilities', 'accessPoints'])
                ->firstOrFail();
        });

        $marketings = Cache::remember('active_marketings_sidebar', 3600, function () {
            return \App\Models\Marketing::active()->ordered()->take(3)->get();
        });
        
        return view('housing.show', compact('housing', 'marketings'));
    }

    public function showType($housingSlug, $typeSlug)
    {
        $housing = Cache::rememberForever("housing_slug_{$housingSlug}", function () use ($housingSlug) {
            return Housing::where('slug', $housingSlug)->firstOrFail();
        });
        
        $type = Cache::rememberForever("housing_type_{$housingSlug}_{$typeSlug}", function () use ($typeSlug, $housing) {
            return HousingType::where('slug', $typeSlug)
                              ->where('housing_id', $housing->id)
                              ->with(['installmentPlans', 'bankPartners'])
                              ->firstOrFail();
        });
        
        return view('housing.type', compact('housing', 'type'));
    }
}
