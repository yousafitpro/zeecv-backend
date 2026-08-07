@extends('frontend.themes.eshoper.layout')

@section('content')
<br>
<div class="tuts-show-container">
    <div class="row">
    <div class="col-md-3"></div>
   <div class="col-md-6">
        <div class="tutorial ">
        <h3 >{{ $tutorial->title }}</h3>
        <br>
        </div >
        @if(!empty($tutorial->attachment?->file_url))
            <img src="{{ $tutorial->attachment->file_url }}"
                alt="{{ $tutorial->title }}"
                style="max-height:400px; height:auto; width:98%;">
        @else

        @endif
            <br>
    <p>{!! $tutorial->description ?? '' !!}</p>
    </div>

    <div class="col-md-3"></div>
    </div>
</div>
</div>


<br>
@endsection
