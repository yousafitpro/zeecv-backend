<?php

namespace App\Console\Commands;

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
            ->add(Url::create('/features')->setPriority(1.0))
            ->add(Url::create('/pricing')->setPriority(0.8))
            ->add(Url::create('/login')->setPriority(0.8))
            ->add(Url::create('/signup')->setPriority(0.8))
            ->add(Url::create('/templates')->setPriority(0.8));

        // Add all public CVs/Profiles from database
        // User::all()->each(function (User $user) use ($sitemap) {
        //     $sitemap->add(Url::create("/profile/{$user->username}"));
        // });

        $sitemap->writeToFile(public_path('sitemap.xml'));
    }
}
