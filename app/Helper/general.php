<?php

use App\Http\Controllers\AlertController;
use App\Models\Alert;
use App\Models\APIKey;
use App\Models\BankAccount;
use App\Models\etransfer_transaction;
use App\Models\gateway;
use App\Models\LocBankAccount;
use App\Models\Merchant\merchantOffers;
use App\Models\User;
use App\Models\branch;
use App\Models\Payment\Ledger;
use App\Models\Payment\Payment;
use App\Models\PMM\Order\PMMOrder;
use App\Models\PMM\Withdrawal\PMMWithdrawal;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Stripe\PaymentIntent;
use Stripe\Stripe;

if ( ! function_exists('create_stripe_payment_url')){
    function create_stripe_payment_url($amount,$currency,$type,$user_id,$reference_type,$reference,$product_name="Amount")
    {
        $payment=Payment::create([
            'amount'=>$amount,
            'currency'=>$currency,
            'type'=>$type,
            'user_id'=>$user_id,
            'reference_type'=>$reference_type,
            'reference'=>$reference,
            ]);
            $order=PMMOrder::create([
                'payment_id'=>$payment->id,
                'cc_status'=>"Pending"
            ]);
        $success_url=route('stripe.success_url',product_encrypt($payment->id));
        $cancel_url=route('stripe.cancel_url',product_encrypt($payment->id));

        $stripe = new \Stripe\StripeClient(config('services.Stripe.sk_key'));
         $amount_in_cents=dollar_to_cents($amount);
         $c_in_cents=dollar_to_cents($amount);
         ///asdasd
         $checkout_session = $stripe->checkout->sessions->create([
             'line_items' => [[
                 'price_data' => [
                     'currency' => $currency,
                     'product_data' => [
                         'name' =>$product_name,
                     ],
                     'unit_amount' =>$amount_in_cents ,
                 ],
                 'quantity' => 1,
             ]],
             'mode' => 'payment',
             'success_url' => $success_url,
             'cancel_url' => $cancel_url,
         ]);
         $payment->update(['stripe_session_id' => $checkout_session->id]);
         $payment_url= $checkout_session->url;

         return ['url'=>$payment_url,'id'=>$payment->id];

    }
}
if ( ! function_exists('create_stripe_payment_intent')){
    function create_stripe_payment_intent($amount,$currency,$type,$user_id,$reference_type,$reference,$product_name="Amount")
    {

        $ck_amount=0;
        $ck_currency='usd';
        $payment=Payment::create([
            'amount'=>$amount,
            'currency'=>$currency,
            'type'=>$type,
            'user_id'=>$user_id,
            'reference_type'=>$reference_type,
            'reference'=>$reference,
            ]);
        $order=PMMOrder::create([
                'payment_id'=>$payment->id,
                'cc_status'=>"Pending"
            ]);
         Stripe::setApiKey(config('services.Stripe.sk_key'));
           $ck_amount=dollar_to_cents($amount);
           $ck_currency='usd';
        
         ///asdasd
         $paymentIntent = PaymentIntent::create([
            'amount' => $ck_amount, // $10.00 in cents
            'currency' => $ck_currency,
        ]);
         $payment->update(['stripe_intent_id' =>$paymentIntent->id]);
         return ['intent_id'=>$paymentIntent->id,'client_secret'=>$paymentIntent->client_secret,'id'=>$payment->id];

    }
}
if ( ! function_exists('create_paysight_payment_intent')){
    function create_paysight_payment_intent($amount,$currency,$type,$user_id,$reference_type,$reference,$product_name="Amount")
    {

        $ck_amount=0;
        $ck_currency='usd';
        $payment=Payment::create([
            'amount'=>$amount,
            'currency'=>$currency,
            'type'=>$type,
            'user_id'=>$user_id,
            'reference_type'=>$reference_type,
            'reference'=>$reference,
            ]);
        $order=PMMOrder::create([
                'payment_id'=>$payment->id,
                'cc_status'=>"Pending"
            ]);
       
         return ['id'=>$payment->id];

    }
}
if ( ! function_exists('my_balance')) {
    function my_balance($user_id)
    {


        $data['available'] = 0;
        $data['pending'] = 0;
        $data['credit'] = 0;
        $data['debit'] = 0;

        // All credits
        $data['credit'] = Ledger::when(!is_admin(),function($iq)use($user_id){
            $iq->where('user_id', $user_id);
        })->sum('credit');

        // Credits added in the last 15 days (pending)
        $data['pending'] = Ledger::when(!is_admin(),function($iq)use($user_id){
            $iq->where('user_id', $user_id);
        })
            ->where('created_at', '>=', Carbon::now()->subDays(15))
            ->sum('credit');

        // Credits older than 15 days (eligible for withdrawal)
        $data['credit_except_last_15_days'] = Ledger::when(!is_admin(),function($iq)use($user_id){
            $iq->where('user_id', $user_id);
        })
            ->where('created_at', '<', Carbon::now()->subDays(15))
            ->sum('credit');

        // Debits
        $data['debit'] = Ledger::when(!is_admin(),function($iq)use($user_id){
            $iq->where('user_id', $user_id);
        })->sum('debit');
        $data['pending_withdrawal'] = PMMWithdrawal::when(!is_admin(),function($iq)use($user_id){
            $iq->where('user_id', $user_id);
        })->Where('status','Pending')->sum('amount');

        // Available = credit older than 15 days - all debits
        $data['available'] = $data['credit_except_last_15_days'] - $data['debit']-$data['pending_withdrawal'];

        return $data;

    }
//asdasd
}
if ( ! function_exists('card_usage_max_count')) {
    function card_usage_max_count()
    {
 return 3;

    }
//asdasd
}

