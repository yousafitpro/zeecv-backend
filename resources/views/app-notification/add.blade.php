@extends('layout.master')
@section('title',"Payment Request")
@section('content')
    <div class="page-header">
        <h4 class="page-title">Create New Notification</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{url('/')}}">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="{{url('/App-Notification-System')}}">All Notification</a>
            </li>

        </ul>
    </div>
    <form action="{{url('App-Notification-System/Create')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card">

            <div class="card-body">

                @include('errorBars.errorsArray')
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-8">
                            <label>Title</label>
                            <input name="title" required value="{{old('title')}}" class="form-control" id="email">
                            <br>
                            <label>Text</label>
                            <textarea id="txtEditor2" required name="text" class="form-control" style=" height: 200px">{{old('transaction_details')}}</textarea>
<br>
                            <label>Image</label>
                            <input  type="file" class="form-control" name="image"  >
                            <br>
                            <label>Link (optional) </label>
                            <input name="link" value="{{old('link')}}" class="form-control" >
                        </div>
                        <div class="col-md-4">
                            <label>Place</label>
                            <select name="place" required class="form-control">
                                @foreach($places as $p)
                                <option {{old('palce')==$p['value']?'selected':''}} value="{{$p['value']}}">{{$p['title']}}</option>
                                @endforeach
                            </select>
                            <br>
                            <label>Start Time</label>
                            <input type="datetime-local" required  class="form-control" name="start_time"  >
                            <br>
                            <label>End Time</label>
                            <input type="datetime-local" required  class="form-control" name="end_time"  >
                            <br>
                            <label>Status</label>
                            <select name="status"  class="form-control">
                                @foreach($statuses as $p)
                                    <option {{old('status')==$p['value']?'selected':''}} value="{{$p['value']}}">{{$p['title']}}</option>
                                @endforeach
                            </select>
                            <br>
                            <label>Type</label>
                            <select name="type"  class="form-control">
                                @foreach($types as $p)
                                    <option {{old('type')==$p['value']?'selected':''}} value="{{$p['value']}}">{{$p['title']}}</option>
                                @endforeach
                            </select>
                            <br>
                            <label>App</label>
                            <select name="app"  class="form-control">
                                @foreach($apps as $p)
                                    <option {{old('app')==$p['value']?'selected':''}} value="{{$p['value']}}">{{$p['title']}}</option>
                                @endforeach
                            </select>
                            <br>
                            <label>Is Close Able</label>
                            <select name="is_close_able"  class="form-control">

                                    <option  value="true">Yes</option>
                                    <option  value="false">No</option>

                            </select>
                        </div>
                    </div>


                    <br>
                    <div class="row">
                        <div class="col-md-12" style="color:white">
                            <button type="submit" onclick="confirm('Please confirm transaction')"   class="btn form-control btn-primary" style="color:white">Submit</button>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </form>


@stop
@section('script')

@stop
