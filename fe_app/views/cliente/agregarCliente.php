<script type="text/javascript" src="/fe_pub/js/cliente.js"></script>
<div class="controller" ng-controller="agregarClienteController">
	<form id="agregarCliente" class="form-validation" method="post" name="agregarCliente">
		<div id="headerbar">
	        <h1 class="headerbar-title">Agregar clientes</h1>
	        <?php require_once '/../master/header_buttons.php'; ?>
	    </div>
		<div id="content">
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
			<div class="row">
				<div class="col-12 col-md-6">
					<div class="panel panel-default">
	                    <div class="panel-heading form-inline clearfix">
	                        Datos de cliente

	                        
	                    </div>

	                    <div class="panel-body">
	                    	<div class="form-group">
	                    		<label for="tipo-cliente">
	                    			Tipo de cliente
	                    		</label>
	                    		<select class="form-control" name="tipo_cliente" id="tipo_cliente" ng-model="tipo_cliente" ng-change="cambio()" aria-describedby="tigoGastoHelp">
	                    			<option value="fisico" >Físico</option>
	                    			<option value="juridico">Jurídico</option>
	                    		</select>
	                    		
							
	                    	</div>

	                    	<div class="form-group" ng-if="tipo_cliente==='juridico'">
								<label for="nombre">Nombre de cliente</label>
								<input type="text" name="nombre_cliente" class="form-control input-required" id="nombre" aria-describedby="nombreHelp" >
								<small id="nombreHelp" class="form-text text-muted">Ingrese el nombre del cliente tal cual desea que lo ubiquen el resto de los usuarios.<br/>
								</small>
							</div>
	                    	<div class="form-group" ng-if="tipo_cliente==='fisico'" >
								<label for="nombre">Primer nombre de cliente</label>
								<input type="text" name="nombre_cliente" class="form-control input-required" id="nombre" aria-describedby="nombreHelp" >
								<small id="nombreHelp" class="form-text text-muted">Ingrese el primer nombre del cliente.<br/>
								</small>
							</div>
							<div class="form-group" ng-if="tipo_cliente==='fisico'">
								<label for="nombre">Segundo nombre de cliente</label>
								<input type="text" name="nombre_cliente" class="form-control input-required" id="nombre" aria-describedby="nombreHelp" >
								<small id="nombreHelp" class="form-text text-muted">Ingrese el segundo nombre del cliente (Opcional).<br/>
								</small>
							</div>
							<div class="form-group" ng-if="tipo_cliente==='fisico'">
								<label for="nombre">Apellido de cliente</label>
								<input type="text" name="nombre_cliente" class="form-control input-required" id="nombre" aria-describedby="nombreHelp" >
								<small id="nombreHelp" class="form-text text-muted">Ingrese el apellido del cliente.<br/>
								</small>
							</div>
							<div class="form-group">
								<label for="cedula">Cédula del cliente</label>
								<input type="text" name="cedula_cliente" class="form-control" id="cedula" aria-describedby="cedulaHelp">
								<small id="cedulaHelp" class="form-text text-muted">Ingrese el número de cédula, ya sea física o jurídica.</small>
							</div>
							<div class="form-group">
								<label>Estado del cliente:</label>
								<div class="form-check">
									<label class="form-check-label">
										<input class="form-check-input" type="radio" name="estado_cliente" id="estado1" value="1" checked>
										Activo
									</label>
								</div>
								<div class="form-check">
									<label class="form-check-label">
										<input class="form-check-input" type="radio" name="estado_cliente" id="estado2" value="0">
										Inactivo
									</label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-6">
					<div class="panel panel-default">
	                    <div class="panel-heading form-inline clearfix">
	                        Teléfonos                       
	                    </div>

	                    <div class="panel-body">
							<div class=" group-template row">
								<div class="col-10 col-md-11">
									<div class="form-group phone-group row">
						       			<div class="col-xs-3">
						       				 <label class="control-label">Código de país</label>
					            			<input type="text" class="form-control" name="phone_countrycode[]" />
					            		</div>
					            		<div class="col-xs-6">
					            			 <label class="control-label">Número telefónico</label>
					            			<input type="text" class="form-control" name="phone_number[]" /> 
					            		</div>
					            		<div class="col-xs-3">
					            			 <label class="control-label">Extensión</label>
					            			<input type="text" class="form-control" name="phone_ext[]" />
					            		</div>		    									
									</div>
						        </div>
						        <div class="col-2 col-md-1">
						        	<br>
						            <button type="button" class="btn btn-default addButton" data-template="telefonoTemplate" data-campo='phone-group'><i class="fa fa-plus"></i></button>
						        </div>
						    </div>

						    <!-- The option field template containing an option field and a Remove button -->
						    <div class="d-none row group-template" id="telefonoTemplate">
						        <div class="col-10 col-md-11">
						        	<div class="form-group phone-group row">
					            		<div class="col-xs-3">
						       				<label class="control-label">Código de país</label>
					            			<input type="text" class="form-control" name="phone_countrycode[]" />
					            		</div>
					            		<div class="col-xs-6">
					            			 <label class="control-label">Número telefónico</label>
					            			<input type="text" class="form-control" name="phone_number[]" /> 
					            		</div>
					            		<div class="col-xs-3">
					            			 <label class="control-label">Extensión</label>
					            			<input type="text" class="form-control" name="phone_ext[]" />
					            		</div>		       			 									
															        		
						        	</div>
						        </div>
						        <div class="col-2 col-md-1">
						        	<br>
						            <button type="button" class="btn btn-default removeButton" data-campo='phone-group'><i class="fa fa-minus"></i></button>
						        </div>
						    </div>
							
	                    </div>
	                </div>
				</div>
				
			</div>
			<div class="row">
				<div class="col-12 col-md-6">
					<div class="panel panel-default">
	                    <div class="panel-heading form-inline clearfix">
	                        Direcciones
	                    </div>

	                    <div class="panel-body">
							<div class=" row group-template">
								<div class="col-10 col-md-11">
									<div class="form-group">
						       			<input type="text" class="form-control" name="direccion[]" />    									
									</div>
						        </div>
						        <div class="col-2 col-md-1">
						            <button type="button" class="btn btn-default addButton" data-template="direccionTemplate" data-campo='direccion'><i class="fa fa-plus"></i></button>
						        </div>
						    </div>

						    <!-- The option field template containing an option field and a Remove button -->
						    <div class="d-none row group-template" id="direccionTemplate">
						        <div class="col-10 col-md-11">
						        	<div class="form-group">
						            	<input class="form-control" type="text" name="direccion[]" />					        		
						        	</div>
						        </div>
						        <div class="col-2 col-md-1">
						            <button type="button" class="btn btn-default removeButton" data-campo='direccion'><i class="fa fa-minus"></i></button>
						        </div>
						    </div>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-6">
					<div class="panel panel-default">
	                    <div class="panel-heading form-inline clearfix">
	                        Correos electrónicos                       
	                    </div>

	                    <div class="panel-body">
							<div class=" row group-template">
								<div class="col-10 col-md-11">
									<div class="form-group">
						       			<input type="text" class="form-control" name="correo[]" />    									
									</div>
						        </div>
						        <div class="col-2 col-md-1">
						            <button type="button" class="btn btn-default addButton" data-template="correoTemplate" data-campo='correo'><i class="fa fa-plus"></i></button>
						        </div>
						    </div>

						    <!-- The option field template containing an option field and a Remove button -->
						    <div class="d-none row group-template" id="correoTemplate">
						        <div class="col-10 col-md-11">
						        	<div class="form-group">					        		
						            	<input class="form-control" type="text" name="correo[]" />
						        	</div>
						        </div>
						        <div class="col-2 col-md-1">
						            <button type="button" class="btn btn-default removeButton" data-campo='correo'><i class="fa fa-minus"></i></button>
						        </div>
						    </div>
	                    </div>
	                </div>
				</div>
				
			</div>
		</div>
	</form>
	
</div>
