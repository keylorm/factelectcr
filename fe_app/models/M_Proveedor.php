<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_Proveedor extends CI_Model {
	
	private $t_proveedor = 'proveedor',
			$t_proveedor_correo =  'proveedor_correo',
			$t_proveedor_telefono = 'proveedor_telefono',
			$rol_id,
			$usuario_id;

	function __construct()
	{
		parent::__construct();
		//comprueba si hay una sesion iniciada
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
	
	function consultaAll($data = null){
		//Consulta primero los datos
		if(isset($data['filtros'])){
			foreach ($data['filtros'] as $key => $value) {
				if($key=='nombre_proveedor' || $key=='cedula_proveedor'){
					$this->db->like($key, $value);
				}else{
					$this->db->where($key, $value);
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
		$result_proveedor = $this->db->get($this->t_proveedor);

		//vuelve a hacer la consulta para obtener el total de rows 
		/*if(isset($data['filtros'])){
			foreach ($data['filtros'] as $key => $value) {
				if($key=='nombre_proveedor' || $key=='cedula_proveedor'){
					$this->db->like($key, $value);
				}else{
					$this->db->where($key, $value);
				}
			}
		}
		$total_rows = $this->db->count_all_results($this->t_proveedor, FALSE);*/

		if($result_proveedor->num_rows()>0){
			$result = array(
							'total_rows' => $result_proveedor->num_rows(),
							'datos' => $result_proveedor->result(),
							);

			return $result;

		}else{
			return false;
		}
		

	}


	function getAllActiveProveedores(){
		$this->db->where('estado_proveedor', 1);
		$proveedor_result = $this->db->get($this->t_proveedor);
		$proveedor_result_num_rows = $proveedor_result->num_rows();
		if($proveedor_result_num_rows > 0){
			return $proveedor_result->result();
		}else{
			return false;
		}
	}


	function insertar($data){
		foreach ($data['proveedor'] as $kfield => $vfield) {
			$this->db->set($kfield, $vfield);
		}
		$this->db->set('usuario_id', $this->usuario_id);
		$this->db->set('fecha_registro', date('Y-m-d H:i:s'));
		
		$this->db->insert($this->t_proveedor);
		$proveedor_id = $this->db->insert_id();

		if(isset($data['proveedor_correo']) || isset($data['proveedor_telefono'])){
			unset($data['proveedor']);
			foreach ($data as $ktipo => $vtipo) {
				foreach ($vtipo as $krow => $vrow) {
					foreach ($vrow as $kfield => $vfield) {
						$this->db->set($kfield, $vfield);
					}
					$this->db->set('proveedor_id', $proveedor_id);				
					$this->db->insert($ktipo);	
				}			
			}
		}
	}

	function consultar($proveedor_id){
		if($proveedor_id!=null){
			$result = array();
			$this->db->where('proveedor_id', $proveedor_id);
			$result_proveedor = $this->db->get($this->t_proveedor);
			if($result_proveedor->num_rows()> 0){
				$result['proveedor'] = $result_proveedor->row();
				$this->db->where('proveedor_id', $proveedor_id);
				$result_proveedor_correo = $this->db->get($this->t_proveedor_correo);
				if($result_proveedor_correo->num_rows()>0){
					$result['proveedor_correo'] = $result_proveedor_correo->result();
				}
				$this->db->where('proveedor_id', $proveedor_id);
				$result_proveedor_telefono = $this->db->get($this->t_proveedor_telefono);
				if($result_proveedor_telefono->num_rows()>0){
					$result['proveedor_telefono'] = $result_proveedor_telefono->result();
				}
				return $result;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	function actualizar($proveedor_id, $data){
		//actualiza los campos
		foreach ($data['proveedor'] as $kfield => $vfield) {
			$this->db->set($kfield, $vfield);
		}
		$this->db->where('proveedor_id', $proveedor_id);		
		$this->db->update($this->t_proveedor);
		
		//borra telefonos y correos viejos
		$this->db->where('proveedor_id', $proveedor_id);
		$this->db->delete($this->t_proveedor_correo);

		$this->db->where('proveedor_id', $proveedor_id);
		$this->db->delete($this->t_proveedor_telefono);

		//inserta correos y telefonos nuevamente
		if(isset($data['proveedor_correo']) || isset($data['proveedor_telefono'])){
			unset($data['proveedor']);
			foreach ($data as $ktipo => $vtipo) {
				foreach ($vtipo as $krow => $vrow) {
					foreach ($vrow as $kfield => $vfield) {
						$this->db->set($kfield, $vfield);
					}
					$this->db->set('proveedor_id', $proveedor_id);				
					$this->db->insert($ktipo);	
				}			
			}
		}
		$this->m_bitacora->registrarEdicionBicatora('proveedor', $proveedor_id);
	}
}