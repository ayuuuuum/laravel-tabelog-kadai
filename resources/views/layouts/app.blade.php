<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'NAGOYAMESHI') }}</title>

        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

        <!-- Font Awesome -->
        <script src="https://kit.fontawesome.com/32f39ed6d1.js" crossorigin="anonymous"></script>

        <link href="{{ asset('css/nagoyameshi.css') }}" rel="stylesheet">
    </head>
    <body>
        <div id="app" class="samuraimart-wrapper">
        {{--@component('components.header')で、作成したヘッダーファイルを呼び出し--}}
            @component('components.header')
            @endcomponent
            
            <main class="py-4">
            {{-- フラッシュメッセージ表示 --}}
            @if (session('flash_message'))
                <div class="container">
                    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                        {{ session('flash_message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif
            @yield('content')
            </main>

            {{--@component('components.footer')で、作成したフッターファイルを呼び出し--}}
            @component('components.footer')
            @endcomponent
        </div>

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    </body>
</html>
