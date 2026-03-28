<?php

namespace App\Http\Controllers;

use App\Models\Housing;
use App\Models\HousingType;
use Illuminate\Http\Request;

class HousingController extends Controller
{
    public function index()
    {
        $housings = Housing::latest()->get();
        return view('housing.index', compact('housings'));
    }

    public function show($slug)
    {
        $housing = Housing::where('slug', $slug)->with('types')->firstOrFail();
        return view('housing.show', compact('housing'));
    }

    public function showType($housingSlug, $typeSlug)
    {
        $housing = Housing::where('slug', $housingSlug)->firstOrFail();
        $type = HousingType::where('slug', $typeSlug)
                          ->where('housing_id', $housing->id)
                          ->with(['installmentPlans', 'bankPartners'])
                          ->firstOrFail();
        
        return view('housing.type', compact('housing', 'type'));
    }
}
