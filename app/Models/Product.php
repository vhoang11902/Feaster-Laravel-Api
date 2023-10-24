<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    public $timestamps = false; //set time to false
    protected $fillable = [
        'product_id', 'category_id', 'product_name', 'product_desc'
        , 'product_content', 'product_price', 'product_image', 'product_sku', 'product_status'
    ];
    protected $table = 'tbl_product';
    protected $primaryKey = 'product_id';

    public function attribute(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Attribute::class, 'product_id', 'product_id');
    }

    public function attr_value(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AttrProduct::class,'product_id', 'product_id');
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }
    public function skus(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SKUProduct::class, 'product_id', 'product_id');
    }

    public function variants(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(VariantProduct::class,'product_id','product_id');
    }
}
