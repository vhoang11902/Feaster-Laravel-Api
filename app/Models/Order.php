<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false; //set time to false
    protected $fillable = [
        'order_id','customer_id','shipping_id','order_total','order_status','order_code'
    ];
    protected $table = 'tbl_order';
    protected $primaryKey = 'order_id';

}
