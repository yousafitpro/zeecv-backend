<?php

namespace App\Http\Controllers\Job;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Job\Models\JobCareer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
class JobsController extends Controller
{
    public function process()
    {
        //dadasd
           $startOfLastWeek = Carbon::now()->subWeeks(2)->startOfWeek();
            $endOfLastWeek   = Carbon::now()->endOfWeek();

            return JobCareer::whereBetween('job_created_at', [
                $startOfLastWeek,
                $endOfLastWeek
            ]);
    }
    public function jobDetail($slug){
         $data['job']=JobCareer::where('slug',$slug)->first();
            $currentTags = is_array($data['job']->tags)
                ? $data['job']->tags
                : explode(',', $data['job']->tags);

            $data['random_jobs'] = JobCareer::where('slug', '!=', $slug)
                ->where(function ($query) use ($currentTags) {

                    foreach ($currentTags as $tag) {

                        $tag = trim($tag);

                        if ($tag !== '') {

                            $query->orWhere('tags', 'LIKE', '%' . $tag . '%')
                                ->orWhere('title', 'LIKE', '%' . $tag . '%');

                        }
                    }

                })
                ->inRandomOrder()
                ->limit(4)
                ->get();
         return view('home.jobs-detail',$data);
    }
    public function index(Request $request)
    {
        $input=$request->all();
        
        $data['list'] = $this->process()
            ->when(!empty($input['search']), function ($query) use ($input) {
                $search = '%' . $input['search'] . '%';

                return $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', $search)
                    ->orWhere('tags', 'like', $search)
                    ->orWhere('location', 'like', $search)
                    ->orWhere('job_types', 'like', $search);
                });
            })
            ->when(!empty($input['location']), function ($query) use ($input) {
                return $query->where(
                    'location',
                    'like',
                    '%' . $input['location'] . '%'
                );
            })
        ->latest('job_created_at')->paginate(20)
        ->withQueryString();
        $data['input']=$input;
        $data['locations'] = JobCareer::pluck('location')
                            ->filter()
                            ->flatMap(function ($locations) {
                                return array_map('trim', explode(',', $locations));
                            })
                            ->filter()
                            ->unique()
                            ->values()
                            ->toArray();
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
public function himalayasJobs()
{
    $limit = 20;
    $maxJobs = 100;

    for ($offset = 0; $offset < $maxJobs; $offset += $limit) {

        $res = Http::timeout(30)->get('https://himalayas.app/jobs/api', [
            'limit' => $limit,
            'offset' => $offset,
        ]);

        if (!$res->successful()) {
            continue;
        }

        $jobs = $res->json('jobs', []);

        foreach ($jobs as $item) {

            JobCareer::updateOrCreate(
                [
                    'slug' => Str::slug(
                        ($item['title'] ?? 'job') . '-' .
                        ($item['companyName'] ?? '')
                    ),
                    'source' => 'himalayas',
                ],
                [
                    'company_name' => $item['companyName'] ?? null,
                    'title' => $item['title'] ?? null,
                    'currency' => $item['currency'] ?? null,
                    'description' => $item['description'] ?? null,

                    'job_created_at' => !empty($item['pubDate'])
                        ? Carbon::parse($item['pubDate'])
                        : null,
                    'expiry_date' => !empty($item['expiryDate'])
                        ? Carbon::parse($item['expiryDate'])
                        : null,

                    'location' => !empty($item['locationRestrictions'])
                        ? $item['locationRestrictions'][0]
                        : null,

                    'url' => $item['applicationLink'] ?? null,

                    'tags' => implode(
                        ', ',
                        $item['categories'] ?? []
                    ),
                ]
            );
        }

        // Stop if API returns fewer than 20 jobs
        if (count($jobs) < $limit) {
            break;
        }
    }

    return response()->json([
        'message' => 'First 100 jobs successfully synced',
    ]);
}
}
