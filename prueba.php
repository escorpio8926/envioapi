<?php
    public function add()
    {
        $cliente_id         = $this->input->post('cliente_id');
        $departamento_id    = $this->input->post('departamento_id');
        $barcode_externo     = $this->input->post('barcode_externo');
        $destinatario        = $this->input->post('destinatario');
        $domicilio           = $this->input->post('domicilio');
        $codigo_postal       = $this->input->post('codigo_postal');
        $localidad           = $this->input->post('localidad');
        $datos_varios        = $this->input->post('datos_varios');
        $datos_varios_1      = $this->input->post('datos_varios_1');
        $datos_varios_2      = $this->input->post('datos_varios_2');
        //$comprobante_id      = $this->input->post('comprobante_id');
        $descripcion_paquete = $this->input->post('descripcion_paquete');
        $dimensiones         = $this->input->post('dimensiones');
        $peso                = $this->input->post('peso');
        $bulto               = $this->input->post('bulto');
        $servicio_base_id    = $this->input->post('servicio_base_id');
        $user_row = $this->ion_auth->user()->row();
        
        // var_dump($_POST);die;
        if( !$departamento_id )
            if( $departamento = ClienteDepartamento::whereClienteId($cliente_id)->first() )
                $departamento_id = $departamento->id;
            
        //Traigo un comprobante disponible
        $comprobante_ingreso_generado = ComprobanteGenerado::whereEstado(ComprobanteGenerado::ESTADO_DISPONIBLE)->first();
        
        // echo '<pre>' . var_export($comprobante_ingreso_generado, true) . '</pre>';
        
        //Creo un comprobante de ingreso
        $comprobante_ingreso_id = $this->crearComprobanteIngreso($comprobante_ingreso_generado,$user_row, $cliente_id, $departamento_id);
        $comprobante_ingreso = Comprobante::whereId($comprobante_ingreso_id)->first();
        //Creo el servicio de paqueteria para ese comprobante
        $comprobante_ingreso_servicio_id = $this->crearComprobanteIngresoServicio($comprobante_ingreso);
        $comprobante_ingreso_servicio = ComprobanteServicio::whereId($comprobante_ingreso_servicio_id)->first();
        $servicio  = Servicio::whereId($comprobante_ingreso_servicio->servicio_id)->first();
        //echo $cantidad[$i]."   -   ";
        $cantidad_modficado = 1; 
        date_default_timezone_set('America/Argentina/Tucuman');
        $array_piezas     = array(
            'usuario_id'             => $this->usuario->id,
            'servicio_id'            => $comprobante_ingreso_servicio->id,
            'tipo_id'                => $servicio->acuse == 1 ? PIEZA_TIPO_NORMAL : PIEZA_TIPO_SIMPLE,
            'sucursal_id'            => $comprobante_ingreso->sucursal_id, //Modificado las piezas cargadas deberian tener la sucursal del CI $this->usuario->sucursal_id,
            'estado_id'              => Pieza::ESTADO_EN_GESTION,
            'cantidad'               => $cantidad_modficado,
            'comprobante_ingreso_id' => $comprobante_ingreso->id,
            'barcode_externo'        => $barcode_externo,
            'destinatario'           => $destinatario,
            'domicilio'              => $domicilio,
            'codigo_postal'          => $codigo_postal,
            'localidad'              => $localidad,
            'datos_varios'           => $datos_varios,
            'datos_varios_1'         => $datos_varios_1,
            'datos_varios_2'         => $datos_varios_2,
            'create_user_id'         => $user_row->id,
            'create'                 => date("Y-m-d H:i:s"),
            'update'                 => date("Y-m-d H:i:s"),
        );
        $this->codegen_model->add('flash_piezas',$array_piezas);
        //Creo el registro en Piezas_paquetes
        $piezas_insertada = $this->codegen_model->row('flash_piezas','*','id = '.$this->db->insert_id());
        $array_piezas_paquetes     = array(
                                'pieza_id' => $piezas_insertada->id,
                                'descripcion_paquete' => $descripcion_paquete,
                                'dimensiones' => $dimensiones,
                                'peso' => $peso,
                                'bultos' => $bulto,
                                'dias_entrega' => '',
                                'create' => date("Y-m-d H:i:s"),
                                'update' => date("Y-m-d H:i:s"),
                                'create_user_id' => $user_row->id,
                                );

        $this->codegen_model->add('flash_piezas_paquetes',$array_piezas_paquetes);
        
//                 echo($this->db->last_query());die;
        /* Auditoria */

        $data     = array(
            'user_id'     => $user_row->id,
            'categoria'   => 'PIEZAS_PAQUETES',
            'descripcion' => 'Comprobante: ' . $comprobante_ingreso->numero . '. A単adir Piezas_paquetes.',
            'origen'      => '',
            'destino'     => '',
        );
        $this->codegen_model->add('users_log', $data);
        /* END: Auditoria */

        $sql = "UPDATE flash_piezas p
                SET barcode = CONCAT( REPEAT( '0', 6 - LENGTH( p.id) ) , p.id)
            WHERE comprobante_ingreso_id = " . $comprobante_ingreso->id . " AND servicio_id = " . $servicio->id;
        $this->db->query($sql);
        unset($array_piezas);
//        echo $comprobante_ingreso->numero;die;
//        $mensaje = "Comprobante Nro: ".$comprobante_ingreso->numero."<br/> Descripcion: ".$descripcion_paquete." <br/> Correspondiente al ID de pieza: ".$piezas_insertada->id. " cuya descripcion es: ";
//        $mensaje_descripcion = " Descripcion Paquete: ".$descripcion_paquete." <br/> Peso: ".$peso." <br/> Dimensiones: ".$dimensiones." <br/> Bultos: ".$bulto ;
//        $this->session->set_flashdata('registro', $comprobante_ingreso->numero);
//        $this->session->set_flashdata('mensaje', $mensaje);
//        $this->session->set_flashdata('mensaje_descripcion', $mensaje_descripcion);
        $cliente = Cliente::whereId($cliente_id)->first();
        $this->getPaqueteriaXCliente($cliente->id,$cliente->nombre);
    }
   ?>