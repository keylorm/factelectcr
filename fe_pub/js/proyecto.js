myApp.controller('proyectoController', ['$scope','$log','$http', '$filter', '$window', function($scope, $log, $http, $filter, $window){
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
	        url: '/proyecto/consultaProyectosAjax/',
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
		        url: '/proyecto/consultaCantonesAjax/',
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
		        url: '/proyecto/consultaDistritosAjax/',
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


	$scope.borrarRow = function(row_id){
		$http({
	        url: '/proyecto/eliminarProyectoAjax/',
	        method: "POST",
	        data: {  proyecto_id: row_id },
	    })
		.then(function(result){
			if(result.data!=="false"){
				$window.location.href ='/proyectos';
				return true;

			}else{
				$window.location.href = '/proyectos';
				return false;
			}
		},function(result){
			$log.error(result);
		});
	}

}]);

myApp.controller('agregarProyectoController', ['$scope','$log','$http', '$filter', '$window', function($scope, $log, $http, $filter, $window){

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
		        url: '/proyecto/consultaCantonesAjax/',
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
		        url: '/proyecto/consultaDistritosAjax/',
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


myApp.controller('editarProyectoController', ['$scope','$log','$http', '$filter', '$window', function($scope, $log, $http, $filter, $window){

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
		        url: '/proyecto/consultaCantonesAjax/',
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
		        url: '/proyecto/consultaDistritosAjax/',
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


myApp.controller('proyectoDashboard', ['$scope','$log','$http', '$filter', '$window', function($scope, $log, $http, $filter, $window){
	$scope.datasetOverride = {
	    backgroundColor: ['#F20600', '#2915A8', '#0A920A', '#DFDF00', '#DD0C82', '#0EA1BD', '#8A14C6', '#FF7B0E'],
	    hoverBackgroundColor: ['#C00500', '#1F0F85', '#007700', '#BDBD35', '#920153', '#045F70', '#520779', '#B65402'],
	    hoverBorderColor: ['#C00500', '#1F0F85', '#007700', '#BDBD35', '#920153', '#045F70', '#520779', '#B65402']
	};
	var pieOptions = {
	  legend: {
	            display: true,
	            position: 'bottom',
	        },
	  /*animation: {
	    duration: 500,
	    easing: "easeOutQuart",
	    onComplete: function () {
	      var ctx = this.chart.ctx;
	      ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
	      ctx.textAlign = 'center';
	      ctx.textBaseline = 'bottom';

	      this.data.datasets.forEach(function (dataset) {

	        for (var i = 0; i < dataset.data.length; i++) {
	          var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model,
	              total = dataset._meta[Object.keys(dataset._meta)[0]].total,
	              mid_radius = model.innerRadius + (model.outerRadius - model.innerRadius)/2,
	              start_angle = model.startAngle,
	              end_angle = model.endAngle,
	              mid_angle = start_angle + (end_angle - start_angle)/2;

	          var x = mid_radius * Math.cos(mid_angle);
	          var y = mid_radius * Math.sin(mid_angle);

	          ctx.fillStyle = '#fff';
	          if (i == 3){ // Darker text color for lighter background
	            ctx.fillStyle = '#444';
	          }
	          var percent = String(Math.round(dataset.data[i]/total*100)) + "%";
	          ctx.fillText('$ '+dataset.data[i], model.x + x, model.y + y);
	          // Display percent in another line, line break doesn't work for fillText
	          ctx.fillText(percent, model.x + x, model.y + y + 15);
	        }
	      });               
	    }
	  },*/
	  	tooltips: {
			callbacks: {
				label: function(tooltipItem, data) {
					var allData = data.datasets[tooltipItem.datasetIndex].data;
					var tooltipLabel = data.labels[tooltipItem.index];
					var tooltipData = allData[tooltipItem.index];
					var total = 0;
					for (var i in allData) {
						total += allData[i];
					}
					var tooltipPercentage = Math.round((tooltipData / total) * 100);
					return tooltipLabel + ': $ ' + parseFloat(tooltipData).toFixed(2)  + ' (' + tooltipPercentage + '%)';
				}
			}
		},
		backgroundColor: ['rgba(151,187,205,0.7)', 'rgba(220,220,220,0.7)', 'rgba(247,70,740, 0.7)', 'rgba(70,191,189,0.7)', 'rgba(253,180,92,0.7)', 'rgba(148,159,177,0.7)', 'rgba(77,83,96,0.7)'],
	};


	// Valor de oferta
	$scope.total_valor_oferta = 0;
	$scope.data_chart_valor_oferta = { 
		labels: [], 
		data: [], 
		options : pieOptions,
	};
	$scope.data_valor_oferta = {};

	// Valor de gastos
	$scope.total_gastos = 0;
	$scope.data_chart_gastos = { 
		labels: [], 
		data: [], 
		options : pieOptions,
	};
	$scope.data_gastos = {};

	// Valor de utilidad
	$scope.total_utilidad = 0;	
	$scope.data_utilidad = {};



	$scope.consultarInfoProyecto = function (){
		$http({
	        url: '/proyecto/consultaProyectoInfoAjax/',
	        method: "POST",
	        data: {  proyecto_id : $scope.proyecto_id, }
	    })
		.then(function(result){
			for(var x in result.data.valor_oferta.desgloce){
				$scope.data_chart_valor_oferta.labels.push(result.data.valor_oferta.desgloce[x].tipo);
				$scope.data_chart_valor_oferta.data.push(result.data.valor_oferta.desgloce[x].valor);
			}

			$scope.data_valor_oferta = result.data.valor_oferta.desgloce;
			$scope.total_valor_oferta = result.data.valor_oferta.total;


			for(var x in result.data.gastos.desgloce){
				$scope.data_chart_gastos.labels.push(result.data.gastos.desgloce[x].tipo);
				$scope.data_chart_gastos.data.push(result.data.gastos.desgloce[x].valor);
			}

			$scope.data_gastos = result.data.gastos.desgloce;
			$scope.total_gastos = result.data.gastos.total;

			
			$scope.total_utilidad = result.data.valor_oferta.total - result.data.gastos.total;


			
		},function(result){
			$log.error(result);
		});
	}

	$scope.borrarRow = function(row_id){
		$http({
	        url: '/proyecto/eliminarProyectoAjax/',
	        method: "POST",
	        data: {  proyecto_id: row_id },
	    })
		.then(function(result){
			if(result.data!=="false"){
				$window.location.href ='/proyectos';
				return true;

			}else{
				$window.location.href = '/proyectos';
				return false;
			}
		},function(result){
			$log.error(result);
		});
	}

}]);


myApp.controller('proyectoExtensionesController', ['$scope','$log','$http', '$filter', '$window', function($scope, $log, $http, $filter, $window){
	$scope.cantidad_mostrar = 20;
	$scope.total_rows = 0;
	$scope.pages = 1;
	$scope.q = '';

    $scope.currentPage = 0;	

    $scope.proyecto_valor_oferta_extension_tipo_id = 'all';		
	$scope.fecha_registro_from = '';
	$scope.fecha_registro_to = '';	

    $scope.filtrar = function(){
		$scope.consultarExtensionesProyecto();
	};

	$scope.limpiarFiltro = function(){
		$scope.proyecto_valor_oferta_extension_tipo_id = 'all';		
		$scope.fecha_registro_from = '';
		$scope.fecha_registro_to = '';		
		$scope.consultarExtensionesProyecto();	
	}



	$scope.consultarExtensionesProyecto = function(){
		$http({
	        url: '/proyecto/consultaExtensionesProyectosAjax/',
	        method: "POST",
	        data: {  filtros: { 
									proyecto_id: $scope.proyecto_id,
									proyecto_valor_oferta_extension_tipo_id: $scope.proyecto_valor_oferta_extension_tipo_id,
									fecha_registro: {
										from: $scope.fecha_registro_from,
										to: $scope.fecha_registro_to,
									}, 									
								},
								cantidad_mostrar: $scope.cantidad_mostrar,
	    			},
	    })
		.then(function(result){
			if(result.data!=="false"){
				$scope.extensiones = result.data.datos;
				$scope.total_rows = result.data.total_rows;
				$scope.calcularPaginas();

			}else{
				$scope.extensiones = false;
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

	$scope.borrarRow = function(row_id){
		$http({
	        url: '/proyecto/eliminarExtensionAjax/',
	        method: "POST",
	        data: {  extension_id: row_id },
	    })
		.then(function(result){
			if(result.data!=="false"){
				$window.location.reload();
				return true;

			}else{
				$window.location.reload();
				return false;
			}
		},function(result){
			$log.error(result);
		});
	}

}]);

myApp.controller('proyectoGastosController', ['$scope','$log','$http', '$filter', '$window','$timeout', function($scope, $log, $http, $filter, $window, $timeout){
	$scope.cantidad_mostrar = 20;
	$scope.total_rows = 0;
	$scope.pages = 1;
	$scope.q = '';

    $scope.currentPage = 0;	


    $scope.proyecto_gasto_tipo_id = 'all';
    $scope.proveedor_id = 'all';
	$scope.proyecto_gasto_estado_id = 'all';		
	$scope.numero_factura = '';
	$scope.fecha_registro_from = '';
	$scope.fecha_registro_to = '';
	$scope.fecha_gasto_from = '';
	$scope.fecha_gasto_to = '';	

    $scope.filtrar = function(){
		$scope.consultarGastosProyecto();
	};

	$scope.limpiarFiltro = function(){
		$scope.proyecto_gasto_tipo_id = 'all';
		$scope.proveedor_id = 'all';
		$scope.proyecto_gasto_estado_id = 'all';		
		$scope.numero_factura = '';
		$scope.fecha_registro_from = '';
		$scope.fecha_registro_to = '';		
		$scope.fecha_gasto_from = '';
		$scope.fecha_gasto_to = '';	
		$scope.consultarGastosProyecto();	
	}

	$scope.consultarGastosProyecto = function(){
		$http({
	        url: '/proyecto/consultaGastosProyectosAjax/',
	        method: "POST",
	        data: {  filtros: { 
									proyecto_id: $scope.proyecto_id, 
									proyecto_gasto_tipo_id: $scope.proyecto_gasto_tipo_id,
									fecha_registro: {
										from: $scope.fecha_registro_from,
										to: $scope.fecha_registro_to,
									},
									fecha_gasto: {
										from: $scope.fecha_gasto_from,
										to: $scope.fecha_gasto_to,
									},
									proveedor_id: $scope.proveedor_id,
									numero_factura: $scope.numero_factura,
									proyecto_gasto_estado_id: $scope.proyecto_gasto_estado_id,									
								},
								cantidad_mostrar: $scope.cantidad_mostrar,
	    			},
	    })
		.then(function(result){
			$log.log(result.data);
			if(result.data!=="false"){
				$scope.gastos = result.data.datos;
				$scope.total_rows = result.data.total_rows;
				$scope.currentPage = 0;	
				$scope.calcularPaginas();
			}else{
				$scope.gastos = false;
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

	$scope.borrarRow = function(row_id){
		$http({
	        url: '/proyecto/eliminarGastoAjax/',
	        method: "POST",
	        data: {  gasto_id: row_id },
	    })
		.then(function(result){
			if(result.data!=="false"){
				$window.location.reload();
				return true;

			}else{
				$window.location.reload();
				return false;
			}
		},function(result){
			$log.error(result);
		});
	}


	$scope.inputMask = function(){
		$timeout(function(){
			jQuery(".input-money-mask").maskMoney({prefix:'$ ', allowNegative: true, thousands:' ', decimal:'.', affixesStay: false});
			jQuery(".input-money-mask-colones").maskMoney({prefix:'₡ ', allowNegative: true, thousands:' ', decimal:'.', affixesStay: false});
			
		},1);
	}

	$scope.chosenSelect = function(){
		$timeout(function(){
			jQuery(".chosen-select").chosen({no_results_text: "Sin resultados."}); 
		},1);
	}

}]);

myApp.controller('agregarProyectoGastoController', ['$scope','$log','$http', '$filter', '$window', '$timeout', function($scope, $log, $http, $filter, $window, $timeout){
	$scope.moneda_id = 1;



	$scope.inputMask = function(){
		$timeout(function(){
			jQuery(".input-money-mask").maskMoney({prefix:'$ ', allowNegative: true, thousands:' ', decimal:'.', affixesStay: false});
			jQuery(".input-money-mask-colones").maskMoney({prefix:'₡ ', allowNegative: true, thousands:' ', decimal:'.', affixesStay: false});
			
		},1);
	}

	$scope.chosenSelect = function(){
		$timeout(function(){
			jQuery(".chosen-select").chosen({no_results_text: "Sin resultados."}); 
		},1);
	}

}]);

myApp.controller('editarProyectoGastoController', ['$scope','$log','$http', '$filter', '$window', '$timeout', function($scope, $log, $http, $filter, $window, $timeout){
	$scope.moneda_id = 1;



	$scope.inputMask = function(){
		$timeout(function(){
			jQuery(".input-money-mask").maskMoney({prefix:'$ ', allowNegative: true, thousands:' ', decimal:'.', affixesStay: false});
			jQuery(".input-money-mask-colones").maskMoney({prefix:'₡ ', allowNegative: true, thousands:' ', decimal:'.', affixesStay: false});
			
		},1);
	}

	$scope.chosenSelect = function(){
		$timeout(function(){
			jQuery(".chosen-select").chosen({no_results_text: "Sin resultados."}); 
		},1);
	}

}]);