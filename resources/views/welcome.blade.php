<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pokemon Shop</title>
    <script src="{{asset('js/login.js')}}"></script>
    @auth
    <script src="{{asset('js/logout.js')}}"></script>
    @endauth
<!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        @auth
        .user + a {
            display: none;
            position: inherit;
            right: 0;
            top: calc(5px + 1rem);
            border: 1px solid #ccc;
            line-height: 2;
            border-radius: .25rem;
        }

        .user:hover + a {
            display: initial;
        }

        .user + a:hover {
            display: initial;
        }
        @endauth
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">
            @auth
                @if(auth()->user()->permission==0)
                    <a href="{{ url('/Coupon') }}">Coupon</a>
                    <a href="{{ url('/customer-reply') }}">Customer Reply</a>
                    <a href="{{ url('/home') }}">Pokemon Index</a>
                    <a href="{{ url('/Attribute') }}">Attribute Index</a>
                    <a href="{{ url('/OrderList') }}">Order List</a>
                    <a href="{{ url('/comment') }}">Comments</a>
                @endif
                <a href="#" class="user">{{ Auth::user()->name }}</a>
                <a id="logoutBtn" href="#">{{ __('Logout') }}</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                      style="display: none;">
                    @csrf
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @endauth
        </div>
    @endif

    <div class="content">
        <div class="title m-b-md">
            Pokemon Shop
        </div>

        <div class="links">
            <a href="https://hackmd.io/d6qSA7tYQHq0jXjzM_-YkQ">Documentation</a>
            <a href="https://github.com/cmd919293/NTUST_FullStack_Back">GitHub</a>
            @auth
                <a href="{{ url('/home') }}">Pokemon Index</a>
                <a href="{{ url('/Attribute') }}">Attribute Index</a>
                <a href="{{ url('/OrderList') }}">Order List</a>
            @endauth
        </div>
    </div>
</div>
</body>
</html>
