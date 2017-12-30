<script src="/fe_pub/js/factura.js"></script>
<!-- Breadcrumbs-->
<ol class="breadcrumb">
	<li class="breadcrumb-item">
	  <a href="/">Inicio</a>
	</li>
	<li class="breadcrumb-item active">Facturas</li>
</ol>

<h1 class="text-center"><i class="fa fa-fw fa-table"></i> Facturas</h1>
<hr>

<div class="row">
	<div class="col-12 col-md-10"><h3 class=" text-center text-md-left"><i class="fa fa-fw fa-table"></i> Lista de facturas</h3></div>
	<div class="col-12 col-md-2"><a class="float-right btn btn-primary" href="/facturas/agregar-factura" role="button"><i class="fa fa-fw fa-plus-circle"></i> Agregar factura</a></div>
</div>

<div class="page-content" ng-controller="proyectoController">
	<div class="card">
		<div class="card-body">
			<h4 class="col-12 anchor-class" data-toggle="collapse" data-target="#filtroContainer" aria-expanded="false" aria-controls="collapseExample">
				<i class="fa fa-fw fa-filter"></i> Filtros
			</h4>
			<div class="filtros  collapse" id="filtroContainer">
				<div class="row">
					<div class="form-group col-12 col-md-3">
						<label for="nombre_proyecto">Número de proyecto</label>
						<input type="text" name="nombre_proyecto" class="form-control" id="nombre_proyecto"  ng-model="nombre_proyecto">
						
					</div>
					
					<div class="form-group col-12 col-md-3">
						<label for="cliente_id">Cliente del proyecto:</label>
						<select class="form-control chosen-select" name="cliente_id" id="cliente_id" aria-describedby="clienteHelp" required="true" ng-model="cliente_id">
							<option value=""></option>
							<option value="all">Todos</option>
							<?php foreach($clientes as $kcliente => $vcliente){ ?>
								<option value="<?=$vcliente->cliente_id?>"><?=$vcliente->nombre_cliente?></option>
							<?php } ?>
						</select>
					</div>
					<div class="form-group col-12 col-md-3">
						<label>Estado del proyecto:</label>
						<select class="form-control select-required" name="proyecto_estado_id" id="proyecto_estado_id" ng-model="proyecto_estado_id">
							<option value="all" selected="selected">Todos</option>
							<?php foreach($factura_estados as $kproyecto_estado => $vproyecto_estado){ ?>
								<option value="<?=$vproyecto_estado->proyecto_estado_id?>"><?=$vproyecto_estado->proyecto_estado?></option>
							<?php } ?>
						</select>
						
					</div>
					<div class="form-group col-12 col-md-3">
						<label for="fecha_registro">Fecha de registro:</label>
						<div class="input-group input-daterange">
						    <input type="text" name="fecha_registro[from]" class="form-control" ng-model="fecha_registro_from" >
						    <div class="input-group-addon"> a </div>
						    <input type="text" name="fecha_registro[to]" class="form-control" ng-model="fecha_registro_to" >
						</div>
						<!--<input type="text" name="fecha_registro" class="form-control datepicker" id="fecha_registro" aria-describedby="fechafirmaHelp" >-->
						
					</div>
				</div>
				

				

				<div class="row">
					<div class="col-12 col-md-3">
						<button  class="btn btn-primary form-submit" ng-click="consultarProyecto()">Filtrar</button>
						<button  class="btn btn-success form-submit" ng-click="limpiarFiltro()">Limpiar Filtrado</button>
					</div>
					
				</div>
			</div>
		</div>
	</div>
	<div class="table-espaciado">
		<div class="table-responsive">
	        <table class="table table-hover table-bordered" id="dataTable" width="100%" cellspacing="0">
	            <thead class="thead-light">
			        <tr>
						<th># Factura</th>
						<th>Cliente</th>
						<?php if($rol_id==1){ ?>
							<th>Estado</th>
							<th>Fecha</th>
							<th>Total</th>
						<?php } ?>
						<th>Acciones</th>
					</tr>
				</thead>
                <tfoot ng-if="total_rows > cantidad_mostrar">
                	<td colspan="6">
                	
                    	<nav aria-label="Page navigation example">
	                        <ul class="pagination pull-right">
                                <li class="page-item"><button class="page-link" ng-disabled="validarPrev()" ng-click="pagePrev()">Anterior</button></li>					
								<li class="page-item"><button class="page-link" ng-disabled="validarNext()" ng-click="pageNext()">Siguiente</button></li>

                            </ul>
	                        
	                    </nav>
                			
                		
                    </td>
				</tfoot>
	            <tbody>
					<tr ng-repeat="proyecto in proyectos | limitTo : cantidad_mostrar : currentPage*cantidad_mostrar">
						<td><a href="/proyectos/ver-proyecto/{{proyecto.proyecto_id}}"><strong>{{proyecto.proyecto_id}}</strong></a></td>
						<td><a href="/proyectos/ver-proyecto/{{proyecto.proyecto_id}}">{{proyecto.nombre_cliente}}</a></td>
						<?php if($rol_id==1){ ?>
							<td><a href="/proyectos/ver-proyecto/{{proyecto.proyecto_id}}">{{proyecto.proyecto_estado}}</a></td>						
							<td><a href="/proyectos/ver-proyecto/{{proyecto.proyecto_id}}">{{proyecto.fecha_registro}}</a></td>
							<td><a href="/proyectos/ver-proyecto/{{proyecto.proyecto_id}}">$ 1000.00</a></td>
						<?php } ?>
						<td><a href="/proyectos/ver-proyecto/{{proyecto.proyecto_id}}" class="btn btn-edit btn-primary"><i class="fa fa-fw fa-print"></i></a> <a href="/proyectos/editar-proyecto/{{proyecto.proyecto_id}}" class="btn btn-edit btn-success"><i class="fa fa-fw fa-edit"></i></a></td>
					</tr>
				</tbody>
			</table>
		</div>
		
	</div>
    <p class="text-right">Mostrando de {{(currentPage*cantidad_mostrar)+1}} a {{(currentPage*cantidad_mostrar)+cantidad_mostrar}} - Total: {{total_rows}}</p>
</div>
