<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;
use App\Services\GoogleIndexingService;
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

    /**
     * Index a single job
     */
    public function indexJob(int $id): JsonResponse
    {
        $job = JobPosting::findOrFail($id);

        if (!method_exists($job, 'getGoogleIndexingUrl')) {
            return response()->json([
                'success' => false,
                'message' => 'Job model does not have getGoogleIndexingUrl method.',
            ], 400);
        }

        $result = $this->indexingService->submitUrl($job->getGoogleIndexingUrl(), 'URL_UPDATED');

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