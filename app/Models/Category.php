<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function shops() 
    {
        return $this->hasMany(Shop::class);
    }

    //管理画面でのカテゴリー作成
    protected $fillable = [
        'name',
        'description',
        'image',
        'image_original_name',  // 元ファイル名を保存するカラム（使用する場合）
    ];
}
