@extends('frontend.themes.eshoper.layout')
@section('content')
<style>
        .header-middle .container .row {
            border-bottom: none;
    }
	.single-products {
    transition: transform 0.3s ease;
}

.single-products:hover {
    transform: translateY(-5px); 
   
}

.single-products img {
    transition: transform 0.3s ease;
}

.single-products:hover img {
    transform: scale(1.13);
}

.shop-filters .custom-range {
    width: 100%;
    margin-top: 10px;
}

.btn.btn-primary {
    background: #28a5ab;
    border: 0 none;

    margin-top: 16px;
    height: 40px;
    border-radius: 20px;
}
.custom-range {
  width: 100%;
  height: 6px;
  background: #ddd;
  border-radius: 5px;
  outline: none;
  -webkit-appearance: none;
}

/* Track */
.custom-range::-webkit-slider-runnable-track {
  background: #28a5ab;
  height: 6px;
  border-radius: 5px;
}

.custom-range::-moz-range-track {
  background: #28a5ab;
  height: 6px;
  border-radius: 5px;
}

/* Thumb */
.custom-range::-webkit-slider-thumb {
  -webkit-appearance: none;
  width: 18px;
  height: 18px;
  background: #28a5ab;
  border-radius: 50%;
  cursor: pointer;
  margin-top: -6px;
}

.custom-range::-moz-range-thumb {
  width: 18px;
  height: 18px;
  background: #28a5ab;
  border-radius: 50%;
  cursor: pointer;
}

