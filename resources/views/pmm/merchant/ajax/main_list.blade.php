<style>
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
            @foreach($list as $item)
                <tr style="border-bottom: 0.02rem solid #e5e7eb;">
                    <td >

                        <div class="m-list-item">
                            <div class="d-flex justify-content-between align-items-start mb-1">

                                <a href="#"
                                   class="m-list-item-link">
                                    <img src="{{$item->user->avatar()??''}}" style="width: 40px;border-radius:10px">
                                   {{ $item->user->name ?? 'No Title' }}</a>


                            </div>


                        </div>
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

                                            {{-- <a class="dropdown-item" style="cursor: pointer"  href="javascript:void" onclick="copyAffiliateLink('linkInput{{$item->id}}')"  ><i class="fas fa-copy"></i> Copy Link</a> --}}






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
