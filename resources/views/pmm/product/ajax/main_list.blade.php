<style>
    /* Base switch container */
.switch {
  position: relative;
  display: inline-block;
  width: 34px;  /* smaller width */
  height: 18px; /* smaller height */
}

/* Hide the checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* Slider styling */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0; left: 0;
  right: 0; bottom: 0;
  background-color: #ccc;
  transition: .4s;
  border-radius: 34px;
}

/* Handle (circle) */
.slider:before {
  position: absolute;
  content: "";
  height: 14px; /* smaller handle */
  width: 14px;
  left: 2px;
  bottom: 2px;
  background-color: white;
  transition: .4s;
  border-radius: 50%;
}

/* Checked state */
input:checked + .slider {
  background-color: var(--primary);
}

input:checked + .slider:before {
  transform: translateX(16px); /* move handle */
}

       table thead{
    background-color:transparent !important;
    color: white !important;

   }
    table thead th {
       background:transparent !important;
        color: var(--primary) !important; /* White text */
    }
   table th{
    border: none !important;
    outline: none var(--primary) !important;
    color: white !important;
   }
    #myTableCustom1 th{
        border-radius: 10px !important
    }
    #myTableCustom1 th, #myTableCustom1 td {
        /* padding: 1rem; */
        vertical-align: top;
    }
 #myTableCustom1 td {
        padding:0px !important;
        vertical-align: top;
        padding-top: 6px !important;
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
                        Commission
                    </th>
                    <th>
                        <i class="fas fa-bell "></i> Alert
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
                            <div class=" align-items-start mb-1">

                                <a href="{{ route('pmm.products.update', product_encrypt($item->id)) . '?back_url=' . route('pmm.products.view') }}"
                                   class="m-list-item-link">
                                    <img src="{{$item->attachment->file_url??''}}" style="width: 40px;border-radius:10px">
                                   <span class="ml-3">
                                    {{ $item->name ?? 'No Title' }}
                                    <span>
                                       | {{$item->price}} {{ $item->crouncy }}
                                    </span>
                                   </span>

                                </a>


                            </div>


                        </div>
                    </td>
                    <td style="text-align: center">
                       {{$item->commission}} {{$item->commission_type=='Flat'?$item->crouncy:'%'}}
                    </td>
                   <td>
                       <label class="switch">
                            <input type="checkbox"
                                onchange="subscriberProduct( '{{ route('pmm.products.subscribe', $item->id) }}')"
                                {{ $item->subscriber ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
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
                                <div class="dropdown pull-right ml-2">

                                        <a style="font-size: 15px; margin-right: 20px"  href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions <i class="fas fa-caret-down pull-left"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink" >

                                             {{-- @if(is_has_permission('pmm.affiliate_links.generate'))
                                            <a class="dropdown-item" style="cursor: pointer"  href="javascript:void" onclick="generate_link('{{route('pmm.affiliate_links.generate',$item->id)}}')"  ><i class="fas fa-link"></i> Generate Affiliation Link</a>
                                             @endif --}}
                                             @if(is_has_permission('pmm.products.update'))
                                            <a class="dropdown-item" style="cursor: pointer"  href="{{ route('pmm.products.update', product_encrypt($item->id)) . '?back_url=' . route('pmm.products.view') }}"   ><i class="fas fa-edit"></i> Edit</a>
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
