@php
    $affiliate_link=get_affiliate_link(auth_user_id(),$item->id);
@endphp

    <style>
.btn_close{
    height: 20px !important;
    font-size: 10x !important;
    padding-top: 1px !important;
    padding-bottom: 0px !important;
}
.pixel-card {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    transition: box-shadow 0.2s;
}
.pixel-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    cursor: pointer;
}
       table thead{
    background-color:transparent !important;
    color: white !important;

   }

   table th{
    border: none !important;
    outline: none var(--primary) !important;
    color: white !important;
   }
   #tagsInput{
    border-radius:10px;
   }
   #productCategory + .select2-container--default .select2-selection--multiple {
    background-color: #fff !important;
    border: 1px solid #0d6efd !important;
    border-radius: 8px !important;
    padding: 6px !important;
    min-height: 60px !important;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

#productCategory + .select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #0d6efd !important;
    color: #fff !important;
    border: none !important;
    border-radius: 6px !important;
    padding: 5px 10px !important;
    margin-top: 5px !important;
    font-size: 13px;
}

#productCategory + .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    color: black;
    margin-right: 6px;
    font-weight: bold;
}

#productCategory + .select2-container--default .select2-dropdown {
    border-radius: 8px !important;
    border-color: #0d6efd !important;
}

#productCategory + .select2-container--default .select2-results__option--highlighted {
    background-color: #0d6efd !important;
    color: white !important;
}

</style>

    <div class="row" >
        <div class="col-md-12">
          <section id="tabs">
              <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="productTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="landing-tab" data-toggle="tab" href="#gallery" role="tab">Gallery</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="postbacks-tab" data-toggle="tab" href="#postbacks" role="tab">Postbacks/Pixels</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="transactions-tab" data-toggle="tab" href="#transactions" role="tab">Transactions</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tag-tab" data-toggle="tab" href="#tag" role="tab">Tag</a>
            </li>
             <li class="nav-item">
                <a class="nav-link" id="Category-tab" data-toggle="tab" href="#Category" role="tab">Category</a>
            </li>
            </ul>
          </section>

            <!-- Tab panes -->
            <div class="tab-content p-3 border border-top-0">
            <div class="tab-pane fade" id="tag" role="tabpanel">
                <div class="row">
                    <div class="col-md-12">
                        <h6 class="text-primary mb-3"><i class="fas fa-tags"></i> Product Tags</h6>

                    <form id="tagForm" method="POST" action="{{route('pmm.products.add.tag', $item->id)}}" onsubmit="saveTags(event, this)">
                @csrf
                <div class="form-group">
                    <label for="tagsInput">Add Tags (comma separated)</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="tagsInput" name="tags" placeholder="Enter tags">
                        <button type="submit" class="btn btn-primary">Save Tags</button>
                    </div>
                </div>
            </form>

            <hr>

            <h6>Existing Tags</h6>
            <div id="tagList" class="mt-2">
              
            </div>
        </div>
    </div>
</div>
  
  <div class="tab-pane fade" id="Category" role="tabpanel">
    <div class="row">
        <div class="col-md-12">
            <h6 class="text-primary mb-3">
                <i class="fas fa-list"></i> Assign Category
            </h6>

  <form id="productCategoryForm"
      method="POST"
      action="{{route('pmm.product.asain.category',$item->id)}}"
      onsubmit="saveProductCategory(event, this)">
    @csrf

    <div class="form-group">
        <label for="productCategory" class="fw-bold mb-2">Select Categories</label>
      <select id="productCategory"
        class="form-control select2"
        name="category_ids[]"
        multiple
        required
        style="width: 100%; min-width: 400px;"  <!-- width bada kar di -->
        {{ $can_edit ? '' : 'disabled' }}>
    @foreach($allCategories as $category)
        <option value="{{ $category->id }}"
            {{ in_array($category->id, $item->categories->pluck('id')->toArray() ?? []) ? 'selected' : '' }}>
            {{ $category->name }}
        </option>
    @endforeach
</select>

    </div>

    <button type="submit" class="btn btn-primary mt-2" {{ $can_edit ? '' : 'disabled' }}>
        Save Categories
    </button>
