<?php

use App\Http\Controllers\PMM\Product\PMMProductController;
use App\Models\appcountry;
use App\Models\AppLog;
use App\Models\telpaybill;
use App\Models\User;
use App\Models\companyBillsFile;
use App\Models\MyRole\MyRole;
use App\Models\MyRole\MyUserRole;
use App\Models\Payment\Payment;
use App\Models\Payments\Ledger;
use App\Models\PMM\AffiliateLink\PMMAffiliateLink;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

if (!function_exists('app_getStatusColor')) {
    function app_getStatusColor($status) {
        switch ($status) {
            case 'pending':
                return 'warning';
            case 'In Progress':
                return 'info';
            case 'Completed':
                return 'success';
            case 'In Review':
                return 'secondary';
            case 'Cancelled':
                return 'danger';
            case 'inactive':
                return 'danger';
            case 'Rejected':
                return 'danger';
            default:
                return 'info';
        }
    }
}
if ( ! function_exists('get_comebackurl_link')){
    function get_comebackurl_link($payment_id)
    {
      $payment=Payment::find($payment_id);
      $domain=$payment->link->customdomain;
     $url=(!empty($domain->domain) && $domain->order_comeback == 'true')
                                            ? $domain->domain.'/sell/'.product_encrypt($payment->link->product_id)
                                            : affiliate_link($payment->user_id, $payment->link->product_id);
     return $url.'?trans_ref='.unique_encrypt($payment_id);
    }
}
if ( ! function_exists('get_affiliate_link')){
    function get_affiliate_link($user_id,$product_id)
    {

      return PMMAffiliateLink::where(
            [
                'user_id'    => $user_id,
                'product_id' => $product_id,
            ]
        )->first();
    }
}
if ( ! function_exists('affiliate_link')){
    function affiliate_link($user_id,$product_id)
    {

        $al = PMMAffiliateLink::updateOrCreate(
            [
                'user_id'    => $user_id,
                'product_id' => $product_id,
            ],
            [
                'created_by_id' => $user_id,
                'status'        => 'active',
            ]
        );

       return route('pmm.product.purchase',product_encrypt($al->id));
    }
}
if ( ! function_exists('theme_url')){
    function theme_url()
    {
       return "frontend.themes.eshoper.";
    }
}
if ( ! function_exists('product_encrypt')){
    function product_encrypt($id)
    {
       return $id*343556;
    }
}
if ( ! function_exists('product_decrypt')){
    function product_decrypt($id)
    {
       return $id/343556;
    }
}
if ( ! function_exists('app_log')){
    function app_log($user_id,$type,$reference,$description,$payload)
    {
       AppLog::create([
        'reference'=>$reference,
        'type'=>$type,
        'user_id'=>$user_id,
        'description'=>$description,
        'payload'=>json_encode($payload)
       ]);
    }
}
if ( ! function_exists('get_user_id')){
    function get_user_id()
    {
        $user_id=null;
        if(request_type()=='api')
        {
          $user_id=get_user_by_api_key()->id;
        }
        elseif(auth()->check())
        {
            $user_id=auth()->user()->id;
        }
        return $user_id;
    }
}
if ( ! function_exists('auth_user_id')){
    function auth_user_id()
    {
       return auth()->user()->id;
    }
}
if (!function_exists('is_has_role')) {
    function is_has_role($role_unique_key)
    {
        $user = auth()->user();
        if (!$user) return false;

        $role = MyRole::where('unique_key', $role_unique_key)->first();

        if (!$role) return false;

        return MyUserRole::where('my_role_id', $role->id)
                         ->where('user_id', $user->id)
                         ->exists();
    }
}
if ( ! function_exists('is_has_permission')){
    function is_has_permission($permissions)
    {
        $has_permission=false;
        $or_permissions=explode('|',$permissions);
        $and_permissions=explode('&',$permissions);
        $operator='none';
        $md_permissions=[];
        if(count($and_permissions)>1)
        {
            $operator='and';
            $md_permissions=$and_permissions;
        }
        elseif(count($or_permissions)>1)
        {
            $operator='or';
            $md_permissions=$or_permissions;
        }else
        {
            $md_permissions=[$permissions];
            $operator='and';
        }
        if(my_has_permission($md_permissions,$operator))
        {
            $has_permission=true;
        }
        return $has_permission;
    }
}
if ( ! function_exists('my_permissions')){
    function my_permissions($user_id=null,$group=null,$force_query=null)
    {
        if(!$user_id)
        {
            $user_id=auth()->user()->id;
        }
        $root_user_permissions=set_user_permissions(root_user_id(),$group,$force_query);
        $permissions=set_user_permissions($user_id,$group,$force_query);
        $common_permissions = array_uintersect($root_user_permissions, $permissions, function ($a, $b) {
            return strcmp($a['slug'], $b['slug']);
        });
        return $common_permissions;
    }
}
if ( ! function_exists('set_user_permissions')){
    function set_user_permissions($user_id=null,$group=null,$force_query=null)
    {
        $permissions=cache_get('user_'.$user_id.'_permissions');
        if($permissions && empty($force_query))
        {
            return $permissions;
        }
        $my_roles=\App\Models\MyRole\MyUserRole::where('user_id',$user_id)->pluck('my_role_id');
        $permissions=\App\Models\MyRole\MyRolePermissions::where(function($query)use($my_roles,$user_id){
            $query->whereIn('my_role_permissions.my_role_id',$my_roles)
            ->orWhere('my_role_permissions.user_id',$user_id);
        })
        ->when(!empty($group),function($q2)use($group){
            $q2->where('group',$group);
        })
        ->leftJoin('my_permissions','my_permissions.id','my_role_permissions.my_permission_id')
        ->select('my_permissions.*')
        ->get()->toArray();
        cache_put('user_'.$user_id.'_permissions',$permissions);
        return $permissions;
    }
}
if ( ! function_exists('my_has_permission')){
    function my_has_permission($required_permissions,$operator='and')
    {

        $user_id=get_user_id();
        $has_permission=false;
        if(is_admin($user_id))
        {
            return true;
        }
        $my_permissions=my_permissions($user_id,null);
        $slugs = array_column($my_permissions, 'slug');
       if($operator=='and')
       {
        $has_permission = !array_diff($required_permissions, $slugs);
       }
       elseif($operator=='or')
       {
        $has_permission = (bool) array_intersect($required_permissions, $slugs);
       }
       return $has_permission;
    }
}
if ( ! function_exists('request_type')){
    function request_type()
    {
        $type='web';
        if(request()->header("api-key"))
        {
            $type='api';
        }
        return $type;
    }
}
if ( ! function_exists('root_user_id')){
    function root_user_id($user=false)
    {
        $user_id=null;
        $auth_user_id=null;
        if(request_type()=='api')
        {
            $auth_user_id=get_user_by_api_key()->id;
        }
        else if(request_type()=='web' && auth()->check())
        {
            $auth_user_id=auth()->user()->id;
        }
        $auth_user=User::find($auth_user_id);
        if($auth_user)
        {
            if($auth_user->type=="User")
            {
              $user_id=$auth_user->root_user_id;
            }else
            {
              $user_id=$auth_user->id;
            }
        }
        if($user)
        {
            return $auth_user;
        }

        return $user_id;
    }

}
if ( ! function_exists('cache_put')){
    function cache_put($key,$data)
    {
        Cache::put($key,json_encode($data));
    }
}

