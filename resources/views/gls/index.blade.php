@extends('layout.master')
@section('title',"Order | Info")
@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


<div class="card">
    <!-- /.box-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                @php
                    if (!empty(request('back_url'))) {
                        $back_url = request('back_url');
                    } else {
                        $back_url = url()->previous();
                    }
                @endphp

                @include('components.panelBackbutton',['backUrl'=>$back_url])
            </div>
            <div class="col-md-6">
            </div>
        </div>
        
       
        <br>
    </div>

    
<div class="container">
    <h3 class="mb-3"><strong>Confirm order</strong></h3>

    <form id="glsShipmentForm" method="POST" action="{{ route('create.shipment') }}" onsubmit="submitGLSShipmentForm(event, this)">
        @csrf
        <input type="hidden" name="payment_id" value="{{ $item->id }}">

        <!-- Sender Information -->
        <hr>
        <h4 class="mt-2 mb-2"><strong>Sender Information</strong></h4>
        <div class="row">
            <div class="col-md-6 mt-2">
                <label class="form-label">Sender Name</label>
                <input type="text" class="form-control" name="sender_name" placeholder="Your Sender Name" value="{{ $user_primary_address->name }}" required>
            </div>
            <div class="col-md-6 mt-2">
                <label class="form-label">Sender Phone</label>
                <input type="text" class="form-control" value="{{ $user_primary_address->phone }}" name="sender_phone" placeholder="+39123456789">
            </div>
            <div class="col-md-12 mt-2">
                <label class="form-label">Sender Address</label>
                <input type="text" class="form-control" name="sender_address" value="{{ $user_primary_address->address }}" required>
            </div>
            <div class="col-md-4 mt-2">
                <label class="form-label">Sender City</label>
                <input type="text" class="form-control" name="sender_city" placeholder="Milano" value="{{ $user_primary_address->city }}" required>
            </div>
            <div class="col-md-4 mt-2">
                <label class="form-label">Sender Postal Code</label>
                <input type="text" class="form-control" name="sender_postalcode" value="{{ $user_primary_address->postal_code }}" placeholder="20100" required>
            </div>
            <div class="col-md-6 mt-2">
                <label class="form-label">Country</label>
   <select  class="form-control" name="country" >
                  <option value="IT" {{ $item->country=='IT'?'selected':'' }}>Italy</option>
                  <option value="US" {{ $item->country=='US'?'selected':'' }}>US</option>
                </select>
            </div>
            <div class="col-md-4 mt-2">
                <label class="form-label">Sender Province</label>
                <input type="text" class="form-control" name="sender_province" value="{{ $user_primary_address->province }}" placeholder="MI" required>
            </div>
        </div>

        <!-- Recipient Information -->
        <hr>
        <h4 class="mt-2 mb-2"><strong>Recipient Information</strong></h4>
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
                <input type="hidden" class="form-control" name="payment_id" value="{{ $item->id }}" required>
            </div>
            <div class="col-md-12 mt-2">
                <label class="form-label">Address</label>
                <textarea class="form-control" name="recipient_address" rows="2" required>{{ $item->address }}</textarea>
            </div>
            <div class="col-md-4 mt-2">
                <label class="form-label">Postal Code</label>
                <input type="text" class="form-control" name="recipient_postalcode" value="{{ $item->postalcode }}" required>
            </div>
            <div class="col-md-4 mt-2">
                <label class="form-label">Country</label>
                <select  class="form-control" name="country" >
                  <option value="IT" {{ $item->country=='IT'?'selected':'' }}>Italy</option>
                  <option value="US" {{ $item->country=='US'?'selected':'' }}>US</option>
                </select>
            </div>
            <div class="col-md-4 mt-2">
                <label class="form-label">Province</label>
                <input type="text" class="form-control" name="recipient_province" value="{{ $item->state }}" required>
            </div>
            <div class="col-md-6 mt-2">
                <label class="form-label">Shipment Weight (kg)</label>
                <input type="number" class="form-control" name="weight" value="1" required>
            </div>
            <div class="col-md-6 mt-2">
                <label class="form-label">Product Id</label>
                <input type="text" class="form-control" name="reference" value="{{ $item->id }}" readonly>
            </div>
            <div class="col-md-12 mt-2">
    <label class="form-label">Note</label>
    <textarea class="form-control" name="note" rows="3" placeholder="Enter any note here...">{{ $item->ship_note ?? '' }}</textarea>
