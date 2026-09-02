<?php

namespace App\Services;

use App\Http\Controllers\Job\Models\JobCareer;
use Carbon\Carbon;
use Google\Client;
use Google\Service\Indexing;
use Google\Service\Indexing\UrlNotification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Exception;

class GoogleIndexingService
{
    protected Client $client;
    protected Indexing $indexing;
    protected string $keyFilePath;
    protected int $dailyQuotaLimit = 200; // Default, can be overridden

    public function __construct()
    {
        $this->keyFilePath = storage_path('app/google-service-account.json');
        $this->initClient();
    }

    /**
     * Initialize Google Client with Service Account
     */
    protected function initClient(): void
    {
        try {
            $this->client = new Client();
            $this->client->setAuthConfig($this->keyFilePath);
            $this->client->addScope(Indexing::INDEXING);
            $this->indexing = new Indexing($this->client);
        } catch (Exception $e) {
            Log::error('Google Indexing Client Initialization Error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Submit a URL to Google Indexing API
     *
     * @param string $url The URL to index or remove
     * @param string $type 'URL_UPDATED' or 'URL_DELETED'
     * @return array ['success' => bool, 'message' => string, 'remaining_quota' => int|null]
     */
    public function submitUrl(string $url, string $type = 'URL_UPDATED',$job_id): array
    {
        try {
            // 1. Check quota
            // if ($this->isQuotaExceeded()) {
            //     return [
            //         'success' => false,
            //         'message' => 'Daily Google Indexing quota exceeded (200 URLs per day).',
            //         'remaining_quota' => $this->getRemainingQuota(),
            //     ];
            // }

            // 2. Prepare notification
            $notification = new UrlNotification();
            $notification->setType($type);
            $notification->setUrl($url);

            // 3. Send request
            $response = $this->indexing->urlNotifications->publish($notification);
            // dd($response);
            // 4. Increment usage
            // $this->incrementUsage();
            JobCareer::where('id',$job_id)->update([
                            'sent_for_indexing_google'=>1,
                            'sent_at_for_indexing_google'=>Carbon::now()
                        ]);
            return [
                'success' => true,
                'message' => 'URL successfully submitted to Google.',
                'remaining_quota' => $this->getRemainingQuota(),
                'response' => $response,
            ];
            
        } catch (Exception $e) {
            Log::error('Google Indexing API error: ' . $e->getMessage(), ['url' => $url]);
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Submit a Job model (assumes a method to get its URL)
     */
    public function submitJob($job, string $type = 'URL_UPDATED'): array
    {
        if (!method_exists($job, 'getGoogleIndexingUrl')) {
            throw new \InvalidArgumentException('Job model must implement getGoogleIndexingUrl()');
        }
        return $this->submitUrl($job->getGoogleIndexingUrl(), $type);
    }

    /**
     * Batch submit multiple URLs (up to 100 per batch)
     */
    public function submitBatch(array $urls, string $type = 'URL_UPDATED'): array
    {
        $results = [];
        foreach ($urls as $url) {
            $results[] = $this->submitUrl($url, $type);
        }
        return $results;
    }

    /**
     * Check if daily quota is exceeded
     */
    public function isQuotaExceeded(): bool
    {
        return $this->getUsedQuota() >= $this->getQuotaLimit();
    }

    /**
     * Get used quota count for today
     */
    public function getUsedQuota(): int
    {
        return (int) Cache::get('google_indexing_quota_' . today()->toDateString(), 0);
    }

    /**
     * Get remaining quota
     */
    public function getRemainingQuota(): int
    {
        $limit = $this->getQuotaLimit();
        $used = $this->getUsedQuota();
        return max(0, $limit - $used);
    }

    /**
     * Increment quota usage by 1
     */
    protected function incrementUsage(): void
    {
        $key = 'google_indexing_quota_' . today()->toDateString();
        Cache::increment($key);
        Cache::expire($key, 86400); // expire at end of day
    }

    /**
     * Get daily quota limit (can be overridden in config)
     */
    public function getQuotaLimit(): int
    {
        return config('services.google.indexing_quota', 200);
    }
}