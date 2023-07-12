<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use App\Models\Size;
use App\Models\Color;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Coupon;
use App\Models\Product_details;

session_start();
class CartController extends Controller
{
    public function check_coupon(Request $request){
        $data = $request->all();
        $coupon = Coupon::where('coupon_code',$data['coupon'])->first();
        if($coupon){
            if($coupon->coupon_qty <= 0){
                return redirect()->back()->with('error', 'Mã giảm đã hết!!!');
            }
            $count_coupon = $coupon->count();
            if($count_coupon>0){
                $coupon_session = Session::get('coupon');
                //dd($coupon_session);
                if($coupon_session == true){
                    $is_avaiable = 0;
                    if($is_avaiable == 0){
                        $cou[] = array(
                        'coupon_code'>$coupon->coupon_code,
                        'coupon_condition'=> $coupon->coupon_condition,
                        'coupon_number' => $coupon->coupon_number,
                        );
                        Session::put('coupon',$cou);
                    }
                }
                else{
                    $cou[] = array(
                        'coupon_code'>$coupon->coupon_code,
                        'coupon_condition'=> $coupon->coupon_condition,
                        'coupon_number' => $coupon->coupon_number,
                    );
                    Session::put('coupon',$cou);
                }
                Session:: save();
                $slgiamgia = 0;
                    $slgg = Coupon::where('coupon_code',$data['coupon'])->select('coupon_qty')->get();
                    foreach($slgg as $sl){
                    $slgiamgia=$sl->coupon_qty-1;
                    }
                    Coupon::where('coupon_code',$data['coupon'])->update(['coupon_qty'=>$slgiamgia]);

                return redirect()->back()->with('message', 'Thêm mã giảm giá thành công');
            }
        }else{
            return redirect()->back()->with('error', 'Mã giảm giá không chính xác!!!');
        }
    }
    public function save_cart(Request $request){

        $productId = $request->productid_hidden;
        $quantity = $request->qty;
        $lay_mau = $request->hidden_color_name;
        $lay_size = $request->hidden_size_name;
        $product_infor = Product::where('product_id',$productId)->first();
        $color_infor = Color::where('color_id',$lay_mau)->first();
        $size_infor = Size::where('size_id',$lay_size)->first();
        //Cart::add('293ad', 'Product 1', 1, 9.99, 550);
        //Cart::destroy();
        //dd( $lay_mau ==NULL);
        $slctsp = Product_details::where('product_id', $productId)
        ->where('color_name',$lay_mau)
        ->where('size_name',$lay_size)
        ->select('quantity')
        ->get();
            foreach($slctsp as $sl){
                $slton = $sl->quantity;
            }

            if($lay_mau ==NULL ||  $lay_size==NULL || $slton==NULL ){
                return redirect()->back()->with('error', 'Vui lòng kiểm tra lại màu size !!!');
            }
            if($slton < $quantity){
                return redirect()->back()->with('error', 'Số lượng trong kho không đủ !!!');
            }

        $data['id'] = $product_infor->product_id;
        $data['qty'] = $quantity;
        $data['options']['colors'] =$color_infor->color_name;
        $data['options']['sizes'] = $size_infor->size_name;
        $data['name'] = $product_infor->product_name;
        $data['price'] = $product_infor->product_price;
        $data['weight'] = '170';
        $data['options']['image'] = $product_infor->product_image;

        Cart::add($data);
        //dd($data);
        //set thue 0%
        Cart::setGlobalTax(0);
        return Redirect::to('/show-cart')
        ->with('lay_mau',$lay_mau)
        ->with('lay_size',$lay_size);
    }
    public function show_cart(Request $request){
        $cate_product = Category::where('category_status','1')->orderBy('category_id','desc')->get();
        $brand_product = Brand::where('brand_status','1')->orderBy('brand_id','desc')->get();
        //dd(Session::get('coupon'));
        $show_mau = Session::get('lay_mau');
        $show_size = Session::get('lay_size');
        //dd($show_mau);

        $ten_mau = Color::where('color_id',  $show_mau)->get();
        $ten_size = Size::where('size_id', $show_size)->get();
        // dd($ten_mau);
        return view('pages.cart.show_cart')
        ->with('category',$cate_product)
        ->with('brand',$brand_product)
        ->with('color', $ten_mau)
        ->with('size', $ten_size);
    }
    public function delete_to_cart($rowId){
        Cart::update($rowId, 0);
        return Redirect::to('/show-cart');
    }
    public function update_cart_quantity(Request $request){
        $rowId = $request ->rowId_cart;
        $qty = $request->cart_quantity;
        Cart::update($rowId, $qty);
        return Redirect::to('/show-cart');
    }
    public function test(){
        Session::forget('coupon');
    }
}
