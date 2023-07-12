<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Models\Category;
use App\Models\Coupon;

class CouponController extends Controller
{
    public function Authlogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
     //giam gia

    public function add_coupon(){
        $this->Authlogin();
        return view('admin.coupon.add_coupon');
    }
    public function save_coupon(Request $request){
        $this->Authlogin();
        $data = $request->all();
        $coupon = new Coupon();
        $coupon->coupon_name = $data['coupon_name'];
        $coupon->coupon_code = $data['coupon_code'];
        $coupon->coupon_qty = $data['coupon_qty'];
        $coupon->coupon_number = $data['coupon_number'];
        $coupon->coupon_condition = $data['coupon_condition'];
        $coupon->save();

        Session::put('message','Thêm mã giảm giá thành công');
        return Redirect::to('add-coupon');
    }
    public function all_coupon(){
        $this->Authlogin();
        $all_coupon = Coupon::orderBy('coupon_id','DESC')->get();
        $manager_counpon = view('admin.coupon.all_coupon')->with('all_coupon',$all_coupon);
        return view('admin_layout')->with('admin.coupon.all_coupon', $manager_counpon);
    }
    public function edit_coupon(){

    }
    public function delete_coupon($coupon_id){
        $this->Authlogin();
        Coupon::where('coupon_id',$coupon_id)->delete();
        Session::put('message','Xóa mã giảm giá thành công');
        return Redirect::to('all-coupon');
    }
}
