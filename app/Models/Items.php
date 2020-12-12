<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'order_id',
        'title',
        'note',
        'quantity',
        'price'
    ];

    public function order() {
        return $this->belongsTo(Orders::class);
    }
}
