<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Models\Color;
class ColorProduct extends Controller
{
    public function Authlogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function add_color_product(){
        $this->Authlogin();
        return view('admin.add_color_product');
    }
    public function all_color_product(){
        $this->Authlogin();
        $all_color_product = Color::orderBy('color_id','DESC')->get();
        $manager_color_product = view('admin.all_color_product')->with('all_color_product',$all_color_product);
        return view('admin_layout')->with('admin.all_color_product', $manager_color_product);
    }
    public function save_color_product(Request $request){
        $this->Authlogin();
        $data = array();
        $data['color_name']=$request->color_product_name;
        $data['color_status']=$request->color_product_status;
        Color::insert($data);
        Session::put('message','Thêm màu thành công.');
        return Redirect::to('add-color-product');
    }
    public function unactive_color_product($color_product_id){
        $this->Authlogin();
        Color::where('color_id',$color_product_id)->update(['color_status'=>1]);
        Session::put('message','Kích hoạt màu.');
        return Redirect::to('all-color-product');
    }
    public function active_color_product($color_product_id){
        $this->Authlogin();
        Color::where('color_id',$color_product_id)->update(['color_status'=>0]);
        Session::put('message','Không kích hoạt màu.');
        return Redirect::to('all-color-product');
    }
    public function edit_color_product($color_product_id){
        $this->Authlogin();
        $edit_color_product = Color::where('color_id',$color_product_id)->get();
        $manager_color_product = view('admin.edit_color_product')->with('edit_color_product',$edit_color_product);
        return view('admin_layout')->with('admin.edit_color_product', $manager_color_product);
    }
    public function delete_color_product($color_product_id){
        $this->Authlogin();
        Color::where('color_id',$color_product_id)->delete();
        Session::put('message','Xóa màu thành công');
        return Redirect::to('all-color-product');
    }
    public function update_color_product(Request $request, $color_product_id){
        $this->Authlogin();
        $data = array();
        $data['color_name']=$request->color_product_name;
        Color::where('color_id',$color_product_id)->update($data);
        Session::put('message','Cập nhật màu thành công');
        return Redirect::to('all-color-product');
    }
}
