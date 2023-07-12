<!DOCTYPE html>
<head>
<title>DashBoard</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- bootstrap-css -->
<link rel="stylesheet" href="{{asset('backend/css/bootstrap.min.css')}}" >
<!-- //bootstrap-css -->
<!-- Custom CSS -->
<link href="{{asset('backend/css/style.css')}}" rel='stylesheet' type='text/css' />
<link href="{{asset('backend/css/style-responsive.css')}}" rel="stylesheet"/>
<!-- font CSS -->
<link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<!-- font-awesome icons -->
<link rel="stylesheet" href="{{asset('backend/css/font.css')}}" type="text/css"/>
<link href="{{asset('backend/css/font-awesome.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('backend/css/morris.css')}}" type="text/css"/>
<!-- calendar -->
<link rel="stylesheet" href="{{asset('backend/css/monthly.css')}}">
<!-- //calendar -->
<!-- //font-awesome icons -->
<script src="{{asset('backend/js/jquery2.0.3.min.js')}}"></script>
<script src="{{asset('backend/js/raphael-min.js')}}"></script>
<script src="{{asset('backend/js/morris.js')}}"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<section id="container">
<!--header start-->
<header class="header fixed-top clearfix">
<!--logo start-->
<div class="brand">
    <a href="index.html" class="logo">
        ADMIN
    </a>
    <div class="sidebar-toggle-box">
        <div class="fa fa-bars"></div>
    </div>
</div>
<!--logo end-->

<div class="top-nav clearfix">
    <!--search & user info start-->
    <ul class="nav pull-right top-menu">
        <li>
            <input type="text" class="form-control search" placeholder=" Search">
        </li>
        <!-- user login dropdown start-->
        <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <img alt="" src="">
                <span class="username">
                <?php
                use Illuminate\Support\Facades\Session;
                    $name = Session::get('admin_name');
                    if($name){
                        echo $name;
                    }
                ?>
                </span>
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu extended logout">
                {{-- <li><a href="#"><i class=" fa fa-suitcase"></i>Profile</a></li>
                <li><a href="#"><i class="fa fa-cog"></i> Cài đặt</a></li> --}}
                <li><a href="{{URL::to('/logout')}}"><i class="fa fa-key"></i> Đăng xuất</a></li>
            </ul>
        </li>
        <!-- user login dropdown end -->
    </ul>
    <!--search & user info end-->
</div>
</header>
<!--header end-->
<!--sidebar start-->
<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
                <li>
                    <a class="active" href="{{URL::to('/dashboard')}}">
                        <i class="fa fa-dashboard"></i>
                        <span>Thống kê</span>
                    </a>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-address-card"></i>
                        <span>Khách hàng</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/all-account')}}">Quản lý tài khoản</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-server"></i>
                        <span>Danh mục sản phẩm</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/add-category-product')}}">Thêm danh mục sản phẩm</a></li>
						<li><a href="{{URL::to('/all-category-product')}}">Liệt kê danh mục sản phẩm</a></li>
                    </ul>
                </li>
				<li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-bars" aria-hidden="true"></i>
                        <span>Thương hiệu sản phẩm</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/add-brand-product')}}">Thêm thương hiệu sản phẩm</a></li>
						<li><a href="{{URL::to('/all-brand-product')}}">Liệt kê thương hiệu sản phẩm</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-google-wallet" aria-hidden="true"></i>
                        <span>Màu sản phẩm</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/add-color-product')}}">Thêm màu sản phẩm</a></li>
						<li><a href="{{URL::to('/all-color-product')}}">Liệt kê màu sản phẩm</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-sort-numeric-asc" aria-hidden="true"></i>
                        <span>Size sản phẩm</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/add-size-product')}}">Thêm size sản phẩm</a></li>
						<li><a href="{{URL::to('/all-size-product')}}">Liệt kê size sản phẩm</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                        <span>Sản phẩm</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/add-product')}}">Thêm sản phẩm</a></li>
						<li><a href="{{URL::to('/all-product')}}">Liệt kê sản phẩm</a></li>
                        <li><a href="{{URL::to('/add-product-details')}}">Thêm chi tiết sản phẩm</a></li>
						<li><a href="{{URL::to('/all-product-details')}}">Liệt kê chi tiết sản phẩm</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-list-ol" aria-hidden="true"></i>
                        <span>Đơn hàng</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/manage-order')}}">Quản lý đơn hàng</a></li>
						{{-- <li><a href="{{URL::to('/all-size-product')}}">Liệt kê đơn hàng</a></li> --}}
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-commenting-o" aria-hidden="true"></i>
                        <span>Bình luận</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/all-comment')}}">Quản lý bình luận</a></li>
						{{-- <li><a href="{{URL::to('/all-size-product')}}">Liệt kê đơn hàng</a></li> --}}
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-address-card"></i>
                        <span>Mã giảm giá</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/add-coupon')}}">Thêm mã giảm giá</a></li>
                        <li><a href="{{URL::to('/all-coupon')}}">Liệt kê mã giảm giá</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
	<section class="wrapper">
	@yield('admin_content')

    </section>
 <!-- footer -->
		  <div class="footer">
			<div class="wthree-copyright">
			  <p>©Web bán giày </p>
			</div>
		  </div>
  <!-- / footer -->
