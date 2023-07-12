<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Product_details;
use App\Models\Size;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
session_start();

class ProductDetailsController extends Controller
{
    public function Authlogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function add_product_details(){
        $this->Authlogin();
        $name_product = Product::orderBy('product_id','desc')->get();
        $size_product = Size::orderBy('size_id','desc')->get();
        $color_product = Color::orderBy('color_id','desc')->get();

        return view('admin.add_product_details')
        ->with('name_product', $name_product)
        ->with('size_product', $size_product)
        ->with('color_product', $color_product);

    }
    public function all_product_details(){
        $this->Authlogin();

        $all_product_details = Product_details::join('tbl_product','tbl_product.product_id','=','tbl_product_details.product_id')
        ->join('tbl_color_product','tbl_product_details.color_name','=','tbl_color_product.color_id')
        ->join('tbl_size_product','tbl_product_details.size_name','=','tbl_size_product.size_id')
        ->orderBy('tbl_product_details.product_details_id','desc')->get();
        //dd($all_product_details);
        $manager_product_details = view('admin.all_product_details')->with('all_product_details',$all_product_details);
        return view('admin_layout')
        ->with('admin.all_product_details', $manager_product_details);

    }
    public function save_product_details(Request $request){
        $this->Authlogin();
        $data = array();
        $data['product_id']=$request->product_id;
        $data['color_name']=$request->color_name;
        $data['size_name']=$request->size_name;
        $data['quantity']=$request->quantity;
        //
        // $slctsp = Product_details::where('product_id', $request->product_id)
        // ->where('color_name',$request->color_name)
        // ->where('size_name',$request->size_name)
        // ->get();
        // foreach($slctsp as $ct){
        //     $id = $ct->product_id;
        //     $mau = $ct->color_name;
        //     $size = $ct->size_name;
        //     $qty = $ct->quantity;
        // }
        // if( $id == $request->product_id && $mau == $request->color_name &&  $size == $request->size_name){
        //     $update_qty = $qty + $request->quantity;
        //     Product_details::where('product_id', $request->product_id)
        //     ->where('color_name',$request->color_name)
        //     ->where('size_name',$request->size_name)->update(['quantity'=>$update_qty]);
        // }
        $kiemtrabt = Product_details::all();

            foreach ($kiemtrabt as $kiemtra){
                if($kiemtra->product_id == $request->product_id){
                    if( $kiemtra->size_name == $request->size_name){
                        if($kiemtra->color_name == $request->color_name){
                            $update_qty = $kiemtra->quantity +$request->quantity;
                            Product_details::where('product_id', $request->product_id)
                            ->where('color_name',$request->color_name)
                            ->where('size_name',$request->size_name)->update(['quantity'=>$update_qty]);
                            Session::put('message','Cập nhật số lượng chi tiết sản phẩm thành công');
                            return Redirect::to('add-product-details');

                        }
                    }
                }
            }
        //
        Product_details::insert($data);
        Session::put('message','Thêm chi tiết sản phẩm thành công');
        return Redirect::to('add-product-details');
    }
    public function edit_product_details($product_details_id){
        $this->Authlogin();
        $name_product = Product::orderBy('product_id','desc')->get();
        $size_product = Size::orderBy('size_id','desc')->get();
        $color_product = Color::orderBy('color_id','desc')->get();
        $edit_category_product = Product_details::where('product_details_id',$product_details_id)->get();
        $manager_details_product = view('admin.edit_product_details')->with('edit_product_details',$edit_category_product)->with('name_product', $name_product)
        ->with('size_product', $size_product)
        ->with('color_product', $color_product);
        return view('admin_layout')
        ->with('admin.edit_product_details', $manager_details_product);
    }
    public function delete_product_details($product_details_id){
        $this->Authlogin();
        Product_details::where('product_details_id',$product_details_id)->delete();
        Session::put('message','Xóa chi tiết sản phẩm thành công');
        return Redirect::to('all-product-details');
    }
    public function update_product_details(Request $request, $product_details_id){
        $this->Authlogin();
        $data = array();
        $data['product_id']=$request->product_id;
        $data['color_name']=$request->color_name;
        $data['size_name']=$request->size_name;
        $data['quantity']=$request->quantity;

        Product_details::where('product_details_id',$product_details_id)->update($data);
        Session::put('message','Cập nhật chi tiết sản phẩm thành công');
        return Redirect::to('all-product-details');
    }
    // public function quantity_details($size, $color,$product_id,$qty){
    //     $quantity =  Product_details::where('product_id',$product_id)
    //     ->where('size_name',$size)
    //     ->where('color_name',$color)->get();
    //     $sl_cuoi = 0;
    //     foreach($quantity as $sl1){
    //         $sl_cuoi = $sl1->
    //     }

    // }
}
