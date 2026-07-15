<?php

namespace App\Http\Controllers;

use App\Models\Marketing;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cache;

class MarketingController extends Controller
{
    public function index()
    {
        $marketingTeam = Cache::rememberForever('marketing_team_all_active', function () {
            return Marketing::active()->get();
        });
        
        // Randomize the order in memory to avoid Database inRandomOrder() scans
        $marketingTeam = $marketingTeam->shuffle();
        
        return view('marketing.index', compact('marketingTeam'));
    }
}
