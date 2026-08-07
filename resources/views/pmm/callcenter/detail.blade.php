@extends('layout.master')
@section('title',"Order | Info")
@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<div class="card">
    <!-- /.box-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                @php
                    if(!empty(request('back_url'))) {
                        $back_url= request('back_url');
                    } else {
                        $back_url= route('pmm.transactions.view');
                    }
                @endphp
                @include('components.panelBackbutton',['backUrl'=>$back_url])
            </div>
            <div class="col-md-6">
                <h3 style="text-align: right">Transaction</h3>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 info-box" >
                        
<div class="d-flex justify-content-between align-items-center mb-2">
    <h3 class="mb-0">Payment Details</h3>
    @if(is_has_permission('pmm.cc.order.details'))
        <a class="dropdown-item app-action-btn" href="javascript:void(0)" data-toggle="modal" data-target="#modal_order_details"
         style="width:200px; padding:4px 10px; font-size:13px;">
            <i class="fas fa-edit"></i> Edit Order
        </a>
    @endif
</div>

                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Created At</label> : {{ $item->created_at->format('d M Y, h:i A') }}
                                </div>
                                <div class="col-md-6">
                                    <label>Amount</label> : {{ $item->amount }} | {{ $item->currency }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Order Status</label> : 
                                    <span id="order-status-badge-{{ $item->id }}" 
                                        class="badge bg-{{ app_getStatusColor($item->order_status) }} badge-sm" 
                                        style="color:white;font-size:10px;padding:4px 6px">
                                        {{ $item->order_status }}
                                    </span>

                                    <a href="javascript:void"
                                            class=" ml-2"
                                            onclick="updateOrderStatus('{{ $item->id }}')">
                                        <i class="fas fa-edit"></i>
                                </a>
                                </div>

                                <div class="col-md-6">
                                    <label>Order ID</label> : {{ unique_encrypt($item->id) }}
                                </div>
                            </div>
                                 <div class="row">
                                <div class="col-md-6">
                                    <label>Payment Status</label> : <span class="badge bg-{{ app_getStatusColor($item->status) }} badge-sm" style="color:white;font-size:10px;padding:4px;padding-left:5px;padding-left:5px">{{ $item->status }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 info-box" >
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                <h3 class="mb-0">Delivery Details</h3>
                            
                            </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Name</label> :<span id="delivery_name">{{ $item->name }}</span>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Phone</label> : <span id="delivery_phone">{{ $item->phone }}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Email</label> : <span id="delivery_email">{{ $item->email }}</span>
                                    </div>
                                    <div class="col-md-6">
                                        <label>City</label> : <span id="delivery_city">{{ $item->city }}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Address</label> : <span id="delivery_address">{{ $item->address }}</span>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Postal Code</label> : <span id="delivery_postalcode">{{ $item->postalcode }}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Quantity</label> : {{ $item->quantity}}
                                    </div>
                                    <div class="col-md-6">
                                        <label>Country</label> : <span id="delivery_country">{{ $item->country }}</span>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Comeback Link</label> : {{get_comebackurl_link($item->id)}}
                                    </div>
                                    <div class="col-md-6">
                                        <label>Comeback Message</label> : {{$item->is_comeback_notified==1?'Sent':"Not Yet!"}}
                                    </div>
                                </div>
                         
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 info-box" >
                            <div class="row">
                                <div class="col-md-6">
                                    <h3> Product Details</h3>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Name</label> : {{ $item->link->product->name }}
                                </div>
                                <div class="col-md-6">
                                    <label>Amount</label> : {{ $item->link->product->price }} | {{ $item->link->product->crouncy }}
                                </div>
                                <div class="col-md-6">
                                    <label>Commission</label> :  {{$item->link->product->commission}} {{$item->link->product->commission_type=='Flat'?'$':'%'}}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                   
                            <div class="col-md-6 info-box" >
                                <h3> Merchant</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Name</label> : {{ $item->link->product->user->name }}
                                    </div>
                                    <div class="col-md-6">
                                        <label>Email</label> : {{ $item->link->product->user->email }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Merchant ID</label> : #{{ unique_encrypt($item->link->product->user_id) }}<br>
                                        @if (!empty($item->merchantpayment))
                                            <label>Amount</label> : $ {{$item->merchantpayment->credit}}<br>
                                        @endif
                                    </div>
                                </div>
                            </div>
                       
                        
                          <div class="col-md-6 info-box" >
                                <h3> Affiliate</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Name</label> : {{ $item->link->user->name }}
                                    </div>
                                    <div class="col-md-6">
                                        <label>Email</label> : {{ $item->link->user->email }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Affiliate ID</label> : #{{ unique_encrypt($item->link->user->id) }}<br>
                                        @if (!empty($item->affiliatecommission))
                                            <label>Amount</label> : ${{$item->affiliatecommission->credit}}
                                        @endif
                                    </div>
                                </div>
                            </div>
                       
                        
                        @if(is_admin())
                            <div class="col-md-6 info-box" >
                                <h3>Processor Detail</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Intent ID</label> : {{ $item->stripe_intent_id}}
                                    </div>
                                    <div class="col-md-6">
                                        <label>Session ID</label> : {{ $item->stripe_session_id }}
                                    </div>
                                </div>
                            </div>
                        @endif
                       
                          <div class="col-md-6 info-box">
    



                      
                    </div>
                </div>
            </div>
        </div>
        <br>
    </div>
<div class="mb-3 text-right d-flex justify-content-end" style="gap: 10px;">

   <a href="{{route('gls.view',$item->id)}}"> <button class="btn btn-primary" data-toggle="modal" >
        <i class="fas fa-truck"></i> Confirm Order and Create Shipment
    </button></a>
 


</div>


</div>
<div class="modal fade" id="downloadLabelModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="downloadLabelForm" action="{{ route('shipment.label') }}" method="POST" onsubmit="downloadLabel(event)">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Download Shipment Label</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
         <input type="hidden" id="download_shipment_number" name="shipment_number" value="">
          
          <div class="form-group">
            <label for="labelType">Select Label Type</label>
            <select class="form-control" id="labelType" name="type" required>
              <option value="pdf">PDF</option>
              <option value="zpl">ZPL</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-download"></i> Download Label
          </button>
          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_order_Delivery" tabindex="-1" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

  <div class="modal-header">
                  <h5 class="modal-title" id="orderDetailsModalLabel">Details</h5>
               <button type="button" class="close" data-dismiss="modal"
                                           aria-label="Close">
             <span aria-hidden="true">&times;</span>
            </button>
          </div>
     <form method="post" action="{{route('cc.updateDelivery',$item->id)}}" form-id='modal_order_details{{$item->id}}' onsubmit="submitOrderDeliveryForm(event, this)">
    @csrf
    <div class="modal-body">
        <div class="row">
        

              <input type="hidden" name="payment_id" value="{{ $item->id }}">
            
             <div class="col-md-6 mt-2">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" name="name" value="{{ $item->name ?? '' }}">
              </div>
                <div class="col-md-6 mt-2">
                <label class="form-label">Phone</label>
                <input type="text" class="form-control" name="phone" value="{{ $item->phone ?? '' }}">
              </div>

              <div class="col-md-6 mt-2">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="{{ $item->email ?? '' }}">
              </div>

              <div class="col-md-6 mt-2">
                <label class="form-label">City</label>
                <input type="text" class="form-control" name="city" value="{{ $item->city ?? '' }}">
              </div>

              <div class="col-md-12 mt-2">
                <label class="form-label">Address</label>
                <textarea class="form-control" name="address" rows="2">{{ $item->address ?? '' }}</textarea>
              </div>

              <div class="col-md-4 mt-2">
                <label class="form-label">Postal Code</label>
                <input type="text" class="form-control" name="postal_code" value="{{ $item->postalcode ?? '' }}">
              </div>

              <div class="col-md-4 mt-2">
                <label class="form-label">Quantity</label>
                <input type="number" class="form-control" name="quantity" value="{{ $item->quantity ?? 1 }}" disabled>
              </div>

              <div class="col-md-4 mt-2">
                <label class="form-label">Country</label>
                <input type="text" class="form-control" name="country" value="{{ $item->country ?? '' }}">
              </div>


            
        </div>
    </div>
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </div>
</form>
        </div>
    </div>
</div>

<div class="modal fade" id="trackShipmentModal" tabindex="-1" aria-labelledby="trackShipmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="trackShipmentForm" action="{{route('track.shipment')}}" method="POST" onsubmit="submitTrackForm(event)">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="trackShipmentModalLabel">Track Your Shipment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tracking_number">Tracking Number</label>
                     <input
                                type="text"
                                class="form-control"
                                id="shipment_number"
                                name="shipment_number"
                                value=""
                            >

                    </div>
                    <div id="trackResult" class="mt-3"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Track</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="updateShipmentModal" tabindex="-1" aria-labelledby="updateShipmentLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="updateShipmentForm" onsubmit="submitUpdateShipment(event, this)">
        <div class="modal-header">
          <h5 class="modal-title" id="updateShipmentLabel">Update GLS Shipment</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div id="updateShipmentFields">
            <!-- Fields will be filled by AJAX -->
          </div>
          <div id="updateResult" class="mt-2"></div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="glsShipmentModal" tabindex="-1" aria-labelledby="glsShipmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="glsShipmentForm" method="POST" action="{{route('create.shipment')}}"  onsubmit="submitGLSShipmentForm(event, this)">
                @csrf
              <input hidden name="payment_id" value="{{ $item->id }}">
                <div class="modal-header">
                    <h5 class="modal-title" acttion id="glsShipmentModalLabel">Send Shipment to GLS</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Shipment Fields -->
                    <hr>
                    <h3 class="mt-2 mb-2"><strong>Sender Information</strong></h3>

                    <div class="row">
                        <div class="col-md-6 mt-2">
                            <label class="form-label">Sender Name</label>
                            <input type="text" class="form-control" name="sender_name" 
                                placeholder="Your Sender Name" required>
                        </div>

                        <div class="col-md-6 mt-2">
                            <label class="form-label">Sender Phone</label>
                            <input type="text" class="form-control" name="sender_phone"   
                                placeholder="+39123456789">
                        </div>
                    
                        <div class="col-md-12 mt-2">
                            <label class="form-label">Sender Address</label>
                            <input class="form-control" name="sender_address"     required>

                        </div>

                        <div class="col-md-4 mt-2">
                            <label class="form-label">Sender City</label>
                            <input type="text" class="form-control" name="sender_city" 
                                placeholder="Milano" required>
                        </div>
           
                        <div class="col-md-4 mt-2">
                            <label class="form-label">Sender Postal Code</label>
                            <input  class="form-control" name="sender_postalcode" 
                                placeholder="20100" required>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label class="form-label">Country</label>
                            <input type="text" class="form-control" name="sender_country"  required>
                        </div>
                        <div class="col-md-4 mt-2">
                            <label class="form-label">Sender Province</label>
                            <input type="text" class="form-control" name="sender_province" 
                                placeholder="MI" required>
                        </div>
                    </div>
                    <hr>
                    <h3 class="mt-2 mb-2"><strong>Reciver Information</strong></h3>
                    <div class="row">
                        <div class="col-md-6 mt-2">
                            <label class="form-label">Recipient Name</label>
                         
                            <input type="text" class="form-control" name="recipient_name" value="{{ $item->name }}" required>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" name="recipient_phone" value="{{ $item->phone }}" required>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="recipient_email" value="{{ $item->email }}">
                        </div>
                        <div class="col-md-6 mt-2">
                            <label class="form-label">City</label>
                            <input type="text" class="form-control" name="recipient_city" value="{{ $item->city }}" required>
                        </div>
                                           
                        <div class="col-md-12 mt-2">
                            <label class="form-label">Address</label>
                            <textarea class="form-control" name="recipient_address" rows="2" required>{{ $item->address }}</textarea>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label class="form-label">Postal Code</label>
                            <input type="text" class="form-control" name="recipient_postalcode" value="{{ $item->postalcode }}" required>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label class="form-label">Country</label>
                            <input type="text" class="form-control" name="recipient_country" value="{{ $item->country }}" required>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label class="form-label">Shipment Weight (kg)</label>
                            <input type="number" class="form-control" name="weight" value="1" required>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label class="form-label">Product Id</label>
                            <input type="text" class="form-control" name="reference" value="{{ $item->id }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                            <button type="button" id="checkAddressBtn" class="btn btn-primary">
                                Check Address
                            </button>
                        </div>
                <div class="col-md-12 mt-3" id="addressResult"></div>
                </div>
                 <hr>
         <div class="col-md-12 mt-3">
    <label class="form-label"><strong>Select Up Sell</strong></label>
    <select class="form-control" name="upsell_id">
        <option value="">-- Select Up Sell --</option>
        @foreach($UpSells as $UpSell)
            <option value="{{ $UpSell->id }}">{{ $UpSell->name }} || ${{$UpSell->price}}</option>
        @endforeach
    </select>
</div>


                <div class="modal-footer text-center">
                    <button type="submit" class="btn btn-primary">Send to GLS</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_order_details" tabindex="-1" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

  <div class="modal-header">
                  <h5 class="modal-title" id="orderDetailsModalLabel">Details</h5>
               <button type="button" class="close" data-dismiss="modal"
                                           aria-label="Close">
             <span aria-hidden="true">&times;</span>
            </button>
          </div>
     <form method="post" action="{{route('cc.updateDetails',$item->id)}}" form-id='modal_order_details{{$item->id}}' onsubmit="submitOrderDetailsForm(event, this)">
    @csrf
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <label for="order_status" class="form-label">Order Status</label>
                @if($status)
                <select class="form-control" id="order_status" name="order_status" >
                    <option value="Try Call 1" {{ $status->cc_status == 'Try Call 1' ? 'selected' : '' }}>Try Call 1</option>
                    <option value="Try Call 2" {{ $status->cc_status == 'Try Call 2' ? 'selected' : '' }}>Try Call 2</option>
                    <option value="Try Call 3" {{ $status->cc_status == 'Try Call 3' ? 'selected' : '' }}>Try Call 3</option>
                    <option value="Pending" {{ $status->cc_status == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Shipping" {{ $status->cc_status == 'Shipping' ? 'selected' : '' }}>Accepted</option>
                    <option value="Fake" {{ $status->cc_status == 'Fake' ? 'selected' : '' }}>Fake</option>
                    <option value="Cancelled" {{ $status->cc_status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="Trash" {{ $status->cc_status == 'Trash' ? 'selected' : '' }}>Trash</option>
                    <option value="Non-existent data" {{ $status->cc_status == 'Non-existent data' ? 'selected' : '' }}>Non-existent data</option>
                    <option value="Suspended" {{ $status->cc_status == 'Suspended' ? 'selected' : '' }}>Suspended</option>
                </select>
                @endif
            </div>

              <input type="hidden" name="payment_id" value="{{ $item->id }}">
                <div class="col-md-12 mt-2"  >
                <label for="shipping_note" class="form-label"> Note</label>
                <textarea class="form-control" id="shipping_note" name="shipping_note" rows="3" placeholder="Enter shipping details..." required></textarea>
            </div>
        
        </div>
    </div>
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </div>
</form>
        </div>
    </div>
</div>

<!-- Add Call Log Button -->
<div class="mb-3 text-right">
    <button class="btn btn-primary" data-toggle="modal" data-target="#callModal">
        <i class="fas fa-phone"></i> Add Log
    </button>
</div>

<!-- Call Log Modal -->
<div class="modal fade" id="callModal" tabindex="-1" aria-labelledby="callModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="callLogForm" method="POST" action="{{ route('pmm.addCallLog') }}" onsubmit="submitForm(event, this)">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="callModalLabel">Add Call Log</h5>
                       <button type="button" class="close" data-dismiss="modal"
                                           aria-label="Close">
                                       <span aria-hidden="true">&times;</span>
                                   </button>
                </div>
                <input type="hidden" name="payment_id" value="{{ $item->id }}">
                <input type="hidden" name="user_id" value="{{ $item->user_id }}">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="call_type">Call Type</label>
                        <select class="form-control" id="call_type" name="call_type" onchange="toggleCallInputs()">
                            <option value="">-- Select Type --</option>
                            <option value="call">call</option>
                            <option value="general">general</option>
                        </select>
                    </div>

                    <!-- For Center Type -->
                    <div id="centerInputs" style="display:none;">
                        <div class="form-group">
                            <label for="start_time">Start Time</label>
                            <input type="time" class="form-control" id="start_time" name="start_time">
                        </div>
                        <div class="form-group">
                            <label for="end_time">End Time</label>
                            <input type="time" class="form-control" id="end_time" name="end_time">
                        </div>
                    </div>

                    <!-- Common Note Field -->
                    <div class="form-group">
                        <label for="note">Note</label>
                   <textarea class="form-control" id="note" name="note" rows="3" placeholder="Enter note here..." required></textarea>

                    </div>
                </div>
                <div class="modal-footer">
            <button type="button" class="btn btn-secondarys"
                                       data-dismiss="modal"> Cancel
                               </button>
             
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="shipmentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-box"></i> GLS Shipment Details
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <!-- Body -->
           <div class="modal-body">

                        <h6 class="text-primary">Shipment Info</h6>
                        <div class="row">
                            <div class="col-md-6"><b>Shipment No:</b> <span id="m_shipment_no">-</span></div>
                            <div class="col-md-6"><b>Status:</b>
                                <span class="badge badge-info" id="m_status">-</span>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-6"><b>Date:</b> <span id="m_date">-</span></div>
                            <div class="col-md-6"><b>Weight:</b> <span id="m_weight">-</span></div>
                        </div>

                        <hr>

                        <h6 class="text-primary">Receiver Details</h6>
                        <div class="row">
                            <div class="col-md-6"><b>Name:</b> <span id="m_name">-</span></div>
                            <div class="col-md-6"><b>Phone:</b> <span id="m_phone">-</span></div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-6"><b>City:</b> <span id="m_city">-</span></div>
                            <div class="col-md-6"><b>Postal Code:</b> <span id="m_postal">-</span></div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-12"><b>Address:</b> <span id="m_address">-</span></div>
                        </div>

                        <hr>

                        <h6 class="text-primary">Sender Details</h6>
                        <div class="row">
                            <div class="col-md-6"><b>Name:</b> <span id="m_sender_name">-</span></div>
                            <div class="col-md-6"><b>Phone:</b> <span id="m_sender_phone">-</span></div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-6"><b>City:</b> <span id="m_sender_city">-</span></div>
                            <div class="col-md-6"><b>Country:</b> <span id="m_sender_country">-</span></div>
                        </div>

                    </div>


            <!-- Footer -->
            <div class="modal-footer">
             





                        <button type="button" class="btn btn-primary cancel-shipment-btn" data-shipment-number="GLS123456" >
                            <i class="fas fa-trash-alt"></i> Cancel Shipment
                        </button>

                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="orderStatusModal" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Update Order Status</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body py-4 px-4">
                <input type="hidden" id="modal_order_id">

                <div class="form-group">
                    <label for="modal_status" class="font-weight-bold mb-2">Order Status</label>
                    <select class="custom-select" id="modal_status">
                        <option value="Pending">Pending</option>
                        <option value="Completed">Completed</option>
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary btn-sm px-4" onclick="saveOrderStatus()">Update</button>
            </div>

        </div>
    </div>
</div>

<!-- User Logs & Orders Table -->
  @include('pmm.callcenter.ajax.shownote')


<script>
function submitOrderDetailsForm(event, formElement) {
    event.preventDefault();
    let formData = new FormData(formElement);

    $.ajax({
        url: $(formElement).attr('action'),
        type: $(formElement).attr('method'),
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            if (response.code == 1) {
                //  formElement.reset();
                Swal.fire({
    icon: 'success',
    title: 'Success!',
    text: response.message
});

                const tbody = $("#notesTable tbody");
                tbody.empty();

                response.notes.forEach((note, i) => {
                    let duration = "—";

                    if (note.call_start && note.call_end) {
                        const [sh, sm] = note.call_start.split(':').map(Number);
                        const [eh, em] = note.call_end.split(':').map(Number);

                        if (!isNaN(sh) && !isNaN(eh)) {
                            let startMinutes = sh * 60 + sm;
                            let endMinutes = eh * 60 + em;
                            let diff = endMinutes - startMinutes;
                            if (diff < 0) diff += 24 * 60;

                            let h = String(Math.floor(diff / 60)).padStart(2, '0');
                            let m = String(diff % 60).padStart(2, '0');
                            duration = `${h}:${m}:00`;
                        }
                    }

                    tbody.append(`
                        <tr>
                            <td>${i + 1}</td>
                            <td>${note.user?.name ?? '--'}</td>
                            <td>
                                ${note.note ? note.note.substring(0, 50) + (note.note.length > 50 ? '...' : '') : ''}
                                ${note.note && note.note.length > 50 ? 
                                    `<button class="btn btn-sm btn-primary view-note-btn"
                                        data-toggle="modal"
                                        data-target="#viewNoteModal"
                                        data-note="${note.note.replace(/"/g, '&quot;')}">
                                        View
                                    </button>` 
                                : ''}
                            </td>
                            <td>${note.type ?? ''}</td>
                            <td>${duration}</td>
                            <td>${new Date(note.created_at).toLocaleString()}</td>
                            <td>${new Date(note.updated_at).toLocaleString()}</td>
                        </tr>
                    `);
                });

            } else if (response.code == 0) {
                swal("Sorry!", response.message, "error");
            } else {
                swal("Sorry!", "Unexpected response", "error");
            }
        },
        error: function(xhr) {
            let errorMessage = "Something went wrong.";
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            Swal.fire({
    icon: 'error',
    title: 'Error!',
    text: errorMessage
});

        },
        complete: function() {
            $("#mainLoader1").modal('hide');
        }
    });
}

function toggleCallInputs() {
    const type = document.getElementById('call_type').value;
    const centerInputs = document.getElementById('centerInputs');

    if (type === 'call') {
        centerInputs.style.display = 'block';
    } else {
        centerInputs.style.display = 'none';
    }
}

function submitForm(event, form) {
    event.preventDefault();

    let data = new FormData(form);
    let $submitBtn = $(form).find('button[type="submit"]');
    $submitBtn.prop('disabled', true); 

    $.ajax({
        url: form.action,
        method: form.method,
        data: data,
        contentType: false,
        processData: false,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: (res) => {
            if (res.success) {
      
                form.reset();

        
                setTimeout(() => {
                    swal("Success!", res.message, "success");
                }, 100);   
                const tbody = $("#notesTable tbody");
                tbody.empty();
                res.notes.forEach((item, i) => {
                    let duration = "—";

                    if (item.call_start && item.call_end) {
                        const [sh, sm] = item.call_start.split(':').map(Number);
                        const [eh, em] = item.call_end.split(':').map(Number);

                        if (!isNaN(sh) && !isNaN(eh)) {
                            let startMinutes = sh * 60 + sm;
                            let endMinutes = eh * 60 + em;
                            let diff = endMinutes - startMinutes;
                            if (diff < 0) diff += 24 * 60;

                            let h = String(Math.floor(diff / 60)).padStart(2, '0');
                            let m = String(diff % 60).padStart(2, '0');
                            duration = `${h}:${m}:00`;
                        }
                    }

                    window.requestAnimationFrame(() => {
                        tbody.append(`
                            <tr>
                                <td>${i + 1}</td>
                                <td>${item.user?.name ?? '--'}</td>
                                <td>
                                    ${item.note ? item.note.substring(0, 50) + (item.note.length > 50 ? '...' : '') : ''}
                                    ${item.note && item.note.length > 50 ? 
                                        `<button class="btn btn-sm btn-primary view-note-btn"
                                            data-toggle="modal"
                                            data-target="#viewNoteModal"
                                            data-note="${item.note.replace(/"/g, '&quot;')}">
                                            View
                                        </button>` 
                                    : ''}
                                </td>
                                <td>${item.type ?? ''}</td>
                                <td>${duration}</td>
                                <td>${new Date(item.created_at).toLocaleString()}</td>
                                <td>${new Date(item.updated_at).toLocaleString()}</td>
                            </tr>
                        `);
                    });
                });
            } else {
                swal("Error!", res.message || "Something went wrong!", "error");
            }
        },
        error: () => swal("Error!", "Something went wrong!", "error"),
        complete: () => {
            $submitBtn.prop('disabled', false); 
        }
    });
}
document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('click', function(e) {
        if(e.target && e.target.classList.contains('view-note-btn')) {
            const noteText = e.target.getAttribute('data-note') || 'No note available';
            document.getElementById('noteContent').textContent = noteText;
        }
    });
});
</script>
<script>
function toggleShippingInput() {
    const status = document.getElementById('order_status').value;
    const shippingDiv = document.getElementById('shippingTextDiv');

    if(status === 'Shipping') {
        shippingDiv.style.display = 'block';
    } else {
        shippingDiv.style.display = 'none';
    }
}

document.addEventListener('DOMContentLoaded', () => {
    toggleShippingInput();
});
function submitOrderDeliveryForm(event, formElement) {
    event.preventDefault();
    let formData = new FormData(formElement);

    $.ajax({
        url: $(formElement).attr('action'),
        type: $(formElement).attr('method'),
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            if (response.code == 1) {
                //  formElement.reset();
                Swal.fire({
    icon: 'success',
    title: 'Success!',
    text: response.message
});
        $('#delivery_name').text(response.details.name);
        $('#delivery_phone').text(response.details.phone);
        $('#delivery_email').text(response.details.email);
        $('#delivery_city').text(response.details.city);
        $('#delivery_address').text(response.details.address);
        $('#delivery_postalcode').text(response.details.postalcode);
        $('#delivery_country').text(response.details.country);

        // Close modal
        $('#modal_order_Delivery').modal('hide');
            } else if (response.code == 0) {
                swal("Sorry!", response.message, "error");
            } else {
                swal("Sorry!", "Unexpected response", "error");
            }
        },
        error: function(xhr) {
            let errorMessage = "Something went wrong.";
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            Swal.fire({
    icon: 'error',
    title: 'Error!',
    text: errorMessage
});

        },
        complete: function() {
            $("#mainLoader1").modal('hide');
        }
    });
}

