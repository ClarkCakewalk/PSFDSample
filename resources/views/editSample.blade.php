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
                  樣本編號：{{$sample->sampleId}}
              </label>
            </td>
          <td width="15%">
              <label>
                  樣本代號：<input type="text" name="qname" required value="{{$sample->quesName}}">
              </label>
            </td>
          <td width="25%">
              <label>
                  樣本狀態：<select name="sampleType" >
                            <option value=1 @if($sample->status==1 | empty($sample->status)) selected @endif >持續追蹤</option>
                            <option value=2 @if($sample->status==2) selected @endif >停止訪問</option>
                      </select>
              </label>
            </td>
          <td width="15%">
              <label>
              紙本通知/訪函：<select name="sendMail">
                            <option value=1 @if($sample->mail==1 | empty($sample->mail)) selected @endif>正常郵寄</option>
                            <option value=2 @if($sample->mail==2) selected @endif>停止寄送</option>
                            </select>
              </label>
            </td>
          <td width="15%">
              <label>
                  訪問途徑：<select name="method">
                            <option value=1 @if($sample->mode==1 | empty($sample->mode)) selected @endif>面訪</option>
                            <option value=2 @if($sample->mode==2) selected @endif>網調</option>
                            <option value=3 @if($sample->mode==3) selected @endif>視訊</option>
                        </select>
              </label>
            </td>
          <td width="10%"> </td>
        </tr>
        <tr>
            <td>
                <label>
                    姓名：<input type="text" name="sampleName" value="{{$sample->name}}">
                </label>
            </td>
            <td>
                <label>
                    性別：<select name="sampleGender" required>
                        <option></option>
                        <option value=1 @if($sample->gender==1)selected @endif>男</option>
                        <option value=2 @if($sample->gender==2)selected @endif>女</option>
                    </select>
                </label>
            </td>
            <td>
                <label>
                    出生年月：<input type="number" name="sampleBirth" required minlength="4" maxlength="4" pattern="^\+?[1,2][0,9][0-9]*$" value="{{$sample->birthYear}}">年
                    <select name="sampleBirthM" required>
                        <option></option>
                        @for($i=1; $i<=12; $i++)
                            <option value={{$i}} @if($sample->birthMonth==$i) selected @endif>{{$i}}</option>
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
                    @foreach ($sample->add as $add)   
                    <tr>
                        <td><input type="radio" name="add1st" value="1" @if($sample->mainAdd==$add->id | old('add1st')==1) checked @endif></td>
                        <td><select name="add[1][Cat]" @if ($loop->iteration==1) required @endif>
                                <option></option>
                                <option value="1" @if ($add->category==1 | old('add.1.Cat')==1) selected @endif >住家</option>
                                <option value="2" @if ($add->category==2 | old('add.1.Cat')==2) selected @endif>公司/學校</option>
                                <option value="3" @if ($add->category==3 | old('add.1.Cat')==3) selected @endif>其他</option>
                            </select>
                        </td>
                        <td><input type="text" name="add[{{$loop->iteration}}][address]" value="{{$add->add}}" @if($loop->iteration==1) required @endif></td>
                        <td><input type="text" name="add[{{$loop->iteration}}][note]" value="{{$add->note}}">
                            <input type="hidden" name="add[{{$loop->iteration}}][id]" value="{{$add->id}}">
                        </td>
                    </tr>
                    @endforeach
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
                    @foreach($sample->tel as $tel)
                    <tr >
                        <td><select name="tel[{{$loop->iteration}}][Cat]">
                                <option></option>
                                <option value="1" @if($tel->category==1 | old('tel.'.$i.'.Cat')==1) selected @endif>住家</option>
                                <option value="2" @if($tel->category==2 | old('tel.'.$i.'.Cat')==2) selected @endif>公司/學校</option>
                                <option value="3" @if($tel->category==3 | old('tel.'.$i.'.Cat')==3) selected @endif>行動電話</option>
                            </select>
                        </td>
                        <td><input type="tel" name="tel[{{$loop->iteration}}][Num]" value="{{$tel->number}}"></td>
                        <td><input type="text" name="tel[{{$loop->iteration}}][Note]" value="{{$tel->note}}">
                        <input type="hidden" name="tel[{{$loop->iteration}}][id]" value="{{$tel->id}}">
                        </td>
                    </tr>
                    @endforeach
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
                    @foreach($sample->email as $email)
                    <tr>
                        <td><input type="radio" name="email1st" value="{{$loop->iteration}}" @if($sample->emailFirst==$email->id | old('email1st')==$i) checked @endif ></td>
                        <td><input type="text" name="email[{{$loop->iteration}}][Address]" value="{{$email->email}}"></td>
                        <td><input type="text" name="email[{{$loop->iteration}}][Note]" value="{{$email->note}}"></td>
                    </tr>
                    @endforeach
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
                    @foreach($sample->im as $im)
                    <tr>
                        <td><input type="radio" name="im1st" value="{{$loop->iteration}}" @if($sample->imFirst==$im->id | old('im1st')==$i) checked @endif ></td>
                        <td><select name="im[{{$loop->iteration}}][APP]" >
                                <option></option>
                                <option value="1" @if($im->app==1 | old('im.'.$i.'.APP')==1) selected @endif>Facebook</option>
                                <option value="2" @if($im->app==2 | old('im.'.$i.'.APP')==2) selected @endif>Line</option>
                                <option value="3" @if($im->app==3 | old('im.'.$i.'.APP')==3) selected @endif>微信</option>
                                <option value="4" @if($im->app==4 | old('im.'.$i.'.APP')==4) selected @endif>Skype</option>
                                <option value="5" @if($im->app==5 | old('im.'.$i.'.APP')==5) selected @endif>Instagram</option>
                                <option value="6" @if($im->app==6 | old('im.'.$i.'.APP')==6) selected @endif>其他</option>
                            </select>
                        </td>
                        <td><input type="text" name="im[{{$loop->iteration}}][Id]" value="{{$im->account}}"></td>
                        <td><input type="text" name="im[{{$loop->iteration}}][Note]" value="{{$im->note}}"></td>
                    </tr>
                    @endforeach
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="3">備註：<br><textarea name="note" rows="3" cols="100">{{$sample->note}}</textarea></td>
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
        <tr><td colspan="3">內部備註：<br><textarea name="innerNote" rows="3" cols="100">{{$sample->innerNote}}</textarea></td></tr>
        <tr>
            <td><input type="submit"></td>
        </tr>
    </table>
    @csrf

</form>
@endsection