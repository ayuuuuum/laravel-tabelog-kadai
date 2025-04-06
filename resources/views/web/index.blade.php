@extends('layouts.app')

@section('content')
    <div id="topCarousel" class="carousel slide mb-4" data-bs-ride="carousel" data-bs-interval="4000">
        <div class="carousel-inner">
            <div class="carousel-caption-text">
                <p>名古屋ならではの味を見つけよう</p>
                    <h3>NAGOYAMESHIは、<br>
                        名古屋市のB級グルメ専門のレビューサイトです。</h3>
            </div>
            <div class="carousel-item active">
                <div class="carousel-image-wrapper position-relative">
                    <img src="{{ asset('storage/img/top1.jpg') }}" class="d-block w-100 carousel-image" alt="1枚目">
                </div>
            </div>
            <div class="carousel-item">
                <div class="carousel-image-wrapper position-relative">
                    <img src="{{ asset('storage/img/top2.jpg') }}" class="d-block w-100 carousel-image" alt="2枚目">
                </div>
            </div>
            <div class="carousel-item">
                <div class="carousel-image-wrapper position-relative">
                    <img src="{{ asset('storage/img/海鮮丼.jpg') }}" class="d-block w-100 carousel-image" alt="3枚目">
                </div>
            </div>
        </div>
    </div>

<div class="container pt-2">
    @component('components.sidebar', ['categories' => $categories])
    @endcomponent

    <div class="mb-4">
        <h2>評価が高いお店</h2>
            <div class="row">
                @foreach ($recommended_shops as $recommended_shop)
                    <div class="col-md-3 mb-4">
                        <a href="{{ route('shops.show', $recommended_shop) }}">
                            @if ($recommended_shop->image !== "")
                                <img src="{{ asset('storage/' . $recommended_shop->image) }}" class="img-thumbnail samuraimart-product-img-detail">
                            @else
                                <img src="{{ asset('img/dummy.png')}}" class="img-thumbnail samuraimart-product-img-recommend">
                            @endif
                        </a>
                            <p class="samuraimart-product-label mt-2">
                            <a href="{{ route('shops.show', $recommended_shop) }}" class="link-dark" style="text-decoration: none;">{{ $recommended_shop->name }}</a><br>
                                <span class="review-color">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= round($recommended_shop->reviews_avg_score))
                                            ★
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                    ({{ number_format($recommended_shop->reviews_avg_score, 1) }})
                                </span>
                            </p>
                    </div>
                @endforeach
            </div>
    </div>

           
    <div class="mb-4">
       <h2>新規掲載店舗</h2>
          <div class="text-end mb-2">
            <a href="{{ route('shops.index', ['sort' => 'id', 'direction' => 'desc']) }}">もっと見る</a>
          </div>
                <div class="row">
                    {{--新着店舗を繰り返し処理で表示--}}
                    @foreach ($recently_shops as $recently_shop)
                        <div class="col-md-3">
                            <a href="{{ route('shops.show', $recently_shop) }}">
                                {{--もし画像があれば表示。無ければ指定の画像を表示--}}
                                @if ($recently_shop->image !== "")
                                    <img src="{{ asset('storage/' . $recently_shop->image) }}" class="img-thumbnail samuraimart-product-img-detail">
                                @else
                                    <img src="{{ asset('img/dummy.png')}}" class="img-thumbnail samuraimart-product-img-products">
                                @endif
                            </a>
                                    <p class="samuraimart-product-label mt-2">
                                    <a href="{{ route('shops.show', $recently_shop) }}" class="link-dark" style="text-decoration: none;">{{ $recently_shop->name }}</a><br>
                                        <span class="review-color">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= round($recently_shop->reviews_avg_score))
                                                    ★
                                                @else
                                                    ☆
                                                @endif
                                            @endfor
                                            ({{ number_format($recently_shop->reviews_avg_score, 1) }})
                                        </span>
                                    </p>
                        </div>
                    @endforeach
                </div>
   </div>
</div>

@endsection