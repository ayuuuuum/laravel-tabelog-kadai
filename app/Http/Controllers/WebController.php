<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Shop;

class WebController extends Controller
{
    public function index()
    {
        //CategoryModelを使ってカテゴリーをすべて取得
        $categories = Category::all();

        //新着店舗(商品の登録日時（created_at）でソートして、新しい順に4つ取得してビューに渡す)
        $recently_shops = Shop::withAvg('reviews', 'score')->orderBy('created_at', 'desc')->take(4)->get();

        // おすすめ店舗を取得（recommend_flagがtrueのもの）
        $recommended_shops = Shop::withAvg('reviews', 'score')->where('recommend_flag', true)->take(4)->get();

        return view('web.index', compact('categories', 'recently_shops', 'recommended_shops'));
    }
}
