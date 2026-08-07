@extends('layout.master')
@section('title',"Add Credit")
@section('content')
    <div class="box box-body">
    <div class="row">
        <div class="col-6">
           <h4>Two Step Verification</h4>
            <small>Please Enable this to Secure your Account.</small>
            </div>
        <div class="col-6">
            @if(user_setting(auth()->user()->id)->is_two_step_enabled=='false')
                <a href="javascript:void" data-target="#verifyPhone" data-toggle="modal" class="pull-right" ><h4>Enable</h4></a>

            @endif
                @if(user_setting(auth()->user()->id)->is_two_step_enabled=='true')
                    <a href="{{route('security.disable2fa')}}"  data-toggle="modal" class="pull-right" ><h4>Disable</h4></a>

                @endif
        </div>
        </div>
    </div>


    <div class="modal fade" id="verifyPhone" tabindex="-1" role="dialog" data-backdrop="static"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Verify Phone Number</h5>
                    <button  type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

<form action="{{route('security.verifyPhoneNumber')}}" method="post">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <input class="form-control" required name="phone" id="phone" style="text-align: center" placeholder="Enter Phone Number here...">
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-block btn-primary">Submit</button>
        </div>
    </div>
</form>
                </div>

            </div>
        </div>
    </div>

@endsection
