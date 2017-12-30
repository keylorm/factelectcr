myApp.controller('proyectoController', ['$scope','$log','$http', '$filter', function($scope, $log, $http, $filter){
	$scope.cantidad_mostrar = 20;
	$scope.total_rows = 0;
	$scope.pages = 1;
	$scope.q = '';

    $scope.currentPage = 0;	



	$scope.filtrarProyecto = function(){
		$scope.consultarProyecto();
	};

	$scope.limpiarFiltro = function(){
		$scope.nombre_proyecto = '';
		$scope.proyecto_estado_id = 'all';
		$scope.cliente_id = 'all';
		$scope.numero_contrato = '';
		$scope.orden_compra = '';
		$scope.provincia_id = 'all';
		$scope.canton_id = 'all';
		$scope.distrito_id = 'all';		
		$scope.fecha_registro_from = '';
		$scope.fecha_registro_to = '';		
		$scope.fecha_firma_contrato_from = '';
		$scope.fecha_firma_contrato_to = '';		
		$scope.fecha_inicio_from = '';
		$scope.fecha_inicio_to = '';	
		$scope.fecha_entrega_estimada_from = '';
		$scope.fecha_entrega_estimada_to = '';
		$scope.consultarProyecto();	
	}

	$scope.consultarProyecto = function(){
		$http({
	        url: '/factura/consultaFacturasAjax/',
	        method: "POST",
	        data: {  filtros: { 
									nombre_proyecto: $scope.nombre_proyecto, 
									proyecto_estado_id: $scope.proyecto_estado_id, 
									cliente_id: $scope.cliente_id,
									numero_contrato: $scope.numero_contrato,
									orden_compra: $scope.orden_compra,
									provincia_id: $scope.provincia_id,
									canton_id: $scope.canton_id,
									distrito_id: $scope.distrito_id,
									fecha_registro: {
										from: $scope.fecha_registro_from,
										to: $scope.fecha_registro_to,
									},
									fecha_firma_contrato: {
										from: $scope.fecha_firma_contrato_from,
										to: $scope.fecha_firma_contrato_to,
									},
									fecha_inicio: {
										from: $scope.fecha_inicio_from,
										to: $scope.fecha_inicio_to,
									},
									fecha_entrega_estimada: {
										from: $scope.fecha_entrega_estimada_from,
										to: $scope.fecha_entrega_estimada_to,
									},
								},
								cantidad_mostrar: $scope.cantidad_mostrar,
	    			},
	    })
		.then(function(result){
			$scope.proyectos = result.data.datos;
			$scope.total_rows = result.data.total_rows;
			$scope.calcularPaginas();
		},function(result){
			$log.error(result);
		});
	}

	$scope.validarPrev = function(){
		if($scope.currentPage > 0){
			return false;
		}else{
			return	true;
		}
	}

	$scope.validarNext = function(){
		if($scope.currentPage >= ($scope.pages-1)){
			return true;
		}else{
			return	false;
		}
	}

	$scope.pagePrev = function(){
		$scope.currentPage = $scope.currentPage-1;
	}

	$scope.pageNext = function(){
		$scope.currentPage = $scope.currentPage+1;
	}

	$scope.calcularPaginas =  function(){
		if($scope.total_rows > $scope.cantidad_mostrar){
			$scope.pages = Math.ceil($scope.total_rows / $scope.cantidad_mostrar);
		}
	}

	$scope.consultarProyecto();



	$scope.getCantones = function(){
		$scope.canton_id = 'all';
		$scope.distrito_id = 'all';
		$scope.consultarCantones();
	}

	$scope.getDistritos = function(){
		$scope.distrito_id = 'all';
		$scope.consultarDistritos();
	}

	$scope.consultarCantones = function(){
		if($scope.provincia_id!='none'){
			$http({
		        url: '/factura/consultaCantonesAjax/',
		        method: "POST",
		        data: {  provincia_id: $scope.provincia_id },
		    })
			.then(function(result){
				$scope.cantones = result.data.datos;
			},function(result){
				$scope.cantones = '';
				$log.error(result);
			});
			
		}else{
			$scope.cantones = '';
		}
	}


	$scope.consultarDistritos = function(){
		if($scope.canton_id!='none'){
			$http({
		        url: '/factura/consultaDistritosAjax/',
		        method: "POST",
		        data: {  canton_id: $scope.canton_id },
		    })
			.then(function(result){
				$scope.distritos = result.data.datos;
			},function(result){
				$scope.distritos = '';
				$log.error(result);
			});
		}else{
			$scope.distritos = '';
		}
	}

}]);

