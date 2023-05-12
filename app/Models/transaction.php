<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'itemList',
        'total',
        'totalDiscounted',
        'userID',
        'discountID',
        'discountType',
        'discountAmount',
    ];
}
