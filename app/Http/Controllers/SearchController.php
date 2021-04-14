<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\Search;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search (Request $request) {
        $list= Search::select('sampleId', 'quesName', 'name', 'gender', 'birthYear', 'birthMonth', 'status', 'liname')
                ->join('li', 'sample.liCode', '=', 'li.licode')
                ->where($request->input('select'), 'like', $request->input('value').'%')
                ->orderby('sampleId')
                ->get();
        foreach ($list as &$sample) {
            $tmps=Result::where('sampleId', $sample->sampleId)
                        ->whereIn('year', array(2016, 2018, 2020))
                        ->get();
            $sample->last1='未訪問';
            $sample->last2='未訪問';
            $sample->last3='未訪問';
            foreach ($tmps as $tmp) {
                if ($tmp->year==2020) {
                    $sample->last1=$tmp->result;
                } elseif ($tmp->year==2018) {
                    $sample->last2=$tmp->result;
                } elseif ($tmp->year==2016) {
                    $sample->last3=$tmp->result;
                }
             }
             switch ($sample->status) {
                case 1:
                    $sample->status='正常訪問';
                break;
                case 2:
                    $sample->status='特殊安排';
                break;
                case 3:
                    $sample->status='停止訪問';
                break;
                default:
                    $sample->status='資料錯誤';
            }
            switch ($sample->gender) {
                case 1:
                    $sample->gender='男';
                break;
                case 2:
                    $sample->gender='女';
                break;
                default:
                    $sample->gender='資料錯誤';
            }
            $sample->birthYear=$sample->birthYear-1911;
         }
        return view('search', ['select'=>$request->input('select'),
                                'value'=>$request->input('value'),
                                'list'=>$list]);
    }

    public function show ($id, Request $request) {
        $sample= Search::join('li', 'sample.liCode', '=', 'li.licode')
                ->where('sampleId', '=', $id)
                ->first();

        return view('show',['sample'=>$sample]);
    } 
}
