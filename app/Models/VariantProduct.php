<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariantProduct extends Model
{
    use HasFactory;
    public $timestamps = false; //set time to false
    protected $fillable = [
        'attr_id','attr_value_id','product_id','sku_id'
    ];
    protected $primaryKey = 'id';
    protected $table = 'variant_products';
    public function option(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Attribute::class,'attr_id','id');
    }

    public function optionValue(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(AttrProduct::class,'attr_value_id','attr_value_id');
    }
}
