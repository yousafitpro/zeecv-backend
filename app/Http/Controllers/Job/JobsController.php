<?php

namespace App\Http\Controllers\Job;

use App\Http\Controllers\App\AppGoogleRecaptchaController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Job\Models\JobApplication;
use App\Http\Controllers\Job\Models\JobCareer;
use App\Http\Controllers\Job\Models\JobCareerApply;
use App\Http\Controllers\Job\Models\JobCareerSaved;
use App\Http\Controllers\Job\Models\UploadedResume;
use App\Http\Controllers\Job\Resources\JobResource;
use App\Models\Resume\Skill;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
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

            $data['random_jobs'] = JobResource::collection(JobCareer::where('slug', '!=', $slug)
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
                ->get());
        if(is_ma()){
            $data['job']=new JobResource($data['job']);
            unset($data['random_jobs']);
            return response()->json($data);
        }
         return view('home.jobs-detail',$data);
    }
    public function jobApplyProcess(Request $request,$slug){

        $job=JobCareer::where('slug',$slug)->first();
        $input=$request->all();
        // $score=(new AppGoogleRecaptchaController())->getScore($input['g-recaptcha-response']);
        // if($score<0.7)
        // {
        //    return redirect()->back()->withInput()->with([
        //         'toast' => [
        //             'heading' => 'Message',
        //             'message' => 'Invalid recaptcha',
        //             'type' => 'danger',
        //         ]
        //     ]);
        // }
        $todayApplications = JobApplication::where('user_id',auth_user_id())
        ->whereDate('created_at', Carbon::today())
        ->count();
        // dd($todayApplications);
        if($todayApplications>29){
            return redirect()->back()->with([
                'toast' => [
                    'heading' => 'Message',
                    'message' => 'You have reached your limit for today.',
                    'type' => 'danger',
                ]
            ]);
        }
        $app=JobApplication::create(
            [
                'job_id'=>$job->id,
                'cover_letter'=>$input['cover_letter']??'',
                'user_id'=>auth_user_id(),
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
            $user=User::where('login_token',request('token'))->first();
            Session::put('is_app','yes');
            if($user){
                auth()->login($user);
            }
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
        
        $data['list'] = [];
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
public function queryProcess(Request $request)
{
    $input = $request->all();

    $query = $this->process()
        ->with(['user']);

    if (!empty($input['search'])) {

        $keywords = preg_split('/\s+/', trim($input['search']));

        $query->where(function ($q) use ($keywords) {

            foreach ($keywords as $keyword) {

                $term = '%' . $keyword . '%';

                $q->orWhere(function ($subQuery) use ($term) {
                    $subQuery->where('title', 'like', $term)
                        ->orWhere('tags', 'like', $term)
                        ->orWhere('company_name', 'like', $term)
                        ->orWhere('location', 'like', $term)
                        ->orWhere('job_types', 'like', $term);
                });
            }
        });

        /*
        |--------------------------------------------------------------------------
        | Relevance Ranking
        |--------------------------------------------------------------------------
        */

        $search = trim($input['search']);
        $searchTerm = '%' . $search . '%';

        $score = "
            (
                CASE
                    WHEN title LIKE " . \DB::getPdo()->quote($searchTerm) . "
                        THEN 100
                    WHEN tags LIKE " . \DB::getPdo()->quote($searchTerm) . "
                        THEN 80
                    WHEN company_name LIKE " . \DB::getPdo()->quote($searchTerm) . "
                        THEN 70
                    WHEN location LIKE " . \DB::getPdo()->quote($searchTerm) . "
                        THEN 60
                    WHEN job_types LIKE " . \DB::getPdo()->quote($searchTerm) . "
                        THEN 50
                    ELSE 10
                END
            )
        ";

        $query->orderByRaw($score . ' DESC');
    }

    if (!empty($input['location'])) {
        $query->where(
            'location',
            'like',
            '%' . $input['location'] . '%'
        );
    }
    if (isset($input['is_remote'])) {
        $query->where('remote', 1);
    }
    if (isset($input['is_part_time'])) {
        $query->where('is_part_time', 1);
    }
    if (isset($input['is_permanent'])) {
        $query->where('is_permanent', 1);
    }
    if (isset($input['is_internship'])) {
        $query->where('is_internship', 1);
    }
    if (isset($input['is_full_time'])) {
        $query->where('is_full_time', 1);
    }
    if (isset($input['is_contract'])) {
        $query->where('is_contract', 1);
    }

    return $query;
}
    public function applyAjax(Request $request){
        $input=$request->all();
        JobCareerApply::updateOrCreate([
                    'job_id' => $input['job_id'],
                    'user_id' => auth_user_id(),
                ],
                [
                    'status' => 'applied',
                    'updated_at' => now(),
                ]);
        return response()->json(['success'=>true,'message'=>'successfully Applied']);
    }
    public function saveAjax(Request $request){
        $input=$request->all();
        JobCareerSaved::updateOrCreate([
                    'job_id' => $input['job_id'],
                    'user_id' => auth_user_id(),
                ],
                [
                    'status' => 'applied',
                    'updated_at' => now(),
                ]);
        return response()->json(['success'=>true,'message'=>'successfully saved']);
    }
    public function indexAjax(Request $request)
    {
        $input=$request->all();
        
        $data['list'] =$this->queryProcess($request)
        ->inRandomOrder();
    
        if(!is_ma()){
            $data['list']=$data['list']->paginate(20)
        ->withQueryString()->setPath(route('home.jobs'));;
        return view('home.ajax.jobs-list',$data);
        }else{
          $data['list']= JobResource::collection($data['list']->take(20)->get()); 
          return response()->json($data);
        }
        
         
    }
    public function deleteAccount(Request $request){
       return response()->json(['message'=>'Account successfully deleted']);
    }
    public function myJobs(Request $request)
    {
        $input=$request->all();
        $skills=[];
        $resume=my_resume();
        if(!empty($resume)){
            $skills=Skill::where('resume_id',$resume->id)->pluck('skill')->toArray();
        }
        $data['list'] = JobCareer::query()
            ->when(!empty($skills), function ($query) use ($skills) {
                $query->where(function ($q) use ($skills) {
                    foreach ($skills as $skill) {
                        $q->orWhere('tags', 'like', '%' . $skill . '%');
                    }
                });
            })
            ->orderBy('id','desc');
    
        if(!is_ma()){
            $data['list']=$data['list']->paginate(20)
        ->withQueryString();
        return view('home.ajax.jobs-list',$data);
        }else{
            if(empty($skills)){
                //adsd
             $data['list']=[];
            }else{
                $data['list']= JobResource::collection($data['list']->take(50)->get());
            }
           
          return response()->json($data);
        }
        
         
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
        
        $query = JobCareer::query()
            ->when(!is_admin(),function ($query) {
                return $query->where('user_id',auth_user_id());
            });
            if (!empty($input['search'])) {

            $keywords = preg_split('/\s+/', trim($input['search']));

            $query->where(function ($q) use ($keywords) {

                foreach ($keywords as $keyword) {

                    $term = '%' . $keyword . '%';

                    $q->orWhere(function ($subQuery) use ($term) {
                        $subQuery->where('title', 'like', $term)
                            ->orWhere('tags', 'like', $term)
                            ->orWhere('company_name', 'like', $term)
                            ->orWhere('location', 'like', $term)
                            ->orWhere('job_types', 'like', $term);
                    });
                }
            });

            /*
            |--------------------------------------------------------------------------
            | Relevance Ranking
            |--------------------------------------------------------------------------
            */

            $search = trim($input['search']);
            $searchTerm = '%' . $search . '%';

            $score = "
                (
                    CASE
                        WHEN title LIKE " . \DB::getPdo()->quote($searchTerm) . "
                            THEN 100
                        WHEN tags LIKE " . \DB::getPdo()->quote($searchTerm) . "
                            THEN 80
                        WHEN company_name LIKE " . \DB::getPdo()->quote($searchTerm) . "
                            THEN 70
                        WHEN location LIKE " . \DB::getPdo()->quote($searchTerm) . "
                            THEN 60
                        WHEN job_types LIKE " . \DB::getPdo()->quote($searchTerm) . "
                            THEN 50
                        ELSE 10
                    END
                )
            ";

            $query->orderByRaw($score . ' DESC');
        }

        if (!empty($input['location'])) {
            $query->where(
                'location',
                'like',
                '%' . $input['location'] . '%'
            );
        }
        if (!empty($input['source'])) {
            $query->where(
                'source',
                'like',
                '%' . $input['source'] . '%'
            );
        }
        if (isset($input['is_remote'])) {
            $query->where('remote', 1);
        }
        if (isset($input['is_part_time'])) {
            $query->where('is_part_time', 1);
        }
        if (isset($input['is_permanent'])) {
            $query->where('is_permanent', 1);
        }
        if (isset($input['is_internship'])) {
            $query->where('is_internship', 1);
        }
        if (isset($input['is_full_time'])) {
            $query->where('is_full_time', 1);
        }
        if (isset($input['is_contract'])) {
            $query->where('is_contract', 1);
        }
            
        $data['list']=$query->latest('job_created_at')->paginate(20)
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
        $data['sources'] = JobCareer::pluck('source')
                            ->filter()
                            ->flatMap(function ($sources) {
                                return array_map('trim', explode(',', $sources));
                            })
                            ->filter()
                            ->unique()
                            ->values()
                            ->toArray();
        return view('home.jobs.my',$data);
    }
    public function arbeitnowJobs()
    {
        for ($page = 1; $page <= 10; $page++) {

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
    $maxJobs = 500;

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



        for($i=1; $i<=10; $i++){
            $res = Http::get(
            'https://api.adzuna.com/v1/api/jobs/us/search/'.$i,
            [
                'app_id' => '0b647b4f',
                'app_key' => 'e53df415d6e4264f4d8f9f381fac7a30',
                'results_per_page' => 100,
                'content-type' => 'application/json',
            ]
        );
        if ($res->successful()) {

            $jobs = $res->json('results', []);
            // dd($jobs);
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
        }

    return response()->json([
        'message' => 'First 100 jobs successfully synced',
    ]);
}
public function openwebJobs($search = null)
{
    $accounts = [
        0 => [
            'api_key' => env('OPENWEBNINJA_API_KEY_1'),
            'urls' => [
                'https://api.openwebninja.com/jsearch/search-v2?query=developer jobs in Portugal&country=pt',
                'https://api.openwebninja.com/jsearch/search-v2?query=developer jobs in Czech Republic&country=cz',
                'https://api.openwebninja.com/jsearch/search-v2?query=developer jobs in Romania&country=ro',
                'https://api.openwebninja.com/jsearch/search-v2?query=developer jobs in Hungary&country=hu',
                'https://api.openwebninja.com/jsearch/search-v2?query=developer jobs in Greece&country=gr',
                'https://api.openwebninja.com/jsearch/search-v2?query=developer jobs in Luxembourg&country=lu',
            ]
        ],

        1 => [
            'api_key' => env('OPENWEBNINJA_API_KEY_2'),
            'urls' => [
                'https://api.openwebninja.com/jsearch/search-v2?query=developer jobs in Norway&country=no',
                'https://api.openwebninja.com/jsearch/search-v2?query=developer jobs in Denmark&country=dk',
                'https://api.openwebninja.com/jsearch/search-v2?query=developer jobs in Finland&country=fi',
                'https://api.openwebninja.com/jsearch/search-v2?query=developer jobs in Belgium&country=be',
                'https://api.openwebninja.com/jsearch/search-v2?query=developer jobs in Austria&country=at',
                'https://api.openwebninja.com/jsearch/search-v2?query=developer jobs in Ireland&country=ie',
            ]
        ],

        2 => [
            'api_key' => env('OPENWEBNINJA_API_KEY_3'),
            'urls' => [
                'https://api.openwebninja.com/jsearch/search-v2?query=developer jobs in France&country=fr',
                'https://api.openwebninja.com/jsearch/search-v2?query=developer jobs in Netherlands&country=nl',
                'https://api.openwebninja.com/jsearch/search-v2?query=developer jobs in Sweden&country=se',
                'https://api.openwebninja.com/jsearch/search-v2?query=developer jobs in Spain&country=es',
                'https://api.openwebninja.com/jsearch/search-v2?query=developer jobs in Poland&country=pl',
                'https://api.openwebninja.com/jsearch/search-v2?query=developer jobs in Switzerland&country=ch',
            ]
        ],

        3 => [
            'api_key' => env('OPENWEBNINJA_API_KEY_4'),
            'urls' => [
                'https://api.openwebninja.com/jsearch/search-v2?query=developer jobs in United Kingdom&country=gb',
                'https://api.openwebninja.com/jsearch/search-v2?query=developer jobs in Germany&country=de',
                'https://api.openwebninja.com/jsearch/search-v2?query=developer jobs in United States&country=us',
                'https://api.openwebninja.com/jsearch/search-v2?query=developer jobs in Italy&country=it',
                'https://api.openwebninja.com/jsearch/search-v2?query=developer jobs in United Arab Emirates&country=ae',
                'https://api.openwebninja.com/jsearch/search-v2?query=developer jobs in Canada&country=ca',
            ]
        ],
        4 => [
            'api_key' => env('OPENWEBNINJA_API_KEY_5'),
            'urls' => [
                'https://api.openwebninja.com/jsearch/search-v2?query=developer jobs in Slovakia&country=sk',
                'https://api.openwebninja.com/jsearch/search-v2?query=developer jobs in Slovenia&country=si',
                'https://api.openwebninja.com/jsearch/search-v2?query=developer jobs in Croatia&country=hr',
                'https://api.openwebninja.com/jsearch/search-v2?query=developer jobs in Bulgaria&country=bg',
                'https://api.openwebninja.com/jsearch/search-v2?query=developer jobs in Estonia&country=ee',
                'https://api.openwebninja.com/jsearch/search-v2?query=developer jobs in Pakistan&country=pk',
            ]
        ],
    ];

    $total = 0;
    $failed = 0;
    $filtered_urls=[];

    foreach ($accounts as $account) {

        foreach ($account['urls'] as $url) {
              $filtered_urls[]=$url;
            try {

                $res = Http::timeout(30)
                    ->withHeader('x-api-key', $account['api_key'])
                    ->get($url);

                if (!$res->successful()) {
                    $failed++;
                    continue;
                }

                $jobs = $res->json('data.jobs', []);

                if (!is_array($jobs)) {
                    continue;
                }

                foreach ($jobs as $item) {

                    $jobUid = $item['job_uid'] ?? null;

                    if (!$jobUid) {
                        continue;
                    }

                    JobCareer::updateOrCreate(
                        [
                            'slug' => Str::slug(
                                ($item['job_title'] ?? 'job')
                                . '-' . $jobUid
                                . '-zeecv-6'
                            ),
                            'source' => 'openwebninja',
                        ],
                        [
                            'company_name' => $item['employer_name'] ?? null,

                            'title' => $item['job_title'] ?? null,

                            'job_types' => !empty($item['job_employment_types'])
                                ? implode(', ', $item['job_employment_types'])
                                : null,

                            'description' => $item['job_description'] ?? null,

                            'job_created_at' => !empty($item['job_posted_at_timestamp'])
                                ? Carbon::createFromTimestamp(
                                    $item['job_posted_at_timestamp']
                                )
                                : null,

                            'url' => $item['job_apply_link'] ?? null,

                            'location' => $item['job_location'] ?? null,
                        ]
                    );

                    $total++;
                }

            } catch (\Throwable $e) {

                $failed++;

                // Log::error('OpenWebNinja Job Sync Error', [
                //     'url' => $url,
                //     'error' => $e->getMessage(),
                // ]);
            }
        }
    }

    return response()->json([
        'message' => 'Jobs successfully synced',
        'synced' => $total,
        'filtered_urls'=>$filtered_urls,
        'failed_requests' => $failed,
    ]);
}
}
