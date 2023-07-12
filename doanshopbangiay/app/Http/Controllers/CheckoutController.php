<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Category;
use App\Models\Color;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Order_details;
use App\Models\Size;
use App\Models\Payment;
use App\Models\Product_details;
use App\Models\Shipping;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use PDF;
use Illuminate\Support\Facades\App;
session_start();
class CheckoutController extends Controller
{
    public function Authlogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function login_checkout(){

        $cate_product = Category::where('category_status','1')->orderBy('category_id','desc')->get();
        $brand_product = Brand::where('brand_status','1')->orderBy('brand_id','desc')->get();

        return view('pages.checkout.login_checkout')->with('category',$cate_product)->with('brand',$brand_product);
    }
    // public function login_checkout_chuamua(){

    //     $cate_product = Category::where('category_status','1')->orderBy('category_id','desc')->get();
    //     $brand_product = Brand::where('brand_status','1')->orderBy('brand_id','desc')->get();

    //     return view('pages.checkout.login_checkout_chuamua')->with('category',$cate_product)->with('brand',$brand_product);
    // }
    public function add_customer(Request $request){
        $data = array();
        $data['customer_name'] = $request->customer_name;
        $data['customer_email'] = $request->customer_email;
        $data['customer_password'] = md5($request->customer_password);
        $data['customer_phone'] = $request->customer_phone;

        $customer_id = Customer::insertGetId($data);
        Session::put('customer_id', $customer_id);
        Session::put('customer_name', $request->customer_name);
        return Redirect::to('/checkout');
    }
    public function show_lichsu(){

        $id_user = Session::get('customer_id');
        $order_infor = Order::where('customer_id', $id_user)
        ->join('tbl_payment','tbl_order.payment_id','=','tbl_payment.payment_id')
        ->get();
        //dd($order_infor);

        $cate_product = Category::where('category_status','1')->orderBy('category_id','desc')->get();
        $brand_product = Brand::where('brand_status','1')->orderBy('brand_id','desc')->get();
        return view('pages.checkout.show_lichsu')
        ->with('category',$cate_product)
        ->with('brand',$brand_product)
        ->with('history',$order_infor);
        // ->with('namecus',$name_cus);
    }
    public function show_chitiet_lichsu($orderId){
        $cate_product = Category::where('category_status','1')->orderBy('category_id','desc')->get();
        $brand_product = Brand::where('brand_status','1')->orderBy('brand_id','desc')->get();
        $order_details_by_id = Order::join('tbl_customer','tbl_order.customer_id','=','tbl_customer.customer_id')
        ->join('tbl_shipping','tbl_order.shipping_id','=','tbl_shipping.shipping_id')
        ->join('order_details','tbl_order.order_id','=','order_details.order_id')
        ->select('tbl_order.*','tbl_customer.*','tbl_shipping.*','order_details.*')
        ->where('tbl_order.order_id', $orderId)->first();
        $order_details_sp = Order::join('tbl_customer','tbl_order.customer_id','=','tbl_customer.customer_id')
        ->join('tbl_shipping','tbl_order.shipping_id','=','tbl_shipping.shipping_id')
        ->join('order_details','tbl_order.order_id','=','order_details.order_id')
        ->select('tbl_order.*','tbl_customer.*','tbl_shipping.*','order_details.*')
        ->where('tbl_order.order_id', $orderId)->get();
        //dd($order_details_sp);
        return view('pages.checkout.show_chitiet_lichsu')
        ->with('category',$cate_product)
        ->with('brand',$brand_product)
        ->with('order_details_id',$order_details_by_id)
        ->with('order_details_sanpham',$order_details_sp);
    }
    public function checkout(Request $request){
        $cate_product = Category::where('category_status','1')->orderBy('category_id','desc')->get();
        $brand_product = Brand::where('brand_status','1')->orderBy('brand_id','desc')->get();
        $lay_giam = $request->gg;
        $lay_tien_tra =  $request->tt;
        return view('pages.checkout.show_checkout')
        ->with('category',$cate_product)
        ->with('brand',$brand_product)
        ->with('lay_giam',$lay_giam)
        ->with('lay_tien_tra',$lay_tien_tra);
    }

