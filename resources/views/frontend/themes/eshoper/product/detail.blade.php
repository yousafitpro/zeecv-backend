@extends('frontend.themes.eshoper.layout')
@section('content')
<style>
    .buy-now-container {
        width: 100%;
    display: flex;
    justify-content: center;  /* Horizontal center */
    align-items: center;      /* Vertical center */
    height: 100%;             /* Fill the column height */
    min-height: 300px;        /* Optional: ensures visible vertical centering */
}

.buy-now-btn {
    background: linear-gradient(135deg, #00a3a3, #007d7d);
    color: white;
    padding: 14px 32px;
    font-size: 16px;
    font-weight: bold;
    border-radius: 8px;
    text-transform: uppercase;
    border: none;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
    width: 200px;
   cursor: pointer; 
}

.view-product h3 {
    cursor: pointer;   
}
.buy-now-btn:hover {
    background: linear-gradient(135deg, #009090, #006b6b);
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
}

.buy-now-btn:active {
    transform: translateY(1px);
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
}
.zoom-modal .modal-dialog {
    max-width: 750px;       /* wider modal */
}

.zoom-modal .modal-content {
    border-radius: 10px;
    overflow: hidden;
}

.zoom-modal .modal-body {
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 600px;          
    background: #c3f2fdff;
}

.zoom-modal img {
    max-width: 100%;
    max-height: 100%;
    transition: transform 0.3s ease;
    object-fit: contain;
}

.zoom-modal img:hover {
    transform: scale(1.3);
    cursor: zoom-in;
}
.tag-badge {
    display: inline-block;

    color: #ffff;
    padding: 4px 10px;
    margin: 3px 3px 3px 0;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 500;
    transition: background-color 0.3s ease;
    cursor: default;
    font-size:16px;
    background-color: #007d7d;
}


</style>
<br>
	<section>
		<div class="container">
			<div class="row">


				<div class="col-sm-10">
					<div class="product-details"><!--product-details-->
						<div class="col-sm-5">
							<div class="view-product">
								<img src="{{ !empty($link->attachment)?$link->attachment->file_url:$product->attachment->file_url}}" alt="" style="max-height: 250px" />
								<h3>ZOOM</h3>
							</div>
                           @if (count($product->images)>0)

                            <div id="similar-product" class="carousel slide" data-ride="carousel">

								  <!-- Wrapper for slides -->
								    <div class="carousel-inner">
                                         @foreach ($product->images->chunk(3) as $chunkIndex => $chunk)
										<div class="item {{ $chunkIndex == 0 ? 'active' : '' }}">
                                          @foreach ($chunk as $pi)
										  <a href=""><img src="{{$pi->appfile->file_url}}" style="width: 90px;height:70px" alt=""></a>
                                          @endforeach
										</div>
                                        @endforeach

									</div>

								  <!-- Controls -->
								  <a class="left item-control" href="#similar-product" data-slide="prev">
									<i class="fa fa-angle-left"></i>
								  </a>
								  <a class="right item-control" href="#similar-product" data-slide="next">
									<i class="fa fa-angle-right"></i>
								  </a>
							</div>

                           @endif
						</div>
						<div class="col-sm-6">
							<div class="product-information"><!--/product-information-->
								<img src="images/product-details/new.jpg" class="newarrival" alt="" />
								<h2>{{ !empty($link->product_name)?$link->product_name:$product->name }}</h2>
								<p>Web ID: {{product_encrypt($product->id)}}</p>
								<img src="images/product-details/rating.png" alt="" />
								<span>
									<span>US ${{$product->price}}</span>

								</span>
								<p><b>Availability:</b> In Stock</p>
								<p><b>Condition:</b> New</p>
								<p><b>Brand:</b> Silkory</p>
                              @if($product->tags->count() > 0)
                                <p><b>Tags:</b>
                                @foreach($product->tags as $tag)
                                    <span class="tag-badge">{{ $tag->tag }}</span>
                                @endforeach
                                </p>
                            @endif
								<a href=""><img src="images/product-details/share.png" class="share img-responsive"  alt="" /></a>
							</div><!--/product-information-->

						</div>
					</div><!--/product-details-->

					<div class="category-tab shop-details-tab"><!--category-tab-->
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#reviews" data-toggle="tab">Details</a></li>
							</ul>
						</div>
						<div class="tab-content">


							<div class="tab-pane fade active in" id="reviews" >
								<div class="col-sm-12">
                              {!! $product->long_description !!}
								</div>
							</div>

						</div>
					</div><!--/category-tab-->


				</div>
                <div class="col-sm-2">
<div class="col-sm-4 buy-now-container">
    @php
        $checkout_link=route('frontend.product.url',product_encrypt($product->id));
        if(!empty($link->external_checkout_link))
        {
             $checkout_link=$link->external_checkout_link;
        }
    @endphp
   <a href="{{$checkout_link}}">

        @csrf
        <button type="submit" class="buy-now-btn">
            Buy Now
        </button>
    </a>
</div>

			</div>
		</div>
	</section>
    <br>
<!-- Zoom Image Modal -->
<div class="modal fade zoom-modal" id="zoomModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body p-0">
        <img id="zoomImage" src="" alt="Zoom Image">
      </div>
    </div>
  </div>
</div>
{!! $link->on_click !!}
<script>
    function submitForm(event, formElement) {
    event.preventDefault(); // Always pass event explicitly

    swal({
        title: "Confirmation!",
        text: "Are you sure you want to proceed?",
        icon: "warning",
        buttons: ["No", "Yes"],
        dangerMode: false,
    }).then((res) => {
        if (res) {
             formData = new FormData(formElement);
             $("#btncheckout").prop('disabled',true)
             $("#btncheckout").text("Saving...")
            $.ajax({
                url: $(formElement).attr('action'),
                type: $(formElement).attr('method'),
                data:formData,
                contentType: false,         // Required for FormData
                processData: false,
                success: function(response) {
                    if (response.code == 1) {
                        $("#create_sprint_form")[0].reset();
                    window.top.location.href = response.url;
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
                                 $("#btncheckout").prop('disabled',false)
             $("#btncheckout").text("Submit & Continue")
                }
            });
        }
    });
}


document.querySelector('.view-product h3').addEventListener('click', function () {
    const imgSrc = document.querySelector('.view-product img').src;
    document.getElementById('zoomImage').src = imgSrc;
    $('#zoomModal').modal('show');
});
</script>
@endsection
