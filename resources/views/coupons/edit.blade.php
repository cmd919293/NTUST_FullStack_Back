@extends('layouts.app')
@section('title', '優惠券編輯')
@section('content')
<div>
    <div class="box-header with-border">
        <h3 class="box-title">優惠券編輯</h3>
    </div>
    <form action="{{ route('coupon.update', $coupon->id) }}" method="post">
        @csrf
        @method('PATCH')

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
                    <input type="text" class="form-control" id="title" name="Name" placeholder="請輸入名稱" value="{{ old('Name', $coupon->Name) }}">
                </div>
                <div class="form-group">
                    <label for="title">擁有者ID</label>
                    <input type="number" class="form-control" id="title" name="UserId" placeholder="請輸入擁有者ID" value="{{ old('UserId', $coupon->UserId) }}">
                </div>
                <div class="form-group">
                    <label for="title">訂單ID</label>
                    <input type="number" class="form-control" id="title" name="OrderId" placeholder="請輸入訂單ID" value="{{ old('OrderId', $coupon->OrderId) }}">
                </div>
                <div class="form-group">
                    <label for="title">折扣</label>
                    <input type="number" class="form-control" id="title" name="Discount" placeholder="請輸入折扣" value="{{ old('Discount', $coupon->Discount) }}">
                </div>
                <div class="form-group">
                    <label for="title">優惠碼</label>
                    <input type="text" class="form-control" id="title" name="Token" placeholder="請輸入優惠碼" value="{{ old('Token', $coupon->Token) }}">
                </div>
                <div class="form-group">
                    <label for="title">有效期限</label>
                    <input type="datetime-local" class="form-control" id="title" name="expired_at" placeholder="請輸入有效期限" value="{{ old('expired_at', $coupon->expired_at->format('Y-m-d\TH:i')) }}">
                </div>
                <div class="form-group">
                    <label for="title">是否被擁有</label>
                    <input type="number" class="form-control" id="title" name="Owned" placeholder="請輸入是否被擁有" value="{{ old('Owned', $coupon->Owned) }}">
                </div>
                <div class="form-group">
                    <label for="title">是否被使用過</label>
                    <input type="number" class="form-control" id="title" name="Used" placeholder="請輸入是否被使用過" value="{{ old('Used', $coupon->Used) }}">
                </div>
        </div>

        <div class="box-footer text-right">
            <a class="btn btn-link" href="#">取消</a>
            <button type="submit" class="btn btn-primary">更新</button>
        </div>
    </form>
</div>
@endsection
