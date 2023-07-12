<?php

namespace App\Http\Controllers;

use App\Models\Comment as ModelsComment;
use App\Models\Product;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
class Comment extends Controller
{
    public function Authlogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function all_comment(){
        $this->Authlogin();
        $all_comment = ModelsComment::join('tbl_product','tbl_product.product_id','=','tbl_comment.comment_product_id')
        ->orderBy('tbl_comment.comment_id','desc')->get();
        $manager_comment = view('admin.all_comment')->with('all_comment', $all_comment);
        return view('admin_layout')->with('admin.all_comment', $manager_comment);
    }
    public function unactive_comment($comment_id){
        $this->Authlogin();
        ModelsComment::where('comment_id',$comment_id)->update(['comment_status'=>1]);
        Session::put('message','Đã duyệt bình luận.');
        return Redirect::to('all-comment');
    }
    public function active_comment($comment_id){
        $this->Authlogin();
        ModelsComment::where('comment_id',$comment_id)->update(['comment_status'=>0]);
        Session::put('message','Đã ẩn bình luận.');
        return Redirect::to('all-comment');
    }
}
