<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peoples extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name'
    ];

    public function phone() {
        return $this->hasMany(Phones::class, 'people_id');
    }
}
