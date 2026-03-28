<?php

namespace App\Http\Middleware;

use App\Models\PageVisit;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackPageVisit
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only track GET requests
        if ($request->isMethod('GET')) {
            // Exclude admin routes and static assets
            $excludedPaths = [
                'admin/*',
                'livewire/*',
                'filament/*',
                '*.js',
                '*.css',
                '*.jpg',
                '*.jpeg',
                '*.png',
                '*.gif',
                '*.svg',
                '*.ico',
                '*.woff',
                '*.woff2',
                '*.ttf',
            ];

            $shouldTrack = true;
            foreach ($excludedPaths as $pattern) {
                if ($request->is($pattern)) {
                    $shouldTrack = false;
                    break;
                }
            }

            if ($shouldTrack) {
                PageVisit::create([
                    'url' => $request->fullUrl(),
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'visited_at' => now(),
                ]);
            }
        }

        return $next($request);
    }
}
