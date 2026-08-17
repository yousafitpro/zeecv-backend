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
                    ->orWhere('company_name', 'like', $search)
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
    public function my(Request $request)
    {
        $input=$request->all();
        
        $data['list'] = JobCareer::query()
            ->when(!is_admin(),function ($query) {
                return $query->where('user_id',auth_user_id());
            })
            ->when(!empty($input['search']), function ($query) use ($input) {
                $search = '%' . $input['search'] . '%';

                return $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', $search)
                    ->orWhere('tags', 'like', $search)
                    ->orWhere('company_name', 'like', $search)
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
        return view('home.jobs.my',$data);
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

                $job=JobCareer::updateOrCreate(
                    [
                        'slug' => $item['slug'].'-zeecv-1',
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

            $job=JobCareer::updateOrCreate(
                [
                    'slug' => Str::slug(
                        ($item['title'] ?? 'job') . '-' .
                        ($item['companyName'] ?? '').'-zeecv-2'
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
public function remotiveJobs($search=null)
{
    $limit = 100;
    $maxJobs = 100;



        $res = Http::timeout(30)->get('https://remotive.com/api/remote-jobs', [
            'limit' => $limit
        ]);

        if ($res->successful()) {

            $jobs = $res->json('jobs', []);
            foreach ($jobs as $item) {

                $job=JobCareer::updateOrCreate(
                    [
                        'slug' => Str::slug(
                            ($item['title'] ?? 'job') . '-' .
                            ($item['company_name'] ?? '').'-zeecv-3'
                        ),
                        'source' => 'remotive',
                    ],
                    [
                        'company_name' => $item['company_name'] ?? null,
                        'title' => $item['title'] ?? null,
                        'currency' => $item['currency'] ?? null,
                        'job_types' => $item['job_type'] ?? null,
                        'description' => $item['description'] ?? null,

                        'job_created_at' => !empty($item['publication_date'])
                            ? Carbon::parse($item['publication_date'])
                            : null,

                        'location' => !empty($item['locationRestrictions'])
                            ? $item['locationRestrictions'][0]
                            : null,

                        'url' => $item['url'] ?? null,

                        'tags' => implode(
                            ', ',
                            $item['tags'] ?? []
                        ),
                    ]
                );
            }
        }

    return response()->json([
        'message' => 'First 100 jobs successfully synced',
    ]);
}
public function remoteOKJobs($search=null)
{
    $limit = 100;
    $maxJobs = 100;



        $res = Http::timeout(30)->get('https://remoteok.com/api', [
            'limit' => $limit
        ]);
        if ($res->successful()) {

            $jobs =$res->json();
            foreach ($jobs as $index => $item) {
                if ($index === 0) {
                    continue;
                }

                $job=JobCareer::updateOrCreate(
                    [
                        'slug' => Str::slug(
                            ($item['position'] ?? 'job').'-zeecv-4'
                        ),
                        'source' => 'remoteok',
                    ],
                    [
                        'company_name' => $item['company'] ?? null,
                        'title' => $item['position'] ?? null,
                        'currency' => $item['currency'] ?? null,
                        'job_types' => $item['job_type'] ?? null,
                        'description' => $item['description'] ?? null,

                        'job_created_at' => !empty($item['date'])
                            ? Carbon::parse($item['date'])
                            : null,

                        'location' => $item['location'],

                        'url' => $item['apply_url'] ?? null,

                        'tags' => implode(
                            ', ',
                            $item['tags'] ?? []
                        ),
                    ]
                );
            }
        }

    return response()->json([
        'message' => 'First 100 jobs successfully synced',
    ]);
}
public function adzunaJobs($search=null)
{
    $limit = 100;
    $maxJobs = 100;



        $res = Http::get(
            'https://api.adzuna.com/v1/api/jobs/us/search/1',
            [
                'app_id' => '0b647b4f',
                'app_key' => 'e53df415d6e4264f4d8f9f381fac7a30',
                'results_per_page' => 50,
                'what' => 'Laravel Developer',
                'content-type' => 'application/json',
            ]
        );

        if ($res->successful()) {

            $jobs = $res->json('results', []);
            foreach ($jobs as $item) {

                $job=JobCareer::updateOrCreate(
                    [
                        'slug' => Str::slug(
                            ($item['title'] ?? 'job').'-zeecv-5'
                        ),
                        'source' => 'adzuna',
                    ],
                    [
                        'company_name' => $item['company']['display_name'] ?? null,
                        'title' => $item['title'] ?? null,
                        'currency' => $item['currency'] ?? null,
                        'job_types' => $item['job_type'] ?? null,
                        'description' => $item['description'] ?? null,

                        'job_created_at' => !empty($item['created'])
                            ? Carbon::parse($item['created'])
                            : null,

                        'url' => $item['redirect_url'] ?? null,
                        'tags' => $item['category']['tag'] ?? null,

                        'location' => is_array($item['location']['area'] ?? null)
                                    ? implode(', ', $item['location']['area'])
                                    : ($item['location']['area'] ?? ''),
                    ]
                );
            }
        }

    return response()->json([
        'message' => 'First 100 jobs successfully synced',
    ]);
}
public function openwebJobs($search=null)
{
    $urls=[
        'https://api.openwebninja.com/jsearch/search-v2?query=developer jobs in UK',
        'https://api.openwebninja.com/jsearch/search-v2?query=developer jobs in DE',
        'https://api.openwebninja.com/jsearch/search-v2?query=developer jobs in US',
        'https://api.openwebninja.com/jsearch/search-v2?query=developer jobs in IT',
        'https://api.openwebninja.com/jsearch/search-v2?query=developer jobs in AE',
        'https://api.openwebninja.com/jsearch/search-v2?query=developer jobs in PK',
    ];



        foreach($urls as $url){
            $res = Http::withHeader('x-api-key','ak_ei1rwelcczvlrvyxe9cvhnukd7ny3kwcs0qn0hsbbu330yx')->get($url);
        if ($res->successful()) {

            $jobs = $res->json('data', [])['jobs'];
            foreach ($jobs as $item) {

                $job=JobCareer::updateOrCreate(
                    [
                        'slug' => Str::slug(
                            ($item['job_title'] ?? 'job').($item['job_uid'] ?? 'job').'zeecv-6'
                        ),
                        'source' => 'openwebninja',
                    ],
                    [
                        'company_name' => $item['employer_name'] ?? null,
                        'title' => $item['job_title'] ?? null,
                        'job_types' => implode(', ', $item['job_employment_types'] ?? []),
                        'description' => $item['job_description'] ?? null,

                        'job_created_at' => !empty($item['job_posted_at_timestamp'])
                            ? Carbon::parse($item['job_posted_at_timestamp'])
                            : null,

                        'url' => $item['job_apply_link'] ?? null,

                        'location' =>$item['job_location'],
                    ]
                );
            }
        }
        }

    return response()->json([
        'message' => 'First 100 jobs successfully synced',
    ]);
}
}
