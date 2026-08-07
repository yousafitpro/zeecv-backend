@extends('layout.master')
@section('title',"Logs")
@section('content')
<div class="card">
    <div class="card-header with-border">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-2">
                        @include('components.panelBackbutton',['backUrl'=>route('hr.e.employees.view')])
                    </div>
                    <div class="col-md-8">
                        <br>
                        <h3> Logs</h3>
                    </div>


                    <div class="col-md-2">


                    </div>
                </div>
            </div>


    </div>
<div class="card-body">
    @foreach ($list as $index => $item)
<p>
    <a class="btn btn-primary form-control" style="border-radius: 0px;text-align:left" data-toggle="collapse" href="#collapseExample{{$item['id']}}" role="button" aria-expanded="false" aria-controls="collapseExample{{$item['id']}}">
       {{$index+1}}-User: <small>{{$item->user->email??''}}</small> | <small>{{$item->description}}</small>
       <small style="float: right">{{date_time_readable($item['created_at'])}} | {{date_human_readable($item['created_at'])}}</small>
    </a>

  </p>
  <div class="collapse" id="collapseExample{{$item['id']}}">
    <div class="card card-body">
        @include('hr.employee.logs.json_parser', ['data' => ['data_obj' => json_decode($item->payload,true)]])
    </div>
  </div>




@endforeach
</div>
</div>
@endsection
