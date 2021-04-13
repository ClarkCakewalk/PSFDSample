<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search (Request $request) {
        $list= DB::table('sample')->get();
        return view('search', ['select'=>$request->input('select'),
                                'value'=>$request->input('value'),
                                'list'=>$list]);
    }

}
