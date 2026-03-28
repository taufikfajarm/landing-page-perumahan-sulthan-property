<?php

namespace App\Http\Controllers;

use App\Models\Marketing;
use Illuminate\Http\Request;

class MarketingController extends Controller
{
    public function index()
    {
        $marketingTeam = Marketing::active()->inRandomOrder()->get();
        return view('marketing.index', compact('marketingTeam'));
    }
}
