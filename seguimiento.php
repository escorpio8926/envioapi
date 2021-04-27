<?php
include 'curl.php';
$token=CURL("POST",'https://misenvios.com.ar/servicios/api/Tokens',$payload);
$paramsolicitud = 'CB3EF';
$solicitudID = null;
$estado = null;
$fecha = null;
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL,
'https://misenvios.com.ar/servicios/api/Solicitud/Seguimientos/'
.$paramsolicitud);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
'Content-Type: application/json',
'Content-Length: ' . strlen($payload),
"Authorization: Bearer ".$token)
);
 echo "<script>console.log('" .$token. "');</script>";
$curl_res = curl_exec($curl);
 echo "<script>console.log('" .$curl_res. "');</script>";
curl_close($curl);
if( $curl_res ){
$res = json_decode($curl_res, true);
if( isset($res["isError"]) && !$res["isError"]){
$solicitudID = $res["result"]["solicitudID"];
$estado = $res["result"]["estado"];
$fecha = $res["result"]["fecha"];
}}
echo "solicitudID : " . $solicitudID."<br>";
echo "estado : " . $estado."<br>";
echo "fecha : " . $fecha;
?>