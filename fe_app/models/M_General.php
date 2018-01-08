<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_General extends CI_Model {

	private $t_pais = 'pais',
			$t_provincia = 'ubicacion_provincia', 
			$t_canton = 'ubicacion_canton', 
			$t_distrito = 'ubicacion_distrito',
			$t_barrio = 'ubicacion_barrio',
			$t_usuario_rol_permiso = 'usuario_rol_permiso',
			$t_moneda = 'moneda',
			$rol_id,
			$usuario_id;

	function __construct()
	{
		parent::__construct();
		$loggedin = $this->conectado();			
		if($loggedin){
			if($this->session->has_userdata('rol_id')){
				$this->rol_id = $this->session->userdata('rol_id');
			}
			if($this->session->has_userdata('usuario_id')){
				$this->usuario_id = $this->session->userdata('usuario_id');
			}			
		}
	}
	


	function conectado(){
		if($this->session->has_userdata('loggedin')){
			if($this->session->userdata('loggedin') == TRUE){				
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}

	function desconectado(){
		if($this->session->has_userdata('loggedin')){
			if($this->session->userdata('loggedin') == TRUE){				
				redirect('/', 'refresh');
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}

	function validarRol($modulo, $funcion){
		$this->db->where('usuario_rol_id', $this->rol_id);
		$this->db->where('modulo', $modulo);
		$this->db->where('funcion', $funcion);
		$result = $this->db->get($this->t_usuario_rol_permiso);
		if($result->num_rows()>0){
			if($result->row()->estado_permiso == 1){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	function getPaises(){
		$pais_result = $this->db->get($this->t_pais);
		if($pais_result->num_rows() > 0){
			return $pais_result->result();
		}else{
			return false;
		}
	}

	function getProvincias(){
		$provincia_result = $this->db->get($this->t_provincia);
		if($provincia_result->num_rows() > 0){
			return $provincia_result->result();
		}else{
			return false;
		}
	}

	function getCantones(){
		$canton_result = $this->db->get($this->t_canton);
		if($canton_result->num_rows() > 0){
			return $canton_result->result();
		}else{
			return false;
		}
	}

	function getDistritos(){
		$distrito_result = $this->db->get($this->t_distrito);
		if($distrito_result->num_rows() > 0){
			return $distrito_result->result();
		}else{
			return false;
		}
	}

	function getBarrios(){
		$barrio_result = $this->db->get($this->t_barrio);
		if($barrio_result->num_rows() > 0){
			return $barrio_result->result();
		}else{
			return false;
		}
	}

	function getMonedas(){
		$moneda_result = $this->db->get($this->t_moneda);
		$moneda_result_num_rows = $moneda_result->num_rows();
		if($moneda_result_num_rows > 0){
			return $moneda_result->result();
		}else{
			return false;
		}
	}


	function consultaPaises(){
		
		$result_pais = $this->db->get($this->t_pais);

		if($result_pais->num_rows()>0){
			$result = array(
							'total_rows' => $result_pais->num_rows(),
							'datos' => $result_pais->result(),
							);

			return $result;
		}else{
			return false;
		}
	}

	function consultaProvincias(){
		
		$result_provincia = $this->db->get($this->t_provincia);

		if($result_provincia->num_rows()>0){
			$result = array(
							'total_rows' => $result_provincia->num_rows(),
							'datos' => $result_provincia->result(),
							);

			return $result;
		}else{
			return false;
		}
	}


	function consultaCantonesProvincia($data = null){
		//Consulta primero los datos
		if(isset($data['provincia_id'])){			
			$this->db->where('provincia_id', $data['provincia_id']);				
		}

		$result_cantones = $this->db->get($this->t_canton);

		if($result_cantones->num_rows()>0){
			$result = array(
							'total_rows' => $result_cantones->num_rows(),
							'datos' => $result_cantones->result(),
							);

			return $result;
		}else{
			return false;
		}
	}


	function consultaDistritosCantones($data = null){
		//Consulta primero los datos
		if(isset($data['canton_id'])){		
			$this->db->where('provincia_id', $data['provincia_id']);	
			$this->db->where('canton_id', $data['canton_id']);				
		}

		$result_distrito = $this->db->get($this->t_distrito);

		if($result_distrito->num_rows()>0){
			$result = array(
							'total_rows' => $result_distrito->num_rows(),
							'datos' => $result_distrito->result(),
							);

			return $result;
		}else{
			return false;
		}
	}

	function consultaBarriosDistritos($data = null){
		//Consulta primero los datos
		if(isset($data['distrito_id'])){
			$this->db->where('provincia_id', $data['provincia_id']);	
			$this->db->where('canton_id', $data['canton_id']);				
			$this->db->where('distrito_id', $data['distrito_id']);				
		}

		$result_barrio = $this->db->get($this->t_barrio);

		if($result_barrio->num_rows()>0){
			$result = array(
							'total_rows' => $result_barrio->num_rows(),
							'datos' => $result_barrio->result(),
							);

			return $result;
		}else{
			return false;
		}
	}
}