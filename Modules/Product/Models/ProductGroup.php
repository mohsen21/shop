<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductGroup extends Model
{
    use HasFactory;
    protected $table="product_group";
    protected $softDelete = true;
    protected $fillable = [
        "name",
        "img_path",
        "description"
    ];
    public function product()
    {
        return $this->hasOne(Product::class);
    }

    protected static function newFactory()
    {
        return \Modules\Product\Database\factories\ProductGroupFactory::new();
    }
}
