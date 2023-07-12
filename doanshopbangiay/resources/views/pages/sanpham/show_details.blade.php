@extends('welcome')
@section('content')

<section id="details_items">
    @if(session()->has('message'))
    <div class="alert alert-success">
        {!!session()->get('message')!!}
    </div>
    @elseif(session()->has('error'))
    <div class="alert alert-danger">
        {!!session()->get('error')!!}
    </div>
    @endif
    @foreach ($details_product as $key => $value )
    <div class="product-details"><!--product-details-->
        <div class="col-sm-5">
            <div class="view-product">
                <img src="{{URL::to('/uploads/product/'.$value->product_image)}}" alt="" />
                {{-- <h3>ZOOM</h3> --}}
            </div>
            {{-- <div id="similar-product" class="carousel slide" data-ride="carousel">

                <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        <div class="item active">
                        <a href=""><img src="{{URL::to('/frontend/images/similar1.jpg')}}" alt=""></a>
                        <a href=""><img src="{{URL::to('/frontend/images/similar2.jpg')}}" alt=""></a>
                        <a href=""><img src="{{URL::to('/frontend/images/similar3.jpg')}}" alt=""></a>
                        </div>

                    </div>

                <!-- Controls -->
                <a class="left item-control" href="#similar-product" data-slide="prev">
                    <i class="fa fa-angle-left"></i>
                </a>
                <a class="right item-control" href="#similar-product" data-slide="next">
                    <i class="fa fa-angle-right"></i>
                </a>
            </div> --}}

        </div>

        <div class="col-sm-7">
            <div class="product-information"><!--/product-information-->
                <img src="images/product-details/new.jpg" class="newarrival" alt="" />
                <p style="font-size: 30px">{{$value->product_name}}</p>
                <input type="hidden" value="{{$value->product_id}}" name="lay_id" id="lay_id">
                <div style="display: flex">
                    <p class="selected" >
                        <div class="form-group" style="width: 130px">
                            <label for="exampleInputPassword1">Size</label>
                            <select id="select_size" name="product_size" class="form-control input-sm m-bot15 chonsize" onchange="myfun_size()">
                                <option value="0" disabled="true" selected="true">Chọn size</option>
                                @foreach($lay_size as $sizes)
                                    @for($i = 0; $i < count($sizes); $i++)
                                        <option value="{{$sizes[$i]->size_id}}">{{$sizes[$i]->size_name}}</option>
                                    @endfor
                                @endforeach
                            </select>
                        </div>
                            <div class="form-group" style="width: 130px; margin-left: 10px">
                            <label for="exampleInputPassword1">Màu</label>
                                <select id="select_color" name="product_color" class="form-control input-sm m-bot15 chonmau" onchange="myfun_mau()">
                                    <option value="0" disabled="true" selected="true">Chọn màu</option>
                                    @foreach($lay_mau as $colors)
                                        @for($i = 0; $i < count($colors); $i++)
                                          <option value="{{$colors[$i]->color_id}}">{{$colors[$i]->color_name}}</option>
                                        @endfor
                                    @endforeach
                                </select>
                        </div>
                    </p>
                </div>
                <form action="{{URL::to('/save-cart')}}" method="POST">
                    {{ @csrf_field() }}
                    <span>
                        <input type="hidden" id="sizes" name="hidden_size_name" value="">
                        <input type="hidden" id="colors" name="hidden_color_name" value="">
                        <span style="margin-top: -20px;">{{number_format($value->product_price).' VND'}}</span>
                        <label>Số lượng:</label>
                        <input name="qty" type="number" value="1" min="1" />
                        <input name="productid_hidden" type="hidden" value="{{$value->product_id}}" />
                        <button type="submit" class="btn btn-fefault cart">
                            <i class="fa fa-shopping-cart"></i>
                            Thêm giỏ hàng
                        </button>
                    </span>
                </form>
                {{-- <p><b>Tình trạng:</b> Còn hàng</p> --}}
                <p><b>Điều kiện:</b> Mới</p>
                <p><b>Danh mục:</b> {{$value->category_name}}</p>
                <p><b>Thương hiệu:</b> {{$value->brand_name}}</p>
                <a href=""><img src="images/product-details/share.png" class="share img-responsive"  alt="" /></a>
            </div><!--/product-information-->
        </div>
    </div><!--/product-details-->
    <div class="category-tab shop-details-tab"><!--category-tab-->
        <div class="col-sm-12">
            <ul class="nav nav-tabs">
                <li ><a href="#details" data-toggle="tab">Mô tả</a></li>
                <li><a href="#companyprofile" data-toggle="tab">Chi tiết sản phẩm</a></li>
                <li class="active"><a href="#reviews" data-toggle="tab">Đánh giá</a></li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade " id="details" >
                <p>{!!$value->product_desc!!}</p>
            </div>

            <div class="tab-pane fade" id="companyprofile" >
                <p>{!!$value->product_content!!}</p>
            </div>
            <div class="tab-pane fade active in" id="reviews" >
                <div class="col-sm-12">
                    {{-- <ul>
                        <li><a href=""><i class="fa fa-user"></i>EUGEN</a></li>
                        <li><a href=""><i class="fa fa-clock-o"></i>12:41 PM</a></li>
                        <li><a href=""><i class="fa fa-calendar-o"></i>31 DEC 2023</a></li>
                    </ul> --}}
                    <style type="text/css">
                        .row.style_comment {
                            border-radius: 10px;
                            border: 1px solid aliceblue;
                            background: rgb(230, 226, 226);
                            margin-bottom: 5px;
                        }
                    </style>
                    <form>
                        @csrf()
                        <input type="hidden" name="comment_product_id" class="comment_product_id" value="{{ $value->product_id }}">
                        <div id="comment_show"></div>

                    </form>

                   <p>Viết đánh giá của bạn</p>
                    <form action="#">

                        <span style="margin-left: 0%">
                            <input type="text" class="comment_name" placeholder="Tên bình luận"/>
                            {{-- <input type="email" placeholder="Email Address"/> --}}
                        </span>
                        <textarea name="comment" class="comment_content" placeholder="Nội dung bình luận"></textarea>
                        <div id="notify_comment"></div>
                        {{-- <b>Rating: </b> <img src="images/product-details/rating.png" alt="" /> --}}
                        <button type="button" class="btn btn-default pull-right send-comment">
                            Thêm bình luận
                        </button>

                    </form>
                </div>
            </div>

        </div>
    </div><!--/category-tab-->
