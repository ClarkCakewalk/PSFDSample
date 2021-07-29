<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\Search;
use App\Models\Sample_Add;
use App\Models\Sample_Tel;
use App\Models\Sample_Email;
use App\Models\Sample_Result;
use App\Models\Sample_Im;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    protected $NameController;
    public function __construct(NameController $NameController) {
        $this->NameController=$NameController;
    }
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
                    if ($tmp->year==$item) {
                        $sample[$item]=$tmp->result;
                    }
                    $sample[$item]=$this->NameController->result($sample[$item]);
                }
             }
            $sample->status=$this->NameController->SurveyStatus($sample->status);
            $sample->gender=$this->NameController->gender($sample->gender);
            $sample->birthYear=$this->NameController->birthT($sample->birthYear);
         }
        return view('search', ['select'=>$request->input('select'),
                                'list'=>$list,
                                'showResultTimes'=>$showResultTimes,
                                'showResult'=>$showResult]);
    }

    public function show ($id, Request $request) {
        $surveyTimes=[1999, 2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2014, 2016, 2018, 2020];
        $sampleInfo=Search::find($id);
        $sampleInfo->liname=$sampleInfo->Liname()->select('liname')->get();
        $tmp=Search::find($id)->Tels()
            ->where('avaliable', 1)
            ->orderByDesc('updated_at')
            ->orderByDesc('id')
            ->get();
         foreach ($tmp as $tmp2) {
            if ($tmp2->category==1) $sampleInfo->telh=$this->NameController->addNote($tmp2->number, $tmp2->note, $sampleInfo->telh);
            if ($tmp2->category==2) $sampleInfo->telo=$this->NameController->addNote($tmp2->number, $tmp2->note, $sampleInfo->telo);
            if ($tmp2->category==3) $sampleInfo->telm=$this->NameController->addNote($tmp2->number, $tmp2->note, $sampleInfo->telm);
        }
        $tmp=Search::find($id)->Results()
            ->orderBy('year')
            ->get();
         foreach ($surveyTimes as $time) {
            $result[$time]='未受訪';
        }
        foreach ($tmp as $tmp2) {
            $result[$tmp2->year]=$tmp2->result;
        }
        $sampleInfo->result=$result;

        $tmp=Search::find($id)->Adds()    
                            ->where('avaliable', 1)
                            ->orderByDesc('updated_at')
                            ->orderByDesc('id')
                            ->get();
         foreach ($tmp as $tmp2) {
            if ($sampleInfo->mainAdd==$tmp2->id) $sampleInfo->mainAddress=$this->NameController->addNote($tmp2->add, $tmp2->note);
            if (!empty($sampleInfo->mailAdd) and $sampleInfo->mailAdd==$tmp2->id) $sampleInfo->mailAddress=$this->NameController->addNote($tmp2->add, $tmp2->note);
            else $sampleInfo->mailAddress=='同主地址';
            if ($tmp2->category==1) $sampleInfo->addh=$this->NameController->addNote($tmp2->add, $tmp2->note, $sampleInfo->addh);
            if ($tmp2->category==2) $sampleInfo->addc=$this->NameController->addNote($tmp2->add, $tmp2->note, $sampleInfo->addc);
            if ($tmp2->category==3) $sampleInfo->addo=$this->NameController->addNote($tmp2->add, $tmp2->note, $sampleInfo->addo);
        }
        $tmp=Search::find($id)->Emails()
            ->orderByDesc('updated_at')
            ->orderByDesc('id')
            ->get();
        foreach ($tmp as $tmp2) {
            $sampleInfo->email=$this->NameController->addNote($tmp2->email, $tmp2->note);
        }
        $tmp=Search::find($id)->Ims()
            ->orderByDesc('updated_at')
            ->orderByDesc('id')
            ->get();
        foreach ($tmp as $tmp2) {
            $sampleInfo->im=$this->NameController->addNote($tmp2->account, $tmp2->app);
        }

        $sampleInfo->status=$this->NameController->SurveyStatus($sampleInfo->status);
        $sampleInfo->gender=$this->NameController->gender($sampleInfo->gender);
        $sampleInfo->birthYear=$this->NameController->birthT($sampleInfo->birthYear);
        $sampleInfo->mail=$this->NameController->mail($sampleInfo->mail);
        $sampleInfo->mode=$this->NameController->mode($sampleInfo->mode);

        return view('show',['sample'=>$sampleInfo,
                            'surveyTimes'=>$surveyTimes]);
    } 
}
