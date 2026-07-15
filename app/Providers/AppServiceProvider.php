<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set Carbon locale to Indonesian
        \Carbon\Carbon::setLocale('id');

        // Automatic Cache Invalidation System for content updates
        $models = [
            \App\Models\HeroSection::class,
            \App\Models\HeroImage::class,
            \App\Models\Housing::class,
            \App\Models\HousingType::class,
            \App\Models\HousingFacility::class,
            \App\Models\HousingAccessPoint::class,
            \App\Models\InstallmentPlan::class,
            \App\Models\BankPartner::class,
            \App\Models\Testimonial::class,
            \App\Models\Blog::class,
            \App\Models\BlogAd::class,
            \App\Models\SurveyLokasi::class,
            \App\Models\SurveyLokasiImage::class,
            \App\Models\ProsesAkad::class,
            \App\Models\ProsesAkadImage::class,
            \App\Models\AboutSetting::class,
            \App\Models\Marketing::class,
        ];

        foreach ($models as $modelClass) {
            if (!class_exists($modelClass)) {
                continue;
            }

            $modelClass::saved(function ($model) {
                $ignoredKeys = ['views', 'views_count', 'clicks_count', 'updated_at'];
                $hasRealChanges = false;
                
                if ($model->wasRecentlyCreated) {
                    $hasRealChanges = true;
                } else {
                    foreach ($model->getChanges() as $key => $value) {
                        if (!in_array($key, $ignoredKeys)) {
                            $hasRealChanges = true;
                            break;
                        }
                    }
                }

                if ($hasRealChanges) {
                    \Illuminate\Support\Facades\Cache::flush();
                }
            });

            $modelClass::deleted(function () {
                \Illuminate\Support\Facades\Cache::flush();
            });
        }
    }
}
