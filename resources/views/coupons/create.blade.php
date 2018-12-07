@extends('layouts.app')
@section('title', '建立優惠券')
@section('content')
    <div>
        <div class="box-header with-border">
            <h3 class="box-title">建立優惠券</h3>
        </div>
        <form action="{{ route('coupon.store') }}" method="post">
            @csrf

            <div>
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-ban"></i> 錯誤！</h4>
                        請修正以下表單錯誤：
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-group">
                    <label for="title">名稱</label>
                    <input type="text" class="form-control" id="title" name="Name" placeholder="請輸入名稱" value="{{ old('Name') }}">
                </div>
                <div class="form-group">
                    <label for="title">折扣</label>
                    <input type="number" class="form-control" id="title" name="Discount" placeholder="請輸入折扣" value="{{ old('Discount') }}">
                </div>
                <div class="form-group">
                    <label for="title">優惠碼</label>
                    <input type="text" class="form-control" id="title" name="Token" placeholder="請輸入優惠碼" value="{{ old('Token') }}">
                </div>
                <div class="form-group">
                    <label for="title">有效期限</label>
                    <input type="datetime-local" class="form-control" id="title" name="expired_at" placeholder="請輸入有效期限" value="{{ old('expired_at') }}">
                </div>
            </div>

            <div class="box-footer text-right">
                <a class="btn btn-link" href="{{ route('coupon.index') }}">取消</a>
                <button type="submit" class="btn btn-primary">建立</button>
            </div>
        </form>
    </div>
@endsection
