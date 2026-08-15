<?php
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
                'thumbnail'=>asset('resume/templates/temp2.png'),
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