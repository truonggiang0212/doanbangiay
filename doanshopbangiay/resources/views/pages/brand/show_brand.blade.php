@extends('welcome')
@section('content')
<section class="show_brand">
    <div class="features_items"><!--features_items-->
        @foreach($brand_name as $key => $name)
            <h2 class="title text-center">{{$name->brand_name}}</h2>
        @endforeach
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
        @foreach($brand_by_id as $key => $product)
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
                        {{-- <div class="choose">
                            <ul class="nav nav-pills nav-justified">
                                <li style="text-align: center">
                                    <button class="button_wishlist" id="{{ $product->product_id }}" onclick="add_wishlist(this.id);" ><span>+ Yêu thích</span></button>
                                </li>
                            </ul>
                        </div> --}}
                    </div>
                </div>
            </a>


        @endforeach
    </div>
</section>

@endsection
