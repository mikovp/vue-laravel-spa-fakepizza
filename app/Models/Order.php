<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['order_number','user_id','product_id','amount','address','name','mobile_phone'];

    use HasFactory;

    public function user()
    {
        return $this->hasOne(User::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
