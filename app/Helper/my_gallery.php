<?php

use App\Models\galleryFile;
///asdasd
if ( ! function_exists('my_gallery')) {
    function my_gallery()
    {
        $SRC = 'my_gallary';
        $data['list']=galleryFile::where('user_id',auth()->id())->where(['deleted_at'=>null])->latest()->get();
        $data['src']='public/'.$SRC;
        return $data;

    }

}
