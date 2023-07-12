@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
        Thông tin khách hàng
    </div>
    <div class="table-responsive">
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th>Tên người đặt</th>
            <th>Số điện thoại</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{$order_infor->customer_name }}</td>
            <td>{{$order_infor->customer_phone }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<br>
<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
          Thông tin vận chuyển
      </div>
      <div class="table-responsive">
        <table class="table table-striped b-t b-light">
          <thead>
            <tr>
              <th>Tên người nhận hàng</th>
              <th>Số điện thoại</th>
              <th>Địa chỉ</th>
              <th>Email</th>
              <th>Ghi chú</th>
              <th style="width:30px;"></th>
            </tr>
          </thead>
          <tbody>
            <tr>
                <td>{{$order_infor->shipping_name}}</td>
                <td>{{$order_infor->shipping_phone}}</td>
                <td>{{$order_infor->shipping_address}}</td>
                <td>{{$order_infor->shipping_email}}</td>
                <td>{{$order_infor->shipping_notes}}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
<br>
<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
        Liệt kê chi tiết đơn hàng
      </div>

      <div class="table-responsive">

        <table class="table table-striped b-t b-light">
          <thead>
            <tr>

              <th>Tên sản phẩm</th>
              <th>Size </th>
              <th>Màu </th>
              <th>Giá </th>
              <th>Số lượng</th>
              <th>Tổng tiền</th>

              <th style="width:30px;"></th>
            </tr>
          </thead>
          <tbody>
            @foreach($order_by_id as $order)
            <tr>
                <td>{{ $order->product_name }}</td>
                <td>{{ $order->product_size }}</td>
                <td>{{ $order->product_color }}</td>
                <td>{{number_format($order->product_price).' '.' VND'}}</td>
                <td>{{ $order->product_sales_quantity }}</td>
                <td>{{number_format($order->product_price * $order->product_sales_quantity).' '.' VND'}}</td>

            <td>
            @endforeach
                {{-- <a href="" class="active styling-edit" ui-toggle-class="">
                  <i class="fa fa-pencil-square-o text-success text-active"></i>
                  <a onclick="return confirm('Bạn chắc chắn muốn xóa không?')" href="" class="active styling-edit" ui-toggle-class="">
                    <i class="fa fa-times text-danger text"></i></a>
                </a> --}}
              </td>
            </tr>

          </tbody>
        </table>

      </div>

      <footer class="panel-footer">
        <div class="row">

          <div class="col-sm-5 text-center">
            <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
          </div>
          <div class="col-sm-7 text-right text-center-xs">
            <ul class="pagination pagination-sm m-t-none m-b-none">
              <li><a href=""><i class="fa fa-chevron-left"></i></a></li>
              <li><a href="">1</a></li>
              <li><a href="">2</a></li>
              <li><a href="">3</a></li>
              <li><a href="">4</a></li>
              <li><a href=""><i class="fa fa-chevron-right"></i></a></li>
            </ul>
          </div>
        </div>
      </footer>
    </div>
  </div>
@endsection
