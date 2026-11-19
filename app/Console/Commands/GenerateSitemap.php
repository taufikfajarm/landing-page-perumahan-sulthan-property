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
    protected $signature = 'sitemap:generate {--base-url= : Override base URL for sitemap generation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.xml with image metadata for SEO';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating sitemap...');

        // Determine base URL: use option, or production URL if local .test/localhost
        $baseUrl = $this->option('base-url') ?: config('app.url', 'https://sulthanproperty.com');
        if (str_contains($baseUrl, 'localhost') || str_contains($baseUrl, '.test')) {
            $baseUrl = 'https://sulthanproperty.com';
        }
        $baseUrl = rtrim($baseUrl, '/');

        $this->info("Using base URL: {$baseUrl}");

        $resolveImageUrl = function (?string $path) use ($baseUrl): ?string {
            if (empty($path)) {
                return null;
            }
            if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
                return preg_replace('#^https?://[^/]+#', $baseUrl, $path);
            }
            if (str_starts_with($path, 'public/')) {
                $path = substr($path, 7);
            }
            return $baseUrl . '/storage/' . ltrim($path, '/');
        };

        $sitemap = Sitemap::create();

        // 1. Static Pages
        $homeUrl = Url::create($baseUrl . '/')
            ->setPriority(1.0)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            ->addImage($baseUrl . '/images/og-image.jpg', 'Sulthan Property - Perumahan Murah & Subsidi di Brebes', 'Brebes, Jawa Tengah', 'Sulthan Property');
        $sitemap->add($homeUrl);

        $perumahanUrl = Url::create($baseUrl . '/perumahan')
            ->setPriority(0.9)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            ->addImage($baseUrl . '/images/og-image.jpg', 'Daftar Perumahan di Brebes & Tegal', 'Brebes, Jawa Tengah', 'Pilihan Perumahan Brebes');
        $sitemap->add($perumahanUrl);

        $staticPages = [
            ['url' => '/marketing', 'priority' => 0.7, 'frequency' => Url::CHANGE_FREQUENCY_MONTHLY],
            ['url' => '/blog', 'priority' => 0.8, 'frequency' => Url::CHANGE_FREQUENCY_DAILY],
            ['url' => '/about', 'priority' => 0.6, 'frequency' => Url::CHANGE_FREQUENCY_MONTHLY],
        ];

        foreach ($staticPages as $page) {
            $sitemap->add(
                Url::create($baseUrl . $page['url'])
                    ->setPriority($page['priority'])
                    ->setChangeFrequency($page['frequency'])
            );
        }

        $this->info('  - Added static pages with images');

        // 2. Blog Posts
        $blogs = Blog::published()->get();
        foreach ($blogs as $blog) {
            $blogUrl = Url::create($baseUrl . '/blog/' . $blog->slug)
                ->setLastModificationDate($blog->updated_at)
                ->setPriority(0.7)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY);

            if ($blog->featured_image) {
                $imgUrl = $resolveImageUrl($blog->featured_image);
                if ($imgUrl) {
                    $blogUrl->addImage($imgUrl, $blog->title, 'Brebes, Jawa Tengah', $blog->title);
                }
            }

            $sitemap->add($blogUrl);
        }
        $this->info("  - Added {$blogs->count()} blog posts with images");

        // 3. Housing Projects & Types
        $housings = Housing::with('types')->get();
        foreach ($housings as $housing) {
            $housingTag = Url::create($baseUrl . '/perumahan/' . $housing->slug)
                ->setLastModificationDate($housing->updated_at)
                ->setPriority(0.9)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY);

            if ($housing->featured_image) {
                $imgUrl = $resolveImageUrl($housing->featured_image);
                if ($imgUrl) {
                    $housingTag->addImage($imgUrl, $housing->name . ' - ' . $housing->location, 'Brebes, Jawa Tengah', $housing->name);
                }
            }

            if ($housing->site_plan) {
                $planUrl = $resolveImageUrl($housing->site_plan);
                if ($planUrl) {
                    $housingTag->addImage($planUrl, 'Siteplan ' . $housing->name, 'Brebes, Jawa Tengah', 'Siteplan ' . $housing->name);
                }
            }

            $sitemap->add($housingTag);

            // Housing types
            foreach ($housing->types as $type) {
                $typeTag = Url::create($baseUrl . '/perumahan/' . $housing->slug . '/' . $type->slug)
                    ->setLastModificationDate($type->updated_at)
                    ->setPriority(0.8)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY);

                $typeImg = $type->image_tampak_depan ?: $type->floor_plan;
                if ($typeImg) {
                    $imgUrl = $resolveImageUrl($typeImg);
                    if ($imgUrl) {
                        $typeTag->addImage($imgUrl, "{$housing->name} - Tipe {$type->name}", 'Brebes, Jawa Tengah', "Tipe {$type->name}");
                    }
                }

                $sitemap->add($typeTag);
            }
        }
        $this->info("  - Added {$housings->count()} housing projects with types & images");

        // Save sitemap
        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully at public/sitemap.xml');

        return Command::SUCCESS;
    }
}