myApp.controller('agregarProyectoController', ['$scope','$log','$http', '$filter', function($scope, $log, $http, $filter){

	//Variables
	$scope.valor_utilidad = 0;
	$scope.valor_materiales = 0;
	$scope.valor_mano_obra = 0;
	$scope.valor_gastos_operacion = 0;
	$scope.valor_gastos_administrativos = 0;
	$scope.total_oferta = 0;

	$scope.getCantones = function(){
		$scope.canton_id = '';
		$scope.distrito_id = '';
		$scope.consultarCantones();
	}

	$scope.getDistritos = function(){
		$scope.distrito_id = '';
		$scope.consultarDistritos();
	}

	$scope.updateValorOferta = function(){
		$scope.calcularValorOferta();
	}

	$scope.consultarCantones = function(){
		if($scope.provincia_id!='none'){
			$http({
		        url: '/factura/consultaCantonesAjax/',
		        method: "POST",
		        data: {  provincia_id: $scope.provincia_id },
		    })
			.then(function(result){
				$scope.cantones = result.data.datos;
			},function(result){
				$scope.cantones = '';
				$log.error(result);
			});
			
		}else{
			$scope.cantones = '';
		}
	}


	$scope.consultarDistritos = function(){
		if($scope.canton_id!='none'){
			$http({
		        url: '/factura/consultaDistritosAjax/',
		        method: "POST",
		        data: {  canton_id: $scope.canton_id },
		    })
			.then(function(result){
				$scope.distritos = result.data.datos;
			},function(result){
				$scope.distritos = '';
				$log.error(result);
			});
		}else{
			$scope.distritos = '';
		}
	}

	$scope.calcularValorOferta = function(){
		var valMateriales = ($scope.valor_materiales)?$scope.valor_materiales.toString().replace(' ',''):0;
		var valManoObra = ($scope.valor_mano_obra)?$scope.valor_mano_obra.toString().replace(' ',''):0;
		var valGastosOpe = ($scope.valor_gastos_operacion)?$scope.valor_gastos_operacion.toString().replace(' ',''):0;
		var valGastosAdm = ($scope.valor_gastos_administrativos)?$scope.valor_gastos_administrativos.toString().replace(' ',''):0;
		var valUtilidad = ($scope.valor_utilidad)?$scope.valor_utilidad.toString().replace(' ',''):0;
		if(valMateriales!='' || valManoObra!='' || valGastosOpe!='' || valGastosAdm!='' ||valUtilidad!=''){
			return parseFloat(valMateriales) + parseFloat(valManoObra) + parseFloat(valGastosOpe) + parseFloat(valGastosAdm) + parseFloat(valUtilidad);
		}else{
			return 0;
		}
	}

}]);


myApp.controller('editarProyectoController', ['$scope','$log','$http', '$filter', function($scope, $log, $http, $filter){

	//Variables


	$scope.getCantones = function(){
		$scope.canton_id = '';
		$scope.distrito_id = '';
		$scope.consultarCantones();
	}

	$scope.getDistritos = function(){
		$scope.distrito_id = '';
		$scope.consultarDistritos();
	}

	$scope.updateValorOferta = function(){
		$scope.calcularValorOferta();
	}

	$scope.consultarCantones = function(){
		if($scope.provincia_id!='none'){
			$http({
		        url: '/factura/consultaCantonesAjax/',
		        method: "POST",
		        data: {  provincia_id: $scope.provincia_id },
		    })
			.then(function(result){
				$scope.cantones = result.data.datos;
			},function(result){
				$scope.cantones = '';
				$log.error(result);
			});
			
		}else{
			$scope.cantones = '';
		}
	}


	$scope.consultarDistritos = function(){
		if($scope.canton_id!='none'){
			$http({
		        url: '/factura/consultaDistritosAjax/',
		        method: "POST",
		        data: {  canton_id: $scope.canton_id },
		    })
			.then(function(result){
				$scope.distritos = result.data.datos;
			},function(result){
				$scope.distritos = '';
				$log.error(result);
			});
		}else{
			$scope.distritos = '';
		}
	}

	$scope.calcularValorOferta = function(){
		var valMateriales = ($scope.valor_materiales)?$scope.valor_materiales.toString().replace(' ',''):0;
		var valManoObra = ($scope.valor_mano_obra)?$scope.valor_mano_obra.toString().replace(' ',''):0;
		var valGastosOpe = ($scope.valor_gastos_operacion)?$scope.valor_gastos_operacion.toString().replace(' ',''):0;
		var valGastosAdm = ($scope.valor_gastos_administrativos)?$scope.valor_gastos_administrativos.toString().replace(' ',''):0;
		var valUtilidad = ($scope.valor_utilidad)?$scope.valor_utilidad.toString().replace(' ',''):0;
		if(valMateriales!='' || valManoObra!='' || valGastosOpe!='' || valGastosAdm!='' ||valUtilidad!=''){
			return parseFloat(valMateriales) + parseFloat(valManoObra) + parseFloat(valGastosOpe) + parseFloat(valGastosAdm) + parseFloat(valUtilidad);
		}else{
			return 0;
		}
	}

}]);


myApp.controller('proyectoDashboard', ['$scope', '$log', '$http', '$filter', function($scope,$log,$http,$filter){

	$scope.total_valor_oferta = 0;
	$scope.consultarInfoProyecto = function (){
		$http({
	        url: '/factura/consultaFacturaInfoAjax/',
	        method: "POST",
	        data: {  proyecto_id : $scope.proyecto_id, }
	    })
		.then(function(result){
			$log.log(result.data);
			$scope.total_valor_oferta = result.data.valor_oferta.total;
		},function(result){
			$log.error(result);
		});
	}
}]);