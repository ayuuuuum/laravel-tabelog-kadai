<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //マイページ(閲覧専用)
    public function mypage()
    {
        //ログイン中のユーザーのユーザー情報を取得
        $user = Auth::user();

        return view('users.mypage', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    //編集画面の表示(データを編集するためのフォームを表示する)
    public function edit(User $user)
    {
        $user = Auth::user();

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    //データの更新(フォームから送信されたデータを受け取り、データベースの情報を更新する)
    public function update(Request $request, User $user)
    {
        $user = Auth::user();

        // ?=三項演算子(＜条件式＞?＜条件式が真の場合＞:＜条件式が偽の場合＞)
        //$requestから各種情報を取得して、ユーザー情報を更新
        $user->name = $request->input('name') ? $request->input('name') : $user->name;
        $user->email = $request->input('email') ? $request->input('email') : $user->email;
        $user->update();

        //更新後はマイページに遷移
        return to_route('mypage')->with('flash_message', '会員情報を更新しました。');
    }

    //パスワードを変更するためのアクション
    public function update_password(Request $request) 
    {
        /*バリデーション 
        required= 入力必須
        confirmed= password_confirmationの値と一致しているか自動でチェックしてくれる
        ⇒失敗すると自動的に元のページにリダイレクトし、エラーメッセージを表示*/
        $validateData = $request->validate([
            'password' => 'required|confirmed',
        ]);

        $user = Auth::user();

        //パスワードと確認用パスワードが一致している場合
        if ($request->input('password') == $request->input('password_confirmation')) {
            //bcrypt()を使ってハッシュ化（暗号化)
            $user->password = bcrypt($request->input('password'));
            //データベース情報を更新
            $user->update();
        //一致しなかった場合
        } else {
            //パスワード編集画面に戻る
            return to_route('mypage.edit_password');
        }

        //パスワード変更が終了したらマイページに戻る
        return to_route('mypage')->with('flash_message', 'パスワードを更新しました。');

    }

    //パスワード変更画面を表示
    public function edit_password()
    {
        return view('users.edit_password');
    }

    //お気に入り店舗表示
    public function favorite()
    {
        $user = Auth::user();

        //お気に入り登録した店舗一覧を取得
        $favorite_shops = $user->favorite_shops()->paginate(5);

        return view('users.favorite', compact('favorite_shops'));
    }

    /*クレジットカード情報をStripeに登録
    public function storePaymentMethod(Request $request)
    {
        $user = Auth::user();

        // Stripeの顧客情報を作成
        $user->createOrGetStripeCustomer();

        //クレジットカード情報を登録
        $user->updateDefaultPaymentMethod($request->paymentmethod);

        //成功メッセージを表示して、元のページに戻る
        return back()->with('success', 'カード情報を登録しました！');
    }*/

    //有料会員登録ページを表示
    public function showSubscriptionForm()
    {
        $user = Auth::user();

        return view('users.subscription', compact('user'));
    }

    /*クレジットカード登録 & サブスク契約処理
    public function processSubscription(Request $request)
    {
    $user = Auth::user();
    $user->createOrGetStripeCustomer();
    $user->updateDefaultPaymentMethod($request->payment_method);

    $subscription = $user->newSubscription('default', 'price_1R2upmQ9d9JAAZz6bq9jugty')
        ->create($request->payment_method, ['payment_behavior' => 'default_incomplete']);

    if ($subscription->latestPayment()->requiresAction()) {
        return response()->json([
            'requires_action' => true,
            'payment_intent_client_secret' => $subscription->latestPayment()->clientSecret(),
        ]);
    }

    return response()->json(['success' => true]);
    }*/

    //クレジットカード登録 & サブスク契約処理
    public function processSubscription(Request $request)
    {
        $user = Auth::user();

        // Stripeの顧客情報を作成（すでに登録済みならそのまま取得）
        $user->createOrGetStripeCustomer();

        //クレジットカードを登録
        $user->updateDefaultPaymentMethod($request->payment_method);

        /*サブスクリプションを開始（"price_xxxx" はStripeのプランID）
        default → サブスクの名前（複数サブスクを扱う場合に識別するため）
        $request->payment_method → フロントから送られた paymentMethod（カード情報）*/
        $user->newSubscription('default', 'price_1R2upmQ9d9JAAZz6bq9jugty')
            ->create($request->payment_method, ['payment_behavior' => 'default_incomplete']);

        //メッセージを表示してマイページにリダイレクト
        return redirect()->route('mypage')->with('success', '有料会員登録が完了しました！');
    }

    //退会用画面　deleteメソッドで論理削除ができる
    public function destroy(Request $request)
    {
        Auth::user()->delete();
        return redirect('/')->with('flash_message', '退会が完了しました。');
    }

}
