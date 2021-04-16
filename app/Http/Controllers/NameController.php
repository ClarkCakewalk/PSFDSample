<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NameController extends Controller
{
    public function SurveyStatus ($var){
        switch ($var) {
            case 1:
                return '正常訪問';
            break;
            case 2:
                return '特殊安排';
            break;
            case 3:
                return '停止訪問';
            break;
            default:
            return '資料錯誤';
        }
    }

    public function gender ($var) {
        switch ($var) {
            case 1:
                return '男';
            break;
            case 2:
                return '女';
            break;
            default:
            return '資料錯誤';
        }
    }

    public function result ($var) {
        if (empty($var)) return '未訪問';
        else return $var;
    }

    public function birthT ($var) {
        return $var-1911;
    }

    public function mail ($var) {
        switch ($var) {
            case 1:
                return '寄送';
            break;
            case 0:
                return '不寄';
            break;
            default:
                return '資料錯誤';
        }
    }

    public function mode ($var) {
        switch ($var) {
            case 1:
                return '面訪';
            break;
            case 2:
                return '視訊訪問';
            break;
            case 3:
                return '停止訪問';
            break;
            default:
                return '資料錯誤';
        }
    }

    public function addNote ($var1, $var2, $main=0) {
        if (empty($main) or $main==0) {
            if (empty($var2)) $main=$var1;
            else $main=$var1.'('.$var2.')';
        } 
        else {
            if (empty($var2)) $main=$main.'；'.$var1;
            else $main=$main.'；'.$var1.'('.$var2.')';
        } 
        return $main;
    } 
}
