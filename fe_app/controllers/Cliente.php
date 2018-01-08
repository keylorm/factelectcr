<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends CI_Controller {

	private 
		$vista_master = 'index',
		$rol_id,
		$usuario_id,
		$company_id,
		$internalcustomer_id,
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
			if($this->session->has_userdata('company_id')){
				$this->company_id = $this->session->userdata('company_id');
				$this->data['company_id'] = $this->company_id;
			}

			if($this->session->has_userdata('internalcustomer_id')){
				$this->internalcustomer_id = $this->session->userdata('internalcustomer_id');
				$this->data['internalcustomer_id'] = $this->internalcustomer_id;
			}				
		}else{
			redirect('/login', 'refresh');
		}

		// Carga provincias
		$paises = $this->m_general->getPaises();
		$this->data['paises'] = $paises;

		// Carga provincias
		$provincias = $this->m_general->getProvincias();
		$this->data['provincias'] = $provincias;
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

	


	public function agregarCliente(){
		$acceso = $this->m_general->validarRol($this->router->class, 'create');
		if($acceso){		
			
			$post_data = $this->input->post(NULL, TRUE);
			if($post_data!=null){
				$datos_insert = array();
				
				$datos_insert['firstName'] = $post_data['nombre_cliente'];
				if(isset($post_data['segundo_nombre_cliente'])){
					$datos_insert['secondName'] = $post_data['segundo_nombre_cliente'];
				}
				if(isset($post_data['apellido_cliente'])){
					$datos_insert['lastName'] = $post_data['apellido_cliente'];
				}
				$datos_insert['identification'] = $post_data['cedula_cliente'];
				$datos_insert['PersonType'] = str_replace('number:','',$post_data['tipo_cliente']);
				$datos_insert['Company'] = $this->company_id;
				//$this->m_cliente->insertar($datos_insert);
				//exit(var_export($datos_insert));
				$option = array('trace'=>1);
				$client_ws = new SoapClient("http://factura.azurewebsites.net/Service1.svc?wsdl", $option);
				try{ 
					$result = $client_ws->CreateCustomer($datos_insert);
					$result_decoded = json_decode($result->CreateCustomerResult);
					$cliente_id = $result_decoded->customerID;
					$person_id = $result_decoded->personID;
					

					//Ingresa las direcciones
					if(isset($post_data['address_country']) && !empty($post_data['address_country'])){
						foreach ($post_data['address_country'] as $kdireccion => $vdireccion) {
							if($vdireccion!=''){
								$datos_address = array(
													'address_principal' => $post_data['address_principal'][$kdireccion],
													'adress_country' => $vdireccion,
													'address_state' => $post_data['address_state'][$kdireccion],
													'address_canton' => $post_data['address_canton'][$kdireccion],
													'address_district' => $post_data['address_district'][$kdireccion],
													'address_street' => $post_data['address_street'][$kdireccion],
													'address_number' => ($post_data['address_number'][$kdireccion]!='')?$post_data['address_number'][$kdireccion]:0,
													'address_firstline' => $post_data['address_firstline'][$kdireccion],
													'address_secondline' => $post_data['address_neighborhood'][$kdireccion] );

								$result_address = $client_ws->AddAddress(array('personID' => $person_id, 
																				'address' => $datos_address));
							}
						}
					}

					//Ingresa Emails
					if(isset($post_data['correo']) && !empty($post_data['correo'])){
						foreach ($post_data['correo'] as $kcorreo => $vcorreo) {
							if($vcorreo!=''){
								$datos_email = array('email_address' => $vcorreo);
								$result_email = $client_ws->AddEmail(array('personID' => $person_id, 
																				'email' => $datos_email));
							}
						}
					}

					//Ingresa telefonos
					if(isset($post_data['phone_number']) && !empty($post_data['phone_number'])){
						foreach ($post_data['phone_number'] as $ktelefono => $vtelefono) {
							if($vtelefono!=''){
								$datos_phone = array('phone_countrycode' => $post_data['phone_countrycode'][$ktelefono],
																'phone_number' => $vtelefono,
																'phone_ext' => $post_data['phone_ext'][$ktelefono]);
								$result_phone = $client_ws->AddPhone(array('personID' => $person_id, 
																				'phone' => $datos_phone));
							}
						}
					}
					
					$this->data['msg'][] = array(
									'tipo' => 'success',
									'texto' => 'Cliente registrado con éxito.');
				}catch(SoapFault $fault){ 
					// <xmp> tag displays xml output in html 
					echo 'Request : <br/><xmp>', 
					$client_ws->__getLastRequest(), 
					'</xmp><br/><br/> Error Message : <br/>', 
					$fault->getMessage(); 
				} 
				

			}

			$person_type_ws = new SoapClient("http://factura.azurewebsites.net/Service1.svc?wsdl");
			$result = $person_type_ws->GetAllPersonTypes();

			$this->data['person_types'] = $result->GetAllPersonTypesResult->person_type;

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


	//Consultas ajax

	public function consultaClientesAjax(){
		//Se usa esta forma para obtener los post de angular. Si se usa jquery se descomenta la otra forma		
		//$post_data = $this->input->post(NULL, TRUE);

		$parametros_ws_cliente = array('internalCustomer'=>$this->internalcustomer_id);
		$this->output->set_content_type('application/json');
		$post_data = json_decode(file_get_contents("php://input"), true);
    	if($post_data!=null){
    		if(isset($post_data['filtros']['company_id'])){
    			$parametros_ws_cliente['CompanyID'] = $post_data['filtros']['company_id'];
    		}
    	}
    	
		$client_ws = new SoapClient("http://factura.azurewebsites.net/Service1.svc?wsdl");			
		$result = $client_ws->GetCustomers($parametros_ws_cliente);
		//$result = $this->m_cliente->consultaAll($post_data);
		die(json_encode($result->GetCustomersResult));
	}
}