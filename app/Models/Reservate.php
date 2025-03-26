<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'shop_id', 
        'reservation_time', 
        'number_of_people', 
    ];

    public function shop() 
    {
        return $this->belongsTo(Shop::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

