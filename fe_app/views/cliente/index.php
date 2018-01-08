<script src="/fe_pub/js/cliente.js"></script>
<!-- Breadcrumbs-->
<div id="headerbar">
    <h1 class="headerbar-title"><i class="fa fa-fw fa-handshake-o"></i> Clientes</h1>

</div>


<div class="page-content" ng-controller="clienteController">
	<div class="row">
		<div class="col-12 col-md-10"><h3 class=" text-center text-md-left"><i class="fa fa-fw fa-table"></i> Lista de clientes</h3></div>
		<div class="col-12 col-md-2"><a class="btn btn-primary float-md-right mb-3 mr-md-3 mx-auto d-block d-md-inline-block" href="/clientes/agregar-cliente" role="button"><i class="fa fa-fw fa-plus-circle"></i> Agregar cliente</a></div>
	</div>
	<div class="card" ng-show="loadedcompany">
		<div class="card-header anchor-class" data-toggle="collapse" data-target="#filtroContainer" aria-expanded="false" aria-controls="collapseExample">
				<i class="fa fa-fw fa-filter"></i> Filtros <i class="fa float-right fa-plus-circle"></i>
        </div>
		<div class="card-body collapse" id="filtroContainer">			
			<div class="filtros">
				<div class="row">
					<div class="form-group col-12 col-md-3">
						<label for="nombre">Sociedad o Empresa interna</label>
						<select name="company_id" class="form-control" id="company_id" ng-model="company_id">
							<option value="all" selected="selected">Todas</option>
							<option ng-repeat="company in companies" value="{{company.company_id}}">{{company.company_name}}</option>
						</select>
						</small>
					</div>
					
					<div class="col-12 col-md-3">

						<button  class="btn btn-primary form-submit mt-4" ng-click="filtrarCliente()">Filtrar</button>
					</div>
					
				</div>
			</div>
		</div>
	</div> 
	<div class="table-espaciado" >
		<div ng-hide="loaded">
		  <img class="text-center mx-auto mt-3 mb-3 float-none d-block" src="/fe_pub/images/ajax-loader.gif" alt="" />
		</div>
		<div ng-show="sindatos">
			<p class="text-center">No hay clientes registrados aún.</p>
		</div>
		<div class="table-responsive" ng-show="loaded && sindatos===false">
	        <table class="table table-hover table-bordered" id="dataTable" width="100%" cellspacing="0">
	            <thead class="thead-light">
			        <tr>
						<th class="d-md-none">Acciones</th>
						<th>Nombre</th>
						<th>Cédula</th>
						<th class="d-none d-md-table-cell">Acciones</th>
					</tr>
				</thead>
                <tfoot ng-if="total_rows > cantidad_mostrar">
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
					<tr ng-repeat="cliente in clientes | limitTo : cantidad_mostrar : currentPage*cantidad_mostrar">
						<td class="d-md-none"><a href="/clientes/editar-cliente/{{cliente.customer_id}}" class="btn btn-edit btn-sm btn-success mb-1"><i class="fa fa-fw fa-edit"></i></a></td>
						<td>{{cliente.customer_firstname}} {{cliente.customer_secondname !== null ? cliente.customer_secondname : ''}} {{cliente.customer_lastname !== null ? cliente.customer_lastname : ''}}</td>
						<td>{{cliente.customer_identification}}</td>
						<td class="d-none d-md-table-cell"><a href="/clientes/editar-cliente/{{cliente.customer_id}}" class="btn btn-edit btn-sm btn-success mb-1"><i class="fa fa-fw fa-edit"></i></a></td>
					</tr>
				</tbody>
			</table>
		</div>
		
	</div>
    <p class="text-right" ng-show="loaded  && sindatos===false">Mostrando de {{(currentPage*cantidad_mostrar)+1}} a {{(currentPage*cantidad_mostrar)+cantidad_mostrar}} - Total: {{total_rows}}</p>
</div>

