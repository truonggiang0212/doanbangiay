<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function index(){
        $cate_product = Category::where('category_status','1')->orderBy('category_id','desc')->get();
        $brand_product =Brand::where('brand_status','1')->orderBy('brand_id','desc')->get();
        $ma_coupon = Coupon::where('coupon_qty','>','1')->orderBy('coupon_id','desc')->get();
        //dd($ma_coupon);
        // $all_product = Product::where('product_status','1')->orderBy('product_id','desc')->limit(9)->get();
        if(isset($_GET['sort_by'])){
            $sort_by = $_GET['sort_by'];
            if($sort_by =='giam_dan'){
                $all_product = Product::where('product_status','1')->orderBy('product_price', 'DESC')->paginate(9)->appends (request()->query());
            }elseif($sort_by =='tang_dan'){
                $all_product = Product::where('product_status','1')->orderBy('product_price', 'ASC')->paginate(9)->appends (request()->query());
            }elseif($sort_by =='a_z'){
                $all_product = Product::where('product_status','1')->orderBy('product_name', 'ASC')->paginate(9)->appends (request()->query());
            }elseif($sort_by =='z_a'){
                $all_product = Product::where('product_status','1')->orderBy('product_name', 'DESC')->paginate(9)->appends (request()->query());
            }
        }else{
            $all_product = Product::where('product_status','1')->orderBy('product_id','desc')->limit(9)->get();
        }
        return view('pages.home')->with('category',$cate_product)->with('brand',$brand_product)->with('all_product',$all_product)->with('coupon',$ma_coupon);
    }
    public function search(Request $request){
        $keywords = $request->keywords_submit;
        $cate_product = Category::where('category_status','1')->orderBy('category_id','desc')->get();
        $brand_product = Brand::where('brand_status','1')->orderBy('brand_id','desc')->get();

        $search_product = Product::where('product_name','like','%'.$keywords.'%')->get();

        return view('pages.sanpham.search')
        ->with('category',$cate_product)
        ->with('brand',$brand_product)
        ->with('search_product',$search_product);
    }
    public function search_user(Request $request){
        $keywords = $request->keywords_submit;
        $search_product = Customer::where('customer_name','like','%'.$keywords.'%')->get();
        $manager_or = view('admin.all_account')->with('all_account',$search_product);
        return view('admin_layout')->with('admin.all_account',$manager_or);
    }
    public function search_order(Request $request){
        $keywords = $request->keywords_submit;
        $search_product = Order::where('order_id','like','%'.$keywords.'%')
        ->join('tbl_customer','tbl_order.customer_id','=','tbl_customer.customer_id')
        ->join('tbl_payment','tbl_order.payment_id','=','tbl_payment.payment_id')->paginate(10);
        // $search_or = Order::where('customer_name','like','%'.$keywords.'%')
        // ->join('tbl_customer','tbl_order.customer_id','=','tbl_customer.customer_id')
        // ->join('tbl_payment','tbl_order.payment_id','=','tbl_payment.payment_id')->get();
        // dd($search_or);

        $manager_acc = view('admin.manage_order')->with('all_order',$search_product);
        return view('admin_layout')->with('admin.manage_order',$manager_acc);
    }
    public function quen_mat_khau(){
        $cate_product = Category::where('category_status','1')->orderBy('category_id','desc')->get();
        $brand_product =Brand::where('brand_status','1')->orderBy('brand_id','desc')->get();

        return view('pages.checkout.forget_password')->with('category',$cate_product)->with('brand',$brand_product);
    }
    public function recover_password(Request $request){
        $data = $request->all();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y');
        $title_mail = "Lấy lại mặt khẩu.".' '.$now;
        $customer = Customer::where('customer_email','=',$data['email_account'])->get();
        foreach($customer as $key => $value){
            $customer_id = $value->customer_id;
        }

        if($customer){
            $count_customer = $customer->count();
            if($count_customer == 0){
                return redirect()->back()->with('error','Email này chưa được đăng ký.');
            }else{
                $token_random = Str::random();
                Customer::where('customer_id',$customer_id)->update(['customer_token'=>$token_random]);
                // $customer->customer_token = $token_random;
                // //dd($customer->customer_token);
                // $customer->save();

                $to_email = $data['email_account']; //send to this email

                $link_reset_pass = url('/update-new-pass?email='.$to_email.'&token='.$token_random);
                $data = array("name"=>$title_mail, "body"=>$link_reset_pass, 'email'=>$data['email_account']); //body of mail.blade.php
                Mail::send('pages.checkout.forget_pass_notify', ['data'=>$data],
                function($message) use ($title_mail,$data){
                    $message->to($data['email'])->subject($title_mail);//send this mail with subject
                    $message->from($data['email'],$title_mail);//send from this mail
                });
                return redirect()->back()->with('message', 'Gửi mail thành công,vui lòng vào email để reset password');
            }
        }
    }
    public function update_new_pass(){
        $cate_product = Category::where('category_status','1')->orderBy('category_id','desc')->get();
        $brand_product =Brand::where('brand_status','1')->orderBy('brand_id','desc')->get();
        return view('pages.checkout.new_password')->with('category',$cate_product)->with('brand',$brand_product);
    }
    public function reset_new_pass(Request $request){
        $data = $request->all();
        // dd($data['repassword_account']);
        $token_random = Str::random();
        $customer = Customer::where('customer_email','=', $data['email'])->where('customer_token', '=', $data['token'])->get();
        $count = $customer->count();
        if($count>0){
            foreach($customer as $key => $cus){
                $customer_id = $cus->customer_id;
            }
            if($data['password_account'] == $data['repassword_account']){
            Customer::where('customer_id',$customer_id)->update(['customer_password'=>md5($data['password_account'])]);
            Customer::where('customer_id',$customer_id)->update(['customer_token'=>$token_random]);
            return redirect('login-checkout')->with('message', 'Mật khẩu đã cập nhật mới.');
            }else{
                return redirect('quen-mat-khau')->with('error', 'Vui lòng kiểm tra lại.');
            }

        }else{
            return redirect('quen-mat-khau')->with('error', 'Vui lòng nhập lại email vì link đã quá hạn.');
        }
    }

}
