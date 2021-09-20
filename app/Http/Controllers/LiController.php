<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\li;

class LiController extends Controller
{
    public function __construct(NameController $NameController) {
        $this->NameController=$NameController;
    }
    public function getLiId($address, Request $request) {
        $liName = substr($address, 18, 30);
        if (strrpos($liName, '村')) $liName=substr($address, 0,strrpos($liName, '村')+21);
        elseif (strrpos($liName, '里')) $liName=substr($address, 0,strrpos($liName, '里')+21);
        else unset($liName);
        $li=li::select('licode')->where('liname','like', $liName)->get();
        return view('testLi',['liName'=>$liName, 'licode'=>$li[0]['licode']]);
    }
}
