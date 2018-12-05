@extends('layouts.app')
@section('title', '訂單列表')
@section('content')
    <div class="container">
        <div class="card">

        </div>
    </div>
    @foreach($replies as $reply)
        {{$reply['id']}}
    @endforeach
    <div class="cr_pager">
        {{  $replies->render() }}
    </div>
@endsection
