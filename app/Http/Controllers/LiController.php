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
    
    function geocode($address, Request $request){
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
}
