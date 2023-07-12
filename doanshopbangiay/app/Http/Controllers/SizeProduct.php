<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Models\Size;
class SizeProduct extends Controller
{
    public function Authlogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function add_size_product(){
        $this->Authlogin();
        $size_product = Size::orderBy('size_id','desc')->get();

        return view('admin.add_size_product')
        ->with('size_product', $size_product);
    }
    public function all_size_product(){
        $this->Authlogin();
        $all_size_product = Size::get();

        $manager_size_product = view('admin.all_size_product')->with('all_size_product',$all_size_product);

        return view('admin_layout')->with('admin.all_size_product', $manager_size_product);
    }
    public function save_size_product(Request $request){
        $this->Authlogin();
        $data = array();
        $data['size_name']=$request->size_product_name;
        $data['size_status']=$request->size_product_status;
        Size::insert($data);
        Session::put('message','Thêm size thành công.');
        return Redirect::to('add-size-product');
    }
    public function unactive_size_product($size_product_id){
        $this->Authlogin();
        Size::where('size_id',$size_product_id)->update(['size_status'=>1]);
        Session::put('message','Kích hoạt size.');
        return Redirect::to('all-size-product');
    }
    public function active_size_product($size_product_id){
        $this->Authlogin();
        Size::where('size_id',$size_product_id)->update(['size_status'=>0]);
        Session::put('message','Không kích hoạt size.');
        return Redirect::to('all-size-product');
    }
    public function edit_size_product($size_product_id){
        $this->Authlogin();
        $edit_size_product = Size::where('size_id',$size_product_id)->get();
        $manager_size_product = view('admin.edit_size_product')->with('edit_size_product',$edit_size_product);
        return view('admin_layout')->with('admin.edit_size_product', $manager_size_product);
    }
    public function delete_size_product($size_product_id){
        $this->Authlogin();
        Size::where('size_id',$size_product_id)->delete();
        Session::put('message','Xóa size thành công');
        return Redirect::to('all-size-product');
    }
    public function update_size_product(Request $request, $size_product_id){
        $this->Authlogin();
        $data = array();
        $data['size_name']=$request->size_product_name;
        Size::where('size_id',$size_product_id)->update($data);
        Session::put('message','Cập nhật size thành công');
        return Redirect::to('all-size-product');
    }
}
