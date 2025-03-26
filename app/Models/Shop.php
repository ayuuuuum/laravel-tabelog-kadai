<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Shop extends Model
{
    use HasFactory, Sortable;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    //favorited_usersメソッド＝店舗のお気に入りをしたユーザーたち
    public function favorited_users()
    {
        return $this->belongsToMany(User::class, 'favorites', 'shop_id', 'user_id')->withTimestamps();
    }

    public function reservates()
    {
        return $this->hasMany(Reservate::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    //管理画面での店舗作成
    protected $fillable = [
        'name',
        'description',
        'image',
        'recommend_flag',
        'price',
        'min_price', 
        'max_price',
        'open_time',
        'close_time',
        'category_id',
        'created_at'
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