</script>
<script>


function submitGLSShipmentForm(event, formElement) {
    event.preventDefault();
    let formData = new FormData(formElement);
     $('#glsShipmentModal').modal('hide');
    // Show loader first
    $("#mainLoader1").modal('show');
 
    $.ajax({
        url: $(formElement).attr('action'),
        type: $(formElement).attr('method'),
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            console.log("GLS Response:", response);
            // Hide shipment modal first
           
            
            // Then show success message
            swal("Success!", "Shipment request sent!", "success");
             setTimeout(() => {
                location.reload();
            }, 2000);
        },
        error: function(xhr) {
            console.error(xhr.responseText);
            let errorMessage = "Something went wrong.";
            try {
                let res = JSON.parse(xhr.responseText);
                if(res.message) errorMessage = res.message;
            } catch(e) {}
            swal("Sorry!", errorMessage, "error");
        },
        complete: function() {
            // Hide loader at the end
            $("#mainLoader1").modal('hide');
        }
    });
}



function submitTrackForm(event) {
    event.preventDefault();

    let form = document.getElementById('trackShipmentForm');
    let formData = new FormData(form);
    let trackResult = document.getElementById('trackResult');

    trackResult.innerHTML = 'Loading...';

    $.ajax({
        url: form.action,
        method: form.method,
        data: formData,
        processData: false,
        contentType: false,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function(res) {
            if(res.status === 'success') {
                // Display parcel info nicely
                trackResult.innerHTML = `
                    <strong>Shipment Number:</strong> ${res.data.shipment_number}<br>
                    <strong>Recipient:</strong> ${res.data.recipient_name}<br>
                    <strong>Address:</strong> ${res.data.recipient_address}, ${res.data.recipient_city}, ${res.data.recipient_province}<br>
                    <strong>Date:</strong> ${res.data.shipment_date}<br>
                    <strong>Weight:</strong> ${res.data.weight} kg<br>
                    <strong>Packages:</strong> ${res.data.total_packages}<br>
                    <strong>Note:</strong> ${res.data.note || 'N/A'}<br>
                    ${res.data.label_url ? `<a href="${res.data.label_url}" target="_blank">Download PDF</a>` : ''}
                `;
            } else {
                trackResult.innerHTML = `<span class="text-danger">${res.message}</span>`;
            }
        },
        error: function(xhr) {
            let msg = 'Something went wrong.';
            if(xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
            trackResult.innerHTML = `<span class="text-danger">${msg}</span>`;
        }
    });
}

</script>
<script>
$(document).on('click', '.cancel-shipment-btn', function() {
    let shipmentNumber = $(this).data('shipment-number');
    let btn = $(this); // preserve reference to button

    if (!shipmentNumber) {
        Swal.fire({
            icon: 'warning',
            title: 'Oops!',
            text: 'No shipment number found'
        });
        return;
    }

    Swal.fire({
        title: `Cancel shipment #${shipmentNumber}?`,
        text: "This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, cancel it!',
        cancelButtonText: 'No, keep it'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Processing...',
                text: 'Please wait!',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });

            fetch("{{ route('gls.cancel') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ shipment_number: String(shipmentNumber) })
            })
            .then(response => response.json())
            .then(data => {
                Swal.close(); // close loading

                if(data.status === 'success'){
                    Swal.fire({
                        icon: 'success',
                        title: 'Cancelled!',
                        text: data.message
                    });

                    // Update UI: Replace button with badge
                    btn.replaceWith('<span class="badge badge-danger">Cancelled</span>');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message || 'Failed to cancel shipment'
                    });
                }
            })
            .catch(err => {
                Swal.close();
                console.error('Cancel error:', err);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Something went wrong. Please try again.'
                });
            });
        }
    });
});


