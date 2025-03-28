<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebController;
use Laravel\Cashier\Http\Controllers\WebhookController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ReservateController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\TermsController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\AdminShopController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [WebController::class, 'index'])->name('top');
Route::get('/company', [CompanyController::class, 'show'])->name('company');
Route::get('/terms', [TermsController::class, 'show'])->name('terms');

require __DIR__.'/auth.php';

//ルーティングをグループ化することで、複数のルーティングにまとめて認可を設定できるる
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('shops', ShopController::class);

    Route::post('reviews', [ReviewController::class, 'store'])->name('reviews.store');

    Route::post('favorites/{shop_id}', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('favorites/{shop_id}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

    Route::get('/mypage/reservate', [ReservateController::class, 'index'])->name('users.reservate');
    Route::post('/reservate', [ReservateController::class, 'store'])->name('reservate.store');
    Route::get('/reservate/create/{shop}', [ReservateController::class, 'create'])->name('reservate.create');
    Route::delete('/reservate/{id}', [ReservateController::class, 'destroy'])->name('reservate.destroy');

    Route::get('users/mypage/cancel-subscription', [SubscriptionController::class, 'showCancelPage'])->name('mypage.cancel_subscription');
    Route::post('users/mypage/cancel-subscription', [SubscriptionController::class, 'cancelSubscription'])->name('mypage.cancel_subscription_post');

    Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    //UserController に関するルートをグループ化
    Route::controller(UserController::class)->group(function () {
        //マイページの表示
        Route::get('users/mypage', 'mypage')->name('mypage');
        //ユーザー情報の編集フォームを表示
        Route::get('users/mypage/edit', 'edit')->name('mypage.edit');
        //編集フォームから送信されたデータでユーザー情報を更新
        Route::put('users/mypage', 'update')->name('mypage.update');
        //パスワード変更フォームを表示
        Route::get('users/mypage/password/edit', 'edit_password')->name('mypage.edit_password');
        //パスワードの更新処理を実行
        Route::put('users/mypage/password', 'update_password')->name('mypage.update_password');
        //お気に入り店舗一覧を表示
        Route::get('users/mypage/favorite', 'favorite')->name('mypage.favorite');
        //カード入力画面を表示
        Route::get('users/mypage/subscription', 'showSubscriptionForm')->name('mypage.show_subscription');
        //カードを登録してサブスク契約を実行
        Route::post('users/mypage/subscription', 'processSubscription')->name('mypage.process_subscription');
        //退会機能を実行
        Route::delete('users/mypage/delete', 'destroy')->name('mypage.destroy');

    });
});

//Stripe からの通知を受け取るために Webhook を設定
Route::post('stripe/webhook', [WebhookController::class, 'handleWebhook']);


