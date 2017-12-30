<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General extends CI_Controller{

	private 
		$vista_master = 'index',
		$data,
		$loggedin;
	
	function __construct(){
		parent::__construct();
		$this->data['vista'] = $this->router->method;
		//comprueba si hay una sesion iniciada
		$loggedin = $this->m_general->conectado();
		$this->data['loggedin'] = $loggedin;	
		if($loggedin){
			if($this->session->has_userdata('rol_id')){
				$this->data['rol_id'] = $this->session->userdata('rol_id');
			}
			if($this->session->has_userdata('usuario_id')){
				$this->data['usuario_id'] = $this->session->userdata('usuario_id');
			}			
		}else{
			redirect('/login', 'refresh');
		}
	}

	public function dashboard(){

		$this->data['title'] = 'Dashboard';
		$this->load->view($this->vista_master, $this->data);
	}

	public function errorPermisoDenegado(){
		$this->data['title'] = 'Acceso denegado';
		$this->load->view($this->vista_master, $this->data);
	}
}