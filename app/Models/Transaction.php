<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use Uuid;

    protected $table = 'transactions';

    protected $fillable = [
        'user_id',
        'total'
    ];

    public $timestamps = true;

    public function transactionDetail(){
        return $this->hasMany(TransactionDetail::class,'transaction_id','id');
    }

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
}
