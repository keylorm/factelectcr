<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_Factura extends CI_Model {
	
	private $t_proyecto = 'proyecto',
			$t_proyecto_estado = 'proyecto_estado',
			$t_proyecto_valor_oferta = 'proyecto_valor_oferta',
			$t_proyecto_tipo_cambio = 'proyecto_tipo_cambio',
			$t_proyecto_valor_oferta_tipo = 'proyecto_valor_oferta_tipo',
			$t_cliente = 'cliente',
			$t_distrito = 'ubicacion_distrito',
			$t_canton = 'ubicacion_canton',
			$t_provincia = 'ubicacion_provincia',
			$rol_id,
			$usuario_id;

	function __construct()
	{
		parent::__construct();

		$loggedin = $this->m_general->conectado();			
		if($loggedin){
			if($this->session->has_userdata('rol_id')){
				$this->rol_id = $this->session->userdata('rol_id');
			}
			if($this->session->has_userdata('usuario_id')){
				$this->usuario_id = $this->session->userdata('usuario_id');
			}			
		}
		$this->load->model('m_bitacora');
	}

	function getFacturaEstados(){
		$proyecto_estado_result = $this->db->get($this->t_proyecto_estado);
		if($proyecto_estado_result->num_rows() > 0){
			return $proyecto_estado_result->result();
		}else{
			return false;
		}
	}

	function consultaAll($data = null){
		//Consulta primero los datos
		$this->db->join($this->t_cliente, $this->t_cliente.'.cliente_id = '.$this->t_proyecto.'.cliente_id', 'LEFT');
		$this->db->join($this->t_proyecto_estado, $this->t_proyecto_estado.'.proyecto_estado_id = '.$this->t_proyecto.'.proyecto_estado_id', 'LEFT');
		$this->db->join($this->t_distrito, $this->t_distrito.'.distrito_id = '.$this->t_proyecto.'.distrito_id', 'LEFT');
		$this->db->join($this->t_canton, $this->t_canton.'.canton_id = '.$this->t_distrito.'.canton_id', 'LEFT');
		$this->db->join($this->t_provincia, $this->t_provincia.'.provincia_id = '.$this->t_canton.'.provincia_id', 'LEFT');
		if(isset($data['filtros'])){			
			foreach ($data['filtros'] as $key => $value) {
				if($value!='' && $value!='undefined' && $value!=null  &&  $value!='all'){
					if($key=='nombre_proyecto' || $key=='numero_contrato' || $key=='orden_compra'){
						$this->db->like($this->t_proyecto.'.'.$key, $value);
					}else if($key=='provincia_id'){
						$this->db->where($this->t_canton.'.'.$key, $value);
					}else if($key=='canton_id'){
						$this->db->where($this->t_distrito.'.'.$key, $value);
					}else if($key=='fecha_registro' || $key=='fecha_firma_contrato' || $key=='fecha_inicio' || $key=='fecha_entrega_estimada'){
						if($value['from']!='' && $value['from']!='undefined' && $value['from']!='IS NULL'){
							$value['from'] = date('Y-m-d', strtotime(str_replace('/', '-', $value['from'])));
							$this->db->where($this->t_proyecto.'.'.$key.'>="'.$value['from'].'"');
						}

						if($value['to']!='' && $value['to']!='undefined' && $value['to']!='IS NULL'){
							$value['to'] = date('Y-m-d', strtotime(str_replace('/', '-', $value['to'])));
							$this->db->where($this->t_proyecto.'.'.$key.'<="'.$value['to'].'"');	
						}
					}else{
						$this->db->where($this->t_proyecto.'.'.$key, $value);
					}
					
				}
			}
		}
		/*$offset = 0;
		$cantidad_mostrar = 2;
		if(isset($data['cantidad_mostrar'])){
			$cantidad_mostrar = (int)$data['cantidad_mostrar'];
		}
		if(isset($data['pagina'])){
			$pagina = (int)$data['pagina'];
			if($pagina>1){
				$offset=$pagina*$cantidad_mostrar;
			}
		}

		$this->db->limit($cantidad_mostrar, $offset);*/
		$result_proyecto = $this->db->get($this->t_proyecto);

		//vuelve a hacer la consulta para obtener el total de rows 

		/*
		$this->db->join($this->t_cliente, $this->t_cliente.'.cliente_id = '.$this->t_proyecto.'.cliente_id');
		$this->db->join($this->t_proyecto_estado, $this->t_proyecto_estado.'.proyecto_estado_id = '.$this->t_proyecto.'.proyecto_estado_id');
		$this->db->join($this->t_distrito, $this->t_distrito.'.distrito_id = '.$this->t_proyecto.'.distrito_id');
		$this->db->join($this->t_canton, $this->t_canton.'.canton_id = '.$this->t_distrito.'.canton_id');
		$this->db->join($this->t_provincia, $this->t_provincia.'.provincia_id = '.$this->t_canton.'.provincia_id');
		if(isset($data['filtros'])){			
			foreach ($data['filtros'] as $key => $value) {
				if($value!='' && $value!='undefined' && $value!=null  &&  $value!='all'){
					if($key=='nombre_proyecto' || $key=='numero_contrato' || $key=='orden_compra'){
						$this->db->like($this->t_proyecto.'.'.$key, $value);
					}else if($key=='provincia_id'){
						$this->db->where($this->t_canton.'.'.$key, $value);
					}else if($key=='canton_id'){
						$this->db->where($this->t_distrito.'.'.$key, $value);
					}else if($key=='fecha_registro' || $key=='fecha_firma_contrato' || $key=='fecha_inicio' || $key=='fecha_entrega_estimada'){
						if($value['from']!='' && $value['from']!='undefined' && $value['from']!='IS NULL'){
							$value['from'] = date('Y-m-d', strtotime(str_replace('/', '-', $value['from'])));
							$this->db->where($this->t_proyecto.'.'.$key.'>="'.$value['from'].'"');
						}

						if($value['to']!='' && $value['to']!='undefined' && $value['to']!='IS NULL'){
							$value['to'] = date('Y-m-d', strtotime(str_replace('/', '-', $value['to'])));
							$this->db->where($this->t_proyecto.'.'.$key.'<="'.$value['to'].'"');	
						}
					}else{
						$this->db->where($this->t_proyecto.'.'.$key, $value);
					}
					
				}
			}
		}
		$total_rows = $this->db->count_all_results($this->t_cliente, FALSE);*/

		if($result_proyecto->num_rows()>0){
			$result = array(
							'total_rows' => $result_proyecto->num_rows(),
							'datos' => $result_proyecto->result(),
							);

			return $result;

		}else{
			return false;
		}
		

	}

	function insertar($datos){
		if($datos!=null){

		
			$datos2 = $datos;			
			$datos['usuario_id'] = $this->usuario_id;
			$datos['fecha_registro'] = date('Y-m-d H:i:s');
			$datos['fecha_firma_contrato'] = ($datos['fecha_firma_contrato']!='' && $datos['fecha_firma_contrato']!=null )?date('Y-m-d', strtotime(str_replace('/','-',$datos['fecha_firma_contrato']))):'';
			$datos['fecha_inicio'] = ($datos['fecha_inicio']!='' && $datos['fecha_inicio']!=null )?date('Y-m-d', strtotime(str_replace('/','-',$datos['fecha_inicio']))):'';
			$datos['fecha_entrega_estimada'] = ($datos['fecha_entrega_estimada']!='' && $datos['fecha_entrega_estimada']!=null )?date('Y-m-d', strtotime(str_replace('/','-',$datos['fecha_entrega_estimada']))):'';
			$datos['moneda_id'] = 1;
			unset($datos['provincia_id']);
			unset($datos['canton_id']);
			unset($datos['valor_oferta']);
			unset($datos['tipocambio']);
			$this->db->insert($this->t_proyecto, $datos);
			$proyecto_id = $this->db->insert_id();
			foreach ($datos2['valor_oferta'] as $kfield => $vfield) {
				$this->db->set('proyecto_valor_oferta_tipo_id', $kfield);
				$this->db->set('proyecto_id', $proyecto_id);
				$this->db->set('moneda_id', 1);
				$this->db->set('valor_oferta', str_replace(' ', '',$vfield));
				$this->db->set('fecha_registro', date('Y-m-d H:i:s'));
				$this->db->set('estado_registro', 1);
				$this->db->insert($this->t_proyecto_valor_oferta);
			}
			
			$this->db->set('proyecto_id', $proyecto_id);
			$this->db->set('moneda_base_id', 1);
			$this->db->set('moneda_destino_id', 2);
			$this->db->set('valor_compra', str_replace(' ', '',$datos2['tipocambio']['valor_compra']));
			$this->db->set('valor_venta', str_replace(' ', '',$datos2['tipocambio']['valor_venta']));
			$this->db->set('fecha_registro', date('Y-m-d H:i:s'));
			$this->db->insert($this->t_proyecto_tipo_cambio);
			

			return array('tipo' => 'success',
						'texto' => 'Proyecto ingresado con éxito',
						'inserted_id'=> $proyecto_id);
			

		}
		
	}


	function actualizar($proyecto_id, $datos){
		//actualiza los campos

		if($proyecto_id!=null && $datos!=null){
			$datos2 = $datos;			
			$datos['fecha_firma_contrato'] = ($datos['fecha_firma_contrato']!='' && $datos['fecha_firma_contrato']!=null )?date('Y-m-d', strtotime(str_replace('/','-',$datos['fecha_firma_contrato']))):'';
			$datos['fecha_inicio'] = ($datos['fecha_inicio']!='' && $datos['fecha_inicio']!=null )?date('Y-m-d', strtotime(str_replace('/','-',$datos['fecha_inicio']))):'';
			$datos['fecha_entrega_estimada'] = ($datos['fecha_entrega_estimada']!='' && $datos['fecha_entrega_estimada']!=null )?date('Y-m-d', strtotime(str_replace('/','-',$datos['fecha_entrega_estimada']))):'';
			unset($datos['provincia_id']);
			unset($datos['canton_id']);
			unset($datos['valor_oferta']);
			unset($datos['tipocambio']);
			$this->db->where('proyecto_id', $proyecto_id);
			$this->db->update($this->t_proyecto, $datos);			
			foreach ($datos2['valor_oferta'] as $kfield => $vfield) {
				$this->db->where('proyecto_id', $proyecto_id);
				$this->db->where('proyecto_valor_oferta_tipo_id', $kfield);
				$result_valor = $this->db->get($this->t_proyecto_valor_oferta);

				$this->db->set('valor_oferta', str_replace(' ', '',$vfield));
				if($result_valor->num_rows()>0){
					$this->db->where('proyecto_id', $proyecto_id);
					$this->db->where('proyecto_valor_oferta_tipo_id', $kfield);
					$this->db->update($this->t_proyecto_valor_oferta);
				}else{
					$this->db->set('proyecto_valor_oferta_tipo_id', $kfield);
					$this->db->set('proyecto_id', $proyecto_id);
					$this->db->set('moneda_id', 1);
					$this->db->set('fecha_registro', date('Y-m-d H:i:s'));
					$this->db->set('estado_registro', 1);
					$this->db->insert($this->t_proyecto_valor_oferta);
				}

			}

			$this->db->where('proyecto_id', $proyecto_id);
			$result_tipo_cambio = $this->db->get($this->t_proyecto_tipo_cambio);

			$this->db->set('valor_compra', str_replace(' ', '',$datos2['tipocambio']['valor_compra']));
			$this->db->set('valor_venta', str_replace(' ', '',$datos2['tipocambio']['valor_venta']));
			if($result_tipo_cambio->num_rows()>0){
				$this->db->where('proyecto_id', $proyecto_id);
				$this->db->update($this->t_proyecto_tipo_cambio);
			}else{
				$this->db->set('proyecto_id', $proyecto_id);
				$this->db->set('moneda_base_id', 1);
				$this->db->set('moneda_destino_id', 2);
				$this->db->set('fecha_registro', date('Y-m-d H:i:s'));
				$this->db->insert($this->t_proyecto_tipo_cambio);
			}

			
			

			$this->m_bitacora->registrarEdicionBicatora('proyecto', $proyecto_id);

			return array('tipo' => 'success',
						'texto' => 'Proyecto ingresado con éxito',
						'inserted_id'=> $proyecto_id);

		}else{
			return array('tipo' => 'danger',
						'texto' => 'Hubo un error al actualizar el proyecto. Favor contactar al administrador del sistema.',
						'inserted_id'=> $proyecto_id);
		}
	}


	function consultar($proyecto_id){
		if($proyecto_id!=null){
			$result = array();
			$this->db->join($this->t_distrito, $this->t_distrito.'.distrito_id = '.$this->t_proyecto.'.distrito_id', 'LEFT');
			$this->db->join($this->t_canton, $this->t_canton.'.canton_id = '.$this->t_distrito.'.canton_id', 'LEFT');
			$this->db->where('proyecto_id', $proyecto_id);
			$result_proyecto = $this->db->get($this->t_proyecto);
			if($result_proyecto->num_rows()> 0){
				$result['proyecto'] = $result_proyecto->row();
				$this->db->where('proyecto_id', $proyecto_id);
				$result_valor_oferta = $this->db->get($this->t_proyecto_valor_oferta);
				if($result_valor_oferta->num_rows()>0){
					$result['valor_oferta'] = $result_valor_oferta->result();
				}
				$this->db->where('proyecto_id', $proyecto_id);
				$result_tipo_cambio = $this->db->get($this->t_proyecto_tipo_cambio);
				if($result_tipo_cambio->num_rows()>0){
					$result['tipo_cambio'] = $result_tipo_cambio->row();
				}

				return $result;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}


	function consultaInfoFactura($datos){
		if($datos!=null){
			if(isset($datos['proyecto_id'])){
				$proyecto_id = $datos['proyecto_id'];
				$result_array = array();

				$total_valor_oferta = 0;
				$valor_oferta_tmp = array();
				$valor_oferta_array = array();
				$this->db->where('proyecto_id', $proyecto_id);
				$result_valor_oferta = $this->db->get($this->t_proyecto_valor_oferta);
				if($result_valor_oferta->num_rows()>0){
					foreach ($result_valor_oferta->result() as $kvalor => $vvalor) {
						$valor_oferta_tmp[$vvalor->proyecto_valor_oferta_tipo_id][] = $vvalor->valor_oferta;
					}


					$result_valor_oferta_tipo = $this->db->get($this->t_proyecto_valor_oferta_tipo);
					if($result_valor_oferta_tipo->num_rows()>0){
						foreach ($result_valor_oferta_tipo->result() as $kvtipo => $vvtipo) {
							if(isset($valor_oferta_tmp[$vvtipo->proyecto_valor_oferta_tipo_id])){
								$subtotal = 0;
								foreach ($valor_oferta_tmp[$vvtipo->proyecto_valor_oferta_tipo_id] as $kv => $vv) {
									$subtotal+=(double)$vv;
									$total_valor_oferta += (double)$vv;
								}
								$valor_oferta_array[$vvtipo->proyecto_valor_oferta_tipo_id] = array('tipo' => $vvtipo->proyecto_valor_oferta_tipo,
																									'valor' => $subtotal);
							}
						}
						
					}
				}
				$result_array['valor_oferta']['desgloce'] = $valor_oferta_array;
				$result_array['valor_oferta']['total'] = $total_valor_oferta;
				return $result_array;
			}
		}else{
			return false;
		}
	}

	function consultarNumeroContrato($numero_contrato){
		$this->db->where('numero_contrato', $numero_contrato);
		$proyecto_result = $this->db->get($this->t_proyecto);
		if($proyecto_result->num_rows()>0){
			return array('tipo' => 'success',
						'texto' => 'Ya existe un proyecto con este numero de contrato.'
						);
		}else{
			return false;
		}
	}

	function consultarOrdenCompra($orden_combra){
		$this->db->where('orden_combra', $orden_combra);
		$proyecto_result = $this->db->get($this->t_proyecto);
		if($proyecto_result->num_rows()>0){
			return array('tipo' => 'success',
						'texto' => 'Ya existe un proyecto con esta orden de compra'
						);
		}else{
			return false;
		}
	}
}