if (!function_exists('user_balance')) {
    function user_balance($user_id)
    {
        $ledger = App\Models\HolderLedger::where('user_id', $user_id)
            ->where('status', 'Completed') // Only consider completed transactions
            ->get();

        $total_credit = $ledger->where('type', 'credit')->sum('amount');
        $total_debit = $ledger->where('type', 'debit')->sum('amount');

        $connects_credit = $ledger->where('type', 'credit')->sum('connects');
        $connects_debit = $ledger->where('type', 'debit')->sum('connects');

        return [
            'balance' => $total_credit - $total_debit,
            'connects' => $connects_credit - $connects_debit
        ];
    }
}

if ( ! function_exists('root_user_id')) {
    function root_user_id()
    {
        return auth()->user()->id;

    }

}
if ( ! function_exists('connects_to_amount')) {
    function connects_to_amount($connects)
    {
        return $connects/66667;

    }
}
if ( ! function_exists('amount_to_connects')) {
    function amount_to_connects($amount)
    {
        return $amount*66667;

    }
}
if ( ! function_exists('no_reply_email')) {
    function no_reply_email()
    {
        return 'g.ramabaja@gmail.com';

    }

}
if ( ! function_exists('zpayd_format_date')) {
    function zpayd_format_date($date,$format)
    {
        return Carbon::parse($date)->format($format);

    }

}
if ( ! function_exists('get_ip_details')) {
    function get_ip_details($ip)
    {
        $ipdat = @json_decode(file_get_contents(
            "http://www.geoplugin.net/json.gp?ip=" .$ip));
      return $ipdat;

    }

}
if ( ! function_exists('get_user_by_id')) {
    function get_user_by_id($id)
    {
      return User::find($id);

    }

}
if ( ! function_exists('system_detail')) {
    function system_detail()
    {

//asdasdasdasdadas



        $mont1=Carbon::parse(time_now());
        $start_of_all=$mont1->subYears(10)->startOfMonth()->toDateString();
        $end_of_all=$mont1->addYears(10)->endOfMonth()->toDateString();

        $mont2=Carbon::parse(time_now());
        $start_of_month=$mont2->startOfMonth()->toDateString();
        $end_of_month=$mont2->endOfMonth()->toDateString();

        $mont3=Carbon::parse(time_now());
        $start_of_year=$mont3->startOfYear()->toDateString();
        $end_of_year=$mont3->endOfYear()->toDateString();

        $mont4=Carbon::parse(time_now());
        $start_of_day=$mont4->toDateString();
        $end_of_day=$mont4->addDays(10)->toDateString();

        $mont5=Carbon::parse(time_now());
        $start_of_week=$mont5->subDays(7)->toDateString();
        $end_of_week=$mont4->toDateString();

        if(\session('state_duration')=='monthly')
        {
            $start=$start_of_month;
            $end=$end_of_month;
        }else if(\session('state_duration')=='yearly')
        {
            $start=$start_of_year;
            $end=$end_of_year;
        }
        else if(\session('state_duration')=='all')
        {

            $start=$start_of_all;
            $end=$end_of_all;
        }else if(\session('state_duration')=='weekly')
        {
            $start=$start_of_week;
            $end=$end_of_week;

        }else
        {
            $start=$start_of_day;

            $end=$end_of_day;
            //dd($start.'-'.$end);

        }

///asdasdasdsdfsdfsdfasdasd

            if(auth()->user()->hasRole("admin"))
            {
                $data['cases_count']=\App\Models\MerchantCase::query()->where('deleted_at',null)->whereBetween('created_at',[$start,$end])->get()->count();
                $data['users_total']=\App\Models\Merchant\merchantCompany::where('deleted_at',null)->whereBetween('created_at',[$start,$end])->get()->count();
                $data['companies_total']=branch::where('deleted_at',null)->whereBetween('created_at',[$start,$end])->get()->count();
                $data['approved_offers']=merchantOffers::where('status','APPROVED')->whereBetween('created_at',[$start,$end])->get();
                $data['cards_collected_revenue_usd']=0;
                $data['cards_collected_revenue_cad']=0;
                $data['cards_collected_revenue_eur']=0;
                foreach ($data['approved_offers'] as $item)
                {
                    $commission_amount=($item->amount/100)*$item->commission;
                    if ($item->currency=='USD')
                    {
                        $data['cards_collected_revenue_usd']=$data['cards_collected_revenue_usd']+$commission_amount;
                    }
                    if ($item->currency=='EUR')
                    {
                        $data['cards_collected_revenue_eur']=$data['cards_collected_revenue_eur']+$commission_amount;
                    }
                    if ($item->currency=='CAD')
                    {
                        $data['cards_collected_revenue_cad']=$data['cards_collected_revenue_cad']+$commission_amount;
                    }
                }
            }
   $data['upcoming_payments_count']=merchantOffers::where('is_upcomming_cleared','false')->whereBetween('created_at',[$start,$end])->where('status','APPROVED')->get()->count();





        $data['approved_offers_count']=merchantOffers::where('status','APPROVED')->whereBetween('created_at',[$start,$end])->get()->count();
        $data['pending_offers_count']=merchantOffers::where('status','zPAYD-Started')->whereBetween('created_at',[$start,$end])->get()->count();
        $data['created_offers_count']=merchantOffers::whereBetween('created_at',[$start,$end])->get()->count();

//sdfsdf
        $data['merchant_deposit_sent_cad']=\App\Models\aptpaysendpayment::where('status','APPROVED')->whereBetween('created_at',[$start,$end])->get()->sum('sent_cad');
        $data['merchant_deposit_recieved_cad']=\App\Models\aptpaysendpayment::where('status','APPROVED')->whereBetween('created_at',[$start,$end])->get()->sum('amount');

        $data['merchant_deposit_approved']=\App\Models\aptpaysendpayment::where('status','APPROVED')->whereBetween('created_at',[$start,$end])->get()->sum('amount');
        $data['merchant_deposit_pending']=\App\Models\aptpaysendpayment::where(function ($q){
            $q->where('status','zPAYD-Started');
            $q->orWhere('status','Started');
        })->where('type','INTERAC')->whereBetween('created_at',[$start,$end])->get()->sum('amount');


        $data['merchant_deposit_sent_interac']=\App\Models\aptpaysendpayment::where('status','APPROVED')->whereBetween('created_at',[$start,$end])->where('type','INTERAC')->get()->sum('amount');
        $data['merchant_deposit_pending_interac']=\App\Models\aptpaysendpayment::where(function ($q){
            $q->where('status','zPAYD-Started');
            $q->orWhere('status','Started');
        })->where('type','INTERAC')->whereBetween('created_at',[$start,$end])->get()->sum('amount');
        $data['merchant_deposit_sent_eft']=\App\Models\aptpaysendpayment::where('status','APPROVED')->whereBetween('created_at',[$start,$end])->where('type','EFT')->get()->sum('amount');
        $data['merchant_deposit_pending_eft']=\App\Models\aptpaysendpayment::where(function ($q){
            $q->where('status','zPAYD-Started');
            $q->orWhere('status','Started');
        })->where('type','EFT')->whereBetween('created_at',[$start,$end])->get()->sum('amount');



        $data['offers_graph_data']= \App\Models\Merchant\merchantOffers::select(DB::raw("(COUNT(*)) as val"),DB::raw("MONTHNAME(created_at) as month"))
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->latest()
            ->get();
        $data['offers_graph_data']=fill_months($data['offers_graph_data']);
        return $data;
    }

}
if ( ! function_exists('convert_image_to_base64')) {
    function convert_image_to_base64($path)
    {

        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $base64;

    }

}