</form>

        </div>
    </div>
</div>
  
            <div class="tab-pane fade show active" id="gallery" role="tabpanel">
    <!-- Upload Section -->
    @if(is_has_permission('pmm.products.update'))
        <form id="pmm_produc_image_upload_form" action="{{route('pmm.products.image_upload',$item->id)}}" method="POST"  enctype="multipart/form-data" onsubmit="submitAttachmentUploadForm(event, this)">
            @csrf

        <input type="file" name="attachment" class="form-control" id="attachmentInput" onchange="$('#pmm_produc_image_upload_form').submit()"  >
        </form>
        <div id="uploadStatus" class="text-info mt-2" style="display: none;">
            <i class="fas fa-spinner fa-spin"></i> Uploading...
        </div>
        @endif
        <br>


    <!-- Gallery Grid -->
    <div class="row">

       <div class="col-md-12">
         <div id="product_gallery_box"></div>
       </div>
    </div>
</div>

            <div class="tab-pane fade" id="postbacks" role="tabpanel">
              <div class="container-fluid ">
                <h6 class="text-primary mb-3">
                    <i class="fas fa-cube"></i> Pixels
                </h6>

                <div class="row">
                    <div class="col-md-3" data-toggle="modal" data-target="#modal_update_On_click">
                        <div class="pixel-card p-3 text-start">
                            <h6 class="fw-bold text-uppercase mb-1">On Click</h6>
                            <small class="text-muted">On click</small>
                        </div>
                    </div>
                    <div class="col-md-3" data-toggle="modal" data-target="#modal_update_On_sale">
                        <div class="pixel-card p-3 text-start">
                            <h6 class="fw-bold text-uppercase mb-1">On Sale</h6>
                            <small class="text-muted">On sale</small>
                        </div>
                    </div>



                </div>
                <br>
                 <h6 class="text-primary mb-3">
                    <i class="fas fa-cog"></i> Postbacks
                </h6>

                <div class="row">

                      <div class="col-md-3" data-toggle="modal" data-target="#modal_checkout">
                        <div class="pixel-card p-3 text-start">
                            <h6 class="fw-bold text-uppercase mb-1">Checkout</h6>
                            <small class="text-muted">Checkout page settings</small>
                        </div>
                    </div>
                     <div class="col-md-3" data-toggle="modal" data-target="#modal_iframe">
                        <div class="pixel-card p-3 text-start">
                            <h6 class="fw-bold text-uppercase mb-1">Checkout</h6>
                            <small class="text-muted">Iframe</small>
                        </div>
                    </div>
                     <div class="col-md-3" data-toggle="modal" data-target="#modal_iframe_fields">
                        <div class="pixel-card p-3 text-start">
                            <h6 class="fw-bold text-uppercase mb-1">Checkout</h6>
                            <small class="text-muted">Fields</small>
                        </div>
                    </div>
                    <div class="col-md-3" data-toggle="modal" data-target="#modal_update_thank_page_link">
                        <div class="pixel-card p-3 text-start">
                            <h6 class="fw-bold text-uppercase mb-1">Thank You Page</h6>
                            <small class="text-muted">On Order Completion</small>
                        </div>
                    </div>
                         <div class="col-md-3" data-toggle="modal" data-target="#modal_update_redirect_url">
                        <div class="pixel-card p-3 text-start">
                            <h6 class="fw-bold text-uppercase mb-1">Redirect</h6>
                            <small class="text-muted">Redirect URL</small>
                        </div>
                    </div>
                </div>
                     <br>
                 <h6 class="text-primary mb-3">
                    <i class="fas fa-box"></i> Order
                </h6>


                <div class="row">

                     <div class="col-md-3" data-toggle="modal" data-target="#modal_order_tracking">
                        <div class="pixel-card p-3 text-start">
                            <h6 class="fw-bold text-uppercase mb-1">Order Tracking</h6>
                            <small class="text-muted">Iframe</small>
                        </div>
                    </div>
                    <div class="col-md-3" data-toggle="modal" data-target="#modal_product_domain">
                        <div class="pixel-card p-3 text-start">
                            <h6 class="fw-bold text-uppercase mb-1">Custom Domain</h6>
                            <small class="text-muted">Form</small>
                        </div>
                    </div>

                </div>
                                     <br>
                 <h6 class="text-primary mb-3">
                    <i class="fas fa-box"></i> Others
                </h6>


                <div class="row">

                     <div class="col-md-3" data-toggle="modal" data-target="#modal_external_product_link">
                        <div class="pixel-card p-3 text-start">
                            <h6 class="fw-bold text-uppercase mb-1">External Product Link</h6>
                            <small class="text-muted">Link</small>
                        </div>
                    </div>
                    <div class="col-md-3" data-toggle="modal" data-target="#modal_external_checkout_link">
                        <div class="pixel-card p-3 text-start">
                            <h6 class="fw-bold text-uppercase mb-1">External Checkout Link</h6>
                            <small class="text-muted">Link</small>
                        </div>
                    </div>

                </div>
            </div>

            </div>
            <div class="tab-pane fade" id="transactions" role="tabpanel">



                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive" style="margin-top: 10px">
    <table id="myTableCustom" class="table table-borderless align-middle">

       <thead class="thead-light">
        <tr>
            <th>Product</th>
            <th>Amount</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $trans)
                           <tr>
                <td>{{$trans->link->product->name}}</td>
                <td>{{$trans->link->product->price}} $</td>
                <td>
                    <div class="badge badge-sm" style="color: black">{{$trans->status}}</div>
                </td>
            </tr>
            @endforeach

        </tbody>
        </table>
                    </div>
                </div>
               </div>

            </div>

        </div>
    </div>
    <div class="modal fade" id="modal_update_On_click" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                       <div class="modal-dialog " role="document">
                           <div class="modal-content">
                               <div class="modal-header">
                                   <h5 class="modal-title" id="exampleModalLabel">On Click</h5>
                                   <button type="button" class="close" data-dismiss="modal"
                                           aria-label="Close">
                                       <span aria-hidden="true">&times;</span>
                                   </button>
                               </div>

                       <form method="post" action="{{route('pmm.affiliate_links.updateAttribute',$item->id)}}" onsubmit="updateAffiliateAttributes(event, this)">
                           @csrf
                           <div class="modal-body">

                            <div class="form-group">
                                <label for="name" class="form-label">HTML</label>
                                <textarea class="form-control code-editor" name="on_click" id="name" rows="6" required>{{ $affiliate_link->on_click }}</textarea>
                            </div>

                           </div>
                           <div class="modal-footer text-center">

                               <button href="#"
                                  class="btn btn-primary"> Submit
                            </button>
                           </div>
                       </form>

                           </div>
                       </div>
    </div>
     <div class="modal fade" id="modal_checkout" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                       <div class="modal-dialog " role="document">
                           <div class="modal-content">
                               <div class="modal-header">
                                   <h5 class="modal-title" id="exampleModalLabel">Checkout Page Settings</h5>
                                   <button type="button" class="close" data-dismiss="modal"
                                           aria-label="Close">
                                       <span aria-hidden="true">&times;</span>
                                   </button>
                               </div>

                       <form method="post" action="{{route('pmm.affiliate_links.updateAttribute',$item->id)}}" enctype="multipart/form-data" onsubmit="updateAffiliateAttributes(event, this)">
                           @csrf
                           <div class="modal-body">
                            <div class="form-group">
                                <label for="product_name" class="form-label">Product name</label>
                                <input name="product_name" id="product_name" value="{{ $affiliate_link->product_name }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="product_description" class="form-label">Product Description</label>
                                <textarea class="form-control code-editor" name="product_description" id="product_description" rows="3" required>{{ $affiliate_link->product_description }}</textarea>
                            </div>
                        <div class="form-group">
                            @if ($affiliate_link->attachment)
                                                            <img src="{{$affiliate_link->attachment->file_url}}" id="checkout_image_link" style="max-width: 100px">

                            @endif
                                <label for="product_description" class="form-label">Product Thumbnail</label>
                                <div class="row">
                    <div class="col-md-12">
             <input type="file"
               name="attachment"
               id="attachment"
               class="form-control form-control-sm ps-5"
               style="height: 42px;">
                    </div>
                </div>
                            </div>

                           </div>
                           <div class="modal-footer text-center">

                               <button href="#"
                                  class="btn btn-primary"> Submit
                            </button>
                           </div>
                       </form>

                           </div>
                       </div>
    </div>
    <div class="modal fade" id="modal_iframe" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                       <div class="modal-dialog " role="document">
                           <div class="modal-content">
                               <div class="modal-header">
                                   <h5 class="modal-title" id="exampleModalLabel">Iframe</h5>
                                   <button type="button" class="close" data-dismiss="modal"
                                           aria-label="Close">
                                       <span aria-hidden="true">&times;</span>
                                   </button>
                               </div>

                        <div class="modal-body">
                            <label for="iframeCode">Copy Embed Code:</label>
                            <textarea id="iframeCode" class="form-control" style="height: 120px;" readonly>
                        <iframe src="{{ affiliate_link(auth()->user()->id, $item->id) }}" width="100%" height="2000px" frameborder="0" style="border: none; display: block;width:100%" loading="lazy" scrolling="no" allowfullscreen>
                        </iframe>
                            </textarea>

                            <button type="button" class="btn btn-primary mt-2" onclick="copyIframeEmbed()">Copy to Clipboard</button>
                        </div>



                           </div>
                       </div>
    </div>
     <div class="modal fade" id="modal_external_product_link" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                       <div class="modal-dialog " role="document">
                           <div class="modal-content">
                               <div class="modal-header">
                                   <h5 class="modal-title" id="exampleModalLabel">External Product Link</h5>
                                   <button type="button" class="close" data-dismiss="modal"
                                           aria-label="Close">
                                       <span aria-hidden="true">&times;</span>
                                   </button>
                               </div>

                        <div class="modal-body">
                            <form method="post" action="{{route('pmm.affiliate_links.updateAttribute',$item->id)}}" enctype="multipart/form-data" onsubmit="updateAffiliateAttributes(event, this)">
                           @csrf
                            <label for="iframeCode">Product Link:</label>
                            <input class="form-control" value="{{$affiliate_link->external_product_link}}" name="external_product_link">

                            <button type="submit" class="btn btn-primary mt-2">Save Changes</button>
                            </form>
                        </div>



                           </div>
                       </div>
    </div>
         <div class="modal fade" id="modal_external_checkout_link" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                       <div class="modal-dialog " role="document">
                           <div class="modal-content">
                               <div class="modal-header">
                                   <h5 class="modal-title" id="exampleModalLabel">External Checkout Link</h5>
                                   <button type="button" class="close" data-dismiss="modal"
                                           aria-label="Close">
                                       <span aria-hidden="true">&times;</span>
                                   </button>
                               </div>

                        <div class="modal-body">
                            <form method="post" action="{{route('pmm.affiliate_links.updateAttribute',$item->id)}}" enctype="multipart/form-data" onsubmit="updateAffiliateAttributes(event, this)">
                           @csrf
                            <label for="iframeCode">External Checkout Link:</label>
                            <input class="form-control" value="{{$affiliate_link->external_checkout_link}}" name="external_checkout_link">

                            <button type="submit" class="btn btn-primary mt-2">Save Changes</button>
                            </form>
                        </div>



                           </div>
                       </div>
    </div>
     <div class="modal fade" id="modal_order_tracking" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                       <div class="modal-dialog " role="document">
                           <div class="modal-content">
                               <div class="modal-header">
                                   <h5 class="modal-title" id="exampleModalLabel">Iframe</h5>
                                   <button type="button" class="close" data-dismiss="modal"
                                           aria-label="Close">
                                       <span aria-hidden="true">&times;</span>
                                   </button>
                               </div>

                        <div class="modal-body">
                            <label for="iframeCode">Copy Embed Code:</label>
                            <textarea id="ordertrackingiframeCode" class="form-control" style="height: 120px;" readonly>
                        <iframe
                            src="{{ (!empty($domain->domain) && $domain->order_tracking == 'true')
                                            ? $domain->domain.'/order/track/youorderid'
                                            :url('order/track') }}/yourorderid" width="100%" height="1600px" frameborder="0" style="border: none;width:100%; display: block;" loading="lazy" allowfullscreen>
                        </iframe>
                            </textarea>

                            <button type="button" class="btn btn-primary mt-2" onclick="ordertrackingiframeCode()">Copy to Clipboard</button>
                        </div>



                           </div>
                       </div>
    </div>

    <div class="modal fade" id="modal_product_domain" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                       <div class="modal-dialog " role="document">
                           <div class="modal-content">
                      <form method="post" action="{{route('system.connect.customdomain.update',product_encrypt($item->id))}}" id="customdomain_form" enctype="multipart/form-data" onsubmit="submitFormForDomain(event, this)">
            @csrf

            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Connect your custom domain</h4>
                </div>
                <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-4">
                    <label class="switch">
                        <input type="checkbox" name="order_checkout" {{!empty($domain->order_checkout)?'checked':''}}> Order Checkout
                    </label>
                    </div>
                    <div class="col-md-4">
                    <label class="switch">
                        <input type="checkbox" name="order_tracking" {{!empty($domain->order_tracking)?'checked':''}}> Order Tracking
                    </label>
                    </div>
                    <div class="col-md-4">
                    <label class="switch">
                        <input type="checkbox" name="order_comeback" {{!empty($domain->order_comeback)?'checked':''}}> Order Comeback
                    </label>
                    </div>
                </div>
             <br>
                <div class="row">
                    <div class="col-md-12">
                        <input placeholder="https://yourwebsite.com" value="{{$domain->domain}}" class="form-control" name="domain">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                       <button class="btn btn-primary btn-block" type="submit">Save Changes</button>
                    </div>
                </div>

                </div>
            </div>