</script>
<script>
function downloadLabel(event) {
    event.preventDefault(); // prevent page refresh

    let form = event.target;
    let formData = new FormData(form);

    $.ajax({
        url: form.action,
        method: form.method,
        data: formData,
        processData: false,
        contentType: false,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function(res) {
            if(res.status === 'success'){
                let binary = atob(res.binary); // decode base64
                let len = binary.length;
                let bytes = new Uint8Array(len);
                for (let i = 0; i < len; i++) {
                    bytes[i] = binary.charCodeAt(i);
                }
                let blob = new Blob([bytes], { type: res.type });
                let link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = res.filename;
                link.click();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: res.message
                });
            }
        },
        error: function(xhr){
            let msg = 'Something went wrong';
            if(xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: msg
            });
        }
    });
}

$(document).on('click', '.cancel-shipment-btn', function() {
    let shipmentNumber = $(this).data('shipment-number');
    let btn = $(this); // reference to button

    if(!shipmentNumber) {
        Swal.fire({
            icon: 'warning',
            title: 'Oops!',
            text: 'No shipment number found'
        });
        return;
    }

    Swal.fire({
        title: `Cancel shipment #${shipmentNumber}?`,
        text: "This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, cancel it!',
        cancelButtonText: 'No, keep it'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Processing...',
                text: 'Please wait!',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            fetch("{{ route('gls.cancel') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ shipment_number: String(shipmentNumber) })
            })
            .then(response => response.json())
            .then(data => {
                Swal.close(); // close loading

                if(data.status === 'success'){
                    Swal.fire({
                        icon: 'success',
                        title: 'Cancelled!',
                        text: data.message
                    });

                    // Update UI: Replace button with badge
                    btn.replaceWith('<span class="badge badge-danger">Cancelled</span>');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message || 'Failed to cancel shipment'
                    });
                }
            })
            .catch(err => {
                Swal.close();
                console.error('Cancel error:', err);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Something went wrong. Please try again.'
                });
            });
        }
    });
});
</script>


