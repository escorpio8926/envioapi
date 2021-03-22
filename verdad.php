<?php 

    //obtener el token de seguridad de mis envios
   function token(){
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

        curl_close($curl);
        if( $curl_res ){
        $res = json_decode($curl_res, true);
        if( isset($res["isError"]) && !$res["isError"])
        $access_token = $res["result"]["access_token"];
        }
        return $access_token;
        }
        //termina la funcion del token

        //funcion de solicitud de la api mis envios
    function solicitud($barcode_externo,$domicilio,$codigo_postal,$localidad,$destinatario,$bulto,$dimensiones,$peso){

        $numero=''; 
        $calle='';
        $domicilio=strrev($domicilio);
        $n =strlen($domicilio);
        For($i=0;$i<$n;$i++)
        {
            $val= $domicilio[$i];
            if(is_numeric($domicilio[$i]))
            {$numero=$numero.$val;}
            else
            {$calle=$calle.$val;}
        }

        $numero=(int)(strrev($numero));
        $calle=strrev($calle);

        $bulto               = (int)$bulto;


        $alto='';
        $ancho='';
        $profundidad='';
        $n =strlen($dimensiones);
        For($i=1;$i<=$n;$i++)
        {
            $val= $dimensiones[$i];
            if($dimensiones[$i]=='X')
            {$dimensiones=explode('X', $dimensiones);
            break;}
            if($domicilio[$i]=='x')
            {$dimensiones=explode('x', $dimensiones);
            break;}
    
        }

        $alto=(int)$dimensiones[0];
        $ancho=(int)$dimensiones[1];
        $profundidad=(int)$dimensiones[2];




        $peso               = (int)$peso;

        $paramsolicitud = array(
        'identificadorExterno' => $barcode_externo ,
        'locationID' => 2122 ,
        'origen' => array(
        'calle' => '',
        'altura' => '',
        'esquina' => '',
        'esquina2' => '',
        'barrio' => '',
        'localidad' => '',
        'partido' => '',
        'provincia' => '',
        'codigoPostal' => '',
        'observacion' => '',
        'piso' => '',
        'depto' => ''
        ),
        'destino' => array(
        'calle' => $calle ,
        'altura' => $numero ,
        'esquina' => '',
        'esquina2' => '',
        'barrio' => '',
        'localidad' => $localidad ,
        'partido' => '',
        'provincia' => 'tucuman',
        'codigoPostal' => $codigo_postal ,
        'observacion' => '',
        'piso' => '',
        'depto' => ''
        ),
        'destinatario' => array(
        'nombre' => $destinatario ,
        'email' => 'sistemas@correoflash.com',
        'phone' => '3815600094',
        'dni' => '',
        'comentario' => ''
        ),
        'productos' => array(
        array(
        'descripcion' => 'Producto' ,
        'cantidad' => $bulto ,
        'alto' => $alto,
        'ancho' => $ancho,
        'profundidad' => $profundidad,
        'tiempo' =>1 ,
        'peso' => $peso
        )
        )
        );
        $token=token();
        $payload = json_encode($paramsolicitud);
        $solicitudID = null;
        $codigoSeguimiento = null;
        $fecha = null;
        exit;
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
        curl_close($curl);

        if( $curl_res ){
        $res = json_decode($curl_res, true);
        if( isset($res["isError"]) && !$res["isError"]){
        $solicitudID = $res["result"]["solicitudID"];
        $codigoSeguimiento = 
        $res["result"]["codigoSeguimiento"];
        $fecha = $res["result"]["fecha"];
        }}
        echo "<script>console.log('" .$curl_res. "');</script>";
        echo "<script>console.log('" .'Token Verficación: '.$token. "');</script>";
        echo "<script>console.log('" .'SolicitudID: '.$solicitudID. "');</script>";
        echo "<script>console.log('" .'Codigo Seguimiento: '.$codigoSeguimiento. "');</script>";
        echo "<script>console.log('" .'Fecha: '.$fecha. "');</script>";
        }
        //termina la función de solicitud de mis envios
$cliente_id = 625;
$barcode_externo='123213sdfs';
$domicilio='san lorenzo 2660';
$codigo_postal='4000';
$localidad='san miguel de tucuman';
$destinatario='libia nedel';
$bulto='11';
$dimensiones='5X2X8';
$peso='10';

         if($cliente_id == 625){
            solicitud($barcode_externo,$domicilio,$codigo_postal,$localidad,$destinatario,$bulto,$dimensiones,$peso);}
 ?>