if ( ! function_exists('cache_get')){
    function cache_get($key)
    {
        return json_decode(Cache::get($key),true);
    }
}
if ( ! function_exists('encrypt_client_id')){
    function encrypt_client_id($id)
    {

        try{
            if (!ctype_digit((string)$id) && !is_int($id)) {
                return false;
            }
        return $id*21212121;
        }
        catch(\Exception $e){
            Log::channel('error_log')->error($e->getMessage());
            Log::channel('error_log')->error($e->getCode());
            Log::channel('error_log')->error($e);
            return false;
        }
    }

}
if ( ! function_exists('decrypt_client_id')){
    function decrypt_client_id($id)
    {
        try{
            if (!ctype_digit((string)$id) && !is_int($id)) {
                return false;
            }
            return $id/21212121;
        }catch(\Exception $e){
            Log::channel('error_log')->error($e->getMessage());
            Log::channel('error_log')->error($e->getCode());
            Log::channel('error_log')->error($e);
            return false;
        }
    }
}
if ( ! function_exists('app_notifications')) {
    function app_notifications()
    {

        $data['bar'] = \App\Models\appnotification::where(['deleted_at' => null,'app'=>'Merchant','is_expired'=>'false', 'place' => 'home_page_top_bar','status'=>'Active'])
            ->where(function ($q){
                $q->where('end_time','>',time_now());
                $q->orWhere('end_time','=',null);
            })
            ->where(function ($q){
                $q->where('start_time','=',time_now());
                $q->orWhere('start_time','<',time_now());

            })->latest()->first();
        $data['dashboard_inner'] = \App\Models\appnotification::where(['deleted_at' => null,'app'=>'Merchant','is_expired'=>'false','place'=>'dashboard_inner_container','status'=>'Active'])
            ->where(function ($q){
                $q->where('end_time','>',time_now());
                $q->orWhere('end_time','=',null);
            })
            ->where(function ($q){
                $q->where('start_time','=',time_now());
                $q->orWhere('start_time','<',time_now());

            })->latest()->first();
        return $data;
    }
}
if ( ! function_exists('VC_pending_query')){
    function VC_pending_query($user=null)
    {
    if($user==null)
    {
       $user=auth()->user();
    }
        $item=\App\Models\VCQuery::where('user_id',$user->id)->latest()->first();
        return $item;
    }

}
if ( ! function_exists('app_file_get_contents')){
    function app_file_get_contents($url,$user_include_path=false,$stream_context=null,$defualt_url=null)
    {
        if($defualt_url==null)
        {
            $defualt_url=public_path('images/default.png');
        }
        if(!$stream_context)
        {
            $stream_context = stream_context_create([
                "ssl" => [
                    "verify_peer" => false,
                    "verify_peer_name" => false
                ]
            ]);
         }

         $url=file_exists(public_path($url))?public_path($url):$defualt_url;
        return file_get_contents($url,$user_include_path,$stream_context);
    }

}
if ( ! function_exists('app_file_put_contents')){
    function app_file_put_contents($path,$content,$user_include_path=false,$stream_context=null)
    {
        if(!$stream_context)
        {
            $stream_context = stream_context_create([
                "ssl" => [
                    "verify_peer" => false,
                    "verify_peer_name" => false
                ]
            ]);
        }


        return file_put_contents($path,$content,$user_include_path,$stream_context);
    }

}
if ( ! function_exists('is_admin')){
    function is_admin()
    {

        if(auth()->check() && auth()->user()->type=='admin')
        {

            return true;
        }else
        {
            return false;
        }
    }

}
if ( ! function_exists('referer_commission')){
    function referer_commission()
    {
        return 1;
    }

}
if ( ! function_exists('rolling_account_percentage')){
    function rolling_account_percentage()
    {
        return 25;
    }

}
if ( ! function_exists('my_web')){
    function my_web($user=null)
    {
        $data['logo']=asset('images/logo.png');
        return $data;
    }

}
if ( ! function_exists('get_all_users')){
    function get_all_users()
    {
        return User::where(function($query){
            $query->where('status','Active');
            $query->orWhere('status','approved');
            $query->orWhere('status','');
            $query->orWhere('status',null);
        })->get();
    }

}
if ( ! function_exists('is_user_blocked')){
    function is_user_blocked($user_id)
    {
        try {
            $user=User::find($user_id);
            if($user->status == "Deleted" || $user->status == "Blocked")
            {
                return true;
            }else{
                return false;
            }
        }catch (\Exception $e){
            return true;
        }
    }

}
if ( ! function_exists('encrypt_unique_id')){
    function encrypt_unique_id($id)
    {
        return $id*1232332321;
    }

}
if ( ! function_exists('decrypt_unique_id')){
    function decrypt_unique_id($id)
    {
        return $id/1232332321;
    }

}
if ( ! function_exists('app_get_ip')){
    function app_get_ip($request)
    {
          return $request->ip();
    }
//sdasdasd
}
if ( ! function_exists('withdraw_fund_request')){
    function withdraw_fund_request($user_id)
    {
        if(\App\Models\withdrawfundrequest::where('user_id',$user_id)->where('status','Pending')->exists())
        {
            $re=\App\Models\withdrawfundrequest::where('user_id',$user_id)->where('status','Pending')->first();
            return $re;
        }
        return null;
    }

}
if ( ! function_exists('edit_url')){
    function edit_url($url)
    {
        // $url=str_replace("https","http",$url);
        return $url;
    }

}
if ( ! function_exists('company_dashboard')){
    function company_dashboard($user_id)
    {

        $mont=Carbon::now();
        $start_day=$mont->subDays(1)->toDateString();
        $mont=Carbon::now();
        $end_day=$mont->addDays(1)->toDateString();

        $tb_query=telpaybill::query();

        $data['today_bills']=(clone $tb_query)->where('date',today_date() )->where('status','confirmed')->where('user_id',$user_id)->get()->count();
        $data['total_bill_collected_amount']=(clone $tb_query)->where('user_id',$user_id)->where('status','Collected')->get()->sum('actual_amount');
        $data['total_bill_collected_amount_total']=(clone $tb_query)->where('user_id',$user_id)->where('status','Collected')->get()->sum('total_amount');
        $data['total_bill_files']=companyBillsFile::where('user_id',$user_id)->get()->count();

        $mont=Carbon::now();
        $start_of_year=$mont->startOfYear()->toDateString();
        $end_of_year=$mont->endOfYear()->toDateString();
        // charts
        $created_files=companyBillsFile::where('user_id',$user_id)->get()->count();
        $created_files=$created_files==0?1:$created_files;
        $confirmed_files=companyBillsFile::where('user_id',$user_id)->where('status','confirmed')->get()->count();
        $data['pending_files_count']=companyBillsFile::where('user_id',$user_id)->where('status','Created')->get()->count();
        $data['files_confirmations']=($confirmed_files/$created_files)*100;
        $data['chartMonthlyBills'] =telpaybill::getMonthlyDataWithZeroCounts($start_of_year,$end_of_year,$user_id);




        return $data;

    }

}
if ( ! function_exists('app_get_mac_address')){
    function app_get_mac_address()
    {
        return substr(exec('getmac'), 0, 17);
    }

}
if ( ! function_exists('fill_months')){
    function fill_months($array)
    {

        $months=['January'=>0,'February'=>0,'March'=>0,'April'=>0,'May'=>0,'June'=>0,'July'=>0,'August'=>0,'September'=>0,'October'=>0,'November'=>0,'December'=>0];
        foreach ($array as $a)
        {
            foreach ($months as $x => $val)
            {
                if($a->month==$x)
                {
                    $months[$x]=$a->val;
                }
            }
        }
        return $months;
    }

}
if ( ! function_exists('app_countries')){
    function app_countries($status='Active')
    {

       $app_countries=appcountry::query()->where('status',$status)->get();
       return $app_countries;
    }

}