</div>
        </div>

        <div class="col-md-12 mt-3">
            <button type="button" id="checkAddressBtn" style="margin-left: -12px;" class="btn btn-primary">Check Address</button>
        </div>
        <div class="col-md-12 mt-3" id="addressResult"></div>

        <!-- Up Sell Selection -->
        <hr>
        <div class="col-md-12 mt-3">
            <label class="form-label"><strong>Select Up Sell</strong></label>
            <select class="form-control" name="upsell_id" id="upsellSelect">
                <option value="">-- Select Up Sell --</option>
                @foreach($UpSells as $UpSell)
                    <option value="{{ $UpSell->id }}">
                        {{ $UpSell->name }} || Added Price+{{ $UpSell->price }}
                    </option>
                @endforeach
            </select>
        </div>

<button type="button"  style="margin-left: 5px;"
        id="addCustomUpsellBtn" 
        class="btn btn-primary mb-3" 
        data-bs-toggle="modal" 
        data-bs-target="#addUpSellModal">
    Add Custom Up Sell
</button>
    <div id="upsellItemList" class="mt-3">
    <!-- items yahan JS se add honge -->
</div>
<div class="col-md-6 mt-3">
    <label class="form-label"><strong>Total Price ( {{$item->currency}} )</strong></label>
    <input type="number" step="0.01" class="form-control" name="total_price" id="totalPrice" value="{{ $item->amount ?? 0 }}"  required>
</div>
    <div class="mt-4 d-flex justify-content-end" style="margin: 10px">
    <button type="submit" class="btn btn-primary" id="glsSubmitBtn" >Confirm order</button>
</div>
     
 
    </form>
</div>