if ( ! function_exists('unique_encrypt')) {
    function unique_encrypt($id)
    {
        return $id*123112;

    }

}
if ( ! function_exists('unique_decrypt')) {
    function unique_decrypt($id)
    {
        return $id/123112;

    }

}
if ( ! function_exists('admin_otp_verification_phone')) {
    function admin_otp_verification_phone()
    {
        //return '+923417414093';
        return '+15198319871';
        ///asdasdasd

    }

}
if ( ! function_exists('default_contact_email')) {
    function default_contact_email()
    {
        //return '+923417414093';
        return 'bill@merchant.zpayd.com';
        ///asdasdasd

    }

}
if ( ! function_exists('send_instant_message')) {
    function send_instant_message($email,$subject,$greeting,$message)
    {
        $tempData['subject']=$subject;
        $tempData['message']=$message;
        $tempData['greeting']=$greeting;
        Notification::route('mail',$email)->notify(new \App\Notifications\InstantMessage($tempData));

    }

}
if ( ! function_exists('send_system_alert')) {
    function send_system_alert($subject,$greeting,$message)
    {
        //das
        $receiver=get_list_date('admin_mails_receivers','emergency-system-alerts-receiver');
        $tempData['subject']=$subject;
        $tempData['message']=$message;
        $tempData['greeting']=$greeting;


        if($receiver)
        {
            $receiver=$receiver->first();
            Notification::route('mail',$receiver->value)->notify(new \App\Notifications\systemAlertNotification($tempData));

        }
        // Notification::route('mail','yousaf.zpayd@gmail.com')->notify(new \App\Notifications\systemAlertNotification($tempData));

    }

}



