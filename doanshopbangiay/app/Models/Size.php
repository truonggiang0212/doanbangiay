<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;
    protected $fillable =[
        'size_name','size_status'
    ];
    protected $primarykey = 'size_id';
    protected $table = 'tbl_size_product';
}
