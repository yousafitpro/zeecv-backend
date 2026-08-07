<?php

use App\Models\Utils\listdata;

    if(!function_exists('admin_mails_receivers'))
    {
        function admin_mails_receivers($slug=null)
        {
            if(!listdata::where('slug','daily-branches-report-reciever-mail')->exists())
            {
             listdata::create([
                 'type'=>'admin_mails_receivers',
                 'slug'=>'daily-branches-report-reciever-mail',
                 'name'=>'daily-branches-report-reciever-mail',
                 'value'=>''
             ]);
            }
            if(!listdata::where('slug','daily-telpay-file-receiver')->exists())
            {
             listdata::create([
                 'type'=>'admin_mails_receivers',
                 'slug'=>'daily-telpay-file-receiver',
                 'name'=>'daily-telpay-file-receiver',
                 'value'=>''
             ]);
            }

           return get_list_date("admin_mails_receivers",$slug);
        }

    }
