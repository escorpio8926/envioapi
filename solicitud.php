<?php
include 'curl.php';
$paramsolicitud = array(
'identificadorExterno' => 'PZ00F029',
'locationID' => 2122,
'origen' => array(
 'calle' => 'combate de las piedras',
 'altura' => 1284,
 'esquina' => 'san luis',
 'esquina2' => '',
 'barrio' => '',
 'localidad' => 'san miguel de tucuman',
 'partido' => '',
 'provincia' => 'tucuman',
 'codigoPostal' => '4000',
 'observacion' => '',
 'piso' => '',
 'depto' => ''
 ),
'destino' => array(
 'calle' => 'CONSTITUCION',
 'altura' => 200 ,
 'esquina' => '',
 'esquina2' => '',
 'barrio' => '',
 'localidad' => 'san miguel de tucuman',
 'partido' => '',
 'provincia' => 'tucuman',
 'codigoPostal' => '4000',
 'observacion' => '',
 'piso' => '',
 'depto' => ''
 ),
'destinatario' => array(
 'nombre' => 'Emmanuel Monteros',
 'email' => 'escorpio8924@gmail.com',
 'phone' => '3815600094',
 'dni' => '34133550',
 'comentario' => 'test de envio'
 ),
'productos' => array(
 array(
 'descripcion' => 'Producto',
 'cantidad' => 1,
 'alto' => 1,
 'ancho' => 2,
 'profundidad' => 1,
 'tiempo' => 0,
 'peso' => 15
 )
 )
);
$token=CURL("POST","https://misenvios.com.ar/servicios/api/Tokens",$payload);
$payload = json_encode($paramsolicitud );
$solicitudID = null;
$codigoSeguimiento = null;
$fecha = null;
$curl = curl_init();
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
curl_setopt($curl, CURLOPT_URL,
"https://misenvios.com.ar/servicios/api/Solicitud");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
 'Content-Type: application/json',
 'Content-Length: ' . strlen($payload),
 "Authorization: Bearer ".$token)
);
$curl_res = curl_exec($curl);
echo "<script>console.log('" .$curl_res. "');</script>";
curl_close($curl);
if( $curl_res ){
 $res = json_decode($curl_res, true);
if( isset($res["isError"]) && !$res["isError"]){
 $solicitudID = $res["result"]["solicitudID"];
 $codigoSeguimiento = 
$res["result"]["codigoSeguimiento"];
 $fecha = $res["result"]["fecha"];
}}
echo "Token de seguridad: " . $token."<br>";
echo "solicitudID : " . $solicitudID."<br>";
echo "codigoSeguimiento : " . $codigoSeguimiento."<br>";
echo "fecha : " . $fecha;
?>