if ( ! function_exists('get_device_fingerprint')){
    function get_device_fingerprint()
    {

        ?>
        <script>
            // Initialize the agent at application startup.
            var fpPromise = import('https://openfpcdn.io/fingerprintjs/v3')
                .then(FingerprintJS => FingerprintJS.load())

            // Get the visitor identifier when you need it.
            fpPromise
                .then(fp => fp.get())
                .then(result => {
                    // This is the visitor identifier:
                    const visitorId = result.visitorId
                    document.cookie = "visitorId = " + visitorId ;
                    console.log(document.cookie);

                })
            //asdasdasasdas
        </script>

<?php
        $val=null;
        try {
            if(isset($_COOKIE['visitorId']))
            {
                //aSas
                $val= $_COOKIE['visitorId'];
            }else
            {
                $val=strval(app_get_ip(request()));
            }
        }catch (\Exception $e)
        {
            $val=strval(app_get_ip(request()));
        }
        return $val;
    }

}
if ( ! function_exists('add_entry_in_ledger')){
  function  add_entry_in_ledger($user_id,$added_by,$amount,$type,$currency='CAD'){
          Ledger::create([
            'added_by'=>$added_by,
            'user_id'=>$user_id,
            'amount'=>$amount,
            'type'=>$type,
            'currency'=>$currency,
          ]);
    }
}
