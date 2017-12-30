<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends CI_Controller {

	private 
		$vista_master = 'index',
		$rol_id,
		$usuario_id,
		$data;


	function __construct(){
		parent::__construct();

		//Carga la vista
		$this->data['vista'] = $this->router->class.'/'.$this->router->method;
		//carga el modelo
		$this->load->model('m_cliente');
		//carga la validacion del formulario
		$this->load->library('form_validation');

		//comprueba si hay una sesion iniciada
		$loggedin = $this->m_general->conectado();
		$this->data['loggedin'] = $loggedin;	
		if($loggedin){
			if($this->session->has_userdata('rol_id')){
				$this->rol_id = $this->session->userdata('rol_id');
				$this->data['rol_id'] = $this->rol_id;
			}
			if($this->session->has_userdata('usuario_id')){
				$this->usuario_id = $this->session->userdata('usuario_id');
				$this->data['usuario_id'] = $this->usuario_id;
			}			
		}else{
			redirect('/login', 'refresh');
		}
	}


	public function index()	{
		/* Esto se usa si la consulta se hace por post normal y no por angular 
		$post_data = $this->input->post(NULL, TRUE);
		if($post_data!=null){		
			exit(var_export($post_data));
		}*/
		$acceso = $this->m_general->validarRol($this->router->class, 'list');
		if($acceso){
        
			$this->data['title'] = 'Clientes';
			$this->load->view($this->vista_master, $this->data);
		}else{
			redirect('/acceso-denegado', 'refresh');
		}
	}

	public function consultaClientesAjax(){
		//Se usa esta forma para obtener los post de angular. Si se usa jquery se descomenta la otra forma		
		//$post_data = $this->input->post(NULL, TRUE);
		$this->output->set_content_type('application/json');
		$post_data = json_decode(file_get_contents("php://input"), true);
    	if($post_data!=null){
    		$result = $this->m_cliente->consultaAll($post_data);
			die(json_encode($result));
    	}
	}


	public function agregarCliente(){
		$acceso = $this->m_general->validarRol($this->router->class, 'create');
		if($acceso){
			$post_data = $this->input->post(NULL, TRUE);
			if($post_data!=null){
				$datos_insert = array();
				if(isset($post_data['correo']) && !empty($post_data['correo'])){
					foreach ($post_data['correo'] as $kcorreo => $vcorreo) {
						if($vcorreo!=''){
							$datos_insert['cliente_correo'][] = array('correo_cliente' => $vcorreo);
						}
					}
					unset($post_data['correo']);
				}
				if(isset($post_data['telefono']) && !empty($post_data['telefono'])){
					foreach ($post_data['telefono'] as $ktelefono => $vtelefono) {
						if($vtelefono!=''){
							$datos_insert['cliente_telefono'][] = array('telefono_cliente' => $vtelefono);
						}
					}
					unset($post_data['telefono']);
				}
				$datos_insert['cliente'] = $post_data;
				$this->m_cliente->insertar($datos_insert);

				$this->data['msg'][] = array(
									'tipo' => 'success',
									'texto' => 'Cliente registrado con éxito.');

			}
			$this->data['title'] = 'Clientes - Agregar cliente';
			$this->load->view($this->vista_master, $this->data);
		}else{
			redirect('/acceso-denegado', 'refresh');
		}
	}

	public function verCliente($cliente_id){
		$acceso = $this->m_general->validarRol($this->router->class, 'view');
		if($acceso){
			if($cliente_id!=null){
				$cliente_result = $this->m_cliente->consultar($cliente_id);
				if($cliente_result!==false){
					$this->data['cliente'] = $cliente_result['cliente'];
					if(isset($cliente_result['cliente_correo'])){
						$this->data['cliente_correo'] = $cliente_result['cliente_correo'];
					}
					if(isset($cliente_result['cliente_telefono'])){
						$this->data['cliente_telefono'] = $cliente_result['cliente_telefono'];
					}
					
					$this->data['title'] = 'Clientes - Ver cliente';
					$this->load->view($this->vista_master, $this->data);
				}else{
					redirect('/clientes', 'refresh');
				}
			}else{
				redirect('/clientes', 'refresh');
			}
		}else{
			redirect('/acceso-denegado', 'refresh');
		}
	}

	public function editarCliente($cliente_id){
		$acceso = $this->m_general->validarRol($this->router->class, 'edit');
		if($acceso){
			if($cliente_id!=null){
				$post_data = $this->input->post(NULL, TRUE);
				if($post_data!=null){
					$datos_update = array();
					if(isset($post_data['correo']) && !empty($post_data['correo'])){
						foreach ($post_data['correo'] as $kcorreo => $vcorreo) {
							if($vcorreo!=''){
								$datos_update['cliente_correo'][] = array('correo_cliente' => $vcorreo);
							}
						}
						unset($post_data['correo']);
					}
					if(isset($post_data['telefono']) && !empty($post_data['telefono'])){
						foreach ($post_data['telefono'] as $ktelefono => $vtelefono) {
							if($vtelefono!=''){
								$datos_update['cliente_telefono'][] = array('telefono_cliente' => $vtelefono);
							}
						}
						unset($post_data['telefono']);
					}
					$post_data['cliente_id'] = $cliente_id;
					$datos_update['cliente'] = $post_data;
					$this->m_cliente->actualizar($cliente_id, $datos_update);

					$this->data['msg'][] = array(
										'tipo' => 'success',
										'texto' => 'Cliente actualizado con éxito.');
				}

				$cliente_result = $this->m_cliente->consultar($cliente_id);
				if($cliente_result!==false){
					$this->data['cliente'] = $cliente_result['cliente'];
					if(isset($cliente_result['cliente_correo'])){
						$this->data['cliente_correo'] = $cliente_result['cliente_correo'];
					}
					if(isset($cliente_result['cliente_telefono'])){
						$this->data['cliente_telefono'] = $cliente_result['cliente_telefono'];
					}
				}
				$this->data['title'] = 'Clientes - Editar cliente';
				$this->load->view($this->vista_master, $this->data);
			}else{
				redirect('/clientes', 'refresh');
			}
		}else{
			redirect('/acceso-denegado', 'refresh');
		}
	}
}