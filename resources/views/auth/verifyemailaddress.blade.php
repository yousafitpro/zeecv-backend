@extends('auth.layout')

@section('content')

<div class="container">
    <br>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <br>
            <br>
            <div class="card">


                <div class="card-body">
                    <form method="POST" action="{{ route('webAuth.verifyEmailAddress') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{$token}}">



                        <div class="form-group row">

                            <div class="col-md-6">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-4 offset-md-4">
                                <button type="submit" class="btn btn-primary form-control">
                                    {{ __('Verify') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
