<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proveedor extends CI_Controller {

	private 
		$vista_master = 'index',
		$rol_id,
		$usuario_id,
		$data;


	function __construct(){
		parent::__construct();
		$this->data['vista'] = $this->router->class.'/'.$this->router->method;
		$this->load->model('m_proveedor');
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
			$this->data['title'] = 'Proveedores';
			$this->load->view($this->vista_master, $this->data);
		}else{
			redirect('/acceso-denegado', 'refresh');
		}
	}

	public function consultaProveedoresAjax(){
		//Se usa esta forma para obtener los post de angular. Si se usa jquery se descomenta la otra forma		
		//$post_data = $this->input->post(NULL, TRUE);
		$this->output->set_content_type('application/json');
		$post_data = json_decode(file_get_contents("php://input"), true);
    	if($post_data!=null){
    		$result = $this->m_proveedor->consultaAll($post_data);
			die(json_encode($result));
    	}
	}

	public function agregarProveedor(){
		$acceso = $this->m_general->validarRol($this->router->class, 'create');
		if($acceso){
			$post_data = $this->input->post(NULL, TRUE);
			if($post_data!=null){
				$datos_insert = array();
				if(isset($post_data['correo']) && !empty($post_data['correo'])){
					foreach ($post_data['correo'] as $kcorreo => $vcorreo) {
						if($vcorreo!=''){
							$datos_insert['proveedor_correo'][] = array('correo_proveedor' => $vcorreo);
						}
					}
					unset($post_data['correo']);
				}
				if(isset($post_data['telefono']) && !empty($post_data['telefono'])){
					foreach ($post_data['telefono'] as $ktelefono => $vtelefono) {
						if($vtelefono!=''){
							$datos_insert['proveedor_telefono'][] = array('telefono_proveedor' => $vtelefono);
						}
					}
					unset($post_data['telefono']);
				}
				$datos_insert['proveedor'] = $post_data;
				$this->m_proveedor->insertar($datos_insert);

				$this->data['msg'][] = array(
									'tipo' => 'success',
									'texto' => 'Proveedor registrado con éxito.');

			}
			$this->data['title'] = 'Proveedores - Agregar proveedor';
			$this->load->view($this->vista_master, $this->data);
		}else{
			redirect('/acceso-denegado', 'refresh');
		}
	}

	public function verProveedor($proveedor_id){
		$acceso = $this->m_general->validarRol($this->router->class, 'view');
		if($acceso){
			if($proveedor_id!=null){
				$proveedor_result = $this->m_proveedor->consultar($proveedor_id);
				if($proveedor_result!==false){
					$this->data['proveedor'] = $proveedor_result['proveedor'];
					if(isset($proveedor_result['proveedor_correo'])){
						$this->data['proveedor_correo'] = $proveedor_result['proveedor_correo'];
					}
					if(isset($proveedor_result['proveedor_telefono'])){
						$this->data['proveedor_telefono'] = $proveedor_result['proveedor_telefono'];
					}
					$this->data['title'] = 'Proveedores - Ver proveedor';
						$this->load->view($this->vista_master, $this->data);
				}else{
					redirect('/proveedores', 'refresh');
				}			
			}else{
				redirect('/proveedores', 'refresh');
			}
		}else{
			redirect('/acceso-denegado', 'refresh');
		}
	}

	public function editarProveedor($proveedor_id){
		$acceso = $this->m_general->validarRol($this->router->class, 'edit');
		if($acceso){
			if($proveedor_id!=null){
				$post_data = $this->input->post(NULL, TRUE);
				if($post_data!=null){
					$datos_update = array();
					if(isset($post_data['correo']) && !empty($post_data['correo'])){
						foreach ($post_data['correo'] as $kcorreo => $vcorreo) {
							if($vcorreo!=''){
								$datos_update['proveedor_correo'][] = array('correo_proveedor' => $vcorreo);
							}
						}
						unset($post_data['correo']);
					}
					if(isset($post_data['telefono']) && !empty($post_data['telefono'])){
						foreach ($post_data['telefono'] as $ktelefono => $vtelefono) {
							if($vtelefono!=''){
								$datos_update['proveedor_telefono'][] = array('telefono_proveedor' => $vtelefono);
							}
						}
						unset($post_data['telefono']);
					}
					$post_data['proveedor_id'] = $proveedor_id;
					$datos_update['proveedor'] = $post_data;
					$this->m_proveedor->actualizar($proveedor_id, $datos_update);

					$this->data['msg'][] = array(
										'tipo' => 'success',
										'texto' => 'Proveedor actualizado con éxito.');
				}

				$proveedor_result = $this->m_proveedor->consultar($proveedor_id);
				if($proveedor_result!==false){
					$this->data['proveedor'] = $proveedor_result['proveedor'];
					if(isset($proveedor_result['proveedor_correo'])){
						$this->data['proveedor_correo'] = $proveedor_result['proveedor_correo'];
					}
					if(isset($proveedor_result['proveedor_telefono'])){
						$this->data['proveedor_telefono'] = $proveedor_result['proveedor_telefono'];
					}
				}
				$this->data['title'] = 'Proveedores - Editar proveedor';
				$this->load->view($this->vista_master, $this->data);
			}else{
				$this->data['title'] = 'Proveedores - Agregar proveedor';
				$this->load->view($this->vista_master, $this->data);
			}
		}else{
			redirect('/acceso-denegado', 'refresh');
		}
	}
}