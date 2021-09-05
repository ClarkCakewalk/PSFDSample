<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Sample_Basic;
use Illuminate\Http\Request;

class SampleController extends Controller
{
    public function create()
    {
        return view('addSample');
    }

    public function store(Request $request) {
        $validated= $request->validate([
            'sampleId'=>'unique:sample,sampleId'
        ]);
        $addSample=new Sample_Basic;
        $addSample->sampleId = $request->sampleId;
        $addSample->quesName = $request->qname;
        $addSample->name = $request->sampleName;
        $addSample->gender = $request->sampleGender;
        $addSample->birthYear = $request->sampleBirth;
        $addSample->birthMonth = $request->sampleBirthM;
        $addSample->save();
    }
}
