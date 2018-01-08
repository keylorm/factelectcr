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


	// Ajax calls

	public function consultaPaisesAjax(){
		//Se usa esta forma para obtener los post de angular. Si se usa jquery se descomenta la otra forma		
		//$post_data = $this->input->post(NULL, TRUE);
		
		$result = $this->m_general->consultaPaises();
		die(json_encode($result));
    	
	}

	public function consultaProvinciasAjax(){
		//Se usa esta forma para obtener los post de angular. Si se usa jquery se descomenta la otra forma		
		//$post_data = $this->input->post(NULL, TRUE);
		
		$result = $this->m_general->consultaProvincias();
		die(json_encode($result));
    	
	}

	public function consultaCantonesAjax(){
		//Se usa esta forma para obtener los post de angular. Si se usa jquery se descomenta la otra forma		
		//$post_data = $this->input->post(NULL, TRUE);
		$this->output->set_content_type('application/json');
		$post_data = json_decode(file_get_contents("php://input"), true);
    	if($post_data!=null){
    		$result = $this->m_general->consultaCantonesProvincia($post_data);
    		exit(var_export($result));
			die(json_encode($result));
    	}
	}

	public function consultaDistritosAjax(){
		//Se usa esta forma para obtener los post de angular. Si se usa jquery se descomenta la otra forma		
		//$post_data = $this->input->post(NULL, TRUE);
		$this->output->set_content_type('application/json');
		$post_data = json_decode(file_get_contents("php://input"), true);
    	if($post_data!=null){
    		$result = $this->m_general->consultaDistritosCantones($post_data);
			die(json_encode($result));
    	}
	}

	public function consultaBarriosAjax(){
		//Se usa esta forma para obtener los post de angular. Si se usa jquery se descomenta la otra forma		
		//$post_data = $this->input->post(NULL, TRUE);
		$this->output->set_content_type('application/json');
		$post_data = json_decode(file_get_contents("php://input"), true);
    	if($post_data!=null){
    		$result = $this->m_general->consultaBarriosDistritos($post_data);
			die(json_encode($result));
    	}
	}
}