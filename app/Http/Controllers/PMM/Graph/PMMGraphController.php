<?php

namespace App\Http\Controllers\PMM\Graph;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Ledger\LedgerController;
use App\Models\Payment\Payment;
use App\Models\PMM\Product\PMMProduct;
use App\Models\PMM\Product\PMMProductClick;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PMMGraphController extends Controller
{

public function ProductInsigts(Request $request)
    {
            $filter = $request->input('filter');
            $userId = auth()->id();
            $query = PMMProduct::query();

            if (!is_admin()) {
                $query->where('user_id', $userId);
            }

            $data = [];
            $labels = [];

            switch ($filter) {
                case 'Today':
                case 'Yesterday':
                    $date = $filter === 'Today' ? now() : now()->subDay();
                    $query->whereDate('created_at', $date);
                    $products = $query->select(
                        DB::raw('HOUR(created_at) as label'),
                        DB::raw('COUNT(*) as count')
                    )
                    ->groupBy(DB::raw('HOUR(created_at)'))
                    ->pluck('count', 'label')
                    ->toArray();

                    for ($i = 0; $i < 24; $i++) {
                        $labels[] = $i . ':00';
                        $data[] = $products[$i] ?? 0;
                    }
                    break;

                case 'Monthly':
                case 'Previous Month':
                    $date = $filter === 'Monthly' ? now() : now()->subMonth();
                    $query->whereMonth('created_at', $date->month)
                        ->whereYear('created_at', $date->year);

                    $products = $query->select(
                        DB::raw('DAY(created_at) as label'),
                        DB::raw('COUNT(*) as count')
                    )
                    ->groupBy(DB::raw('DAY(created_at)'))
                    ->pluck('count', 'label')
                    ->toArray();

                    $daysInMonth = now()->daysInMonth;
                    for ($i = 1; $i <= $daysInMonth; $i++) {
                        $labels[] = $i;
                        $data[] = $products[$i] ?? 0;
                    }
                    break;

                case 'Yearly':
                case 'Previous Year':
                    $date = $filter === 'Yearly' ? now() : now()->subYear();
                    $query->whereYear('created_at',$date->year);

                    $products = $query->select(
                        DB::raw('MONTH(created_at) as label'),
                        DB::raw('COUNT(*) as count')
                    )
                    ->groupBy(DB::raw('MONTH(created_at)'))
                    ->pluck('count', 'label')
                    ->toArray();

                    $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

                    foreach (range(1, 12) as $i) {
                        $labels[] = $months[$i - 1];
                        $data[] = $products[$i] ?? 0;
                    }
                    break;

                case 'All':
                default:
                    $products = $query->select(
                        DB::raw('YEAR(created_at) as label'),
                        DB::raw('COUNT(*) as count')
                    )
                    ->groupBy(DB::raw('YEAR(created_at)'))
                    ->orderBy('label')
                    ->pluck('count', 'label')
                    ->toArray();

                    foreach ($products as $year => $count) {
                        $labels[] = $year;
                        $data[] = $count;
                    }
                    break;
            }

            return [
                'labels' => $labels,
                'data' => $data
            ];
    }
public function ProductTransactionsInsights(Request $request)
    {
        $filter = $request->input('filter');
        $userId = auth()->id();
        $query = Payment::query()->when(!is_admin(), function ($q2) {
            $q2->where(function ($q3) {
                $q3->where('user_id', auth_user_id())
                    ->orWhereHas('link.product', function ($q) {
                        $q->where('user_id', auth_user_id());
                    });
            });
        });
        $data = [];
        $labels = [];

        switch ($filter) {
            case 'Today':
            case 'Yesterday':
                $date = $filter === 'Today' ? now() : now()->subDay();
                $query->whereDate('created_at',$date);

                $clicks = $query->select(
                    DB::raw('HOUR(created_at) as label'),
                    DB::raw('COUNT(*) as count')
                )
                ->groupBy(DB::raw('HOUR(created_at)'))
                ->pluck('count', 'label')
                ->toArray();
                for ($i = 0; $i < 24; $i++) {
                    $labels[] = $i . ':00';
                    $data[] = $clicks[$i] ?? 0;
                }
                break;

            case 'Monthly':
            case 'Previous Month':
                $date = $filter === 'Monthly' ? now() : now()->subMonth();
                $query->whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year);

                $clicks = $query->select(
                    DB::raw('DAY(created_at) as label'),
                    DB::raw('COUNT(*) as count')
                )
                ->groupBy(DB::raw('DAY(created_at)'))
                ->pluck('count', 'label')
                ->toArray();

                $daysInMonth = now()->daysInMonth;
                for ($i = 1; $i <= $daysInMonth; $i++) {
                    $labels[] = $i;
                    $data[] = $clicks[$i] ?? 0;
                }
                break;

            case 'Yearly':
            case 'Previous Year':
                $date = $filter === 'Yearly' ? now() : now()->subYear();
                $query->whereYear('created_at',$date->year);

                $clicks = $query->select(
                    DB::raw('MONTH(created_at) as label'),
                    DB::raw('COUNT(*) as count')
                )
                ->groupBy(DB::raw('MONTH(created_at)'))
                ->pluck('count', 'label')
                ->toArray();

                $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                        'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

                foreach (range(1, 12) as $i) {
                    $labels[] = $months[$i - 1];
                    $data[] = $clicks[$i] ?? 0;
                }
                break;

            case 'All':
            default:
                $clicks = $query->select(
                    DB::raw('YEAR(created_at) as label'),
                    DB::raw('COUNT(*) as count')
                )
                ->groupBy(DB::raw('YEAR(created_at)'))
                ->orderBy('label')
                ->pluck('count', 'label')
                ->toArray();

                foreach ($clicks as $year => $count) {
                    $labels[] = $year;
                    $data[] = $count;
                }
                break;
        }
        return [
            'labels' => $labels,
            'data' => $data
        ];
    }
