<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attribute extends Model
{
    use HasFactory;
    public $timestamps = false; //set time to false
    protected $fillable = [
        'attr_id','attr_name'
    ];
    protected $primaryKey = 'attr_id';
    protected $table = 'tbl_attribute';
    public function attr_product()
    {
        return $this->hasMany(AttrProduct::class, 'attr_id', 'id');
    }
}
