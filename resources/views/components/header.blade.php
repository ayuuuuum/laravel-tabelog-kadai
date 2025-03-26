<header>
   <nav class="navbar navbar-expand-md navbar-light shadow-sm samuraimart-header-container h-auto">
   <div class="container">
       <a class="navbar-brand logo-text" href="{{ url('/') }}">
           {{ config('app.name', 'NAGOYAMESHI') }}
       </a>
       <form action="{{ route('shops.index') }}" method="GET">
           <div class="d-flex">
               <input class="form-control samuraimart-header-search-input me-1" placeholder="何をお探しですか？" name="keyword">
               <button type="submit" class="btn samuraimart-header-search-button"><i class="fas fa-search samuraimart-header-search-icon"></i></button>
           </div>
       </form>
       <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
           <span class="navbar-toggler-icon"></span>
       </button>

       <div class="collapse navbar-collapse" id="navbarSupportedContent">
           <ul class="navbar-nav ms-auto">
                {{--ログインしていない場合の処理--}}
               @guest
                   <li class="nav-item me-4">
                       <a class="nav-link fw-bold" href="{{ route('register') }}">新規登録</a>
                   </li>
                   <li class="nav-item me-4">
                       <a class="nav-link fw-bold" href="{{ route('login') }}">ログイン</a>
                   </li>

                   <div class="vr me-4 samuraimart-vertical-bar"></div>

                   <li class="nav-item me-4">
                       <a class="nav-link" href="{{ route('login') }}"><i class="far fa-heart"></i></a>
                   </li>
                   <li class="nav-item">
                       <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-shopping-cart"></i></a>
                   </li>
               {{--ログインしている場合の処理--}}
               @else
                   <li class="nav-item me-4">
                    {{--マイページへのリンクを表示--}}
                       <a class="nav-link fw-bold" href="{{ route('mypage') }}">
                   <i class="fas fa-user me-2"></i>マイページ</a>
                   </li>

                   <div class="vr me-4 samuraimart-vertical-bar"></div>

                   <li class="nav-item me-4">
                        {{--お気に入り店舗一覧へのリンクを表示--}}
                       <a class="nav-link" href="{{ route('mypage.favorite') }}">
                   <i class="far fa-heart"></i>
                       </a>
                   </li>
               @endguest
           </ul>
       </div>
   </div>
  </nav>
</header>