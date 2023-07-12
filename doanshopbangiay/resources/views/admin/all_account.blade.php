@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê tài khoản khách hàng
    </div>
    <div class="row w3-res-tb">
      <div class="col-sm-3">
        <form action="{{URL::to('/tim-kiem-user')}}" method="POST">
            {{ csrf_field() }}
            <div class="input-group" style="display: flex;">
            <input type="text" name="keywords_submit" class="input-sm form-control" placeholder="Nhập user">
            <input type="submit" name="search_items" style="color:#000;margin-top: 0"class="btn btn-primary btn-sm" value="Tìm kiếm"/>
            </div>
        </form>
      </div>
    </div>
    <div class="table-responsive">
    <?php
	use Illuminate\Support\Facades\Session;
    $message = Session::get('message');
    if($message){
        echo '<span class="text-alert">',$message.'</span>';
        Session::put('message',null);
    }
    ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th>Tên khách hàng</th>
            <th>Email</th>
            <th>Mật khẩu</th>
            <th>Số điện thoại</th>
          </tr>
        </thead>
        <tbody>
            @foreach($all_account as $key => $acc)
          <tr>
            <td>{{ $acc->customer_name }}</td>
            <td>{{ $acc->customer_email }}</td>
            <td>{{ $acc->customer_password }}</td>
            <td>{{ $acc->customer_phone }}</td>
            {{-- <td><span class="text-ellipsis">
                <?php
                if($cate_pro->category_status==0){
                ?>
                    <a href="{{URL::to('/unactive-category-product/'.$cate_pro->category_id)}}"> <span class="fa-thumb-styling fa fa-thumbs-down"></span> </a>
                    <?php
                }else{
                    ?>
                    <a href="{{URL::to('/active-category-product/'.$cate_pro->category_id)}}"> <span class="fa-thumb-styling fa fa-thumbs-up"></span>  </a>
                    <?php
                    }
                ?>
            </span></td>

            <td>
              <a href="{{URL::to('/edit-category-product/'.$cate_pro->category_id)}}" class="active styling-edit" ui-toggle-class="">
                <i class="fa fa-pencil-square-o text-success text-active"></i>
                <a onclick="return confirm('Bạn chắc chắn muốn xóa không?')" href="{{URL::to('/delete-category-product/'.$cate_pro->category_id)}}" class="active styling-edit" ui-toggle-class="">
                  <i class="fa fa-times text-danger text"></i></a>
              </a>
            </td> --}}
          </tr>
          @endforeach
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
