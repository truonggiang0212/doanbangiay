<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable =[
        'customer_id','shipping_id','payment_id','order_total','order_status','giam_gia','so_tien_phai_tra','order_date_time'
    ];
    protected $primarykey = 'order_id';
    protected $table = 'tbl_order';
}
