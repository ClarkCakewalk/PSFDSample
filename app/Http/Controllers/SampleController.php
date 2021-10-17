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
    function geocode($address){
        $level1=strpos($address,"市");
            if(!$level1) $level1=strpos($address,"縣");
        $level2=strpos($address,"區",12);
            if (!$level2) $level2=strpos($address,"鄉",12);
                if (!$level2) $level2=strpos($address,"鎮",12);
                    if (!$level2) {
                        $level2=strrpos($address,"市",12);
                    }
        $level3=strpos($address,"村",18);
            if (!$level3) $level3=strpos($address,"里",18);
        $level4=strpos($address,"鄰",21);
        //分析地址，是否包含行政區資訊及位置
        if ($level3>0) $checklevel=3;
        else if ($level2>0) $checkleve=2;
        else $checklevel=1;
        //確認地址所包含的行政區層級
        if ($level4>0) {
            if ($level3>0) {
                $address=substr($address,0,$level3+3).substr($address, $level4+3);
            }
            else $address=substr($address,0,$level2+3).substr($address, $level4+3);
        }
        else $address=$address;
        //刪除「鄰」資訊，避免干擾查詢
         // url encode the address
    //    $addressurl = urlencode($address);
        $addressurl = $address;
        // google map geocode api url
        $url = "https://maps.googleapis.com/maps/api/geocode/json?sensor=false&language=zh-tw&key=AIzaSyBQqMpc54_ymRrWL537qi6hC95iMjoEoSU&address={$addressurl}";
         // get the json response
        $resp_json = file_get_contents($url);
         // decode the json
        $resp = json_decode($resp_json, true);
        // response status will be 'OK', if able to geocode given address
        if($resp['status']=='OK'){
            $countres=count($resp["results"]);
            //如果只有一筆回傳結果，直接記錄此座標。
            if ($countres==1){
                $lati = $resp['results'][0]['geometry']['location']['lat'];
                $lngi = $resp['results'][0]['geometry']['location']['lng'];
            }
            //如果回傳多比結果，依照地址資訊比對，以村里名稱正確者為準。
            else {
               for($i=0; $i<$countres; $i++) {
                    $LocateCount=count($resp["results"][$i]["address_components"]);
                   switch($checklevel)	{
                     case 1:
                        if (substr($address,0,$level1+3)==$resp["results"][$i]["address_components"][$LocateCount-3]["long_name"]) {
                            $lati = $resp['results'][$i]['geometry']['location']['lat'];
                             $lngi = $resp['results'][$i]['geometry']['location']['lng'];
                            goto end;
                        }
                        else continue;
                     break;
                     case 2:
                        if (substr($address,0,$level2+3)==$resp["results"][$i]["address_components"][$LocateCount-3]["long_name"].$resp["results"][$i]["address_components"][$LocateCount-4]["long_name"]) {
                            $lati = $resp['results'][$i]['geometry']['location']['lat'];
                             $lngi = $resp['results'][$i]['geometry']['location']['lng'];
                            goto end;
                        }
                        else continue;
                     break;
                     case 3:
                        if (substr($address,0,$level3+3)==$resp["results"][$i]["address_components"][$LocateCount-3]["long_name"].$resp["results"][$i]["address_components"][$LocateCount-4]["long_name"].$resp["results"][$i]["address_components"][$LocateCount-5]["long_name"]) {
                            $lati = $resp['results'][$i]['geometry']['location']['lat'];
                             $lngi = $resp['results'][$i]['geometry']['location']['lng'];
                            goto end;
                        }
                        else if (substr($address,0,$level2+3)==$resp["results"][$i]["address_components"][$LocateCount-3]["long_name"].$resp["results"][$i]["address_components"][$LocateCount-4]["long_name"]){
                                    $lati = $resp['results'][$i]['geometry']['location']['lat'];
                                     $lngi = $resp['results'][$i]['geometry']['location']['lng'];
                                    goto end;
                        }
                        else continue;
                     break;
                }
            }
        }
            end:
        } 
        //如果完整地址查無結果，則以村里座標取代.
        else if ($resp['status']=='ZERO_RESULTS' and $level3>0 and $level2>0 and $level1>0){
                $address=substr($address,0,$level3+3);
                $url="https://maps.googleapis.com/maps/api/geocode/json?sensor=false&language=zh-tw&key=AIzaSyBQqMpc54_ymRrWL537qi6hC95iMjoEoSU&address={$address}";
                $resp2_json = file_get_contents($url);
                $resp2 = json_decode($resp2_json, true);
                  if($resp2['status']='OK'){
                    $lati = $resp2['results'][0]['geometry']['location']['lat'];
                    $lngi = $resp2['results'][0]['geometry']['location']['lng'];
                }
        }
        if($lati && $lngi){
            // put the data in the array
            $data_arr = array();           
            array_push(
                $data_arr,
                $lati,
                $lngi
                );
            return $data_arr;
    
        }
        else return  false;        
    }
    public function addAddress($id, $add1st, $address) {
        $i=1;
        $addAdd=new Sample_Add;
        foreach($address as $addtmp) {
            if(!empty($addtmp['Cat'])) {
                $gis=$this->geocode($addtmp['address']);
                $addAdd->sampleId = $id;
                $addAdd->category = $addtmp['Cat'];
                $addAdd->add = $addtmp['address'];
                $addAdd->note = $addtmp['note'];
                $addAdd->GPS = POINT($gis[0], $gis[1]);
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

    public function editSampleShow ($id, Request $request) {
      $sampleInfo = Sample_Basic::where('sampleId', $id)->first();
      $sampleInfo->add = $sampleInfo->Address()->get();
      $sampleInfo->tel = $sampleInfo->Telephone()->get();
      $sampleInfo->email = $sampleInfo->Email()->get();
      $sampleInfo->im = $sampleInfo->Massanger()->get();
      $sampleInfo->result = $sampleInfo->Result()->get();

      return view('editSample', ['sample'=>$sampleInfo]);
    }
}
