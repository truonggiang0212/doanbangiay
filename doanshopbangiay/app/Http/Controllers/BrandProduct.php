<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Comment;
session_start();
class BrandProduct extends Controller
{
    public function Authlogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function add_brand_product(){
        $this->Authlogin();

        return view('admin.add_brand_product');
    }
    public function all_brand_product(){
        $this->Authlogin();

        $all_brand_product = Brand::orderBy('brand_id','DESC')->get();
        $manager_brand_product = view('admin.all_brand_product')->with('all_brand_product',$all_brand_product);
        return view('admin_layout')->with('admin.all_brand_product', $manager_brand_product);
    }
    public function save_brand_product(Request $request){
        $this->Authlogin();
        // $data = array();
        // $data['brand_name']=$request->brand_product_name;
        // $data['brand_desc']=$request->brand_product_desc;
        // $data['brand_status']=$request->brand_product_status;
        // DB::table('tbl_brand_product')->insert($data);
        $data = $request->all();
        $brand = new Brand();
        $brand->brand_name = $data['brand_product_name'];
        $brand->brand_desc = $data['brand_product_desc'];
        $brand->brand_status = $data['brand_product_status'];
        $brand->save();
        Session::put('message','Thêm thương hiệu thành công.');
        return Redirect::to('add-brand-product');
    }
    public function unactive_brand_product($brand_product_id){
        $this->Authlogin();
        Brand::where('brand_id',$brand_product_id)->update(['brand_status'=>1]);
        Session::put('message','Kích hoạt thương hiệu.');
        return Redirect::to('all-brand-product');
    }
    public function active_brand_product($brand_product_id){
        $this->Authlogin();
        Brand::where('brand_id',$brand_product_id)->update(['brand_status'=>0]);
        Session::put('message','Không kích hoạt thương hiệu.');
        return Redirect::to('all-brand-product');
    }
    public function edit_brand_product($brand_product_id){
        $this->Authlogin();

        $edit_brand_product = Brand::where('brand_id',$brand_product_id)->get();
        // dd( $edit_brand_product);
        $manager_brand_product = view('admin.edit_brand_product')->with('edit_brand_product',$edit_brand_product);
        return view('admin_layout')->with('admin.edit_brand_product', $manager_brand_product);
    }
    public function delete_brand_product($brand_product_id){
        $this->Authlogin();

        Brand::where('brand_id',$brand_product_id)->delete();
        Session::put('message','Xóa thương hiệu thành công');
        return Redirect::to('all-brand-product');
    }
    public function update_brand_product(Request $request, $brand_product_id){
        $this->Authlogin();
        $data = array();
        $data['brand_name']=$request->brand_product_name;
        $data['brand_desc']=$request->brand_product_desc;
        Brand::where('brand_id',$brand_product_id)->update($data);
        // $data = $request->all();
        // dd($data);
        // $brand = Brand::where('brand_id',$brand_product_id);
        // $brand->brand_name = $data['brand_product_name'];
        // $brand->brand_desc = $data['brand_product_desc'];
        // $brand->save();
        Session::put('message','Cập nhật thương hiệu thành công');
        return Redirect::to('all-brand-product');
    }
    // ket thuc admin
    public function show_brand_home($brand_id){

        $cate_product = Category::where('category_status','1')->orderBy('category_id','desc')->get();

        $brand_product = Brand::where('brand_status','1')->orderBy('brand_id','desc')->get();

        $brand_name= Brand::where('tbl_brand_product.brand_id',$brand_id)->limit(1)->get();


        if(isset($_GET['sort_by'])){
            $sort_by = $_GET['sort_by'];
            if($sort_by =='giam_dan'){
                $brand_by_id = Product::where('brand_id', $brand_id)->orderBy('product_price', 'DESC')->paginate(9)->appends (request()->query());
            }elseif($sort_by =='tang_dan'){
                $brand_by_id = Product::where('brand_id',$brand_id)->orderBy('product_price', 'ASC')->paginate(9)->appends (request()->query());
            }elseif($sort_by =='a_z'){
                $brand_by_id = Product::where('brand_id', $$brand_id)->orderBy('product_name', 'ASC')->paginate(9)->appends (request()->query());
            }elseif($sort_by =='z_a'){
                $brand_by_id = Product::where('brand_id', $brand_id)->orderBy('product_name', 'DESC')->paginate(9)->appends (request()->query());
            }
        }else{
            $brand_by_id = Product::join('tbl_brand_product','tbl_product.brand_id','=','tbl_brand_product.brand_id')
            ->where('tbl_product.brand_id',$brand_id)->get();
        }
        return view('pages.brand.show_brand', [
            'category'=>$cate_product,
            'brand'=>$brand_product,
            'brand_by_id'=>$brand_by_id,
            'brand_name'=>$brand_name,
        ]);
    }
}
