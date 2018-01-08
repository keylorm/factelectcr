<script src="/fe_pub/js/proyecto.js"></script>
<!-- Breadcrumbs-->
<ol class="breadcrumb">
	<li class="breadcrumb-item">
	  <a href="/">Inicio</a>
	</li>
	<li class="breadcrumb-item">
	  <a href="/proyectos">Proyectos</a>
	</li>
	<li class="breadcrumb-item active">Agregar proyecto</li>
</ol>
<h1  class="text-center"><i class="fa fa-fw fa-area-chart"></i> Proyectos</h1>
<hr>
<h3><i class="fa fa-fw fa-plus-circle"></i> Agregar nuevo proyecto</h3>

<div class="page-content" ng-controller="agregarProyectoController">
	<?php 
		if(validation_errors()){ ?>
    		<div class="alert alert-danger alert-dismissable"><?php echo validation_errors(); ?></div>
    <?php 
		} 

		if(isset($msg)){
			foreach ($msg as $kmsg => $vmsg) { ?>
				<div class="alert alert-<?=$vmsg['tipo']?> alert-dismissable"><?=$vmsg['texto']?></div>
			<?php
			}
		}

    ?>
	<form id="agregarProyecto" class="form-validation" method="post" name="agregarProyecto">
		<div class="card mb-3">
	        <div class="card-header">
	          	Información general del proyecto</div>
	        <div class="card-body">
				<div class="row">
					<div class="form-group col-12 col-md-6">
						<label for="nombre">Nombre del proyecto:</label>
						<input type="text" name="nombre_proyecto" class="form-control input-required" id="nombre" aria-describedby="nombreHelp" >
						<small id="nombreHelp" class="form-text text-muted">Ingrese el nombre del proyecto tal cual desea que lo ubiquen el resto de los usuarios.<br/>
						</small>
					</div>
					<div class="form-group col-12 col-md-6">
						<label for="cliente_id">Cliente del proyecto:</label>
						<select class="form-control chosen-select select-required"  data-placeholder="Seleccione una opción..." name="cliente_id" id="cliente_id" aria-describedby="clienteHelp" required="true">
							<option value="none">- Seleccionar -</option>
							<?php foreach($clientes as $kcliente => $vcliente){ ?>
								<option value="<?=$vcliente->cliente_id?>"><?=$vcliente->nombre_cliente?></option>
							<?php } ?>
						</select>
						<small id="clienteHelp" class="form-text text-muted">Ingrese el nombre del cliente de este proyecto. Si no encuentra al cliente en la lista, debe agregarlo en la sección de clientes.<br/>
						</small>
					</div>
				</div>
				
				<div class="row">
					<div class="form-group col-12 col-md-6">
						<label for="fecha_firma_contrato">Fecha de firma de contrato:</label>
						<input type="text" name="fecha_firma_contrato" class="form-control datepicker" id="fecha_firma_contrato" aria-describedby="fechafirmaHelp" >
						<small id="fechafirmaHelp" class="form-text text-muted">Ingrese la fecha de firma del contrato.<br/>
						</small>
					</div>
					<div class="form-group col-12 col-md-6">
						<label for="fecha_inicio">Fecha de inicio esperada:</label>
						<input type="text" name="fecha_inicio" class="form-control datepicker" id="fecha_inicio" aria-describedby="fechainicioHelp" >
						<small id="fechainicioHelp" class="form-text text-muted">Ingrese la fecha de inicio esperada.<br/>
						</small>
					</div>

					
				</div>

				<div class="row">
					<div class="form-group col-12 col-md-6">
						<label for="fecha_entrega_estimada">Fecha de entrega estimada:</label>
						<input type="text" name="fecha_entrega_estimada" class="form-control datepicker" id="fecha_entrega_estimada" aria-describedby="fechaentregaHelp" >
						<small id="fechaentregaHelp" class="form-text text-muted">Ingrese la fecha de entrega estimada.<br/>
						</small>
					</div>
					<div class="form-group col-12 col-md-6">
						<label for="proyecto_estado_id">Estado del proyecto:</label>
						<select class="form-control select-required" name="proyecto_estado_id" id="proyecto_estado_id">
							<option value="none">- Seleccionar -</option>
							<?php foreach($proyecto_estados as $kproyecto_estado => $vproyecto_estado){ ?>
								<option value="<?=$vproyecto_estado->proyecto_estado_id?>"><?=$vproyecto_estado->proyecto_estado?></option>
							<?php } ?>
						</select>
						<small id="proyectoestadoHelp" class="form-text text-muted">Ingrese el nombre del proyecto tal cual desea que lo ubiquen el resto de los usuarios.<br/>
						</small>
					</div>
					
				</div>
				
			</div>
		</div>
		
		<div class="card mb-3">
	        <div class="card-header">
	          	Ubicación del proyecto</div>
	        <div class="card-body">
				<div class="row">
					<div class="form-group col-12 col-md-6">
						<label for="provincia_id">Provincia:</label>
						<select class="form-control" name="provincia_id" id="provincia_id" aria-describedby="provinciaHelp" ng-model="provincia_id" ng-click="getCantones()" required="required">
							<?php foreach($provincias as $kprovincia => $vprovincia){ ?>
								<option value="<?=$vprovincia->provincia_id?>"><?=$vprovincia->provincia?></option>
							<?php } ?>
						</select>
						<small id="provinciaHelp" class="form-text text-muted">Indique la provincia donde se ubica el proyecto.<br/>
						</small>
					</div>
					<div class="form-group col-12 col-md-6">
						<label for="canton_id">Cantón:</label>
						<select class="form-control" name="canton_id" id="canton_id" aria-describedby="cantonHelp" ng-model="canton_id" ng-click="getDistritos()">
							<option ng-repeat="canton in cantones" value="{{canton.canton_id}}">
								{{canton.canton}}
							</option>
						</select>
						<small id="cantonHelp" class="form-text text-muted">Indique el cantón donde se ubica el proyecto.<br/>
						</small>
					</div>
				</div>
				
				<div class="row">
					<div class="form-group col-12 col-md-6">
						<label for="distrito_id">Distrito:</label>
						<select class="form-control" name="distrito_id" id="distrito_id" aria-describedby="distritoHelp" ng-model="distrito_id">
							<option ng-repeat="distrito in distritos" value="{{distrito.distrito_id}}" required="required">
								{{distrito.distrito}}
							</option>
						</select>
						<small id="distritoHelp" class="form-text text-muted">Indique el distrito donde se ubica el proyecto.<br/>
						</small>
					</div>
					<div class="form-group col-12 col-md-6">
						<label for="direccion_exacta">Dirección exacta:</label>
						<textarea class="form-control" name="direccion_exacta" id="direccion_exacta" rows="3" aria-describedby="direccionHelp"></textarea>
						<small id="direccionHelp" class="form-text text-muted">Indique la dirección exacta donde se ubica el proyecto.<br/>
						</small>
					</div>
				</div>

				
			</div>
		</div>

		<div class="card mb-3">
	        <div class="card-header">
	          	Datos administrativos del proyecto</div>
	        <div class="card-body">
				<div class="row">
					<div class="form-group col-12 col-md-6">
						<label for="numero_contrato">Número de contrato:</label>
						<input type="text" name="numero_contrato" class="form-control"  id="numero_contrato" aria-describedby="contratoHelp" >
						<small id="contratoHelp" class="form-text text-muted">Ingrese el número de contrato del proyecto.<br/>
						</small>
						
					</div>
					<div class="form-group col-12 col-md-6">
						<label for="orden_compra">Orden de compra:</label>
						<input type="text" name="orden_compra" class="form-control "  id="orden_compra" aria-describedby="ordencompraHelp" >
						<small id="ordencompraHelp" class="form-text text-muted">Ingrese el número de orden de compra del proyecto.<br/>
						</small>
						
					</div>
				</div>
				
				

				
			</div>
		</div>

		<div class="card mb-3">
	        <div class="card-header">
	          	Valor de la oferta del proyecto</div>
	        <div class="card-body">
				<div class="row">
					<div class="col-12 col-md-6 col-lg-8">
						<div class="row">
							<div class="form-group col-12 col-lg-6">
								<label for="valor_materiales">Valor de materiales ($):</label>
								
								<input type="text" name="valor_oferta[1]" class="form-control input-money-mask " id="valor_materiales" ng-model="valor_materiales" aria-describedby="valormaterialesHelp" >
								<small id="valormaterialesHelp" class="form-text text-muted">Ingrese el valor de los materiales del proyecto.<br/>
								</small>
							</div>
					
							<div class="form-group col-12 col-lg-6">
								<label for="valor_mano_obra">Valor de mano de obra ($):</label>
								
								<input type="text" name="valor_oferta[2]" class="form-control input-money-mask " id="valor_mano_obra" ng-model="valor_mano_obra" aria-describedby="valormanoobraHelp" >
								<small id="valormanoobraHelp" class="form-text text-muted">Ingrese el valor de la mano de obra del proyecto.<br/>
								</small>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-12 col-lg-6">
								<label for="valor_gastos_operacion">Valor de gastos de operación ($):</label>
								
								<input type="text" name="valor_oferta[3]" class="form-control input-money-mask " id="valor_gastos_operacion" ng-model="valor_gastos_operacion" aria-describedby="valorgastosopeHelp" >
								<small id="valorgastosopeHelp" class="form-text text-muted">Ingrese el valor de los gastos de operación del proyecto.<br/>
								</small>
							</div>
							
							<div class="form-group col-12 col-lg-6">
								<label for="valor_gastos_administrativos">Valor de gastos administrativos ($):</label>
								
								<input type="text" name="valor_oferta[4]" class="form-control input-money-mask " id="valor_gastos_administrativos" ng-model="valor_gastos_administrativos" aria-describedby="valorgastosadmHelp" >
								<small id="valorgastosadmHelp" class="form-text text-muted">Ingrese el valor de los gastos administrativos del proyecto.<br/>
								</small>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-12 col-lg-6">
								<label for="valor_utilidad">Valor de utilidad ($):</label>
								
								<input type="text" name="valor_oferta[5]" class="form-control input-money-mask " id="valor_utilidad" ng-model="valor_utilidad" aria-describedby="valorutilidadHelp" >
								<small id="valorutilidadHelp" class="form-text text-muted">Ingrese el valor de la utilidad del proyecto.<br/>
								</small>
							</div>
						</div>
					</div>
					<div class="col-12 col-md-6 col-lg-4">
						<div class="row">
							<div class="form-group form-group col-12">
								<label for="moneda_id">Valor total de la oferta:</label>
								<p class="display-4">{{calcularValorOferta() | currency:'$ '}}</p>
								<small id="monedaHelp" class="form-text text-muted">Es una sumatoria de las ofertas anteriores.<br/>
								</small>
							</div>
						</div>
					</div>					
				</div>				
			</div>
		</div>

		<div class="card mb-3">
	        <div class="card-header">
	          	Tipo de cambio al día de firma del contrato</div>
	        <div class="card-body">
				

				<div class="row">
					
					<div class="form-group col-12 col-md-6">
						<label for="tipo_cambio_compra">Valor de compra (₡):</label>
						
						<input type="text" name="tipocambio[valor_compra]" class="form-control input-money-mask-colones" id="tipo_cambio_compra" ng-model="tipo_cambio_compra"  aria-describedby="valorTipoCambioCompra" >
						<small id="valorTipoCambioCompra" class="form-text text-muted">Ingrese el valor de compra del dolar en colones.<br/>
						</small>
					</div>
					
					<div class="form-group col-12 col-md-6">
						<label for="tipo_cambio_venta">Valor de venta (₡):</label>
						
						<input type="text" name="tipocambio[valor_venta]" class="form-control input-money-mask-colones" id="tipo_cambio_venta" ng-model="tipo_cambio_venta"  aria-describedby="valorTipoCambioVenta" >
						<small id="valorTipoCambioVenta" class="form-text text-muted">Ingrese el valor de venta del dolar en colones.<br/>
						</small>
					</div>
					
					
				</div>
				
				

				
			</div>
		</div>

		

		<div class="card mb-3">
	        <div class="card-header">
	          	Otros datos</div>
	        <div class="card-body">
				<div class="row">
					<div class="form-group col-12">
						<label for="observaciones">Observaciones:</label>
						<textarea class="form-control" name="observaciones" id="observaciones" rows="3" aria-describedby="observacionesHelp"></textarea>
						<small id="observacionesHelp" class="form-text text-muted">Ingrese observaciones adicionales del proyecto.<br/>
						</small>
						
					</div>
					
				</div>

			</div>
		</div>


		<button type="submit" class="btn btn-primary form-submit"><i class="fa fa-fw fa-save"></i> Guardar</button>
	</form>
	
</div>