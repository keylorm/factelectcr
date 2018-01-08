myApp.controller('empresaController', ['$scope','$log','$http', '$filter', function($scope, $log, $http, $filter){
	$scope.nombre_cliente = '';
	$scope.cedula_cliente = '';
	$scope.estado_cliente = 1;
	$scope.cantidad_mostrar = 20;
	$scope.total_rows = 0;
	$scope.pages = 1;
	$scope.q = '';
	$scope.loaded = false;
	$scope.sindatos=false;

    $scope.currentPage = 0;	



	$scope.filtrarCliente = function(){
		$scope.consultarClientes();
	};

	$scope.consultarClientes = function(){
		$http({
	        url: '/configuracion/consultaEmpresasAjax/',
	        method: "POST",
	        /*data: {  filtros: { 
									nombre_cliente: $scope.nombre_cliente, 
									cedula_cliente: $scope.cedula_cliente, 
									estado_cliente: $scope.estado_cliente
								},
								cantidad_mostrar: $scope.cantidad_mostrar,
	    			},*/
	    })
		.then(function(result){
			$log.log(result.data);
			if(result.data.company!==undefined){
				if(result.data.company.company_id!==undefined){
					$scope.companies = {0: result.data.company};
					$scope.total_rows = 1;
					
				}else{
					$scope.companies = result.data.company;
					$scope.total_rows = result.data.company.length;
				}
				
			}else{
				$scope.sindatos=true;
			}
			$scope.loaded = true;
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

	$scope.consultarClientes();
}]);