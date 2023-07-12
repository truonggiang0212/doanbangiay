@extends('admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Thêm chi tiết sản phẩm
                        </header>
                        <div class="panel-body">
                        <?php
                        use Illuminate\Support\Facades\Session;
                        $message = Session::get('message');
                        if($message){
                            echo '<span class="text-alert">',$message.'</span>';
                            Session::put('message',null);
                        }
                        ?>
                            @foreach($edit_product_details as $key => $edit_value)
                            <div class="position-center">
                                <form role="form" action="{{URL::to('/update-product-details/'.$edit_value->product_details_id)}}"method="post">
                                    {{csrf_field()}}
                                    <label for="exampleInputPassword1">Tên sản phẩm</label>
                                    <select name="product_id" class="form-control input-sm m-bot15">
                                        @foreach($name_product as $key => $name)
                                        <option value="{{$name->product_id}}"{{ $edit_value->product_id==$name->product_id ? 'selected' : ''}} >{{$name->product_name}}</option>
                                        @endforeach
                                    </select>
                                    <label for="exampleInputPassword1">Size</label>
                                    <select name="size_name" class="form-control input-sm m-bot15">
                                        @foreach($size_product as $key => $size)
                                        <option value="{{$size->size_id}}"{{ $edit_value->size_name==$size->size_id ? 'selected' : ''}}>{{$size->size_name}}</option>
                                        @endforeach
                                    </select>
                                        <div class="form-group">
                                        <label for="exampleInputPassword1">Màu</label>
                                            <select name="color_name" value="{{ $edit_value->color_name }}" class="form-control input-sm m-bot15">
                                                @foreach($color_product as $key => $color)
                                                <option value="{{$color->color_id}}"{{ $edit_value->color_name==$color->color_id ? 'selected' : ''}}>{{$color->color_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Số lượng</label>
                                            <input type="number" value="{{ $edit_value->quantity }}" name="quantity"class="form-control" id="
                                            exampleInputEmail1" placeholder="Số lượng sản phẩm">
                                        </div>
                                        </div>
                                <button type="submit" name="update_product_details"class="btn btn-info">Cập nhật tiết sản phẩm</button>
                            </form>
                            </div>
                            @endforeach
                        </div>
                    </section>

            </div>
@endsection
