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
                            <option value=1 selected>持續追蹤</option>
                            <option value=2>停止訪問</option>
                      </select>
              </label>
            </td>
          <td width="15%">
              <label>
              紙本通知/訪函：<select name="sendMail">
                            <option value=1 selected>正常郵寄</option>
                            <option value=0>停止寄送</option>
                            </select>
              </label>
            </td>
          <td width="15%">
              <label>
                  訪問途徑：<select name="method">
                            <option value=1 selected>面訪</option>
                            <option value=2>網調</option>
                            <option value=3>視訊</option>
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
<!--
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
                    <tr id="input">
                        <td><input type="radio" name="add1st" checked></td>
                        <td><select name="addCat[]" required>
                                <option></option>
                                <option value="1">住家</option>
                                <option value="2">公司/學校</option>
                                <option value="3">其他</option>
                            </select>
                        </td>
                        <td><input type="text" name="add[]" value="{{old('add[1]')}}" required></td>
                        <td><input type="text" name="addNote[]" value="{{old('addNote[1]')}}"></td>
                    </tr>
                    <tr id="add_tr">
                        <td> <input type='button' id='add' value='新增'></td>
                    </tr>
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
                    <tr id="input">
                        <td><select name="telCat[]" required>
                                <option></option>
                                <option value="1">住家</option>
                                <option value="2">公司/學校</option>
                                <option value="3">其他</option>
                            </select>
                        </td>
                        <td><input type="tel" name="tel[]" value="{{old('tel[1]')}}" required></td>
                        <td><input type="text" name="telNote[]" value="{{old('telNote[1]')}}"></td>
                    </tr>
                    <tr id="add_tr">
                        <td> <input type='button' id='add' value='新增'></td>
                    </tr>
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
                    <tr>
                        <td><input type="radio" name="email1st" checked></td>
                        <td><input type="text" name="email[]" value="{{old('email[1]')}}" required></td>
                        <td><input type="text" name="emailNote[]" value="{{old('emailNote[1]')}}"></td>
                    </tr>
                </table>
            </td>
            <td colspan="2">
                <table>
                    <tr>
                        <th colspan="3">即時通訊</th>
                    </tr>
                    <tr>
                        <th>通訊軟體</th>
                        <th>ID</th>
                        <th>備註</th>
                    </tr>
                    <tr>
                        <td><select name="imCat[]" required>
                                <option></option>
                                <option value="1">Facebook</option>
                                <option value="2">Line</option>
                                <option value="3">微信</option>
                                <option value="4">Skype</option>
                                <option value="5">Instagram</option>
                                <option value="6">其他</option>
                            </select>
                        </td>
                        <td><input type="text" name="im[]" value="{{old('im[1]')}}" required></td>
                        <td><input type="text" name="imNote[]" value="{{old('imNote[1]')}}"></td>
                    </tr>
                </table>
            </td>
        </tr>
    -->
        <tr>
            <td colspan="3">備註：<br><textarea name="note" rows="3" cols="100">{{old('note')}}</textarea></td>
            <!--<td rowspan="2" colspan="2">
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
            </td>-->
        </tr>
        <tr><td colspan="3">內部備註：<br><textarea name="innerNote" rows="3" cols="100">{{old('innerNote')}}</textarea></td></tr>
        <tr>
            <td><input type="submit"></td>
        </tr>
    </table>
    @csrf

</form>
@endsection