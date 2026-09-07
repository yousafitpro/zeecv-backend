<?php

namespace App\Console\Commands;

use App\Http\Controllers\Job\JobsController;
use App\Http\Controllers\Job\Models\JobCareer;
use App\Models\Pages\Page\Page;
use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
class syncJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-jobs';

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
        dump("started");
        $result=(new JobsController())->openwebJobs();
        dump("completed");
    }
}