</script>
<script>
    $(document).on('click', '.track-btn', function () {
        var shipmentNumber = $(this).data('shipment');
        $('#shipment_number').val(shipmentNumber);
    });
</script>
<script>
$(document).on('click', '.view-shipment-btn', function () {

    let shipmentNumber = $(this).data('shipment-number');

    // reset old data
    $('#shipmentModal span').text('-');

    $.ajax({
        url: "{{ route('shipment.details.ajax') }}", // backend route
        type: "GET",
        data: {
            shipment_number: shipmentNumber
        },
        success: function (res) {

            $('#m_shipment_no').text(res.ShipmentNumber);
            $('#m_status').text(res.shipment_status);
            $('#m_date').text(res.shipment_date);
            $('#m_weight').text(res.weight);

            $('#m_name').text(res.name);
            $('#m_phone').text(res.phone);
            $('#m_city').text(res.city);
            $('#m_postal').text(res.postalcode);
            $('#m_address').text(res.address);

            $('#m_sender_name').text(res.sender_name);
            $('#m_sender_phone').text(res.sender_phone);
            $('#m_sender_city').text(res.sender_city);
            $('#m_sender_country').text(res.sender_country);

            // update cancel button shipment number
            $('.cancel-shipment-btn').data('shipment-number', res.ShipmentNumber);
        },
        error: function () {
            alert('Failed to load shipment details');
        }
    });

});




