<script src="/instatec_pub/js/proveedor.js"></script>
<!-- Breadcrumbs-->
<ol class="breadcrumb">
	<li class="breadcrumb-item">
	  <a href="/">Inicio</a>
	</li>
	<li class="breadcrumb-item active">Proveedores</li>
</ol>

<h1 class="text-center"><i class="fa fa-fw fa-shopping-bag"></i> Proveedores</h1>
<hr>


<div class="page-content" ng-controller="proveedorController">
	<div class="row">
		<div class="col-12 col-md-10"><h3 class=" text-center text-md-left"><i class="fa fa-fw fa-table"></i> Lista de proveedores</h3></div>
		<div class="col-12 col-md-2"><a class="btn btn-primary float-md-right mb-3 mr-md-3 mx-auto d-block d-md-inline-block" href="/proveedores/agregar-proveedor" role="button"><i class="fa fa-fw fa-plus-circle"></i> Agregar proveedor</a></div>
	</div>
	<div class="card">
		<div class="card-header anchor-class" data-toggle="collapse" data-target="#filtroContainer" aria-expanded="false" aria-controls="collapseExample">
				<i class="fa fa-fw fa-filter"></i> Filtros <i class="fa float-right fa-plus-circle"></i>
        </div>
		<div class="card-body collapse" id="filtroContainer">			
			<div class="filtros">
				<div class="row">
					<div class="form-group col-12 col-md-3">
						<label for="nombre">Nombre de proveedor</label>
						<input type="text" name="nombre_proveedor" class="form-control" id="nombre" aria-describedby="nombreHelp" ng-model="nombre_proveedor">
						</small>
					</div>
					<div class="form-group col-12 col-md-3">
						<label for="cedula">Cédula de proveedor</label>
						<input type="text" name="cedula_proveedor" class="form-control" id="cedula" aria-describedby="cedulaHelp" ng-model="cedula_proveedor">
					</div>
					<div class="form-group col-12 col-md-3">
						<label>Estado del proveedor:</label>
						<div class="form-check">
							<label class="form-check-label">
								<input class="form-check-input" type="radio" name="estado_proveedor" id="estado1" ng-value="1" ng-model="estado_proveedor" >
								Activo
							</label>
						</div>
						<div class="form-check">
							<label class="form-check-label">
								<input class="form-check-input" type="radio" name="estado_proveedor" id="estado2" ng-model="estado_proveedor" ng-value="0">
								Inactivo
							</label>
						</div>
					</div>
					<div class="col-12 col-md-3">
						<button  class="btn btn-primary form-submit" ng-click="filtrarProveedor()">Filtrar</button>
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
			        	<th class="d-md-none">Acciones</th>
						<th>Nombre</th>
						<th>Cédula</th>
						<th>Fecha de registro</th>
						<th>Estado</th>
						<th class="d-none d-md-table-cell">Acciones</th>
					</tr>
				</thead>
                <tfoot  ng-if="total_rows > cantidad_mostrar">
                    <td colspan="5">
                    	<nav aria-label="Page navigation example">
	                        <ul class="pagination pull-right">
                                <li class="page-item"><button class="page-link" ng-disabled="validarPrev()" ng-click="pagePrev()">Anterior</button></li>
                                <li class="page-item"><button class="page-link" ng-disabled="validarNext()" ng-click="pageNext()">Siguiente</button></li>							
                            </ul>
	                        
	                    </nav>
                    </td>
				</tfoot>
	            <tbody>
					<tr ng-repeat="proveedor in proveedores | limitTo : cantidad_mostrar : currentPage*cantidad_mostrar">
						<td class="d-md-none"><a href="/proveedores/ver-proveedor/{{proveedor.proveedor_id}}" class="btn btn-edit btn-sm mb-1 btn-primary"><i class="fa fa-fw fa-eye"></i></a> <a href="/proveedores/editar-proveedor/{{proveedor.proveedor_id}}" class="btn btn-edit btn-sm mb-1 btn-success"><i class="fa fa-fw fa-edit"></i></a></td>
						<td>{{proveedor.nombre_proveedor}}</td>
						<td>{{proveedor.cedula_proveedor}}</td>
						<td>{{proveedor.fecha_registro}}</td>
						<td ng-switch="proveedor.estado_proveedor"><span ng-switch-when="1">Activo</span><span ng-switch-when="0">Inactivo</span></td>
						<td class="d-none d-md-table-cell"><a href="/proveedores/ver-proveedor/{{proveedor.proveedor_id}}" class="btn btn-edit btn-sm mb-1 btn-primary"><i class="fa fa-fw fa-eye"></i></a> <a href="/proveedores/editar-proveedor/{{proveedor.proveedor_id}}" class="btn btn-edit btn-sm mb-1 btn-success"><i class="fa fa-fw fa-edit"></i></a></td>
					</tr>
				</tbody>
			</table>
		</div>
		
	</div>
	<p class="text-right">Mostrando de {{(currentPage*cantidad_mostrar)+1}} a {{(currentPage*cantidad_mostrar)+cantidad_mostrar}} - Total: {{total_rows}}</p>


	
</div>