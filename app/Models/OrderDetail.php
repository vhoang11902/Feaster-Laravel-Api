<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    public $timestamps = false; //set time to false
    protected $fillable = [
        'order_detail_id','order_id','product_id','sku_id','product_name','product_price','product_qty'
    ];
    protected $table = 'tbl_order_detail';
    protected $primaryKey = 'order_detail_id';
}
