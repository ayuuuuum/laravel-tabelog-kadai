<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    //店舗IDを受け取る
    public function store($shop_id)
    {
        //Auth::user()=現在ログインしているユーザーを取得し、favorite_shops() リレーション を通じて、お気に入り登録
        //attach($shop_id)=多対多のリレーションで 中間テーブルにデータを追加 するメソッド
        Auth::user()->favorite_shops()->attach($shop_id);

        return back();
    }

    public function destroy($shop_id)
    {
        Auth::user()->favorite_shops()->detach($shop_id);

        return back();
    }
}
