<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>@yield('title') | {{ config('app.name', 'Laravel') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Abril+Fatface" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/email.css') }}" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Noto+Sans+TC|Noto+Serif+TC');
        @import url('https://fonts.googleapis.com/css?family=Bungee');
        .container{
            position: relative;
            margin: 0px auto;
            width: 60%;
            margin-top: 100px;
        }
        .email_logo{
            position: relative;
            max-width: 500px;
            height: 100px;
            margin: 0 auto;
            font-family: 'Nunito', cursive;
        }
        .logo_table {
            width:100%;
            height: 100%;
            border: 3px solid white;
            border-radius: 1em;
        }
        .logo_row{
            width: 100%;
            border: 3px solid white;
        }
        .logo{
            width: 25%;
            vertical-align: middle;
            text-align: right;
        }
        .logo_title{
            color: white;
            font-size: 60px;
            vertical-align: middle;
            font-weight: 500;
        }

        .email_content{
            background-color: #ffffff;
            border: 1px solid transparent;;
            border-radius: 10px;
            margin-top: 30px;
        }


        .reply_container{
            font-family: 'Noto Sans TC', sans-serif;
            font-size: 16px;
            width:80%;
            margin: 0px auto;
            padding: 10px 30px;
            font-color: #191818;
        }

        .reply_block {
            padding: 15px;
            margin-left: 30px;
            margin-top:10px;
            margin-right:50px;
            border: 0px solid transparent;
            border-radius:1.5em;

        }

        .customer{
            background-color: rgba(255,0,0,0.7);
        }

        .manager{
            background-color: rgba(0,255,0,0.7);
        }

        .footer{
            margin: 10px auto;
            max-width: 80%;
            text-align: center;
        }
        .footer .nav_text{
            margin:5px 20px;
            text-align: center;
            color:white;
            font-size: 23px;

            font-family: 'Bungee', sans-serif;
            /*font-family: 'Noto Sans TC',*/
        }

        .footer .nav_text a{
            color:inherit;
            font-weight: 500;
            text-decoration: none;
        }

        .footer .nav_text a:hover{
            color:gray;
            text-decoration: none;
        }


        body{
            background-color: black;

        }

    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
        <div class="container">

            <div class="email_logo">
                    <table class="logo_table">
                        <tr class="logo_row">
                            <td class="logo"><img style="width: 70px;" class="logo" src="http://localhost:8000/storage/img/logo/pokeball_spec_colored.png"/></td>
                            <td class="logo_title">POKESHOP</td>
                        </tr>
                    </table>
            </div>
            <div class="email_content">
                @yield('content')
            </div>

            <div class="footer" style="">
                <div style="width:100%;background:white;height: 1px;border: 2px solid transparent;border-radius: 1.5em;"></div>
                <span  class="nav_text">
                    <a href="http://localhost:4200/" >
                        SHOP
                    </a>
                </span>
                <span  class="nav_text">
                    <a href="http://localhost:4200/" >
                        CONTACT US
                    </a>
                </span>
            </div>
        </div>
</body>
