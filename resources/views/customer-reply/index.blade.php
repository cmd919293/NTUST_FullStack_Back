@extends('../layouts.app')
@section('title', '客服中心')
@section('cssheader')
    <link href="{{ asset('css/customer-reply.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="cr_pager">
        {{  $replies->render() }}
    </div>

    <div class="container">
        <table class="cr_table">
            <tr>
                <th>ID</th>
                <th>USER</th>
                <th>RESOLVED</th>
                <th>PROPOSED AT</th>
                <th>REPLIED AT</th>
                <th></th>
            </tr>
                @foreach ($replies as $reply)
                <tr>
                    <td>{{ $reply->id }}</td>
                    <td>{{ $reply->User->name }}</td>
                    <td style="color: {{ $reply->resolved==true ? 'green':'red'}};">{{ $reply->resolved==false?"unresolved":"resolved" }}</td>
                    <td>{{ $reply->created_at }}</td>
                    @if($reply->resolved == true)
                        <td>{{$reply->updated_at}}</td>
                    @else
                        <td>Need Response</td>
                    @endif
                    <td >
                        <a href="{{route('customer-reply.reply',['id'=>$reply->id])}}">回覆</a>
                    </td>
                </tr>
                @endforeach
        </table>

    </div>




@endsection
