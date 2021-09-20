<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Sample_Basic;
use App\Models\li;
use App\Models\Sample_Add;
use App\Models\Sample_Tel;
use Illuminate\Http\Request;

class SampleController extends Controller
{
    public function getLiId($address) {
        $liName = substr($address, 18, 30);
        if (strrpos($liName, '村')) $liName=substr($address, 0,strrpos($liName, '村')+21);
        elseif (strrpos($liName, '里')) $liName=substr($address, 0,strrpos($liName, '里')+21);
        else unset($liName);
        $li=li::select('licode')->where('liname','like', $liName)->get();
        return $li[0]['licode'];
    }
    public function addAddress($id, $add1st, $address) {
        $i=1;
        $addAdd=new Sample_Add;
        foreach($address as $addtmp) {
            if(!empty($addtmp['Cat'])) {
                $addAdd->sampleId = $id;
                $addAdd->category = $addtmp['Cat'];
                $addAdd->add = $addtmp['address'];
                $addAdd->note = $addtmp['note'];
                $addAdd->save();
                if ($i==$add1st) {
                    $addCode=$addAdd->id;
                    $liName = substr($addtmp['address'], 18, 30);
                    if (strrpos($liName, '村')) $liName=substr($addtmp['address'], 0,strrpos($liName, '村')+21);
                    elseif (strrpos($liName, '里')) $liName=substr($addtmp['address'], 0,strrpos($liName, '里')+21);
                    else unset($liName);
                    $li=li::select('licode')->where('liname','like', $liName)->get();
                }
            }
            $i++;            
        }
        return ['addcode'=>$addCode, 'licode'=>$li[0]['licode']];
    }
/*    public function addTel ($id, $tel) {
        $addSampleTel = new Sample_Tel;
        foreach($tel as $teltmp) {
            if (!empty($teltmp['Cat'])) {
                $teldata[]=['sampleId'=>$id, 
                            'category'=>$teltmp['Cat'],
                            'number'=>$teltmp['Num'],
                            'note'=>$teltmp['Note']];
                $addSampleTel->sampleId = $id;
                $addSampleTel->category = $teltmp['Cat'];
                $addSampleTel->number = $teltmp['Num'];
                $addSampleTel->note = $teltmp['Note'];
            }
        }
        $addSampleTel->saveMany();
 //       $addSampleTel->insert($teldata);
    }*/
    public function create()
    {
        return view('addSample');
    }

    public function store(Request $request) {
        $validated= $request->validate([
            'sampleId'=>'unique:sample,sampleId'
        ]);
        $mainAdd=$request['add'][$request['add1st']]['address'];
 //       $addAdds=$this->addAddress($request->sampleId, $request->add1st, $request->add);
        foreach($request->tel as $teltmp) {
            if (!empty($teltmp['Cat'])) {
                $teldata[]=['category'=>$teltmp['Cat'],
                            'number'=>$teltmp['Num'],
                            'note'=>$teltmp['Note']];
            }
        }
        foreach($request->add as $addtmp) {
            if(!empty($addtmp['Cat'])) {
                $addData[]=['sampleId'=>$request->sampleId,
                            'category'=>$addtmp['Cat'],
                            'add'=>$addtmp['address'],
                            'note'=>$addtmp['note']];
            }
        }
        $addSample=new Sample_Basic;
        $addSample->sampleId = $request->sampleId;
        $addSample->quesName = $request->qname;
        $addSample->name = $request->sampleName;
        $addSample->gender = $request->sampleGender;
        $addSample->birthYear = $request->sampleBirth;
        $addSample->birthMonth = $request->sampleBirthM;
        $addSample->liCode = $this->getLiId($mainAdd);
//        $addSample->mainAdd = $addAdds['addcode'];
        $addSample->save();
        $addSample = Sample_Basic::where('sampleId', $request->sampleId)->first();
        $addSample->Telephone()->createMany($teldata);
        $addSample->Address()->createMany($addData);
        $addSample->mainAdd = $addSample->Address()->where('add', 'like', $mainAdd)->first()->id;
        $addSample->save();
    }
}