if ( ! function_exists('card_usage_count_today')) {
    function card_usage_count_today($card_number)
    {

       $count=0;

       $offers=\App\Models\Merchant\merchantOffers::all();
        foreach ($offers as $of)
        {
            $date=Carbon::parse($of->created_at)->timezone(Config::get('app.timezone'))->format('Y-m-d');

            if ($of->card_number!=null && decrypt($of->card_number)==$card_number && $date==today_date())
            {
                $count++;
            }
        }
return $count;
    }
}
if ( ! function_exists('countries_list')) {
    function countries_list()
    {
        $countries_list = array(
            "AF" => "Afghanistan",
            "AX" => "Aland Islands",
            "AL" => "Albania",
            "DZ" => "Algeria",
            "AS" => "American Samoa",
            "AD" => "Andorra",
            "AO" => "Angola",
            "AI" => "Anguilla",
            "AQ" => "Antarctica",
            "AG" => "Antigua and Barbuda",
            "AR" => "Argentina",
            "AM" => "Armenia",
            "AW" => "Aruba",
            "AU" => "Australia",
            "AT" => "Austria",
            "AZ" => "Azerbaijan",
            "BS" => "Bahamas",
            "BH" => "Bahrain",
            "BD" => "Bangladesh",
            "BB" => "Barbados",
            "BY" => "Belarus",
            "BE" => "Belgium",
            "BZ" => "Belize",
            "BJ" => "Benin",
            "BM" => "Bermuda",
            "BT" => "Bhutan",
            "BO" => "Bolivia",
            "BQ" => "Bonaire, Sint Eustatius and Saba",
            "BA" => "Bosnia and Herzegovina",
            "BW" => "Botswana",
            "BV" => "Bouvet Island",
            "BR" => "Brazil",
            "IO" => "British Indian Ocean Territory",
            "BN" => "Brunei Darussalam",
            "BG" => "Bulgaria",
            "BF" => "Burkina Faso",
            "BI" => "Burundi",
            "KH" => "Cambodia",
            "CM" => "Cameroon",
            "CA" => "Canada",
            "CV" => "Cape Verde",
            "KY" => "Cayman Islands",
            "CF" => "Central African Republic",
            "TD" => "Chad",
            "CL" => "Chile",
            "CN" => "China",
            "CX" => "Christmas Island",
            "CC" => "Cocos (Keeling) Islands",
            "CO" => "Colombia",
            "KM" => "Comoros",
            "CG" => "Congo",
            "CD" => "Congo, the Democratic Republic of the",
            "CK" => "Cook Islands",
            "CR" => "Costa Rica",
            "CI" => "Cote D'Ivoire",
            "HR" => "Croatia",
            "CU" => "Cuba",
            "CW" => "Curacao",
            "CY" => "Cyprus",
            "CZ" => "Czech Republic",
            "DK" => "Denmark",
            "DJ" => "Djibouti",
            "DM" => "Dominica",
            "DO" => "Dominican Republic",
            "EC" => "Ecuador",
            "EG" => "Egypt",
            "SV" => "El Salvador",
            "GQ" => "Equatorial Guinea",
            "ER" => "Eritrea",
            "EE" => "Estonia",
            "ET" => "Ethiopia",
            "FK" => "Falkland Islands (Malvinas)",
            "FO" => "Faroe Islands",
            "FJ" => "Fiji",
            "FI" => "Finland",
            "FR" => "France",
            "GF" => "French Guiana",
            "PF" => "French Polynesia",
            "TF" => "French Southern Territories",
            "GA" => "Gabon",
            "GM" => "Gambia",
            "GE" => "Georgia",
            "DE" => "Germany",
            "GH" => "Ghana",
            "GI" => "Gibraltar",
            "GR" => "Greece",
            "GL" => "Greenland",
            "GD" => "Grenada",
            "GP" => "Guadeloupe",
            "GU" => "Guam",
            "GT" => "Guatemala",
            "GG" => "Guernsey",
            "GN" => "Guinea",
            "GW" => "Guinea-Bissau",
            "GY" => "Guyana",
            "HT" => "Haiti",
            "HM" => "Heard Island and Mcdonald Islands",
            "VA" => "Holy See (Vatican City State)",
            "HN" => "Honduras",
            "HK" => "Hong Kong",
            "HU" => "Hungary",
            "IS" => "Iceland",
            "IN" => "India",
            "ID" => "Indonesia",
            "IR" => "Iran, Islamic Republic of",
            "IQ" => "Iraq",
            "IE" => "Ireland",
            "IM" => "Isle of Man",
            "IL" => "Israel",
            "IT" => "Italy",
            "JM" => "Jamaica",
            "JP" => "Japan",
            "JE" => "Jersey",
            "JO" => "Jordan",
            "KZ" => "Kazakhstan",
            "KE" => "Kenya",
            "KI" => "Kiribati",
            "KP" => "Korea, Democratic People's Republic of",
            "KR" => "Korea, Republic of",
            "XK" => "Kosovo",
            "KW" => "Kuwait",
            "KG" => "Kyrgyzstan",
            "LA" => "Lao People's Democratic Republic",
            "LV" => "Latvia",
            "LB" => "Lebanon",
            "LS" => "Lesotho",
            "LR" => "Liberia",
            "LY" => "Libyan Arab Jamahiriya",
            "LI" => "Liechtenstein",
            "LT" => "Lithuania",
            "LU" => "Luxembourg",
            "MO" => "Macao",
            "MK" => "Macedonia, the Former Yugoslav Republic of",
            "MG" => "Madagascar",
            "MW" => "Malawi",
            "MY" => "Malaysia",
            "MV" => "Maldives",
            "ML" => "Mali",
            "MT" => "Malta",
            "MH" => "Marshall Islands",
            "MQ" => "Martinique",
            "MR" => "Mauritania",
            "MU" => "Mauritius",
            "YT" => "Mayotte",
            "MX" => "Mexico",
            "FM" => "Micronesia, Federated States of",
            "MD" => "Moldova, Republic of",
            "MC" => "Monaco",
            "MN" => "Mongolia",
            "ME" => "Montenegro",
            "MS" => "Montserrat",
            "MA" => "Morocco",
            "MZ" => "Mozambique",
            "MM" => "Myanmar",
            "NA" => "Namibia",
            "NR" => "Nauru",
            "NP" => "Nepal",
            "NL" => "Netherlands",
            "AN" => "Netherlands Antilles",
            "NC" => "New Caledonia",
            "NZ" => "New Zealand",
            "NI" => "Nicaragua",
            "NE" => "Niger",
            "NG" => "Nigeria",
            "NU" => "Niue",
            "NF" => "Norfolk Island",
            "MP" => "Northern Mariana Islands",
            "NO" => "Norway",
            "OM" => "Oman",
            "PK" => "Pakistan",
            "PW" => "Palau",
            "PS" => "Palestinian Territory, Occupied",
            "PA" => "Panama",
            "PG" => "Papua New Guinea",
            "PY" => "Paraguay",
            "PE" => "Peru",
            "PH" => "Philippines",
            "PN" => "Pitcairn",
            "PL" => "Poland",
            "PT" => "Portugal",
            "PR" => "Puerto Rico",
            "QA" => "Qatar",
            "RE" => "Reunion",
            "RO" => "Romania",
            "RU" => "Russian Federation",
            "RW" => "Rwanda",
            "BL" => "Saint Barthelemy",
            "SH" => "Saint Helena",
            "KN" => "Saint Kitts and Nevis",
            "LC" => "Saint Lucia",
            "MF" => "Saint Martin",
            "PM" => "Saint Pierre and Miquelon",
            "VC" => "Saint Vincent and the Grenadines",
            "WS" => "Samoa",
            "SM" => "San Marino",
            "ST" => "Sao Tome and Principe",
            "SA" => "Saudi Arabia",
            "SN" => "Senegal",
            "RS" => "Serbia",
            "CS" => "Serbia and Montenegro",
            "SC" => "Seychelles",
            "SL" => "Sierra Leone",
            "SG" => "Singapore",
            "SX" => "Sint Maarten",
            "SK" => "Slovakia",
            "SI" => "Slovenia",
            "SB" => "Solomon Islands",
            "SO" => "Somalia",
            "ZA" => "South Africa",
            "GS" => "South Georgia and the South Sandwich Islands",
            "SS" => "South Sudan",
            "ES" => "Spain",
            "LK" => "Sri Lanka",
            "SD" => "Sudan",
            "SR" => "Suriname",
            "SJ" => "Svalbard and Jan Mayen",
            "SZ" => "Swaziland",
            "SE" => "Sweden",
            "CH" => "Switzerland",
            "SY" => "Syrian Arab Republic",
            "TW" => "Taiwan, Province of China",
            "TJ" => "Tajikistan",
            "TZ" => "Tanzania, United Republic of",
            "TH" => "Thailand",
            "TL" => "Timor-Leste",
            "TG" => "Togo",
            "TK" => "Tokelau",
            "TO" => "Tonga",
            "TT" => "Trinidad and Tobago",
            "TN" => "Tunisia",
            "TR" => "Turkey",
            "TM" => "Turkmenistan",
            "TC" => "Turks and Caicos Islands",
            "TV" => "Tuvalu",
            "UG" => "Uganda",
            "UA" => "Ukraine",
            "AE" => "United Arab Emirates",
            "GB" => "United Kingdom",
            "US" => "United States",
            "UM" => "United States Minor Outlying Islands",
            "UY" => "Uruguay",
            "UZ" => "Uzbekistan",
            "VU" => "Vanuatu",
            "VE" => "Venezuela",
            "VN" => "Viet Nam",
            "VG" => "Virgin Islands, British",
            "VI" => "Virgin Islands, U.s.",
            "WF" => "Wallis and Futuna",
            "EH" => "Western Sahara",
            "YE" => "Yemen",
            "ZM" => "Zambia",
            "ZW" => "Zimbabwe"
        );
        return $countries_list;

    }
}
if ( ! function_exists('get_country_name_by_code')) {
    function get_country_name_by_code($code)
    {
        $name=$code;
        $countries_list =countries_list();

      foreach ($countries_list as $index => $item)
      {
          if ($index==$code)
          {
            $name=$item;
          }

      }
        return $name;
    }

}

