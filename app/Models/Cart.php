<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use Uuid;

    protected $table = 'carts';

    protected $fillable = [
        'product_id',
        'user_id',
        'amount'
    ];

    public $timestamps = true;

    public function product(){
        return $this->hasOne(Product::class,'id','product_id');
    }
}
