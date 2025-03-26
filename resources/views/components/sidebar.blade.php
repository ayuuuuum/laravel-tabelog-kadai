<div class="container">
       @foreach ($categories as $category)
              <div class="mb-3">
                {{--呼び出すルーティングの後に連想配列で変数を渡すことで、コントローラー側へ値を渡すことができる--}}
               <label class="samuraimart-sidebar-category-label"><a href="{{ route('shops.index', ['category' => $category->id]) }}" class="h6 link-dark text-decoration-none">{{ $category->name }}</a></label>
       @endforeach
</div>