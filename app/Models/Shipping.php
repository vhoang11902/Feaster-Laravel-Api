<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    public $timestamps = false; //set time to false
    protected $fillable = [
        'shipping_id','customer_id','shipping_address','shipping_state','shipping_city','shipping_postal_code'
    ];
    protected $table = 'tbl_shipping';
    protected $primaryKey = 'shipping_id';
}
