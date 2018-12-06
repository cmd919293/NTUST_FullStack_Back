@extends('layouts.app')
@section('title', '優惠券管理')
@section('content')
<div>
    <table>
        <tr>
            <th>id</th>
            <th>票券名稱</th>
            <th>有效時間</th>
            <th>建立時間</th>
            <th>管理功能</th>
        </tr>
        @foreach ($coupons as $coupon)
            <tr>
                <td>{{ $coupon->id }}</td>
                <td>{{ $coupon->Name }}</td>
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
@endsection
