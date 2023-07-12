@extends('admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Cập nhật màu
                        </header>
                        <div class="panel-body">
                            @foreach($edit_color_product as $key => $edit_value)
                            <div class="position-center">
                                <form role="form" action="{{URL::to('/update-color-product/'.$edit_value->color_id)}}" method="post">
                                    {{csrf_field()}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên danh mục</label>
                                    <input type="text" value="{{ $edit_value->color_name}}" name="color_product_name"class="form-control" id="
                                    exampleInputEmail1" placeholder="Tên danh mục">
                                </div>
                                <button type="submit" name="update_color_product"class="btn btn-info">Cập nhật màu</button>
                            </form>
                            </div>
                        @endforeach
                        </div>
                    </section>

            </div>
@endsection
