@extends('layouts.app')
@section('title', '新增資料')
@section('content')
    <link href="{{asset('css/Monster.css')}}" rel="stylesheet" type="text/css">
    <form id="forms">
        <table>
            <tr>
                <td>
                    <label for="ATTACK"></label>
                </td>
                <td>
                    <input id="ATTACK" name="ATTACK" type="text" value="{{old('ATTACK',0)}}"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="DEFENSE"></label>
                </td>
                <td>
                    <input id="DEFENSE" name="DEFENSE" type="text" value="{{old('DEFENSE',0)}}"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="HP"></label>
                </td>
                <td>
                    <input id="HP" name="HP" type="text" value="{{old('HP',0)}}"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="NAME"></label>
                </td>
                <td>
                    <input id="NAME" name="NAME" type="text" value="{{old('NAME',0)}}"/>
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
                <td>
                    <label for="SPEED"></label>
                </td>
                <td>
                    <input id="SPEED" name="SPEED" type="text" value="{{old('SPEED')}}"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="SP_ATTACK"></label>
                </td>
                <td>
                    <input id="SP_ATTACK" name="SP_ATTACK" type="text" value="{{old('SP_ATTACK',0)}}"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="SP_DEFENSE"></label>
                </td>
                <td>
                    <input id="SP_DEFENSE" name="SP_DEFENSE" type="text" value="{{old('SP_DEFENSE',0)}}"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="Description"></label>
                </td>
                <td>
                    <textarea id="Description" name="description">{{old('description')}}</textarea>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="Attributes"></label>
                </td>
                <td>
                    <select id="Attributes">
                        @foreach($attrs as $attr)
                            <option value="{{$attr['value']}}">{{$attr['NAME']}}</option>
                        @endforeach
                    </select>
                    <span id="addAttr"></span>
                    <div id="attr"></div>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="Price"></label>
                </td>
                <td>
                    <input id="Price" name="price" type="text" value="{{old('price',0)}}"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="Image"></label>
                </td>
                <td>
                    <input id="Image" name="image[]" type="file" multiple="true"/>
                    <div id="preImg"></div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div>
                        <input id="createMonster" type="button" value="送出"/>
                        <input type="reset" value="重置"/>
                    </div>
                </td>
            </tr>
        </table>
    </form>
    <script src="{{asset('js/Monster.js')}}"></script>
@endsection
