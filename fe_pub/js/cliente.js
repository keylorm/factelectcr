myApp.controller('clienteController', ['$scope','$log','$http', '$filter', function($scope, $log, $http, $filter){
	$scope.nombre_cliente = '';
	$scope.cedula_cliente = '';
	$scope.estado_cliente = 1;
	$scope.cantidad_mostrar = 20;
	$scope.total_rows = 0;
	$scope.pages = 1;
	$scope.q = '';
	$scope.loaded = false;
	$scope.sindatos=false;
	$scope.loadedcompany = false;

    $scope.currentPage = 0;	



	$scope.filtrarCliente = function(){
		$scope.loaded = false;
		$scope.sindatos = false;
		$scope.consultarClientes();
	};

	$scope.consultarClientes = function(){
		filtroObject = {};
		if($scope.company_id!=='all'){
			filtroObject = {
								filtros: {
									company_id: $scope.company_id
								}
							};
		}
		$http({
	        url: '/cliente/consultaClientesAjax/',
	        method: "POST",
	        data: filtroObject,
	    })
		.then(function(result){
			if(result.data.customer!==undefined){
				if(result.data.customer.customer_id!==undefined){
					$scope.clientes = {0: result.data.customer};
					$scope.total_rows = 1;
					
				}else{
					$scope.clientes = result.data.customer;
					$scope.total_rows = result.data.customer.length;
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

	$scope.consultarEmpresas = function(){
		$http({
	        url: '/configuracion/consultaEmpresasAjax/',
	        method: "POST",
	        
	    })
		.then(function(result){
			if(result.data.company!==undefined){
				if(result.data.company.company_id!==undefined){
					$scope.companies = {0: result.data.company};
					$scope.total_rows = 1;
					$scope.company_id='all';
				}else{
					$scope.companies = result.data.company;
					$scope.total_rows = result.data.company.length;
					$scope.company_id='all';
				}
				
				$scope.loadedcompany = true;
			}
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

	$scope.consultarEmpresas();
	$scope.consultarClientes();
}]);


myApp.controller('agregarClienteController', ['$scope','$log','$http', '$filter', function($scope, $log, $http, $filter){
	$scope.tipo_cliente = 1;
	$scope.phones = [{id: 'phone1'}];
	$scope.emails = [{id: 'email1'}];
	$scope.addresses = [{id: 'address1', address_country: 'CR' }];
	

	$scope.addNewAddress = function() {
	    var newItemNo = $scope.addresses.length+1;
	    $scope.addresses.push({id:'address'+newItemNo, address_country : 'CR'});
	};
	    
	$scope.removeAddress = function() {
	    var lastItem = $scope.addresses.length-1;
	    $scope.addresses.splice(lastItem);
	};
	$scope.addNewPhone = function() {
	    var newItemNo = $scope.phones.length+1;
	    $scope.phones.push({id:'phone'+newItemNo});
	};
	    
	$scope.removePhone = function() {
	    var lastItem = $scope.phones.length-1;
	    $scope.phones.splice(lastItem);
	};	

	$scope.addNewEmail = function() {
	    var newItemNo = $scope.emails.length+1;
	    $scope.emails.push({id:'phone'+newItemNo});
	};
	    
	$scope.removeEmail = function() {
	    var lastItem = $scope.emails.length-1;
	    $scope.emails.splice(lastItem);
	};	


    $scope.cambio = function(){    	
   		//$log.log($scope.tipo_cliente);
    }

	$scope.getPaises = function(){
		$scope.consultarPaises();
	}
	$scope.getProvincias = function(){		
		$scope.consultarProvincias();
	}

    $scope.getCantones = function(index){
    	$scope.addresses[index].canton_id = '';
		$scope.addresses[index].distrito_id = '';
		$scope.addresses[index].barrio_id = '';
		$scope.consultarCantones(index);
	}

	$scope.getDistritos = function(index){
		$scope.addresses[index].distrito_id = '';
		$scope.addresses[index].barrio_id = '';
		$scope.consultarDistritos(index);
	}

	$scope.getBarrios = function(index){
		$scope.addresses[index].barrio_id = '';
		$scope.consultarBarrios(index);
	}

	$scope.consultarPaises = function(){
		$http({
	        url: '/general/consultaPaisesAjax/',
	        method: "POST",
	    })
		.then(function(result){
			$scope.paises = result.data.datos;
		},function(result){
			$scope.paises = '';
			$log.error(result);
		});
	}


	$scope.consultarProvincias = function(){
		
		$http({
	        url: '/general/consultaProvinciasAjax/',
	        method: "POST",
	    })
		.then(function(result){
			$scope.provincias = result.data.datos;
		},function(result){
			$scope.provincias = '';
			$log.error(result);
		});
		
	}


	$scope.consultarCantones = function(index){
		if($scope.provincia_id!='none'){
			$http({
		        url: '/proyecto/consultaCantonesAjax/',
		        method: "POST",
		        data: {  provincia_id: $scope.addresses[index].provincia_id },
		    })
			.then(function(result){
				$scope.addresses[index].cantones = result.data.datos;
			},function(result){
				$scope.addresses[index].cantones = '';
				$log.error(result);
			});
			
		}else{
			$scope.cantones = '';
		}
	}


	$scope.consultarDistritos = function(index){
		if($scope.canton_id!='none'){
			$http({
		        url: '/proyecto/consultaDistritosAjax/',
		        method: "POST",
		        data: {  provincia_id: $scope.addresses[index].provincia_id,
		        		canton_id: $scope.addresses[index].canton_id },
		    })
			.then(function(result){
				$scope.addresses[index].distritos = result.data.datos;
			},function(result){
				$scope.addresses[index].distritos = '';
				$log.error(result);
			});
		}else{
			$scope.distritos = '';
		}
	}

	$scope.consultarBarrios = function(index){
		if($scope.distrito_id!='none'){
			$http({
		        url: '/general/consultaBarriosAjax/',
		        method: "POST",
		        data: {  
		        		provincia_id: $scope.addresses[index].provincia_id,
		        		canton_id: $scope.addresses[index].canton_id,
		        		distrito_id: $scope.addresses[index].distrito_id },
		    })
			.then(function(result){
				$scope.addresses[index].barrios = result.data.datos;
			},function(result){
				$scope.addresses[index].barrios = '';
				$log.error(result);
			});
			
		}else{
			$scope.barrios = '';
		}
	}

	$scope.consultarPaises();
	$scope.consultarProvincias();


	
}]);

myApp.controller('editarClienteController', ['$scope','$log','$http', '$filter', function($scope, $log, $http, $filter){
	$scope.tipo_cliente = 'fisico';


    $scope.cambio = function(){
    	
   		$log.log($scope.tipo_cliente);
    }
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