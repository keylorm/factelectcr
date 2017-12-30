<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_Usuario extends CI_Model {

	private $t_usuario = 'usuario',
			$t_usuario_bitacora_ingreso = 'usuario_bitacora_ingreso',
			$usuario_id,
			$ip,
			$agente_usuario;
	
	function __construct()
	{
		parent::__construct();
		$this->ip = $this->input->ip_address();
		$this->agente_usuario =$this->input->user_agent();
		if($this->session->has_userdata('usuario_id')){
			$this->usuario_id = $this->session->userdata('usuario_id');
		}
	}

	function getUserLogin($usuario){
		$this->db->where('usuario', $usuario);
		$db_result = $this->db->get($this->t_usuario);
		if($db_result->num_rows() > 0){
			return $db_result->row();
		}else{
			return false;
		}
	}


	function registroBitacoraIngreso($usuario_id){

		
		$this->db->set('usuario_id', $usuario_id);
		$this->db->set('fecha_ingreso', date('Y-m-d H:i:s'));
		$this->db->set('ip', $this->ip);
		$this->db->set('agente_usuario', $this->agente_usuario);
		$this->db->insert($this->t_usuario_bitacora_ingreso);
		
	}

	/*function registroAdmin(){
		$password_plaintext = '';
		$usuario = '';
		$password_hash =  password_hash( $password_plaintext, PASSWORD_DEFAULT, [ 'cost' => 10 ] );

		$this->db->set('fecha_registro', date('Y-m-d H:i:s'));
		$this->db->set('rol_id', 1);
		$this->db->set('estado_id', 1);
		$this->db->set('usuario', $usuario);
		$this->db->set('password', $password_hash);
		$this->db->insert($this->t_usuario);
	}*/
}