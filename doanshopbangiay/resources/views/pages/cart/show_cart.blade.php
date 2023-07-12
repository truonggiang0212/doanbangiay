@extends('welcome')
@section('content')

<section id="cart_items">
    <div class="container" style="width: 990px">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
              <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
              <li class="active">Giỏ hàng của bạn</li>
            </ol>
        </div>
        <div class="table-responsive cart_info">
            <?php
            $content = Cart::content();
            // echo $content;
            $count = Cart::count();
            ?>
            @if($count != 0)
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Hình ảnh</td>
                        <td class="description">Mô tả</td>
                        <td class="size">Size</td>
                        <td class="color">Màu</td>
                        <td class="price">Giá</td>
                        <td class="quantity" style="width: 130px">Số lượng</td>
                        <td class="total">Tổng tiền</td>
                        <td class="total">Xóa</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($content as $v_content)
                            <tr>
                                <td class="cart_product">
                                    <a href="{{URL::to('/chi-tiet-san-pham/'.$v_content->id)}}"><img src="{{URL::to('uploads/product/'.$v_content->options->image)}}" width="80" alt=""></a>
                                </td>
                                <td class="cart_description">
                                    <h5><a href="{{URL::to('/chi-tiet-san-pham/'.$v_content->id)}}" style="color: black">{{$v_content->name}}</a></h5>
                                </td>
                                <td class="cart_size">
                                   <p>{{$v_content->options->sizes}}</p>

                                </td>
                                <td class="cart_color">
                                    <p>{{$v_content->options->colors}}</p>

                                 </td>
                                <td class="cart_price">
                                    <p>{{number_format($v_content->price).' '.' VND'}}</p>
                                </td>
                                <td class="cart_quantity">
                                    <div class="cart_quantity_button">
                                        <form action="{{URL::to('/update-cart-quantity')}}" method="POST">
                                            {{@csrf_field()}}
                                            <input class="cart_quantity_input" type="number" name="cart_quantity" value="{{$v_content->qty}}" style="width: 40%">
                                            <input type="hidden" value="{{$v_content->rowId}}" name="rowId_cart" class="form control">
                                            <input type="submit" value="Cập nhật" name="update_qty" class="btn btn-default btn-sm">
                                        </form>
                                    </div>
                                </td>
                                <td class="cart_total">
                                    <p class="cart_total_price" style="font-size: 20px">
                                        <?php
                                            $subtotal = $v_content->price *  $v_content->qty;
                                            echo number_format($subtotal).' '.'VND';
                                        ?>
                                    </p>
                                </td>
                                <td class="cart_delete">
                                    <a class="cart_quantity_delete" href="{{URL::to('/delete-to-cart/'.$v_content->rowId)}}"><i class="fa fa-times"></i></a>
                                </td>
                            </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section> <!--/#cart_items-->
<section id="do_action">
    <div class="container" style="width: 1000px">
        <div class="row">

            <div class="col-sm-4">
                <p>Nhập mã giảm giá đi chờ chi:</p>
                <td>
                    <form action="{{ url('/check-coupon') }}" method="POST">
                        @csrf
                        <input type="text" name="coupon" class="form-control" placeholder="Nhập mã giảm giá">
                        <input type="submit" name="check_coupon" class="btn btn-default check_coupon"  value="Xác nhận mã giảm giá" style="background-color: #ffcb87;margin:10px 0px 10px 0px">
                    </form>
                    @if(session()->has('message'))
                    <div class="alert alert-success">
                        {!!session()->get('message')!!}
                    </div>
                    @elseif(session()->has('error'))
                    <div class="alert alert-danger">
                        {!!session()->get('error')!!}
                    </div>
                    @endif
                </td>
            </div>
            <form action="{{URL::to('/checkout')}}" method="POST">
                @csrf
                <div class="col-sm-6">
                    <div class="total_area">
                        <ul>
                            {{-- <li>Tổng <span>{{Cart::priceTotal(0,',','.').' '.'VND'}}</span></li> --}}
                            <li>Phí vận chuyển: <span>Free</span></li>
                            <li>Thành tiền: <span>{{Cart::total(0,',','.').' '.'VND'}}</span></li>
                            @php
                            $total = Cart::total(0,',','');
                            @endphp
                            @if(Session::get('coupon')==NULL)
                            <?php
                            $customer_id = Session::get('customer_id');
                            if($customer_id !=NULL){
                                ?>
                                <a class="btn btn-default check_out" href="/checkout/{{0}}/{{ $total }}">Thanh toán không mã giảm</a>
                                <?php
                                }
                                else {
                                ?>
                                    <a class="btn btn-default check_out" href="{{URL::to('/login-checkout')}}">Thanh toán không mã giảm</a>
                                <?php
                                }
                                ?>
                                <input type="hidden" value="0" name="giam_gia">
                                <input type="hidden" value="{{$total}}" name="tien_phai_tra">
                            @endif
                            <li>
                                @if(Session::get('coupon'))
                                    @foreach(Session::get('coupon') as $key => $cou)
                                        @if($cou['coupon_condition']==1)
                                        Mã giảm : {{$cou['coupon_number']}} %
                                        <p>
                                            @php
                                            $total_coupon = ($total * $cou['coupon_number'])/100;
                                            echo '<p><li>Tổng giảm:'.number_format($total_coupon,0,',','.').' VND</li></p>';
                                            $total_end = $total-$total_coupon;
                                            @endphp
                                            <input type="hidden" value="{{$total_coupon}}" name="giam_gia">
                                        </p>
                                        <p>
                                            <li>Số tiền cần phải thanh toán:{{number_format($total_end,0,',','.')}} VND </li>

                                            <input type="hidden" value="{{$total_end}}" name="tien_phai_tra">
                                        </p>
                                        @elseif($cou['coupon_condition']==2)
                                            Mã giảm : {{number_format($cou['coupon_number'],0,',','.')}} VND
                                            <p>
                                                @php
                                                $total_end = $total - $cou['coupon_number'];
                                                $total_coupon = $cou['coupon_number'];
                                                @endphp

                                            </p>
                                            <p><li>Số tiền cần phải thanh toán:{{ number_format($total_end,0,',','.')}} VND</li></p>
                                            <input type="hidden" value="{{$total_coupon}}" name="giam_gia">
                                            <input type="hidden" value="{{$total_end}}" name="tien_phai_tra">
                                        @endif
                                    @endforeach
                                @endif
                            </li>
                        </ul>
                        <?php
                        $customer_id = Session::get('customer_id');
                        if($customer_id !=NULL){
                        ?>
                        @if(Session::get('coupon')!=0)

                        <a class="btn btn-default check_out" href="/checkout/{{ $total_coupon }}/{{$total_end}}">Thanh toán</a>
                        @endif

                        <?php
                        }
                        else {
                        ?>
                            <a class="btn btn-default check_out" href="{{URL::to('/login-checkout')}}">Thanh toán</a>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </form>

        </div>
    </div>
    @else
            <p style="
            color: #ffb102;
            font-size: 35px;
            font-weight: 300;
            margin-top: 45px;
            margin-bottom: 20px;
            font-weight: 400;
            ">Giỏ hàng trống, Vui lòng thêm giày vào giỏ.</p>
            @endif



</section>
@endsection
