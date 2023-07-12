<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable =[
        'coupon_name','coupon_code','coupon_qty','coupon_number','coupon_condition'
    ];
    protected $primarykey = 'coupon_id';
    protected $table = 'tbl_coupon';
}