</div>
    <div class="modal fade" id="addUpSellModal" tabindex="-1" aria-labelledby="addUpSellModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="upsellForm" action="{{ route('upsell.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add Up Sell</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Up Sell Name</label>
                            <input type="text" class="form-control" name="title" required>
                            <input type="hidden" class="form-control" name="type" value="custom">
                        </div>
                        <div class="mb-3">
                            <label>Price</label>
                            <input type="number" class="form-control" name="price" min="0" step="0.01" required>
                        </div>
                       @if($item)
                        <input type="hidden" name="product_id" value="{{ $item->id }}">
                    @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Add Up Sell</button>
                    </div>
                </form>
            </div>
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
         <input type="hidden"  name="payment_id" value="{{$item->id}}">
          
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
                    <input type="hidden" name="payment_id" value="{{$item->id}}">
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
<div class="modal fade" id="UpsellViewModal" tabindex="-1" aria-labelledby="UpsellViewModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      
      <div class="modal-header">
        <h5 class="modal-title" id="UpsellViewModalLabel">Upsell Detail</h5>
      </div>
      
      <div class="modal-body">
        Loading...
      </div>
      
     
     <div class="modal-footer">
             



                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    Close
                </button>
            </div>
    </div>
  </div>
</div>


<div class="modal fade" id="addUpsellItemModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
     <form id="upsellForm" action="{{ route('item.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add Up Sell Item</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Up Sell Name</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                       
                       <input type="hidden" name="product_id" value="{{ $item->id }}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Add Item</button>
                    </div>
                </form>
  </div>
</div>



   <div class="modal fade" id="addItemUpSellModal" tabindex="-1" aria-labelledby="addUpSellModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="ItemupsellForm" action="{{ route('item.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add Up Sell Item</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Up Sell Item Name</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                       
                       <input type="hidden" name="product_id" id="upsell_product_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Add Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<div class="card">
    <div class="card-header">
        <h3>GLS Shipment History </h3>
    </div>
    <div class="card-body">
        <table id="notesTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User Name</th>
                    <th>Added By</th>
                    <th >address</th>
                    <th>Shipment Number </th>
                    <th>Shipment Status</th>
                    <th>Total Price</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($item->parcel as $index => $parcel)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $parcel->name ?? '—' }}</td>
                        <td>
                            {{ $parcel->user->name ?? '—' }}<br>
                           ({{ $parcel->user->email ?? '—' }})
                        </td>
                        <td>
                            {{ Str::limit($parcel->address, 50, '...') }}
                          
                        </td>
                        <td>{{ $parcel->ShipmentNumber }}</td>
                        <td>
                           <div class="badge badge-{{$parcel->shipment_status=='Cancelled'?'danger':'default'  }}">{{ $parcel->shipment_status }}</div>
                          
                        </td>
                        <td>
                           {{ $parcel->total_price }}
                          
                        </td>
                        <td>{{ $parcel->created_at->format('d M Y, h:i A') }}</td>
                        <td>{{ $parcel->updated_at->format('d M Y, h:i A') }}</td>
                         <td>     
      <button class="btn btn-primary btn-sm view-shipment-btn" data-toggle="modal" data-target="#shipmentModal"  data-shipment-number="{{ $parcel->id }}">
    <i class="fas fa-shipping-fast"></i> View
</button>
                
<button
    class="btn btn-primary btn-sm track-btn"
    data-toggle="modal"
    data-target="#trackShipmentModal"
    data-shipment="{{ $parcel->ShipmentNumber }}"
>
    <i class="fas fa-truck"></i> Track
</button>
<button type="button" 
        class="btn btn-primary btn-sm download-label-btn"
        data-toggle="modal" 
        data-target="#downloadLabelModal"
        data-shipment-number="{{ $parcel->ShipmentNumber }}">
    <i class="fas fa-download"></i> Download Label
</button>
@if ($parcel->is_close_work_day==1)
 <a href="#"  class="btn btn-primary btn-sm download-label-btn" >
    <i class="fas fa-checkbox"></i> Confirmed
</a> 
 @else
 <a href="{{ route('closeWorkDay.shipment.number',$parcel->id) }}"  class="btn btn-primary btn-sm download-label-btn" >
    <i class="fas fa-checkbox"></i> Confirm
</a>   
@endif
<button 
    class="btn btn-primary btn-sm view-uppsell-btn"
    data-url="{{ url('parcel/upsell/'.$parcel->id) }}"
    data-toggle="modal"
    data-target="#UpsellViewModal">
    <i class="fas fa-shipping-fast"></i> Upp Sell
</button>

                
                         </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
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
        const value = parseFloat($('#totalPrice').val());
        const min   = parseFloat($('#totalPrice').prop('min'));

         let noteValue = $(formElement).find('textarea[name="note"]').val();
        
        if (!isNaN(value) && value < min) {
            alert("Minimum amount is " + min.toFixed(2));
            return;
        }
    let formData = new FormData(formElement);
    formData.set('note', noteValue);
  
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
                  setTimeout(() => {
                    location.reload();
                  }, 2000);
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
 let paymentInput = form.querySelector('input[name="payment_id"]');
 if(paymentInput) {
        formData.set('payment_id', paymentInput.value);
    }
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
   let payment_id = {{ $item->id }}; 
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
                body: JSON.stringify({
                     shipment_number: String(shipmentNumber) ,
                    payment_id: payment_id 
                    })
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
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
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
    let province = $('input[name="recipient_province"]').val().trim();
    let address = $('textarea[name="recipient_address"]').val().trim();
    let payment_id = $('input[name="payment_id"]').val().trim();

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
        province:province,
        payment_id:payment_id,
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
                        <th>City</th>
                        <th>Province</th>
                        <th>ZIP</th>
                        <th>Street</th>
                        <th>ETA</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>`;

            res.list.forEach(function (item) {
                html += `
                <tr>
                    <td>${item.city}</td>
                    <td>${item.province}</td>
                    <td>${item.cap}</td>
                    <td>${item.street}</td>
                    <td>${item.eta} hrs</td>
                    <td>
                        <button class="btn btn-sm btn-success selectAddress"
                            data-city="${item.city}"
                            data-street="${item.street}"
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

    var selectedCity = $(this).data('city');
    var selectedProvince = $(this).data('province');
    var selectedCap = $(this).data('cap');
    var street = $(this).data('street');

var selectedCity = $(this).data('city');
var selectedProvince = $(this).data('province');
var selectedCap = $(this).data('cap');
var street = $(this).data('street');

if (selectedCity) {
    $('input[name="recipient_city"]').val(selectedCity);
}

if (selectedCap) {
    $('input[name="recipient_postalcode"]').val(selectedCap);
}

if (selectedProvince) {
    $('input[name="sender_province"]').val(selectedProvince);
}

if (street) {
    $('textarea[name="recipient_address"]').val(street);
}

    $('#addressResult').html(`
        <div class="alert alert-info d-flex justify-content-between align-items-center">
            <span>Address selected successfully</span>
            <button type="button" class="btn btn-sm btn-danger removeAddressBtn">
                Remove
            </button>
        </div>
    `);
});
$(document).on('click', '.removeAddressBtn', function () {

    // Message remove
    $('#addressResult').empty();

   
});
$(document).ready(function(){
      // CSRF token for AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // ============ PRICE CALCULATION ============
    let basePrice = {{ $item->amount ?? 0 }};
    let selectedUpsellPrice = 0;
    let customUpsellPrice = 0;
    
    function updateTotalPrice() {
        let total = parseFloat(basePrice) + parseFloat(selectedUpsellPrice) + parseFloat(customUpsellPrice);
        $('#totalPrice').val(total.toFixed(2));
      
      
    }
    
    // Initial calculation - یہ لائن ایڈ کریں!
    updateTotalPrice();
    // 1. ADD UP SELL FORM
    $('#upsellForm').submit(function(e){
        e.preventDefault();

        var form = $(this);
        var url = form.attr('action');
        var data = form.serialize();
      
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function(response){
                $('#addUpSellModal').modal('hide');
                $('#upsellForm')[0].reset();
        $('#addCustomUpsellBtn').fadeOut(300);
        // Remove "No Up Sell" message if exists
        $('#noUpsellRow').remove();
   $('#upsellSelect').prop('disabled', true);
       selectedUpsellPrice = 0;
    $('#upsellSelect').val('');
    
    // Set custom upsell price
    customUpsellPrice = parseFloat(response.upsell.price);
    updateTotalPrice();
        // Create container if it doesn't exist
        if($('#dynamicUpsellList').length === 0){
            $('<div id="dynamicUpsellList" class="mt-3"></div>').insertAfter('select[name="upsell_id"]');
        }

        // Remove any previous custom upsell
        $('#dynamicUpsellList').empty();

        // Append the new upsell with a button, styled
            let upsellHtml = `
                <div class="d-flex align-items-center mb-2" 
                    data-upsell-id="${response.upsell.id}" 
                    style="gap: 10px; max-width: 500px;">
                    <input type="text" class="form-control" 
                        value="${response.upsell.name} || ${response.upsell.price}" 
                        readonly style="flex: 1;">
                        <input type="hidden" name="upsell_id" value="${response.upsell.id}">
<button
    type="button"
    class="btn btn-primary mb-3 addUpsellItemBtn"
    data-upsell-id="${response.upsell.id}"
    data-bs-toggle="modal"
    data-bs-target="#addItemUpSellModal">
    Add Up Sell Item
</button>
<button
    type="button"
    class="btn btn-danger mb-3 deleteUpsellItemBtn"
    data-upsell-id="${response.upsell.id}">
    Delete Up Sell Item
</button>

                    </div>
            `;

        $('#dynamicUpsellList').append(upsellHtml);

        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: response.message
        });
            },
            error: function(xhr){
                if(xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let message = '';
                    for(let key in errors){
                        message += errors[key][0] + '\n';
                    }
                    alert(message);
                } else {
                    alert('Something went wrong!');
                }
            }
        });
    });
    });
