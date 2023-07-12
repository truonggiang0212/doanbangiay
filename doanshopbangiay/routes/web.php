<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryProduct;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandProduct;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ColorProduct;
use App\Http\Controllers\SizeProduct;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Cart;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductDetailsController;
use App\Http\Controllers\Comment;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//frontend
Route::get('/',[HomeController::class, 'index']);

Route::get('/trang-chu',[HomeController::class, 'index']);
Route::post('/tim-kiem',[HomeController::class, 'search']);
Route::post('/tim-kiem-user',[HomeController::class, 'search_user']);
Route::post('/tim-kiem-order',[HomeController::class, 'search_order']);
Route::get('/quen-mat-khau',[HomeController::class, 'quen_mat_khau']);
Route::post('/recover-password',[HomeController::class, 'recover_password']);
Route::get('/update-new-pass',[HomeController::class, 'update_new_pass']);
Route::post('/reset-new-pass',[HomeController::class, 'reset_new_pass']);

// Danh muc san pham trang chu
Route::get('/danh-muc-san-pham/{category_id}',[CategoryProduct::class, 'show_category_home']);

//Danh muc thuong hieu trang chu
Route::get('/thuong-hieu-san-pham/{brand_id}',[BrandProduct::class, 'show_brand_home']);

Route::get('/chi-tiet-san-pham/{product_id}',[ProductController::class, 'details_product']);




//Backend
Route::get('/admin',[AdminController::class, 'index']);

Route::get('/dashboard',[AdminController::class, 'show_dashboard']);
Route::get('/logout',[AdminController::class, 'logout']);
Route::post('/admin-dashboard',[AdminController::class, 'dashboard']);

//Category product
Route::get('/add-category-product',[CategoryProduct::class,'add_category_product']);
Route::get('/edit-category-product/{category_product_id}',[CategoryProduct::class,'edit_category_product']);
Route::get('/delete-category-product/{category_product_id}',[CategoryProduct::class,'delete_category_product']);

Route::get('/all-category-product',[CategoryProduct::class, 'all_category_product']);
Route::post('/save-category-product',[CategoryProduct::class, 'save_category_product']);
Route::post('/update-category-product/{category_product_id}',[CategoryProduct::class, 'update_category_product']);

Route::get('/unactive-category-product/{category_product_id}',[CategoryProduct::class, 'unactive_category_product']);
Route::get('/active-category-product/{category_product_id}',[CategoryProduct::class, 'active_category_product']);

//Brand
Route::get('/add-brand-product',[BrandProduct::class,'add_brand_product']);
Route::get('/edit-brand-product/{brand_product_id}',[BrandProduct::class,'edit_brand_product']);
Route::get('/delete-brand-product/{brand_product_id}',[BrandProduct::class,'delete_brand_product']);

Route::get('/all-brand-product',[BrandProduct::class, 'all_brand_product']);
Route::post('/save-brand-product',[BrandProduct::class, 'save_brand_product']);
Route::post('/update-brand-product/{brand_product_id}',[BrandProduct::class, 'update_brand_product']);

Route::get('/unactive-brand-product/{brand_product_id}',[BrandProduct::class, 'unactive_brand_product']);
Route::get('/active-brand-product/{brand_product_id}',[BrandProduct::class, 'active_brand_product']);

//Color
Route::get('/add-color-product',[ColorProduct::class,'add_color_product']);
Route::get('/edit-color-product/{color_product_id}',[ColorProduct::class,'edit_color_product']);
Route::get('/delete-color-product/{color_product_id}',[ColorProduct::class,'delete_color_product']);

Route::get('/all-color-product',[ColorProduct::class, 'all_color_product']);
Route::post('/save-color-product',[ColorProduct::class, 'save_color_product']);
Route::post('/update-color-product/{color_product_id}',[ColorProduct::class, 'update_color_product']);

Route::get('/unactive-color-product/{color_product_id}',[ColorProduct::class, 'unactive_color_product']);
Route::get('/active-color-product/{color_product_id}',[ColorProduct::class, 'active_color_product']);

//Size
Route::get('/add-size-product',[SizeProduct::class,'add_size_product']);
Route::get('/edit-size-product/{size_product_id}',[SizeProduct::class,'edit_size_product']);
Route::get('/delete-size-product/{size_product_id}',[SizeProduct::class,'delete_size_product']);

Route::get('/all-size-product',[SizeProduct::class, 'all_size_product']);
Route::post('/save-size-product',[SizeProduct::class, 'save_size_product']);
Route::post('/update-size-product/{size_product_id}',[SizeProduct::class, 'update_size_product']);

Route::get('/unactive-size-product/{size_product_id}',[SizeProduct::class, 'unactive_size_product']);
Route::get('/active-size-product/{size_product_id}',[SizeProduct::class, 'active_size_product']);
//Product
Route::get('/add-product',[ProductController::class,'add_product']);
Route::get('/edit-product/{product_id}',[ProductController::class,'edit_product']);
Route::get('/delete-product/{product_id}',[ProductController::class,'delete_product']);

Route::get('/all-product',[ProductController::class, 'all_product']);
Route::post('/save-product',[ProductController::class, 'save_product']);
Route::post('/update-product/{product_id}',[ProductController::class, 'update_product']);

Route::get('/unactive-product/{product_id}',[ProductController::class, 'unactive_product']);
Route::get('/active-product/{product_id}',[ProductController::class, 'active_product']);

