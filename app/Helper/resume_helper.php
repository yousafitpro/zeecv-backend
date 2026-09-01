<?php

use App\Models\Resume\Resume;

if (!function_exists('my_resume')) {
    function my_resume($user_id=null)
    {
        if(empty($user_id) && auth()->check()){
           $user_id=auth()->user()->id;
        }
        if(empty($user_id)){
            return null;
        }
        $resume=Resume::where('user_id',$user_id)->first();
        return $resume;
    }
}
if (!function_exists('reset_description')) {
    function reset_description($description)
    {
        // Remove all <a> tags and their inner content
        $description = preg_replace('/<a[^>]*>.*?<\/a>/i', '', $description);

        $texts = [
            'Originally posted on',
            'Himalayas',
            'on Arbeitnow',
            'jobs in',
            'arbeitnow',
            'www.',
            '.com',
            'Arbeitnow',
            'Find more'
        ];

        return str_replace($texts, '', $description);
    }
}
if ( ! function_exists('zeecv_templates')){
    function zeecv_templates()
    {
        return [
            'default'=>[
                'color'=>'#c7885c',
                'template'=>'default',
                'thumbnail'=>asset('resume/templates/default.png'),
                'name'=>'Default'
                ],
                 'temp1'=>[
                'color'=>'#c7885c',
                'template'=>'temp1',
                'thumbnail'=>asset('resume/templates/temp1.png'),
                'name'=>'Template 1'
                ],
            'temp2'=>[
                'color'=>'#c7885c',
                'template'=>'temp2',
                'thumbnail'=>asset('resume/templates/temp2.png'),
                'name'=>'Template 2'
                ],
            'temp3'=>[
                'color'=>'#c7885c',
                'template'=>'temp3',
                'thumbnail'=>asset('resume/templates/temp3.png'),
                'name'=>'Template 3'
                ],
            'marketer'=>[
                'color'=>'#c7885c',
                'template'=>'marketer',
                'thumbnail'=>asset('resume/templates/marketer.png'),
                'name'=>'Marketers'
                ],
            'uk'=>[
                'color'=>'#c7885c',
                'template'=>'uk',
                'thumbnail'=>asset('resume/templates/uk.png'),
                'name'=>'UK'
                ],
            'gamedeveloper'=>[
                'color'=>'#c7885c',
                'template'=>'gamedeveloper',
                'thumbnail'=>asset('resume/templates/uk.png'),
                'name'=>'Game Developer'
                ],
            'fashiondesigner'=>[
                'color'=>'#c7885c',
                'template'=>'fashiondesigner',
                'thumbnail'=>asset('resume/templates/uk.png'),
                'name'=>'Fashion Designer'
                ],
            'ca'=>[
                'color'=>'#c7885c',
                'template'=>'ca',
                'thumbnail'=>asset('resume/templates/ca.png'),
                'name'=>'Canada'
                ],
           
        ];
    }
}