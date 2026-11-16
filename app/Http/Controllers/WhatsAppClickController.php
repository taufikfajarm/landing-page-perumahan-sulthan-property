<?php

namespace App\Http\Controllers;

use App\Models\WhatsAppClick;
use Illuminate\Http\Request;

class WhatsAppClickController extends Controller
{
    public function track(Request $request)
    {
        $validated = $request->validate([
            'marketing_id' => 'required|exists:marketing,id',
        ]);

        WhatsAppClick::create([
            'marketing_id' => $validated['marketing_id'],
            'clicked_at' => now(),
        ]);

        return response()->json(['success' => true]);
    }
}
