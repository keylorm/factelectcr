<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Configuracion extends CI_Controller {

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
	}


	public function index()	{
		$acceso = $this->m_general->validarRol($this->router->class, 'list');
		if($acceso){
        
			$this->data['title'] = 'Configuración';
			$this->load->view($this->vista_master, $this->data);
		}else{
			redirect('/acceso-denegado', 'refresh');
		}
	}

	public function gestionEmpresas()	{
		$acceso = $this->m_general->validarRol($this->router->class.'_empresa', 'list');
		if($acceso){
			$post_data = $this->input->post(NULL, TRUE);
			if($post_data!=null){
				

			}
			$this->data['title'] = 'Configuración - Empresa';
			$this->load->view($this->vista_master, $this->data);
		}else{
			redirect('/acceso-denegado', 'refresh');
		}
	}

	public function agregarEmpresa()	{
		$acceso = $this->m_general->validarRol($this->router->class.'_empresa', 'create');
		if($acceso){

			$post_data = $this->input->post(NULL, TRUE);
			if($post_data!=null){
				$datos_insert = array();
				
				$datos_insert['CompanyName'] = $post_data['company_name'];
				if(isset($post_data['company_comercialname'])){
					$datos_insert['comercialName'] = $post_data['company_comercialname'];
				}
				$datos_insert['CompanyIdentification'] = $post_data['company_identification'];
				$datos_insert['person_type'] = str_replace('number:','',$post_data['tipo_company']);

				if(isset($post_data['company_atv_user'])){
					$datos_insert['ATVuser'] = $post_data['company_atv_user'];
				}
				if(isset($post_data['company_atv_pass'])){
					$datos_insert['ATVpass'] = $post_data['company_atv_pass'];
				}
				if(isset($post_data['company_certificate_user'])){
					$datos_insert['certificate'] = $post_data['company_certificate_user'];
				}
				if(isset($post_data['company_certificate_pass'])){
					$datos_insert['certificatePass'] = $post_data['company_certificate_pass'];
				}

				$datos_insert['internalCustomer'] = $this->internalcustomer_id;
				//$this->m_cliente->insertar($datos_insert);
				//exit(var_export($datos_insert));
				$option = array('trace'=>1);
				$company_ws = new SoapClient("http://factura.azurewebsites.net/Service1.svc?wsdl", $option);
				try{ 
					$result = $company_ws->CreateCompany($datos_insert);
					$result_decoded = json_decode($result->CreateCompanyResult);
					$company_id = $result_decoded->companyID;
					

					//Ingresa los folios de factura
					/*if(isset($post_data['official_number_factura_initial']) && isset($post_data['official_number_factura_final'])){
						
								$datos_folio = array(
													'initialNumber' => $post_data['official_number_factura_initial'],
													'finalNumber' => $post_data['official_number_factura_final'],
													'documentType' => $post_data['official_number_factura_tipo_documento'],
													'companyID' => $company_id,
													'prefix' => $post_data['official_number_factura_prefix']
													);

								$result_folio = $company_ws->CreateOfficialNumber($datos_folio);
					}
					if(isset($post_data['official_number_nota_credito_initial']) && isset($post_data['official_number_nota_credito_final'])){
						
								$datos_folio = array(
													'initialNumber' => $post_data['official_number_nota_credito_initial'],
													'finalNumber' => $post_data['official_number_nota_credito_final'],
													'documentType' => $post_data['official_number_nota_credito_tipo_documento'],
													'companyID' => $company_id,
													'prefix' => $post_data['official_number_nota_credito_prefix']
													);

								$result_folio = $company_ws->CreateOfficialNumber($datos_folio);
					}
					if(isset($post_data['official_number_nota_debito_initial']) && isset($post_data['official_number_nota_debito_final'])){
						
								$datos_folio = array(
													'initialNumber' => $post_data['official_number_nota_debito_initial'],
													'finalNumber' => $post_data['official_number_nota_debito_final'],
													'documentType' => $post_data['official_number_nota_debito_tipo_documento'],
													'companyID' => $company_id,
													'prefix' => $post_data['official_number_nota_debito_prefix']
													);

								$result_folio = $company_ws->CreateOfficialNumber($datos_folio);
					}*/

					
					
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


			$this->data['title'] = 'Configuración - Crear Empresa';
			$this->load->view($this->vista_master, $this->data);
		}else{
			redirect('/acceso-denegado', 'refresh');
		}
	}

	//Llamados ajax

	public function consultaEmpresasAjax(){
		//Se usa esta forma para obtener los post de angular. Si se usa jquery se descomenta la otra forma		
		//$post_data = $this->input->post(NULL, TRUE);
		$this->output->set_content_type('application/json');
		$post_data = json_decode(file_get_contents("php://input"), true);
    	if($post_data!=null){
    	}
		$client_ws = new SoapClient("http://factura.azurewebsites.net/Service1.svc?wsdl");			
		$result = $client_ws->GetCompaniesFromInternalCustomer(array('InternalCustomer'=>$this->internalcustomer_id));
		//$result = $this->m_cliente->consultaAll($post_data);
		die(json_encode($result->GetCompaniesFromInternalCustomerResult));
	}
}