<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    // 解約ページを表示
    public function showCancelPage()
    {
        return view('users.cancel_subscription');
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
            return redirect()->route('mypage')->with('flash_message', '解約に失敗しました。エラー: ' . $e->getMessage());
            }
        }

        return redirect()->route('mypage')->with('flash_message', '既に解約されています。');
    }

}