</section>
<!--main content end-->
</section>
<script src="{{asset('backend/js/bootstrap.js')}}"></script>
<script src="{{asset('backend/js/jquery.dcjqaccordion.2.7.js')}}"></script>
<script src="{{asset('backend/js/scripts.js')}}"></script>
<script src="{{asset('backend/js/js/jquery.slimscroll.js')}}"></script>
<script src="{{asset('backend/js/jquery.nicescroll.js')}}"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot-chart/excanvas.min.js"></script><![endif]-->
<script src="{{asset('backend/js/jquery.scrollTo.js')}}"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<!-- morris JavaScript -->
<script>
    $(document).ready(function(){
        chart30daysorder();
        chartluotban();
        tonkho();
        trangthai();
        var chart = new Morris.Area({
        element: 'myfirstchart',
        lineColors: ['#FF66CC','#FF66CC'],
        // pointFillColors: ['#ffffff'],
        // pointStrokeColors: ['black'],
        // fillOpacity: 0.6,
        parseTime: false,
        hideHover: 'auto',
        xkey: 'order_date_time',
        ykeys: ['order_total'],
        // behaveLikeLine: true,
        labels: ['Tiền']
        });
        //luot ban

        var chart_luotban = new Morris.Area({
        element: 'thongkeluotban',
        lineColors: ['#FF3399','#FF3399'],
        parseTime: false,
        hideHover: 'auto',
        xkey: 'product_name',
        ykeys: ['so_luong_ban'],
        labels: ['Tổng số lượng']
        });
        var tonkho = new Morris.Bar({
        element: 'tonkho',
        lineColors: ['#819C79','#FF6541'],
        parseTime: false,
        hideHover: 'auto',
        xkey: 'product_name',
        ykeys: ['quantity','product_color','product_size'],
        // behaveLikeLine: true,
        labels: ['Số lượng tồn','ID_Màu','ID_Size']
        });
        var trangthai = new Morris.Area({
        element: 'trangthai',
        lineColors: ['#819C79','#FF6541'],
        parseTime: false,
        hideHover: 'auto',
        xkey: 'order_status',
        ykeys: ['sl'],
        // behaveLikeLine: true,
        labels: ['Số lượng']
        });
        function tonkho(){
            var _token=$('input[name="_token"]').val();
            $.ajax({
            url:" {{url('/tonkho')}}",
            method: "POST",
            dataType: "JSON",
            data: {_token:_token},
            success:function(data)
            {
                tonkho.setData(data);
            }
            });
        }
        function trangthai(){
            var _token=$('input[name="_token"]').val();
            $.ajax({
            url:" {{url('/trangthai')}}",
            method: "POST",
            dataType: "JSON",
            data: {_token:_token},
            success:function(data)
            {
                trangthai.setData(data);
            }
            });
        }
        function chartluotban(){
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:"{{url('/luot-ban')}}",
                method: "POST",
                dataType: "JSON",
                data: {_token:_token},
                success:function(data)
                {
                    chart_luotban.setData(data);
                }

            });
        }

        //
        function chart30daysorder(){
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:"{{url('/days-order')}}",
                method: "POST",
                dataType: "JSON",
                data: {_token:_token},
                success:function(data)
                {
                   chart.setData(data);
                }

            });
        }
        $('.dashboard-filter').change(function(){
            var dashboard_value = $(this).val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
            url:"{{url('/dashboard-filter')}}",
            method: "POST",
            dataType: "JSON",
            data: {dashboard_value:dashboard_value,_token:_token},
            success:function(data)
            {
            chart.setData(data);
            }
            });
        });
        $('#btn-dashboard-filter').click(function(){
            var _token = $('input[name="_token"]').val();
            var from_date = $('#datepicker').val();
            var to_date = $('#datepicker2').val();
            // alert(from_date);
            // alert(to_date);
            $.ajax({
                url:"{{ url('/lay-ngay-loc') }}",
                method: "POST",
                dataType:"JSON",
                data: {from_date: from_date, to_date:to_date, _token:_token},
                success:function(data)
                    {
                    chart.setData(data);
                    }
            });
        });
    });