    public function save_checkout_customer(Request $request){
        $cate_product = Category::where('category_status','1')->orderBy('category_id','desc')->get();
        $brand_product = Brand::where('brand_status','1')->orderBy('brand_id','desc')->get();

        $show_mau = Session::get('lay_mau');
        $show_size = Session::get('lay_size');
        $ten_mau = Color::where('color_id',  $show_mau)->get();
        $ten_size = Size::where('size_id', $show_size)->get();
        $data = array();
        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_phone'] = $request->shipping_phone;
        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_notes'] = $request->shipping_notes;
        $data['shipping_address'] = $request->shipping_address;
        $lay_giam = $request->giam_gia;
        $lay_tien_tra =  $request->tien_phai_tra;

        $shipping_id = Shipping::insertGetId($data);
        Session::put('shipping_id', $shipping_id);
        //dd($t);

        return view('pages.checkout.payment')->with('lg', $lay_giam)->with('ltt',$lay_tien_tra)->with('category',$cate_product)
        ->with('brand',$brand_product)
        ->with('color', $ten_mau)
        ->with('size', $ten_size);
    }
    public function payment(Request $request){
        $cate_product = Category::where('category_status','1')->orderBy('category_id','desc')->get();
        $brand_product = Brand::where('brand_status','1')->orderBy('brand_id','desc')->get();

        $show_mau = Session::get('lay_mau');
        $show_size = Session::get('lay_size');
        $ten_mau = Color::where('color_id',  $show_mau)->get();
        $ten_size = Size::where('size_id', $show_size)->get();
        //dd( $ten_mau);
        return view('pages.checkout.payment')
        ->with('category',$cate_product)
        ->with('brand',$brand_product)
        ->with('color', $ten_mau)
        ->with('size', $ten_size);
    }
    public function logout_checkout(){
        Session::flush();
        return Redirect::to('/login-checkout');
    }
    public function login_customer(Request $request){
        $email = $request->email_account;
        $password = md5($request->password_account);
        $result = Customer::where('customer_email',$email)->where('customer_password',$password)->first();
        if($result){
            Session::put('customer_id',$result->customer_id);
            return Redirect::to('/');
        }else{
            return Redirect::to('/login-checkout')->with('error', 'Vui lòng kiểm tra lại tài khoản, mật khẩu');
        }
    }
    public function order_place(Request $request){
        //Lay hinh thuc thanh toan
        $data = array();
        $data['payment_method'] = $request->payment_option;
        $data['payment_status'] = 'Đang chờ xử lý';
        $payment_id = Payment::insertGetId($data);
        //oder
        $order_data = array();
        $order_data['customer_id'] = Session::get('customer_id');
        $order_data['shipping_id'] = Session::get('shipping_id');
        $order_data['payment_id'] = $payment_id;
        $order_data['order_total'] = Cart::total();
        $order_data['order_status'] = 'Đang chờ xử lý';
        $order_data['order_date_time'] = Carbon::now('Asia/Ho_Chi_Minh');
        $order_id = Order::insertGetId($order_data);
        //order details

        $content = Cart::content();
        foreach($content as $v_content){
        // $order_details_data = array();
        $order_details_data['order_id'] = $order_id;
        $order_details_data['product_id'] = $v_content->id;
        $order_details_data['product_name'] = $v_content->name;
        $order_details_data['product_size'] = $v_content->options->sizes;
        $order_details_data['product_color'] = $v_content->options->colors;
        $order_details_data['product_price'] = $v_content->price;
        $order_details_data['product_sales_quantity'] = $v_content->qty;
        Order_details::insert($order_details_data);
        $product_id = $v_content->id;
        $size = $v_content->options->sizes;
        $color = $v_content->options->colors;
        $qty = $v_content->qty;
        //dd($size);
        $this->update_qty($product_id,$size,$color,$qty);
        }
        // if($data['payment_method']==1){
        //     // echo'Ban dang chon thanh toan ATM';
        // $cate_product = Category::where('category_status','1')->orderBy('category_id','desc')->get();
        // $brand_product = Brand::where('brand_status','1')->orderBy('brand_id','desc')->get();
        //     return view('pages.checkout.vnpay')->with('category',$cate_product)->with('brand',$brand_product);
        // }elseif($data['payment_method']==2){
        // Cart::destroy();
        // $cate_product = Category::where('category_status','1')->orderBy('category_id','desc')->get();
        // $brand_product = Brand::where('brand_status','1')->orderBy('brand_id','desc')->get();
        // return view('pages.checkout.tien_mat')->with('category',$cate_product)->with('brand',$brand_product);
        // }

    }
    public function update_qty($product_id, $size, $color, $qty){
        $lay_tenmau = Product_details::join('tbl_color_product','tbl_product_details.color_name','=','tbl_color_product.color_id')
        ->join('tbl_size_product','tbl_product_details.size_name','=','tbl_size_product.size_id')
        ->where('tbl_color_product.color_name',$color)
        ->where('tbl_size_product.size_name',$size)
        ->get();
        //dd($lay_tenmau);
        foreach( $lay_tenmau as $lay_tt){
            $lay_sl = Product_details::where('product_id',$product_id)
            ->where('size_name',$lay_tt->size_id)
            ->where('color_name','like' ,$lay_tt->color_id)->get();

        }
        $qty_cuoi = 0;
        foreach($lay_sl as $sl){
            $qty_cuoi = $sl->quantity -= $qty;
        }
        //dd($qty_cuoi);
        foreach( $lay_tenmau as $lay_tt){
            $lay_sl = Product_details::where('product_id',$product_id)
            ->where('size_name',$lay_tt->size_id)
            ->where('color_name','like' ,$lay_tt->color_id)
            ->update(['quantity'=>$qty_cuoi]);
        }
    }
    //
    public function manage_order(){
        $this->Authlogin();
        $all_order = Order::join('tbl_customer','tbl_order.customer_id','=','tbl_customer.customer_id')
        ->join('tbl_payment','tbl_order.payment_id','=','tbl_payment.payment_id')->orderBy('order_id','desc')->paginate(10);
        $manager_order = view('admin.manage_order')->with('all_order',$all_order);
        return view('admin_layout')->with('admin.manage_order',$manager_order);
    }
    public function update_order_xuly($orderId){
        $this->Authlogin();
        Order::where('order_id',$orderId)->update(['order_status'=>'Đang chờ xử lý']);
        Session::put('message','Cập nhật trạng thái đơn hàng thành công.');
        return Redirect::to('manage-order');
    }
    public function update_order_dagoi($orderId){
        $this->Authlogin();
        Order::where('order_id',$orderId)->update(['order_status'=>'Đã gói hàng']);
        Session::put('message','Cập nhật trạng thái đơn hàng thành công.');
        return Redirect::to('manage-order');
    }
    public function update_order_danggiao($orderId){
        $this->Authlogin();
        Order::where('order_id',$orderId)->update(['order_status'=>'Đang giao']);
        Session::put('message','Cập nhật trạng thái đơn hàng thành công.');
        return Redirect::to('manage-order');
    }
    public function update_order_hoanthanh($orderId){
        $this->Authlogin();
        Order::where('order_id',$orderId)->update(['order_status'=>'Đã hoàn thành']);
        Session::put('message','Cập nhật trạng thái đơn hàng thành công.');
        return Redirect::to('manage-order');
    }
    public function update_order_huy($orderId){
        $this->Authlogin();
        Order::where('order_id',$orderId)->update(['order_status'=>'Đã hủy']);
        Session::put('message','Cập nhật trạng thái đơn hàng thành công.');
        return Redirect::to('show-lichsu');
    }
    public function loc_order_xuly(){
        $this->Authlogin();
        $all_order = Order::where('order_status','Đang chờ xử lý')
        ->join('tbl_customer','tbl_order.customer_id','=','tbl_customer.customer_id')
        ->join('tbl_payment','tbl_order.payment_id','=','tbl_payment.payment_id')->paginate(10);
        $manager_order = view('admin.manage_order')->with('all_order',$all_order);
        return view('admin_layout')->with('admin.manage_order',$manager_order);
    }
    public function loc_order_dagoi(){
        $this->Authlogin();
        $all_order = Order::where('order_status','Đã gói hàng')
        ->join('tbl_customer','tbl_order.customer_id','=','tbl_customer.customer_id')
        ->join('tbl_payment','tbl_order.payment_id','=','tbl_payment.payment_id')->paginate(10);
        $manager_order = view('admin.manage_order')->with('all_order',$all_order);
        return view('admin_layout')->with('admin.manage_order',$manager_order);
    }
    public function loc_order_danggiao(){
        $this->Authlogin();
        $all_order = Order::where('order_status','Đang giao')
        ->join('tbl_customer','tbl_order.customer_id','=','tbl_customer.customer_id')
        ->join('tbl_payment','tbl_order.payment_id','=','tbl_payment.payment_id')->paginate(10);
        $manager_order = view('admin.manage_order')->with('all_order',$all_order);
        return view('admin_layout')->with('admin.manage_order',$manager_order);
    }
    public function loc_order_hoanthanh(){
        $this->Authlogin();
        $all_order = Order::where('order_status','Đã hoàn thành')
        ->join('tbl_customer','tbl_order.customer_id','=','tbl_customer.customer_id')
        ->join('tbl_payment','tbl_order.payment_id','=','tbl_payment.payment_id')->paginate(10);
        $manager_order = view('admin.manage_order')->with('all_order',$all_order);
        return view('admin_layout')->with('admin.manage_order',$manager_order);
    }
    public function loc_order_huy(){
        $this->Authlogin();
        $all_order = Order::where('order_status','Đã hủy')
        ->join('tbl_customer','tbl_order.customer_id','=','tbl_customer.customer_id')
        ->join('tbl_payment','tbl_order.payment_id','=','tbl_payment.payment_id')->paginate(10);
        $manager_order = view('admin.manage_order')->with('all_order',$all_order);
        return view('admin_layout')->with('admin.manage_order',$manager_order);
    }
    public function view_order($orderId){
        $this->Authlogin();
        //Lay thong tin khach hang first
        $order_infor = Order::join('tbl_customer','tbl_order.customer_id','=','tbl_customer.customer_id')
        ->join('tbl_shipping','tbl_order.shipping_id','=','tbl_shipping.shipping_id')
        ->join('order_details','tbl_order.order_id','=','order_details.order_id')
        ->select('tbl_order.*','tbl_customer.*','tbl_shipping.*','order_details.*')
        ->where('tbl_order.order_id', $orderId)->first();
        //Lay chi tiet don hang get
        $order_by_id = Order::join('tbl_customer','tbl_order.customer_id','=','tbl_customer.customer_id')
        ->join('tbl_shipping','tbl_order.shipping_id','=','tbl_shipping.shipping_id')
        ->join('order_details','tbl_order.order_id','=','order_details.order_id')
        ->select('tbl_order.*','tbl_customer.*','tbl_shipping.*','order_details.*')
        ->where('tbl_order.order_id', $orderId)->get();
        //dd($order_by_id);
        $manager_order_by_id = view('admin.view_order')->with('order_by_id',$order_by_id)->with('order_infor',$order_infor);
        return view('admin_layout')->with('admin.view_order',$manager_order_by_id );

    }
    public function tienmat_payment(Request $request){
        $data = array();
        $data['payment_method'] = $request->tienmat;
        $data['payment_status'] = 'Thanh toán tiền mặt';
        $payment_id = Payment::insertGetId($data);
        //add oder
        $order_data = array();
        $order_data['customer_id'] = Session::get('customer_id');
        $order_data['shipping_id'] = Session::get('shipping_id');
        $order_data['payment_id'] = $payment_id;
        $order_data['order_total'] = Cart::total(0,',','');
        $order_data['order_status'] = 'Đang chờ xử lý';
        $order_data['giam_gia'] = $request->giam_gia;
        $order_data['so_tien_phai_tra'] = $request->tien_phai_tra;
        $order_data['order_date_time'] = Carbon::now('Asia/Ho_Chi_Minh');
        $order_id = Order::insertGetId($order_data);
        //dd($order_data);
        //add order details
        $content = Cart::content();
        foreach($content as $v_content){
        // $order_details_data = array();
        $order_details_data['order_id'] = $order_id;
        $order_details_data['product_id'] = $v_content->id;
        $order_details_data['product_name'] = $v_content->name;

        $order_details_data['product_size'] = $v_content->options->sizes;
        $order_details_data['product_color'] = $v_content->options->colors;

        $order_details_data['product_price'] = $v_content->price;
        $order_details_data['product_sales_quantity'] = $v_content->qty;
        Order_details::insert($order_details_data);
        $product_id = $v_content->id;
        $size = $v_content->options->sizes;
        $color = $v_content->options->colors;
        $qty = $v_content->qty;
        $this->update_qty($product_id,$size,$color,$qty);
        //

        }

        $name = Customer::where('customer_id',$order_data['customer_id'])->get();
        foreach( $name as $na){
            $name_cus = $na->customer_name;
            $email_cus = $na->customer_email;
        }
        $email= $email_cus;
        $name = $name_cus;
        $or_id = $order_id;
        $or_tong = Cart::total(0,',','');
        $or_giam = $request->giam_gia;
        $or_phai_tra = $request->tien_phai_tra;
        $or_pay ='Thanh toán tiền mặt';
        $or_date = Carbon::now('Asia/Ho_Chi_Minh');
            Mail::send('pages.checkout.send_mail',[
                'name'=> $name_cus,
                'order'=> $or_id,
                'order_date'=> $or_date,
                'order_tong'=> $or_tong,
                'order_giam'=> $or_giam,
                'order_tra'=> $or_phai_tra,
                'order_pay'=> $or_pay,
                'items'=> $content,
            ], function ($mail) use($email,$name) {
                $mail->from('sneakershop@gmail.com', 'Sneaker-Shop');
                $mail->to($email,$name);
                $mail->subject('Email odered');
            });

        Cart::destroy();
        Session::forget('coupon');
        $cate_product = Category::where('category_status','1')->orderBy('category_id','desc')->get();
        $brand_product = Brand::where('brand_status','1')->orderBy('brand_id','desc')->get();
        return view('pages.checkout.tien_mat')->with('category',$cate_product)->with('brand',$brand_product);
    }
    public function vnpay(){
        Session::forget('coupon');
        Cart::destroy();
        $cate_product = Category::where('category_status','1')->orderBy('category_id','desc')->get();
        $brand_product = Brand::where('brand_status','1')->orderBy('brand_id','desc')->get();
        return view('pages.checkout.vnpay')->with('category',$cate_product)->with('brand',$brand_product);
    }
    public function vnpay_payment(Request $request){
        $data = array();
        $data['payment_method'] = $request->vnpay;
        $data['payment_status'] = 'Đã thanh toán VNPAY';
        $payment_id = Payment::insertGetId($data);
        //oder
        $order_data = array();
        $order_data['customer_id'] = Session::get('customer_id');
        $order_data['shipping_id'] = Session::get('shipping_id');
        $order_data['payment_id'] = $payment_id;
        $order_data['order_total'] = Cart::total(0,',','');
        $order_data['order_status'] = 'Đang chờ xử lý';
        $order_data['giam_gia'] = $request->giam_gia;
        $order_data['so_tien_phai_tra'] = $request->tien_phai_tra;
        $order_data['order_date_time'] = Carbon::now('Asia/Ho_Chi_Minh');
        $order_id = Order::insertGetId($order_data);

        //order details;
        $total_end = $order_data['so_tien_phai_tra'];
         $total = Cart::total(0,',','');
        //dd($total);
        $content = Cart::content();
        foreach($content as $v_content){
        // $order_details_data = array();
        $order_details_data['order_id'] = $order_id;
        $order_details_data['product_id'] = $v_content->id;
        $order_details_data['product_name'] = $v_content->name;

        $order_details_data['product_size'] = $v_content->options->sizes;
        $order_details_data['product_color'] = $v_content->options->colors;
        $order_details_data['product_price'] = $v_content->price;
        $order_details_data['product_sales_quantity'] = $v_content->qty;
        Order_details::insert($order_details_data);
        $product_id = $v_content->id;
        $size = $v_content->options->sizes;
        $color = $v_content->options->colors;
        $qty = $v_content->qty;
        $this->update_qty($product_id,$size,$color,$qty);
        //$this->update_qty($v_content->id,$v_content->options->sizes,$v_content->options->colors,$v_content->qty);
        }
        $name = Customer::where('customer_id',$order_data['customer_id'])->get();
        foreach( $name as $na){
            $name_cus = $na->customer_name;
            $email_cus = $na->customer_email;
        }
        $email= $email_cus;
        $name = $name_cus;
        $or_id = $order_id;
        $or_tong = Cart::total(0,',','');
        $or_giam = $request->giam_gia;
        $or_phai_tra = $request->tien_phai_tra;
        $or_pay ='Đã thanh toán VNPAY';
        $or_date = Carbon::now('Asia/Ho_Chi_Minh');
            Mail::send('pages.checkout.send_mail',[
                'name'=> $name_cus,
                'order'=> $or_id,
                'order_date'=> $or_date,
                'order_tong'=> $or_tong,
                'order_giam'=> $or_giam,
                'order_tra'=> $or_phai_tra,
                'order_pay'=> $or_pay,
                'items'=> $content,
            ], function ($mail) use($email,$name) {
                $mail->from('sneakershop@gmail.com', 'Sneaker-Shop');
                $mail->to($email,$name);
                $mail->subject('Email odered');
            });

        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://127.0.0.1:8000/vnpay";
        $vnp_TmnCode = "S4ZHTQ0E";//Mã website tại VNPAY
        $vnp_HashSecret = "SGVDPBZSVQDQTOHXEAFKTRVPWMKGPBAC"; //Chuỗi bí mật

        // $vnp_TxnRef = $_POST['order_id']; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_TxnRef = 'HD'.time(); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY

        $vnp_OrderInfo = 'Thanh toan vnpay test';
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $total_end * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array('code' => '00'
            , 'message' => 'success'
            , 'data' => $vnp_Url);
            if (isset($_POST['redirect'])) {
                header('Location: ' . $vnp_Url);
                die();
            } else {
                echo json_encode($returnData);
            }
    }
    public function find_mau(Request $request){

        $data= DB::table('tbl_product_details')->where('product_id', $request->idpro)
        ->where('size_name', $request->id)
        ->join('tbl_color_product', 'tbl_color_product.color_id', '=', 'tbl_product_details.color_name')
        ->select('tbl_color_product.color_id', 'tbl_color_product.color_name')
        ->get();
        return response()->json($data);
	}
    //Loc doanh thu
    public function lay_ngay_loc(Request $request){
        $data = $request->all();
        $from_date = $data['from_date'];
        $to_date = $data['to_date'];
        $get = Order::whereBetween('order_date_time', [$from_date, $to_date])->selectRaw('sum(so_tien_phai_tra) as tt, DATE(order_date_time) as day')
        ->groupByRaw('DATE(order_date_time)')
        ->orderBy('order_date_time', 'ASC')
        ->get();

        foreach($get as $key => $val){
            $chart_data[] = array(
                'order_date_time' => $val->day,
                'order_total' => $val->tt,
            );
        }
        echo $data = json_encode($chart_data);
    }
    public function luot_ban(Request $request){
        //$data = $request->all();
        $lay_id_hd = Order_details::
        select('product_id')
        ->selectRaw('sum(product_sales_quantity) as so_luong_ban')
        ->groupBy('product_id')->get();

        foreach($lay_id_hd as $key => $val){
            $lay_ten = Product::where('product_id',$val->product_id)->select('product_name')->get();
            foreach($lay_ten as $key => $lay){
                $chart_data[] = array(
                    'product_name' => $lay->product_name,
                    'so_luong_ban' => $val->so_luong_ban,
                );
            }

        }
        //dd($chart_data);
        echo $data = json_encode($chart_data);
    }
    public function dashboard_filter(Request $request){
        $data = $request->all();
        $dauthangnay = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $dau_thangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $cuoi_thangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();

        $sub7days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(7)->toDateString();
        $sub365days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(365)->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
            if($data['dashboard_value'] =='7ngay'){
            $get = Order::whereBetween('order_date_time', [$sub7days, $now])
            ->selectRaw('sum(so_tien_phai_tra) as tt, DATE(order_date_time) as day')
            ->groupByRaw('DATE(order_date_time)')
            ->orderBy('order_date_time', 'ASC')
            ->get();
            }elseif ($data['dashboard_value'] =='thangtruoc'){
            $get = Order::whereBetween('order_date_time', [$dau_thangtruoc, $cuoi_thangtruoc])
            ->selectRaw('sum(so_tien_phai_tra) as tt, DATE(order_date_time) as day')
            ->groupByRaw('DATE(order_date_time)')
            ->orderBy('order_date_time', 'ASC')
            ->get();
            }elseif($data['dashboard_value'] == 'thangnay'){
            $get = Order::whereBetween('order_date_time', [$dauthangnay, $now])->selectRaw('sum(so_tien_phai_tra) as tt, DATE(order_date_time) as day')
            ->groupByRaw('DATE(order_date_time)')
            ->orderBy('order_date_time', 'ASC')
            ->get();
            }else{
            $get = Order::whereBetween('order_date_time', [$sub365days, $now])->selectRaw('sum(so_tien_phai_tra) as tt, DATE(order_date_time) as day')
            ->groupByRaw('DATE(order_date_time)')
            ->orderBy('order_date_time', 'ASC')
            ->get();
            }
            foreach($get as $key => $val){
                $chart_data[] = array(
                    'order_date_time' => $val->day,
                    'order_total' => $val->tt,
                );
            }
            echo $data = json_encode($chart_data);
        }
        public function days_order(){
                $sub30days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(30)->toDateString();
                $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

                $get=Order::whereBetween('order_date_time', [$sub30days, $now])->selectRaw('sum(so_tien_phai_tra) as tt, DATE(order_date_time) as day')
                ->groupByRaw('DATE(order_date_time)')
                ->orderBy('order_date_time', 'ASC')
                ->get();
                foreach($get as $key=> $val){
                    $chart_data[] = array(
                    'order_date_time'=> $val->day,
                    'order_total'=>$val->tt
                    );
                }
                echo $data=json_encode($chart_data);
        }
        public function in_hoadon(Request $request){
            $id_in = $request->hd;
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadHTML($this->print_order_convert($id_in));
            return $pdf->stream();
        }
        public function print_order_convert($id_in){
        $order_infor = Order::join('tbl_customer','tbl_order.customer_id','=','tbl_customer.customer_id')
        ->join('tbl_shipping','tbl_order.shipping_id','=','tbl_shipping.shipping_id')
        ->join('order_details','tbl_order.order_id','=','order_details.order_id')
        ->join('tbl_payment','tbl_order.payment_id','=','tbl_payment.payment_id')
        ->select('tbl_order.*','tbl_customer.*','tbl_shipping.*','order_details.*','tbl_payment.*')
        ->where('tbl_order.order_id', $id_in)->first();
        $order_by_id = Order::join('tbl_customer','tbl_order.customer_id','=','tbl_customer.customer_id')
        ->join('tbl_shipping','tbl_order.shipping_id','=','tbl_shipping.shipping_id')
        ->join('order_details','tbl_order.order_id','=','order_details.order_id')
        ->select('tbl_order.*','tbl_customer.*','tbl_shipping.*','order_details.*')
        ->where('tbl_order.order_id', $id_in)->get();
        $in_hoadon = '';
        $in_hoadon .=
        '<style>
        body{
            font-family: DeJavu Sans
        }
        </style>
        <p style="font-size:25px">SNAKER-Shop _ Mã đơn hàng: #'.$order_infor->order_id.'</p>

        <table style="border: 1px solid #000000;width: 700px;margin-bottom:10px;height:40px">
        <thead>

          <tr>
            <p>Thông tin tài khoản</p>
            <td>Tên người đặt: '.$order_infor->customer_name.'</td>
            <td>Số điện thoại: '.$order_infor->customer_phone.'</td>
          </tr>
        </thead>
      </table>
      <table class="table table-striped b-t b-light" style="border: 1px solid #000000;width: 700px;margin-bottom:10px;">
        <div style="margin-left: 50px;">
            <p style="font-size:17px;margin-left: 200px;">Thông tin giao hàng</p>

            <p>Tên người nhận hàng: '.$order_infor->shipping_name.'</p>
            <p>Số điện thoại: '.$order_infor->shipping_phone.'</p>
            <p>Email: '.$order_infor->shipping_email.'</p>
            <p>Địa chỉ: '.$order_infor->shipping_address.'</p>
            <p>Ghi chú: '.$order_infor->shipping_notes.'</p>
        </div>
    </table>
    <table class="table table-striped b-t b-light" style="border: 1px solid #000000; width: 700px;margin-bottom:10px;">
          <thead>
            <tr>
              <th>Tên sản phẩm</th>
              <th>Size </th>
              <th>Màu </th>
              <th>Giá </th>
              <th>Số lượng</th>
              <th>Tổng tiền</th>
            </tr>
          </thead>
          <tbody>';
            foreach($order_by_id as $order){
                $in_hoadon .='
            <tr>
                <td>'.$order->product_name.'</td>
                <td>'.$order->product_size.'</td>
                <td>'.$order->product_color.'</td>
                <td>'.number_format($order->product_price).' '.' VND'.'</td>
                <td>'.$order->product_sales_quantity.'</td>
                <td>'.number_format($order->product_price * $order->product_sales_quantity).' '.' VND'.'</td>
            <td>';
            }
            $in_hoadon .='
          </tbody>
        </table>
        </div style="padding-left: 20px">
            <li>Tổng tiền: '.number_format($order_infor->order_total).' '.' VND'.'</li>
            <li>Giảm giá: '.number_format($order_infor->giam_gia).' '.' VND'.'</li>
            <li>Số tiền phải thanh toán: '.number_format($order_infor->so_tien_phai_tra).' '.' VND '.'('.$order_infor->payment_status.')'.'</li>
        </div>
        <table class="table">
        <thead>
            <tr>
                <td style="width:200px; padding-top:50px"></td>
                <td style="width:800px; text-align:center; padding-top:50px">........,Ngày......Tháng......Năm.......</td>
            </tr>

            <tr>
                <td style="width:200px; padding-top:10px">Người nhận</td>
                <td style="width:800px; text-align:center; padding-top:10px">Người lập hóa đơn</td>
            </tr>
            <tr>
            <td style="width:200px; padding-top:10px"></td>
            <td style="width:800px; text-align:center; padding-top:10px; font-size:12px">(ký và ghi rõ họ tên)</td>
            </tr>
        </table>

    ';
        return $in_hoadon;
        }
        public function update_account(){
        $customer_id = Session::get('customer_id');
        $cate_product = Category::where('category_status','1')->orderBy('category_id','desc')->get();
        $brand_product = Brand::where('brand_status','1')->orderBy('brand_id','desc')->get();
        $user = Customer::where('customer_id',$customer_id)->get();
        return view('pages.checkout.update-account')->with('category',$cate_product)->with('brand',$brand_product)->with('user',$user);
        }
        public function update_account_save(Request $request){
            $customer_id = Session::get('customer_id');

            $name = $request->customer_name;

            $phone = $request->customer_phone;
            Customer::where('customer_id',$customer_id)->update(['customer_name'=>$name,'customer_phone'=>$phone]);
            return redirect('/update-account');
        }
        public function update_password(){
            $customer_id = Session::get('customer_id');
            $cate_product = Category::where('category_status','1')->orderBy('category_id','desc')->get();
            $brand_product = Brand::where('brand_status','1')->orderBy('brand_id','desc')->get();
            $user = Customer::where('customer_id',$customer_id)->get();
            return view('pages.checkout.update-password')->with('category',$cate_product)->with('brand',$brand_product)->with('user',$user);
            }
        public function update_password_save(Request $request){
            $customer_id = Session::get('customer_id');
            $lay_pass_cu =  Customer::where('customer_id',$customer_id)->select('tbl_customer.customer_password')->first();

            $pass_cu = $request->customer_password_cu;
            $pass_md5 = md5($pass_cu);
            //dd($pass_md5);
            $pass = $request->customer_password;
            $repass = $request->customer_repassword;
            $newpass = md5($pass);
            //dd($lay_pass_cu == '{"customer_password":"'.$pass_md5.'"}');
            if($lay_pass_cu == '{"customer_password":"'.$pass_md5.'"}'){
                //dd($lay_pass_cu);
                if($pass == $repass){
                    Customer::where('customer_id',$customer_id)->update(['customer_password'=>$newpass]);
                    Session::put('message','Cập nhật mật khẩu thành công.');
                }else{
                    Session::put('message','Mật khẩu không trùng khớp.');
                }
            }else{
                Session::put('message','Mật khẩu cũ sai!!!.');
            }

            return redirect('/update-password');
        }
        public function tonkho(Request $request)
            {
                $get=Product::join('tbl_product_details', 'tbl_product_details.product_id', '=', 'tbl_product.product_id')
                ->join('tbl_color_product', 'tbl_product_details.color_name', '=', 'tbl_color_product.color_id')
                ->join('tbl_size_product', 'tbl_product_details.size_name', '=', 'tbl_size_product.size_id')
                ->select('tbl_product.product_name','tbl_product_details.quantity','tbl_color_product.color_id','tbl_size_product.size_id')->get();
                foreach($get as $key=> $val){
                    $chart_data[] = array(
                    'product_name'=> $val->product_name,
                    'quantity'=>$val->quantity,
                    'product_color'=>$val->color_id,
                    'product_size'=>$val->size_id
                    );
                    }
                    echo $data=json_encode($chart_data);
            }
            public function trangthai(Request $request)
            {
                $get=Order::select('order_status')
                ->selectRaw('count(order_id) as sl')
                ->groupBy('order_status')
                ->get();

                    // $namett=DSTrangThai::where('id',$val->ds_trang_thai_id)->select('tenTT')->get();
                    foreach( $get as $key=>$tt){
                    $chart_data[] = array(
                    'order_status'=>$tt->order_status,
                    'sl'=>$tt->sl
                    );
                    }

                echo $data=json_encode($chart_data);
            }

}
