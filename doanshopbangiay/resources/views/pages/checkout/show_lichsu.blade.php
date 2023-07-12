@extends('welcome')
@section('content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading" style="text-align: center;font-size: 23px;font-weight: bold; color: #ff8b00;">
      Lịch sử mua hàng của bạn
    </div>
    <div class="table-responsive">
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            {{-- <th>Tên người đặt</th> --}}
            <th>Tổng tiền</th>
            <th>Giảm giá</th>
            <th>Tiền thanh toán</th>
            <th>Thanh toán</th>
            <th>Trạng thái</th>
            <th>Xem chi tiết đơn hàng</th>
            <th>Hủy đơn hàng</th>
          </tr>
        </thead>
        <tbody>
            @foreach($history as $his)
                    <tr>
                        <td>{{number_format($his->order_total).' '.' VND'}}</td>
                        <td>{{number_format($his->giam_gia).' '.' VND'}}</td>
                        <td>{{number_format($his->so_tien_phai_tra).' '.' VND'}}</td>
                        <td>{{$his->payment_status }}</td>
                        <td>{{$his->order_status }}</td>
                        <td>
                        {{-- <a href="{{URL::to('/show-chitiet-lichsu/'.$his->order_id)}}" class="active styling-edit" ui-toggle-class="">
                            <i class="fa fa-caret-square-o-right" aria-hidden="true" style="font-size: 20px; margin-left: 60px;"></i>
                        </a> --}}
                        <a href="{{URL::to('/show-chitiet-lichsu/'.$his->order_id)}}" class="btn" ui-toggle-class="">
                            <button style="background-color: rgb(248, 255, 166);border-radius: 10px;width: 100px;">
                                Xem chi tiết
                            </button>
                        </a>
                        </td>
                        @if($his->order_status=='Đang chờ xử lý')
                            <td>
                                <a href="{{URL::to('/update-order-huy/'.$his->order_id)}}" class="btn" ui-toggle-class="">
                                    <button style="background-color: rgb(252, 168, 252);border-radius: 10px;width: 70px;">
                                        Hủy đơn
                                    </button>
                                </a>
                            </td>
                        @endif
                    </tr>
            @endforeach
        </tbody>
      </table>
    </div>
    {{-- <footer class="panel-footer">
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
    </footer> --}}
  </div>
</div>
{{-- <script>
    function update_gh(){
        location.reload();
    }
</script> --}}
@endsection
