<?php 
function CURL($method,$url, $data = null) {
$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
echo "paso";
if(!empty($data)) {
switch ($method) {
case "POST":
curl_setopt($ch, CURLOPT_POST, true);
echo " paso 1";
if ($data){
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
 'Content-Type: application/json',
 'Content-Length: ' . strlen($data))
);
echo " paso3";
}
break;
case "PUT":
curl_setopt($ch, CURLOPT_PUT, 1);
break;
default:
if ($data){
$url = sprintf("%s?%s", $url, http_build_query($data));
//print_r($url);
}
}
curl_setopt($ch, CURLOPT_URL, $url);
//echo("<P>Con Datos De Envio</P>");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
//curl_setopt($ch, CURLOPT_HTTPHEADER , array("cache-control: no-cache"));
} else{
//echo("<P>Sin Datos De Envio</P>");
}
$result = curl_exec($ch);
echo $ch;
/*
print_r("<p>");
print_r(count(array_keys(json_decode($result, true))));
print_r(array_keys(json_decode($result, true)));
print_r(json_decode($result, true));
print_r("</p>");
*/
//if(gettype($result) == "string"){$result = json_encode(array('error' => true));}
$DataResultado = curl_getinfo($ch);
//print_r($DataResultado);
//print_r(json_decode($result, true));
$ResultadoDecode = json_decode($result, true);
 echo "<script>console.log('" .$result. "');</script>";
if($ResultadoDecode){
$Respuesta = array_merge($DataResultado,json_decode($result, true));
}else{
$result = json_encode(array('json-data' => false));
$Respuesta = array_merge($DataResultado,json_decode($result, true));
}
if( $Respuesta["http_code"] == 200 ){
curl_close($ch);
return $Respuesta;
}else{
curl_close($ch);
return $Respuesta;
}
}
//POST
$api_keys = array(
'apikey' => 'Ff1X1AgNgmQZsl4n9SdBoof7SRXrwA20xGXMMQDPioHXLVUPJX',
'secretkey' => 'E0QN0FAVAHE4CKZ8'
);
$payload = json_encode($api_keys);
CURL("POST","https://api.misenvios.com.ar/api/Tokens",$payload);

 ?>