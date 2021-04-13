@extends('layouts.app')
@section('title','搜尋樣本')
@section('content')
    @parent
    <form method="POST" action="/searchSample">
        @csrf
        <p>
            <label>
            搜尋欄位：
            <select name="select">
              <option value="id">樣本戶</option>
              <option value="name">姓名</option>
              <option value="liname">村里名稱</option>
              <option value="updatetime">更新日期</option>
            </select>
            </label>
            <label>
            <input name="value" type="text" id="value" />
            </label>
            <label>
            <input type="submit" name="Submit" value="查詢" />
            </label>
          </p>
    </form>
    <hr>
    @if (!empty($select))
        以{{$select}}查詢{{$value}}。
        @foreach ($list as $samples)
            {{$samples->name}}
        @endforeach
    @endif
    
@endsection