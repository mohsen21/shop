<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductImage extends Model
{
    use HasFactory;
    protected $table="product_image";
    protected $softDelete = true;

    protected $fillable = [
        "product_id",
        "name",
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    protected static function newFactory()
    {
        return \Modules\Product\Database\factories\ProductImageFactory::new();
    }
}