public function clicksAndLeads(Request $request)
    {
        $data = [
            'labels' => [],
            'orders' => [],
            'clicks' => [],
        ];

        try {
            $clicks = $this->ProductClicksInsights($request);
            $orders = $this->ProductTransactionsInsights($request);

            $data = [
                'labels' => $clicks['labels'] ?? [],
                'orders' => $orders['data'] ?? [],
                'clicks' => $clicks['data'] ?? [],
            ];

        } catch (\Throwable $e) {
            // Log::error($e->getMessage());
        }

        return $data;

    }
public function ProductClicksInsights(Request $request)
    {
        $filter = $request->input('filter');
        $userId = auth()->id();
        $query = PMMProductClick::query()->when(!is_admin(), function ($q2) {
            $q2->where(function ($q3) {
                $q3->where('user_id', auth_user_id())
                    ->orWhereHas('link.product', function ($q) {
                        $q->where('user_id', auth_user_id());
                    });
            });
        });

        $data = [];
        $labels = [];

        switch ($filter) {
            case 'Today':
            case 'Yesterday':
                $date = $filter === 'Today' ? now() : now()->subDay();
                $query->whereDate('created_at',$date);

                $clicks = $query->select(
                    DB::raw('HOUR(created_at) as label'),
                    DB::raw('COUNT(*) as count')
                )
                ->groupBy(DB::raw('HOUR(created_at)'))
                ->pluck('count', 'label')
                ->toArray();
                for ($i = 0; $i < 24; $i++) {
                    $labels[] = $i . ':00';
                    $data[] = $clicks[$i] ?? 0;
                }
                break;

            case 'Monthly':
            case 'Previous Month':
                $date = $filter === 'Monthly' ? now() : now()->subMonth();
                $query->whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year);

                $clicks = $query->select(
                    DB::raw('DAY(created_at) as label'),
                    DB::raw('COUNT(*) as count')
                )
                ->groupBy(DB::raw('DAY(created_at)'))
                ->pluck('count', 'label')
                ->toArray();

                $daysInMonth = now()->daysInMonth;
                for ($i = 1; $i <= $daysInMonth; $i++) {
                    $labels[] = $i;
                    $data[] = $clicks[$i] ?? 0;
                }
                break;

            case 'Yearly':
            case 'Previous Year':
                $date = $filter === 'Yearly' ? now() : now()->subYear();
                $query->whereYear('created_at',$date->year);

                $clicks = $query->select(
                    DB::raw('MONTH(created_at) as label'),
                    DB::raw('COUNT(*) as count')
                )
                ->groupBy(DB::raw('MONTH(created_at)'))
                ->pluck('count', 'label')
                ->toArray();

                $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                        'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

                foreach (range(1, 12) as $i) {
                    $labels[] = $months[$i - 1];
                    $data[] = $clicks[$i] ?? 0;
                }
                break;

            case 'All':
            default:
                $clicks = $query->select(
                    DB::raw('YEAR(created_at) as label'),
                    DB::raw('COUNT(*) as count')
                )
                ->groupBy(DB::raw('YEAR(created_at)'))
                ->orderBy('label')
                ->pluck('count', 'label')
                ->toArray();

                foreach ($clicks as $year => $count) {
                    $labels[] = $year;
                    $data[] = $count;
                }
                break;
        }
        return [
            'labels' => $labels,
            'data' => $data
        ];
    }


