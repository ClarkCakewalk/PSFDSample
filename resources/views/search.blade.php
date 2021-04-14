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
              <option value="sampleId">樣本戶</option>
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
    @if (!@empty($select))
        @if (!empty($list))
            
            <p>查詢結果共有{{count($list)}}筆。 </p>
            <table width="100%" border="1">
                <tr>
                <th scope="col">樣本編號</th>
                <th scope="col">問卷別</th>
                <th scope="col">姓名</th>
                <th scope="col">性別</th>
                <th scope="col">出生年/月</th>
                <th scope="col">所屬村里</th>
                <th scope="col">狀態</th>
                <th scope="col">20結果</th>
                <th scope="col">18結果</th>
                <th scope="col">16結果</th>
                </tr>
            @foreach ($list as $samples)
                <tr>
                    <td><div align="center"><a href="{{ url('show/'.$samples->sampleId)}}" target="_blank">{{$samples->sampleId}}</a></div></td>
                    <td><div align="center">{{$samples->quesName}} </div></td>
                    <td><div align="center">{{$samples->name}} </div></td>
                    <td><div align="center">{{$samples->gender}} </div></td>
                    <td><div align="center">{{$samples->birthYear}}/{{$samples->birthMonth}} </div></td>
                    <td><div align="center">{{$samples->liname}} </div></td>
                    <td><div align="center">{{$samples->status}} </div></td>
                    <td><div align="center">{{$samples->last1}} </div></td>
                    <td><div align="center">{{$samples->last2}} </div></td>
                    <td><div align="center">{{$samples->last3}} </div></td>
                </tr>      
            @endforeach
        </table>   
        @else
            <p>無 {{$select}}為{{$value}}的樣本</p>  
        @endif
    @endif
@endsection