<?php 
function CURL($method,$url, $data = null) {
$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
if(!empty($data)) {
curl_setopt($ch, CURLOPT_POST, true);
if ($data){
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
 'Content-Type: application/json',
 'Content-Length: ' . strlen($data)));
}
curl_setopt($ch, CURLOPT_URL, $url);
} else{}
$curl_res = curl_exec($ch);
curl_close($ch);
if( $curl_res ){
 $res = json_decode($curl_res, true);
if( isset($res["isError"]) && !$res["isError"])
 $access_token = $res["result"]["access_token"];
}
return $access_token;
}

$api_keys = array(
'apikey' => 'Ff1X1AgNgmQZsl4n9SdBoof7SRXrwA20xGXMMQDPioHXLVUPJX',
'secretkey' => 'E0QN0FAVAHE4CKZ8'
);

$payload = json_encode($api_keys);
$token=CURL("POST","https://misenvios.com.ar/servicios/api/Tokens",$payload);
echo $token;

 ?>