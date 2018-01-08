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
				<div class="col-12 col-md-5 col-lg-6">
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
	                    			<?php if(isset($person_types)){
	                    				foreach ($person_types as $key => $value) { ?>
	                    						<option value="<?=$value->person_type_id?>" ng-value="<?=$value->person_type_id?>"" <?=($value->person_type_id==1)?'selected="selected"':''?> ><?=$value->person_description?></option>
	                    					
	                    				<?php }
	                    			} ?>	                    			
	                    		</select>
	                    		
							
	                    	</div>

	                    	<div class="form-group" ng-if="tipo_cliente==2">
								<label for="nombre">Nombre de cliente</label>
								<input type="text" name="nombre_cliente" class="form-control input-required" id="nombre" aria-describedby="nombreHelp" >
								<small id="nombreHelp" class="form-text text-muted">Ingrese el nombre del cliente tal cual desea que lo ubiquen el resto de los usuarios.<br/>
								</small>
							</div>
	                    	<div class="form-group" ng-if="tipo_cliente==1" >
								<label for="nombre">Primer nombre de cliente</label>
								<input type="text" name="nombre_cliente" class="form-control input-required" id="nombre" aria-describedby="nombreHelp" >
								<small id="nombreHelp" class="form-text text-muted">Ingrese el primer nombre del cliente.<br/>
								</small>
							</div>
							<div class="form-group" ng-if="tipo_cliente==1">
								<label for="nombre">Segundo nombre de cliente</label>
								<input type="text" name="segundo_nombre_cliente" class="form-control" id="nombre" aria-describedby="segnombreHelp" >
								<small id="segnombreHelp" class="form-text text-muted">Ingrese el segundo nombre del cliente (Opcional).<br/>
								</small>
							</div>
							<div class="form-group" ng-if="tipo_cliente==1">
								<label for="nombre">Apellido de cliente</label>
								<input type="text" name="apellido_cliente" class="form-control" id="nombre" aria-describedby="apellidoHelp" >
								<small id="apellidoHelp" class="form-text text-muted">Ingrese el apellido del cliente.<br/>
								</small>
							</div>
							<div class="form-group">
								<label for="cedula">Cédula del cliente</label>
								<input type="text" name="cedula_cliente" class="form-control input-required" id="cedula" aria-describedby="cedulaHelp">
								<small id="cedulaHelp" class="form-text text-muted">Ingrese el número de cédula, ya sea física o jurídica.</small>
							</div>
							
						</div>
					</div>
				</div>
				<div class="col-12 col-md-7 col-lg-6">
					<div class="panel panel-default">
	                    <div class="panel-heading form-inline clearfix">
	                        Direcciones
	                    </div>

	                    <div class="panel-body">
							<div class="px-3 mb-3 border border-top-0 border-left-0 border-right-0 row group-template" ng-repeat="(x,address) in addresses">
								<label><strong>Dirección {{x+1}}:</strong></label>
								<div class="col-9 col-md-11">
									<div class="form-group address-group row">
										<div class="col-12 col-md-6">
						       				<label class="control-label">¿Contacto principal?</label>
					            			<select class="form-control select-required" name="address_principal[]" id="address_principal[]" aria-describedby="paisHelp">
				                    			<option value="none">- Seleccionar - </option>
				                    			<option value="true">Si</option>
				                    			<option value="false">No</option>				                    			
				                    		</select>
					            		</div>
					            		<div class="col-12 col-md-6">
						       				<label class="control-label">País</label>
					            			<select class="form-control" name="address_country[]" id="address_country[]" ng-model="address.address_country"  aria-describedby="paisHelp">
				                    			<?php foreach ($paises as $key => $value) { ?>
				                    				<option value="<?=$value->codigo_pais?>" <?=($value->codigo_pais=='CR')?'selected="selected"':''?>><?=$value->nombre_pais?></option>
				                    			<?php } ?>
				                    		</select>
					            		</div>
					            		       			 									
															        		
						        	</div>
									<div class="form-group address-group row">
					            		
					            		<div class="col-12 col-md-6" ng-if="address.address_country!=='CR'">
					            			<label class="control-label">Estado</label>
					            			<input type="text" class="form-control" name="address_state[]" /> 
					            		</div>
					            		<div class="col-12 col-md-6" ng-if="address.address_country==='CR'">
					            			<label class="control-label">Provincia</label>
					            			<select class="form-control" name="address_state[]" id="address_state[]" ng-model="address.provincia_id" aria-describedby="provinciaHelp" ng-change="getCantones(x)">
				                    			<?php foreach ($provincias as $key => $value) { ?>
				                    				<option value="<?=$value->provincia_id?>"><?=$value->provincia?></option>
				                    			<?php } ?>
				                    		</select> 
					            		</div>	       			 									
															        		
					            		<div class="col-12 col-md-6" ng-if="address.address_country!=='CR'"> 
					            			<label class="control-label">Municipio</label>
					            			 
					            			<input type="text" class="form-control" name="address_canton[]" /> 
					            		</div>
					            		
					            		<div class="col-12 col-md-6" ng-if="address.address_country==='CR'">
					            			 <label class="control-label">Cantón</label>
					            			 <select class="form-control" name="address_canton[]" id="address_canton[]" aria-describedby="cantonHelp" ng-model="address.canton_id" ng-change="getDistritos(x)">
												<option ng-repeat="canton in address.cantones" value="{{canton.canton_id}}">
													{{canton.canton}}
												</option>
											</select>
					            		</div>
						        	</div>
						        	<div class="form-group address-group row">
					            		<div class="col-12 col-md-6" ng-if="address.address_country!=='CR'">
					            			 <label class="control-label">Distrito</label>					            			 
					            			<input type="text" class="form-control" name="address_district[]" />
					            		</div>	
					            		<div class="col-12 col-md-6" ng-if="address.address_country==='CR'">
					            			 <label class="control-label">Distrito</label>
					            			 <select class="form-control" name="address_district[]" id="address_district[]" aria-describedby="distritoHelp" ng-model="address.distrito_id" ng-change="getBarrios(x)">
												<option ng-repeat="distrito in address.distritos" value="{{distrito.distrito_id}}" >
													{{distrito.distrito}}
												</option>
											</select>
					            		</div>		       			 									
					            		<div class="col-12 col-md-6">
					            			 <label class="control-label">Barrio</label>
					            			<select class="form-control" name="address_neighborhood[]" id="address_neighborhood[]" aria-describedby="distritoHelp" ng-model="address.barrio_id">
												<option ng-repeat="barrio in address.barrios" value="{{barrio.barrio_id}}" >
													{{barrio.barrio}}
												</option>
											</select>
					            		</div>
					            			       			 									
															        		
						        	</div>
						        	
						        	<div class="form-group address-group row">
					            		
					            		<div class="col-12 col-md-6">
					            			 <label class="control-label">Calle</label>
					            			<input type="text" class="form-control" name="address_street[]" /> 
					            		</div>
					            		<div class="col-12 col-md-6">
					            			 <label class="control-label">Número de casa o edificio</label>
					            			<input type="text" class="form-control" name="address_number" />
					            		</div>		       			 									
															        		
						        	</div>
						        	<div class="form-group address-group row">
					            		
					            		<div class="col-12 col-md-6">
					            			 <label class="control-label">Dirección línea 1</label>
					            			<input type="text" class="form-control" name="address_firstline[]" /> 
					            		</div>
					            		<div class="col-12 col-md-6">
					            			 <label class="control-label">Dirección línea 2</label>
					            			<input type="text" class="form-control" name="address_secondline[]" />
					            		</div>		       			 									
															        		
						        	</div>
									
						        </div>
						        <div class="col-3 col-md-1">
						            <button ng-show="x>0" type="button" class="btn btn-default" data-template="direccionTemplate" data-campo='direccion' ng-click="removeAddress()"><i class="fa fa-minus"></i></button>
						        </div>

						    </div>
						    <button type="button" class="btn btn-default" data-template="direccionTemplate" data-campo='direccion' ng-click="addNewAddress()"><i class="fa fa-plus"></i></button>

						    
						</div>
					</div>
					
				</div>
				
			</div>
			<div class="row">
				<div class="col-12 col-md-6">
					<div class="panel panel-default">
	                    <div class="panel-heading form-inline clearfix">
	                        Teléfonos                       
	                    </div>

	                    <div class="panel-body">
							<div class=" group-template row" ng-repeat="(x,phone) in phones">
								<div class="col-9 col-md-11">
									<div class="form-group phone-group row">
						       			<div class="col-12 col-md-4 col-lg-3">
						       				 <label class="control-label">Código de país</label>
					            			<input type="text" class="form-control" name="phone_countrycode[]" maxlength="3" />
					            		</div>
					            		<div class="col-12 col-md-4 col-lg-6">
					            			 <label class="control-label">Número telefónico</label>
					            			<input type="text" class="form-control" name="phone_number[]" /> 
					            		</div>
					            		<div class="col-12 col-md-4 col-lg-3">
					            			 <label class="control-label">Extensión</label>
					            			<input type="text" class="form-control" name="phone_ext[]" />
					            		</div>		    									
									</div>
						        </div>
						        <div class="col-3 col-md-1">
						        	<br>
						            <button ng-show="x>0" type="button" class="btn btn-default"><i class="fa fa-minus" ng-click="removePhone()"></i></button>
						        </div>
						    </div>
						    <button type="button" class="btn btn-default" ng-click="addNewPhone()"><i class="fa fa-plus"></i></button>
	                    </div>
	                </div>
				</div>
				<div class="col-12 col-md-6">
					<div class="panel panel-default">
	                    <div class="panel-heading form-inline clearfix">
	                        Correos electrónicos                       
	                    </div>

	                    <div class="panel-body">
							<div class=" row group-template" ng-repeat="(x,email) in emails">
								<div class="col-9 col-md-11">
									<div class="form-group">
						       			<input type="text" class="form-control" name="correo[]" />    									
									</div>
						        </div>
						        <div class="col-3 col-md-1">
						             <button ng-show="x>0" type="button" class="btn btn-default"><i class="fa fa-minus" ng-click="removeEmail()"></i></button>
						        </div>
						    </div>
							<button type="button" class="btn btn-default" ng-click="addNewEmail()"><i class="fa fa-plus"></i></button>
	                    </div>
	                </div>
				</div>
				
			</div>
		</div>
	</form>
	
</div>
