@extends('layouts.app')

@section('content')
<div class="container pt-2">
<div class="row">
    <div class="col-md-2">
        @component('components.sidebar', ['categories' => $categories])
        @endcomponent
    </div>
   <div class="col">
            {{--カテゴリーの値が存在すれば、絞り込んでいるカテゴリー名、件数を表示--}}
            @if ($category !== null)
            <nav class="mb-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="{{ route('top') }}">トップ</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
              </ol>
            </nav>
                <h1>{{ $category->name }}の商品一覧<span class="ms-3">{{number_format($total_count)}}件</span></h1>
                {{--検索ワードの値が存在すれば、検索結果、件数を表示--}}
            @elseif ($keyword !== null)
            <nav class="mb-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="{{ route('top') }}">トップ</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">商品一覧
              </li>
              </ol>
            </nav>
                <h1>"{{ $keyword }}"の検索結果<span class="ms-3">{{number_format($total_count)}}件</span></h1>
            @else
            <nav class="mb-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('top') }}">トップ</a></li>
              <li class="breadcrumb-item active" aria-current="page">店舗一覧</li>
              </ol>
            </nav>
            <h1>店舗一覧<span class="ms-3">{{ number_format($total_count) }}件</span></h1>
            @endif
        </div>
        <div class="d-flex align-items-center mb-4">
            <span class="small me-2">並べ替え</span>
            {{--GETリクエストを送るフォーム(商品一覧にリクエストを送る)--}}
            <form method="GET" action="{{ route('shops.index') }}">
                {{--ユーザーがすでに カテゴリや検索キーワードでフィルターしている場合、並べ替えをしてもその条件を保持するようにする--}}
                @if ($category)
                    {{--hidden フィールドでデータを渡すことで、並べ替え時に カテゴリやキーワードがリセットされない ようにしてる--}}
                    <input type="hidden" name="category" value="{{ $category->id }}">
                @endif
                @if ($keyword)
                    <input type="hidden" name="keyword" value="{{ $keyword }}">
                @endif
                {{--name="select_sort"：選択した並べ替えの値を送る
                    onChange="this.form.submit();"：選択を変更すると 自動でフォームが送信される(ユーザーがボタンを押す必要なし)--}}
                <select class="form-select form-select-sm" name="select_sort" onChange="this.form.submit();">
                    {{--現在選択されている並べ替え方法 ($sorted) と一致する場合 → <option> に selected を付ける
                        それ以外は普通に <option> を作成--}}
                    @foreach ($sorts as $key => $value)
                        @if ($sorted === $value)
                            <option value="{{ $value }}" selected>{{ $key }}</option>
                        @else
                            <option value="{{ $value }}">{{ $key }}</option>
                        @endif
                    @endforeach
                </select>
            </form>
        </div>
           <div class="row">
               @foreach($shops as $shop)
               <div class="col-md-4 mb-3">
                   <a href="{{route('shops.show', $shop)}}">
                        {{--もし画像があれば表示。無ければ指定の画像を表示--}}
                        @if ($shop->image !== "")
                        <img src="{{ asset('img/' . $shop->image) }}" class="img-thumbnail samuraimart-product-img-detail">
                        @else
                        <img src="{{ asset('img/dummy.png')}}" class="img-thumbnail samuraimart-product-img-products">
                        @endif
                   </a>
                   <div class="row">
                       <div class="col-12">
                           <p class="samuraimart-product-label mt-2">
                             <a href="{{ route('shops.show', $shop) }}" class="link-dark">
                               {{$shop->name}}</a><br>
                                <br>
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
                           </p>
                       </div>
                   </div>
               </div>
               @endforeach
           </div>
          <div class="mb-4">
       {{--カテゴリーで絞り込んだ条件を保持してページングする--}}
       {{ $shops->appends(request()->query())->links() }}
       </div>
    </div>
  </div>
</div>
@endsection