</form>


                           </div>
                       </div>
    </div>
    <div class="modal fade" id="modal_iframe_fields" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                       <div class="modal-dialog " role="document">
                           <div class="modal-content">
                      <form method="post" action="{{route('system.connect.fields.update',product_encrypt($item->id))}}" id="customdomain_form" enctype="multipart/form-data" onsubmit="submitFormForDomain(event, this)">
            @csrf

            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Checkout Fields</h4>
                </div>
                <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-4">
                    <label class="switch">
                        <input type="checkbox" name="fields_address" {{!empty($affiliate_link->fields_address)?'checked':''}}> Address
                    </label>
                    </div>
                    <div class="col-md-4">
                    <label class="switch">
                        <input type="checkbox" name="fields_city" {{!empty($affiliate_link->fields_city)?'checked':''}}> City
                    </label>
                    </div>
                    <div class="col-md-4">
                    <label class="switch">
                        <input type="checkbox" name="fields_zip" {{!empty($affiliate_link->fields_zip)?'checked':''}}> Zip
                    </label>
                    </div>
                    <div class="col-md-4">
                    <label class="switch">
                        <input type="checkbox" name="fields_state" {{!empty($affiliate_link->fields_state)?'checked':''}}> State
                    </label>
                    </div>
                    <div class="col-md-4">
                    <label class="switch">
                        <input type="checkbox" name="fields_country" {{!empty($affiliate_link->fields_country)?'checked':''}}> Country
                    </label>
                    </div>
                    <div class="col-md-4">
                    <label class="switch">
                        <input type="checkbox" name="fields_email" {{!empty($affiliate_link->fields_email)?'checked':''}}> Email
                    </label>
                    </div>
                    <div class="col-md-4">
                    <label class="switch">
                        <input type="checkbox" name="fields_quantity" {{!empty($affiliate_link->fields_quantity)?'checked':''}}> Quantity
                    </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <small>Please select the fields you want to hide on checkout form</small>
                    </div>
                </div>
             
                <br>
                <div class="row">
                    <div class="col-md-12">
                       <button class="btn btn-primary btn-block" type="submit">Save Changes</button>
                    </div>
                </div>

                </div>
            </div>


