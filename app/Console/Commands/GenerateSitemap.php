<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Blog;
use App\Models\Housing;
use App\Models\HousingType;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.xml for SEO';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating sitemap...');

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

        $this->info('  - Added static pages');

        // Blog posts
        $blogs = Blog::published()->get();
        foreach ($blogs as $blog) {
            $sitemap->add(
                Url::create(config('app.url') . '/blog/' . $blog->slug)
                    ->setLastModificationDate($blog->updated_at)
                    ->setPriority(0.7)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            );
        }
        $this->info("  - Added {$blogs->count()} blog posts");

        // Housing projects
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
        $this->info("  - Added {$housings->count()} housing projects with types");

        // Save sitemap
        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully at public/sitemap.xml');

        return Command::SUCCESS;
    }
}
