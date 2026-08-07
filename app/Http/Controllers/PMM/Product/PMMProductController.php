<?php

namespace App\Http\Controllers\PMM\Product;
//aasd
use App\Http\Controllers\Controller;
use App\Http\Controllers\PMM\Transactions\PMMTransactionsController;
use App\Jobs\PMM\Product\PMMProductUpdatedJob;
use App\Models\AppLog;
use App\Models\HR\Post\HRPost;
use App\Models\MyRole\UserSetting;
use App\Models\UppSell;
use App\Models\Payment\Payment;
use App\Models\PM\Project\PMMyTask;
use App\Models\PM\Project\PMpost;
use App\Models\PMM\Affiliate\PMMAffiliate;
use App\Models\PMM\AffiliateLink\PMMAffiliateLink;
use App\Models\PMM\Product\PMMProduct;
use App\Models\PMM\Product\PMMProductClick;
use App\Models\PMM\Product\PMMProductImage;
use App\Models\PMM\Product\PMMProductSubscriber;
use App\Models\SP\SPTicket;
use App\Models\SP\SPTicketMember;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use  App\Models\PMM\PMMCategory;
use App\Models\PMM\PMMProductTag;
use App\Models\PMM\PMMProductCategory;
use App\Models\PMM\PMMRats;
use App\Models\PMM\gls\profile;
class PMMProductController extends Controller
{
        public function index()
    {

       $data['list']=$this->process()
       ->where('status','active')
       ->with(['attachment'])
       ->when(!is_admin() && !is_has_role('Marketer'),function($q2){
                $q2->where('user_id',auth()->user()->id);
            })
       ->latest()->paginate(50);
        return view('pmm.product.index',$data);

    }
public function shopSearch(Request $request)
{
    $input = $request->all();

    $products = $this->process()
        ->when(!empty($input['status']), function($q) use ($input) {
            $q->where('status', $input['status']);
        })
        ->when(!empty($input['name']), function ($q) use ($input) {
            $q->where('name', 'like', '%' . $input['name'] . '%');
        })
        ->when(!empty($input['price']), function ($q) use ($input) {
            $q->where('price', '<=', $input['price']);
        })
        ->latest()
        ->get();

    // Pass products as an array key
   return view('frontend.themes.eshoper.ajax.products', ['products' => $products]);
}
    public function search(Request $request)
    {

       $input=$request->all();
       $data['list']=$this->process()
        ->when(!empty($input['status']),function($q)use($input){
        $q->where('status',$input['status']);
       })
        ->when(!empty($input['name']), function ($q) use ($input) {
            $q->where('name', 'like', '%' . $input['name'] . '%');
        })
       ->latest()
       ->get();
        return view('pmm.product.ajax.main_list',$data);

    }
    public function process()
    {

     return PMMProduct::query()
        ->with(['attachment']);


    }
    public function add()
    {
        $data['marketers']=PMMAffiliate::with(['user'])->get();
        $data['profils']= profile::where('user_id',auth()->id())->latest()->get();
        
        return view('pmm.product.add',$data);
    }
    public function request()
    {

        return view('pmm.product.request');
    }
    public function requestPost(Request $request)
    {
        $data=$request->except('_token');
        try{
            $data['subject']='Request For Campaign By '.auth()->user()->email;
            $data['priority']="low";
            $data['description']="Product Link : ".$data['link']."\n Payout expectation : ".$data['payout']."\n Destination country : ".$data['country']."\n Expected Traffic : ".$data['trafic']."\n Product Detai : ".$data['detail'];
            DB::beginTransaction();
            $ticket=SPTicket::isAdmin()->create([
                'subject'=>$data['subject'],
                'priority'=>$data['priority'],
                'user_id'=>auth_user_id(),
                'created_by_id'=>auth_user_id(),
                'description'=>$data['description'],
                'status'=>"Created"
            ]);
        SPTicketMember::updateOrCreate(
            ['ticket_id'=>$ticket->id,'user_id'=>who_is_support()],[]);

        DB::commit();
         return response()->json(['code'=>1,'message'=>"added successfully!",'url'=>route('sp.tickets.chat',unique_encrypt($ticket->id))]);
        }catch(\Exception $e)
        {
            DB::rollBack();
           return response()->json(['code'=>0,'message'=>$e->getMessage()]);
        }
    }
    public function addPost(Request $request)
    {
        $data=$request->except('_token');
       $data['marketers']=$data['marketers']??[];
        try{
            if($data['commission_type']=="Flat" && $data['commission']>=$data['price'])
            {
            return response()->json(['code' => 0, 'message' => "Commission must be less than the price."]);
            }
            if($data['commission_type']=="Percentage" && $data['commission']>=100)
            {
            return response()->json(['code' => 0, 'message' => "Commission must be less than the price."]);
            }
            DB::beginTransaction();
            $product=PMMProduct::create([
                'name'=>$data['name'],
                'marketers'=>json_encode($data['marketers']),
                'type'=>$data['type'],
                'commission'=>$data['commission'],
                'commission_type'=>$data['commission_type'],
                'price'=>$data['price'],
                'name'=>$data['name'],
                'user_id'=>auth_user_id(),
                'created_by_id'=>auth_user_id(),
                'description'=>$data['description'],
                'long_description'=>$data['long_description'],
                'status'=>$data['status'],
                'gls_profile_id'=>$request->sender_pro_id
            ]);
            $attachment = $request->file('attachment');
            if ($attachment) {
                    $data['attachment']=fun_save_file($attachment,'uploads');
                    $product->app_file_id=$data['attachment']->id;
                    $product->save();
                }
        DB::commit();
        affiliate_link(auth()->user()->id,$product->id);
        $afl=get_affiliate_link(auth()->user()->id,$product->id);
        $afl->product_name=$data['name'];
        $afl->product_description=$data['description'];
        if ($attachment) {
        $data['attachment']=fun_save_file($attachment,'uploads');
        $product->app_file_id=$data['attachment']->id;
        $product->save();
        $afl->product_image=$data['attachment']->id;
        }
        $afl->save();

         return response()->json(['code'=>1,'message'=>"product added successfully!",'url'=>route('pmm.products.update',product_encrypt($product->id).'?#tabs')]);
        }catch(\Exception $e)
        {
            DB::rollBack();
           return response()->json(['code'=>0,'message'=>$e->getMessage()]);
        }

    }
        public function updatePost(Request $request,$id)
    {
        $data=$request->except(['_token']);

        $product = PMMProduct::find($id);
          $attachment = $request->file('attachment');
         if(auth_user_id()==$product->user_id || is_admin())
         {


                if ($attachment) {
                    $data['attachment']=fun_save_file($attachment,'uploads');
                    $product->app_file_id=$data['attachment']->id;
                    $product->save();
                }
        $Payload['old'] = $product->replicate();
            if($data['commission_type']=="Flat" && $data['commission']>=$data['price'])
            {
            return response()->json(['code' => 0, 'message' => "Commission must be less than the price."]);
            }
            if($data['commission_type']=="Percentage" && $data['commission']>=100)
            {
            return response()->json(['code' => 0, 'message' => "Commission must be less than the price."]);
            }
            
        $product->update([
                'name'=>$data['name'],
                'description'=>$data['description'],
                'long_description'=>$data['long_description'],
                'payment_method'=>$data['payment_method'],
                'marketers'=>$data['marketers']??[],
                'countries'=>$data['countries']??[],
                'type'=>$data['type'],
                'status'=>$data['status'],
                'quantity'=>$data['quantity'],
                'commission'=>$data['commission'],
                'commission_type'=>$data['commission_type'],
                'price'=>$data['price'],
                'crouncy'=>$data['crouncy'],
                'gls_profile_id'=>$request->sender_pro_id
            ]);
         }

         affiliate_link(auth()->user()->id,$product->id);
        $afl=get_affiliate_link(auth()->user()->id,$product->id);
        $afl->product_name=$data['name'];
        $afl->product_description=$data['description'];
        if ($attachment) {
        $data['attachment']=fun_save_file($attachment,'uploads');
        $afl->product_image=$data['attachment']->id;
        $afl->save();
        $afl->product_image=$data['attachment']->id;
        }

        $afl->save();
        $Payload['updated'] = $product->fresh('user');
        app_log(auth_user_id(),'product',$id,"product Updated",$Payload);
        $subscribers=PMMProductSubscriber::where('product_id',$product->id)->where('status','active')->get();

         foreach($subscribers as $sb)
         {
            $mailData['email']=$sb->user->email;
            $mailData['product_id']=$sb->id;
            $mailData['name']=$sb->user->name;
            $mailData['comment']="Product Updated";
            $mailData['user_id']=$sb->user->id;
            $mailData['title']=$product->name;
            $mailData['redirect_url']=route('pmm.products.view_detail',product_encrypt($product->id));
            PMMProductUpdatedJob::dispatch($mailData);
         }
        return response()->json(['code'=>1,'message'=>"product updated successfully!",'item_url'=>!empty($afl->attachment)?$afl->attachment->file_url:($product->attachment?$product->attachment->file_url:'')]);
    }

