@extends('emails.master')
@section('content')
    Hi <h3>{{$data['user']->name}}</h3><br>
   <p> To set up a new password to your {{config('app.name2')}} account, click "Reset Your Password" below, or use this link:</p>
    <a href="{{route('webAuth.verifyEmail',$data['token'])}}">Reset Your Password</a>
<p>    The link will expire in 24 hours.
</p>
@stop
