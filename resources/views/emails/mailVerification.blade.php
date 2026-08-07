@extends('emails.master')
@section('content')
    Hi <h3>{{$user->name}}</h3><br>
   <p> To activate your {{config('app.name2')}} account, click "Verify Account" below, or use this link:</p>
    <a href="{{route('webAuth.verifyEmailAddressView',$user->token)}}">Verify Account</a>
<p>    The link will expire in 24 hours.
</p>
@stop
