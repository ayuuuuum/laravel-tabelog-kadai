@extends('layouts.app')

@section('content')
    <div class="container pt-5">
        <div class="row justify-content-center mb-4">
            <div class="col-lg-5">

            <h1>マイページ</h1>

            @if (session('flash_message'))
            <div class="alert alert-light">
                {{ session('flash_message') }}
            </div>
            @endif
        <div class="container">
           <div class="d-flex justify-content-between">
               <div class="row">
                   <div class="col-2 d-flex align-items-center">
                       <i class="fas fa-user fa-3x"></i>
                   </div>
                   <div class="col-9 d-flex align-items-center ms-2 mt-3">
                       <div class="d-flex flex-column">
                           <label for="user-name">会員情報の編集</label>
                           <p>アカウント情報の編集</p>
                       </div>
                   </div>
               </div>
               <div class="d-flex align-items-center">
                   <a href="{{route('mypage.edit')}}">
                       <i class="fas fa-chevron-right fa-2x"></i>
                   </a>
               </div>
           </div>
       </div>

       <hr>

       {{-- 有料会員でない場合に有料会員登録ページを表示 --}}
       @if (!auth()->user()->subscribed('default'))
       <div class="container">
           <div class="d-flex justify-content-between">
               <div class="row">
                   <div class="col-2 d-flex align-items-center">
                       <i class="fas fa-user fa-3x"></i>
                   </div>
                   <div class="col-9 d-flex align-items-center ms-2 mt-3">
                       <div class="d-flex flex-column">
                           <label for="user-name">有料会員登録</label>
                           <p>有料会員登録が出来ます</p>
                       </div>
                   </div>
               </div>
               <div class="d-flex align-items-center">
                   <a href="{{route('mypage.show_subscription')}}">
                       <i class="fas fa-chevron-right fa-2x"></i>
                   </a>
               </div>
           </div>
       </div>

       <hr>

       @else
       {{-- 有料会員の場合に予約一覧ページ、お気に入り一覧ページを表示 --}}
       <div class="container">
           <div class="d-flex justify-content-between">
               <div class="row">
                   <div class="col-2 d-flex align-items-center">
                       <i class="fas fa-calendar-check fa-3x"></i>
                   </div>
                   <div class="col-9 d-flex align-items-center ms-2 mt-3">
                       <div class="d-flex flex-column">
                           <label for="user-name">予約一覧</label>
                           <p>あなたの予約履歴を確認できます</p>
                       </div>
                   </div>
               </div>
               <div class="d-flex align-items-center">
                   <a href="{{route('users.reservate')}}">
                       <i class="fas fa-chevron-right fa-2x"></i>
                   </a>
               </div>
           </div>
       </div>
       
        <hr>

        <div class="container">
           <div class="d-flex justify-content-between">
               <div class="row">
                   <div class="col-2 d-flex align-items-center">
                       <i class="fas fa-heart fa-3x"></i>
                   </div>
                   <div class="col-9 d-flex align-items-center ms-2 mt-3">
                       <div class="d-flex flex-column">
                           <label for="user-name">お気に入り店舗一覧</label>
                           <p>お気に入りに登録した店舗を確認できます</p>
                       </div>
                   </div>
               </div>
               <div class="d-flex align-items-center">
                   <a href="{{route('mypage.favorite')}}">
                       <i class="fas fa-chevron-right fa-2x"></i>
                   </a>
               </div>
           </div>
       </div>
    
       <hr>
       @endif

       <div class="container">
        <div class="d-flex justify-content-between">
            <div class="row">
                <div class="col-2 d-flex align-items-center">
                    <i class="fas fa-ban fa-3x"></i>
                </div>
                <div class="col-9 d-flex align-items-center ms-2 mt-3">
                    <div class="d-flex flex-column">
                        <label for="user-name">有料会員解約</label>
                        <p>有料会員を解約します</p>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <a href="{{ route('mypage.cancel_subscription') }}">
                    <i class="fas fa-chevron-right fa-2x"></i>
                </a>
            </div>
        </div>

        <hr>

    </div>


       <div class="container">
            <div class="d-flex justify-content-between">
                <div class="row">
                    <div class="col-2 d-flex align-items-center">
                        <i class="fas fa-lock fa-3x"></i>
                    </div>
                    <div class="col-9 d-flex align-items-center ms-2 mt-3">
                        <div class="d-flex flex-column">
                            <label for="user-name">パスワード変更</label>
                            <p>パスワードを変更します</p>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <a href="{{ route('mypage.edit_password') }}">
                        <i class="fas fa-chevron-right fa-2x"></i>
                    </a>
                </div>
            </div>
        </div>

        <hr>

       <div class="container">
           <div class="d-flex justify-content-between">
               <div class="row">
                   <div class="col-2 d-flex align-items-center">
                       <i class="fas fa-sign-out-alt fa-3x"></i>
                   </div>
                   <div class="col-9 d-flex align-items-center ms-2 mt-3">
                       <div class="d-flex flex-column">
                           <label for="user-name">ログアウト</label>
                           <p>ログアウトします</p>
                       </div>
                   </div>
               </div>
               <div class="d-flex align-items-center">
                    {{--ログアウトをクリックすることでフォームをsubmitできる。
                        event.preventDefault();とすることで、リンクがクリックされたときにページ移動することを防ぐ。
                        document.getElementById('logout-form').submit();でID指定でsubmit--}}
                   <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                       <i class="fas fa-chevron-right fa-2x"></i>
                   </a>

                   {{--styleにdisplay: none;と指定することで見えなくしている--}}
                   <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                       @csrf
                   </form>
               </div>
           </div>
       </div>

       <hr>
       </div>
   </div>
</div>
@endsection