<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
	<form action="#" method="POST">
 <script
 src="https://misenvios.com.ar/api/api.min.js"
 data-publictoken="4A845D700D234FC8B1FF752DCFE5350482C76B6EC5BE478296"
 data-transaction-id="10000" 
 >
 </script>

</body>
</html>
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

echo $curl;
echo $curl_res;
 echo "<script>console.log('" .$curl_res. "');</script>";

curl_close($curl);
if( $curl_res ){
 $res = json_decode($curl_res, true);
if( isset($res["isError"]) && !$res["isError"])
 $access_token = $res["result"]["access_token"];
}
echo "access-token : " . $access_token;
?>

