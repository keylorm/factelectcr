<script src="/fe_pub/js/factura.js"></script>
<!-- Breadcrumbs-->
<ol class="breadcrumb">
	<li class="breadcrumb-item">
	  <a href="/">Inicio</a>
	</li>
	<li class="breadcrumb-item">
	  <a href="/facturas">Facturas</a>
	</li>
	<li class="breadcrumb-item active">Crear factura</li>
</ol>
<h1  class="text-center"><i class="fa fa-fw fa-area-chart"></i> Facturas</h1>
<hr>
<div class="row">
	<div class="col-12 col-md-9"><h3 class=" text-center text-md-left"><i class="fa fa-fw fa-plus-circle"></i> Crear nueva factura</h3></div>
	<div class="col-12 col-md-3"><a class="btn btn-success" href="/facturas/agregar-factura" role="button"><i class="fa fa-fw fa-save"></i></a> <a class="btn btn-primary" href="/facturas/agregar-factura" role="button"><i class="fa fa-fw fa-print"></i></a> <a class="btn btn-primary" href="/facturas/agregar-factura" role="button"><i class="fa fa-fw fa-envelope"></i></a> <a class="btn btn-primary" href="/facturas/agregar-factura" role="button"><i class="fa fa-fw fa-cloud-upload"></i></a></div>
</div>

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
	<form id="agregarCliente" class="form-validation" method="post" name="agregarProyecto">
		<div class="card mb-3">
	        <div class="card-header">
	          	Información de factura</div>
	        <div class="card-body">
				<div class="row">
					<div class="col-12 col-md-9">
						<div class="form-group">
							<label for="cliente_id">Cliente:</label>
							<select class="form-control chosen-select select-required" name="cliente_id" id="cliente_id" aria-describedby="clienteHelp" required="true">
								<option value="none">- Seleccionar -</option>
								<?php foreach($clientes as $kcliente => $vcliente){ ?>
									<option value="<?=$vcliente->cliente_id?>"><?=$vcliente->nombre_cliente?></option>
								<?php } ?>
							</select>
							<small id="clienteHelp" class="form-text text-muted">Ingrese el nombre del cliente de esta factura.<br/>
							</small>
						</div>
						<div class="form-group">
							<label for="nombre">Cédula de cliente:</label>
							<input type="text" name="nombre_proyecto" class="form-control input-required" id="nombre" value="542313-3" aria-describedby="nombreHelp" >
							<small id="nombreHelp" class="form-text text-muted">Cédula física o jurídica de cliente<br/>
							</small>
						</div>
						
					</div>
					<div class="col-12 col-md-3">
						<div class="form-group">
							<label for="nombre">Número de factura:</label>
							<input type="text" name="nombre_proyecto" class="form-control input-required" id="nombre" value="12" aria-describedby="nombreHelp" >
							<small id="nombreHelp" class="form-text text-muted"># consecutivo de factura<br/>
							</small>
						</div>
						<div class="form-group">
							<label for="fecha_firma_contrato">Fecha de factura:</label>
							<input type="text" name="fecha_firma_contrato" class="form-control datepicker" id="fecha_firma_contrato" value="<?=date('d/m/Y')?>" aria-describedby="fechafirmaHelp" >
							<small id="fechafirmaHelp" class="form-text text-muted">Ingrese la fecha de la factura.<br/>
							</small>
						</div>
						
					</div>
				</div>
		
				
			</div>
		</div>
		
		<div class="card mb-3">
	        <div class="card-header">
	          	Detalle de factura</div>
	        <div class="card-body">
				
				<div class="form-group row">
					<div class="col-6 col-md-7">
						<label>Producto</label>
			       		<input type="text" class="form-control" name="producto[]" />    
			        </div>
			        <div class="col-2 col-md-2">
			        	<label>Cantidad</label>
			       		<input type="text" class="form-control" name="cantidad[]" />    
			        </div>
			        <div class="col-2 col-md-2">
			        	<label>Costo</label>
			       		<input type="text" class="form-control" name="costo[]" />    
			        </div>
			        <div class="col-2 col-md-1">
			        	<label>Acciones</label>
			            <button type="button" class="btn btn-default addButton" data-template="productoTemplate" data-campo='correo'><i class="fa fa-plus"></i></button>
			        </div>
			    </div>

			    <!-- The option field template containing an option field and a Remove button -->
			    <div class="form-group d-none row" id="productoTemplate">
			        <div class="col-6 col-md-7">
			       		<input type="text" class="form-control" name="producto[]" />    
			        </div>
			        <div class="col-2 col-md-2">
			       		<input type="text" class="form-control" name="cantidad[]" />    
			        </div>
			        <div class="col-2 col-md-2">
			       		<input type="text" class="form-control" name="costo[]" />    
			        </div>
			        <div class="col-2 col-md-1">
			            <button type="button" class="btn btn-default removeButton" data-campo='correo'><i class="fa fa-minus"></i></button>
			        </div>
			    </div>		
					

					
				
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-md-8">
				
			</div>
			<div class="col-12 col-md-4">
				<div class="card mb-3">
	        		<div class="card-header">
	          			Total</div>
			        <div class="card-body">	
						<div class="row">
							<div class="col-6">
								<p>Subtotal</p>
							</div>
							<div class="col-6">
								<p><strong>$ 1 000.00</strong></p>
							</div>
						</div>							
					
					
						<div class="row">
							<div class="col-6">
								<p>Impuesto</p>
							</div>
							<div class="col-6">
								<p><strong>$ 130.00</strong></p>
							</div>
						</div>									
					
						<div class="row">
							<div class="col-6">
								<p>Total</p>
							</div>
							<div class="col-6">
								<p><strong>$ 1 130.00</strong></p>
							</div>
						</div>									
					</div>
				</div>
			</div>
		</div>


		<button type="submit" class="btn btn-success form-submit"><i class="fa fa-fw fa-save"></i> Guardar</button> <button type="submit" class="btn btn-primary form-submit"><i class="fa fa-fw fa-print"></i> Imprimir</button> <button type="submit" class="btn btn-primary form-submit"><i class="fa fa-fw fa-envelope"></i> Enviar por email</button> <button type="submit" class="btn btn-primary form-submit"><i class="fa fa-fw fa-cloud-upload"></i> Enviar a Hacienda</button>
	</form>
	
</div>