if ( ! function_exists('get_servie_image')) {
    function get_servie_image($service)
    {
        if ($service=='Freshbooks')
        {
            return asset("smallicons/freshbooks.png");
        }
        if ($service=='Quickbooks')
        {
            return asset("smallicons/quickbooks.jpg");
        }
        if ($service=='Xero')
        {
            return asset("smallicons/xero.png");
        }
        if ($service=='Sage')
        {
            return asset("smallicons/sage.png");
        }

    }
}
if ( ! function_exists('dollar_to_cents')){
    function dollar_to_cents($dollars)
    {
        $dollars=round($dollars,2);
        $dollars=$dollars * 100;
        $cents=intval($dollars);
        return $cents;
    }
}
if ( ! function_exists('decode_access_token')) {
    function decode_access_token($token)
    {
        $decoded_token = json_decode(base64_decode(str_replace('_', '/', str_replace('-', '+', explode('.', $token)[1]))));
    return $decoded_token;
    }
}
if ( ! function_exists('default_currency')) {
    function default_currency()
    {
        return 'CAD';
    }
}
if ( ! function_exists('my_wallet_balance')){
    function my_wallet_balance($user_id)
    {
        $user=User::find($user_id);

        $balance=decrypt($user->wallet_balance);

        return $balance;

    }
}

