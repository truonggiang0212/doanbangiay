<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
session_start();
class CategoryProduct extends Controller
{
    public function Authlogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function add_category_product(){
        $this->Authlogin();
        return view('admin.add_category_product');
    }
    public function all_category_product(){
        $this->Authlogin();
        $all_category_product = Category::orderBy('category_id','DESC')->get();
        $manager_category_product = view('admin.all_category_product')->with('all_category_product',$all_category_product);
        return view('admin_layout')->with('admin.all_category_product', $manager_category_product);
    }
    public function save_category_product(Request $request){
        $this->Authlogin();

        $data = $request->all();
        $category = new Category();
        $category->category_name = $data['category_product_name'];
        $category->category_desc = $data['category_product_desc'];
        $category->category_status = $data['category_product_status'];
        $category->save();

        Session::put('message','Thêm danh mục sản phẩm thành công');
        return Redirect::to('add-category-product');
    }
    public function unactive_category_product($category_product_id){
        Category::where('category_id',$category_product_id)->update(['category_status'=>1]);
        $this->Authlogin();
        Session::put('message','Kích hoạt danh mục sản phẩm');
        return Redirect::to('all-category-product');
    }
    public function active_category_product($category_product_id){
        $this->Authlogin();
        Category::where('category_id',$category_product_id)->update(['category_status'=>0]);
        Session::put('message','Không kích hoạt danh mục sản phẩm');
        return Redirect::to('all-category-product');
    }
    public function edit_category_product($category_product_id){
        $this->Authlogin();
        $edit_category_product =  Category::where('category_id',$category_product_id)->get();
        $manager_category_product = view('admin.edit_category_product')->with('edit_category_product',$edit_category_product);
        return view('admin_layout')->with('admin.edit_category_product', $manager_category_product);
    }
    public function delete_category_product($category_product_id){
        $this->Authlogin();
        Category::where('category_id',$category_product_id)->delete();
        Session::put('message','Xóa danh mục sản phẩm thành công');
        return Redirect::to('all-category-product');
    }
    public function update_category_product(Request $request, $category_product_id){
        $this->Authlogin();
        $data = array();
        $data['category_name']=$request->category_product_name;
        $data['category_desc']=$request->category_product_desc;
        Category::where('category_id',$category_product_id)->update($data);
        Session::put('message','Cập nhật danh mục sản phẩm thành công');
        return Redirect::to('all-category-product');
    }
    //Ket thuc admin

    public function show_category_home($category_id){
        $cate_product =  Category::where('category_status','1')->orderBy('category_id','desc')->get();
        $brand_product = Brand::where('brand_status','1')->orderBy('brand_id','desc')->get();
        $category_name= Category::where('tbl_category_product.category_id',$category_id)->limit(1)->get();
        // $category_by_id = Product::join('tbl_category_product','tbl_product.category_id','=','tbl_category_product.category_id')
        // ->where('tbl_product.category_id',$category_id)->get();

        if(isset($_GET['sort_by'])){
            $sort_by = $_GET['sort_by'];
            if($sort_by =='giam_dan'){
                $category_by_id = Product::where('category_id', $category_id)->orderBy('product_price', 'DESC')->paginate(6)->appends (request()->query());
            }elseif($sort_by =='tang_dan'){
                $category_by_id = Product::where('category_id',$category_id)->orderBy('product_price', 'ASC')->paginate(6)->appends (request()->query());
            }elseif($sort_by =='a_z'){
                $category_by_id = Product::where('category_id', $category_id)->orderBy('product_name', 'ASC')->paginate(6)->appends (request()->query());
            }elseif($sort_by =='z_a'){
                $category_by_id = Product::where('category_id', $category_id)->orderBy('product_name', 'DESC')->paginate(6)->appends (request()->query());
            }
        }else{
            // $category_by_id = Product::with('category')->where('category_id', $category_id)->orderBy('product_id', 'DESC')->paginate(6);
            $category_by_id = Product::join('tbl_category_product','tbl_product.category_id','=','tbl_category_product.category_id')
            ->where('tbl_product.category_id',$category_id)->get();
        }

        return view('pages.category.show_category',[
            'category'=>$cate_product,
            'brand'=>$brand_product,
            'category_by_id'=>$category_by_id,
            'category_name'=>$category_name,
        ]);

    }

}