$('#ItemupsellForm').on('submit', function(e){
    e.preventDefault();

    let form = $(this);
    let url = form.attr('action');
    let data = form.serialize();

    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        success: function(response){

            if(response.code !== 1){
                Swal.fire('Error', 'Failed to add item', 'error');
                return;
            }

            // ✅ correct modal close
            $('#addItemUpSellModal').modal('hide');

            // reset form
            form[0].reset();

            // ✅ append item
          let html = `
                <div class="alert alert-secondary d-flex justify-content-between align-items-center" 
                    data-upsell-id="${response.upsell.id}">
                    
                    <span>
                        <strong>${response.upsell.name}</strong>
                    </span>

                    <div>
                        <span class="badge bg-success me-2">Added</span>
                        
                        <button type="button" 
                            class="btn btn-sm btn-danger deleteUpsellDelete"
                            data-upsell-id="${response.upsell.id}">
                            Delete
                        </button>
                    </div>
                </div>
            `;
            $('#upsellItemList').append(html);

            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: response.message
            });
        },
        error: function(xhr){
            Swal.fire('Error', 'Something went wrong', 'error');
        }
    });
});

    // When the "Add Item this upsell" button is clicked
$(document).on('click', '.selectUpsellBtn', function() {
    const upsellId = $(this).closest('[data-upsell-id]').data('upsell-id');
    const upsellTitle = $(this).siblings('input').val();

    // Set hidden input and prefill item name
    $('#upsellIdHidden').val(upsellId);
    $('#itemName').val(upsellTitle);

    // Show the modal
    const upsellModal = new bootstrap.Modal(document.getElementById('addUpsellItemModal'));
    upsellModal.show();
});
$(document).on('click', '.addUpsellItemBtn', function () {
    let upsellId = $(this).data('upsell-id');

    // hidden input میں set کرو
    $('#upsell_product_id').val(upsellId);
});
</script>
<script>
$(document).on('click', '.deleteUpsellItemBtn', function () {

    let button = $(this); // current button
    let upsellId = button.data('upsell-id');

    if (!confirm('Are you sure you want to delete this item?')) {
        return;
    }

    $.ajax({
        url: "{{ route('delete.custom.upsell') }}",
        type: "GET",
        data: {
            upsell_id: upsellId
        },
   success: function (response) {
  customUpsellPrice = 0;
    updateTotalPrice();
        // 🔥 Remove that upsell div
        $('[data-upsell-id="'+ upsellId +'"]').remove();

        // ✅ Button enable
        $('#addCustomUpsellBtn').prop('disabled', false).fadeIn(300);

        // ✅ Dropdown bhi enable karo
        $('#upsellSelect').prop('disabled', false);

        // (Optional) Dropdown value bhi reset karna ho to:
        $('#upsellSelect').val('');

        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Item Deleted Successfully'
        });

    },
        error: function () {
            alert('Something went wrong!');
        }
    });

});
$(document).on('click', '.deleteUpsellDelete', function () {

    let button = $(this);
    let upsellId = button.data('upsell-id');

    if (!confirm('Are you sure you want to delete this upsell?')) {
        return;
    }

    $.ajax({
        url: "{{ route('delete.custom.item') }}",
        type: "GET",
        data: {
            upsell_id: upsellId
        },
        success: function (response) {

            if(response.status === true){

                // Remove that specific div
               $('.alert[data-upsell-id="'+ upsellId +'"]').remove();


              

                Swal.fire({
                    icon: 'success',
                    title: 'Deleted!',
                    text: response.message
                });

            } else {
                Swal.fire('Error', response.message, 'error');
            }
        },
        error: function () {
            Swal.fire('Error', 'Something went wrong!', 'error');
        }
    });

});