if ( ! function_exists('get_user_api_key')){
    function get_user_by_api_key()
    {
        $user_id=null;
        $user=null;

        if(APIKey::where('api_key',request()->header(config('myconfig.PLATFORM.API_HEADER_PREFIX')."api-key"))->where('user_id',decrypt_client_id(request()->header(config('myconfig.PLATFORM.API_HEADER_PREFIX')."client-id")))->exists())
        {
            $user=APIKey::where('api_key',request()->header(config('myconfig.PLATFORM.API_HEADER_PREFIX')."api-key"))->where('user_id',decrypt_client_id(request()->header(config('myconfig.PLATFORM.API_HEADER_PREFIX')."client-id")))->first();
            $user_id=$user->user_id;
        }

        request()->merge(['api_auth_user_id'=>$user_id]);
        return $user;

    }
}

if ( ! function_exists('get_month_name')){
    function get_month_name($date)
    {
        $name=Carbon::parse($date)->monthName;

        return $name;

    }
}
if ( ! function_exists('add_balance_to_wallet')){
    function add_balance_to_wallet($user_id,$amount,$title="Wallet Debited!",$description='',$is_mail=true,$currency='CAD',$added_by='user')
    {

        //sdasdasdsdsd
        $user=User::find($user_id);
        $old_balance=decrypt($user->wallet_balance);
        $user->wallet_balance=encrypt(floatval(decrypt($user->wallet_balance))+$amount);
        $user->save();
        $new_balance=decrypt($user->wallet_balance);
        \App\Models\wallet_balance_entry::create([
            'currency'=>$currency,
            'amount'=>$amount,
            'added_by'=>$added_by,
            'title'=>$description,
            'user_id'=>$user->id,
            'type'=>'plus',
            'old_balance'=>$old_balance,
            'new_balance'=>$new_balance
        ]);

        if ($description=='')
        {
            $description='You have received payment in the amount of '.$amount.'$. Funds will be processed and send to your account shortly. ';
        }
        //asdasd
        AlertController::create([
            'message'=>$description,
            'title'=>$title,
            'type'=>'fundAddedToWallet',
            'receiver'=>$user_id,
            'sender'=>$user_id
        ]);
        $data['user']=$user;
        $data['subject']=$title;
        $data['message']=$description;
        if ($is_mail)
        {
            Notification::send(User::where('id',$user_id)->get(),new \App\Notifications\globalMessage($data));
        }

        return true;

    }
}

