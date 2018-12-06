@extends('email.base')
@section('title', '客服回應')
@section('content')
    <div style="margin: 30px 50px;">
        <table style="width:40%;margin:20px auto;border: 3px solid black;border-radius: 20px">
            <tr>
                <th style="font-size: 50px;vertical-align: middle">
                    客服中心
                </th>
            </tr>
        </table>
        <div style="margin: 0px auto;height: 5px;width:80% ;background-color: black;border: 0px solid transparent;border-radius: 1.5em
"> </div>
        <div class="reply_container">
            <p> 嗨 <span style="font-size: 25px;font-weight: bold;">{{ $customerReply->User->name  }} </span>!</p>
            <p>我們已經接收到您提出的客服訊息:</p>
            <div class="reply_block customer">
                <p>{{$text}}</p>
                @foreach($images as $image)
                    <image style="display: inline-block;width: 33%;"  src="{{$image}}"></image>
                @endforeach
            </div>
            <p>以下是我們的回應:</p>
            <div class="reply_block manager">
                <p>{{$reply}}</p>
            </div>

        </div>

    </div>
@endsection
