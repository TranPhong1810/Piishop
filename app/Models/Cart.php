<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
    ];
    public function product()
    {
        return $this->hasMany(CartProduct::class, 'cart_id');
    }
    public function getBy($userId)
    {
        return Cart::whereUserId($userId)->first();
    }
    public function firstOrCreateBy($userId)
    {
        $cart = $this->getBy($userId);
        if (!$cart) {
            $cart = Cart::create(['user_id' => $userId]);
        }
        return $cart;
    }
}
