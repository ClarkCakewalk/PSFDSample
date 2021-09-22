@extends('layouts.app')
@section('title','新增樣本')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        var i=1;
        $('#add').click(function(){
            $('#input').clone().attr('id', 'input'+i).insertBefore('#add_tr');
            i++;
        });
    });
</script>
<h3>新增樣本</h3>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form method="POST" action="/sampleEdit">
    <table width="100%" border="0">
        <tr>
          <td width="15%">
              <label>
                  樣本編號：<input type="text" name="sampleId" required maxlength="7" minlength="7" pattern="^[0-9]*$" value="{{old('sampleId')}}">
              </label>
            </td>
          <td width="15%">
              <label>
                  樣本代號：<input type="text" name="qname" required value="{{old('qname')}}">
              </label>
            </td>
          <td width="25%">
              <label>
                  樣本狀態：<select name="sampleType" >
                            <option value=1 @if(old('sampleType')==1 | empty(old('sampleType'))) selected @endif >持續追蹤</option>
                            <option value=2 @if(old('sampleType')==2) selected @endif >停止訪問</option>
                      </select>
              </label>
            </td>
          <td width="15%">
              <label>
              紙本通知/訪函：<select name="sendMail">
                            <option value=1 @if(old('sendMail')==1 | empty(old('sendMail'))) selected @endif>正常郵寄</option>
                            <option value=2 @if(old('sendMail')==2) selected @endif>停止寄送</option>
                            </select>
              </label>
            </td>
          <td width="15%">
              <label>
                  訪問途徑：<select name="method">
                            <option value=1 @if(old('method')==1 | empty(old('method'))) selected @endif>面訪</option>
                            <option value=2 @if(old('method')==2) selected @endif>網調</option>
                            <option value=3 @if(old('method')==3) selected @endif>視訊</option>
                        </select>
              </label>
            </td>
          <td width="10%"> </td>
        </tr>
        <tr>
            <td>
                <label>
                    姓名：<input type="text" name="sampleName" value="{{old('sampleName')}}">
                </label>
            </td>
            <td>
                <label>
                    性別：<select name="sampleGender" required>
                        <option></option>
                        <option value=1 @if(old('sampleGender')==1)selected @endif>男</option>
                        <option value=2 @if(old('sampleGender')==2)selected @endif>女</option>
                    </select>
                </label>
            </td>
            <td>
                <label>
                    出生年月：<input type="number" name="sampleBirth" required minlength="4" maxlength="4" pattern="^\+?[1,2][0,9][0-9]*$" value="{{old('sampleBirth')}}">年
                    <select name="sampleBirthM" required>
                        <option></option>
                        @for($i=1; $i<=12; $i++)
                            <option value={{$i}} @if(old('sampleBirthM')==$i) selected @endif>{{$i}}</option>
                        @endfor    
                    </select>月
                </label>
            </td>
        </tr>
        <tr>

            <td colspan="3">
                <table>
                    <tr>
                        <th colspan="4">聯絡地址</th>
                    </tr>
                    <tr>
                        <th>主地址</th>
                        <th>類別</th>
                        <th>地址</th>
                        <th>備註</th>
                    </tr>
                    <tr>
                        <td><input type="radio" name="add1st" value="1" @if(old('add1st')==1 | empty(old('add.1st'))) checked @endif></td>
                        <td><select name="add[1][Cat]" required>
                                <option></option>
                                <option value="1" @if (old('add.1.Cat')==1) selected @endif >住家</option>
                                <option value="2" @if (old('add.1.Cat')==2) selected @endif>公司/學校</option>
                                <option value="3" @if (old('add.1.Cat')==3) selected @endif>其他</option>
                            </select>
                        </td>
                        <td><input type="text" name="add[1][address]" value="{{old('add.1.address')}}" required></td>
                        <td><input type="text" name="add[1][note]" value="{{old('add.1.note')}}"></td>
                    </tr>
                    @for($i=2; $i<=5; $i++)
                    <tr>
                        <td><input type="radio" name="add1st" value="{{$i}}" @if(old('add1st')==$i) checked @endif></td>
                        <td><select name="add[{{$i}}][Cat]" >
                                <option></option>
                                <option value="1" @if(old('add.'.$i.'.Cat')==1) selected @endif>住家</option>
                                <option value="2" @if(old('add.'.$i.'.Cat')==2) selected @endif>公司/學校</option>
                                <option value="3" @if(old('add.'.$i.'.Cat')==3) selected @endif>其他</option>
                            </select>
                        </td>
                        <td><input type="text" name="add[{{$i}}][address]" value="{{old('add.'.$i.'.address')}}" ></td>
                        <td><input type="text" name="add[{{$i}}][note]" value="{{old('add.'.$i.'.note')}}"></td>
                    </tr>
                    @endfor
                </table>
            </td>
            <td colspan="2">
                <table>
                    <tr>
                        <th colspan="3">聯絡電話</th>
                    </tr>
                    <tr>
                        <th>類別</th>
                        <th>電話</th>
                        <th>備註</th>
                    </tr>
                    @for($i=1; $i<=5; $i++)
                    <tr >
                        <td><select name="tel[{{$i}}][Cat]">
                                <option></option>
                                <option value="1" @if(old('tel.'.$i.'.Cat')==1) selected @endif>住家</option>
                                <option value="2" @if(old('tel.'.$i.'.Cat')==2) selected @endif>公司/學校</option>
                                <option value="3" @if(old('tel.'.$i.'.Cat')==3) selected @endif>行動電話</option>
                            </select>
                        </td>
                        <td><input type="tel" name="tel[{{$i}}][Num]" value="{{old('tel.'.$i.'.Num')}}"></td>
                        <td><input type="text" name="tel[{{$i}}][Note]" value="{{old('tel.'.$i.'.Note')}}"></td>
                    </tr>
                    @endfor
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <table>
                    <tr>
                        <th colspan="2">Email</th>
                    </tr>
                    <tr>
                        <th>優先</th>
                        <th>Email Address</th>
                        <th>備註</th>
                    </tr>
                    @for($i=1; $i<=3; $i++)
                    <tr>
                        <td><input type="radio" name="email1st" value="{{$i}}" @if(old('email1st')==$i) checked @endif ></td>
                        <td><input type="text" name="email[{{$i}}][Address]" value="{{old('email.'.$i.'.Address')}}"></td>
                        <td><input type="text" name="email[{{$i}}][Note]" value="{{old('email.'.$i.'.Note')}}"></td>
                    </tr>
                    @endfor
                </table>
            </td>
            <td colspan="2">
                <table>
                    <tr>
                        <th colspan="4">即時通訊</th>
                    </tr>
                    <tr>
                        <th>優先</th>
                        <th>通訊軟體</th>
                        <th>ID</th>
                        <th>備註</th>
                    </tr>
                    @for($i=1; $i<=3; $i++)
                    <tr>
                        <td><input type="radio" name="im1st" value="{{$i}}" @if(old('im1st')==$i) checked @endif ></td>
                        <td><select name="im[{{$i}}][APP]" >
                                <option></option>
                                <option value="1" @if(old('im.'.$i.'.APP')==1) selected @endif>Facebook</option>
                                <option value="2" @if(old('im.'.$i.'.APP')==2) selected @endif>Line</option>
                                <option value="3" @if(old('im.'.$i.'.APP')==3) selected @endif>微信</option>
                                <option value="4" @if(old('im.'.$i.'.APP')==4) selected @endif>Skype</option>
                                <option value="5" @if(old('im.'.$i.'.APP')==5) selected @endif>Instagram</option>
                                <option value="6" @if(old('im.'.$i.'.APP')==6) selected @endif>其他</option>
                            </select>
                        </td>
                        <td><input type="text" name="im[{{$i}}][Id]" value="{{old('im.'.$i.'.Id')}}"></td>
                        <td><input type="text" name="im[{{$i}}][Note]" value="{{old('im.'.$i.'.Note')}}"></td>
                    </tr>
                    @endfor
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="3">備註：<br><textarea name="note" rows="3" cols="100">{{old('note')}}</textarea></td>
            <td rowspan="2" colspan="2">
                <table>
                    <tr><th colspan="2">結果代碼</th></tr>
                    <tr>
                        <th>訪問年</th>
                        <th>結果代碼</th>
                    </tr>
                    <tr>
                        <td><input type="number" name="resultYear[]" minlength="4" maxlength="4" pattern="^\+?[1,2][0,9][0-9]*$" value="{{old('resultYear[1]')}}"></td>
                        <td><input type="number" name="result[]" minlength="1" maxlength="3" value="{{old('result[1]')}}"></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr><td colspan="3">內部備註：<br><textarea name="innerNote" rows="3" cols="100">{{old('innerNote')}}</textarea></td></tr>
        <tr>
            <td><input type="submit"></td>
        </tr>
    </table>
    @csrf

</form>
@endsection