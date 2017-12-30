<!-- Breadcrumbs-->
<ol class="breadcrumb">
	<li class="breadcrumb-item">
	  <a href="/">Inicio</a>
	</li>
	<li class="breadcrumb-item">
	  <a href="/clientes">Clientes</a>
	</li>
	<li class="breadcrumb-item active">Editar cliente</li>
</ol>
<h1  class="text-center"><i class="fa fa-fw fa-handshake-o"></i> Clientes</h1>
<hr>
<h2><i class="fa fa-fw fa-edit"></i> Editar cliente</h2>

<div class="page-content">
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
	<form id="editarCliente" class="form-validation" method="post" name="editarCliente">
		<div class="form-group">
			<label for="nombre">Nombre de cliente</label>
			<input type="text" name="nombre_cliente" class="form-control input-required" id="nombre" aria-describedby="nombreHelp" value="<?=(isset($cliente->nombre_cliente))?$cliente->nombre_cliente:''?>" >
			<small id="nombreHelp" class="form-text text-muted">Ingrese el nombre del cliente tal cual desea que lo ubiquen el resto de los usuarios.<br/>
			</small>
		</div>
		<div class="form-group">
			<label for="cedula">Cédula del cliente</label>
			<input type="text" name="cedula_cliente" class="form-control" id="cedula" aria-describedby="cedulaHelp" value="<?=(isset($cliente->cedula_cliente))?$cliente->cedula_cliente:''?>">
			<small id="cedulaHelp" class="form-text text-muted">Ingrese el número de cédula, ya sea física o jurídica.</small>
		</div>
	    
	    <label class="control-label">Correos de contacto</label>
	    <?php if(isset($cliente_correo)){ 
			foreach($cliente_correo as $kcorreo => $vcorreo){ ?>
				<div class="form-group row">
					<div class="col-10 col-md-11">
			       		<input type="text" class="form-control" name="correo[<?=$kcorreo?>]" value="<?=$vcorreo->correo_cliente?>" />    
			        </div>
			        <div class="col-2 col-md-1">
			            <button type="button" class="btn btn-default addButton" data-template="correoTemplate" data-campo='correo'><i class="fa <?=($kcorreo==0)?'fa-plus':'fa-minus'?>"></i></button>
			        </div>
			    </div>
			<?php	
			}
	    }else{ ?>
			<div class="form-group row">
				<div class="col-10 col-md-11">
		       		<input type="text" class="form-control" name="correo[]" />    
		        </div>
		        <div class="col-2 col-md-1">
		            <button type="button" class="btn btn-default addButton" data-template="correoTemplate" data-campo='correo'><i class="fa fa-plus"></i></button>
		        </div>
		    </div>
	    <?php } ?>

	    <!-- The option field template containing an option field and a Remove button -->
	    <div class="form-group d-none row" id="correoTemplate">
	        <div class="col-10 col-md-11">
	            <input class="form-control" type="text" name="correo[]" />
	        </div>
	        <div class="col-2 col-md-1">
	            <button type="button" class="btn btn-default removeButton" data-campo='correo'><i class="fa fa-minus"></i></button>
	        </div>
	    </div>
	    
	    <label class="control-label">Teléfonos de contacto</label>

	    <?php if(isset($cliente_telefono)){ 
			foreach($cliente_telefono as $ktelefono => $vtelefono){ ?>
				<div class="form-group row">
					<div class="col-10 col-md-11">
			       		<input type="text" class="form-control" name="telefono[<?=$ktelefono?>]" value="<?=$vtelefono->telefono_cliente?>" />    
			        </div>
			        <div class="col-2 col-md-1">
			            <button type="button" class="btn btn-default addButton" data-template="telefonoTemplate" data-campo='telefono'><i class="fa <?=($ktelefono==0)?'fa-plus':'fa-minus'?>"></i></button>
			        </div>
			    </div>
			<?php	
			}
	    }else{ ?>
			<div class="form-group row">
				<div class="col-10 col-md-11">
		       		<input type="text" class="form-control" name="telefono[]" />    
		        </div>
		        <div class="col-2 col-md-1">
		            <button type="button" class="btn btn-default addButton" data-template="telefonoTemplate" data-campo='telefono'><i class="fa fa-plus"></i></button>
		        </div>
		    </div>
	    <?php } ?>

	    <!-- The option field template containing an option field and a Remove button -->
	    <div class="form-group d-none row" id="telefonoTemplate">
	        <div class="col-10 col-md-11">
	            <input class="form-control" type="text" name="telefono[]" />
	        </div>
	        <div class="col-2 col-md-1">
	            <button type="button" class="btn btn-default removeButton" data-campo='telefono'><i class="fa fa-minus"></i></button>
	        </div>
	    </div>


	    <div class="form-group">
			<label>Estado del cliente:</label>
			<div class="form-check">
				<label class="form-check-label">
					<input class="form-check-input" type="radio" name="estado_cliente" id="estado1" value="1" <?=(isset($cliente->estado_cliente) && $cliente->estado_cliente==1)?'checked="checked"':''?>>
					Activo
				</label>
			</div>
			<div class="form-check">
				<label class="form-check-label">
					<input class="form-check-input" type="radio" name="estado_cliente" id="estado2" value="0" <?=(isset($cliente->estado_cliente) && $cliente->estado_cliente==0)?'checked="checked"':''?>>
					Inactivo
				</label>
			</div>
		</div>
	  <button type="submit" class="btn btn-primary form-submit"><i class="fa fa-fw fa-save"></i> Guardar</button>
	</form>
	
</div>