@extends('layout.master')
@section('title',"HR | Projects")
@section('content')

<style>
    .info-box{
    border: dotted 2px gray;
    padding:10px
    }
    .json-container {
    background: #lightgrey;
    color:green !important;
    padding: 15px;
    max-height: 350px;
    overflow-y: auto;
    font-size: 13px;
    font-family: Consolas, Monaco, monospace;
}
</style>


        <div class="card">
            <!-- /.box-header -->
            <div class="card-body">
                <div class="row">
                <div class="col-md-6">
                    @php
                             if(!empty(request('back_url')))
                                {
                               $back_url= request('back_url');
                                }else {
                                    $back_url= route('pmm.transactions.view');
                                }

                    @endphp
                @include('components.panelBackbutton',['backUrl'=>$back_url])
                </div>
                <div class="col-md-6">
                <h3 style="text-align: right">Trasnsaction</h3>
                </div>
        </div>
      <div class="row">
        <div class="col-md-12">


            <div class="modal-body">

            <div class="row">
                <div class="col-md-6 info-box" >

                         <div class="row">
                        <div class="col-md-6">
                        <h3> Payment Details</h3>
                        </div>
                        <div class="col-md-6">
                        @if(is_has_permission('pmm.transactions.order_details'))
                            <a class="dropdown-item app-action-btn"  href="javascript:void" data-toggle="modal" data-target="#modal_order_details{{$item->id}}"  ><i class="fas fa-edit"></i> Edit Order</a>
                        @endif
                        </div>
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
                        <label>Order Status</label> : <span class="badge bg-{{ app_getStatusColor($item->order_status) }} badge-sm" style="color:white;font-size:10px;padding:4px;padding-left:5px;padding-left:5px">{{ $item->order_status }}</span>
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
                     @if(is_has_permission('pmm.transactions.order_details'))
                        <h3>Delivery Details</h3>
                     <div class="row">
                        <div class="col-md-6">
                        <label>Name</label> : {{ $item->name}}
                        </div>
                        <div class="col-md-6">
                            <label>Phone</label> : {{ $item->phone }}
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                        <label>Email</label> : {{ $item->email}}
                        </div>
                        <div class="col-md-6">
                            <label>City</label> : {{ $item->city }}
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                        <label>Address</label> : {{ $item->address}}
                        </div>
                        <div class="col-md-6">
                            <label>Postal Code</label> : {{ $item->postalcode }}
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                        <label>Quantity</label> : {{ $item->quantity}}
                        </div>
                        <div class="col-md-6">
                        <label>Country</label> : {{ $item->country}}
                        </div>
                        <div class="col-md-6">
                            <label>Comeback Link</label> : {{get_comebackurl_link($item->id)}}
                        </div>
                      <div class="col-md-6">
                            <label>Comeback Message</label> : {{$item->is_comeback_notified==1?'Sent':"Not Yet!"}}
                        </div>
                     </div>

                     @endif
                </div>

            </div>
  <div class="row">
                <div class="col-md-6 info-box" >

                         <div class="row">
                        <div class="col-md-6">
                        <h3> Product Details</h3>
                        </div>
                        <div class="col-md-6">
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
          @if(is_has_permission('pmm.transactions.full_control'))
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
                  @endif
                   @if(is_has_permission('pmm.transactions.full_control') || $item->link->user_id=auth_user_id())
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
                 @endif
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
        @if(is_admin())
                @php
                    $request_payload = [];

                    if (!empty($item->request_payload)) {
                        $request_payload = json_decode($item->request_payload, true);
                    }

                    $prettyJson = json_encode($request_payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
                @endphp

                <div class="col-md-6">

                    <div class="card shadow-sm">

                        <div class="card-header d-flex justify-content-between align-items-center">
                            <strong>Request Payload</strong>

                            <div class="btn-group btn-group-sm">

                                <button class="btn btn-outline-primary"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#payloadPanel{{ $item->id }}">
                                    Show / Hide
                                </button>
                            </div>
                        </div>

                        <!-- 🔽 Starts HIDDEN (no "show" class) -->
                        <div class="collapse" id="payloadPanel{{ $item->id }}">
                            <div class="card-body p-0">
                                <div class="json-container">
                                    <pre id="jsonOutput{{ $item->id }}">{{ $prettyJson }}</pre>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                @endif
        @if(is_admin())
                @php
                    $response_payload = [];

                    if (!empty($item->processor_response)) {
                        $response_payload = json_decode($item->processor_response, true);
                    }

                    $prettyJson2 = json_encode($response_payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
                @endphp

                <div class="col-md-6">

                    <div class="card shadow-sm">

                        <div class="card-header d-flex justify-content-between align-items-center">
                            <strong>Response Payload</strong>

                            <div class="btn-group btn-group-sm">

                                <button class="btn btn-outline-primary"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#payloadPanel2{{ $item->id }}">
                                    Show / Hide
                                </button>
                            </div>
                        </div>

                        <!-- 🔽 Starts HIDDEN (no "show" class) -->
                        <div class="collapse" id="payloadPanel2{{ $item->id }}">
                            <div class="card-body p-0">
                                <div class="json-container">
                                    <pre id="jsonOutput{{ $item->id }}">{{ $prettyJson2 }}</pre>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                @endif

            </div>

            </div>


        </div>


      </div>
    @if(is_admin())
         <div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Created At</th>
                        <th>Status</th>
                        <th>Amount</th>
                        <th>Transaction ID</th>
                        <th>Raw Payload</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($item->paymentlogs as $log)
                        @php
                            $payloadData = json_decode($log->payload, true);
                        @endphp
                        <tr>
                            <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                            <td>{{ $payloadData['status'] ?? 'N/A' }}</td>
                            <td>{{ $payloadData['amount'] ?? 'N/A' }}</td>
                            <td>{{ $payloadData['transaction_id'] ?? 'N/A' }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#payloadModal{{ $log->id }}">
                                    View Details
                                </button>
                                
                                <!-- Modal for detailed view -->
                                <div class="modal fade" id="payloadModal{{ $log->id }}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Payload Details</h5>
                                                <button type="button" class="close" data-dismiss="modal">
                                                    <span>&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <pre>{{ json_encode($payloadData, JSON_PRETTY_PRINT) }}</pre>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
    @endif
      <br>



    </div>
        <div class="modal fade" id="modal_order_details{{$item->id}}" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                       <div class="modal-dialog modal-lg" role="document">
                           <div class="modal-content">
                               <div class="modal-header">
                                   <h5 class="modal-title" id="exampleModalLabel">Order Details</h5>
                                   <button type="button" class="close" data-dismiss="modal"
                                           aria-label="Close">
                                       <span aria-hidden="true">&times;</span>
                                   </button>
                               </div>

                       <form method="post" action="{{route('pmm.transactions.updateDetails',$item->id)}}" form-id='modal_order_details{{$item->id}}' onsubmit="submitOrderDetailsForm(event, this)">
                           @csrf
                           <div class="modal-body">


                            <div class="row">
                             <div class="col-md-12">
                                <label for="name" class="form-label"> Order Status</label>
                               <select class="form-control" name="order_status">
                                <option value="Pending" {{$item->order_status=='Pending'?'selected':''}}>Pending</option>
                                <option value="In Process" {{$item->order_status=='In Process'?'selected':''}}>In Process</option>
                                <option value="Dispatched" {{$item->order_status=='Dispatched'?'selected':''}}>Dispatched</option>
                                <option value="Delivered" {{$item->order_status=='Delivered'?'selected':''}}>Delivered</option>
                                <option value="Rejected" {{$item->order_status=='Rejected'?'selected':''}}>Rejected</option>
                               </select>
                            </div>

                            </div>
                            <div class="row">

                               <div class="col-md-12">
                                        <label for="name" class="form-label">Note</label>
                                <textarea class="form-control code-editor" name="note" id="name" rows="3" >{{ $item->note}}</textarea>

                            </div>
                             </div>

                           </div>
                           <div class="modal-footer text-center">

                               <button href="#"
                                  class="btn btn-primary"> Save Changes
                            </button>
                           </div>
                       </form>

                           </div>
                       </div>
        </div>
<script>
    function submitOrderDetailsForm(event, formElement) {
        event.preventDefault(); // Always pass event explicitly
       formData = new FormData(formElement);
           $("#mainLoader1").modal('show')
           $("#"+$(formElement).attr('form-id')).modal('hide')
            $.ajax({
                url: $(formElement).attr('action'),
                type: $(formElement).attr('method'),
                data:formData,
                contentType: false,         // Required for FormData
                processData: false,
                success: function(response) {
                    if (response.code == 1) {
                        $("#"+$(formElement).attr('form-id')).modal('hide')


                        swal("Success!", response.message, "success");
                        setTimeout(() => {
                            window.location.reload()
                        }, 2000);

                    } else if (response.code == 0) {
                        swal("Sorry!", response.message, "error");
                    } else {
                        swal("Sorry!", "Unexpected response", "error");
                    }
                },
                error: function(xhr) {
                       $("#"+$(formElement).attr('form-id')).modal('show')
                    let errorMessage = "Something went wrong.";
                    if (xhr.e.responseJSON && xhr.e.responseJSON.message) {
                        errorMessage = xhr.e.responseJSON.message;
                    }
                    swal("Error!", errorMessage, "error");
                },
                complete:function()
                {
                     $("#mainLoader1").modal('hide')
                }
            });
}
</script>
@stop

