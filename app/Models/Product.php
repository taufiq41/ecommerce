<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Uuid;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'price',
        'image',
        'stock',
        'description'
    ];

    public $timestamps = true;
}
