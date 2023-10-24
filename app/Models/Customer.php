<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public $timestamps = false; //set time to false
    protected $fillable = [
        'customer_id','customer_name','customer_phone','customer_email'
    ];
    protected $table = 'tbl_customer';
    protected $primaryKey = 'customer_id';
}
