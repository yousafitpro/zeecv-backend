<?php

use Illuminate\Support\Facades\Storage;

if(!function_exists('app_save_file'))
{
    function app_save_file($path,$file,$name=null,$extension=null,$drive='public')
    {
        $request=request();
      if(!$name)
      {
        $name=date('Y-m-d hmsi');
      }
      if(!$extension)
      {
        $extension=$file->getClientOriginalExtension();
      }
      $full_name=$name.'.'.$extension;
       $res= Storage::disk($drive)->putFileAs($path,$file,$full_name);
       dd($res);
    }
}
if(!function_exists('app_get_file'))
{
    function app_get_file($path,$name=null,$drive='public')
    {
        $request=request();

    }
}