</script>
<script>
$(document).ready(function(){
    $('#upsellSelect').on('change', function() {
        if ($(this).val() != '') {
          
            $('#addCustomUpsellBtn').prop('disabled', true);
         
            // ============ Get price from selected upsell ============
            let selectedText = $(this).find('option:selected').text();
            let priceMatch = selectedText.match(/Added Price\+(\d+(\.\d{1,2})?)/);
              
            if (priceMatch) {
                selectedUpsellPrice = parseFloat(priceMatch[1]);
                customUpsellPrice = 0; // Reset custom if dropdown selected
            }
            updateTotalPrice();
        } else {
            $('#addCustomUpsellBtn').prop('disabled', false);
            
            // ============ Reset price when dropdown is cleared ============
            selectedUpsellPrice = 0;
            updateTotalPrice();
        }
    });

    $('#addCustomUpsellBtn').on('click', function() {
        // Modal will be opened via data-bs-toggle attribute
        // No additional action needed here
    });
});

// Add this missing function for updating price
function updateTotalPrice() {
    let basePrice = {{ $item->amount ?? 0 }};
    let selectedUpsellPrice = 0;
    let customUpsellPrice = 0;
    
    // Get selected upsell price
    let selectedOption = $('#upsellSelect option:selected');
    if (selectedOption.val()) {
        let selectedText = selectedOption.text();
        let priceMatch = selectedText.match(/Added Price\+(\d+(\.\d{1,2})?)/);
        if (priceMatch) {
            selectedUpsellPrice = parseFloat(priceMatch[1]);
        }
    }
    
    // Get custom upsell price if exists
    let customUpsellInput = $('[name="upsell_id"]').closest('div').find('input[readonly]');
    if (customUpsellInput.length) {
        let customText = customUpsellInput.val();
        let customMatch = customText.match(/\|\|\s*\$([\d\.]+)/);
        if (customMatch) {
            customUpsellPrice = parseFloat(customMatch[1]);
        }
    }
    
    let total = parseFloat(basePrice) + selectedUpsellPrice + customUpsellPrice;
    $('#totalPrice').val(total.toFixed(2));
    $('#totalPrice').prop('min',total.toFixed(2));
}

