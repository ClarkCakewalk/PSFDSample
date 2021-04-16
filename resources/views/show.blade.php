@extends('layouts.app')
@section('title','樣本')
@section('content')
<h3>樣本資訊</h3>
  <table width="100%" border="0">
    <tr>
      <td width="15%">樣本編號：{{$sample->sampleId}}</td>
      <td width="15%">樣本代號：{{$sample->quesName}}</td>
      <td width="15%">樣本狀態：{{$sample->status}}</td>
      <td width="15%">紙本通知/訪函：{{$sample->mail}}</td>
      <td width="15%">訪問途徑：{{$sample->mode}} </td>
      <td width="10%"><div align="right"><a href="#">修改</a></div></td>
      <td width="10%"><div align="right"><a href="javascript:window.close();">關閉視窗</a></div></td>
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
            <td align="center" valign="middle">{{$sample->result[$item]}}</td>
            @endforeach
        </tr>
      </table></td>
    </tr>
    <tr>
      <td colspan="2">姓名：{{$sample->name}} </td>
      <td>性別：{{$sample->gender}} </td>
      <td width="15%">出生年月：{{$sample->birthYear}}/{{$sample->birthMonth}} </td>
      <td width="15%"> </td>
      <td> </td>
      <td> </td>
    </tr>
    <tr>
      <td height="28" colspan="7">家中電話：{{$sample->telh}} </td>
    </tr>
    <tr>
      <td colspan="7">公司電話：{{$sample->telo}} </td>
    </tr>
    <tr>
      <td colspan="7">手機：{{$sample->telm}} </td>
    </tr>
    <tr>
      <td colspan="7">主地址村里：{{$sample->liname}} ({{$sample->liCode}}  )</td>
    </tr>
    <tr>
      <td>主地址：</td>
      <td colspan="6">{{$sample->mainAddress}} </td>
    </tr>
    <tr>
    <td>郵寄地址：</td>
      <td colspan="6">{{$sample->mailAddress}} </td>
    </tr>
    <tr>
      <td>住家地址： </td>
      <td colspan="6">{{$sample->addh}} </td>
    </tr>
    <tr>
      <td>公司地址： </td>
      <td colspan="6">{{$sample->addc}} </td>
    </tr>
    <tr>
      <td>其他地址： </td>
      <td colspan="6">{{$sample->addo}} </td>
    </tr>
    <tr>
      <td colspan="7">Email：{{$sample->email}} </td>
    </tr>
    <tr>
      <td>註記：</td>
      <td colspan="6" rowspan="2">{{$sample->note}} </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>內部註記：</td>
      <td colspan="6">{{$sample->innerNote}} </td>
    </tr>
  </table>
@endsection