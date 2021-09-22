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
    public function create()
    {
        return view('addSample');
    }

    public function store(Request $request) {
        $validated= $request->validate([
            'sampleId'=>'unique:sample,sampleId'
        ]);
        $sampleID=$request->sampleId;
        $mainAdd=$request['add'][$request['add1st']]['address'];
         foreach($request->tel as $teltmp) {
            if (!empty($teltmp['Cat'])) {
                $teldata[]=['category'=>$teltmp['Cat'],
                            'number'=>$teltmp['Num'],
                            'note'=>$teltmp['Note']];
            }
        }
        foreach($request->add as $addtmp) {
            if(!empty($addtmp['Cat'])) {
                $addData[]=['category'=>$addtmp['Cat'],
                            'add'=>$addtmp['address'],
                            'note'=>$addtmp['note']];
            }
        }
        foreach($request->email as $emailtmp) {
            if(!empty($emailtmp['Address'])) {
                $emailData[]=['email'=>$emailtmp['Address'],
                            'note'=>$emailtmp['Note']];
            }
        }
        foreach($request->im as $imtmp) {
            if(!empty($imtmp['Id'])) {
                $imData[]=['app'=>$imtmp['APP'],
                            'account'=>$imtmp['Id'],
                            'note'=>$imtmp['Note']];
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
        $addSample->save();
        $addSample = Sample_Basic::where('sampleId', $request->sampleId)->first();
        if(!empty($teldata)) $addSample->Telephone()->createMany($teldata);
        $addSample->Address()->createMany($addData);
        if(!empty($emailData)) $addSample->Email()->createMany($emailData);
        if(!empty($imData)) $addSample->Massanger()->createMany($imData);
        $addSample->mainAdd = $addSample->Address()->where('add', 'like', $mainAdd)->first()->id;
        if(!empty($emailData)) $addSample->emailFirst = $addSample->Email()->where('email', 'like', $request['email'][$request['email1st']]['Address'])->first()->id;
        if(!empty($imData)) $addSample->imFirst = $addSample->Massanger()->where('app', 'like', $request['im'][$request['im1st']]['APP'])->where('account', 'like', $request['im'][$request->im1st]['Id'])->first()->id;
        $addSample->save();
        return redirect()->action([SearchController::class, 'show'],['id'=>$sampleID]);
    }
}
