<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
session_start();
class AdminController extends Controller
{
    public function Authlogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function index(){
        return view('admin_login');
    }
    public function show_dashboard(){
        $this->Authlogin();
        $order = Order::all()->count();
        $product = Product::all()->count();
        $comment = Comment::all()->count();
        $customer = Customer::all()->count();
        $list_pro = Product::orderBy('product_view','DESC')->get();
        //dd($list_pro);
        return view('admin.dashboard',[
            'order'=>$order,
            'product'=>$product,
            'comment'=>$comment,
            'customer'=>$customer,
            'list_pro'=>$list_pro,
        ]);
    }
    public function dashboard(Request $request){
       $admin_email = $request->admin_email;
       $admin_password = md5($request->admin_password);

       $result = DB::table('tbl_admin')->where('admin_email',$admin_email)->where('admin_password',$admin_password)->first();
       if($result){
        Session::put('admin_name',$result->admin_name);
        Session::put('admin_id',$result->admin_id);
        return Redirect::to('/dashboard');
       }else{
        Session::put('message','Tài khoản hoặc mật khẩu sai, Vui lòng nhập lại!');
        return Redirect::to('/admin');
       }
    }
    public function logout(Request $request){
        $this->Authlogin();
        Session::put('admin_name',null);
        Session::put('admin_id',null);
        return Redirect::to('/admin');
    }
}
