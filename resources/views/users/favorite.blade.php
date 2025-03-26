@extends('layouts.app')

@section('content')
<div class="container pt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <h1>お気に入り</h1>

       <hr class="my-4">

       @if ($favorite_shops->isEmpty())
        <div class="row">
            <p class="mb-0">お気に入りはまだ追加されていません。</p>
        </div>

        @else
            {{--お気に入り店舗を繰り返し処理で表示--}}
           @foreach ($favorite_shops as $favorite_shop)
               <div class="row align-items-center mb-2">
                   <div class="col-md-2">
                        {{--クリックすると店舗詳細へ画面遷移--}}
                       <a href="{{ route('shops.show', $favorite_shop->id) }}">
                            {{--もし画像があれば表示。無ければ指定の画像を表示--}}
                            @if ($favorite_shop->image !== "")
                            <img src="{{ asset('storage/' . $favorite_shop->image) }}" class="img-thumbnail samuraimart-product-img-cart"> {{--alt="Shop Image"--}}
                            @else
                            <img src="{{ asset('img/dummy.png')}}" class="img-thumbnail samuraimart-product-img-cart">
                            @endif
                       </a>
                       <div class="col-md-6">
                            {{--店舗名と値段を表示--}}
                           <h5 class="w-100 samuraimart-favorite-item-text"><a href="{{ route('shops.show', $favorite_shop->id) }}" class="link-dark">{{ $favorite_shop->name }}</a></h5>
                           <h6 class="w-100 samuraimart-favorite-item-text mb-0">￥{{ number_format($favorite_shop->price) }}</h6>
                       </div>
               <div class="col-md-1">
                    {{--route('favorites.destroy', $favorite_shop->id)= 削除用のルートURLを取得--}}
                    <form id="favorites-destroy-form" action="{{ route('favorites.destroy', $favorite_shop->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                        <button type="submit" class="btn btn-link link-dark text-decoration-none">
                            削除
                        </button>
                    </form>
                </div>
           @endforeach
        @endif
       </div>

       <hr class="my-4">

        <div class="mb-4">
            {{ $favorite_shops->links() }}
        </div>
       </div>
   </div>
</div>
@endsection