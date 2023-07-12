@extends('admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Cập nhật size
                        </header>
                        <div class="panel-body">
                            @foreach($edit_size_product as $key => $edit_value)
                            <div class="position-center">
                                <form role="form" action="{{URL::to('/update-size-product/'.$edit_value->size_id)}}" method="post">
                                    {{csrf_field()}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên size</label>
                                    <input type="text" value="{{ $edit_value->size_name}}" name="size_product_name"class="form-control" id="
                                    exampleInputEmail1" placeholder="Tên size">
                                </div>
                                <button type="submit" name="update_size_product"class="btn btn-info">Cập nhật size</button>
                            </form>
                            </div>
                        @endforeach
                        </div>
                    </section>

            </div>
@endsection