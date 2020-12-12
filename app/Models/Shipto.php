<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipto extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'name',
        'address',
        'city',
        'country'
    ];

    public function order() {
        return $this->belongsTo(Orders::class);
    }
}