</form>


                           </div>
                       </div>
    </div>
        <div class="modal fade" id="modal_update_On_sale" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                       <div class="modal-dialog " role="document">
                           <div class="modal-content">
                               <div class="modal-header">
                                   <h5 class="modal-title" id="exampleModalLabel">On Sale</h5>
                                   <button type="button" class="close" data-dismiss="modal"
                                           aria-label="Close">
                                       <span aria-hidden="true">&times;</span>
                                   </button>
                               </div>

                       <form method="post" action="{{route('pmm.affiliate_links.updateAttribute',$item->id)}}" onsubmit="updateAffiliateAttributes(event, this)">
                           @csrf
                           <div class="modal-body">

                            <div class="form-group">
                                <label for="name" class="form-label">HTML</label>
                                <textarea class="form-control code-editor" name="on_sale" id="name" rows="6" required>{{ $affiliate_link->on_sale }}</textarea>
                            </div>

                           </div>
                           <div class="modal-footer text-center">

                               <button href="#"
                                  class="btn btn-primary"> Submit
                            </button>
                           </div>
                       </form>

                           </div>
                       </div>
    </div>
        <div class="modal fade" id="modal_update_thank_page_link" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                       <div class="modal-dialog " role="document">
                           <div class="modal-content">
                               <div class="modal-header">
                                   <h5 class="modal-title" id="exampleModalLabel">HTML</h5>
                                   <button type="button" class="close" data-dismiss="modal"
                                           aria-label="Close">
                                       <span aria-hidden="true">&times;</span>
                                   </button>
                               </div>

                       <form method="post" action="{{route('pmm.affiliate_links.updateAttribute',$item->id)}}" onsubmit="updateAffiliateAttributes(event, this)">
                           @csrf
                           <div class="modal-body">

                            <div class="form-group">
                                <label for="name" class="form-label">Thank you page</label>
                                <textarea class="form-control code-editor" name="thank_page_link" id="name" rows="6" required>{{ $affiliate_link->thank_page_link }}</textarea>

                            </div>

                           </div>
                           <div class="modal-footer text-center">

                               <button href="#"
                                  class="btn btn-primary"> Submit
                            </button>
                           </div>
                       </form>

                           </div>
                       </div>
    </div>
     <div class="modal fade" id="modal_update_redirect_url" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                       <div class="modal-dialog " role="document">
                           <div class="modal-content">
                               <div class="modal-header">
                                   <h5 class="modal-title" id="exampleModalLabel">URL</h5>
                                   <button type="button" class="close" data-dismiss="modal"
                                           aria-label="Close">
                                       <span aria-hidden="true">&times;</span>
                                   </button>
                               </div>

                       <form method="post" action="{{route('pmm.affiliate_links.updateAttribute',$item->id)}}" onsubmit="updateAffiliateAttributes(event, this)">
                           @csrf
                           <div class="modal-body">

                            <div class="form-group">
                                <label for="name" class="form-label">URL</label>
                                <input class="form-control" value="{{$affiliate_link->redirect_url}}" name="redirect_url">

                            </div>

                           </div>
                           <div class="modal-footer text-center">

                               <button href="#"
                                  class="btn btn-primary"> Submit
                            </button>
                           </div>
                       </form>

                           </div>
                       </div>
    </div>
