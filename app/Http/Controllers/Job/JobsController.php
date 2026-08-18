<?php

namespace App\Http\Controllers\Job;

use App\Http\Controllers\App\AppGoogleRecaptchaController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Job\Models\JobApplication;
use App\Http\Controllers\Job\Models\JobCareer;
use App\Http\Controllers\Job\Models\UploadedResume;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
class JobsController extends Controller
{
    public function process()
    {
        // dd(time_now());
        //dadasd
        $startDate = Carbon::now()->subWeeks(2);
        $endDate   = Carbon::now()->addDay();

        return JobCareer::whereBetween('job_created_at', [
                $startDate,
                $endDate
            ])
            ->where(function ($query) {
                $query->where('published', 1)
                    ->orWhereNull('published');
            })
            ->where(function ($query) {
                $query->where('status', 'approved')
                    ->orWhereNull('status');
            })
        ->where(function ($query) {
            $query->where('expiry_date', '>=', today())
                ->orWhereNull('expiry_date');
        });
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
    public function jobApplyProcess(Request $request,$slug){

        $job=JobCareer::where('slug',$slug)->first();
        $input=$request->all();
        $score=(new AppGoogleRecaptchaController())->getScore($input['g-recaptcha-response']);
        if($score<0.7)
        {
           return redirect()->back()->withInput()->with([
                'toast' => [
                    'heading' => 'Message',
                    'message' => 'Invalid recaptcha',
                    'type' => 'danger',
                ]
            ]);
        }
        $app=JobApplication::create(
            [
                'job_id'=>$job->id,
                'cover_letter'=>$input['cover_letter']??'',
                'resume_reference'=>$input['selected_resume_id']
            ]
        );
        $item=UploadedResume::updateOrCreate([
            'user_id'=>auth_user_id()
        ]
        );
        $resume = $request->file('resume_file');
        if ($resume) {
                    $data['resume']=fun_save_file($resume,'zeecv/uploaded-resumes');
                    $item->resume_file_id=$data['resume']->id;
                    $item->save();
                }
        return redirect()->route('home.jobs')->with([
                'toast' => [
                    'heading' => 'Message',
                    'message' => 'Application successfully submitted',
                    'type' => 'success',
                ]
            ]);
    }
    public function jobApply($slug){
         $data['job']=JobCareer::where('slug',$slug)->first();
         if(!auth()->check())
          {
              return redirect('signup');
          }
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
         return view('home.jobs-apply',$data);
    }
    public function index(Request $request)
    {
        $input=$request->all();
        
        $data['list'] = $this->process()
            ->where(function ($query) use ($input) {

                if (!empty($input['search'])) {
                    $search = '%' . $input['search'] . '%';

                    $query->where(function ($q) use ($search) {
                        $q->where('title', 'like', $search)
                            ->orWhere('tags', 'like', $search)
                            ->orWhere('company_name', 'like', $search)
                            ->orWhere('location', 'like', $search)
                            ->orWhere('job_types', 'like', $search);
                    });
                }

                if (!empty($input['location'])) {
                    $query->orWhere('location', 'like', '%' . $input['location'] . '%');
                }
            })
        ->with(['user'])
        ->inRandomOrder()
        ->paginate(20)
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
    public function edit(Request $request,$id)
    {
          $input=$request->all();
          $data['job']=JobCareer::find(unique_decrypt($id));
          return view('home.jobs.edit',$data);
    }
    public function update(Request $request,$id)
    {
          $user=auth()->user();
          $input=$request->all();
          $job=JobCareer::find(unique_decrypt($id));
          $job->update(
            [
                'title'=>$input['title'],
                'location'=>$input['location'],
                'url'=>$input['url'],
               'expiry_date' => Carbon::parse($input['expiry_date'])->format('Y-m-d'),
                'slug'=>Str::slug($input['title']).'-'.$user->name.'-zeecv-'.unique_encrypt($user->id),
                'tags'=>$input['tags'],
                'description'=>$input['description'],
                'job_types'=>$input['job_types'],
                'remote'=>$input['remote']??0,
                'published'=>$input['published']??0,
            ]
          );
          if(is_admin()){
            $job->status=$input['status'];
            $job->save();
          }
        return redirect()->back()->with([
                'toast' => [
                    'heading' => 'Message',
                    'message' => 'Job successfully updated',
                    'type' => 'success',
                ]
            ]);
    }
    public function new(Request $request)
    {
          $user=auth()->user();
          $input=$request->all();
          $job=JobCareer::create([
            'title'=>$input['title'],
            'user_id'=>auth_user_id(),
            'slug'=>Str::slug($input['title']).'-'.$user->name.'-zeecv-'.unique_encrypt($user->id),
            'status'=>'pending',
            'type'=>'internal',
            'job_created_at'=>now(),
            'published'=>0
          ]);
          return redirect()->route('jobs.edit',unique_encrypt($job->id));
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
                    ->orWhere('source', 'like', $search)
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
