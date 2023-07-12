<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use App\Models\Comment;
class CustomerController extends Controller
{
    public function Authlogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function all_account(){
        $this->Authlogin();
        $all_customer = Customer::orderBy('customer_id','DESC')->get();
        $manager_customer = view('admin.all_account')->with('all_account',$all_customer);
        return view('admin_layout')->with('admin.all_account',  $manager_customer);
    }

}
