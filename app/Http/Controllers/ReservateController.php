<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservate;
use App\Models\Shop;
use Carbon\Carbon;


class ReservateController extends Controller
{
    public function index()
    {
        // ログインユーザーの予約を取得
        $reservations = Reservate::where('user_id', Auth::id())->orderBy('reservation_time', 'desc')->get();

        return view('users.reservate', compact('reservations'));
    }

    public function store(Request $request) {

    // ユーザーがログインしているかチェック(していなかった場合はメッセージ表示)
    if (!auth()->check()) {
        return redirect()->back()->with('error' , 'ログインが必要です');
    }

    // ログイン中のユーザーが有料会員かどうかをチェック
    $user = auth()->user();
    if (!$user->subscribed('default')) { // 'default' は Stripe のサブスク名
        return redirect()->back()->with('error', '予約機能は有料会員のみ利用できます');
    }

    $request->validate([
        //exists:shops,id',= shopsテーブルに存在するIDであることをチェック
        'shop_id' => 'required|exists:shops,id',
        //date = 日付 
        'reservation_time' => [
            'required',
            'date',
            function ($attribute, $value, $fail) {
                $minTime = now()->addHours(2); // 現在時刻の2時間後
                if (\Carbon\Carbon::parse($value)->lt($minTime)) {
                    $fail('予約は現在時刻の2時間後以降のみ可能です。');
                }
            },
        ],
        /*integer = 整数
        min:1 = 1以上であること*/
        'number_of_people' => 'required|integer|min:1',
    ]);

    // 予約の重複チェック
    $exists = Reservate::where('shop_id', $request->shop_id) //指定された shop_id の予約を探す
        //指定された reservation_time の時間に予約があるか調べる
        ->where('reservation_time', $request->reservation_time)
        // その条件でデータが存在するかチェック
        ->exists();
    
    //すでに同じ日時で予約が入っている場合、予約を受け付けないようにする
    if ($exists) {
        return redirect()->back()->with('error', 'この時間は既に予約されています');
    }

    // 予約作成(予約情報をデータベースに保存)
    $reservation = Reservate::create([
        'user_id' => auth()->id(),
        'shop_id' => $request->shop_id,
        'reservation_time' => $request->reservation_time,
        'number_of_people' => $request->number_of_people ?? 1,
        //'status' => 'pending',  初期状態は未確定(pending)
    ]);

    /*201 = リソースが作成されたことを示すHTTPステータスコード（201 Created）
    json($reservation) = 作成した予約データをJSON形式で返す*/
    return redirect()->route('users.reservate')->with('success', '予約が完了しました！');
    }

    //店舗予約
    public function create($shopID)
    {
        $shop = Shop::findOrfail($shopID);

        return view('reservate.create', compact('shop'));
    }

    //予約店舗削除
    public function destroy($id)
    {
        $reservation = Reservate::find($id);

        if ($reservation) {
            // 予約を削除
            $reservation->delete();

            return redirect()->route('users.reservate')->with('success', '予約がキャンセルされました。');
        }

        return redirect()->route('users.reservate')->with('error', '予約が見つかりませんでした。');
    }
}
