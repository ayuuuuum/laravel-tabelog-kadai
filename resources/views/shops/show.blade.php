@extends('layouts.app')

@section('content')

<div class="container pt-2">
    <div class="row justify-content-center">

        <div class="row">
            <nav class="mb-2" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('top') }}">トップ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('shops.index', ['category' => $shop->category->id]) }}">{{ $shop->category->name }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $shop->name }}</li>
                </ol>
            </nav>
        </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    {{--もし画像があれば表示。無ければ指定の画像を表示--}}
                    @if ($shop->image !== "")
                        <img src="{{ asset('storage/' . $shop->image) }}" class="img-thumbnail samuraimart-product-img-detail">
                    @else
                        <img src="{{ asset('img/dummy.png')}}" class="img-thumbnail samuraimart-product-img-detail">
                    @endif
                </div>
                        <div class="col">
                            <div>
                                <h1>{{$shop->name}}</h1>
                                    <span>
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= round($shop->reviews_avg_score))
                                                ★
                                            @else
                                                ☆
                                            @endif
                                        @endfor
                                        ({{ number_format($shop->reviews_avg_score ?? 0, 1) }})
                                    </span>
                                    <br>
                                    <p>{{$shop->description}}</p>
                            </div>
                                    <hr class="my-4">
                                        <div class="d-flex align-items-baseline">
                    <span class="fs-4 fw-bold">
                        ¥{{ number_format($shop->min_price) }} ~ {{ number_format($shop->max_price) }}
                    </span>
               </div>
               <p class="d-flex align-items-end">
                   {{\Carbon\Carbon::parse($shop->open_time)->format('H:i') }} ~ {{ \Carbon\Carbon::parse($shop->close_time)->format('H:i') }}
               </p>
               <hr class="my-4">
           @auth
           @if(Auth::user()->subscribed('default'))
           <form method="POST" class="m-3 align-items-end">
               @csrf
               <input type="hidden" name="id" value="{{$shop->id}}">
               <input type="hidden" name="name" value="{{$shop->name}}">
               <input type="hidden" name="price" value="{{$shop->price}}">
               <input type="hidden" name="image" value="{{$shop->image}}">
               <input type="hidden" name="open_time" value="{{$shop->open_time}}">
               <input type="hidden" name="close_time" value="{{$shop->close_time}}">
            </form>
            
                   <div class="col">
                        {{--Auth::user()=ログイン中のユーザー取得
                            favorite_shops()=ユーザーが登録したお気に入りショップ一覧を取得（多対多のリレーション）
                            where('shop_id', $shop->id)=現在表示している $shop->id（ショップの ID）が含まれているかチェック
                            exists()=そのショップがすでにお気に入り登録されているかを判定--}}
                        @if(Auth::user()->favorite_shops()->where('shop_id', $shop->id)->exists())
                            {{--お気に入り登録済みの場合--}}
                            <a href="{{ route('favorites.destroy', $shop->id) }}" class="btn samuraimart-favorite-button text-favorite w-100 mb-2" onclick="event.preventDefault(); document.getElementById('favorites-destroy-form').submit();">
                                <i class="fa fa-heart"></i>
                                お気に入り解除
                            </a>

                            <form id="favorites-destroy-form" action="{{ route('favorites.destroy', $shop->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>

                        @else
                            {{--お気に入り未登録の場合--}}
                            <a href="{{ route('favorites.store', $shop->id) }}" class="btn samuraimart-favorite-button text-favorite w-100 mb-2" onclick="event.preventDefault(); document.getElementById('favorites-store-form').submit();">
                                <i class="fa fa-heart"></i>
                                お気に入り
                            </a>

                            <form id="favorites-store-form" action="{{ route('favorites.store', $shop->id) }}" method="POST" style="display: none;">
                            @csrf
                            </form>

                        @endif
    
                    </div>
     
                    {{--route('reservate.create', ['shop' => $shop->id]) で 予約ページへ遷移--}}
                        <form method="GET" action="{{ route('reservate.create', ['shop' => $shop->id]) }}" class="m-3 align-items-end">
                            <button type="submit" class="btn samuraimart-favorite-button text-favorite w-100 mt-2">
                                <i class="fa fa-calendar"></i> 予約する
                            </button>
                        </form>
            @endif
            @endauth
    </div>

    <hr class="w-100 my-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <h2 class="mb-3">カスタマーレビュー</h2>
                        <p>
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= round($shop->reviews_avg_score ?? 0))
                                    ★
                                @else
                                    ☆
                                @endif
                            @endfor
                            ({{ number_format($shop->reviews_avg_score ?? 0, 1) }})
                        </p>

                            <div class="row justify-content-center">
                                <div class="col-md-5 mb-4">
                                    <p>{{ number_format($reviews->total()) }}件のレビュー</p>

                                    @auth
                                        @if(Auth::user()->subscribed('default'))
                                        <!-- レビュー投稿フォーム -->
                                        <form method="POST" action="{{ route('reviews.store') }}">
                                            @csrf
                                                <div class="mb-3">
                                                    <label class="fs-5 mb-1">評価</label>
                                                    <select name="score" class="form-control review-score-color form-select samuraimart-form-parts">
                                                        <option value="5" class="review-score-color">★★★★★</option>
                                                        <option value="4" class="review-score-color">★★★★</option>
                                                        <option value="3" class="review-score-color">★★★</option>
                                                        <option value="2" class="review-score-color">★★</option>
                                                        <option value="1" class="review-score-color">★</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="fs-5 mb-1">タイトル</label>
                                                    <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                                                    @error('title')
                                                        <p class="text-danger"><strong>{{ $message }}</strong></p>
                                                    @enderror
                                                </div>
                                                <div class="mb-4">
                                                    <label class="fs-5 mb-1">レビュー内容</label>
                                                    @error('content')
                                                        <p class="text-danger"><strong>{{ $message }}</strong></p>
                                                    @enderror
                                                        <textarea name="content" class="form-control" rows="4"></textarea>
                                                </div>
                                                <input type="hidden" name="shop_id" value="{{$shop->id}}">
                                                <button type="submit" class="btn btn-primary w-100">レビューを追加</button>
                                        </form>
                                        @endif
                                    @endauth
                                </div>

                                <div class="col-md-7">
                                    @if ($reviews->isEmpty())
                                        <p>レビューはまだありません。</p>
                                    @else
                                        {{--レビューを繰り返し処理で表示--}}
                                        @foreach($reviews as $review)
                                            <div class="md-5">
                                                {{--評価を表示--}}
                                                <h3>{{ $review->title }}</h3>
                                                    <p class="fs-5 mb-2">
                                                        <span class="review-score-color">{{ str_repeat('★', $review->score) }}</span>
                                                        <span class="review-score-blank-color">{{ str_repeat('★', 5 - $review->score) }}</span>
                                                    </p>
                                                    <p>{{$review->content}}</p>
                                                    {{--レビュー作成日時、ユーザーネーム表示--}}
                                                    <p>
                                                        <span class="fw-bold me-2">{{$review->user->name}}</span>
                                                        <span class="text-muted">{{$review->created_at->format('Y年m月d日') }}</span>
                                                    </p>

                                                    @auth
                                                        @if ($review->user_id === auth()->id())
                                                            <div class="d-flex gap-2">
                                                                {{-- 編集ボタン --}}
                                                                <a href="{{ route('reviews.edit', $review->id) }}" class="btn btn-outline-secondary btn-sm">
                                                                    編集
                                                                </a>

                                                                {{-- 削除ボタン --}}
                                                                <form method="POST" action="{{ route('reviews.destroy', $review->id) }}" onsubmit="return confirm('本当に削除しますか？');">
                                                                @csrf
                                                                @method('DELETE')
                                                                    <button type="submit" class="btn btn-outline-danger btn-sm">削除</button>
                                                                </form>
                                                            </div>
                                                        @endif
                                                    @endauth
                                            </div>
                                        @endforeach
                                        <div class="mb-4">
                                            {{ $reviews->links() }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                </div>
            </div>
        </div>
@endsection
