<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $table="product";
    protected $softDelete = true;
    protected $fillable = [
        "name",
        "price",
        "description",
        "stock",
        "group_id"
    ];
    public function images()
    {
        return $this->hasMany(ProductImage::class,"product_id");
    }
    public function group()
    {
        return $this->hasOne(ProductGroup::class,"group_id");
    }
    protected static function newFactory()
    {
        return \Modules\Product\Database\factories\ProductFactory::new();
    }
}
