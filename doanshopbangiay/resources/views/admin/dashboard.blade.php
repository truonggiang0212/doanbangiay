@extends('admin_layout')
@section('admin_content')


<div class="row" style="background-color: aliceblue">
    <h2 style="text-align: center">Thống kê</h2>
    <p style="margin-left: 15px;font-size: 20px;">Thống kê doanh số đơn hàng</p>
    <form action="" autocomplete="off">
        @csrf
        <div class="col-md-2">
            <p>Từ ngày:<input type="text" id="datepicker" class="form-control"></p>
            <input type="button" id="btn-dashboard-filter" class="btn btn-primary btn-sm" value="Lọc kết quả" style="margin: 15px 0 0 160px; background-color: #FF66CC">
        </div>
        <div class="col-md-2">
            <p>Đến ngày:<input type="text" id="datepicker2" class="form-control"></p>
        </div>
        <div class="col-md-2">
            <p>
            Lọc theo:
            <select class="dashboard-filter form-control" >
                <option>--Chọn--</option>
                <option value="7ngay"> 7 ngày qua</option>
                {{-- <option value="thangtruoc"> tháng trước</option> --}}
                <option value="thangnay"> tháng này</option>
                <option value="365ngayqua"> 365 ngày qua </option>
            </select>
            </p>
        </div>
        <style>
            .col-md-12 p{
                text-align: center;
                font-size: 25px;
            }
        </style>
        <div class="col-md-12">
            <p>Thống kê hóa đơn</p>
            <div id="myfirstchart" style="height: 200px"></div>
        </div>
        <div class="col-md-12" style="margin-top: 20px;">
            <p>Thống kê lượt bán</p>
            <div id="thongkeluotban" style="height: 200px"></div>
        </div>
        <div class="col-md-12" style="margin-top: 20px;">
            <p>Thống kê tồn kho</p>
            <div id="tonkho" style="height: 200px"></div>
        </div>
        <div class="col-md-12" style="margin-top: 20px;">
            <p>Thống kê trạng thái đơn hàng</p>
            <div id="trangthai" style="height: 200px"></div>
        </div>
    </form>
    <div class="row">
        {{-- <div class="col-md-4 col-xs-12">
            <p style="font-size: 20px;">Biểu đồ thống kê số lượng</p>
            <p>aaa</p>
            <div id="donut"></div>
        </div> --}}
        <div class="col-md-6 col-xs-12" style="margin-left: 50px">
            <p style="font-size: 20px;">Thống kê lượt xem sản phẩm</p>
            @foreach ($list_pro as $list)
            <div style="display: flex; color: rgb(57, 170, 246)">
                <p style="width: 200px">{{ $list->product_name }} có: <p style="color: #FF66CC"> {{ $list->product_view }}_</p><p> lượt xem</p></p>
            </div>
            @endforeach
            <div></div>
        </div>
    </div>
</div>

{{-- <div class="row">
    <p style="margin-left: 15px;font-size: 20px;">Thống kê sản phẩm bán chạy</p>
    <form action="" autocomplete="off">
        @csrf
        </div>
        <div class="col-md-12">
            <div id="thongkeluotban" style="height: 300px"></div>
        </div>
        <div class="col-md-2">
            <input type="button" id="btn-dashboard-filter" class="btn btn-primary btn-sm" value="Lọc kết quả" style="margin: 10px">
        </div>
    </form>
</div> --}}
@endsection

