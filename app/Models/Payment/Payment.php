<?php

namespace App\Models\Payment;

use App\Models\DataLogs;
use App\Models\Parcel;
use App\Models\PMM\AffiliateLink\PMMAffiliateLink;
use App\Models\PMM\Order\PMMOrder;
use App\Models\User;
use App\Traits\AppTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use  App\Models\PMM\CC\PmmOrderNote;
class Payment extends Model
{
    use AppTrait,HasFactory;

    public $table = 'payments';
    public function user()
    {
       return $this->belongsTo(User::class,'user_id');
    }
    public function notes()
{
    return $this->hasMany(PmmOrderNote::class, 'payment_id', 'id');
}
    public function paymentlogs()
{
    return $this->hasMany(DataLogs::class, 'reference', 'id')->where('type','paysigh-iframe-payment');
}
        public function order()
    {
       return $this->hasOne(PMMOrder::class,'payment_id');
    }
public function link()
{
    return $this->belongsTo(PMMAffiliateLink::class, 'reference', 'id');
}
public function is_double()
{
    if (!$this->id) {
        return false;
    }

    return Payment::where('phone', $this->phone)
        ->whereHas('link', function ($query) {
            $query->where('product_id', $this->link->product_id);
        })
        ->where('id', '<', $this->id) // only older records
        ->exists();
}
public function merchantpayment()
{
    return $this->hasOne(Ledger::class, 'reference', 'id')->where('narration','merchant product sale');
}
public function affiliatecommission()
{
    return $this->hasOne(Ledger::class, 'reference', 'id')->where('narration','affiliate commission');
}

    public static function getMonthlyCompletedPayments($start_of_month, $end_of_month,$user_id)
    {
        $monthlyData = self::query()
            ->whereBetween('created_at', [$start_of_month, $end_of_month])
            ->where('status', 'Completed')
            ->select(DB::raw('SUM(amount) as `amount`'), DB::raw('MONTH(created_at) as `month`'))
            ->groupBy('month')
            ->when(!is_admin(),function($query)use($user_id){
                $query->where('user_id',$user_id);
            })
            ->orderBy('month', 'ASC')
            ->get();

        // Create an array to hold the monthly data
        $data = [];

        // Initialize an array with zero counts for each month
        for ($month = 1; $month <= 12; $month++) {
            $data[$month] = 0;
        }

        // Populate the array with data from the query
        foreach ($monthlyData as $item) {
            $data[$item->month] = $item->amount;
        }

        // Convert the associative array to a numeric array
        $chartMonthlyBills = array_values($data);

        return $chartMonthlyBills;
    }
    public static function getMonthlyPendingPayments($start_of_month, $end_of_month,$user_id)
    {
        $monthlyData = self::query()
            ->whereBetween('created_at', [$start_of_month, $end_of_month])
            ->where('status', 'Pending')
            ->select(DB::raw('SUM(amount) as `amount`'), DB::raw('MONTH(created_at) as `month`'))
            ->groupBy('month')
            ->when(!is_admin(),function($query)use($user_id){
                $query->where('user_id',$user_id);
            })
            ->orderBy('month', 'ASC')
            ->get();

        // Create an array to hold the monthly data
        $data = [];

        // Initialize an array with zero counts for each month
        for ($month = 1; $month <= 12; $month++) {
            $data[$month] = 0;
        }

        // Populate the array with data from the query
        foreach ($monthlyData as $item) {
            $data[$item->month] = $item->amount;
        }

        // Convert the associative array to a numeric array
        $chartMonthlyBills = array_values($data);

        return $chartMonthlyBills;
    }
     public function parcel()
    {
        return $this->hasMany(Parcel::class, 'payment_id');
    }
    public function latestParcel()
    {
        return $this->hasOne(Parcel::class, 'payment_id')->latestOfMany();
    }
    protected $guarded=[];

}
