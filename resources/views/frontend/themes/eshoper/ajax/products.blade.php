@if($products->count() > 0)
@foreach ($products as $p)
                            <div class="col-sm-4">
							<div class="product-image-wrapper">
								<div class="single-products">
										<div class="productinfo text-center">
											<img src="{{$p->attachment->file_url??''}}" alt="" style="height: 200px !important" />
											<h2>{{$p->price}}$</h2>
											<p>{{ \Illuminate\Support\Str::limit($p->name, 25, '...') }}</p>
											<a href="{{route('frontend.shop.product.view',product_encrypt($p->id))}}" class="btn btn-default add-to-cart"><i class="fa"></i>View Detail</a>
										</div>
										
								</div>
								{{-- <div class="choose">
									<ul class="nav nav-pills nav-justified">
										<li><a href="#"><i class="fa fa-plus-square"></i>Add to wishlist</a></li>
										<li><a href="#"><i class="fa fa-plus-square"></i>Add to compare</a></li>
									</ul>
								</div> --}}
							</div>
						</div>
                        @endforeach
                        @else

                          <div class="col-12 text-center my-5">
    <div class="col-12 text-center my-5">
    <h4 class="mb-3" style="color:#28a5ab">
        <i class="fa fa-folder-open-o" aria-hidden="true" style="font-size: 28px; margin-right: 10px;"></i>
        No products found
    </h4>
    <a href="{{ route('frontend.shop') }}" class="btn btn-primary" style="border-radius: 25px; padding: 10px 25px;">
        <i class="fa fa-refresh" aria-hidden="true" style="margin-right:5px"></i> Reset
    </a>
</div>

    </div>
@endif