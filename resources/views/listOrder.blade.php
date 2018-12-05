@extends('layouts.app')
@section('title', '訂單列表')
@section('content')
    <div class="cr_pager">
        {{  $replies->render() }}
    </div>
@endsection
