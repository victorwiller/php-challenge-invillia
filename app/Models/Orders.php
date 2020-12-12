<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'people_id'
    ];

    public function item() {
        return $this->hasMany(Items::class, 'order_id');
    }

    public function shipto() {
        return $this->hasOne(Shipto::class, 'order_id');
    }
}   
