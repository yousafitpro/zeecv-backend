@extends('layout.master')
@section('title', "Orders")
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">GLS Profile Management</h5>
        </div>
       

        <div class="card-body">

            {{-- Add Category Form --}}
            <form method="POST" action="{{ route('system.gls.profile.store') }}" onsubmit="addCategory(event, this)">
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <label>GLS Profile Name</label>
                        <input type="text" name="name" class="form-control" placeholder="GLS Profile Name" required>
                    </div>
                    <div class="col-md-3">
                        <label>Sede</label>
                        <input type="text" name="sede" class="form-control" placeholder="sede" required>
                    </div>
                    <div class="col-md-3">
                        <label>Customer Code</label>
                        <input type="number" name="customer_code" class="form-control" placeholder="customer code" required>
                    </div>
                    <div class="col-md-3">
                        <label>Contract Code</label>
                        <input type="number" name="Contract_code" class="form-control" placeholder="Contract code" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label>Password</label>
                        <input type="text" name="password" class="form-control" placeholder="Password" required>
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
                            <th width="10%">Sede</th>
                            <th width="10%">Customer Code</th>
                            <th width="20%">Contract Code</th>
                            <th width="20%">Password</th>
                            <th width="20%">Action</th>
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
        url: "{{ route('system.gls.profile.list') }}",
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
                        <td>${category.sede}</td>
                        <td>${category.customer_code}</td>
                        <td>${category.contract_code}</td>
                        <td>${category.password}</td>
                        <td>
                            <form action="{{ route('delete.gls.pro', ':id') }}"
                                  method="POST"
                                  onsubmit="deleteCategory(event, this)">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                            <form action="{{ url('lookup/gls/profile/edit') }}/${category.id}"
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