@endforeach
<div class="recommended_items" style="margin-top: -50px;"><!--recommended_items-->
    <h2 class="title text-center">Sản phẩm liên quan</h2>

    <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel" >

        <div class="carousel-inner">
            <div class="item active">
                @foreach ($relate as $key =>$lienquan )
                <a href="{{URL::to('/chi-tiet-san-pham/'.$lienquan->product_id)}}">
                    <div class="col-sm-4">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <img src="{{URL::to('uploads/product/'.$lienquan->product_image)}}" alt="" />
                                    <h3 style="color: rgb(0, 0, 0)">{{$lienquan->product_name}}</h3>
                                    {{-- <h4>{{ 'Size: '.($lienquan->size_name).' - Màu: '.($lienquan->color_name)}}</h4> --}}
                                    <h2>{{ number_format($lienquan->product_price).' VND'}}</h2>
                                    <a href="{{URL::to('/chi-tiet-san-pham/'.$lienquan->product_id)}}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
         {{-- <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
            <i class="fa fa-angle-left"></i>
          </a>
          <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
            <i class="fa fa-angle-right"></i>
          </a> --}}
    </div>
</div><!--/recommended_items-->

</section>
<script type="text/javascript">
    function myfun_size(){
        let e = document.getElementById("select_size");
        let giaTriSize = e.options[e.selectedIndex].value;
        document.getElementById('sizes').setAttribute('value', giaTriSize);
    }
</script>
<script type="text/javascript">
    function myfun_mau(){
        let b = document.getElementById("select_color");
        let giaTriMau = b.options[b.selectedIndex].value;
        document.getElementById('colors').setAttribute('value', giaTriMau);
    }
</script>


@endsection
