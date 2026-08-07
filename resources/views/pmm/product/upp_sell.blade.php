@extends('layout.master')
@section('title', "Product Add Up Sell")
@section('content')
<div class="container">

    <h2>Up Sell Ads</h2>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Add Up Sell Button -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addUpSellModal">
        Add Up Sell
    </button>
    
    <!-- Edit Up Sell Modal -->
    <div class="modal fade" id="editUpSellModal" tabindex="-1" aria-labelledby="editUpSellModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editUpsellForm" method="POST">
                    @csrf
                    <!-- Hidden field for upsell ID -->
                    <input type="hidden" name="id" id="editUpsellId">
                    
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Up Sell</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Up Sell Name</label>
                            <input type="text" class="form-control" name="title" id="editUpsellName" required>
                        </div>
                        <div class="mb-3">
                            <label>Price {{$item->crouncy}}</label>
                            <input type="number" class="form-control" name="price" id="editUpsellPrice" min="0" step="0.01" required>
                        </div>
                        <!-- Hidden product ID -->
@if($item)
    <input type="hidden" name="product_id" value="{{ $item->id }}">
@endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Update Up Sell</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Add Up Sell Modal -->
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
                            <input type="hidden" class="form-control" name="type" value="product">
                        </div>
                        <div class="mb-3">
                            <label>Price {{$item->crouncy}}</label>
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

    <!-- List of Existing Up Sell Ads -->
    <div class="card mt-4">
        <div class="card-header"> <h3> <strong>Product : {{$item->name}}</strong></h3> </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="upsellTableBody">
                    @foreach($upsells ?? [] as $upsell)
                        <tr id="upsellRow{{ $upsell->id }}">
                            <td>{{ $upsell->id }}</td>
                            <td>{{ $upsell->name }}</td>
                            <td>{{ number_format($upsell->price, 2) }} {{$item->crouncy}}</td>
                            <td>
                                <button class="btn btn-sm btn-primary editUpsell" 
                                        data-id="{{ $upsell->id }}" 
                                        data-name="{{ $upsell->name }}" 
                                        data-price="{{ $upsell->price }}">
                                    Edit
                                </button>
                                <a href="{{route('upsell.items',$upsell->id)}}">

                                      <button class="btn btn-sm btn-primary " 
                                       >
                                    Items
                                                                </button>
                                </a>
                               
                                <button class="btn btn-sm btn-danger deleteUpsell" data-id="{{ $upsell->id }}">Delete</button>
                            </td>
                        </tr>
                    @endforeach

                    @if(empty($upsells) || count($upsells) == 0)
                        <tr id="noUpsellRow">
                            <td colspan="4" class="text-center">No Up Sell Added for this product</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
$(document).ready(function(){
    // CSRF token for AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

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
                
                // Remove "No Up Sell" message if exists
                $('#noUpsellRow').remove();
           
                
                
                swal("Success!", response.message, "success");
                setTimeout(function() {
                    location.reload();
                }, 2000);
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

    // 2. EDIT BUTTON CLICK - Using data attributes
    $(document).on('click', '.editUpsell', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var price = $(this).data('price');
        
        // Set values in modal
        $('#editUpsellId').val(id);
        $('#editUpsellName').val(name);
        $('#editUpsellPrice').val(price);
        
        // Set form action (using your route)
        $('#editUpsellForm').attr('action', '{{ route("upsell.update") }}');
        
        // Show modal
        $('#editUpSellModal').modal('show');
    });

    // 3. UPDATE FORM SUBMIT
    $('#editUpsellForm').submit(function(e){
        e.preventDefault();
        
        var form = $(this);
        var url = form.attr('action');
        var data = form.serialize();
        
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function(response){
                $('#editUpSellModal').modal('hide');
                
                // Update the table row
                var row = $('#upsellRow' + response.id);
                row.find('td:eq(1)').text(response.name);
                row.find('td:eq(2)').text('$' + parseFloat(response.price).toFixed(2));
                
                // Update button data attributes
                row.find('.editUpsell')
                    .data('name', response.name)
                    .data('price', response.price);
                
                swal("Success!", response.message, "success");
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

    // 4. DELETE FUNCTIONALITY (Optional - add if you have a delete route)
 // Alternative: Using route helper directly
$(document).on('click', '.deleteUpsell', function() {
    var id = $(this).data('id');
    var deleteUrl = "{{ route('upsell.destroy', ':id') }}".replace(':id', id);
    
    if(confirm("Are you sure you want to delete this upsell?")) {
        $.ajax({
            type: 'DELETE',
            url: deleteUrl,
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response){
                $('#upsellRow' + id).remove();
                
                // If no rows left, show message
                if($('#upsellTableBody tr').length === 0) {
                    $('#upsellTableBody').html('<tr id="noUpsellRow"><td colspan="4" class="text-center">No Up Sell Added for this product</td></tr>');
                }
                
                swal("Success!", response.message, "success");
            },
            error: function(xhr) {
                alert('Error deleting upsell');
            }
        });
    }
});
});
</script>

@endsection