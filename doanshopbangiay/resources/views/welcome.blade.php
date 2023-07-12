<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Home | GiayFake</title>
    <link href="{{asset('frontend/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/prettyPhoto.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/price-range.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/animate.css')}}" rel="stylesheet">
	<link href="{{asset('frontend/css/main.css')}}" rel="stylesheet">
	<link href="{{asset('frontend/css/responsive.css')}}" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="{{('frontend/images/ico/favicon.ico')}}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{('frontend/images/ico/apple-touch-icon-144-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{('frontend/images/ico/apple-touch-icon-114-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{('frontend/images/ico/apple-touch-icon-72-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" href="{{('frontend/images/ico/apple-touch-icon-57-precomposed.png')}}">
</head><!--/head-->

<body>

	<header id="header"><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="contactinfo">
							<ul class="nav nav-pills">
								<li><a href="#"><i class="fa fa-phone"></i> +84 377266388</a></li>
								<li><a href="#"><i class="fa fa-envelope"></i> sneakershop@gmail.com</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="social-icons pull-right">
							<ul class="nav navbar-nav">
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
								<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header_top-->

		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<div class="logo pull-left">
							<a href="index.html"><img src="{{ asset('frontend/images/logo1.jpg') }}" style="margin-top:-20px; margin-bottom:-20px; width: 150px; height: 70px;" /></a>
						</div>
						{{-- <div class="btn-group pull-right">
							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
									USA
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<li><a href="#">Canada</a></li>
									<li><a href="#">UK</a></li>
								</ul>
							</div>

							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
									DOLLAR
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<li><a href="#">Canadian Dollar</a></li>
									<li><a href="#">Pound</a></li>
								</ul>
							</div>
						</div> --}}
					</div>
					<div class="col-sm-8">
						<div class="shop-menu pull-right">
							<ul class="nav navbar-nav">

								{{-- <li><a href="#"><i class="fa fa-heart" aria-hidden="true"></i> Yêu thích</a></li> --}}

                                <?php
                                $customer_id = Session::get('customer_id');
                                $shipping_id = Session::get('shipping_id');
                                if($customer_id !=NULL &&  $shipping_id==NULL){
                                ?>
                               <li><a href="{{URL::to('/checkout')}}"><i class="fa fa-money" aria-hidden="true"></i> Thanh toán</a></li>
                                <?php
                                }elseif($customer_id !=NULL &&  $shipping_id!=NULL){
                                ?>
                                    <li><a href="{{URL::to('/payment')}}"><i class="fa fa-money" aria-hidden="true"></i> Thanh toán</a></li>
                                <?php
                                }else {
                                ?>
                                    <li><a href="{{URL::to('/login-checkout')}}"><i class="fa fa-money" aria-hidden="true"></i> Thanh toán</a></li>
                                <?php
                                }
                                ?>

								<li><a href="{{URL::to('/show-cart')}}"><i class="fa fa-shopping-cart"></i> Giỏ hàng</a></li>
                                <li><a href="{{URL::to('/show-lichsu')}}"><i class="fa fa-repeat" aria-hidden="true"></i></i>Lịch sử mua</a></li>

                                <?php
                                $customer_id = Session::get('customer_id');
                                if($customer_id !=NULL){
                                ?>
                                <li><a href="{{URL::to('/logout-checkout')}}"><i class="fa fa-sign-out" aria-hidden="true"></i> Đăng xuất</a></li>
                                <li><a href="{{URL::to('/update-account')}}"><i class="fa fa-user" aria-hidden="true"></i></i>Tài khoản</a></li>
                                <?php
                                }
                                else {
                                ?>
                                    <li><a href="{{URL::to('/login-checkout')}}"><i class="fa fa-sign-in" aria-hidden="true"></i> Đăng nhập</a></li>
                                <?php
                                }
                                ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-middle-->

		<div class="header-bottom"><!--header-bottom-->
			<div class="container">
				<div class="row">
					<div class="col-sm-8">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="mainmenu pull-left">
							<ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="{{URL::to('/trang-chu')}}" class="active">Trang chủ</a></li>
								{{-- <li class="dropdown"><a href="#">Shop<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        <li><a href="shop.html">Products</a></li>
										<li><a href="product-details.html">Product Details</a></li>
										<li><a href="checkout.html">Thanh toán</a></li>
										<li><a href="cart.html">Giỏ hàng</a></li>
										<li><a href="login.html">Đăng nhập</a></li>
                                    </ul>
                                </li> --}}
								{{-- <li class="dropdown"><a href="#">Blog<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        <li><a href="blog.html">Blog List</a></li>
										<li><a href="blog-single.html">Tin tức</a></li>
                                    </ul>
                                </li> --}}
								<li><a href="{{URL::to('/show-cart')}}">Giỏ hàng</a></li>
								<li><a href="contact-us.html">Liên hệ</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-4">
                        <form action="{{URL::to('/tim-kiem')}}" method="POST">
                            {{ csrf_field() }}
                            <div class="search_box pull-right" style="display: flex">
                                <input type="text" name="keywords_submit" placeholder="Tìm kiếm sản phẩm"/>
                                <input type="submit" name="search_items" style="color:#000;margin-top: 0"class="btn btn-primary btn-sm" value="Tìm kiếm"/>
                            </div>
                        </form>
					</div>
				</div>
			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->

	<section id="slider"><!--slider-->
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
									<h1><span>Sneaker</span>-SHOP</h1>
									<h2>Mua ngay nhận ưu đãi</h2>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
									<button type="button" class="btn btn-default get">Get it now</button>
								</div>
								<div class="col-sm-6" style="margin-top: 50px">
									<img src="{{asset('frontend\images\banner8.jpg')}}"  class="girl img-responsive" alt="" />
									{{-- <img src="{{('frontend\images\pricing.png')}}"  class="pricing" alt="" /> --}}
								</div>
							</div>
							<div class="item">
								<div class="col-sm-6">
									<h1><span>Sneaker</span>-SHOP</h1>
									<h2>Sắp có mã khuyến mãi</h2>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
									<button type="button" class="btn btn-default get">Get it now</button>
								</div>
								<div class="col-sm-6" style="margin-top: 50px">
									<img src="{{asset('frontend/images/banner10.jpg')}}" class="girl img-responsive" alt="" />
									{{-- <img src="{{('frontend/images/pricing.png')}}"  class="pricing" alt="" /> --}}
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
	</section><!--/slider-->

	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<div class="left-sidebar">
						<h2>Danh mục sản phẩm</h2>
						<div class="panel-group category-products" id="accordian"><!--category-productsr-->
							@foreach($category as $key => $cate)
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><a href="{{URL::to('/danh-muc-san-pham/'.$cate->category_id)}}">{{$cate->category_name}}</a></h4>
								</div>
							</div>
							@endforeach
						</div><!--/category-products-->

						<div class="brands_products"><!--brands_products-->
							<h2>Thương hiệu sản phẩm</h2>
							@foreach($brand as $key => $brand)
							<div class="brands-name">
								<ul class="nav nav-pills nav-stacked">
									<li><a href="{{URL::to('/thuong-hieu-san-pham/'.$brand->brand_id)}})}}">{{$brand->brand_name}}</a></li>

								</ul>
							</div>
							@endforeach
						</div>
                        {{-- <div class="brands_products"><!--brands_products-->
							<h2>Mã khuyến mãi</h2>
                            <div style="text-align: center;">
                                @foreach($coupon as $key => $cou)
                                <div class="brands-name">
                                    <p>{{ $cou->coupon_name }}: {{ $cou->coupon_code }} ( SL: {{ $cou->coupon_qty }})</p>
                                </div>
                                @endforeach
                            </div>

						</div> --}}

                        <!--/brands_products-->

                        {{-- <div class="brands_products"><!--brands_products-->
							<h2>Sản phẩm yêu thích</h2>
							<div class="brands-name">
								<div id="row_wishlist" class="row" style="margin: 0">

                                </div>
							</div>

						</div><!--/brands_products--> --}}


						<div class="shipping text-center"><!--shipping-->
							<img src="{{asset('frontend/images/poster.jpg')}}" alt="" style="width: 265px; margin-top: -20px;"/>
						</div><!--/shipping-->

					</div>
				</div>

				<div class="col-sm-9 padding-right">
				@yield('content')

				</div>
			</div>
		</div>
	</section>

	<footer id="footer"><!--Footer-->
		{{-- <div class="footer-top">
			<div class="container">
				<div class="row">
					<div class="col-sm-2">
						<div class="companyinfo">
							<h2><span>Sneaker</span>-shop</h2>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,sed do eiusmod tempor</p>
						</div>
					</div>
					<div class="col-sm-7">




						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="{{('frontend/images/iframe2.png')}}" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Circle of Hands</p>
								<h2>24 DEC 2014</h2>
							</div>
						</div>

						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="{{('frontend/images/iframe3.png')}}" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Circle of Hands</p>
								<h2>24 DEC 2014</h2>
							</div>
						</div>

						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="{{('frontend/images/iframe4.png')}}" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Circle of Hands</p>
								<h2>24 DEC 2014</h2>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="address">
							<img src="{{('frontend/images/map.png')}}" alt="" />
							<p>505 S Atlantic Ave Virginia Beach, VA(Virginia)</p>
						</div>
					</div>
				</div>
			</div>
		</div> --}}

		<div class="footer-widget">
			<div class="container">
				<div class="row">
					<div class="col-sm-2">
						<div class="companyinfo">
							<h2><span>Sneaker</span>-shop</h2>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,sed do eiusmod tempor</p>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Quock Shop</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">T-Shirt</a></li>
								<li><a href="#">Mens</a></li>
								<li><a href="#">Womens</a></li>
								<li><a href="#">Gift Cards</a></li>
								<li><a href="#">Shoes</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Policies</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Terms of Use</a></li>
								<li><a href="#">Privecy Policy</a></li>
								<li><a href="#">Refund Policy</a></li>
								<li><a href="#">Billing System</a></li>
								<li><a href="#">Ticket System</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>About Shopper</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Company Information</a></li>
								<li><a href="#">Careers</a></li>
								<li><a href="#">Store Location</a></li>
								<li><a href="#">Affillate Program</a></li>
								<li><a href="#">Copyright</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-3 col-sm-offset-1">
						<div class="single-widget">
							<h2>Sneaker-Shop</h2>
							<form action="#" class="searchform">
								<input type="text" placeholder="Your email address" />
								<button type="submit" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
								<p>Get the most recent updates from <br />our site and be updated your self...</p>
							</form>
						</div>
					</div>

				</div>
			</div>
		</div>

		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<p class="pull-left">© Giang vs Khôi.</p>

				</div>
			</div>
		</div>

	</footer><!--/Footer-->

    <script src="{{asset('frontend/js/jquery.js')}}"></script>
	<script src="{{asset('frontend/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('frontend/js/jquery.scrollUp.min.js')}}"></script>
	<script src="{{asset('frontend/js/price-range.js')}}"></script>
    <script src="{{asset('frontend/js/jquery.prettyPhoto.js')}}"></script>
    <script src="{{asset('frontend/js/main.js')}}"></script>

    {{-- Loc --}}
    <script type="text/javascript">
         $(document).ready(function(){
            $('#sort').on('change',function(){
                var url = $(this).val();
                if(url){
                    window.location = url;
                }
                return false;
            });
         });
    </script>
    {{-- Yeu thich --}}
    <script type="text/javascript">
    function view(clicked_id){
        if(localStorage.getItem('data')!=null){
            var data = JSON.parse(localStorage.getItem('data'));

            data.reverse();
            document.getElementById('row_wishlist').style.overflow = 'scroll';
            document.getElementById('row_wishlist').style.height = '400px';
            for(i=0; i<data.length; i++){
                var id = clicked_id;
                var name = data[i].name;
                var image = data[i].image;
                var price = data[i].price;
                var url = data[i].url;
                //chua lay dc id sau khi load
                $('#row_wishlist').append('<div class="row" style="margin: 10px 0"><div class="col-md-4"><img width="100%" src="'+image+'"></div><div class="col-md-8 info_wishlist"><p>'+name+'</p><p style="color: #FE980F">'+price+'</p><a href="'+url+'">Xem sản phẩm<p><a class="btn btn-danger btn-xs delete_wishlist" data-id="'+id+'" style="margin-top:0">Xóa yêu thích</a></p></div>');
            }
        }
    }
    $(document).on('click','.delete_wishlist',function(event){
                event.preventDefault(); // những hành động mặc định của sự kiện sẽ k xảy ra
                var id = $(this).data('id');

                // console.log(localStorage.getItem('data'));
                if (localStorage.getItem('data') != null) {
                    var data = JSON.parse(localStorage.getItem('data'));
                    if (data.length) {
                            for (i = 0; i < data.length; i++) {
                                if (data[i].id == id) {
                                data.splice(i,1); //xóa phần tử khỏi mảng, tham số thứ 2 là 1 phần tử
                            }
                        }
                    }

                    localStorage.setItem('data',JSON.stringify(data));  //chuyển obj->string
                    alert('Xóa thành công');
                    window.location.reload();
                }
            });
    view();
    function add_wishlist(clicked_id){
            var id = clicked_id;
            var name = document.getElementById('wishlist_productname'+id).value;
            var price = document.getElementById('wishlist_productprice'+id).value;
            var image = document.getElementById('wishlist_productimage'+id).src;
            var url = document.getElementById('wishlist_producturl'+id).href;

            var newItem = {'url':url, 'id':id, 'name':name, 'price':price, 'image':image}
            if(localStorage.getItem('data')==null){
                localStorage.setItem('data', '[]');
            }
            var old_data = JSON.parse(localStorage.getItem('data'));
            // old_data.push(newItem);


            var matches = $.grep(old_data, function(obj){
                return obj.id == id;
            })
            if(matches.length){
                alert('Sản phẩm bạn đã yêu thích,nên không thể thêm');
            }else{
                old_data.push(newItem);
                $('#row_wishlist').append('<div class="row" style="margin: 10px 0"><div class="col-md-4"><img width="100%" src="'+newItem.image+'"></div><div class="col-md-8 info_wishlist"><p>'+newItem.name+'</p><p style="color: #FE980F">'+newItem.price+'</p><a href="'+newItem.url+'">Xem sản phẩm</a><p><a class="btn btn-danger btn-xs delete_wishlist" data-id="'+newItem.id+'" style="margin-top:0">Xóa yêu thích</a></p></div>');
            }
            localStorage.setItem('data', JSON.stringify(old_data));
    }
    </script>
    {{-- Comment --}}
    <script>
        $(document).ready(function(){
            load_comment();
            function load_comment(){
                var product_id = $('.comment_product_id').val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{url('/load-comment')}}",
                    method:"POST",
                    data:{product_id:product_id, _token:_token},
                    success:function(data){
                        $('#comment_show').html(data);
                    }
                });
            }
            $('.send-comment').click(function(){
                var product_id = $('.comment_product_id').val();
                var comment_name = $('.comment_name').val();
                var comment_content = $('.comment_content').val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{ url('/send-comment') }}",
                    method: "POST",
                    data:{product_id:product_id,comment_name:comment_name ,comment_content:comment_content , _token:_token},
                    success:function(data){
                        load_comment();
                        $('#notify_comment').html('<span class="text text-success">Thêm bình luận thành công, Vui lòng chờ admin duyệt!!!</span>');

                        $('#notify_comment').fadeOut(7000);
                        $('.comment_name').val('');
                        $('.comment_content').val('');
                    }
                });
            });
        });
    </script>
    <script type="text/javascript">

        $(document).ready(function(){

            $(document).on('change','.chonsize',function(){
                var idpro=document.getElementById("lay_id").value;
                var size_id=$(this).val();
                var div=$(".chonmau").parent();
                var op=" ";

                $.ajax({
                    type:'get',
                    url:'{!!URL::to('find-mau')!!}',
                    data:{'id':size_id,'idpro':idpro},
                    success:function(data){
                        op+='<option value="0" selected disabled> Chọn màu</option>';
                        for(var i=0;i<data.length;i++){
                            op+='<option value="'+data[i].color_id+'">'+data[i].color_name+'</option>';
                       }
                       console.log(op);
                       div.find('.chonmau').html(" ");
                       console.log(div.find('.chonmau').html(" "));
                       div.find('.chonmau').append(op);
                    },
                    error:function(){
                    }
                });
            });
        });
    </script>

</body>
</html>

