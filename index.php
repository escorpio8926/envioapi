<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
<?php
$api_keys = array(
'apikey' => 'Ff1X1AgNgmQZsl4n9SdBoof7SRXrwA20xGXMMQDPioHXLVUPJX',
'secretkey' => 'E0QN0FAVAHE4CKZ8'
);
$payload = json_encode($api_keys);
$access_token = null;
$curl = curl_init();
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
curl_setopt($curl, CURLOPT_URL,
'https://misenvios.com.ar/servicios/api/Tokens');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
 'Content-Type: application/json',
 'Content-Length: ' . strlen($payload))
);
$curl_res = curl_exec($curl);

 echo "<script>console.log('" .$curl_res. "');</script>";

curl_close($curl);
if( $curl_res ){
 $res = json_decode($curl_res, true);
if( isset($res["isError"]) && !$res["isError"])
 $access_token = $res["result"]["access_token"];
}
echo "access-token : " . $access_token;
?>

<form action="#" method="POST">
<script
 src="https://misenvios.com.ar/app/api/api.min.js"
 
 data-public-token="Ff1X1AgNgmQZsl4n9SdBoof7SRXrwA20xGXMMQDPioHXLVUPJX"
 
 data-transaction-id="312021232302" 
 
 data-origen-locationID="2122"

 data-country="AR"

 data-destino-Calle="AZCUENAGA"
 data-destino-Altura="2266"
 data-destino-Esquina1="UNAMUNO MIGUEL DE"
 data-destino-Esquina2="COVIELLO ALFREDO"
 data-destino-CodigoPostal="400"
 data-destino-Localidad="Tucumán"
 data-destino-Provincia="San Miguel de Tucumán"

 data-productos-Descripcion="Producto 1|Producto 2|Producto 3"
 data-productos-Cantidad="1|2|3"
 data-productos-Alto="1|10|20"
 data-productos-Ancho="21|20|30" 
 data-productos-Profundidad="3|30|40"
 data-productos-Peso="2|4|6"
 data-productos-Tiempo="1|5|15"

 
 data-destino-Nombre="Alvaro Rodriguez"
 data-destino-DNI="¨33050470"
 data-destino-phone="3815600094" 
 data-destino-email="sistemas@correoflash.com"
 >

></script>
 </form>

</body>
</html>


