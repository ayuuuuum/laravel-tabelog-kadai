<?php

namespace App\Http\Controllers;

use App\Models\Review;
//Laravelの認証機能（Authentication）を提供するファサード（Facade）である Auth クラスを使えるようにするための宣言
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 有料会員かどうかをチェック（ここではStripeのサブスクを利用している前提）
        $user = Auth::user();
        if (!$user->subscribed('default')) {
            return redirect()->back()->with('error', 'レビュー投稿は有料会員のみ利用可能です。');
        }

        $request->validate([
            //入力必須、最大20文字
            'title' => 'required|max:20',
            //入力必須
            'content' =>'required'
            
        ]);

        //新しいレビューオブジェクトを作る
        $review = new Review();
        //リクエストから title の値を取得
        $review->title = $request->input('title');
        //リクエストから content の値を取得
        $review->content = $request->input('content');
        //どのお店に対するレビューかを取得
        $review->shop_id = $request->input('shop_id');
        //現在ログインしているユーザーのIDを取得 してセット
        $review->user_id = Auth::user()->id;
        //リクエストからscoreを取得
        $review->score = $request->input('score');
        //データベースに保存
        $review->save();

        //前のページにリダイレクトする
        return back();
    }

    public function edit(Review $review)
    {
        $this->authorize('update', $review); // ポリシーで認可
        return view('reviews.edit', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        $this->authorize('update', $review);

        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'score' => 'required|integer|between:1,5',
        ]);

        $review->update($validated);

        return redirect()->route('shops.show', $review->shop_id)->with('flash_message', 'レビューを更新しました！');
    }

    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);

        $shopId = $review->shop_id;
        $review->delete();

        return redirect()->route('shops.show', $shopId)->with('flash_message', 'レビューを削除しました！');
    }

}
