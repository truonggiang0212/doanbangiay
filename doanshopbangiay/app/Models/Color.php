<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;
    protected $fillable =[
        'color_name','color_status'
    ];
    protected $primarykey = 'color_id';
    protected $table = 'tbl_color_product';
}
