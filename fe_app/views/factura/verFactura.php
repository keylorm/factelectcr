<script src="/fe_pub/js/factura.js"></script>
<!-- Breadcrumbs-->
<ol class="breadcrumb">
	<li class="breadcrumb-item">
	  <a href="/">Inicio</a>
	</li>
	<li class="breadcrumb-item">
	  <a href="/proyectos">Proyectos</a>
	</li>
	<li class="breadcrumb-item active">Ver proyecto</li>
</ol>
<h1  class="text-center"><i class="fa fa-fw fa-handshake-o"></i> Proyectos</h1>
<hr>
<div class="row">
	<div class="col-12 col-md-10"><h3 class=" text-center text-md-left"><i class="fa fa-fw fa-eye"></i> Ver proyecto: <?=$proyecto->nombre_proyecto?></h3></div>
	<div class="col-12 col-md-2"><a class="float-right btn btn-primary" href="/proyectos/editar-proyecto/<?=$proyecto->proyecto_id?>" role="button"><i class="fa fa-fw fa-edit"></i> Editar proyecto</a></div>
</div>

<div class="page-content" ng-controller="proyectoDashboard" ng-init="proyecto_id='<?=$proyecto->proyecto_id?>'; consultarInfoProyecto();">
	
			<div class="card mb-3">
		        <div class="card-header">
		          	<i class="fa fa-money"></i> Valor de la oferta</div>
		        <div class="card-body">
		        	<div class="row">
						<div class="col-12 col-md-6">
							<h3 class="text-center">Total de la oferta</h3>
							<div class="total-oferta">
								<p class="display-4 text-center">{{total_valor_oferta | currency}}</p>
							</div>
		        		</div>
						<div class="col-12 col-md-6">
							<h3 class="center">Distribución de la oferta por tipo</h3>
							<canvas id="chart-valor-oferta"></canvas>
						</div>
					</div>
		        </div>
		    </div>
		
	

</div>