<script>
        $(document).ready(function(){

getAttachments()
    })

    function updateAffiliateAttributes(event, formElement)
    {
            event.preventDefault(); // Always pass event explicitly
 formData = new FormData(formElement);
           $.ajax({
                url: $(formElement).attr('action'),
                type: $(formElement).attr('method'),
                data:formData,
                contentType: false,         // Required for FormData
                processData: false,
                success: function(response) {
                    if (response.code == 1) {
                        $("#modal_update_On_click").modal('hide');
                        $("#modal_update_On_sale").modal('hide');
                        $("#modal_update_thank_page_link").modal('hide');
                        if(response.image_link !=undefined)
                    {
                        $("#checkout_image_link").prop("src",response.image_link)
                    }
                        swal("Success!", response.message, "success");

                    } else if (response.code == 0) {
                        swal("Sorry!", response.message, "error");
                    } else {
                        swal("Sorry!", "Unexpected response", "error");
                    }
                },
                error: function(xhr) {
                    let errorMessage = "Something went wrong.";
                    if (xhr.e.responseJSON && xhr.e.responseJSON.message) {
                        errorMessage = xhr.e.responseJSON.message;
                    }
                    swal("Error!", errorMessage, "error");
                }
            });
    }

    function submitAttachmentUploadForm(event, formElement)
     {
            event.preventDefault(); // Prevent form submission
            $('#uploadStatus').show();
            const formData = new FormData(formElement);
        $.ajax({
                url: $(formElement).attr('action'),
                type: $(formElement).attr('method'),
                data: formData,
                processData: false, // Required for FormData
                contentType: false, // Required for FormData
                success: function(response) {
                    if (response.code === 1) {
                        formElement.reset();
                        getAttachments()

                    } else if (response.code === 0) {
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
                    swal("Error!", errorMessage, "error");
                },
                complete:function()
                {
                     $('#uploadStatus').hide();
                }
            });
}
function removeImage(url) {

    event.preventDefault(); // Always pass event explicitly

    swal({
        title: "Confirmation!",
        text: "Are you sure you want to proceed?",
        icon: "warning",
        buttons: ["No", "Yes"],
        dangerMode: false,
    }).then((res) => {
        if (res) {
            $.ajax({
                url:url,
                type: 'get',
                data: {'_token':'{{ csrf_token() }}'},
                success: function(response) {
                    if (response.code == 1) {
                            getAttachments()
                    } else if (response.code == 0) {
                        swal("Sorry!", response.message, "error");
                    } else {
                        swal("Sorry!", "Unexpected response", "error");
                    }
                },
                error: function(xhr) {
                    let errorMessage = "Something went wrong.";
                    if (xhr.e.responseJSON && xhr.e.responseJSON.message) {
                        errorMessage = xhr.e.responseJSON.message;
                    }
                    swal("Error!", errorMessage, "error");
                }
            });
        }
    });
}
function ordertrackingiframeCode() {
    const textarea = document.getElementById('ordertrackingiframeCode');
    textarea.select();
    textarea.setSelectionRange(0, 99999); // For mobile devices

    try {
        document.execCommand('copy');
    } catch (err) {
        alert('Failed to copy. Please copy manually.');
    }
}
function copyIframeEmbed() {
    const textarea = document.getElementById('iframeCode');
    textarea.select();
    textarea.setSelectionRange(0, 99999); // For mobile devices

    try {
        document.execCommand('copy');
    } catch (err) {
        alert('Failed to copy. Please copy manually.');
    }
}
 function getAttachments() {
   $.ajax({
                url: "{{route('pmm.products.images',$item->id)}}",
                type: 'post',
                data:{'_token':'{{ csrf_token() }}'} ,
                success: function(response) {
                    $("#product_gallery_box").empty()
                    $("#product_gallery_box").html(response)
                },
                error: function(xhr) {
                    let errorMessage = "Something went wrong.";
                    if (xhr.e.responseJSON && xhr.e.responseJSON.message) {
                        errorMessage = xhr.e.responseJSON.message;
                    }
                    swal("Error!", errorMessage, "error");
                }
            });
}
function submitFormForDomain(event, formElement) {
    event.preventDefault(); // Always pass event explicitly

    swal({
        title: "Confirmation!",
        text: "Are you sure you want to proceed?",
        icon: "warning",
        buttons: ["No", "Yes"],
        dangerMode: false,
    }).then((res) => {
        if (res) {
            //  $("#mainLoader1").modal('show')
             formData = new FormData(formElement);
            $.ajax({
                url: $(formElement).attr('action'),
                type: $(formElement).attr('method'),
                data:formData,
                contentType: false,         // Required for FormData
                processData: false,
                success: function(response) {
                    if (response.code == 1) {
                        swal("Success!", response.message, "success");

                    } else if (response.code == 0) {
                        swal("Sorry!", response.message, "error");
                    } else {
                        swal("Sorry!", "Unexpected response", "error");
                    }
                },
                error: function(xhr) {
                    let errorMessage = "Something went wrong.";
                    if (xhr.e.responseJSON && xhr.e.responseJSON.message) {
                        errorMessage = xhr.e.responseJSON.message;
                    }
                    swal("Error!", errorMessage, "error");
                },
                complete:function(){
                    $("#modal_product_domain").modal('hide')
                }
            });
        }
    });
}
  function saveTags(event, formElement){
      event.preventDefault(); 
         formData = new FormData(formElement);
             $.ajax({
                url: $(formElement).attr('action'),
                type: $(formElement).attr('method'),
                data:formData,
                contentType: false,        
                processData: false,
                success: function(response) {
                    if (response.code == 1) {
                        swal("Success!", response.message, "success");
                        formElement.reset();
                        loadTags('{{ $item->id }}');
                    } else if (response.code == 0) {
                        swal("Sorry!", response.message, "error");
                    } else {
                        swal("Sorry!", "Unexpected response", "error");
                    }
                },
                error: function(xhr) {
                    let errorMessage = "Something went wrong.";
                    if (xhr.e.responseJSON && xhr.e.responseJSON.message) {
                        errorMessage = xhr.e.responseJSON.message;
                    }
                    swal("Error!", errorMessage, "error");
                },
                complete:function(){
                    $("#modal_product_domain").modal('hide')
                }
            });
}
function loadTags(productId) {
    $.ajax({
        url: "{{ route('pmm.products.tag', ':id') }}".replace(':id', productId),
        type: 'GET',
        success: function (response) {
            $('#tagList').html('');

            if (!response.code) {
                $('#tagList').html('<p class="text-danger">Failed to load tags.</p>');
                return;
            }

            const tags = response.tags;

            if (!tags || tags.length === 0) {
                $('#tagList').html('<p class="text-muted">No tags found for this product.</p>');
                return;
            }

            tags.forEach(tag => {
                $('#tagList').append(`
              <span class="badge d-inline-flex align-items-center m-1"
                id="tag_${tag.id}"
                style="background:#fff; color:var(--bs-primary); border:1px solid var(--bs-primary); padding:6px 10px; border-radius:6px; font-size:13px;">
                <span class="me-2">${tag.tag}</span>

                <form action="{{ route('pmm.products.delete.tag') }}"
                    method="POST"
                    onsubmit="deletetag(event, this)"
                    style="display:inline;">
                    @csrf
                    <input type="hidden" name="tagid" value="${tag.id}">
                    <button type="submit"
                            class="btn btn-sm"
                            style="
                           background: #fff;
                                color: var(--bs-primary);
                                border: 1px solid var(--bs-primary);
                                padding: 10px;
                                border-radius: 6px;
                                font-size: 15px;
                            
                            ">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </span>
                `);
            });
        },
        error: function () {
            swal("Error!", "Something went wrong while loading tags.", "error");
        }
    });
}
$(document).ready(function () {
    let productId = '{{ $item->id }}';
    loadTags(productId);
});
// ✅ Delete category
function deletetag(event, formElement) {
    event.preventDefault();

    swal({
        title: "Are you sure?",
        text: "This tag will be deleted!",
        icon: "warning",
        buttons: ["No", "Yes"],
        dangerMode: true,
    }).then((willDelete) => {
        if (!willDelete) return;

        $.ajax({
            url: $(formElement).attr('action'),
            type: 'POST',
            data: new FormData(formElement),
            contentType: false,
            processData: false,
      success: function (response) {
                if (response.code) {
                    swal("Success!", response.message, "success");
                    loadTags('{{ $item->id }}'); // Reload tags after delete
                } else {
                    swal("Error!", response.message || "Something went wrong.", "error");
                }
            },

            error: function () {
                swal("Error!", "Failed to delete tag.", "error");
            }
        });
    });
}
function saveProductCategory(event, formElement) {
    event.preventDefault(); // prevent default form submit

    let formData = new FormData(formElement);

    $.ajax({
        url: $(formElement).attr('action'),        // form action URL (with product ID)
        type: $(formElement).attr('method'),      // form method (POST)
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            if (response.code == 1) {
                swal("Success!", response.message || "Categories saved successfully!", "success");
            } else if (response.code == 0) {
                swal("Sorry!", response.message || "Unable to save categories.", "error");
            } else {
                swal("Sorry!", "Unexpected response", "error");
            }
        },
        error: function(xhr) {
            let errorMessage = "Something went wrong.";
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            swal("Error!", errorMessage, "error");
        }
    });
}


</script>