Route::post('/load-comment',[ProductController::class, 'load_comment']);
Route::post('/send-comment',[ProductController::class, 'send_comment']);
//Customer
Route::get('/all-account',[CustomerController::class, 'all_account']);
// Details Product
Route::get('/add-product-details',[ProductDetailsController::class,'add_product_details']);
Route::get('/edit-product-details/{product_details_id}',[ProductDetailsController::class,'edit_product_details']);
Route::get('/delete-product-details/{product_details_id}',[ProductDetailsController::class,'delete_product_details']);

Route::get('/all-product-details',[ProductDetailsController::class, 'all_product_details']);
Route::post('/save-product-details',[ProductDetailsController::class, 'save_product_details']);
Route::post('/update-product-details/{product_details_id}',[ProductDetailsController::class, 'update_product_details']);

//Gio hang
Route::post('/save-cart',[CartController::class, 'save_cart']);
Route::get('/show-cart',[CartController::class, 'show_cart']);
Route::get('/delete-to-cart/{rowId}',[CartController::class, 'delete_to_cart']);

Route::post('/update-cart-quantity',[CartController::class, 'update_cart_quantity']);
//check-out
Route::get('/login-checkout',[CheckoutController::class, 'login_checkout']);
Route::get('/logout-checkout',[CheckoutController::class, 'logout_checkout']);
// Route::get('/login-checkout-chuamua',[CheckoutController::class, 'login_checkout_chuamua']);
Route::post('/add-customer',[CheckoutController::class, 'add_customer']);
Route::get('/checkout/{gg}/{tt}',[CheckoutController::class, 'checkout']);
Route::get('/checkout-khong-ma/{gg}/{tt}',[CheckoutController::class, 'checkout']);
Route::post('/save-checkout-customer',[CheckoutController::class, 'save_checkout_customer']);
Route::post('/login-customer',[CheckoutController::class, 'login_customer']);
Route::get('/payment',[CheckoutController::class, 'payment']);
Route::post('/order-place',[CheckoutController::class, 'order_place']);
Route::post('/vnpay-payment',[CheckoutController::class, 'vnpay_payment']);
Route::post('/tienmat-payment',[CheckoutController::class, 'tienmat_payment']);
Route::get('/vnpay',[CheckoutController::class, 'vnpay']);
Route::get('/show-lichsu',[CheckoutController::class, 'show_lichsu']);
Route::get('/show-chitiet-lichsu/{orderId}',[CheckoutController::class, 'show_chitiet_lichsu']);
//order
Route::get('/manage-order',[CheckoutController::class, 'manage_order']);
Route::get('/view-order/{orderId}',[CheckoutController::class, 'view_order']);
//cap nhat trang thai
Route::get('/update-order-xuly/{orderId}',[CheckoutController::class, 'update_order_xuly']);
Route::get('/update-order-dagoi/{orderId}',[CheckoutController::class, 'update_order_dagoi']);
Route::get('/update-order-danggiao/{orderId}',[CheckoutController::class, 'update_order_danggiao']);
Route::get('/update-order-hoanthanh/{orderId}',[CheckoutController::class, 'update_order_hoanthanh']);

Route::get('/update-order-huy/{orderId}',[CheckoutController::class, 'update_order_huy']);
//loc trang thai
Route::get('/loc-order-xuly',[CheckoutController::class, 'loc_order_xuly']);
Route::get('/loc-order-dagoi',[CheckoutController::class, 'loc_order_dagoi']);
Route::get('/loc-order-danggiao',[CheckoutController::class, 'loc_order_danggiao']);
Route::get('/loc-order-hoanthanh',[CheckoutController::class, 'loc_order_hoanthanh']);
Route::get('/loc-order-huy',[CheckoutController::class, 'loc_order_huy']);
//
Route::get('/find-mau',[CheckoutController::class, 'find_mau']);
// Route::get('/tim-size',[CheckoutController::class, 'tim_size']);
Route::get('/all-comment',[Comment::class, 'all_comment']);
Route::get('/unactive-comment/{comment_id}',[Comment::class, 'unactive_comment']);
Route::get('/active-comment/{comment_id}',[Comment::class, 'active_comment']);
Route::get('/update-qty',[CheckoutController::class, 'update_qty']);
Route::post('/lay-ngay-loc',[CheckoutController::class, 'lay_ngay_loc']);
Route::post('/dashboard-filter',[CheckoutController::class, 'dashboard_filter']);
Route::post('/days-order', [ CheckoutController::class, 'days_order']);
Route::post('/luot-ban', [ CheckoutController::class, 'luot_ban']);
//in hoa don
Route::get('/in-hoadon/{hd}',[CheckoutController::class, 'in_hoadon']);
//giam gia

Route::get('/add-coupon',[CouponController::class,'add_coupon']);
Route::get('/edit-coupon/{coupon_id}',[CouponController::class,'edit_coupon']);
Route::get('/all-coupon',[CouponController::class,'all_coupon']);
Route::get('/delete-coupon/{coupon_id}',[CouponController::class,'delete_coupon']);
Route::post('/save-coupon',[CouponController::class, 'save_coupon']);
Route::post('/check-coupon',[CartController::class, 'check_coupon']);
Route::get('/test',[CartController::class, 'test']);

//account
Route::get('/update-account',[CheckoutController::class, 'update_account'])->name('update-acc');
Route::post('/update-account-save',[CheckoutController::class, 'update_account_save']);
Route::get('/update-password',[CheckoutController::class, 'update_password'])->name('update-pass');
Route::post('/update-password-save',[CheckoutController::class, 'update_password_save']);
Route::post('/tonkho', [ CheckoutController::class, 'tonkho']);
Route::post('/trangthai', [ CheckoutController::class, 'trangthai']);
