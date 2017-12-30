<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {

	private 
		$vista_master = 'index',
		$data;


	function __construct(){
		parent::__construct();
		$this->data['vista'] = $this->router->method;
		$this->load->model('m_usuario');
		$this->load->library('form_validation');


	}

	public function login()	{

		$loggedin = $this->m_general->conectado();
		$this->data['loggedin'] = $loggedin;

		$post = $this->input->post(NULL, FALSE);
		$usuario_inactivo = false;
		$contrasena_incorrecta = false;
		if($post){
			extract($post);
			$config = array(

					array(
							'field' => 'usuario',
							'label' => 'Usuario',
							'rules' => 'required'
					),
					array(
							'field' => 'password',
							'label' => 'Contraseña',
							'rules' => 'required',
					),
				);
			
			$this->form_validation->set_rules($config);
			if($this->form_validation->run() == TRUE){
				//Consulta si las contraeñas coinciden
				$datos_user = $this->m_usuario->getUserLogin($usuario);
				if($datos_user!==false){
					if(password_verify($password, $datos_user->password)){
						if($datos_user->estado_id==1){
							$this->session->set_userdata('loggedin', TRUE);
							$this->session->set_userdata('usuario_id', $datos_user->usuario_id);
							$this->session->set_userdata('rol_id', $datos_user->rol_id);
							$this->m_usuario->registroBitacoraIngreso($datos_user->usuario_id);
							redirect('/', 'refresh');
						}else{
							$usuario_inactivo = true;
						}
					}else{
						$contrasena_incorrecta = true;
					}				
				}
				
			}
		}

		$msg = array();
		if($usuario_inactivo){
			$msg[] = array(
						'tipo' => 'warning',
						'texto' => 'Usuario inactivo. Consulte al administrador del sistema para más información');
		}

		if($contrasena_incorrecta){
			$msg[] = array(
						'tipo' => 'danger',
						'texto' => 'Usuario o contraseña incorrecto');
		}

		if(!empty($msg)){
			$this->data['msg'] = $msg;
		}

		$this->data['title'] = 'Iniciar Sesión';
		$this->load->view($this->vista_master, $this->data);
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect('/login', 'refresh');
	}

	/*public function registro_admin(){
		$this->m_usuario->registroAdmin();
		$this->data['title'] = 'Iniciar Sesión';
		$this->load->view($this->vista_master, $this->data);
	}*/
}
