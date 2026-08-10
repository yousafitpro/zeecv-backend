<?php
if ( ! function_exists('zeecv_templates')){
    function zeecv_templates()
    {
        return [
            'default'=>[
                'color'=>'#c7885c',
                'template'=>'default',
                'thumbnail'=>asset('resume/templates/default.png')
                ],
            'marketer'=>[
                'color'=>'#c7885c',
                'template'=>'marketer',
                'thumbnail'=>asset('resume/templates/marketer.png')
                ],
            'uk'=>[
                'color'=>'#c7885c',
                'template'=>'uk',
                'thumbnail'=>asset('resume/templates/uk.png')
                ],
            'ca'=>[
                'color'=>'#c7885c',
                'template'=>'ca',
                'thumbnail'=>asset('resume/templates/ca.png')
                ]
        ];
    }
}