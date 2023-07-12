<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_details extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable =[
        'product_id','color_name','size_name','quantity'
    ];
    protected $primarykey = 'product_details_id';
    protected $table = 'tbl_product_details';
}