// Call updateTotalPrice on page load
$(document).ready(function() {
    updateTotalPrice();
});



</script>
<script>
$(document).ready(function() {
    let addressSelected = false;
    
    // Initialize submit button as disabled
    $('#glsSubmitBtn').prop('disabled', true);
    
    // Function to check if both conditions are met
    function checkSubmitButton() {
        if (addressSelected) {
            $('#glsSubmitBtn').prop('disabled', false);
        } else {
            $('#glsSubmitBtn').prop('disabled', true);
        }
    }
    
    // Address selection check
    $(document).on('click', '.selectAddress', function() {
        addressSelected = true;
        checkSubmitButton();
    });
    
    // Remove address selection
    $(document).on('click', '.removeAddressBtn', function() {
        addressSelected = false;
        checkSubmitButton();
    });
    
   
   
    
    // Upsell selection check - custom upsell creation
    $('#upsellForm').submit(function(e) {
        e.preventDefault();
        
        var form = $(this);
        var url = form.attr('action');
        var data = form.serialize();
        
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function(response) {
                $('#addUpSellModal').modal('hide');
                $('#upsellForm')[0].reset();
                
                // Mark upsell as selected
              
            },
            error: function(xhr) {
                // Error handling remains same
            }
        });
    });
    
    // If custom upsell is deleted
  
    
    // Form submission validation
    $('#glsShipmentForm').on('submit', function(event) {
          if (!addressSelected) {
            event.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Address Required',
                text: 'Please select an address from the suggestions'
            });
            return false;
        }
        
        if (!addressSelected) {
            event.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Address Required',
                text: 'Please select an address from the suggestions'
            });
            return false;
        }
        
        if (!upsellSelected) {
            event.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Upsell Required',
                text: 'Please select or create an upsell'
            });
            return false;
        }
        
        const value = parseFloat($('#totalPrice').val());
        const min = parseFloat($('#totalPrice').prop('min'));
        if (!isNaN(value) && value < min) {
            event.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Minimum Amount Required',
                text: `Minimum amount is ${min.toFixed(2)}`
            });
            return false;
        }
        
        return true;
    });
});



