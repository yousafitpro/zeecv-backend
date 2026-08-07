<?php

namespace App\Http\Controllers\PMM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\PMM\PMMRats;
class CruncyController extends Controller
{
 public function crouncyUpdate()
    {
        $apiKey = env('TWELVE_DATA_API_KEY');
        $symbols = ['USD/PKR', 'USD/EUR','EUR/USD','PKR/USD'];

        $results = [];
        foreach ($symbols as $symbol) {
            $url = "https://api.twelvedata.com/time_series?symbol={$symbol}&interval=1day&apikey={$apiKey}";
            $response = Http::get($url);

            if ($response->successful()) {
                $data = $response->json();
                $latest = $data['values'][0]['close'] ?? null;

                if ($latest) {
                    // Save or update in DB
                    PMMRats::updateOrCreate(
                        ['symbol' => $symbol],
                        ['rate' => $latest]
                    );

                    $results[] = [
                        'symbol' => $symbol,
                        'rate' => $latest,
                    ];
                }
            }
        }

        return response()->json([
            'status' => 'success',
            'data' => $results,
        ]);
    }
}
