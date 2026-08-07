<?php
namespace App\Exports;


use App\Models\Merchant\merchantCompany;
use App\Models\MerchantCase;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;

class UsersExport implements FromCollection
{
use Exportable;

public function collection()
{
    $list=User::query()->select(['name','email','avatar','phone','id']);
    if(request()->has("status") && request()->status=='active')
    {
        $list=$list->where(function ($q){
            $q->where('status','active');
            $q->orWhere('status',null);
            $q->orWhere('status','Approved');
            $q->orWhere('status','approved');
        });
    }

    if(request()->has("status") && request()->status=='blocked')
    {
        $list=$list->where(function ($q){
            $q->where('status','blocked');
            $q->orWhere('status','Blocked');

        });
    }
    $list=$list->with(['company'])->latest()->get();
    foreach ($list as $item)
    {
        $case=merchantCompany::where("user_id",$item->id)->first();
        $item->avatar='';
        $item->image_url='';
        $item->phone=$case?$case->phone:'';
        $item->id='';
        //sAS
    }

    return $list;
}
}
