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
            'uk'=>[
                'color'=>'#c7885c',
                'template'=>'uk',
                'thumbnail'=>asset('resume/templates/uk.png')
                ],
        ];
    }
}