if ( ! function_exists('is_sms_notification_enabled')){
    function is_notification_enabled($user_id,$name,$type)
    {
        $status=false;
        if (\App\Models\notificationSetting::where(['user_id'=>$user_id,'name'=>$name])->exists())
        {
            $notify=\App\Models\notificationSetting::where(['user_id'=>$user_id,'name'=>$name])->first();
            if ($type=='sms' && $notify->sms=='yes')
            {
                $status=true;
            }
            if ($type=='email' && $notify->email=='yes')
            {
                $status=true;
            }
        }
        return $status;

    }
}
if ( ! function_exists('app_controllers')){
    function app_controllers()
    {
        return ['7','110'];
    }
}

if ( ! function_exists('alert_unread_count')){
    function alert_unread_count()
    {
        $data['unread_count']=Alert::where([
            "receiver"=>auth()->user()->id,
            'status'=>'created'
        ])->count();

        return $data['unread_count'];
    }
}
if ( ! function_exists('create_alert')){
    function create_alert($sender,$receiver,$type,$title,$message,$reference=null,$web_url=null,$app_url=null)
    {
        return Alert::create([
            "receiver"=>$receiver,
            "sender"=>$sender,
            "type"=>$type,
            "title"=>$title,
            "message"=>$message,
            "web_url"=>$web_url,
            "app_url"=>$app_url,
            "reference"=>$reference,
            'status'=>'created'
        ]);
    }
}
if ( ! function_exists('myalerts')){
    function myalerts()
    {
        $data=Alert::where([
            "receiver"=>auth()->user()->id,
            'status'=>'created'
        ])->latest()->get();

        return $data;
    }
}
  if ( ! function_exists('app_limit_str')){
    function app_limit_str($str,$length)
    {
         return Str::limit($str, $length);
    }
   }

