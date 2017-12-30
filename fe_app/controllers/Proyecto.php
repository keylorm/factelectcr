<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proyecto extends CI_Controller {

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
		$this->load->model('m_proyecto');
		$this->load->model('m_cliente');
		$this->load->model('m_proveedor');
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
		$proyecto_estados = $this->m_proyecto->getProyectoEstados();
		$this->data['proyecto_estados'] = $proyecto_estados;
	}


	public function index(){
		$acceso = $this->m_general->validarRol($this->router->class, 'list');
		if($acceso){
			$this->data['title'] = 'Proyectos';
			$this->load->view($this->vista_master, $this->data);
		}else{
			redirect('/acceso-denegado', 'refresh');
		}
	}

	public function agregarProyecto(){
		$acceso = $this->m_general->validarRol($this->router->class, 'create');
		if($acceso){
			

			$post_data = $this->input->post(NULL,TRUE);
			if($post_data!=null){		
				$result_insert = $this->m_proyecto->insertar($post_data);
				if($result_insert['tipo']=='success'){
					redirect('/proyectos/ver-proyecto/'.$result_insert['inserted_id'].'?nuevo=1', 'refresh');
				}else{
					$this->data['msg'][] = $result_insert;
				}
			}

			$this->data['title'] = 'Proyectos';
			$this->load->view($this->vista_master, $this->data);
			
		}else{
			redirect('/acceso-denegado', 'refresh');
		}
	}

	public function editarProyecto($proyecto_id){
		$acceso = $this->m_general->validarRol($this->router->class, 'edit');
		if($acceso){
			if($proyecto_id!=null){
				$post_data = $this->input->post(NULL, TRUE);
				if($post_data!=null){
					$result_insert = $this->m_proyecto->actualizar($proyecto_id, $post_data);											
					$this->data['msg'][] = $result_insert;
					
				}

				$proyecto_result = $this->m_proyecto->consultar($proyecto_id);
				if($proyecto_result!==false){
					if(isset($proyecto_result['proyecto'])){
						if($proyecto_result['proyecto']->fecha_firma_contrato!=null && $proyecto_result['proyecto']->fecha_firma_contrato!=''){
							$proyecto_result['proyecto']->fecha_firma_contrato = date('d/m/Y', strtotime($proyecto_result['proyecto']->fecha_firma_contrato));
						}
						if($proyecto_result['proyecto']->fecha_inicio!=null && $proyecto_result['proyecto']->fecha_inicio!=''){
							$proyecto_result['proyecto']->fecha_inicio = date('d/m/Y', strtotime($proyecto_result['proyecto']->fecha_inicio));
						}
						if($proyecto_result['proyecto']->fecha_entrega_estimada!=null && $proyecto_result['proyecto']->fecha_entrega_estimada!=''){
							$proyecto_result['proyecto']->fecha_entrega_estimada = date('d/m/Y', strtotime($proyecto_result['proyecto']->fecha_entrega_estimada));
						}
						
						
						$this->data['proyecto'] = $proyecto_result['proyecto'];
					}
					if(isset($proyecto_result['valor_oferta'])){
						foreach ($proyecto_result['valor_oferta'] as $kvalor => $vvalor) {
							$this->data['valor_oferta'][$vvalor->proyecto_valor_oferta_tipo_id][] = $vvalor;
						}
						
					}
					if(isset($proyecto_result['tipo_cambio'])){
						$this->data['tipo_cambio'] = $proyecto_result['tipo_cambio'];
					}
					
				}
				$this->data['title'] = 'Proyectos - Editar proyecto';
				$this->load->view($this->vista_master, $this->data);
			}else{
				redirect('/proyectos', 'refresh');
			}
		}else{
			redirect('/acceso-denegado', 'refresh');
		}
	}


	public function verProyecto($proyecto_id){
		$acceso = $this->m_general->validarRol($this->router->class, 'view');
		if($acceso){
			if($proyecto_id!=null){
				$proyecto_result = $this->m_proyecto->consultar($proyecto_id);
				if($proyecto_result!==false){
					$fecha_inicio = strtotime($proyecto_result['proyecto']->fecha_inicio);
					$fecha_entrega_estimada = strtotime($proyecto_result['proyecto']->fecha_entrega_estimada);
					$fecha_actual = strtotime('now');
					$porcentaje_avance_proyecto = 0;
					$dias_consumidos = 0;
					$dias_proyecto = (((($fecha_entrega_estimada-$fecha_inicio)/60)/60)/24);
					if($fecha_actual > $fecha_inicio){
						$dias_consumidos = (((($fecha_actual-$fecha_inicio)/60)/60)/24);
						$porcentaje_avance_proyecto = ceil((100/$dias_proyecto)*$dias_consumidos);
					}
				

					$this->data['porcentaje'] = $porcentaje_avance_proyecto;
					$this->data['dias_proyecto'] = ceil($dias_proyecto);
					$this->data['dias_consumidos'] = ceil($dias_consumidos);
					$this->data['proyecto'] = $proyecto_result['proyecto'];
					$this->data['title'] = 'Proyectos - Ver proyecto';
					$this->load->view($this->vista_master, $this->data);
				}else{
					redirect('/proyectos', 'refresh');
				}
			}else{
				redirect('/proyectos', 'refresh');
			}
			
		}else{
			redirect('/acceso-denegado', 'refresh');
		}
	}


	public function verExtensionesProyecto($proyecto_id){
		$acceso = $this->m_general->validarRol($this->router->class.'_extensiones', 'list');
		if($acceso){
			$proyecto_result = $this->m_proyecto->consultar($proyecto_id);
			if($proyecto_result!==false){
				$this->data['proyecto'] = $proyecto_result['proyecto'];

				$proyecto_tipo_extensiones = $this->m_proyecto->consultarTiposExtensiones();
				if($proyecto_tipo_extensiones!==false){
					$this->data['extensiones_tipos'] = $proyecto_tipo_extensiones;
				}				

				$this->data['title'] = 'Proyectos - '.$this->data['proyecto']->nombre_proyecto.' - Ver extensiones';
				$this->load->view($this->vista_master, $this->data);
				
			}else{
				redirect('/proyectos', 'refresh');
			}
		}else{
			redirect('/acceso-denegado', 'refresh');
		}
	}



	public function agregarExtensionProyecto($proyecto_id){
		$acceso = $this->m_general->validarRol($this->router->class.'_extensiones', 'create');
		if($acceso){
			$proyecto_result = $this->m_proyecto->consultar($proyecto_id);
			if($proyecto_result!==false){
				$this->data['proyecto'] = $proyecto_result['proyecto'];
				$proyecto_tipo_extensiones = $this->m_proyecto->consultarTiposExtensiones();

				if($proyecto_tipo_extensiones!==false){
					$this->data['extensiones_tipos'] = $proyecto_tipo_extensiones;
				}

				$post_data = $this->input->post(NULL,TRUE);
				if($post_data!=null){		
					$result_insert = $this->m_proyecto->insertarExtension($proyecto_id, $post_data);
					if($result_insert['tipo']=='success'){
						redirect('/proyectos/extensiones/'.$proyecto_id.'?nuevo=1', 'refresh');
					}else{
						$this->data['msg'][] = $result_insert;
					}
				}

				$this->data['title'] = 'Proyectos';
				$this->load->view($this->vista_master, $this->data);
			}else{
				redirect('/proyectos', 'refresh');
			}
			
		}else{
			redirect('/acceso-denegado', 'refresh');
		}
	}

	public function editarExtensionProyecto($proyecto_id, $extension_id){

		$acceso = $this->m_general->validarRol($this->router->class.'_extensiones', 'edit');
		if($acceso){
			$proyecto_result = $this->m_proyecto->consultar($proyecto_id);
			if($proyecto_result!==false){
				$this->data['proyecto'] = $proyecto_result['proyecto'];
				$proyecto_tipo_extensiones = $this->m_proyecto->consultarTiposExtensiones();

				if($proyecto_tipo_extensiones!==false){
					$this->data['extensiones_tipos'] = $proyecto_tipo_extensiones;
				}

				$proyecto_extension = $this->m_proyecto->consultarExtension($extension_id);
				if($proyecto_extension!==false){
					$this->data['proyecto_extension'] = $proyecto_extension;
				}

				$post_data = $this->input->post(NULL,TRUE);
				if($post_data!=null){		
					$result_insert = $this->m_proyecto->actualizarExtension($extension_id, $post_data);
					if($result_insert['tipo']=='success'){
						redirect('/proyectos/extensiones/'.$proyecto_id.'?editar=1', 'refresh');
					}else{
						$this->data['msg'][] = $result_insert;
					}
				}

				$this->data['title'] = 'Proyectos';
				$this->load->view($this->vista_master, $this->data);
			}else{
				redirect('/proyectos', 'refresh');
			}
			
		}else{
			redirect('/acceso-denegado', 'refresh');
		}
	}

	/* Para manejo de Gastos */

	public function verGastosProyecto($proyecto_id){
		$acceso = $this->m_general->validarRol($this->router->class.'_gastos', 'list');
		if($acceso){
			$proyecto_result = $this->m_proyecto->consultar($proyecto_id);
			if($proyecto_result!==false){
				$this->data['proyecto'] = $proyecto_result['proyecto'];

				// carga los tipos de gasto
				$proyecto_tipo_gastos = $this->m_proyecto->consultarTiposGastos();
				if($proyecto_tipo_gastos!==false){
					$this->data['gasto_tipo'] = $proyecto_tipo_gastos;
				}

				// carga monedas
				$monedas = $this->m_general->getMonedas();				
				if($monedas!==false){
					$this->data['monedas'] = $monedas;
				}

				$proveedores = $this->m_proveedor->getAllActiveProveedores();
				if($proveedores!==false){
					$this->data['proveedores'] = $proveedores;
				}

				$gasto_estados = $this->m_proyecto->consultarEstadosGastos();
				if($gasto_estados!==false){
					$this->data['gasto_estados'] = $gasto_estados;
				}
				

				$this->data['title'] = 'Proyectos - '.$this->data['proyecto']->nombre_proyecto.' - Ver gastos';
				$this->load->view($this->vista_master, $this->data);
				
			}else{
				redirect('/proyectos', 'refresh');
			}
		}else{
			redirect('/acceso-denegado', 'refresh');
		}
	}


	public function agregarGastoProyecto($proyecto_id){
		$acceso = $this->m_general->validarRol($this->router->class.'_gastos', 'create');
		if($acceso){
			$proyecto_result = $this->m_proyecto->consultar($proyecto_id);
			if($proyecto_result!==false){
				// carga datos del proyecto	
				$this->data['proyecto'] = $proyecto_result['proyecto'];

				// carga los tipos de gasto
				$proyecto_tipo_gastos = $this->m_proyecto->consultarTiposGastos();
				if($proyecto_tipo_gastos!==false){
					$this->data['gasto_tipo'] = $proyecto_tipo_gastos;
				}

				// carga monedas
				$monedas = $this->m_general->getMonedas();				
				if($monedas!==false){
					$this->data['monedas'] = $monedas;
				}

				$proveedores = $this->m_proveedor->getAllActiveProveedores();
				if($proveedores!==false){
					$this->data['proveedores'] = $proveedores;
				}

				$gasto_estados = $this->m_proyecto->consultarEstadosGastos();
				if($gasto_estados!==false){
					$this->data['gasto_estados'] = $gasto_estados;
				}

				// Agarra los datos por post
				$post_data = $this->input->post(NULL,TRUE);
				if($post_data!=null){	
					$result_insert = $this->m_proyecto->insertarGasto($proyecto_id, $post_data);
					if($result_insert['tipo']=='success'){
						redirect('/proyectos/gastos/'.$proyecto_id.'?nuevo=1', 'refresh');
					}else{
						$this->data['msg'][] = $result_insert;
					}
				}

				$this->data['title'] = 'Proyectos';
				$this->load->view($this->vista_master, $this->data);
			}else{
				redirect('/proyectos', 'refresh');
			}
			
		}else{
			redirect('/acceso-denegado', 'refresh');
		}
	}

	public function editarGastoProyecto($proyecto_id, $gasto_id){

		$acceso = $this->m_general->validarRol($this->router->class.'_gastos', 'edit');
		if($acceso){
			$proyecto_result = $this->m_proyecto->consultar($proyecto_id);
			if($proyecto_result!==false){
				$this->data['proyecto'] = $proyecto_result['proyecto'];
				// carga datos del proyecto	
				$this->data['proyecto'] = $proyecto_result['proyecto'];

				// carga los tipos de gasto
				$proyecto_tipo_gastos = $this->m_proyecto->consultarTiposGastos();
				if($proyecto_tipo_gastos!==false){
					$this->data['gasto_tipo'] = $proyecto_tipo_gastos;
				}

				// carga monedas
				$monedas = $this->m_general->getMonedas();				
				if($monedas!==false){
					$this->data['monedas'] = $monedas;
				}

				$proveedores = $this->m_proveedor->getAllActiveProveedores();
				if($proveedores!==false){
					$this->data['proveedores'] = $proveedores;
				}

				$gasto_estados = $this->m_proyecto->consultarEstadosGastos();
				if($gasto_estados!==false){
					$this->data['gasto_estados'] = $gasto_estados;
				}

				$proyecto_gasto = $this->m_proyecto->consultarGasto($gasto_id);
				if($proyecto_gasto!==false){
					if($proyecto_gasto->fecha_gasto!=null && $proyecto_gasto->fecha_gasto!=''){
						$proyecto_gasto->fecha_gasto = date('d/m/Y', strtotime($proyecto_gasto->fecha_gasto));
					}
					
					$this->data['proyecto_gasto'] = $proyecto_gasto;
				}

				$post_data = $this->input->post(NULL,TRUE);
				if($post_data!=null){		
					$result_actualizar = $this->m_proyecto->actualizarGasto($gasto_id, $post_data);
					if($result_actualizar['tipo']=='success'){
						redirect('/proyectos/gastos/'.$proyecto_id.'?editar=1', 'refresh');
					}else{
						$this->data['msg'][] = $result_actualizar;
					}
				}

				$this->data['title'] = 'Proyectos';
				$this->load->view($this->vista_master, $this->data);
			}else{
				redirect('/proyectos', 'refresh');
			}
			
		}else{
			redirect('/acceso-denegado', 'refresh');
		}
	}


	// Ajax functions


	public function consultaProyectosAjax(){
		//Se usa esta forma para obtener los post de angular. Si se usa jquery se descomenta la otra forma		
		//$post_data = $this->input->post(NULL, TRUE);
		$this->output->set_content_type('application/json');
		$post_data = json_decode(file_get_contents("php://input"), true);
    	if($post_data!=null){
    		$result = $this->m_proyecto->consultaAll($post_data);
			die(json_encode($result));
    	}
	}

	public function consultaProyectosActivosAjax(){
		//Se usa esta forma para obtener los post de angular. Si se usa jquery se descomenta la otra forma		
		//$post_data = $this->input->post(NULL, TRUE);
		
		$result = $this->m_proyecto->consultaAllActivos();
		die(json_encode($result));
    	
	}



	public function consultaProyectoInfoAjax(){
		$this->output->set_content_type('application/json');
		$post_data = json_decode(file_get_contents("php://input"), true);
    	if($post_data!=null){
    		$datos_proyecto = $this->m_proyecto->consultaInfoProyecto($post_data);
    		$result = $datos_proyecto;
			die(json_encode($result));
    	}
	}

	public function eliminarProyectoAjax(){
		$acceso = $this->m_general->validarRol($this->router->class, 'delete');
		if($acceso){
			$this->output->set_content_type('application/json');
			$post_data = json_decode(file_get_contents("php://input"), true);
	    	if($post_data!=null){
	    		$result_eliminar = $this->m_proyecto->eliminarProyecto($post_data['proyecto_id']);
	    		$result = $result_eliminar;
				die(json_encode($result));
	    	}
    	}else{
    		$result=false;
			die(json_encode($result));
		}
	}


	public function consultaExtensionesProyectosAjax(){
		//Se usa esta forma para obtener los post de angular. Si se usa jquery se descomenta la otra forma		
		//$post_data = $this->input->post(NULL, TRUE);
		$this->output->set_content_type('application/json');
		$post_data = json_decode(file_get_contents("php://input"), true);
    	if($post_data!=null){
    		$result = $this->m_proyecto->consultaAllExtensionesConFiltros($post_data);
			die(json_encode($result));
    	}
	}

	public function consultaGastosProyectosAjax(){
		//Se usa esta forma para obtener los post de angular. Si se usa jquery se descomenta la otra forma		
		//$post_data = $this->input->post(NULL, TRUE);
		$this->output->set_content_type('application/json');
		$post_data = json_decode(file_get_contents("php://input"), true);
    	if($post_data!=null){
    		$result = $this->m_proyecto->consultaAllGastosConFiltros($post_data);
			die(json_encode($result));
    	}
	}


	public function eliminarExtensionAjax(){
		$acceso = $this->m_general->validarRol($this->router->class.'_extensiones', 'delete');
		if($acceso){
			$this->output->set_content_type('application/json');
			$post_data = json_decode(file_get_contents("php://input"), true);
	    	if($post_data!=null){
	    		$result_eliminar = $this->m_proyecto->eliminarExtension($post_data['extension_id']);
	    		$result = $result_eliminar;
				die(json_encode($result));
	    	}
    	}else{
    		$result=false;
			die(json_encode($result));
		}
	}

	public function eliminarGastoAjax(){
		$acceso = $this->m_general->validarRol($this->router->class.'_gastos', 'delete');
		if($acceso){
			$this->output->set_content_type('application/json');
			$post_data = json_decode(file_get_contents("php://input"), true);
	    	if($post_data!=null){
	    		$result_eliminar = $this->m_proyecto->eliminarGasto($post_data['gasto_id']);
	    		$result = $result_eliminar;
				die(json_encode($result));
	    	}
    	}else{
    		$result=false;
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