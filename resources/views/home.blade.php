@extends('layouts.app')
@section('title','登入')
@section('content')
    @parent
    <table name="login">
    <tr>
        <td>
    <form action="">
        <p>帳號：<input name="account" type="text"></p>
        <p>密碼：<input name="passwd" type="password"></p>
        <p><input name="submit" type="submit" value="登入">
    </form>
        </td>
    </tr>
    </table>
@endsection