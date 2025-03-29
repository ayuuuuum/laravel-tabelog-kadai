<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    //有料会員登録ページを表示
    public function showSubscriptionForm()
    {
        $user = Auth::user();

        return view('users.subscription', compact('user'));
    }

    // 解約ページを表示
    public function showCancelPage()
    {
        return view('users.cancel_subscription');
    }

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
        return redirect()->route('mypage')->with('flash_message', '有料会員登録が完了しました！');
    }

    // 有料会員解約処理
    public function cancelSubscription(Request $request)
    {
        $user = Auth::user();

        // Stripeでのサブスクリプション解約
        if ($user->subscribed('default')) {
            try {

                // 解約処理
                $user->subscription('default')->cancelNow();

                return redirect()->route('mypage')->with('flash_message', '有料会員の解約が完了しました。');

                $user->refresh(); // ユーザー情報を再取得して最新のステータスを反映
            } catch (\Exception $e) {
                // エラーメッセージを表示
            return redirect()->route('mypage')->with('flash_message', '解約に失敗しました');
            }
        }

        return redirect()->route('mypage')->with('flash_message', '既に解約されています。');
    }

    // カード情報編集フォームを表示
    public function editCard()
    {
        $user = Auth::user();
        return view('users.edit_card', compact('user'));
    }

    // カード情報更新処理
    public function updateCard(Request $request)
    {
        $user = Auth::user();

        // Stripeに顧客が存在しない場合は作成
        $user->createOrGetStripeCustomer();

        // カード情報を更新
        $user->updateDefaultPaymentMethod($request->payment_method);

        return redirect()->route('mypage')->with('flash_message', 'クレジットカード情報を更新しました！');
    }

}
