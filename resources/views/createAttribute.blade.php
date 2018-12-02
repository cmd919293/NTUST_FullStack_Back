@extends('layouts.app')
@section('title', '新增屬性')
@section('content')
    <link href="{{asset('css/Monster.css')}}" rel="stylesheet" type="text/css">
    <form id="forms">
        <table>
            <tr>
                <td>
                    <label for="NAME"></label>
                </td>
                <td>
                    <input id="NAME" name="NAME" type="text" value="{{old('NAME')}}"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="NAME_EN"></label>
                </td>
                <td>
                    <input id="NAME_EN" name="NAME_EN" type="text" value="{{old('NAME_EN')}}"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="NAME_JP"></label>
                </td>
                <td>
                    <input id="NAME_JP" name="NAME_JP" type="text" value="{{old('NAME_JP')}}"/>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div>
                        <input id="createAttribute" type="button" value="送出"/>
                        <input type="reset" value="重置"/>
                    </div>
                </td>
            </tr>
        </table>
    </form>
    <script src="{{asset('js/Attribute.js')}}"></script>
@endsection
