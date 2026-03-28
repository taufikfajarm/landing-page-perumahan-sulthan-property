<?php

namespace App\Http\Controllers;

use App\Models\WhatsAppClick;
use Illuminate\Http\Request;

class WhatsAppClickController extends Controller
{
    public function track(Request $request)
    {
        try {
            \Log::info('WhatsApp click tracking request', [
                'data' => $request->all()
            ]);

            $validated = $request->validate([
                'marketing_id' => 'required|exists:marketing,id',
            ]);

            $click = WhatsAppClick::create([
                'marketing_id' => $validated['marketing_id'],
                'clicked_at' => now(),
            ]);

            \Log::info('WhatsApp click recorded', [
                'click_id' => $click->id,
                'marketing_id' => $click->marketing_id
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error('WhatsApp click tracking failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
