<?php

function generateLicense()
{
    $randomHex = random(15);
    $expirationDate = date('Y-m-d', strtotime('+1 days', time()));
    return [$randomHex, $expirationDate];
}
function exe($url){
    while(true){  
        $api_url = "https://exe.io/api?api=891246b0c29a8772d36199a7d514223cce1a0773&url=".urlencode($url)."&alias=".random(10)."&format=json";
        $r = file_get_contents($api_url);
        $r2 = json_decode($r, 1);
            if($r2["status"] == 'success'){
                return $r2["shortenedUrl"];
            }
    }
}
function random($panjang){
   $ab="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
   $str= "";
   for ($i=0; $i < $panjang ; $i++){
     $pos = rand(0,strlen($ab)-1);
     $str .= $ab[$pos];}
  return 'BP'.$str;
}
function cutly($url){
    while(true){   
        $api_url = "https://cuty.io/api?api=87a312eb6315f7c057f011979115c13a8d721d5e&url=".urlencode($url)."&alias=".random(10)."&format=json";
        $r = file_get_contents($api_url);
        $r2 = json_decode($r, 1);
            if($r2["status"] == 'success'){
                return $r2["shortenedUrl"];
            }
    }
}

function cuty($url){
    while(true){   
        $api_url = "https://cuty.io/api?api=87a312eb6315f7c057f011979115c13a8d721d5e&url=".urlencode($url)."&alias=".random(10)."&format=json";
        $r = file_get_contents($api_url);
        $r3 = json_decode($r, 1);
            if($r3["status"] == 'success'){
                return $r3["shortenedUrl"];
            }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $DataJson = json_decode(file_get_contents('Xonz/database/data.json'), 1);    
    $DataJson2 = json_decode(file_get_contents('Xonz/database/license_data.json'), 1);    
    if(isset($_POST['script']) && isset($_POST['version'])){
        foreach($DataJson as $Data){
            if($Data['name'] == $_POST['script'] && $Data['version'] == $_POST['version'] && $Data['status'] == true ) {
                $response = ['status' => true, 'message' => 'script online'];
                break;
            }elseif($Data['name'] == $_POST['script'] && $Data['version'] != $_POST['version'] && $Data['status'] == true ) {
                $response = ['status' => false, 'message' => 'script update please check telegram group : https://t.me/MrRevoltOfficialGroup'];
                break;
            }elseif($Data['name'] == $_POST['script'] && $Data['version'] == $_POST['version'] && $Data['status'] == false ) {
                $response = ['status' => false, 'message' => 'script offline'];
                break;
            }elseif($Data['name'] == $_POST['script'] && $Data['version'] != $_POST['version'] && $Data['status'] == false ) {
                $response = ['status' => false, 'message' => 'script offline'];
                break;
            }
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }elseif(isset($_POST['license']) && isset($_POST['check'])){
        $license = $DataJson2[$_POST['license']];
        if($license['expiration_date']){
            if($license['status'] == true && strtotime($license['expiration_date']) >= strtotime(date('d-m-Y'))){
                $response = ['status' => 'active', 'message' => 'License is active'];
            }elseif($license['status'] == true && strtotime($license['expiration_date']) < strtotime(date('d-m-Y'))){
                $response = ['status' => 'expired', 'message' => 'License is expired'];
            }if($license['status'] == false){
                $response = ['status' => 'unactive', 'message' => 'License is unactive'];
            }
        }else{
             $response = ['status' => 'error', 'message' => 'License not found'];
       }
        header('Content-Type: application/json');
        echo json_encode($response);
    }elseif(isset($_POST['create_license'])){    
        list($license, $expirationDate) = generateLicense();
        $activationLink = 'https://xonz.codes/activate.php?license=' . urlencode($license);
        $licenseDataFile = 'Xonz/database/license_data.json';
        $licenseData = $DataJson2;
        $licenseData[$license] = ['expiration_date' => $expirationDate, 'status' => false];
        $asu = json_encode($licenseData, JSON_PRETTY_PRINT);
        file_put_contents($licenseDataFile, $asu);
        $sl1 = cuty($activationLink);
        $sl2 = cutly($activationLink);
        $response = [
            'license' => $license,
            'activation_link' => [$sl1, $sl2]
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    
    else{
        $response = ['status' => 'error', 'message' => 'data not define'];
        header('Content-Type: application/json');
        echo json_encode($response);
}







}else{
    echo "Mau Ngapain Bang ??!";
}
                