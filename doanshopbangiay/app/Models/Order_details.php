<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_details extends Model
{
    use HasFactory;
    protected $fillable =[
        'order_id','product_id','product_name','product_size','produtc_color','product_price','product_sales_quantity'
    ];
    protected $primarykey = 'order_details_id';
    protected $table = 'order_details';
}
