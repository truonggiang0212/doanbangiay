@extends('welcome')
@section('content')
<div class="features_items"><!--features_items-->
    <h2 class="title text-center">Kết quả tìm kiếm</h2>
    @foreach($search_product as $key => $product)
    <a href="{{URL::to('/chi-tiet-san-pham/'.$product->product_id)}}">
        <div class="col-sm-4">
            <div class="product-image-wrapper">
                <div class="single-products">

                        <div class="productinfo text-center">
                            <img src="{{URL::to('uploads/product/'.$product->product_image)}}" alt="" />

                            <h3 style="color: rgb(0, 0, 0)">{{$product->product_name}}</h3>

                            {{-- <h4>{{ 'Size: '.($product->size_name).' - Màu: '.($product->color_name)}}</h4> --}}
                            <h2>{{ number_format($product->product_price).' VND'}}</h2>
                            <a href="{{URL::to('/chi-tiet-san-pham/'.$product->product_id)}}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</a>
                        </div>

                </div>
                <div class="choose">
                    <ul class="nav nav-pills nav-justified">
                        <li style="text-align: center">
                            <button class="button_wishlist" id="{{ $product->product_id }}" onclick="add_wishlist(this.id);" style="color: #f88107;"><span>+ Yêu thích</span></button>
                        </li>
                        {{-- <li><a href="#"><i class="fa fa-plus-square"></i>So sánh</a></li> --}}
                    </ul>
                </div>
            </div>
        </div>
    </a>

    @endforeach
</div>
@endsection
