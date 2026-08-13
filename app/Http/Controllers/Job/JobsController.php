<?php

namespace App\Http\Controllers\Job;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Job\Models\JobCareer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class JobsController extends Controller
{
    public function process()
    {
           $startOfLastWeek = Carbon::now()->startOfWeek();
            $endOfLastWeek   = Carbon::now()->endOfWeek();

            return JobCareer::whereBetween('job_created_at', [
                $startOfLastWeek,
                $endOfLastWeek
            ]);
    }
    public function jobDetail($slug){
         $data['job']=JobCareer::where('slug',$slug)->first();
         return view('home.jobs-detail',$data);
    }
    public function index()
    {
        $data['list']=$this->process()->paginate(20)
        ->withQueryString();
        return view('home.jobs',$data);
    }
    public function arbeitnowJobs()
    {
        for ($page = 1; $page <= 4; $page++) {

            $res = Http::get('https://www.arbeitnow.com/api/job-board-api', [
                'page' => $page,
            ]);

            if (!$res->successful()) {
                continue;
            }

            $result = $res->json();

            foreach ($result['data'] ?? [] as $item) {

                JobCareer::updateOrCreate(
                    [
                        'slug' => $item['slug'],
                        'source' => 'arbeitnow',
                    ],
                    [
                        'company_name' => $item['company_name'] ?? null,
                        'title' => $item['title'] ?? null,
                        'description' => $item['description'] ?? null,

                        'job_created_at' => !empty($item['created_at'])
                            ? Carbon::createFromTimestamp($item['created_at'])
                            : null,

                        'location' => $item['location'] ?? null,
                        'url' => $item['url'] ?? null,

                        'tags' => implode(', ', $item['tags'] ?? []),
                        'job_types' => implode(', ', $item['job_types'] ?? []),

                        'remote' => !empty($item['remote']) ? 1 : 0,
                    ]
                );
            }
        }

        return response()->json([
            'message' => 'Jobs successfully synced',
        ]);
    }
}
