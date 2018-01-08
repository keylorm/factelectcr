<div class="controller">
	<form id="gestionEmpresa" class="form-validation" method="post" name="gestionEmpresa">
		<div id="headerbar">
	        <h1 class="headerbar-title">Agregar empresa</h1>
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
	                        Datos de la empresa
	                    </div>

	                    <div class="panel-body">
	                    	<div class="form-group">
	                    		<label for="tipo_company">
	                    			Tipo de cliente
	                    		</label>
	                    		<select class="form-control" name="tipo_company" id="tipo_company" ng-model="tipo_company" ng-change="cambio()" aria-describedby="tigoGastoHelp">
	                    			<?php if(isset($person_types)){
	                    				foreach ($person_types as $key => $value) { ?>
	                    						<option value="<?=$value->person_type_id?>" ng-value="<?=$value->person_type_id?>"" <?=($value->person_type_id==1)?'selected="selected"':''?> ><?=$value->person_description?></option>
	                    					
	                    				<?php }
	                    			} ?>	                    			
	                    		</select>
	                    		
							
	                    	</div>

	                    	

	                    	<div class="form-group">
								<label for="company_name">Nombre</label>
								<input type="text" name="company_name" class="form-control input-required" id="company_name" aria-describedby="folioFacturaHelp" >
								<small id="folioFacturaHelp" class="form-text text-muted">Ingrese el nombre de la empresa o sociedad que factura.<br/>
								</small>
							</div>
							<div class="form-group">
								<label for="company_comercialname">Nombre comercial</label>
								<input type="text" name="company_comercialname" class="form-control input-required" id="company_comercialname" aria-describedby="folioFacturaHelp" >
								<small id="folioFacturaHelp" class="form-text text-muted">Ingrese el nombre comercial de la empresa o sociedad que factura.<br/>
								</small>
							</div>
	                    	<div class="form-group">
								<label for="company_identification">Cédula de la empresa</label>
								<input type="text" name="company_identification" class="form-control input-required" id="company_identification" aria-describedby="folioFacturaHelp" >
								<small id="folioFacturaHelp" class="form-text text-muted">Ingrese la cédula física o jurídica de quien factura.<br/>
								</small>
							</div>
							
							
						</div>
					</div>
				</div>
				<div class="col-12 col-md-6">
					<div class="panel panel-default">
	                    <div class="panel-heading form-inline clearfix">
	                        Datos de conexión a hacienda
	                    </div>

	                    <div class="panel-body row">                    	
	                    	<div class="form-group col-12 col-md-6">
								<label for="company_atv_user">Usuario de ATV</label>
								<input type="text" name="company_atv_user" class="form-control input-required" id="company_atv_user" aria-describedby="folioFacturaHelp" >
								<small id="folioFacturaHelp" class="form-text text-muted">Ingrese el usuario de ATV obtenido del Ministerio de Hacienda.<br/>
								</small>
							</div>
							<div class="form-group col-12 col-md-6">
								<label for="company_atv_pass">Contraseña de ATV</label>
								<input type="text" name="company_atv_pass" class="form-control input-required" id="company_atv_pass" aria-describedby="folioFacturaHelp" >
								<small id="folioFacturaHelp" class="form-text text-muted">Ingrese el la contraseña de ATV obtenida del Ministerio de Hacienda.<br/>
								</small>
							</div>
	                    	<div class="form-group col-12 col-md-6">
								<label for="company_certificate_user">Certificado</label>
								<input type="text" name="company_certificate_user" class="form-control input-required" id="company_certificate_user" aria-describedby="folioFacturaHelp" >
								<small id="folioFacturaHelp" class="form-text text-muted">Ingrese el certificado obtenido del Ministerio de Hacienda.<br/>
								</small>
							</div>
							<div class="form-group col-12 col-md-6">
								<label for="company_certificate_pass">Contraseña del certificado</label>
								<input type="text" name="company_certificate_pass" class="form-control input-required" id="company_certificate_pass" aria-describedby="folioFacturaHelp" >
								<small id="folioFacturaHelp" class="form-text text-muted">Ingrese el la contraseña del certificado obtenida del Ministerio de Hacienda.<br/>
								</small>
							</div>
							
							
						</div>
					</div>
				</div>


				<div class="col-12">
					<div class="panel panel-default">
	                    <div class="panel-heading form-inline clearfix">
	                        Gestión de Folios
	                    </div>

	                    <div class="panel-body">
	                    	<p><strong>Folios para factura:</strong></p>  
	                    	<div class="row">
	                    		<input type="hidden" name="official_number_factura_tipo_documento" value=""/>
	                    		<div class="form-group col-12 col-md-4">
									<label for="official_number_factura_prefix">Prefijo de folio</label>
									<input type="text" name="official_number_factura_prefix" class="form-control input-required" id="official_number_factura_prefix" aria-describedby="folioprefijoHelp" >
									<small id="folioprefijoHelp" class="form-text text-muted">Ingrese el prefijo del folio de la factura.<br/>
									</small>
								</div>
		                    	<div class="form-group col-12 col-md-4">
									<label for="official_number_factura_initial">Número inicial de folio</label>
									<input type="number" name="official_number_factura_initial" class="form-control input-required" id="official_number_factura_initial" aria-describedby="folioFacturaHelp" >
									<small id="folioFacturaHelp" class="form-text text-muted">Ingrese el número de folio inicial de factura sobre la cual continuar la facturación en el sistema.<br/>
									</small>
								</div>
		                    	<div class="form-group col-12 col-md-4">
									<label for="official_number_factura_final">Número final de folio</label>
									<input type="number" name="official_number_factura_final" class="form-control input-required" id="official_number_factura_final" aria-describedby="folioFacturaHelp" >
									<small id="folioFacturaHelp" class="form-text text-muted">Ingrese el número de folio final de factura sobre la cual continuar la facturación en el sistema.<br/>
									</small>
								</div>
	                    		
	                    	</div>    
							<p><strong>Folios para notas de crédito:</strong></p>
	                    	<div class="row">
	                    		<input type="hidden" name="official_number_nota_credito_tipo_documento" value=""/>
	                    		<div class="form-group col-12 col-md-4">
									<label for="official_number_nota_credito_prefix">Prefijo de folio</label>
									<input type="text" name="official_number_nota_credito_prefix" class="form-control input-required" id="official_number_nota_credito_prefix" aria-describedby="folioprefijoHelp" >
									<small id="folioprefijoHelp" class="form-text text-muted">Ingrese el prefijo del folio de la nota de crédito.<br/>
									</small>
								</div>
		                    	<div class="form-group col-12 col-md-4">
									<label for="official_number_nota_credito_initial">Número inicial de folio</label>
									<input type="number" name="official_number_nota_credito_initial" class="form-control input-required" id="official_number_nota_credito_initial" aria-describedby="folioFacturaHelp" >
									<small id="folioFacturaHelp" class="form-text text-muted">Ingrese el número de folio inicial de nota de crédito sobre la cual continuar la facturación en el sistema.<br/>
									</small>
								</div>
		                    	<div class="form-group col-12 col-md-4">
									<label for="official_number_nota_credito_final">Número final de folio</label>
									<input type="number" name="official_number_nota_credito_final" class="form-control input-required" id="official_number_nota_credito_final" aria-describedby="folioFacturaHelp" >
									<small id="folioFacturaHelp" class="form-text text-muted">Ingrese el número de folio final de nota de crédito sobre la cual continuar la facturación en el sistema.<br/>
									</small>
								</div>
	                    		
	                    	</div>
	                    	<p><strong>Folios para notas de débito:</strong></p>
	                    	<div class="row">
	                    		<input type="hidden" name="official_number_nota_debito_tipo_documento" value=""/>
	                    		<div class="form-group col-12 col-md-4">
									<label for="official_number_nota_credito_prefix">Prefijo de folio</label>
									<input type="text" name="official_number_nota_debito_prefix" class="form-control input-required" id="official_number_nota_credito_prefix" aria-describedby="folioprefijoHelp" >
									<small id="folioprefijoHelp" class="form-text text-muted">Ingrese el prefijo del folio de la nota de débito.<br/>
									</small>
								</div>
								<div class="form-group col-12 col-md-4">
									<label for="official_number_nota_debito_initial">Número inicial de folio</label>
									<input type="text" name="official_number_nota_debito_initial" class="form-control input-required" id="official_number_nota_debito_initial" aria-describedby="folioFacturaHelp" >
									<small id="folioFacturaHelp" class="form-text text-muted">Ingrese el número de folio inicial de nota de débito sobre la cual continuar la facturación en el sistema.<br/>
									</small>
								</div>
		                    	<div class="form-group col-12 col-md-4">
									<label for="official_number_nota_debito_final">Número final de folio</label>
									<input type="text" name="official_number_nota_debito_final" class="form-control input-required" id="official_number_nota_debito_final" aria-describedby="folioFacturaHelp" >
									<small id="folioFacturaHelp" class="form-text text-muted">Ingrese el número de folio final de nota de débito sobre la cual continuar la facturación en el sistema.<br/>
									</small>
								</div>
	                    		
	                    	</div>              	
							

							
							
						</div>
					</div>
				</div>
				
			</div>
			
		</div>
	</form>
	
</div>
