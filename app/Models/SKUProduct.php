<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SKUProduct extends Model
{
    use HasFactory;
    public $timestamps = false; //set time to false
    protected $fillable = [
        'product_id','price','stock'
    ];
    protected $primaryKey = 'sku_id';
    protected $table = 'sku_products';
    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class,'product_id','product_id');
    }

    public function variants(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(VariantProduct::class, 'sku_id','sku_id');
    }
}