</script>

<script>
$(document).ready(function() {
    let addressSelected = false;
 
    
   
    $('#glsSubmitBtn').prop('disabled', true);
    
    // Function to check if both conditions are met
    function checkSubmitButton() {
        if (addressSelected) {
            $('#glsSubmitBtn').prop('disabled', false);
        } else {
            $('#glsSubmitBtn').prop('disabled', true);
        }
    }
    
    // Address selection check
    $(document).on('click', '.selectAddress', function() {
        addressSelected = true;
        checkSubmitButton();
    });
    
    // Remove address selection
    $(document).on('click', '.removeAddressBtn', function() {
        addressSelected = false;
        checkSubmitButton();
    });
    
    
    // Upsell selection check - custom upsell creation
    $('#upsellForm').submit(function(e) {
        e.preventDefault();
        
        var form = $(this);
        var url = form.attr('action');
        var data = form.serialize();
        
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function(response) {
                $('#addUpSellModal').modal('hide');
                $('#upsellForm')[0].reset();
                
           
            },
            error: function(xhr) {
                // Error handling remains same
            }
        });
    });
    
    // If custom upsell is deleted
 
    
    // Form submission validation
    $('#glsShipmentForm').on('submit', function(event) {
        if (!addressSelected) {
            event.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Address Required',
                text: 'Please select an address from the suggestions'
            });
            return false;
        }
        
        if (!upsellSelected) {
            event.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Upsell Required',
                text: 'Please select or create an upsell'
            });
            return false;
        }
        
        const value = parseFloat($('#totalPrice').val());
        const min = parseFloat($('#totalPrice').prop('min'));
        
        
        return true;
    });
});


</script>
<script>
$(document).on('click', '.view-uppsell-btn', function () {
    let url = $(this).data('url');

    // Bootstrap 5 Modal instance
    let upsellModalEl = document.getElementById('UpsellViewModal');
    let upsellModal = new bootstrap.Modal(upsellModalEl);

    $('#UpsellViewModal .modal-body').html('Loading...');
    upsellModal.show();  // ✅ یہاں show کر رہے ہیں

    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.status !== 1 || !response.data) {
                $('#UpsellViewModal .modal-body')
                    .html('<p class="text-danger">No upsell found</p>');
                return;
            }

            let html = `
                <p><strong>Upsell Name:</strong> ${response.data.name}</p>
                <p><strong>Price:</strong> ${response.data.price}</p>
            `;

            if (response.items && response.items.length > 0) {
                html += `<hr><strong>Upsell Items:</strong><ul>`;
                response.items.forEach(function(item){
                    html += `<li>${item.name}</li>`;
                });
                html += `</ul>`;
            } else {
                html += `<p><em>No upsell items</em></p>`;
            }

            $('#UpsellViewModal .modal-body').html(html);
        },
        error: function () {
            $('#UpsellViewModal .modal-body')
                .html('<p class="text-danger">Failed to load upsell</p>');
        }
    });
});




</script>

@endsection