</script>
{{-- sơ đồ donut --}}



{{-- sơ đồ donut --}}
<script>
    $(function() {

        $( "#datepicker" ).datepicker({
            prevText:"Tháng trước",
            nextText:"Tháng sau",
            dateFormat: "yy-mm-dd",
            dayNamesMin: [ "Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7", "Chủ nhật" ],
            duration: "slow"
        });
        $( "#datepicker2" ).datepicker({
            prevText:"Tháng trước",
            nextText:"Tháng sau",
            dateFormat: "yy-mm-dd",
            dayNamesMin: [ "Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7", "Chủ nhật" ],
            duration: "slow"
        });
    });
</script>


{{-- <script>
	$(document).ready(function() {
		//BOX BUTTON SHOW AND CLOSE
	   jQuery('.small-graph-box').hover(function() {
		  jQuery(this).find('.box-button').fadeIn('fast');
	   }, function() {
		  jQuery(this).find('.box-button').fadeOut('fast');
	   });
	   jQuery('.small-graph-box .box-close').click(function() {
		  jQuery(this).closest('.small-graph-box').fadeOut(200);
		  return false;
	   });

	    //CHARTS
	    function gd(year, day, month) {
			return new Date(year, month - 1, day).getTime();
		}

		graphArea2 = Morris.Area({
			element: 'hero-area',
			padding: 10,
        behaveLikeLine: true,
        gridEnabled: false,
        gridLineColor: '#dddddd',
        axes: true,
        resize: true,
        smooth:true,
        pointSize: 0,
        lineWidth: 0,
        fillOpacity:0.85,
			data: [
				{period: '2015 Q1', iphone: 2668, ipad: null, itouch: 2649},
				{period: '2015 Q2', iphone: 15780, ipad: 13799, itouch: 12051},
				{period: '2015 Q3', iphone: 12920, ipad: 10975, itouch: 9910},
				{period: '2015 Q4', iphone: 8770, ipad: 6600, itouch: 6695},
				{period: '2016 Q1', iphone: 10820, ipad: 10924, itouch: 12300},
				{period: '2016 Q2', iphone: 9680, ipad: 9010, itouch: 7891},
				{period: '2016 Q3', iphone: 4830, ipad: 3805, itouch: 1598},
				{period: '2016 Q4', iphone: 15083, ipad: 8977, itouch: 5185},
				{period: '2017 Q1', iphone: 10697, ipad: 4470, itouch: 2038},

			],
			lineColors:['#eb6f6f','#926383','#eb6f6f'],
			xkey: 'period',
            redraw: true,
            ykeys: ['iphone', 'ipad', 'itouch'],
            labels: ['All Visitors', 'Returning Visitors', 'Unique Visitors'],
			pointSize: 2,
			hideHover: 'auto',
			resize: true
		});


	});
	</script> --}}
<!-- calendar -->
	<script type="text/javascript" src="{{asset('backend/js/monthly.js')}}"></script>
	<script type="text/javascript">
		$(window).load( function() {

			$('#mycalendar').monthly({
				mode: 'event',

			});

			$('#mycalendar2').monthly({
				mode: 'picker',
				target: '#mytarget',
				setWidth: '250px',
				startHidden: true,
				showTrigger: '#mytarget',
				stylePast: true,
				disablePast: true
			});

		switch(window.location.protocol) {
		case 'http:':
		case 'https:':
		// running on a server, should be good.
		break;
		case 'file:':
		alert('Just a heads-up, events will not work when run locally.');
		}

		});
	</script>
	<!-- //calendar -->
</body>
</html>