public function LedgerInsights(Request $request)
    {
            $filter = $request->input('filter');
            $query = (new LedgerController())->process()
            ->when(!is_admin(), function ($q2) {
            $q2->where('user_id', auth_user_id());
        });

            $labels = [];
            $data = [];

            switch ($filter) {
                case 'Today':
                case 'Yesterday':
                    $date = $filter === 'Today' ? now() : now()->subDay();
                    $query->whereDate('created_at', $date);

                    $result = $query->selectRaw('HOUR(created_at) as label, SUM(credit) as total')
                        ->groupBy(DB::raw('HOUR(created_at)'))
                        ->pluck('total', 'label')
                        ->toArray();

                    for ($i = 0; $i < 24; $i++) {
                        $labels[] = $i . ':00';
                        $data[] = $result[$i] ?? 0;
                    }
                    break;

                case 'Monthly':
                case 'Previous Month':
                    $date = $filter === 'Monthly' ? now() : now()->subMonth();
                    $query->whereMonth('created_at', $date->month)
                        ->whereYear('created_at',$date->year);

                    $result = $query->selectRaw('DAY(created_at) as label, SUM(credit) as total')
                        ->groupBy(DB::raw('DAY(created_at)'))
                        ->pluck('total', 'label')
                        ->toArray();

                    $daysInMonth = now()->daysInMonth;
                    for ($i = 1; $i <= $daysInMonth; $i++) {
                        $labels[] = $i;
                        $data[] = $result[$i] ?? 0;
                    }
                    break;

                case 'Yearly':
                case 'Previous Year':
                    $date = $filter === 'Yearly' ? now() : now()->subYear();
                    $query->whereYear('created_at', $date->year);

                    $result = $query->selectRaw('MONTH(created_at) as label, SUM(credit) as total')
                        ->groupBy(DB::raw('MONTH(created_at)'))
                        ->pluck('total', 'label')
                        ->toArray();

                    $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

                    foreach (range(1, 12) as $i) {
                        $labels[] = $months[$i - 1];
                        $data[] = $result[$i] ?? 0;
                    }
                    break;

                case 'All':
                default:
                    $result = $query->selectRaw('YEAR(created_at) as label, SUM(credit) as total')
                        ->groupBy(DB::raw('YEAR(created_at)'))
                        ->orderBy('label')
                        ->pluck('total', 'label')
                        ->toArray();

                    foreach ($result as $year => $total) {
                        $labels[] = $year;
                        $data[] = $total;
                    }
                    break;
            }

            return [
                'labels' => $labels,
                'data' => $data
            ];
    }

}
