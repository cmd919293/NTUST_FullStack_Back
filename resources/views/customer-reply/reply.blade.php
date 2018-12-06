@extends('../layouts.app')
@section('title', '客服回覆')
@section('cssheader')
    <link href="{{ asset('css/customer-reply.css') }}" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Noto+Sans+TC|Noto+Serif+TC');
    </style>
@endsection
@section('content')
    <div class="reply_container">
        <div class="replyblock text">
            <p>客戶回報:</p>
            <textarea readonly="true" style="background-color: #ff000091;">{{$text}}</textarea>
        </div>
        <div class="replyblock">
            <p>客戶附圖:</p>
            <div class="img-scroll img-container">
            @for($i = 0 ; $i < $reply->imageNum ; $i++)
                <img src="{{$images[$i]}}" style="width:200px;display: inline-block"/>
            @endfor
            </div>
        </div>
        <div class="replyblock text">
            <p>客服回報:</p>
            <form  id="replyform" role="form" style=" height: 100%" method="post" action="{{route('customer-reply.update',$reply->id)}}">
                @csrf
                @method('PATCH')
                <textarea placeholder="輸入回覆" name="reply" style="background-color: #a9ff00a6;"> </textarea>
            </form>
            <div class="btnSend"><button type="submit"  form="replyform">回覆</button></div>
        </div>
    </div>

@endsection
