@extends('layouts.app')

@section('content')
    <div class="container pt-2">
    @if (session('flash_message'))
        <div class="row mb-2">
            <div class="col-12">
                <div class="alert alert-light">
                {{ session('flash_message') }}
                </div>
            </div>
        </div>
    @endif
        <div class="row">
            <div class="col-md-2">
            @component('components.sidebar', ['categories' => $categories])
            @endcomponent
        </div>
        <div class="col">
            <div class="mb-4">
            <h2>おすすめ店舗</h2>
                <div class="row">
                @foreach ($recommended_shops as $recommended_shop)
                <div class="col-md-4">
                    <a href="{{ route('shops.show', $recommended_shop) }}">
                @if ($recommended_shop->image !== "")
                    <img src="{{ asset('img/' . $recommended_shop->image) }}" class="img-thumbnail samuraimart-product-img-detail">
                    {{--<img src="{{ asset('storage/' . $recommended_shop->image) }}" class="img-thumbnail samuraimart-product-img-recommend" alt="Shop Image">--}}
                @else
                    <img src="{{ asset('img/dummy.png')}}" class="img-thumbnail samuraimart-product-img-recommend">
                @endif
            </a>
            <div class="row">
                <div class="col-12">
                    <p class="samuraimart-product-label mt-2">
                        <a href="{{ route('shops.show', $recommended_shop) }}" class="link-dark">{{ $recommended_shop->name }}</a>
                        <br>
                        <span>
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
            </div>
        </div>
    @endforeach
    </div>
</div>
           
      <div class="mb-4">
       <h2>新着商品</h2>
       {{--値がidのsortパラメータと、値がdescのdirectionパラメータを連想配列で指定
        「IDが大きい順」に並んだ状態の店舗一覧ページに遷移させる--}}
        <a href="{{ route('shops.index', ['sort' => 'id', 'direction' => 'desc']) }}">もっと見る</a>
       <div class="row">
            {{--新着店舗を繰り返し処理で表示--}}
            @foreach ($recently_shops as $recently_shop)
                <div class="col-md-3">
                    <a href="{{ route('shops.show', $recently_shop) }}">
                        {{--もし画像があれば表示。無ければ指定の画像を表示--}}
                        @if ($recently_shop->image !== "")
                        <img src="{{ asset('img/' . $recently_shop->image) }}" class="img-thumbnail samuraimart-product-img-detail">
                        {{--<img src="{{ asset('storage/' . $recently_shop->image) }}" class="img-thumbnail samuraimart-product-img-products" alt="Shop Image">--}}
                        @else
                        <img src="{{ asset('img/dummy.png')}}" class="img-thumbnail samuraimart-product-img-products">
                        @endif
                    </a>
                    <div class="row">
                        <div class="col-12">
                            <p class="samuraimart-product-label mt-2">
                                <a href="{{ route('shops.show', $recently_shop) }}" class="link-dark">{{ $recently_shop->name }}</a><br>
                                <br>
                                <span>
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
                    </div>
                </div>
            @endforeach
       </div>
   </div>
</div>
@endsection