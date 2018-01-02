<script src="/fe_pub/js/proyecto.js"></script>
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
<div class="page-content" ng-controller="proyectoDashboard" ng-init="proyecto_id='<?=$proyecto->proyecto_id?>'; consultarInfoProyecto();">
	<div class="row">
		<div class="col-12"><h3 class=" text-center text-md-left"><i class="fa fa-fw fa-eye"></i> Ver proyecto: <?=$proyecto->nombre_proyecto?></h3></div>
		<div class="col-12">
			<a class="btn btn-success mr-md-3 mx-auto d-block d-md-inline-block mb-3" href="/proyectos/gastos/<?=$proyecto->proyecto_id?>" role="button"><i class="fa fa-fw fa-plus-circle"></i> Gastos</a>
			<a class="btn btn-success mr-md-3 mx-auto d-block d-md-inline-block mb-3" href="/proyectos/extensiones/<?=$proyecto->proyecto_id?>" role="button"><i class="fa fa-fw fa-plus-circle"></i> Extensiones</a> 
			<a class="btn btn-secondary mb-3 mr-md-3 mx-auto d-block d-md-inline-block" href="/reporte/generarReporteProyectoEspecifico/<?=$proyecto->proyecto_id?>" role="button" target="_blank"><i class="fa fa-download"></i> Generar reporte</a> 
			<a class="btn btn-primary mb-3 mr-md-3 mx-auto d-block d-md-inline-block" href="/proyectos/editar-proyecto/<?=$proyecto->proyecto_id?>" role="button"><i class="fa fa-fw fa-edit"></i> Editar proyecto</a> 
			<?php if(isset($rol_id) && $rol_id==1){ ?>
				<a class="btn btn-danger mb-3 mr-md-3 mx-auto d-block d-md-inline-block" href="#" data-toggle="modal" data-target="#deleteModal{{proyecto_id}}"><i class="fa fa-fw fa-trash-o"></i> Eliminar proyecto</a>
				<!-- Modal -->
				<div class="modal fade" id="deleteModal{{proyecto_id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
					  <div class="modal-header">
					    <h5 class="modal-title" id="deleteModalLabel">¿Está seguro que desea eliminar este proyecto?</h5>
					    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					      <span aria-hidden="true">&times;</span>
					    </button>
					  </div>
					  <div class="modal-body">
					    Se elimará toda la información relacionada a este proyecto, como gastos, valor de la oferta, registro de horas de trabajo, extensiones de valor de la oferta, etc. Una vez eliminada esta información, no podrá ser recuperada.
					  </div>
					  <div class="modal-footer">
					    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
					    <button type="button" class="btn btn-danger" ng-click="borrarRow(proyecto_id)"><i class="fa fa-fw fa-trash-o"></i> Eliminar</button>
					  </div>
					</div>
					</div>
				</div>
			<?php } ?>
			
		</div>
	</div>


	<?php 
		
		if($this->input->get('nuevo')!=null && $this->input->get('nuevo')==1){ ?>
			<div class="alert alert-success alert-dismissable">Proyecto registrado con éxito.</div>
		<?php  } 

    ?>

	<div class="card mb-3">
        <div class="card-header anchor-class" data-toggle="collapse" data-target="#card1" aria-expanded="true" aria-controls="collapseExample">
          	<i class="fa fa-info"></i> Información básica del proyecto <i class="fa float-right fa-plus-circle"></i></div>
        <div class="card-body collapse show" id="card1">
        	<div class="row">
        		<div class="col-12 col-md-6 col-lg-3  mb-3"><strong>Cliente: </strong><br><?=(isset($proyecto->nombre_cliente))?$proyecto->nombre_cliente:''?></div>
        		<div class="col-12 col-md-6 col-lg-3  mb-3"><strong>Fecha de firma de contrato: </strong><br><?=(isset($proyecto->fecha_firma_contrato))?$proyecto->fecha_firma_contrato:''?></div>
        		<div class="col-12 col-md-6 col-lg-3  mb-3"><strong>Fecha de inicio: </strong><br><?=(isset($proyecto->fecha_inicio))?$proyecto->fecha_inicio:''?></div>
        		<div class="col-12 col-md-6 col-lg-3  mb-3"><strong>Fecha de entrega esperada: </strong><br><?=(isset($proyecto->fecha_entrega_estimada))?$proyecto->fecha_entrega_estimada:''?></div>
        	</div>
        	<div class="row">
        		<div class="col-12 col-md-6 col-lg-3  mb-3"><strong>Provincia: </strong><br><?=(isset($proyecto->provincia))?$proyecto->provincia:''?></div>
        		<div class="col-12 col-md-6 col-lg-3  mb-3"><strong>Cantón: </strong><br><?=(isset($proyecto->canton))?$proyecto->canton:''?></div>
        		<div class="col-12 col-md-6 col-lg-3  mb-3"><strong>Distrito: </strong><br><?=(isset($proyecto->distrito))?$proyecto->distrito:''?></div>
        		<div class="col-12 col-md-6 col-lg-3  mb-3"><strong>Estado: </strong><br><?=(isset($proyecto->proyecto_estado))?$proyecto->proyecto_estado:''?></div>
        	</div>
        	
        	<p><strong>Avance de proyecto: </strong><br><?=$dias_consumidos?> días de un total de <?=$dias_proyecto?> días <?=($dias_consumidos>$dias_proyecto)?'('.($dias_consumidos-$dias_proyecto).' días de retraso)':''?></p>
        	<div class="progress">
				<div class="progress-bar <?=($dias_consumidos>$dias_proyecto)?'bg-danger':'bg-success'?>" role="progressbar" style="width: <?=$porcentaje?>%;" aria-valuenow="<?=$porcentaje?>" aria-valuemin="0" aria-valuemax="100"><?=$porcentaje?>%</div>
			</div>
        </div>
    </div>
		
	<div class="card mb-3">
        <div class="card-header anchor-class" data-toggle="collapse" data-target="#card2" aria-expanded="true" aria-controls="collapseExample">
          	<i class="fa fa-money"></i> Valor de la oferta <i class="fa float-right fa-plus-circle"></i></div>
        <div class="card-body collapse show" id="card2">
        	<div class="row">
				<div class="col-12 col-md-6 mb-5">
					<h3 class="text-center">Total de la oferta</h3>
					<div class="total-oferta">
						<p class="display-4 text-center">{{total_valor_oferta | currency}}</p>
					</div>
					<canvas class="chart chart-pie d-md-none" chart-labels="data_chart_valor_oferta.labels" chart-data="data_chart_valor_oferta.data"
				              chart-options="data_chart_valor_oferta.options" chart-dataset-override="datasetOverride" width="350"
				              height="500">
				    </canvas>
				    <canvas class="chart chart-pie d-none d-md-block d-lg-none" chart-labels="data_chart_valor_oferta.labels" chart-data="data_chart_valor_oferta.data"
				              chart-options="data_chart_valor_oferta.options" chart-dataset-override="datasetOverride" width="350"
				              height="350">
				    </canvas>
				    <canvas class="chart chart-pie d-none d-lg-block" chart-labels="data_chart_valor_oferta.labels" chart-data="data_chart_valor_oferta.data"
				              chart-options="data_chart_valor_oferta.options" chart-dataset-override="datasetOverride" width="350"
				              height="200">
				    </canvas>
        		</div>
				<div class="col-12 col-md-6">
					<h3 class="text-center">Distribución de la oferta por tipo</h3>
					<div class="desgloce-valor-oferta table-espaciado">
						<div class="table-responsive">
							<table class="table table-bordered table-hover">
								<thead class="thead-light">
									<tr>
										<th>Tipo de valor</th>
										<th>Valor</th>
									</tr>
								</thead>
								<tbody>
									<tr class="valor-oferta-item" ng-repeat="valor_oferta in data_valor_oferta">
										<td>{{valor_oferta.tipo}}</td>
										<td>{{valor_oferta.valor | currency}}</td>
									</tr>
									
								</tbody>
								
							</table>
						</div>
					</div>
					<a class=" float-md-right btn btn-success  mx-auto d-block d-md-inline-block mb-3" href="/proyectos/extensiones/<?=$proyecto->proyecto_id?>" role="button"><i class="fa fa-fw fa-eye"></i> Ver extensiones</a>
				</div>
			</div>
        </div>
    </div>


    <div class="card mb-3">
        <div class="card-header anchor-class" data-toggle="collapse" data-target="#card3" aria-expanded="true" aria-controls="collapseExample" >
          	<i class="fa fa-money"></i> Resumen de gastos <i class="fa float-right fa-plus-circle"></i></div>
        <div class="card-body collapse show" id="card3">
        	<div class="row">
				<div class="col-12 col-md-6 mb-5">
					<h3 class="text-center">Total de gastos</h3>
					<div class="total-oferta">
						<p class="display-4 text-center">{{total_gastos | currency}}</p>
					</div>
					<canvas class="chart chart-pie d-md-none" chart-labels="data_chart_gastos.labels" chart-data="data_chart_gastos.data"
				              chart-options="data_chart_gastos.options" chart-dataset-override="datasetOverride" width="350"
				              height="500">
				    </canvas>
				    <canvas class="chart chart-pie d-none d-md-block d-lg-none" chart-labels="data_chart_gastos.labels" chart-data="data_chart_gastos.data"
				              chart-options="data_chart_gastos.options" chart-dataset-override="datasetOverride" width="350"
				              height="350">
				    </canvas>
				    <canvas class="chart chart-pie  d-none d-lg-block" chart-labels="data_chart_gastos.labels" chart-data="data_chart_gastos.data"
				              chart-options="data_chart_gastos.options" chart-dataset-override="datasetOverride" width="350"
				              height="200">
				    </canvas>
        		</div>
				<div class="col-12 col-md-6">
					<h3 class="text-center">Distribución de gastos por tipo</h3>
					<div class="desgloce-gastos table-espaciado">
						<div class="table-responsive">
							<table class="table table-bordered table-hover">
								<thead class="thead-light">
									<tr>
										<th>Tipo de gasto</th>
										<th>Valor</th>
									</tr>
								</thead>
								<tbody>
									<tr class="gasto-item" ng-repeat="gastos in data_gastos">
										<td>{{gastos.tipo}}</td>
										<td>{{gastos.valor | currency}}</td>
									</tr>
									
								</tbody>
								
							</table>
						</div>
					</div>
					<a class=" float-md-right btn btn-success mx-auto d-block d-md-inline-block mb-3" href="/proyectos/gastos/<?=$proyecto->proyecto_id?>" role="button"><i class="fa fa-fw fa-eye"></i> Ver gastos</a>
				</div>
			</div>
        </div>
    </div>


    <div class="card mb-3">
        <div class="card-header anchor-class" data-toggle="collapse" data-target="#card4" aria-expanded="true" aria-controls="collapseExample" >
          	<i class="fa fa-money"></i> Control de Utilidad <i class="fa float-right fa-plus-circle"></i></div>
        <div class="card-body collapse show" id="card4">
        	<div class="row">
				<div class="col-12 col-md-6 mb-5">
					<h3 class="text-center">Utilidad Actual</h3>
					<div class="total-oferta">
						<p class="display-4 text-center">{{total_utilidad | currency}}</p>
						<h4 class="text-center" ng-class="{ 'text-success': total_utilidad>=data_valor_oferta[5].valor, 'text-warning': total_utilidad<data_valor_oferta[5].valor, 'text-danger': total_utilidad<0 }"><strong>Estado actual: </strong><span ng-if="total_utilidad>=data_valor_oferta[5].valor">Correcto</span> <span ng-if="total_utilidad<data_valor_oferta[5].valor && total_utilidad>0">Con pérdida de utilidad</span> <span ng-if="total_utilidad<0">Con pérdida extrema</span></h4>
					</div>
					<div class="gasto-item" ng-repeat="(kgasto, gastos) in data_gastos">
						<label>{{gastos.tipo}}</label>
						<div class="progress">
						  <div class="progress-bar bg-success" ng-class="{'bg-warning':data_valor_oferta[kgasto].valor==gastos.valor, 'bg-danger':data_valor_oferta[kgasto].valor<gastos.valor}" role="progressbar" style="width: {{ (100/data_valor_oferta[kgasto].valor)*gastos.valor | number : 0 }}%;" aria-valuenow="{{ (100/data_valor_oferta[kgasto].valor)*gastos.valor | number : 0 }}" aria-valuemin="0" aria-valuemax="100">{{ (100/data_valor_oferta[kgasto].valor)*gastos.valor | number : 0 }}%</div>
						</div>						
					</div>
        		</div>
				<div class="col-12 col-md-6 ">
					<h3 class="text-center">Comparación de valor cobrado y gastos</h3>
					<div class="desgloce-utilidad table-espaciado">
						<div class="table-responsive">
							<table class="table table-bordered table-hover">
								<thead class="thead-light">
									<tr>
										<th>Tipo de gasto</th>
										<th>Valor cobrado</th>
										<th>Gasto acumulado</th>
									</tr>
								</thead>
								<tbody>
									<tr class="gasto-item" ng-repeat="(kgasto, gastos) in data_gastos">
										<td>{{gastos.tipo}}</td>
										<td>{{data_valor_oferta[kgasto].valor | currency}}</td>
										<td>{{gastos.valor | currency}}</td>
									</tr>
									
								</tbody>
								
							</table>
						</div>
					</div>
					
					
				</div>
			</div>
        </div>
    </div>

    <div class="row">
		<div class="col-12">
			<a class="btn btn-success mr-md-3 mx-auto d-block d-md-inline-block mb-3" href="/proyectos/gastos/<?=$proyecto->proyecto_id?>" role="button"><i class="fa fa-fw fa-plus-circle"></i> Gastos</a>
			<a class="btn btn-success mr-md-3 mx-auto d-block d-md-inline-block mb-3" href="/proyectos/extensiones/<?=$proyecto->proyecto_id?>" role="button"><i class="fa fa-fw fa-plus-circle"></i> Extensiones</a> 
			<a class="btn btn-secondary mb-3 mr-md-3 mx-auto d-block d-md-inline-block" href="/reporte/generarReporteProyectoEspecifico/<?=$proyecto->proyecto_id?>" role="button" target="_blank"><i class="fa fa-download"></i> Generar reporte</a> 
			<a class="btn btn-primary mb-3 mr-md-3 mx-auto d-block d-md-inline-block" href="/proyectos/editar-proyecto/<?=$proyecto->proyecto_id?>" role="button"><i class="fa fa-fw fa-edit"></i> Editar proyecto</a> 
			<?php if(isset($rol_id) && $rol_id==1){ ?>
				<a class="btn btn-danger mb-3 mr-md-3 mx-auto d-block d-md-inline-block" href="#" data-toggle="modal" data-target="#deleteModal2{{proyecto_id}}"><i class="fa fa-fw fa-trash-o"></i> Eliminar proyecto</a>
				<!-- Modal -->
				<div class="modal fade" id="deleteModal2{{proyecto_id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModal2Label" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
					  <div class="modal-header">
					    <h5 class="modal-title" id="deleteModal2Label">¿Está seguro que desea eliminar este proyecto?</h5>
					    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					      <span aria-hidden="true">&times;</span>
					    </button>
					  </div>
					  <div class="modal-body">
					    Se elimará toda la información relacionada a este proyecto, como gastos, valor de la oferta, registro de horas de trabajo, extensiones de valor de la oferta, etc. Una vez eliminada esta información, no podrá ser recuperada.
					  </div>
					  <div class="modal-footer">
					    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
					    <button type="button" class="btn btn-danger" ng-click="borrarRow(proyecto_id)"><i class="fa fa-fw fa-trash-o"></i> Eliminar</button>
					  </div>
					</div>
					</div>
				</div>
			<?php } ?>
			
		</div>
	</div>

</div>

<!-- <canvas class="chart chart-pie" chart-labels="data_chart_valor_oferta.labels" chart-data="data_chart_valor_oferta.data"
					              chart-options="data_chart_valor_oferta.options" width="350"
					              height="200">
					      </canvas> -->