</script>
<script>
$(document).on('click', '.download-label-btn', function() {
    var shipmentNumber = $(this).data('shipment-number');
    $('#download_shipment_number').val(shipmentNumber);
});
</script>
<script>
$('#checkAddressBtn').on('click', function () {

    let city = $('input[name="recipient_city"]').val().trim();
    let postalcode = $('input[name="recipient_postalcode"]').val().trim();
    let address = $('textarea[name="recipient_address"]').val().trim();

    if (!city || !postalcode || !address) {
        $('#addressResult').html(`
            <div class="alert alert-danger">
                Please fill City, Postal Code and Address first
            </div>
        `);
        return;
    }

    let data = {
        city: city,
        postalcode: postalcode,
        address: address,
        _token: '{{ csrf_token() }}'
    };

    $.ajax({
        url: "{{ route('gls.adresss.fetch') }}",
        type: "POST",
        data: data,
        beforeSend: function () {
            $('#addressResult').html('<p>Checking address...</p>');
        },
        success: function (res) {

            if (res.status === true) {
                $('#addressResult').html(
                    `<div class="alert alert-success">${res.message}</div>`
                );
                return;
            }

            if (!res.list || res.list.length === 0) {
                $('#addressResult').html(
                    `<div class="alert alert-warning">No address suggestions found</div>`
                );
                return;
            }

            let html = `
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th># ID</th>
                        <th>City</th>
                        <th>Province</th>
                        <th>ZIP</th>
                        <th>ETA</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>`;

            res.list.forEach(function (item) {
                html += `
                <tr>
                    <td>${item.id}</td>
                    <td>${item.city}</td>
                    <td>${item.province}</td>
                    <td>${item.cap}</td>
                    <td>${item.eta} hrs</td>
                    <td>
                        <button class="btn btn-sm btn-success selectAddress"
                            data-city="${item.city}"
                            data-province="${item.province}"
                            data-cap="${item.cap}">
                            Select
                        </button>
                    </td>
                </tr>`;
            });

            html += `</tbody></table>`;
            $('#addressResult').html(html);
        },
        error: function (xhr) {

            let msg = 'Something went wrong';

            if (xhr.status === 422 && xhr.responseJSON?.errors) {
                msg = Object.values(xhr.responseJSON.errors)
                    .flat()
                    .join('<br>');
            } else if (xhr.responseJSON?.message) {
                msg = xhr.responseJSON.message;
            }

            $('#addressResult').html(`
                <div class="alert alert-danger">
                    ${msg}
                </div>
            `);
        }
    });
});