</style>


	{{-- <section id="slider"><!--slider-->
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div id="slider-carousel" class="carousel slide" data-ride="carousel">
						<ol class="carousel-indicators">
							<li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
							<li data-target="#slider-carousel" data-slide-to="1"></li>
							<li data-target="#slider-carousel" data-slide-to="2"></li>
						</ol>

						<div class="carousel-inner">
							<div class="item active">
								<div class="col-sm-6">
									<h1><span>E</span>-SHOPPER</h1>
									<h2>Free E-Commerce Template</h2>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
									<button type="button" class="btn btn-default get">Get it now</button>
								</div>
								<div class="col-sm-6">
									<img src="{{asset('themes/eshoper/images/home/girl1.jpg')}}" class="girl img-responsive" alt="" />
									<img src="{{asset('themes/eshoper/images/home/pricing.png')}}"  class="pricing" alt="" />
								</div>
							</div>
							<div class="item">
								<div class="col-sm-6">
									<h1><span>E</span>-SHOPPER</h1>
									<h2>100% Responsive Design</h2>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
									<button type="button" class="btn btn-default get">Get it now</button>
								</div>
								<div class="col-sm-6">
									<img src="{{asset('themes/eshoper/images/home/girl2.jpg')}}" class="girl img-responsive" alt="" />
									<img src="{{asset('themes/eshoper/images/home/pricing.png')}}"  class="pricing" alt="" />
								</div>
							</div>

							<div class="item">
								<div class="col-sm-6">
									<h1><span>E</span>-SHOPPER</h1>
									<h2>Free Ecommerce Template</h2>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
									<button type="button" class="btn btn-default get">Get it now</button>
								</div>
								<div class="col-sm-6">
									<img src="{{asset('themes/eshoper/images/home/girl3.jpg')}}" class="girl img-responsive" alt="" />
									<img src="{{asset('themes/eshoper/images/home/pricing.png')}}" class="pricing" alt="" />
								</div>
							</div>

						</div>

						<a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
							<i class="fa fa-angle-left"></i>
						</a>
						<a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
							<i class="fa fa-angle-right"></i>
						</a>
					</div>

				</div>
			</div>
		</div>
	</section><!--/slider--> --}}

	<section>
		<div class="container">
			<div class="row">
				{{-- <div class="col-sm-3">
					<div class="left-sidebar">
						<h2>Category</h2>
						<div class="panel-group category-products" id="accordian"><!--category-productsr-->
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordian" href="#sportswear">
											<span class="badge pull-right"><i class="fa fa-plus"></i></span>
											Sportswear
										</a>
									</h4>
								</div>
								<div id="sportswear" class="panel-collapse collapse">
									<div class="panel-body">
										<ul>
											<li><a href="#">Nike </a></li>
											<li><a href="#">Under Armour </a></li>
											<li><a href="#">Adidas </a></li>
											<li><a href="#">Puma</a></li>
											<li><a href="#">ASICS </a></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordian" href="#mens">
											<span class="badge pull-right"><i class="fa fa-plus"></i></span>
											Mens
										</a>
									</h4>
								</div>
								<div id="mens" class="panel-collapse collapse">
									<div class="panel-body">
										<ul>
											<li><a href="#">Fendi</a></li>
											<li><a href="#">Guess</a></li>
											<li><a href="#">Valentino</a></li>
											<li><a href="#">Dior</a></li>
											<li><a href="#">Versace</a></li>
											<li><a href="#">Armani</a></li>
											<li><a href="#">Prada</a></li>
											<li><a href="#">Dolce and Gabbana</a></li>
											<li><a href="#">Chanel</a></li>
											<li><a href="#">Gucci</a></li>
										</ul>
									</div>
								</div>
							</div>

							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordian" href="#womens">
											<span class="badge pull-right"><i class="fa fa-plus"></i></span>
											Womens
										</a>
									</h4>
								</div>
								<div id="womens" class="panel-collapse collapse">
									<div class="panel-body">
										<ul>
											<li><a href="#">Fendi</a></li>
											<li><a href="#">Guess</a></li>
											<li><a href="#">Valentino</a></li>
											<li><a href="#">Dior</a></li>
											<li><a href="#">Versace</a></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><a href="#">Kids</a></h4>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><a href="#">Fashion</a></h4>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><a href="#">Households</a></h4>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><a href="#">Interiors</a></h4>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><a href="#">Clothing</a></h4>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><a href="#">Bags</a></h4>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><a href="#">Shoes</a></h4>
								</div>
							</div>
						</div><!--/category-products-->

						<div class="brands_products"><!--brands_products-->
							<h2>Brands</h2>
							<div class="brands-name">
								<ul class="nav nav-pills nav-stacked">
									<li><a href="#"> <span class="pull-right">(50)</span>Acne</a></li>
									<li><a href="#"> <span class="pull-right">(56)</span>Grüne Erde</a></li>
									<li><a href="#"> <span class="pull-right">(27)</span>Albiro</a></li>
									<li><a href="#"> <span class="pull-right">(32)</span>Ronhill</a></li>
									<li><a href="#"> <span class="pull-right">(5)</span>Oddmolly</a></li>
									<li><a href="#"> <span class="pull-right">(9)</span>Boudestijn</a></li>
									<li><a href="#"> <span class="pull-right">(4)</span>Rösch creative culture</a></li>
								</ul>
							</div>
						</div><!--/brands_products-->

						<div class="price-range"><!--price-range-->
							<h2>Price Range</h2>
							<div class="well text-center">
								 <input type="text" class="span2" value="" data-slider-min="0" data-slider-max="600" data-slider-step="5" data-slider-value="[250,450]" id="sl2" ><br />
								 <b class="pull-left">$ 0</b> <b class="pull-right">$ 600</b>
							</div>
						</div><!--/price-range-->

						<div class="shipping text-center"><!--shipping-->
							<img src="{{asset('themes/eshoper/images/home/shipping.jpg')}}" alt="" />
						</div><!--/shipping-->

					</div>
				</div> --}}
<div class="row">
  <div class="col-md-3">
 <div class="shop-filters p-4 shadow-sm rounded bg-white">

    <!-- Heading + Reset button in one row -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="font-weight-bold" style="color:#28a5ab">Filter Products</h4>
        <a href="{{ route('frontend.shop') }}" class="btn btn-secondary btn-sm font-weight-bold" style="margin-left:200px; margin-top:-50px; font-size:14px;">
            <i class="fa fa-refresh mr-1"></i> Reset
        </a>
    </div>

    <form action="{{ route('pmm.shop.search.products') }}" method="POST" onsubmit="submitFormAjax(event, this)">
        @csrf

        <!-- Product Name -->
        <div class="form-group mb-3">
            <label for="search_name" class="font-weight-bold" style="color:#28a5ab">Product Name</label>
            <input type="text" class="form-control" name="name" id="search_name" placeholder="Enter product name">
        </div>

        <!-- Price Range -->
        <div class="form-group mb-4">
            <label for="price_range" class="font-weight-bold" style="color:#28a5ab">
                Price Range: $<span id="price_value">50</span>
            </label>
            <input type="range" class="custom-range" name="price" id="price_range" min="0" max="500" step="5" value="50" style="color:#28a5ab">
        </div>

        <button type="submit" class="btn btn-primary btn-block font-weight-bold">
            <i class="fa fa-filter mr-2"></i> Apply Filters
        </button>
    </form>
