<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use Uuid;

    protected $table = 'transaction_details';

    protected $fillable = [
        'transaction_id',
        'user_id',
        'product_id',
        'product_name',
        'amount',
        'price',
        'total'

    ];

    public $timestamps = true;

    public function product(){
        return $this->hasOne(Product::class,'id','product_id');
    }

}
