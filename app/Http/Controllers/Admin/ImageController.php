<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Shop;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ImageController extends Controller
{
    public function update(Request $request, $id)
{
    //カテゴリー画像の処理
    if ($request->hasFile('category_image')) {
        $category = Category::findOrFail($id);

        // 既存の画像を削除
        if ($category->image) {
            Storage::delete('public/' . $category->image);
        }

        // 新しい画像を保存
        $path = $request->file('category_image')->store('categories', 'public');
        $category->image = $path;
        $category->save();
    }


    //店舗画像の処理
    if ($request->hasFile('shop_image')) {
        $shop = Shop::findOrFail($id);

        // 既存の画像を削除
        if ($shop->image) {
            Storage::delete('public/' . $shop->image);
        }

        // 新しい画像を保存
        $path = $request->file('shop_image')->store('shops', 'public');
        $shop->image = $path;
        $shop->save();
    }

    return back()->with('success', '画像を更新しました！');
}
}
