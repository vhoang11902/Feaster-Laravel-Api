<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttrProduct extends Model
{
    use HasFactory;
    public $timestamps = false; //set time to false
    protected $fillable = [
        'attr_value_id','product_id','attr_id','value'
    ];
    protected $primaryKey = 'attr_value_id';
    protected $table = 'tbl_attr_value';
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attr_id', 'id');
    }
}
