<?php

namespace App\Console\Commands;

use App\Http\Controllers\Job\JobsController;
use App\Http\Controllers\Job\Models\JobCareer;
use App\Models\Pages\Page\Page;
use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sitemap = Sitemap::create()
            ->add(Url::create('/')->setPriority(1.0))
            ->add(Url::create('/resume-builder/features')->setPriority(1.0))
            ->add(Url::create('/resume-builder/templates')->setPriority(0.8))
            // ->add(Url::create('/resume-builder/pricing')->setPriority(0.8))
            ->add(Url::create('/resume-builder/jobs')->setPriority(0.8))
            ->add(Url::create('/resume-builder/about')->setPriority(0.8))
            ->add(Url::create('/login')->setPriority(0.8))
            ->add(Url::create('/signup')->setPriority(0.8));

        // Add Blogs
        Page::query()
       ->where('type','blog')
       ->where('status','active')->get()->each(function (Page $blog) use ($sitemap) {
            $sitemap->add(Url::create("/blogs/{$blog->slug}"));
        });


        $sitemap->writeToFile(public_path('sitemap.xml'));
    }
}
