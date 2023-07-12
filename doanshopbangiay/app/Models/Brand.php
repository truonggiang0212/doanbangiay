<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable =[
        'brand_name','brand_desc','brand_status'
    ];
    protected $primarykey = 'brand_id';
    protected $table = 'tbl_brand_product';
}
