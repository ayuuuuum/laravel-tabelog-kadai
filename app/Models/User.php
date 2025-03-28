<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Cashier\Billable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\SoftDeletingScope; 

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, Billable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    //論理削除カラム(deleted_at)が日付(Datetime型)であることを宣言するためのもの
    protected $dates = ['deleted_at'];

    public static function boot()
    {
        parent::boot();

        //static::addGlobalScope(new SoftDeletingScope);
        
        // 認証時にソフトデリートされたユーザーを除外
        static::addGlobalScope('active', function (Builder $builder) {
            $builder->whereNull('deleted_at');
        });
    }

    public function newQuery($excludeDeleted = true): Builder
    {
        return parent::newQuery($excludeDeleted)->withoutGlobalScope(SoftDeletingScope::class);
    }

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function favorite_shops()
    {
        //中間テーブルはcreated_atカラムやupdated_atカラムの値が現在のタイムスタンプで自動的に更新されない
        //withTimestamps()メソッド＝中間テーブルの場合もcreated_atカラムやupdated_atカラムの値が自動的に更新されるようになる
        return $this->belongsToMany(Shop::class, 'favorites', 'user_id', 'shop_id')->withTimestamps();
    }

    public function reservates()
    {
        return $this->hasMany(Reservate::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function isAdmin()
    {
        return $this->is_admin;
    }
}
