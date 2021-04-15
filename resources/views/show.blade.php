@extends('layouts.app')
@section('title','樣本')
@section('content')
<h3>樣本資訊</h3>
  <table width="100%" border="0">
    <tr>
      <td width="9%">樣本編號：</td>
      <td width="10%"> </td>
      <td width="15%">樣本代號：</td>
      <td>樣本狀態：</td>
      <td>通知/訪函：</td>
      <td width="15%"><div align="right"><a href="#">修改</a></div></td>
      <td width="21%"><div align="right"><a href="javascript:window.close();">關閉視窗</a></div></td>
    </tr>
    <tr>
      <td colspan="7"><table width="100%" border="1">
        <tr>
          <th colspan="18" scope="col">訪問結果</th>
          </tr>
        <tr>
            @foreach ($surveyTimes as $item)
                <td align="center" valign="middle">{{$item}}</td>
            @endforeach
        </tr>
        <tr>
            @foreach ($surveyTimes as $item)
            <td align="center" valign="middle"> </td>
            @endforeach
        </tr>
      </table></td>
    </tr>
    <tr>
      <td colspan="2">姓名：</td>
      <td>性別：</td>
      <td width="15%">出生年月：/</td>
      <td width="15%">婚姻狀態：</td>
      <td> </td>
      <td> </td>
    </tr>
    <tr>
      <td height="28" colspan="7">家中電話：</td>
    </tr>
    <tr>
      <td colspan="7">公司電話：</td>
    </tr>
    <tr>
      <td colspan="7">手機：</td>
    </tr>
    <tr>
      <td colspan="7">主地址村里：(  )</td>
    </tr>
    <tr>
      <td>主地址：</td>
      <td colspan="6"><? echo $mainadd; ?></td>
    </tr>
    <tr>
      <td>住家地址： </td>
      <td colspan="6"> </td>
    </tr>
    <tr>
      <td>公司地址：</td>
      <td colspan="6"> </td>
    </tr>
    <tr>
      <td>其他地址：</td>
      <td colspan="6"> </td>
    </tr>
    <tr>
      <td colspan="7">Email： </td>
    </tr>
    <tr>
      <td>註記：</td>
      <td colspan="6" rowspan="2"> </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>內部註記：</td>
      <td colspan="6"> </td>
    </tr>
  </table>
@endsection