    public function update(Request $request,$id)
    {
                   $data['item']=$this->process()->find(product_decrypt($id));
       
                      $productId = product_decrypt($id);

                    $data['item'] = $this->process()->find($productId);
                    $query = Payment::with(['link.product'])
                        ->whereHas('link.product', function ($q) use ($productId) {
                            $q->where('id', $productId);
                        });
                   if (auth()->user()->type !== 'admin') {
                        $query->where('user_id', auth()->id());
                    }
                      $data['transactions'] = $query->get();
        $data['allCategories'] = PMMCategory::all();
         affiliate_link(auth()->user()->id,$data['item']->id);
         $data['link']=PMMAffiliateLink::where(['user_id'=>auth()->user()->id,'product_id' => $data['item']->id])->first();
        $data['marketers']=PMMAffiliate::with(['user'])->get();
        $data['profils']=profile::where('user_id',auth()->id())->latest()->get();
        $data['domain']=$data['link']->customdomain;
        return view('pmm.product.update',$data);
    }
        public function images(Request $request,$id)
    {
          if(!(new PMMProductController())->process()->where('id',$id)->exists())
        {
            return response()->json(['code'=>0,'message'=>"Error"]);
        }
        $data['images']=PMMProductImage::where([
            'product_id'=>$id
        ])->latest()->get();

         return view('pmm.product.ajax.gallery',$data);
    }
    public function removeImage(Request $request,$id)
    {
       try{
        $image=PMMProductImage::find($id);
        $product=PMMProduct::isAdmin()->where('id',$image->product_id)->first();
        if($product)
        {
            $image->delete();
       return response()->json(['code'=>1,'message'=>"Image deleted successfully!"]);
        }

       }catch(\Exception $e)
       {
        DB::rollBack();
         return response()->json(['code'=>0,'message'=>"Project cannot be deleted successfully!"]);
       }

    }
      public function image_upload(Request $request,$id)
    {
        if(!(new PMMProductController())->process()->where('id',$id)->exists())
        {
            return response()->json(['code'=>0,'message'=>"Error"]);
        }
         $attachment = $request->file('attachment');

        if ($attachment) {
            $data['attachment']=fun_save_file($attachment,'uploads');
           PMMProductImage::create([
            'app_file_id'=>$data['attachment']->id,
            'user_id'=>auth_user_id(),
            'product_id'=>$id,
           ]);
        return response()->json(['code'=>1,'message'=>"Attachment successfully uploaded"]);
        }
      return response()->json(['code'=>0,'message'=>"Error"]);

    }
        public function viewDetail(Request $request,$id)
    {
        return $this->update($request,$id);
    }
     public function purchase(Request $request,$id)
    {

        $ref_trans=null;
        $affiliateLink = PMMAffiliateLink::find(product_decrypt($id));
        if (!$affiliateLink) {
            return back()->withErrors(['Invalid affiliate link.']);
        }

        // Get the associated product
        $product = PMMProduct::with(['images'])->find($affiliateLink->product_id);

        if (empty($product) || $product->status=='inactive') {
            return redirect(route('frontend.product.notfound'));
        }
        if($request->has('trans_ref'))
        {
          $ref_trans=Payment::find(unique_decrypt($request->trans_ref));
        }

        // Calculate commission
        $commission = ($product->price / 100) * $product->commission;

        // Calculate total amount (price + commission)
        $input['amount'] = $product->price;
        $input['currency']="USD";
        $input['type']="product";
        $data['product']=$product;
        $data['link']=$affiliateLink;
        $existingClick = PMMProductClick::where('ip', $request->ip())
            ->where('reference_type', 'product')
            ->where('reference', $product->id)
            ->where('created_at', '>=', Carbon::now()->subMinutes(30))
            ->first();

            $marchandCruncy=$product->crouncy;
            $rate = PMMRats::where('symbol', 'USD/'.$product->crouncy)->value('rate');
        
            $data['unit_price_amount'] = $input['amount'] * ($rate ?? 1);
            $data['price_amount'] =$product->price;
            $data['symbol']=$product->crouncy;
        if (!$existingClick) {
            PMMProductClick::create([
                'ip' => $request->ip(),
                'reference_type' => 'affiliate_link',
                'user_id' => $affiliateLink->user_id,
                'reference' => $affiliateLink->id,
            ]);
        }
         $data['locale']='';
         $us_states = [
                'AL' => 'Alabama',
                'AK' => 'Alaska',
                'AZ' => 'Arizona',
                'AR' => 'Arkansas',
                'CA' => 'California',
                'CO' => 'Colorado',
                'CT' => 'Connecticut',
                'DE' => 'Delaware',
                'FL' => 'Florida',
                'GA' => 'Georgia',
                'HI' => 'Hawaii',
                'ID' => 'Idaho',
                'IL' => 'Illinois',
                'IN' => 'Indiana',
                'IA' => 'Iowa',
                'KS' => 'Kansas',
                'KY' => 'Kentucky',
                'LA' => 'Louisiana',
                'ME' => 'Maine',
                'MD' => 'Maryland',
                'MA' => 'Massachusetts',
                'MI' => 'Michigan',
                'MN' => 'Minnesota',
                'MS' => 'Mississippi',
                'MO' => 'Missouri',
                'MT' => 'Montana',
                'NE' => 'Nebraska',
                'NV' => 'Nevada',
                'NH' => 'New Hampshire',
                'NJ' => 'New Jersey',
                'NM' => 'New Mexico',
                'NY' => 'New York',
                'NC' => 'North Carolina',
                'ND' => 'North Dakota',
                'OH' => 'Ohio',
                'OK' => 'Oklahoma',
                'OR' => 'Oregon',
                'PA' => 'Pennsylvania',
                'RI' => 'Rhode Island',
                'SC' => 'South Carolina',
                'SD' => 'South Dakota',
                'TN' => 'Tennessee',
                'TX' => 'Texas',
                'UT' => 'Utah',
                'VT' => 'Vermont',
                'VA' => 'Virginia',
                'WA' => 'Washington',
                'WV' => 'West Virginia',
                'WI' => 'Wisconsin',
                'WY' => 'Wyoming',
            ];
        //stripe
         try{
            $countries=json_decode($product->countries);
            if(!$request->has('en') && !empty($countries) && isset($countries[0]))
         {
             $data['locale']=$countries[0];
            fun_set_locale(strtolower($countries[0]));

         }elseif($request->has('en'))
         {
            $data['locale']=$request->en;
         }
         }catch(\Exception $e){
         }
        $data['stripe_key']=config('services.Stripe.pk_key');
        
           $data['ref_trans']=$ref_trans;
        if(config('app.checkout_gateway')=="stripe")
        {
            return view(theme_url().'checkoutv2.index',$data);
        }
        elseif(config('app.checkout_gateway')=="paysight")
        {
            $setting = UserSetting::firstOrCreate([
                'user_id' =>who_is_admin()
            ]);
            $data['p_product_id']=$setting->paysigh_product_id;
            $data['p_env']=config('myconfig.Paysight.ENV');
            // $api_key=config('myconfig.Paysight.API_KEY');
            // $data=config('myconfig.Paysight.CLIENT_ID');
            $data['unique_session_id']="asdasdasdasd".rand(123,34353);
            $data['us_states']=$us_states;
            // if($request->has('method') && $request->method=='iframe')
            // {
              return view(theme_url().'paysight.checkoutv2.iframe',$data);
            // }
            // return view(theme_url().'paysight.checkoutv2.index',$data);
            
        }
        
    }
    public function doPament(Request $request,$id)
    {
        $affiliateLink = PMMAffiliateLink::find(product_decrypt($id));
        if (!$affiliateLink) {
            return back()->withErrors(['Invalid affiliate link.']);
        }

        // Get the associated product
        $product = PMMProduct::find($affiliateLink->product_id);

        if (!$product) {
            return back()->withErrors(['Product not found.']);
        }

        // Calculate commission
        $commission = ($product->price / 100) * $product->commission;

        // Calculate total amount (price + commission)
        $input['amount'] = $product->price + $commission;
        $input['currency']="USD";
        $input['type']="product";
        $url= create_stripe_payment_url($input['amount'],$input['currency'],$input['type'],$affiliateLink->user_id,'affiliate_link',$affiliateLink->id,$product->name);
        return redirect($url);
    }
    public function logs(Request $request,$id)
    {
        $data['list']=AppLog::where([
            'type'=>'project',
            'reference'=>$id
        ])->with(['user'])->get();
         return view('pmm.product.logs.index',$data);
    }
       public function subscribe(Request $request,$id)
    {
        $data=$request->except(['_token']);
            $product = PMMProduct::findOrFail($id);
            $userId = auth()->id();

            $subscriber = PMMProductSubscriber::where([
                'product_id' => $product->id,
                'user_id' => $userId,
            ])->first();

            $newStatus = 'active'; // default

            if ($subscriber) {
                $newStatus = $subscriber->status === 'active' ? 'inactive' : 'active';
                $subscriber->update(['status' => $newStatus]);
            } else {
                PMMProductSubscriber::create([
                    'product_id' => $product->id,
                    'user_id' => $userId,
                    'status' => $newStatus
                ]);
            }
        return response()->json(['code'=>1,'message'=>"product subscribed successfully!"]);
    }


