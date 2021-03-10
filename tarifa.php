<?php
include 'curl.php';
$paramtarifa = array(
'locationID' => 2122,
'origen' => array(
 'calle' => 'Cerrito',
 'altura' => 348,
 'esquina' => 'Sarmiento',
 'esquina2' => '',
 'barrio' => '',
 'localidad' => 'CABA',
 'partido' => '',
 'provincia' => 'CABA',
 'codigoPostal' => '1104',
 'observacion' => '',
 'piso' => '1',
 'depto' => 'B'
 ),
'destino' => array(
 'calle' => 'Paez',
 'altura' => 2591,
 'esquina' => 'Bolivia',
 'esquina2' => '',
 'barrio' => 'Flores',
 'localidad' => 'CABA',
 'partido' => '',
 'provincia' => 'CABA',
 'codigoPostal' => '1407',
 'observacion' => '',
 'piso' => '1',
 'depto' => '1'
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
$token=CURL("POST",'https://misenvios.com.ar/servicios/api/Tokens',$payload);
$payload = json_encode($paramtarifa);
$importe = null;
$plazo = null;
$nombre = null;
$curl = curl_init();
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
curl_setopt($curl, CURLOPT_URL,
'https://misenvios.com.ar/servicios/api/Tarifa/Calcular');
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
 $importe = $res["result"]["importe"];
 $plazo = $res["result"]["plazo"];
 $nombre = $res["result"]["nombre"];
}}
echo "token : " . $token."<br>";
echo "importe : " . $importe."<br>";
echo "plazo : " . $plazo."<br>";
echo "nombre : " . $nombre."<br>";

?>