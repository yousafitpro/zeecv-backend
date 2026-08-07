<?php

use Carbon\Carbon;
use Illuminate\Support\Str;



if ( ! function_exists('publicId')){
    function publicId($id)
{
    return rand(111, 999) . $id . rand(1111, 9999);
}
///asdasdadasd
}


if ( ! function_exists('modelId')){
function modelId($id)
{
    return substr($id, 3, -4);
}
}
if ( ! function_exists('paginateLength')){
function paginateLength($length)
{
    $length = $length ?: 10;
    if ($length == -1) {
        $length = 99999999999;
    }
    return $length;
}
}
if ( ! function_exists('toString')){

function toString($value)
{
    return '"' . (string)($value) . '"';
}
}
if ( ! function_exists('saveImage')){

function saveImage($img, $path, $name = null,$request=null)
{
    $name='';
    $name = $name ?: rand(1000, 9999) . time() . '.' . $img->getClientOriginalExtension();
    try{
        $img->move($path, $name);
    }catch(\Exception $e){}
    return $name;
}
}
if ( ! function_exists('saveImageAjax')){
function saveImageAjax($img, $path, $name = null)
{
    $name = $name ?: rand(1000, 9999) . time() . '.' . $img->getClientOriginalExtension();
    $img->storeAs($path,$name,'my_files');

   // $file = $img->file->store('public/documents');
    return $name;
}
}
//asdasdasdasdasdasd

if ( ! function_exists('diffDays')){
function diffDays($start, $end = null)
{
    $end = $end ?: Carbon::now();
    $start = Carbon::createFromDate($start);
    return $start->diffInDays($end);
}
}
if ( ! function_exists('diffMinutes')){
function diffMinutes($start, $end = null)
{
    $end = $end ?: Carbon::now();
    $start = Carbon::createFromDate($start);
    return $start->diffInMinutes($end);
}
}
if ( ! function_exists('exportCsv')){
function exportCsv($list, $file_name = 'records')
{
    $headers = [
        'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0'
        , 'Content-type' => 'text/csv'
        , 'Content-Disposition' => 'attachment; filename=' . $file_name . '.csv'
        , 'Expires' => '0'
        , 'Pragma' => 'public'
    ];

    array_unshift($list, array_keys($list[0]));

    $callback = function () use ($list) {
        $FH = fopen('php://output', 'w');
        foreach ($list as $row) {
            fputcsv($FH, $row);
        }
        fclose($FH);
    };
    return response()->stream($callback, 200, $headers);
}
}
if ( ! function_exists('str_random')){

function str_random($length = 20)
{
    return Str::random($length);
}
}
