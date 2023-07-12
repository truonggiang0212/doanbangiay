<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
class Product extends Model
{
    use HasFactory;
    protected $fillable =[
        'product_name','product_price','product_image','product_desc','product_content','category_id','brand_id','product_status'
    ];
    protected $primarykey = 'product_id';
    protected $table = 'tbl_product';
    public function category(){
        return $this->belongsTo('App\Models\Category','category_id');
    }
}
