<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Scripts -->
    <script src="{{ '/js/app.js' }}" defer></script>
    @yield('js')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ '/css/app.css' }}" rel="stylesheet">
    <link href="{{ '/css/utility.css' }}" rel="stylesheet">
    @yield('css')

</head>

<body>
    <div id="app">
        <!-- ヘッダー -->
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                {{ Auth::user()->name }}のNote
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    ログアウト
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="main container">
            <!-- フラッシュメッセージ -->
            @if(session('success'))
                <div class="alert alert-success mt-3" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row" style='height: 92vh;'>
                <div class="col-md-2 p-0">
                    <div class="card h-100">
                        <div class="card-header">タグ一覧</div>
                        <div class="card-body py-2 px-4 taglist">
                            <a class='d-block mb-3' href='/'>全て表示</a>
                            @if(!empty($tags))
                                @foreach($tags as $tag)
                                    <a href="/?tag={{ $tag['name'] }}"><p>{{ $tag['name'] }}</p></a>
                                @endforeach
                            @endif
                        </div>
                    </div>

                </div>
                <div class="col-md-4 p-0">
                    <div class="card h-100">
                        <div class="card-header d-flex">メモ一覧
                        <div class="ml-3 px-3 alert-info">
                        タグ：
                        @if(empty($tag_display))
                            全て
                        @else
                            {{$tag_display}}
                        @endif
                        </div> 
                        <a class='ml-auto' href='/create'><i class="fas fa-plus-circle"></i></a></div>
                        <div class="card-body p-2">
                            @if(!empty($memos))
                                @foreach($memos as $memo)
                                    <a href="/edit/{{ $memo['id'] }}"><p>{{ $memo['title'] }}</p></a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div> <!-- col-md-3 -->
                <div class="col-md-6 p-0">
                    @yield('content')
                </div>
            </div> <!-- row justify-content-center -->
        </main>
    </div>
    @yield('footer')

</body>

</html>