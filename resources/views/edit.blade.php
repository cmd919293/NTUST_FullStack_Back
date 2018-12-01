@extends('layouts.app')
@section('title', '修改資料')
@section('content')
    <link href="{{asset('css/Monster.css')}}" rel="stylesheet" type="text/css">
    <form id="forms">
        <table>
            <tr>
                <td>
                    <label for="ATTACK"></label>
                </td>
                <td>
                    <input id="ATTACK" name="ATTACK" type="text" value="{{old('ATTACK',$monster['ATTACK'])}}"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="DEFENSE"></label>
                </td>
                <td>
                    <input id="DEFENSE" name="DEFENSE" type="text" value="{{old('DEFENSE',$monster['DEFENSE'])}}"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="HP"></label>
                </td>
                <td>
                    <input id="HP" name="HP" type="text" value="{{old('HP',$monster['HP'])}}"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="NAME"></label>
                </td>
                <td>
                    <input id="NAME" name="NAME" type="text" value="{{old('NAME',$monster['NAME'])}}"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="NAME_EN"></label>
                </td>
                <td>
                    <input id="NAME_EN" name="NAME_EN" type="text" value="{{old('NAME_EN',$monster['NAME_EN'])}}"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="NAME_JP"></label>
                </td>
                <td>
                    <input id="NAME_JP" name="NAME_JP" type="text" value="{{old('NAME_JP',$monster['NAME_JP'])}}"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="SPEED"></label>
                </td>
                <td>
                    <input id="SPEED" name="SPEED" type="text" value="{{old('SPEED',$monster['SPEED'])}}"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="SP_ATTACK"></label>
                </td>
                <td>
                    <input id="SP_ATTACK" name="SP_ATTACK" type="text"
                           value="{{old('SP_ATTACK',$monster['SP_ATTACK'])}}"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="SP_DEFENSE"></label>
                </td>
                <td>
                    <input id="SP_DEFENSE" name="SP_DEFENSE" type="text"
                           value="{{old('SP_DEFENSE',$monster['SP_DEFENSE'])}}"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="Description"></label>
                </td>
                <td>
                    <textarea id="Description"
                              name="description">{{old('description',$monster['description'])}}</textarea>
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
                    <input id="Price" name="price" type="text" value="{{old('price',$monster['price'])}}"/>
                </td>
            </tr>
            <tr>
                <td><label for="Original Image"></label></td>
                <td>
                    <div id="oriImg">
                    @for($i = 0; $i < $monster['imgNum']; $i++)
                        <span>{{$i}}</span>
                    @endfor
                    </div>
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
                        <input type="button" value="送出"/>
                        <input type="reset" value="重置"/>
                    </div>
                </td>
            </tr>
        </table>
    </form>
    <script src="{{asset('js/Monster.js')}}"></script>
@endsection
