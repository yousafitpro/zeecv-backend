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
                                        <a href="{{route('pmm.profile.gls')}}">Profils</a>
                                    </li>

                                </ul>

                            </div>

        <div class="card-body">

            {{-- Add Category Form --}}
            <form method="POST" action="{{ route('system.Lookup.gls.pro.update',$item->id) }}" onsubmit="addCategory(event, this)">
                @csrf
                <div class="row">
                    <div class="col-md-3">
                    <label>GLS Profile Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $item->name }}" placeholder="Name" required>
                    </div>
                    <div class="col-md-3">
                        <label>Sede</label>
                        <input type="text" name="sede" class="form-control"  value="{{ $item->sede }}" placeholder="Phone" required>
                    </div>
                    <div class="col-md-3">
                      <label>Customer Code</label>
                        <input type="number" name="customer_code" class="form-control" value="{{ $item->customer_code }}" placeholder="city" required>
                    </div>
                    <div class="col-md-3">
                     <label>Contract Code</label>
                        <input type="number" name="Contract_code" class="form-control" class="form-control" value="{{ $item->contract_code }}" placeholder="Postal" required>
                    </div>

                  
                </div>
                <div class="row">
                    <div class="col-md-3">
                          <label>Password</label>
                        <input type="text" name="password" class="form-control" value="{{ $item->password }}" class="form-control" placeholder="Province" required>
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

