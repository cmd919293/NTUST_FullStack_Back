@extends('email.base')
@section('title', '登入錯誤')
@section('content')
    <div style="margin: 30px 50px;">
        <table style="width:40%;margin:20px auto;border: 3px solid black;border-radius: 20px">
            <tr>
                <th style="font-size: 50px;vertical-align: middle">
                   404
                </th>
            </tr>
        </table>
        <div style="margin: 0px auto;height: 5px;width:80% ;background-color: black;border: 0px solid transparent;border-radius: 1.5em
"> </div>
        <div class="reply_container" style="text-align: center">
            登入的使用者不正確,請重新登入
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                <button type="submit" class="sub_button">
                    切換使用者
                </button>
            </form>
        </div>

    </div>

@endsection