    public function remove(Request $request,$id)
    {
       try{
        DB::beginTransaction();
       PMMProduct::hasPermission('pm.products.full_control')->find($id)->user->delete();
       PMMProduct::hasPermission('pm.products.full_control')->find($id)->delete();
       DB::commit();
       return response()->json(['code'=>1,'message'=>"Employee deleted successfully!"]);
       }catch(\Exception $e)
       {
        DB::rollBack();
         return response()->json(['code'=>0,'message'=>"Project cannot be deleted successfully!"]);
       }

    }

public function AddTag(Request $request , $id)
{
    $request->validate([
        'tags' => 'required|string|max:255',
    ]);

    $userId = auth()->id();
    $productId = $request->product_id; 
    $tagName = trim($request->tags);

    $exists = PMMProductTag::where('user_id', $userId)
        ->where('product_id', $id)
        ->where('tag', $tagName)
        ->exists();

    if ($exists) {
        return response()->json([
            'code' => false,
            'message' => "This tag already exists!"
        ]);
    }

    PMMProductTag::create([
        'user_id' => $userId,
        'product_id' => $id,
        'tag' => $tagName,
    ]);

    return response()->json([
        'code' => true,
        'message' => "Tag added successfully!"
    ]);
}
public function getTag($id)
{
    $tags = PMMProductTag::where('product_id', $id)->get(['id', 'tag']);

    return response()->json([
        'code' => true,
        'tags' => $tags
    ]);
}
public function deleteTag(Request $request)
{
    $tag = PMMProductTag::find($request->tagid);

    if (!$tag) {
        return response()->json(['code' => false, 'message' => 'Tag not found.']);
    }

    $tag->delete();

    return response()->json(['code' => true, 'message' => 'Tag deleted successfully!']);
}
public function AssignCategory(Request $request, $id)
{
    $request->validate([
        'category_ids' => 'required|array',
        'category_ids.*' => 'exists:pmm_categories,id'
    ]);

    $product = PMMProduct::findOrFail($id);

    foreach ($request->category_ids as $category_id) {
        // Check if pivot exists and is soft-deleted
        $pivot = PMMProductCategory::withTrashed()
                    ->where('product_id', $id)
                    ->where('category_id', $category_id)
                    ->first();

        if ($pivot) {
            $pivot->restore(); // Restore soft-deleted
            $pivot->update(['user_id' => auth()->id()]);
        } else {
            PMMProductCategory::create([
                'product_id' => $id,
                'category_id' => $category_id,
                'user_id' => auth()->id()
            ]);
        }
    }

    // Optionally remove pivot rows not in $request->category_ids
    PMMProductCategory::where('product_id', $id)
        ->whereNotIn('category_id', $request->category_ids)
        ->delete();

    return response()->json([
        'code' => 1,
        'message' => 'Categories assigned successfully!'
    ]);
}

 function up_sell($id){
    $item=PMMProduct::find($id);
    
    $upsells=UppSell::where('product_id',$id)->get();
     return view('pmm.product.upp_sell', compact('item','upsells'));
  }
}

