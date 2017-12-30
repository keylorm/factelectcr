myApp.controller('clienteController', ['$scope','$log','$http', '$filter', function($scope, $log, $http, $filter){
	$scope.nombre_cliente = '';
	$scope.cedula_cliente = '';
	$scope.estado_cliente = 1;
	$scope.cantidad_mostrar = 20;
	$scope.total_rows = 0;
	$scope.pages = 1;
	$scope.q = '';

    $scope.currentPage = 0;	



	$scope.filtrarCliente = function(){
		$scope.consultarClientes();
	};

	$scope.consultarClientes = function(){
		$http({
	        url: '/cliente/consultaClientesAjax/',
	        method: "POST",
	        data: {  filtros: { 
									nombre_cliente: $scope.nombre_cliente, 
									cedula_cliente: $scope.cedula_cliente, 
									estado_cliente: $scope.estado_cliente
								},
								cantidad_mostrar: $scope.cantidad_mostrar,
	    			},
	    })
		.then(function(result){
			$scope.clientes = result.data.datos;
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

	$scope.consultarClientes();
}]);

/*(function($){
	$(document).ready(function(){
		$('.ajax-form').submit(function(e){
			e.preventDefault();
			var fm = $(this);
			var form = fm[0];
			var formData = new FormData(form);
			$.ajax({
		        url: '/cliente/consultaClientesAjax/',
		        method: "POST",
		        data: formData,
		        dataType: 'json',
				cache: false,
				contentType: false,
				processData: false
		    })
			.done(function(result){
				console.log(result);
			});

		});
	});
})(jQuery);*/