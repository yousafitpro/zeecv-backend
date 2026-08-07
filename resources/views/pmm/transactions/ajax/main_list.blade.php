<style>
       table thead{
    background-color:transparent !important;
    color: white !important;

   }
    table thead th {
       background:transparent !important;
        color: var(--primary) !important; /* White text */
    }
 #myTableCustom1 td {
        padding:0px !important;
        vertical-align: top;
        padding-top: 6px !important;
    }
       table th{
    border: none !important;
    outline: none var(--primary) !important;
    color: white !important;
   }
    .m-list-item {
        background-color: #ffffff;
        /* border-radius: 0.5rem; */
        padding: 0.5rem;

        /* box-shadow: 0 0 8px rgba(0, 0, 0, 0.06); */
    }
.m-list-item:hover {

}

    .m-list-item-link {
        font-weight: 600;
        color: rgb(0, 120, 212);
        text-decoration: none;
    }

    .m-list-item-link:hover {
        text-decoration: underline;
    }

    .task-meta {
        font-size: 0.875rem;
        color: #6c757d;
    }

    .task-title {
        font-weight: 500;
        font-size: 1rem;
        margin-bottom: 0.25rem;
    }

    .badge-sm {
        font-size: 0.75rem;
        padding: 0.4em 0.6em;
        color: white
    }
</style>

<div class="table-responsive" style="margin-top: 10px">
    <table id="myTableCustom1" class="table table-borderless align-middle">

        <tbody>
              <tr>
                <thead>
                    <th >
                        Product
                    </th>

                       <th>
                        Order ID
                    </th>

                       @if (is_admin() || is_has_role('Merchant'))

                      <th>
                        Customer
                    </th>
                      @endif
                    <th>
                        Amount
                    </th>
                    <th>
                        Publisher
                    </th>
                    <th>
                        Order Status
                    </th>
                    <th style="text-align: center">
                        Actions
                    </th>
                </thead>
               </tr>
            @foreach($list as $item)
                <tr style="border-bottom: 0.02rem solid #e5e7eb;">
                    <td >

                        <div class="m-list-item">
                            <div class="d-flex justify-content-between align-items-start mb-1">

                                <a href="{{route('pmm.transactions.detail',unique_encrypt($item->id)). '?back_url=' . route('pmm.transactions.view') }}"
                                   >
                                    <img src="{{$item->link->product->attachment->file_url??''}}" style="width: 40px;border-radius:10px">
                                   {{ $item->link->product->name ?? 'No Title' }}</span>


                            </div>


                        </div>
                    </td>
                    <td>
                       #{{unique_encrypt($item->id)}}
                                       <br>
        @if ($item->is_double())
            <div class="badge badge-danger badge-sm">Double</div>
        @endif
                    </td>
                      @if (is_admin() || is_has_role('Merchant'))
                     <td>
                           {{$item->name}}<br>
                           {{$item->email}}<br>
                           {{$item->phone}}
                    </td>
                     @endif
                    <td>
                        @php
                            $bg = '';

                            if (!empty($item->processor_response)) {
                                $bg = 'background: greenyellow;';
                            } elseif (!empty($item->request_payload)) {
                                $bg = 'background: blue;';
                            }
                        @endphp
                        {{$item->amount}} | {{$item->currency}}<br>
                        <div class="badge badge-sm" style="color: black; {{ $bg }}">{{$item->link->product->payment_method}}</div>
                    </td>
                     <td>
                        @if(!empty($item->link))
                        #{{unique_encrypt($item->link->user_id)}}
                        @endif
                    </td>
                     <td>
                        {{$item->order_status}}
                    </td>
                    <td>

                        <div class=" mt-2 task_actions" >
                                <div style="float: right;margin-bottom:5px;">
                                      <small class="task-meta" style="font-size: 12px">
                                    @if (!empty($item->created_at))
                                     {{ $item->created_at->format('d M Y, h:i A') }}
                                    @endif

                                </small>
                                <br>
                                      <img class="rounded-circle" data-user-id="{{$item->user->id}}" onclick="hr_show_employee_card(this)"
                                        src="{{ $item->user->avatar() }}"
                                        style="width: 25px; height: 25px;margin-right:5px;margin-bottom:5px;cursor: pointer;"
                                        title="{{ $item->user->name }}">
                                    @if( isset($item->status))
                                    <span class="badge bg-{{ app_getStatusColor($item->status) }} badge-sm">
                                        {{ ucfirst($item->status) }}
                                    </span>

                                @endif
<input type="hidden" id="linkInput{{$item->id}}" value="{{ route('pmm.product.purchase', product_encrypt($item->id)) }}">
                                <div class="dropdown pull-right ml-2">

                                        <a style="font-size: 15px; margin-right: 20px"  href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions <i class="fas fa-caret-down pull-left"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink" >

                                         @if(is_has_permission('pmm.transactions.complete') && $item->status!="Completed")
                                            <a class="dropdown-item" style="cursor: pointer"  href="javascript:void" onclick="compeltepayment('{{route('pmm.transactions.complete',unique_encrypt($item->id))}}')"  ><i class="fas fa-order"></i> Complete Payment</a>
                                         @endif





                                        </div>
                                    </div>

                                </div>
                                <br>
                            </div>
                    </td>
                </tr>

            @endforeach
        </tbody>
    </table>

    @include('widgets.pagination', ['data' => ['meta' => $list]])
</div>
