<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\Search;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search (Request $request) {
        $surveyTimes=[1999, 2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2014, 2016, 2018, 2020];
        $showResultTimes=3;
        $showResult=array_slice($surveyTimes,-3,3);
        $list= Search::select('sampleId', 'quesName', 'name', 'gender', 'birthYear', 'birthMonth', 'status', 'liname')
                ->join('li', 'sample.liCode', '=', 'li.licode')
                ->where($request->input('select'), 'like', $request->input('value').'%')
                ->orderby('sampleId')
                ->get();
        foreach ($list as &$sample) {
            $tmps=Result::where('sampleId', $sample->sampleId)
                        ->whereIn('year', $showResult)
                        ->get();
            foreach ($tmps as $tmp) {
                foreach ($showResult as $item) {
                    if (empty($sample[$item])) $sample[$item]='未訪問';
                    if ($tmp->year==$item) {
                        $sample[$item]=$tmp->result;
                    }
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
                                'list'=>$list,
                                'showResultTimes'=>$showResultTimes,
                                'showResult'=>$showResult]);
    }

    public function show ($id, Request $request) {
        $surveyTimes=[1999, 2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2014, 2016, 2018, 2020];
        $sample= Search::join('li', 'sample.liCode', '=', 'li.licode')
                ->where('sampleId', '=', $id)
                ->first();

        return view('show',['sample'=>$sample,
                            'surveyTimes'=>$surveyTimes]);
    } 
}
