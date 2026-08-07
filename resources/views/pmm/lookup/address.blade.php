@extends('layout.master')
@section('title', "Orders")
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Address Management</h5>
        </div>
       

        <div class="card-body">

            {{-- Add Category Form --}}
            <form method="POST" action="{{ route('system.Lookup.address.add') }}" onsubmit="addCategory(event, this)">
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Name" required>
                    </div>
                    <div class="col-md-3">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control" placeholder="Phone" required>
                    </div>
                    <div class="col-md-3">
                        <label>City</label>
                        <input type="text" name="city" class="form-control" placeholder="city" required>
                    </div>
                    <div class="col-md-3">
                        <label>Postal Code</label>
                        <input type="text" name="postal_code" class="form-control" placeholder="Postal" required>
                    </div>

                  
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label>Province</label>
                        <input type="text" name="province" class="form-control" placeholder="Province" required>
                    </div>
                    <div class="col-md-2">
                        <br>
                        <input type="checkbox" name="is_primary" >
                        <label>Is Primary</label>
                        
                    </div>
                    <div class="col-md-7">
                        <label>Address</label>
                        <input type="text" name="address" class="form-control" placeholder="Address" required>
                    </div>
                </div>
                <div class="row">
                      <div class="col-md-12">
                        <button type="submit" class="btn btn-primary pull-right" style="border-radius: 5px;">
                            <i class="fas fa-plus"></i> Add
                        </button>
                    </div>
                </div>
            </form>

            <hr>

            {{-- Categories List --}}
            <div id="categoryList" class="table-responsive mt-3">
                <table class="table table-bordered table-striped text-center align-middle mb-0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th width="20%">Name</th>
                            <th width="30%">Address</th>
                            <th width="20%">Is Primary</th>
                            <th width="30%">Action</th>
                        </tr>
                    </thead>
                    <tbody id="categoriesTableBody">
                        <!-- categories will be loaded here -->
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    loadCategories();
});

// ✅ Load all categories
function loadCategories() {
    $.ajax({
        url: "{{ route('system.Lookup.address.list') }}",
        type: 'GET',
        success: function (response) {
            $('#categoriesTableBody').html('');
            if (response.length === 0) {
                $('#categoriesTableBody').html(`<tr><td colspan="4">No categories found.</td></tr>`);
                return;
            }
            response.forEach(category => {
                $('#categoriesTableBody').append(`
                    <tr id="cat_${category.id}">
                        <td>${category.name}</td>
                        <td>${category.address}</td>
                        <td>${category.is_primary}</td>
                        <td>
                            <form action="{{ route('system.Lookup.address.delete', ':id') }}"
                                  method="POST"
                                  onsubmit="deleteCategory(event, this)">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                            <form action="{{ url('lookup/address/edit') }}/${category.id}"
                                  method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-pencil"></i> Edit
                                </button>
                            </form>

                        </td>
                    </tr>
                `.replace(':id', category.id));
            });
        },
        error: function (xhr) {
            swal("Error!", "Failed to load categories.", "error");
        }
    });
}

// ✅ Add category
function addCategory(event, formElement) {
    event.preventDefault();
    let formData = new FormData(formElement);

    $.ajax({
        url: $(formElement).attr('action'),
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
 success: function (response) {
    if (response.success) {
        swal("Success!", response.message, "success");
        formElement.reset();
        loadCategories();
    } else {
        swal("Error!", response.message || "Something went wrong.", "error");
    }
},

        error: function (xhr) {
            swal("Error!", "Something went wrong while adding category.", "error");
        }
    });
}

// ✅ Delete category
function deleteCategory(event, formElement) {
    event.preventDefault();

    swal({
        title: "Are you sure?",
        text: "This category will be deleted!",
        icon: "warning",
        buttons: ["No", "Yes"],
        dangerMode: true,
    }).then((willDelete) => {
        if (!willDelete) return;

        $.ajax({
            url: $(formElement).attr('action'),
            type: 'GET',
        success: function (response) {
    if (response.success) {
        swal("Success!", response.message, "success");
        formElement.reset();
        loadCategories();
    } else {
        swal("Error!", response.message || "Something went wrong.", "error");
    }
},

            error: function (xhr) {
                swal("Error!", "Failed to delete category.", "error");
            }
        });
    });
}
</script>


@stop

