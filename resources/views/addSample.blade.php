@extends('layouts.app')
@section('title','新增樣本')
@section('content')
<h3>新增樣本</h3>
<form method="POST" action="/sampleEdit">
    <table width="100%" border="0">
        <tr>
          <td width="15%">
              <label>
                  樣本編號：<input type="text" name="sampleId" required maxlength="7" minlength="7" pattern="^[0-9]*$">
              </label>
            </td>
          <td width="15%">
              <label>
                  樣本代號：<input type="text" name="qname" required>
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
                        </select>
              </label>
            </td>
          <td width="10%"> </td>
        </tr>
        <tr>
            <td>
                <label>
                    姓名：<input type="text" name="sampleName">
                </label>
            </td>
            <td>
                <label>
                    性別：<select name="sampleGender">
                        <option value=0> </option>
                        <option value=1>男</option>
                        <option value=2>女</option>
                    </select>
                </label>
            </td>
            <td>
                <label>
                    出生年月：<input type="text" name="sampleBirth" required minlength="4" maxlength="4" pattern="^\+?[1,2][0,9][0-9]*$">年
                    <select name="sampleBirthM">
                        <option value=0> </option>
                        <option value=1>1</option>
                        <option value=2>2</option>
                        <option value=3>3</option>
                        <option value=4>4</option>
                        <option value=5>5</option>
                        <option value=6>6</option>
                        <option value=7>7</option>
                        <option value=8>8</option>
                        <option value=9>9</option>
                        <option value=10>10</option>
                        <option value=11>11</option>
                        <option value=12>12</option>
                    </select>月
                </label>
            </td>
        </tr>
        <tr>
            <td><input type="submit"></td>
        </tr>
    </table>
    @csrf

</form>
@endsection