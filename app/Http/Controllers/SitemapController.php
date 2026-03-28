<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Blog;
use App\Models\Housing;

class SitemapController extends Controller
{
    /**
     * Generate dynamic sitemap XML
     */
    public function index(): Response
    {
        $sitemap = Sitemap::create();

        // Static pages
        $staticPages = [
            ['url' => '/', 'priority' => 1.0, 'frequency' => Url::CHANGE_FREQUENCY_DAILY],
            ['url' => '/perumahan', 'priority' => 0.9, 'frequency' => Url::CHANGE_FREQUENCY_WEEKLY],
            ['url' => '/marketing', 'priority' => 0.7, 'frequency' => Url::CHANGE_FREQUENCY_MONTHLY],
            ['url' => '/blog', 'priority' => 0.8, 'frequency' => Url::CHANGE_FREQUENCY_DAILY],
            ['url' => '/about', 'priority' => 0.6, 'frequency' => Url::CHANGE_FREQUENCY_MONTHLY],
        ];

        foreach ($staticPages as $page) {
            $sitemap->add(
                Url::create(config('app.url') . $page['url'])
                    ->setPriority($page['priority'])
                    ->setChangeFrequency($page['frequency'])
            );
        }

        // Blog posts from database
        $blogs = Blog::published()->get();
        foreach ($blogs as $blog) {
            $sitemap->add(
                Url::create(config('app.url') . '/blog/' . $blog->slug)
                    ->setLastModificationDate($blog->updated_at)
                    ->setPriority(0.7)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            );
        }

        // Housing projects from database
        $housings = Housing::all();
        foreach ($housings as $housing) {
            $sitemap->add(
                Url::create(config('app.url') . '/perumahan/' . $housing->slug)
                    ->setLastModificationDate($housing->updated_at)
                    ->setPriority(0.8)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            );

            // Housing types
            foreach ($housing->types as $type) {
                $sitemap->add(
                    Url::create(config('app.url') . '/perumahan/' . $housing->slug . '/' . $type->slug)
                        ->setLastModificationDate($type->updated_at)
                        ->setPriority(0.7)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                );
            }
        }

        return response($sitemap->render(), 200, [
            'Content-Type' => 'application/xml',
        ]);
    }
}
