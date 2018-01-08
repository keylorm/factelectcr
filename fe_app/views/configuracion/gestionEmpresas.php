<script src="/fe_pub/js/configuracion.js"></script>
<!-- Breadcrumbs-->
<div id="headerbar">
	<h1 class="headerbar-title"><i class="fa fa-fw fa-handshake-o"></i> Mis empresas</h1>
</div>


<div class="page-content" ng-controller="empresaController">
	<div class="row">
		<div class="col-12 col-md-10"><h3 class=" text-center text-md-left"><i class="fa fa-fw fa-table"></i> Lista de empresas</h3></div>
		<div class="col-12 col-md-2"><a class="btn btn-primary float-md-right mb-3 mr-md-3 mx-auto d-block d-md-inline-block" href="/configuracion/empresas/agregar-empresa" role="button"><i class="fa fa-fw fa-plus-circle"></i> Agregar empresa</a></div>
	</div>
	
	<div class="table-espaciado">
		<div ng-hide="loaded">
		  <img class="text-center mx-auto mt-3 mb-3 float-none d-block" src="/fe_pub/images/ajax-loader.gif" alt="" />
		</div>
		<div ng-show="sindatos">
			<p class="text-center">No hay empresas o sociedades registradas aún.</p>
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
               
	            <tbody>
					<tr ng-repeat="company in companies">
						<td class="d-md-none"><a href="/empresas/editar-empresa/{{company.company_id}}" class="btn btn-edit btn-sm btn-success mb-1"><i class="fa fa-fw fa-edit"></i></a></td>
						<td>Nombre interno: {{company.company_name}}<br>Nombre comercial: {{company.company_comercialname}}</td>
						<td>{{company.company_identification}}</td>	
						<td class="d-none d-md-table-cell"><a href="/empresas/editar-empresa/{{company.company_id}}" class="btn btn-edit btn-sm btn-success mb-1"><i class="fa fa-fw fa-edit"></i></a></td>
					</tr>
				</tbody>
			</table>
		</div>
		
	</div>
    
</div>

