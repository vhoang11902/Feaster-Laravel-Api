<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_name',
        'category_desc',
        'category_status',
    ];
    protected $table = 'tbl_category_product';

    public function product()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
}
