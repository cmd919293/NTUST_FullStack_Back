@extends('layouts.app')
@section('title', '訂單列表')
@section('content')
    <div class="container">
        <table class="card">
            <thead class="card-header">
            <tr>
                <th colspan="5">訂單列表</th>
            </tr>
            </thead>
            <tbody class="card-body p-0">
            <tr>
                <td class="order-cell order-id">#</td>
                <td class="order-cell order-address">地址</td>
                <td class="order-cell order-phone">手機號碼</td>
                <td class="order-cell order-createdAt">建立時間</td>
                <td class="order-cell order-shipment">出貨狀況</td>
            </tr>
            @foreach($orders as $orderId => $order)
                <tr>
                    <td class="order-cell">{{$orderId}}</td>
                    <td class="order-cell">{{$order['Address']}}</td>
                    <td class="order-cell">{{$order['Phone']}}</td>
                    <td class="order-cell">{{$order['createdAt']}}</td>
                    <td class="order-cell">
                        <input type="button" value="{{$order['Shipment'] ? '已出貨' : '未出貨'}}" readonly="readonly"
                               class="order-shipment-status">
                        <label for="order{{$orderId}}" class="order-show-items"></label>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <input type="radio" id="order{{$orderId}}" name="items">
                        <table class="item-table">
                            <thead>
                            <tr>
                                <td class="item-cell item-id">#</td>
                                <td class="item-cell item-img">圖片</td>
                                <td class="item-cell item-price">單價</td>
                                <td class="item-cell item-count">數量</td>
                                <td class="item-cell item-total">總價</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order['items'] as $index => $item)
                                <tr>
                                    <td class="item-cell">{{$index + 1}}</td>
                                    <td class="item-cell">
                                        <img width="100" height="100" src="{{$item['Icon']['src']}}">
                                    </td>
                                    <td class="item-cell">{{$item['Price']}}</td>
                                    <td class="item-cell">x{{$item ['Count']}}</td>
                                    <td class="item-cell">{{$item['Price'] * $item['Count']}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="5">
                                    <div class="footer-form">
                                        <button{{$order['Shipment'] ? ' disabled' : ''}}>出貨</button>
                                        <label for="#0">關閉</label>
                                        <input type="hidden" name="id" value="{{$orderId}}" />
                                    </div>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <input type="radio" id="#0" name="items"/>
@endsection
