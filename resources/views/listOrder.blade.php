@extends('layouts.app')
@section('title', '訂單列表')
@section('content')
    <div class="container">
        <div class="card"><input type="hidden" value="1">
            <div class="card-header">訂單列表</div>
            <div class="card-body p-0">
                <div class="d-table list-group-flush">
                    <div class="container d-table-row">
                        <span class="d-table-cell">#</span>
                        <span class="d-table-cell">地址</span>
                        <span class="d-table-cell">手機號碼</span>
                        <span class="d-table-cell">建立時間</span>
                        <span class="d-table-cell">出貨</span>
                    </div>
                    @foreach($replies as $reply)
                        <div class="container d-table-row">
                            <span class="d-table-cell">{{$reply['id']}}</span>
                            <span class="d-table-cell">{{$reply['Address']}}</span>
                            <span class="d-table-cell">{{$reply['Phone']}}</span>
                            <span class="d-table-cell">{{$reply['created_at']}}</span>
                            <span class="d-table-cell">{{$reply['Shipment']}}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="cr_pager">
        {{  $replies->render() }}
    </div>
@endsection
