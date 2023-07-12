@extends('welcome')
@section('content')
<div class="features_items"><!--features_items-->
						<h2 class="title text-center">Sản phẩm mới nhất</h2>
                        <div class="row" >
                            <div class="col-md-4" style="margin-bottom: 10px; margin-left: 15px">
                                <label for="amount">Sắp xếp theo</label>
                                <form action="">
                                    @csrf
                                    <select name="sort" id="sort" class="form-control">
                                        <option value="{{ Request::url() }}?sort_by=none">Lọc</option>
                                        <option value="{{ Request::url() }}?sort_by=tang_dan">Tăng dần</option>
                                        <option value="{{ Request::url() }}?sort_by=giam_dan">Giảm dần</option>
                                        <option value="{{ Request::url() }}?sort_by=a_z">A-Z</option>
                                        <option value="{{ Request::url() }}?sort_by=z_a">Z-A</option>
                                    </select>
                                </form>
                            </div>
                        </div>
						@foreach($all_product as $key => $product)
                        <a href="{{URL::to('/chi-tiet-san-pham/'.$product->product_id)}}">
                            <div class="col-sm-4">
								<div class="product-image-wrapper">
									<div class="single-products">

											<div class="productinfo text-center">
                                                <form>
                                                @csrf
												<img src="{{URL::to('uploads/product/'.$product->product_image)}}" alt="" />

												<h3 style="color: rgb(0, 0, 0)">{{$product->product_name}}</h3>

												{{-- <h4>{{ 'Size: '.($product->size_name).' - Màu: '.($product->color_name)}}</h4> --}}
												<h2>{{ number_format($product->product_price).' VND'}}</h2>
												<a href="{{URL::to('/chi-tiet-san-pham/'.$product->product_id)}}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</a>

                                                <input type="hidden" value="{{ $product->product_id }}" class="cart_product_id_{{ $product->product_id }}">

                                                <input type="hidden" id="wishlist_productname{{ $product->product_id }}" value=" {{ $product->product_name }}" class="cart_product_name_{{ $product->product_id }}">
                                                {{-- <input type="hidden" value="{{ $product->product_quantity }}" class=" cart_product_quantity ([Sproduct-product_id)}"> --}}

                                                <input type="hidden" value="{{ $product->product_image }}" class="cart_product_image_{{ $product->product_id }}">
                                                <input type="hidden" id="wishlist_productprice{{ $product->product_id }}" value="{{ number_format($product->product_price,0,',','.')}}VND" class=" cart_product_price_{{ $product->product_id }}">
                                                <input type="hidden" value="1" class="cart_product_qty_{{ $product->product_id }}">
                                                {{-- <input type="hidden" id="wishlist_producturl{{ $product->product_id }}" href="{{URL::to('/chi-tiet-san-pham/'.$product->product_id)}}"> --}}
                                                <input type="hidden" id="wishlist_productimage{{ $product->product_id }}" src="{{URL::to('uploads/product/'.$product->product_image)}}">
                                                <a id="wishlist_producturl{{ $product->product_id }}" href="{{URL::to('/chi-tiet-san-pham/'.$product->product_id)}}">
                                                    {{-- <img id="wishlist_productimage{{ $product->product_id }}" src="{{URL::to('uploads/product/'.$product->product_image)}}" alt="" /> --}}
                                                    {{-- <h2>{{ number_format($product->product_price,0,',','.').'VND'}}</h2>
                                                    <p>{{ $product->product_name }}</p> --}}
                                                </a>
                                                </form>
											</div>

									</div>
									{{-- <div class="choose">
										<ul class="nav nav-pills nav-justified">

											<li style="text-align: center">
                                                <button class="button_wishlist" id="{{ $product->product_id }}" onclick="add_wishlist(this.id);" style="color: #f88107;border-radius: 10px"><span>+ Yêu thích</span></button>
                                            </li>

										</ul>
									</div> --}}
								</div>
							</div>
                        </a>
						@endforeach
					</div>
@endsection
