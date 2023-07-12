<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AdminController;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use App\Models\Product_details;
use App\Models\Color;
use App\Models\Size;
use App\Models\Comment;
session_start();
class ProductController extends Controller
{
    public function Authlogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }

    public function add_product(){
        $this->Authlogin();

        $cate_product = Category::orderBy('category_id','desc')->get();
        $brand_product = Brand::orderBy('brand_id','desc')->get();

        return view('admin.add_product')->with('cate_product', $cate_product)
        ->with('brand_product', $brand_product);
    }

    public function all_product(){
        $this->Authlogin();
        $all_product = Product::
        join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
        ->orderBy('tbl_product.product_id','desc')->get();
        // dd($all_product);
        $manager_product = view('admin.all_product')->with('all_product',$all_product);
        return view('admin_layout')
        ->with('admin.all_product',$manager_product);
    }

    public function save_product(Request $request){
        $this->Authlogin();
        $data = array();
        $data['product_name'] = $request->product_name;
        $data['product_price'] = $request->product_price;
        $data['product_image'] = $request->product_image;
        $data['product_desc'] = $request->product_desc;
        $data['product_content'] = $request->product_content;
        $data['category_id'] = $request->product_cate;
        $data['brand_id'] = $request->product_brand;
        $data['product_status'] = $request->product_status;
        $get_image = $request->file('product_image');
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/product',$new_image);
            $data['product_image'] = $new_image;
            Product::insert($data);
            Session::put('message','Thêm sản phẩm thành công.');
            return Redirect::to('add-product');
        }
        $data['product_image'] = '';
        Product::insert($data);
        Session::put('message','Thêm sản phẩm thành công.');
        return Redirect::to('all-product');
    }
    public function send_comment(Request $request){
        //tap 146
        $product_id = $request->product_id;
        $comment_name = $request->comment_name;
        $comment_content = $request->comment_content;
        $cmt = new Comment();
        $cmt->comment = $comment_content;
        $cmt->comment_name = $comment_name;
        $cmt->comment_product_id = $product_id;
        $cmt->comment_status = 1;
        $cmt->save();
    }

    public function load_comment(Request $request){
        $product_id = $request->product_id;
        $comment = Comment::where('comment_product_id',$product_id)->where('comment_status',1)->get();
        $output = '';
        foreach($comment as $key => $comm){
            $output .='
            <div class="row style_comment">
            <div class="col-md-2">
                <img src="'.url('/frontend/images/user.png').'" class="img img-responsive img-thumbnail" style="width: 60px;height: 60px; border-radius: 40px; margin-top: px;margin:10px">
            </div>
            <div class="col-md-10" style="margin-top:10px">
                <p style="color: black; font-size:15px;">@.'.$comm->comment_name.' --- Date: '.$comm->comment_date.'</p>
                <p>'.$comm->comment.'</p>
            </div>
       </div>
       <p></p>
            ';
        }
        echo $output;
    }
    public function unactive_product($product_id){
        $this->Authlogin();
        Product::where('product_id',$product_id)->update(['product_status'=>1]);
        Session::put('message','Kích hoạt sản phẩm.');
        return Redirect::to('all-product');
    }
    public function active_product($product_id){
        $this->Authlogin();
        Product::where('product_id',$product_id)->update(['product_status'=>0]);
        Session::put('message','Không kích hoạt sản phẩm.');
        return Redirect::to('all-product');
    }
    public function edit_product($product_id){
        $this->Authlogin();
        $cate_product = Category::orderBy('category_id','desc')->get();
        $brand_product = Brand::orderBy('brand_id','desc')->get();
        $edit_product = Product::where('product_id',$product_id)->get();
        return view('admin.edit_product', [
            'edit_product'=>$edit_product,
            'cate_product'=>$cate_product,
            'brand_product'=>$brand_product,
        ]);

    }
    public function update_product(Request $request, $product_id){
        $this->Authlogin();
        $data = array();
        $data['product_name'] = $request->product_name;
        $data['product_price'] = $request->product_price;
        $data['product_desc'] = $request->product_desc;
        $data['product_content'] = $request->product_content;
        $data['category_id'] = $request->product_cate;
        $data['brand_id'] = $request->product_brand;

        $get_image = $request->file('product_image');

        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/product',$new_image);

            $data['product_image'] = $new_image;
            Product::where('product_id',$product_id)->update($data);
            Session::put('message','Cập nhật sản phẩm thành công.');
            return Redirect::to('all-product');
        }

        Product::where('product_id',$product_id)->update($data);
        Session::put('message','Cập nhật sản phẩm thành công.');
        return Redirect::to('all-product');
    }
    public function delete_product($product_id){
        $this->Authlogin();
        Product::where('product_id',$product_id)->delete();
        Session::put('message','Xóa sản phẩm thành công');
        return Redirect::to('all-product');
    }
    //Ket thuc admin
    public function details_product($product_id, Request $request){
        $lay_mau = Product_details::select('color_name',)->where('product_id',$product_id)->get();
        $lay_size = Product_details::select('size_name',)->where('product_id',$product_id)->get();
        $tam_mau=[];
        foreach($lay_mau as $v_mau){
            $tam_mau[]=Color::select('color_id','color_name')->where('color_id',$v_mau->color_name)->get();
        }
        $tam_size=[];
        foreach($lay_size as $v_size){
            $tam_size[]=Size::select('size_id','size_name')->where('size_id',$v_size->size_name)->get();
        }
        $mau = $tam_mau;
        $size = $tam_size;
        // dd($tam_mau);
        // dd($tam_size);
        $cate_product = Category::where('category_status','1')->orderBy('category_id','desc')->get();
        $brand_product = Brand::where('brand_status','1')->orderBy('brand_id','desc')->get();
        $product_details =  Product_details::orderBy('product_details_id','desc')->get();
        $details_product =  Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
        ->where('tbl_product.product_id',$product_id)->get();
        //dd($details_product);
        foreach($details_product as $key => $value){
            $category_id = $value->category_id;
        }
        //SP lien quan
        $related_product =  Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
        ->where('tbl_category_product.category_id',$category_id)->whereNotIn('tbl_product.product_id',[$product_id])->get();
        foreach($details_product as $lay_view){
            $view_cuoi = $lay_view->product_view += 1;
        }
        Product::where('product_id',$product_id)->update(['product_view'=>$view_cuoi]);
        return view('pages.sanpham.show_details',[
            'category'=>$cate_product,
            'brand'=>$brand_product,
            'details_product'=>$details_product,
            'relate'=>$related_product,
            'product_details'=>$product_details,
            'lay_size'=>$size,
            'lay_mau'=>$mau,
        ]);
    }
}
