<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Auth\Models\User;

class Cart extends Model
{
    use HasFactory;
    protected $table="cart";
    protected $softDelete = true;

    protected $fillable = [
        "user_id",
        "product_id",
        "price",
    ];
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function newFactory()
    {
        return \Modules\Product\Database\factories\CartFactory::new();
    }
}
