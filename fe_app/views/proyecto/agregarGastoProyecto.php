<script src="/fe_pub/js/proyecto.js"></script>
<!-- Breadcrumbs-->
<ol class="breadcrumb">
	<li class="breadcrumb-item">
	  <a href="/">Inicio</a>
	</li>
	<li class="breadcrumb-item">
	  <a href="/proyectos">Proyectos</a>
	</li>
	<li class="breadcrumb-item">
		<a href="/proyectos/ver-proyecto/<?=$proyecto->proyecto_id?>">Ver proyecto</a>
	</li>
	<li class="breadcrumb-item">
		<a href="/proyectos/gastos/<?=$proyecto->proyecto_id?>">Gastos</a>
	</li>
	<li class="breadcrumb-item active">Agregar gasto</li>
</ol>

<h1 class="text-center">Gastos del proyecto</h1>
<hr>

<div class="row">
	<div class="col-12 col-md-10"><h3 class=" text-center text-md-left"><i class="fa fa-fw fa-plus-circle"></i> Agregar gasto</h3></div>
	<div class="col-12 col-md-2"><a class="float-right btn btn-primary" href="/proyectos/gastos/<?=$proyecto->proyecto_id?>" role="button"><i class="fa fa-fw fa-arrow-left"></i> Volver a gastos</a></div>
</div>


<div class="page-content" ng-controller="agregarProyectoGastoController">
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
	<form id="agregarGastoProyecto" class="form-validation" method="post" name="agregarGastoProyecto">
		<div class="card mb-3">
	        <div class="card-header">
	          	Información del gasto</div>
	        <div class="card-body">
	        	<div class="row">
	        		<div class="col-12 col-md-6 col-lg-4">
	        			<div class="form-group">
							<label for="proyecto_gasto_tipo_id">Tipo de gasto:</label>
							<select class="form-control" name="proyecto_gasto_tipo_id" id="proyecto_gasto_tipo_id" ng-model="proyecto_gasto_tipo_id" ng-change="chosenSelect()" aria-describedby="tigoGastoHelp">
								<?php if(isset($gasto_tipo)){
								 		foreach ($gasto_tipo as $kgasto => $vgasto) { 
								 			if($vgasto->proyecto_gasto_tipo_id!=4) { ?>
												<option value="<?=$vgasto->proyecto_gasto_tipo_id?>"><?=$vgasto->proyecto_gasto_tipo?></option>
								<?php 		}
										}
									}
								?>
							</select>
							<small id="tigoGastoHelp" class="form-text text-muted">Indique el tipo de gasto que está registrando.<br/>
							</small>
						</div>
	        		</div>
	        		

	        		<div class="col-12 col-md-6 col-lg-4">
	        			<div class="form-group">
							<label for="moneda_id">Moneda del gasto:</label>
							<select class="form-control" name="moneda_id" id="moneda_id" ng-model="moneda_id" ng-change="inputMask()" aria-describedby="tigoGastoHelp">
								<?php if(isset($monedas)){
								 		foreach ($monedas as $kmoneda => $vmoneda) { ?>
											<option value="<?=$vmoneda->moneda_id?>"><?=$vmoneda->moneda?></option>
								<?php 	}
									}
								?>
							</select>
							<small id="tigoGastoHelp" class="form-text text-muted">Indique el tipo de gasto que está registrando.<br/>
							</small>
						</div>
	        		</div>

	        		<div class="col-12 col-md-6 col-lg-4">
	        			<div class="form-group">
							<label for="proyecto_gasto_monto">Monto del gasto:</label>							
							<input type="text" name="proyecto_gasto_monto" class="form-control input-required" ng-class="{ 'input-money-mask': moneda_id==1, 'input-money-mask-colones': moneda_id==2 }"  id="proyecto_gasto_monto"  aria-describedby="valorExtensionHelp" >
							<small id="valorExtensionHelp" class="form-text text-muted">Ingrese el monto del gasto.<br/>
							</small>
						</div>
	        		</div>
					<div class="col-12 col-md-6 col-lg-4">
		        		<div class="form-group">
							<label for="fecha_gasto">Fecha de gasto:</label>
							<input type="text" name="fecha_gasto" class="form-control datepicker input-required" id="fecha_gasto" aria-describedby="fechagastoHelp" >
							<small id="fechagastoHelp" class="form-text text-muted">Ingrese la fecha en que se realizó el gasto.<br/>
							</small>
						</div>
					</div>
	        	</div>
	        	
	        </div>
	    </div>
	    <div class="card mb-3" ng-if="proyecto_gasto_tipo_id==1 || proyecto_gasto_tipo_id==3">
	        <div class="card-header">
	          	Detalle del gasto</div>
	        <div class="card-body">
	        	<div class="row">
	        		<div class="col-12 col-md-6 col-lg-4">
	        			<div class="form-group">
							<label for="proveedor_id">Proveedor:</label>							
							<select class="form-control chosen-select select-required" data-placeholder="Seleccione una opción..." name="proveedor_id" id="proveedor_id"  aria-describedby="proveedorHelp">
								<option value="none">- Seleccionar -</option>
								<?php if(isset($proveedores)){
								 		foreach ($proveedores as $kproveedor => $vproveedor) { ?>
											<option value="<?=$vproveedor->proveedor_id?>"><?=$vproveedor->nombre_proveedor?></option>
								<?php 	}
									}
								?>
							</select>
							<small id="proveedorHelp" class="form-text text-muted">Indique el proveedor.</small>
						</div>
	        		</div>
	        		<div class="col-12 col-md-6 col-lg-4">
	        			<div class="form-group">
							<label for="numero_factura">Número de factura:</label>							
							<input type="text" name="numero_factura" class="form-control input-required"  id="numero_factura"  aria-describedby="numerofacturaHelp" >
							<small id="numerofacturaHelp" class="form-text text-muted">Ingrese número de factura.<br/>
							</small>
						</div>
	        		</div>
	        		<div class="col-12 col-md-6 col-lg-4">
	        			<div class="form-group">
							<label for="proyecto_gasto_estado_id">Estado del gasto:</label>							
							<select class="form-control select-required" name="proyecto_gasto_estado_id" id="proyecto_gasto_estado_id"  aria-describedby="estadoHelp">
								<option value="none">- Seleccionar -</option>
								<?php if(isset($gasto_estados)){
								 		foreach ($gasto_estados as $kestado => $vestado) { ?>
											<option value="<?=$vestado->proyecto_gasto_estado_id?>"><?=$vestado->proyecto_gasto_estado?></option>
								<?php 	}
									}
								?>
							</select>
							<small id="estadoHelp" class="form-text text-muted">Ingrese el estado del gasto.</small>
						</div>
	        		</div>
	        	</div>
	        	
	        </div>
	    </div>
		<button type="submit" class="btn btn-primary form-submit"><i class="fa fa-fw fa-save"></i> Guardar</button>
	</form>
</div>
