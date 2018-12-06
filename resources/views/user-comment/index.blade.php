@extends('../layouts.app')
@section('title', '客服中心')
@section('cssheader')
    <link href="{{ asset('css/customer-reply.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="cr_pager">
        {{  $comments->render() }}
    </div>

    <div class="container">
        <table class="cr_table">
            <tr>
                <th>編號</th>
                <th>使用者名稱/ID</th>
                <th>產品名稱/ID</th>
                <th>評論內容</th>
                <th>評論日期</th>
                <th>更新日期</th>
                <th></th>
            </tr>
                @foreach ($comments as $comment)
                <tr>
                    <td>{{ $comment->id }}</td>
                    <td>{{ $comment->User->name}} / {{$comment->User->id }}</td>
                    <td>{{ $comment->Product->Names->NAME}} / {{$comment->Product->id }}</td>
                    <td>{{ $comment->Comment }}</td>
                    <td>{{ $comment->created_at }}</td>
                    <td>{{ $comment->updated_at }}</td>
                    <td >
                        <form action="{{route('user-comment.destroy',['userComment'=>$comment->id])}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="deleteBtn">刪除</button>
                        </form>
                    </td>
                </tr>
                @endforeach
        </table>

    </div>




@endsection
