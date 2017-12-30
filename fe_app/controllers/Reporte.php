<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require './vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Reporte extends CI_Controller {
	
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
			$this->data['title'] = 'Reportes';
			$this->load->view($this->vista_master, $this->data);
		}else{
			redirect('/acceso-denegado', 'refresh');
		}
	}

	public function reporteProyectoEspecifico(){
		$acceso = $this->m_general->validarRol($this->router->class.'_proyecto_especifico', 'view');
		if($acceso){
			$proyectos = $this->m_proyecto->consultaAllSimple();
			if($proyectos!=false){
				$this->data['proyectos'] = $proyectos;
			}

			$post_data = $this->input->post(NULL,TRUE);
			if($post_data!=null){
				if(isset($post_data['proyecto_id'])){
					$proyecto_id = $post_data['proyecto_id'];
					$this->generarReporteProyectoEspecifico($proyecto_id);
				}
			}

			$this->data['title'] = 'Reportes de Proyecto Específico';
			$this->load->view($this->vista_master, $this->data);
		}else{
			redirect('/acceso-denegado', 'refresh');
		}
	}


	public function generarReporteProyectoEspecifico($proyecto_id){
		//Estilos
		$boldStyle = array(
	    	'font' => array(
	        	'bold' => true,
	        ),
	    );

	    $tableTitle = array(
	    	'font' => array(
	        	'bold' => true,
	        ),
	    	'alignment' => array(
		        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
		    ),
	    );

	    $borderCell = array(
	    	'borders' => array(
		        'top' => array(
		            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		        ),
		        'bottom' => array(
		            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		        ),
		        'right' => array(
		            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		        ),
		        'left' => array(
		            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		        ),
		    ),
	    );

	    //Obtiene datos
		$datos_proyecto = $this->m_proyecto->consultaInfoProyecto(array('proyecto_id'=>$proyecto_id));
		$proyecto = $this->m_proyecto->consultar($proyecto_id);	
		//exit(var_export($proyecto['valor_oferta']));

		//Crea el objeto de excel
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		//Carga los datos del proyecto en las primeras celdas
		if($proyecto['proyecto']->nombre_proyecto!=null){
			$sheet->setCellValue('A1', 'Nombre de proyecto:');
			$sheet->getStyle('A1')->applyFromArray($boldStyle);
			$sheet->setCellValue('B1', $proyecto['proyecto']->nombre_proyecto);
		}

		if($proyecto['proyecto']->nombre_cliente!=null){
			$sheet->setCellValue('A2', 'Cliente de proyecto:');
			$sheet->getStyle('A2')->applyFromArray($boldStyle);
			$sheet->setCellValue('B2', $proyecto['proyecto']->nombre_cliente);
		}

		if($proyecto['proyecto']->proyecto_estado!=null){
			$sheet->setCellValue('A3', 'Estado de proyecto:');
			$sheet->getStyle('A3')->applyFromArray($boldStyle);
			$sheet->setCellValue('B3', $proyecto['proyecto']->proyecto_estado);
		}
		


		//Carga los valores de la oferta
		$valor_oferta_totales = array();
		$total_valor_oferta = 0;
		if(isset($proyecto['valor_oferta']) && !empty($proyecto['valor_oferta'])){
			//Saca sumatorias
			foreach ($proyecto['valor_oferta'] as $kvalor => $vvalor) {
				$valor_oferta_totales[$vvalor->proyecto_valor_oferta_tipo_id]['tipo'] = $vvalor->proyecto_valor_oferta_tipo;
				if(!isset($valor_oferta_totales[$vvalor->proyecto_valor_oferta_tipo_id]['valor'])){
					$valor_oferta_totales[$vvalor->proyecto_valor_oferta_tipo_id]['valor']  = (double)0;
				}
				$valor_oferta_totales[$vvalor->proyecto_valor_oferta_tipo_id]['valor']  += (double)$vvalor->valor_oferta;
				$total_valor_oferta+= (double)$vvalor->valor_oferta;
			}


			$sheet->mergeCells('A10:B10');
			$sheet->setCellValue('A10', 'Valor de la oferta');
			$sheet->getStyle('A10')->applyFromArray($tableTitle);
			$sheet->getStyle('A10')->applyFromArray($borderCell);
			$sheet->getStyle('B10')->applyFromArray($borderCell);
			$sheet->setCellValue('A11', 'Tipo');
			$sheet->getStyle('A11')->applyFromArray($tableTitle);
			$sheet->getStyle('A11')->applyFromArray($borderCell);
			$sheet->setCellValue('B11', 'Valor');
			$sheet->getStyle('B11')->applyFromArray($tableTitle);
			$sheet->getStyle('B11')->applyFromArray($borderCell);
			$current_position = 12;
			foreach ($valor_oferta_totales as $kvalor => $vvalor) {
				$sheet->setCellValue('A'.$current_position, $vvalor['tipo']);
				$sheet->getStyle('A'.$current_position)->applyFromArray($borderCell);
				$sheet->setCellValue('B'.$current_position, $vvalor['valor']);
				$sheet->getStyle('B'.$current_position)->getNumberFormat()->setFormatCode('$ #,##0.00');
				$sheet->getStyle('B'.$current_position)->applyFromArray($borderCell);
				$current_position++;
			}
		}

		//Carga los gastos 
		$gastos_totales = array();
		$total_gastos = 0;
		if(isset($proyecto['gastos']) && !empty($proyecto['gastos'])){
			//Saca sumatorias
			foreach ($proyecto['gastos'] as $kgasto => $vgasto) {
				$gastos_totales[$vgasto->proyecto_gasto_tipo_id]['tipo'] = $vgasto->proyecto_gasto_tipo;
				if(!isset($gastos_totales[$vgasto->proyecto_gasto_tipo_id]['valor'])){
					$gastos_totales[$vgasto->proyecto_gasto_tipo_id]['valor']  = (double)0;
				}
				$monto_gasto = (double)$vgasto->proyecto_gasto_monto;
				if($vgasto->moneda_id==2){
					$proyecto_tipo_cambio_venta = (double)$proyecto['tipo_cambio']->valor_venta;							
					$monto_gasto = $monto_gasto / $proyecto_tipo_cambio_venta;
				}
				$gastos_totales[$vgasto->proyecto_gasto_tipo_id]['valor']  += (double)round($monto_gasto,2);
				$total_gastos+=(double)round($monto_gasto,2);
			}


			$sheet->mergeCells('D10:E10');
			$sheet->setCellValue('D10', 'Gastos');
			$sheet->getStyle('D10')->applyFromArray($tableTitle);
			$sheet->getStyle('D10')->applyFromArray($borderCell);
			$sheet->getStyle('E10')->applyFromArray($borderCell);
			$sheet->setCellValue('D11', 'Tipo');
			$sheet->getStyle('D11')->applyFromArray($tableTitle);
			$sheet->getStyle('D11')->applyFromArray($borderCell);
			$sheet->setCellValue('E11', 'Valor');
			$sheet->getStyle('E11')->applyFromArray($tableTitle);
			$sheet->getStyle('E11')->applyFromArray($borderCell);
			$current_position = 12;
			foreach ($gastos_totales as $kgasto => $vgasto) {
				$sheet->setCellValue('D'.$current_position, $vgasto['tipo']);
				$sheet->getStyle('D'.$current_position)->applyFromArray($borderCell);
				$sheet->setCellValue('E'.$current_position, $vgasto['valor']);
				$sheet->getStyle('E'.$current_position)->getNumberFormat()->setFormatCode('$ #,##0.00');
				$sheet->getStyle('E'.$current_position)->applyFromArray($borderCell);
				$current_position++;
			}
		}


		//Carga la Valor no consumido 
		if(isset($valor_oferta_totales) && !empty($valor_oferta_totales) || isset($gastos_totales) && !empty($gastos_totales)){
			$sheet->mergeCells('G10:H10');
			$sheet->setCellValue('G10', 'Restante');
			$sheet->getStyle('G10')->applyFromArray($tableTitle);
			$sheet->getStyle('G10')->applyFromArray($borderCell);
			$sheet->getStyle('H10')->applyFromArray($borderCell);
			$sheet->setCellValue('G11', 'Tipo');
			$sheet->getStyle('G11')->applyFromArray($tableTitle);			
			$sheet->getStyle('G11')->applyFromArray($borderCell);
			$sheet->setCellValue('H11', 'Valor');
			$sheet->getStyle('H11')->applyFromArray($tableTitle);
			$sheet->getStyle('H11')->applyFromArray($borderCell);
			$current_position = 12;
			foreach ($valor_oferta_totales as $kvalor => $vvalor) {
				if($kvalor!=5 && $kvalor!=6){
					$gasto_correspondiente = 0;
					if(isset($gastos_totales[$kvalor]['valor']) && $gastos_totales[$kvalor]['valor']!=null){
						$gasto_correspondiente = $gastos_totales[$kvalor]['valor'];
					}
					$sheet->setCellValue('G'.$current_position, $vvalor['tipo']);
					$sheet->getStyle('G'.$current_position)->applyFromArray($borderCell);
					$sheet->setCellValue('H'.$current_position,($vvalor['valor']-$gasto_correspondiente));
					$sheet->getStyle('H'.$current_position)->getNumberFormat()->setFormatCode('$ #,##0.00');
					$sheet->getStyle('H'.$current_position)->applyFromArray($borderCell);
					$current_position++;
				}
			}

			// Muestra total de valor de oferta
			$sheet->setCellValue('A4', 'Valor total de la oferta:');
			$sheet->getStyle('A4')->applyFromArray($boldStyle);
			$sheet->setCellValue('B4', ($total_valor_oferta));
			$sheet->getStyle('B4')->getNumberFormat()->setFormatCode('$ #,##0.00');

			// Muestra total de gastos
			$sheet->setCellValue('A5', 'Gastos totales:');
			$sheet->getStyle('A5')->applyFromArray($boldStyle);
			$sheet->setCellValue('B5', ($total_gastos));
			$sheet->getStyle('B5')->getNumberFormat()->setFormatCode('$ #,##0.00');

			// Muestra total de utilidad
			$sheet->setCellValue('A6', 'Utilidad actual:');
			$sheet->getStyle('A6')->applyFromArray($boldStyle);
			$sheet->setCellValue('B6', ($total_valor_oferta-$total_gastos));
			$sheet->getStyle('B6')->getNumberFormat()->setFormatCode('$ #,##0.00');
		}


		$sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->getColumnDimension('D')->setAutoSize(true);
		$sheet->getColumnDimension('E')->setAutoSize(true);
		$sheet->getColumnDimension('G')->setAutoSize(true);
		$sheet->getColumnDimension('H')->setAutoSize(true);


		//Genera el archivo
		$writer = new Xlsx($spreadsheet);
		// We'll be outputting an excel file
		header('Content-type: application/vnd.ms-excel');

		// It will be called file.xls
		header('Content-Disposition: attachment; filename="Reporte_Proyecto_'.str_replace(' ', '_', $proyecto['proyecto']->nombre_proyecto).'_'.date('Y_m_d').'.xlsx"');

		// Write file to the browser
		$writer->save('php://output');
	}
}