</div>


</div>


    <!-- Products list -->
<div class="col-md-9">
    <div class="features_items">
        <h2 class="title text-center">Shop</h2>
        @include('frontend.themes.eshoper.ajax.products') {{-- initial products --}}
    </div>

  
</div>



					</div><!--features_items-->

					{{-- <div class="category-tab"><!--category-tab-->
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#tshirt" data-toggle="tab">T-Shirt</a></li>
								<li><a href="#blazers" data-toggle="tab">Blazers</a></li>
								<li><a href="#sunglass" data-toggle="tab">Sunglass</a></li>
								<li><a href="#kids" data-toggle="tab">Kids</a></li>
								<li><a href="#poloshirt" data-toggle="tab">Polo shirt</a></li>
							</ul>
						</div>
						<div class="tab-content">
							<div class="tab-pane fade active in" id="tshirt" >
								<div class="col-sm-3">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<img src="{{asset('themes/eshoper/images/home/gallery1.jpg')}}" alt="" />
												<h2>$56</h2>
												<p>Easy Polo Black Edition</p>
												<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-credit-card"></i>Buy Now</a>
											</div>

										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<img src="{{asset('themes/eshoper/images/home/gallery2.jpg')}}" alt="" />
												<h2>$56</h2>
												<p>Easy Polo Black Edition</p>
												<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-credit-card"></i>Buy Now</a>
											</div>

										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<img src="{{asset('themes/eshoper/images/home/gallery3.jpg')}}" alt="" />
												<h2>$56</h2>
												<p>Easy Polo Black Edition</p>
												<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-credit-card"></i>Buy Now</a>
											</div>

										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<img src="{{asset('themes/eshoper/images/home/gallery4.jpg')}}" alt="" />
												<h2>$56</h2>
												<p>Easy Polo Black Edition</p>
												<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-credit-card"></i>Buy Now</a>
											</div>

										</div>
									</div>
								</div>
							</div>

							<div class="tab-pane fade" id="blazers" >
								<div class="col-sm-3">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<img src="{{asset('themes/eshoper/images/home/gallery4.jpg')}}" alt="" />
												<h2>$56</h2>
												<p>Easy Polo Black Edition</p>
												<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-credit-card"></i>Buy Now</a>
											</div>

										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<img src="{{asset('themes/eshoper/images/home/gallery3.jpg')}}" alt="" />
												<h2>$56</h2>
												<p>Easy Polo Black Edition</p>
												<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-credit-card"></i>Buy Now</a>
											</div>

										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<img src="{{asset('themes/eshoper/images/home/gallery2.jpg')}}" alt="" />
												<h2>$56</h2>
												<p>Easy Polo Black Edition</p>
												<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-credit-card"></i>Buy Now</a>
											</div>

										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<img src="{{asset('themes/eshoper/images/home/gallery1.jpg')}}" alt="" />
												<h2>$56</h2>
												<p>Easy Polo Black Edition</p>
												<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-credit-card"></i>Buy Now</a>
											</div>

										</div>
									</div>
								</div>
							</div>

							<div class="tab-pane fade" id="sunglass" >
								<div class="col-sm-3">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<img src="{{asset('themes/eshoper/images/home/gallery3.jpg')}}" alt="" />
												<h2>$56</h2>
												<p>Easy Polo Black Edition</p>
												<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-credit-card"></i>Buy Now</a>
											</div>

										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<img src="{{asset('themes/eshoper/images/home/gallery4.jpg')}}" alt="" />
												<h2>$56</h2>
												<p>Easy Polo Black Edition</p>
												<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-credit-card"></i>Buy Now</a>
											</div>

										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<img src="{{asset('themes/eshoper/images/home/gallery1.jpg')}}" alt="" />
												<h2>$56</h2>
												<p>Easy Polo Black Edition</p>
												<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-credit-card"></i>Buy Now</a>
											</div>

										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<img src="{{asset('themes/eshoper/images/home/gallery2.jpg')}}" alt="" />
												<h2>$56</h2>
												<p>Easy Polo Black Edition</p>
												<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-credit-card"></i>Buy Now</a>
											</div>

										</div>
									</div>
								</div>
							</div>

							<div class="tab-pane fade" id="kids" >
								<div class="col-sm-3">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<img src="{{asset('themes/eshoper/images/home/gallery1.jpg')}}" alt="" />
												<h2>$56</h2>
												<p>Easy Polo Black Edition</p>
												<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-credit-card"></i>Buy Now</a>
											</div>

										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<img src="{{asset('themes/eshoper/images/home/gallery2.jpg')}}" alt="" />
												<h2>$56</h2>
												<p>Easy Polo Black Edition</p>
												<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-credit-card"></i>Buy Now</a>
											</div>

										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<img src="{{asset('themes/eshoper/images/home/gallery3.jpg')}}" alt="" />
												<h2>$56</h2>
												<p>Easy Polo Black Edition</p>
												<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-credit-card"></i>Buy Now</a>
											</div>

										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<img src="{{asset('themes/eshoper/images/home/gallery4.jpg')}}" alt="" />
												<h2>$56</h2>
												<p>Easy Polo Black Edition</p>
												<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-credit-card"></i>Buy Now</a>
											</div>

										</div>
									</div>
								</div>
							</div>

							<div class="tab-pane fade" id="poloshirt" >
								<div class="col-sm-3">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<img src="{{asset('themes/eshoper/images/home/gallery2.jpg')}}" alt="" />
												<h2>$56</h2>
												<p>Easy Polo Black Edition</p>
												<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-credit-card"></i>Buy Now</a>
											</div>

										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<img src="{{asset('themes/eshoper/images/home/gallery4.jpg')}}" alt="" />
												<h2>$56</h2>
												<p>Easy Polo Black Edition</p>
												<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-credit-card"></i>Buy Now</a>
											</div>

										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<img src="{{asset('themes/eshoper/images/home/gallery3.jpg')}}" alt="" />
												<h2>$56</h2>
												<p>Easy Polo Black Edition</p>
												<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-credit-card"></i>Buy Now</a>
											</div>

										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<img src="{{asset('themes/eshoper/images/home/gallery1.jpg')}}" alt="" />
												<h2>$56</h2>
												<p>Easy Polo Black Edition</p>
												<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-credit-card"></i>Buy Now</a>
											</div>

										</div>
									</div>
								</div>
							</div>
						</div>
					</div><!--/category-tab--> --}}

					<div class="recommended_items"><!--recommended_items-->
                        <br>
						<h2 class="title text-center">recommended items</h2>
                        <br>
						<div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
							<div class="carousel-inner">
                                @foreach ($random_products->chunk(3) as $chunkIndex => $chunk)
                                    <div class="item {{ $chunkIndex == 0 ? 'active' : '' }}">
                                        @foreach ($chunk as $product)
                                            <div class="col-sm-4">
                                                <div class="product-image-wrapper">
                                                    <div class="single-products">
                                                        <div class="productinfo text-center">
                                                            <img src="{{$product->attachment->file_url??''}}" style="height: 200px !important" alt="" />
                                                            <h2>${{ $product->price ?? '0.00' }}</h2>
                                                            <p>{{ $product->name }}</p>
                                                            <a href="{{route('frontend.shop.product.view',product_encrypt($product->id))}}" class="btn btn-default add-to-cart">
                                                                View
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>

							 <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
								<i class="fa fa-angle-left"></i>
							  </a>
							  <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
								<i class="fa fa-angle-right"></i>
							  </a>
						</div>
					</div><!--/recommended_items-->

				</div>
			</div>
            <div class="col-md-2">
</div>
		</div>
	</section>
<script>
const priceRange = document.getElementById('price_range');
const priceValue = document.getElementById('price_value');

priceRange.addEventListener('input', () => {
  priceValue.textContent = priceRange.value;
});


priceRange.addEventListener('input', () => {
    priceValue.textContent = priceRange.value;
});

function submitFormAjax(event, formElement) {
    event.preventDefault();
    let formData = new FormData(formElement);
    let submitBtn = $(formElement).find('button[type="submit"]');
    let originalText = submitBtn.html();

    submitBtn.html('Applying...').prop('disabled', true);

    $.ajax({
        url: $(formElement).attr('action'),
        type: $(formElement).attr('method'),
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            // AJAX se sirf shop products replace hon
            $('.features_items').html(response);
        },
        error: function(xhr) {
            console.error("Filter request failed");
        },
        complete: function() {
            submitBtn.html(originalText).prop('disabled', false);
        }
    });
}

</script>

@endsection 