$(document).on('click', '.selectAddress', function () {
    // Get data from the clicked row
    var selectedCity = $(this).data('city');
    var selectedProvince = $(this).data('province');
    var selectedCap = $(this).data('cap');
    
    // Fill the recipient fields
    $('input[name="recipient_city"]').val(selectedCity);
    $('input[name="recipient_postalcode"]').val(selectedCap);
    $('input[name="sender_province"]').val(selectedProvince);
    
    // Also update the sender's city if you want it to match
    // $('input[name="sender_city"]').val(selectedCity);
    
    $('#addressResult').html(
        '<div class="alert alert-info">Address selected successfully</div>'
    );
});




function updateOrderStatus(orderId) {

    $.ajax({
        url: "{{ route('order.updateStatus') }}",
        type: "GET",
        data: { order_id: orderId },
        success: function (response) {

            if(response.code === 1){

                $('#modal_order_id').val(response.order.id);

                // 🔥 yahan DB wala status selected hoga
                $('#modal_status').val(response.order.status);

                $('#orderStatusModal').modal('show');

            }else{
                alert('Order not found');
            }
        }
    });
}
function saveOrderStatus() {
    let orderId = $('#modal_order_id').val();
    let status  = $('#modal_status').val();

    $.ajax({
        url: "{{ route('order.saveStatus') }}",
        type: "GET",
        data: { order_id: orderId, status: status },
        success: function(response) {
            if(response.code === 1){
                $('#orderStatusModal').modal('hide');

                // ✅ Badge update
                let badge = $('#order-status-badge-' + orderId);
                badge.text(status);

                // Remove old color
                badge.removeClass('bg-primary bg-warning bg-success bg-danger bg-secondary');

                // Add new color dynamically
                let colorClass = '';
                switch(status){
                    case 'Pending': colorClass = 'bg-warning'; break;
                    case 'Completed': colorClass = 'bg-success'; break;
                    default: colorClass = 'bg-secondary';
                }
                badge.addClass(colorClass);

                // ✅ SweetAlert
                Swal.fire({
                    icon: 'success',
                    title: 'Status Updated!',
                    text: 'Order Status successfully updated',
                    timer: 1500,
                    showConfirmButton: false
                });

            } else {
                alert(response.message || 'Update failed');
            }
        },
        error: function(xhr, status, error) {
            alert('Server error: ' + error);
        }
    });
}






</script>

@endsection