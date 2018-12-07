@extends('layouts.app')
@section('title', '優惠券管理')
@section('cssheader')
    <link href="{{ asset('css/coupons.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="container">
        <table class="cr_table">
            <tr>
                <th>ID</th>
                <th>票券名稱</th>
                <th>折扣</th>
                <th>使用狀況</th>
                <th>有效時間</th>
                <th>建立時間</th>
                <th>管理功能</th>
            </tr>
            @foreach ($coupons as $coupon)
                <tr>
                    <td>{{ $coupon->id }}</td>
                    <td>{{ $coupon->Name }}</td>
                    <td>{{ $coupon->Discount }}</td>
                    @if ($coupon['Used'])
                        <td>已使用</td>
                    @else
                        <td>未使用</td>
                    @endif
                    <td>{{ $coupon->expired_at }}</td>
                    <td>{{ $coupon->created_at }}</td>
                    <td>
                        <a href="{{ route('coupon.edit', $coupon->id) }}" class="btn">編輯</a>
                        <form action="{{ route('coupon.destroy', $coupon->id) }}" method="post" style="display: inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-xs btn-danger">刪除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    <a class="floatBtn" href="{{ route('coupon.create') }}">+</a>

    <div class="cr_pager">
        {{  $coupons->render() }}
    </div>
@endsection
