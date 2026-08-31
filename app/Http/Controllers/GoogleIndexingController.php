<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Job\Models\JobCareer;
use App\Models\JobPosting;
use App\Services\GoogleIndexingService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class GoogleIndexingController extends Controller
{
    protected GoogleIndexingService $indexingService;

    public function __construct(GoogleIndexingService $indexingService)
    {
        $this->indexingService = $indexingService;
    }
    public function indexJobs(){
        $todaySent = JobCareer::where('sent_for_indexing_google', 1)
        ->whereDate('updated_at', Carbon::today())  // or 'sent_at' if you have that column
        ->count();
        if($todaySent>=config('services.google.indexing_quota', 200)){
           return response()->json(['message'=>'quota reached : '.config('services.google.indexing_quota', 200)]);
        }
        // Define batch size and time window (e.g., last 48 hours)
        $limit = 5;
        $hours = 1; // change as needed
        $cutoff = Carbon::now()->subHours($hours);

        // 1. Get up to $limit from the prioritized source
        $priorityJobs = JobCareer::where('sent_for_indexing_google', 0)
            ->where('source', 'openwebninja')
            ->where('created_at', '>=', $cutoff) // optional time filter
            ->limit($limit)
            ->get();

        $remaining = $limit - $priorityJobs->count();

        if ($remaining > 0) {
            // 2. Fill the rest from all other sources
            $otherJobs = JobCareer::where('sent_for_indexing_google', 0)
                ->where('source', '!=', 'openwebninja')
                ->where('created_at', '>=', $cutoff)
                ->limit($remaining)
                ->get();
            
            // Merge the two collections
            $jobs = $priorityJobs->merge($otherJobs);
        } else {
            $jobs = $priorityJobs;
        }
        foreach($jobs as $job){
            $this->indexJob($job->id);
        }
        return response()->json(['Successfully Sent','sent_jobs'=>count($jobs)]);
    }
    /**
     * Index a single job
     */
    public function indexJob(int $id): JsonResponse
    {
        $job = JobCareer::findOrFail($id);
        if (!method_exists($job, 'getGoogleIndexingUrl')) {
            return response()->json([
                'success' => false,
                'message' => 'Job model does not have getGoogleIndexingUrl method.',
            ], 400);
        }

        $result = $this->indexingService->submitUrl($job->getGoogleIndexingUrl(), 'URL_UPDATED',$id);
        return response()->json($result);
    }

    /**
     * Index multiple jobs (batch)
     */
    public function indexBatch(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'job_ids' => 'required|array',
            'job_ids.*' => 'exists:job_postings,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $jobs = JobPosting::whereIn('id', $request->job_ids)->get();
        $urls = $jobs->map(function ($job) {
            return $job->getGoogleIndexingUrl();
        })->filter()->toArray();

        if (empty($urls)) {
            return response()->json([
                'success' => false,
                'message' => 'No valid URLs found for the given jobs.',
            ], 400);
        }

        $results = $this->indexingService->submitBatch($urls, 'URL_UPDATED');

        $successCount = collect($results)->filter(fn($r) => $r['success'])->count();
        $failCount = count($results) - $successCount;

        return response()->json([
            'success' => true,
            'total' => count($results),
            'successful' => $successCount,
            'failed' => $failCount,
            'details' => $results,
        ]);
    }

    /**
     * Notify Google that a job has been deleted
     */
    public function deleteJob(int $id): JsonResponse
    {
        $job = JobPosting::findOrFail($id);

        if (!method_exists($job, 'getGoogleIndexingUrl')) {
            return response()->json([
                'success' => false,
                'message' => 'Job model does not have getGoogleIndexingUrl method.',
            ], 400);
        }

        $result = $this->indexingService->submitUrl($job->getGoogleIndexingUrl(), 'URL_DELETED');

        return response()->json($result);
    }

    /**
     * Get current quota usage
     */
    public function quota(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'used' => $this->indexingService->getUsedQuota(),
            'limit' => $this->indexingService->getQuotaLimit(),
            'remaining' => $this->indexingService->getRemainingQuota(),
        ]);
    }

    /**
     * Index all active jobs (for cron jobs)
     */
    public function indexAllActive(): JsonResponse
    {
        $jobs = JobPosting::where('status', 'active')->get();
        $urls = $jobs->map(fn($job) => $job->getGoogleIndexingUrl())->filter()->toArray();

        if (empty($urls)) {
            return response()->json([
                'success' => true,
                'total' => 0,
                'message' => 'No active jobs found.',
            ]);
        }

        $results = $this->indexingService->submitBatch($urls, 'URL_UPDATED');
        $successCount = collect($results)->filter(fn($r) => $r['success'])->count();
        $failCount = count($results) - $successCount;

        return response()->json([
            'success' => true,
            'total' => count($results),
            'successful' => $successCount,
            'failed' => $failCount,
            'details' => $results,
        ]);
    }
}