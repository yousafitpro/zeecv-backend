<?php

namespace App\Console\Commands;

use App\Http\Controllers\Job\JobsController;
use App\Http\Controllers\Job\Models\JobCareer;
use App\Models\Pages\Page\Page;
use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
class Generatellms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-llms';

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
        $jobs = (new JobsController())
            ->process()
            ->where('sent_for_indexing_google', 0)
            ->orderByRaw('user_id IS NULL ASC')
            ->get();

        $content = "# ZeeCV\n\n";

        $content .= "> AI Resume Builder + Job Board\n\n"
                ."ZeeCV is a professional CV and resume builder that helps users \n\n"
                . "ZeeCV helps you build an AI-powered CV and connects you with thousands of jobs posted by companies worldwide. Build your resume, apply instantly, and land your dream role — all in one place.\n\n"
                . "create professional resumes and discover relevant job opportunities.\n\n";

        $content .= "## Main Pages\n\n";
        $content .= "- https://zeecv.com/\n";
        $content .= "- https://zeecv.com/jobs\n";
        $content .= "- https://zeecv.com/resume/create\n\n";

        $content .= "## Jobs\n\n";

        $jobs->each(function (JobCareer $job) use (&$content) {

            $title = $job->title ?? 'Job Opportunity';

            // Change this according to your actual slug/URL column
            $url = url('/jobs/' . ($job->slug ?? $job->id));

            $content .= "### {$title}\n\n";
            $content .= "- URL: {$url}\n";

            if (!empty($job->company_name)) {
                $content .= "- Company: {$job->company_name}\n";
            }

            if (!empty($job->location)) {
                $content .= "- Location: {$job->location}\n";
            }

            $content .= "\n";
        });

        // Save to public/llms.txt
        file_put_contents(
            public_path('llms.txt'),
            $content
        );
    }
}
