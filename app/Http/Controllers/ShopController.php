<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Category;
use App\Imports\ShopsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Tables\Actions\Action;


class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //検索ワードを取得し変数に代入
        $keyword = $request->keyword;

        //セレクトボックスに表示するテキストをキー、カラム名と並び順を値に指定した配列を作成し、変数$sortsに代入
        $sorts = [
            '新着順' => 'created_at desc',
            '価格が安い順' => 'price asc',
        ];

        /*select_sortパラメータが存在するとき（並べ替え機能が使われたとき）にその値を半角スペースで分割し、あらかじめ定義しておいた配列$sort_queryに格納している
        例:セレクトボックスで「価格が安い順」が選択される⇒select_sortパラメータの値はprice ascになるので、if文の1行目でpriceとascに分割される⇒
        if文の2行目で$sort_query['price'] = 'asc';、つまりキーがprice、値がascのセットが配列$sort_queryに格納される（$sort_query = ['price' => 'asc']）⇒
        この配列$sort_queryを47行目のようなsortable()メソッドに指定することで、上記の例であればpriceカラムを昇順で並べ替えられる*/
        $sort_query = [];
        $sorted = "created_at desc";

        if ($request->has('select_sort')) {
            $slices = explode(' ', $request->input('select_sort'));
            $sort_query[$slices[0]] = $slices[1];
            $sorted = $request->input('select_sort');
        }

        //カテゴリーのリクエストがあった場合
        if ($request->category !== null) {
            //Shopモデルを使ってリクエストのあったカテゴリーIDを取得し、ページネーションで15個ずつ表示
            $shops = Shop::withAvg('reviews', 'score')->where('category_id', $request->category)->sortable($sort_query)->orderBy('created_at', 'desc')->paginate(15);
            //リクエストのあったカテゴリーの件数を表示
            $total_count = Shop::where('category_id', $request->category)->count();
            //カテゴリー名を取得
            $category = Category::find($request->category);
        //検索ワードのリクエストがあった場合
        } elseif ($keyword !== null) {
            //Shopモデルを使ってキーワードと一致する店舗名を取得し、ページネーションで15個ずつ表示
            $shops = Shop::withAvg('reviews', 'score')->where('name', 'like', "%{$keyword}%")->sortable($sort_query)->orderBy('created_at', 'desc')->paginate(15);
            //検索結果の件数を表示
            $total_count = $shops->total();
            //エラーにならないようにnullをセット
            $category = null;
        } else {
            //リクエストがなければ、Shopモデルを使ってデータベースからすべての店舗データを取得⇒ページネーションで15個ずつ表示
            $shops = Shop::withAvg('reviews', 'score')->sortable($sort_query)->orderBy('created_at', 'desc')->paginate(15);
            $total_count = (int) $shops->total();
            //エラーが出ないようにnullをセット
            $category = null;
        }


        //全てのカテゴリーを取得
        $categories = Category::all();

        return view('shops.index', compact('shops', 'category', 'categories', 'total_count', 'keyword', 'sorts', 'sorted'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('shops.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $shop = new Shop();
        $shop->name = $request->input('name');
        $shop->description = $request->input('description');
        $shop->price = $request->input('price');
        $shop->open_time = $request->input('open_time');
        $shop->close_time = $request->input('close_time');
        $shop->category_id = $request->input('category_id');
        $shop->save();

        return to_route('shops.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function show(Shop $shop)
    {
        //店舗についての全てのレビューを取得して$reviewsに保存
        $reviews = $shop->reviews()->paginate(5);

        // 平均評価を取得（Eager Loading を使用）
        $shop->loadAvg('reviews', 'score');

        return view('shops.show', compact('shop', 'reviews'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function edit(Shop $shop)
    {
        $categories = Category::all();

        return view('shops.edit', compact('shop', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shop $shop)
    {
        $shop->name = $request->input('name');
        $shop->description = $request->input('description');
        $shop->price = $request->input('price');
        $shop->open_time = $request->input('open_time');
        $shop->close_time = $request->input('close_time');
        $shop->category_id = $request->input('category_id');
        $shop->update();

        return to_route('shops.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shop $shop)
    {
        $shop->delete();

        return to_route('shops.index');
    }

    /*インポート用のビューを表示
    public function import()
    {
        return view('shops.import');
    }*/

    //CSVインポート用アクション
    public function importCsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:2048',
        ]);

        try {
            Excel::import(new ShopsImport, $request->file('csv_file'));
            return redirect()->route('shops.index')->with('success', 'CSVデータをインポートしました！');
        } catch (\Exception $e) {
            return redirect()->route('shops.index')->with('error', 'CSVのインポートに失敗しました。');
        }
    }
}
