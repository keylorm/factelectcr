<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Factura extends CI_Controller {

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
		$this->load->model('m_factura');
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

		//Carga clientes
		$clientes = $this->m_cliente->getAllActiveClientes();
		$this->data['clientes'] = $clientes;
		
		// Carga provincias
		$provincias = $this->m_general->getProvincias();
		$this->data['provincias'] = $provincias;

		// Carga estados
		$factura_estados = $this->m_factura->getFacturaEstados();
		$this->data['factura_estados'] = $factura_estados;
	}


	public function index(){
		$acceso = $this->m_general->validarRol($this->router->class, 'list');
		if($acceso){
			$this->data['title'] = 'Facturas';
			$this->load->view($this->vista_master, $this->data);
		}else{
			redirect('/acceso-denegado', 'refresh');
		}
	}

	public function agregarFactura(){
		$acceso = $this->m_general->validarRol($this->router->class, 'create');
		if($acceso){
			

			$post_data = $this->input->post(NULL,TRUE);
			if($post_data!=null){		
				$result_insert = $this->m_factura->insertar($post_data);
				if($result_insert['tipo']=='success'){
					redirect('/facturas/editar-factura/'.$result_insert['inserted_id'].'?nuevo=1', 'refresh');
				}else{
					$this->data['msg'][] = $result_insert;
				}
			}

			$this->data['title'] = 'Facturas';
			$this->load->view($this->vista_master, $this->data);
			
		}else{
			redirect('/acceso-denegado', 'refresh');
		}
	}

	public function editarFactura($factura_id){
		$acceso = $this->m_general->validarRol($this->router->class, 'edit');
		if($acceso){
			if($factura_id!=null){
				$post_data = $this->input->post(NULL, TRUE);
				if($post_data!=null){
					$result_insert = $this->m_factura->actualizar($factura_id, $post_data);											
					$this->data['msg'][] = $result_insert;
					
				}

				$factura_result = $this->m_factura->consultar($factura_id);
				if($factura_result!==false){
					if(isset($factura_result['factura'])){
						if($factura_result['factura']->fecha_firma_contrato!=null && $factura_result['factura']->fecha_firma_contrato!=''){
							$factura_result['factura']->fecha_firma_contrato = date('d/m/Y', strtotime($factura_result['factura']->fecha_firma_contrato));
						}
						if($factura_result['factura']->fecha_inicio!=null && $factura_result['factura']->fecha_inicio!=''){
							$factura_result['factura']->fecha_inicio = date('d/m/Y', strtotime($factura_result['factura']->fecha_inicio));
						}
						if($factura_result['factura']->fecha_entrega_estimada!=null && $factura_result['factura']->fecha_entrega_estimada!=''){
							$factura_result['factura']->fecha_entrega_estimada = date('d/m/Y', strtotime($factura_result['factura']->fecha_entrega_estimada));
						}
						
						
						$this->data['factura'] = $factura_result['factura'];
					}
					if(isset($factura_result['valor_oferta'])){
						foreach ($factura_result['valor_oferta'] as $kvalor => $vvalor) {
							$this->data['valor_oferta'][$vvalor->proyecto_valor_oferta_tipo_id][] = $vvalor;
						}
						
					}
					if(isset($factura_result['tipo_cambio'])){
						$this->data['tipo_cambio'] = $factura_result['tipo_cambio'];
					}
					
				}
				$this->data['title'] = 'Facturas - Editar factura';
				$this->load->view($this->vista_master, $this->data);
			}else{
				redirect('/facturas', 'refresh');
			}
		}else{
			redirect('/acceso-denegado', 'refresh');
		}
	}


	public function verFactura($factura_id){
		$acceso = $this->m_general->validarRol($this->router->class, 'view');
		if($acceso){
			if($factura_id!=null){
				$factura_result = $this->m_factura->consultar($factura_id);
				if($factura_result!==false){
					$this->data['factura'] = $factura_result['factura'];
					$this->data['title'] = 'Facturas - Ver factura';
					$this->load->view($this->vista_master, $this->data);
				}else{
					redirect('/facturas', 'refresh');
				}
			}else{
				redirect('/facturas', 'refresh');
			}
			
		}else{
			redirect('/acceso-denegado', 'refresh');
		}
	}



	// Ajax functions


	public function consultaFacturasAjax(){
		//Se usa esta forma para obtener los post de angular. Si se usa jquery se descomenta la otra forma		
		//$post_data = $this->input->post(NULL, TRUE);
		$this->output->set_content_type('application/json');
		$post_data = json_decode(file_get_contents("php://input"), true);
    	if($post_data!=null){
    		$result = $this->m_factura->consultaAll($post_data);
			die(json_encode($result));
    	}
	}

	public function consultaFacturaInfoAjax(){
		$this->output->set_content_type('application/json');
		$post_data = json_decode(file_get_contents("php://input"), true);
    	if($post_data!=null){
    		$datos_factura = $this->m_factura->consultaInfoFactura($post_data);
    		$result = $datos_factura;
			die(json_encode($result));
    	}
	}


	public function consultaCantonesAjax(){
		//Se usa esta forma para obtener los post de angular. Si se usa jquery se descomenta la otra forma		
		//$post_data = $this->input->post(NULL, TRUE);
		$this->output->set_content_type('application/json');
		$post_data = json_decode(file_get_contents("php://input"), true);
    	if($post_data!=null){
    		$result = $this->m_general->consultaCantonesProvincia($post_data);
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
}