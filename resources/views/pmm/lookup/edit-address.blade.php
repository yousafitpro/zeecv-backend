@extends('layout.master')
@section('title', "Orders")
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container mt-4">
    <div class="card">

      <div class="card-header page-header">
                                <h4 class="page-title">Address Management</h4>
                                <ul class="breadcrumbs">
                                    <li class="nav-home">
                                        <a href="{{url('/dashboard')}}">
                                            <i class="flaticon-home"></i>
                                        </a>
                                    </li>
                                    <li class="separator">
                                        <i class="flaticon-right-arrow"></i>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('system.Lookup.address')}}">Addresses</a>
                                    </li>

                                </ul>

                            </div>

        <div class="card-body">

            {{-- Add Category Form --}}
            <form method="POST" action="{{ route('system.Lookup.address.update',$item->id) }}" onsubmit="addCategory(event, this)">
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $item->name }}" placeholder="Name" required>
                    </div>
                    <div class="col-md-3">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ $item->phone }}" placeholder="Phone" required>
                    </div>
                    <div class="col-md-3">
                        <label>City</label>
                        <input type="text" name="city" class="form-control" value="{{ $item->city }}" placeholder="city" required>
                    </div>
                    <div class="col-md-3">
                        <label>Postal Code</label>
                        <input type="text" name="postal_code" value="{{ $item->postal_code }}" class="form-control" placeholder="Postal" required>
                    </div>

                  
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label>Province</label>
                        <input type="text" name="province" value="{{ $item->province }}" class="form-control" placeholder="Province" required>
                    </div>
                    <div class="col-md-2">
                        <br>
                        <input type="checkbox" name="is_primary" {{ $item->is_primary?'checked':'' }} >
                        <label>Is Primary</label>
                        
                    </div>
                    <div class="col-md-7">
                        <label>Address</label>
                        <input type="text" name="address" value="{{ $item->address }}" class="form-control" placeholder="Address" required>
                    </div>
                </div>
                <div class="row">
                      <div class="col-md-12">
                        <button type="submit" class="btn btn-primary pull-right" style="border-radius: 5px;">
                            <i class="fas fa-edit"></i> Update
                        </button>
                    </div>
                </div>
            </form>



        </div>
    </div>
</div>



@stop

