@extends('frontend.themes.eshoper.layout')
@section('content')
<br>
	<section>
		<div class="container">
			<div class="row">


				<div class="col-sm-8">
					<div class="product-details"><!--product-details-->
						<div class="col-sm-6">
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
								<p><b>Brand:</b> ScalifyPro</p>
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
                              {{ !empty($link->product_description)?$link->product_description:$product->description }}
								</div>
							</div>

						</div>
					</div><!--/category-tab-->


				</div>
                <div class="col-sm-4">
                    <form action="{{route('frontend.product.checkout',request('id'))}}" id="create_sprint_form" method="post" onsubmit="submitForm(event, this)">
                        <h3>Shipping Details</h3>
                        @csrf
										<span>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input type="text" name="name" required class="form-control" placeholder="Your Name"/>
                                                </div>
                                            </div>
                                            <div  style="margin-top: 10px"></div>
                                            <div class="row mt-1">
                                                <div class="col-md-12">
                                                    <input type="email" name="email" required class="form-control" placeholder="Email Address"/>
                                                </div>
                                            </div>
                                            <div  style="margin-top: 10px"></div>
                                           <div class="row mt-1">
                                                <div class="col-md-6">
                                                <input type="text" name="phone" required class="form-control" placeholder="Phone"/>
                                                </div>
                                                <div class="col-md-6">
                                                <input type="number" min="1" name="quantity" required class="form-control" placeholder="Quantity"/>
                                                </div>
                                           </div>
                                            <div  style="margin-top: 10px"></div>
                                        </span>

										<textarea  name="address" required style="height: 120px" class="form-control" placeholder="Shipping Address"></textarea>
										<br>
                                        <button id="btncheckout" type="submit" class="form-control" class="btn btn-primary">
											Submit & Continue
										</button>
									</form>
                </div>
			</div>
		</div>
	</section>
    <br>
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
</script>
@endsection
