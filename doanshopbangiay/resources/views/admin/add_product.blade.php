@extends('admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Thêm sản phẩm
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
                                <form role="form" action="{{URL::to('/save-product')}}"method="post" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên sản phẩm</label>
                                    <input type="text" name="product_name"class="form-control" id="
                                    exampleInputEmail1" placeholder="Tên sản phẩm">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Giá sản phẩm</label>
                                    <input type="number" name="product_price"class="form-control" id="
                                    exampleInputEmail1" placeholder="Giá sản phẩm">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Ảnh sản phẩm</label>
                                    <input type="file" name="product_image"class="form-control" id="
                                    exampleInputEmail1">
                                </div>
                                {{-- <div class="form-group">
                                <label for="exampleInputPassword1">Size</label>
                                    <select name="product_size"class="form-control input-sm m-bot15">
                                        @foreach($size_product as $key => $size)
                                        <option value="{{$size->size_id}}">{{$size->size_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                <label for="exampleInputPassword1">Màu</label>
                                    <select name="product_color"class="form-control input-sm m-bot15">
                                        @foreach($color_product as $key => $color)
                                        <option value="{{$color->color_id}}">{{$color->color_name}}</option>
                                        @endforeach
                                    </select>
                                </div> --}}

                                {{-- <table border="1" style="width: 50%">
                                    <tr>
                                       <th>Màu/Size</th>
                                       <th>38</th>
                                       <th>39</th>
                                       <th>40</th>
                                       <th>41</th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select name="product_color"class="form-control input-sm m-bot15">
                                                @foreach($color_product as $key => $color)
                                                <option value="{{$color->color_id}}">{{$color->color_name}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="product_sl">
                                        </td>
                                        <td>
                                            <input type="number" name="product_sl">
                                        </td>
                                        <td>
                                            <input type="number" name="product_sl">
                                        </td>
                                        <td>
                                            <input type="number" name="product_sl">
                                        </td>
                                    </tr>

                                 </table> --}}




                                {{-- <label for="exampleInputPassword1">Test size mau</label>
                                <table border="1" style="width: 100%">

                                    <tr>
                                       <th>Màu/Size</th>
                                            @foreach($size_product as $key => $size)
                                                <th value="{{$size->size_id}}" >{{$size->size_name}}</th>
                                            @endforeach
                                    </tr>
                                    <tr>
                                        <td>
                                            <select name="product_color"class="form-control input-sm m-bot15">
                                                @foreach($color_product as $key => $color)
                                                <option value="{{$color->color_id}}">{{$color->color_name}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        @foreach($size_product as $key => $size)
                                            <td>
                                                <input type="number" name="product_sl">
                                            </td>
                                        @endforeach
                                    </tr>
                                 </table> --}}



                                 <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả sản phẩm</label>
                                    <textarea style="resize: none" rows="5" type="password" name="product_desc" class="form-control" id="
                                    exampleInputPassword1" placeholder="Mô tả sản phẩm"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nội dung sản phẩm</label>
                                    <textarea style="resize: none" rows="5" type="password" name="product_content" class="form-control" id="
                                    exampleInputPassword1" placeholder="Nội dung sản phẩm"></textarea>
                                </div>
                                <div class="form-group">
                                <label for="exampleInputPassword1">Danh mục sản phẩm</label>
                                    <select name="product_cate" class="form-control input-sm m-bot15">
                                        @foreach($cate_product as $key => $cate)
                                        <option value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                <label for="exampleInputPassword1">Thương hiệu</label>
                                    <select name="product_brand" class="form-control input-sm m-bot15">
                                    @foreach($brand_product as $key => $brand)
                                        <option value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                <label for="exampleInputPassword1">Hiển thị</label>
                                    <select name="product_status"class="form-control input-sm m-bot15">
                                        <option value="0">Ẩn</option>
                                        <option value="1">Hiện</option>
                                    </select>
                                </div>

                                <button type="submit" name="add_product"class="btn btn-info">Thêm sản phẩm</button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
@endsection
