@extends('admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Thêm size sản phẩm
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
                            <div class="position-center">
                                <form role="form" action="{{URL::to('/save-size-product')}}"method="post">
                                    {{csrf_field()}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên size</label>
                                    <input type="text" name="size_product_name"class="form-control" id="
                                    exampleInputEmail1" placeholder="Tên size">
                                </div>
                                <div class="form-group">
                                <label for="exampleInputPassword1">Hiển thị</label>
                                    <select name="size_product_status"class="form-control input-sm m-bot15">
                                        <option value="0">Ẩn</option>
                                        <option value="1">Hiện</option>

                                    </select>
                                </div>

                                <button type="submit" name="add_size_product"class="btn btn-info">Thêm size</button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
@endsection
