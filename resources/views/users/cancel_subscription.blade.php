@extends('layouts.app')

@section('content')
<div class="container pt-5 d-flex justify-content-center">
    <div class="col-md-6">
        <h2 class="mb-4 text-center">有料プラン解約</h2>
        <p class="mb-4 text-center">有料プランを解約すると以下の特典を受けられなくなります。<br>本当に解約してもよろしいですか？</p>

        <!-- 特典リストをカードスタイルで強調 -->
        <div class="card p-4 mb-4">
            <ul class="list-unstyled">
                <li><i class="fas fa-check-circle text-success"></i> 当日の2時間前までならいつでも予約可能</li>
                <li><i class="fas fa-check-circle text-success"></i> 店舗をお好きなだけお気に入りに追加可能</li>
                <li><i class="fas fa-check-circle text-success"></i> レビューを投稿可能</li>
                <li><i class="fas fa-check-circle text-success"></i> 月額たったの300円</li>
            </ul>
        </div>

        <!-- ボタンを中央寄せ -->
        <div class="text-center mb-4">
            <!-- 解約ボタン -->
            <form action="{{ route('mypage.cancel_subscription_post') }}" method="POST" class="mb-4">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm" style="width: 200px;">解約する</button>
            </form>

            <!-- キャンセルボタン -->
            <a href="{{ route('mypage') }}" class="btn btn-secondary btn-sm" style="width: 200px;">キャンセル</a>
        </div>
    </div>
</div>
@endsection