if ( ! function_exists('date_human_readable')){
    function date_human_readable($date)
    {
        return Carbon::parse($date)
            ->setTimezone(config('app.timezone')) // or 'Asia/Kolkata'
            ->diffForHumans();
    }
}
if (!function_exists('date_time_readable')) {
    function date_time_readable($date)
    {
      return Carbon::parse($date)->setTimezone(config('app.timezone'))->format('F j, Y - H:i');
    }
}
if ( ! function_exists('today_date')){
    function today_date()
    {
        return Carbon::now()->timezone(Config::get('app.timezone'))->format('Y-m-d');
    }
}
if ( ! function_exists('time_now')){
    function time_now()
    {
        return Carbon::now()->timezone(Config::get('app.timezone'))->format('Y-m-d H:i:s');
    }
}
if ( ! function_exists('userNotes')){
    function userNotes($userId)
    {
        if (!\App\Models\userNote::where('user_id',$userId)->exists())
        {
            \App\Models\userNote::create([
                'user_id'=>$userId
            ]);
        }
        return \App\Models\userNote::where('user_id',$userId)->first();
    }
}
if ( ! function_exists('who_is_admin')){
    function who_is_admin()
    {
        return 179;
    }

}
if ( ! function_exists('who_is_support')){
    function who_is_support()
    {
        return 179;
    }

}
if ( ! function_exists('myWallet')){

    function myWallet()
    {
        $data['balance']=auth()->user()->wallet_balance;
return $data;
    }
}
if ( ! function_exists('user_settings')){

    function user_settings($id)
    {
       $user= \App\Models\MyRole\UserSetting::where('user_id',$id)->first();
       return $user;
    }

}
if ( ! function_exists('user_setting')){

    function user_setting($id)
    {
       $user= \App\Models\UserSetting::where('user_id',$id)->first();
       $user->data=User::find($id);
       return $user;
    }

}

if ( ! function_exists('cutNum')) {
    function cutNum($num, $precision = 2)
    {
        return floor($num) . substr(str_replace(floor($num), '', $num), 0, $precision + 1);
    }
}

