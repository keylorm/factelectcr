<!-- Breadcrumbs-->
<ol class="breadcrumb">
	<li class="breadcrumb-item">
	  <a href="/">Inicio</a>
	</li>
	<li class="breadcrumb-item">
	  <a href="/proveedores">Proveedores</a>
	</li>
	<li class="breadcrumb-item active">Editar proveedor</li>
</ol>
<h1  class="text-center"><i class="fa fa-fw fa-handshake-o"></i> Proveedores</h1>
<hr>
<h2><i class="fa fa-fw fa-edit"></i> Editar proveedor</h2>

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
	<form id="editarProveedor" class="form-validation" method="post" name="editarProveedor">
		<div class="form-group">
			<label for="nombre">Nombre de proveedor</label>
			<input type="text" name="nombre_proveedor" class="form-control input-required" id="nombre" aria-describedby="nombreHelp" value="<?=(isset($proveedor->nombre_proveedor))?$proveedor->nombre_proveedor:''?>" >
			<small id="nombreHelp" class="form-text text-muted">Ingrese el nombre del proveedor tal cual desea que lo ubiquen el resto de los usuarios.<br/>
			</small>
		</div>
		<div class="form-group">
			<label for="cedula">Cédula del proveedor</label>
			<input type="text" name="cedula_proveedor" class="form-control" id="cedula" aria-describedby="cedulaHelp" value="<?=(isset($proveedor->cedula_proveedor))?$proveedor->cedula_proveedor:''?>">
			<small id="cedulaHelp" class="form-text text-muted">Ingrese el número de cédula, ya sea física o jurídica.</small>
		</div>
	    
	    <label class="control-label">Correos de contacto</label>
	    <?php if(isset($proveedor_correo)){ 
			foreach($proveedor_correo as $kcorreo => $vcorreo){ ?>
				<div class="form-group row">
					<div class="col-10 col-md-11">
			       		<input type="text" class="form-control" name="correo[<?=$kcorreo?>]" value="<?=$vcorreo->correo_proveedor?>" />    
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

	    <?php if(isset($proveedor_telefono)){ 
			foreach($proveedor_telefono as $ktelefono => $vtelefono){ ?>
				<div class="form-group row">
					<div class="col-10 col-md-11">
			       		<input type="text" class="form-control" name="telefono[<?=$ktelefono?>]" value="<?=$vtelefono->telefono_proveedor?>" />    
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
			<label>Estado del proveedor:</label>
			<div class="form-check">
				<label class="form-check-label">
					<input class="form-check-input" type="radio" name="estado_proveedor" id="estado1" value="1" <?=(isset($proveedor->estado_proveedor) && $proveedor->estado_proveedor==1)?'checked="checked"':''?>>
					Activo
				</label>
			</div>
			<div class="form-check">
				<label class="form-check-label">
					<input class="form-check-input" type="radio" name="estado_proveedor" id="estado2" value="0" <?=(isset($proveedor->estado_proveedor) && $proveedor->estado_proveedor==0)?'checked="checked"':''?>>
					Inactivo
				</label>
			</div>
		</div>
	  <button type="submit" class="btn btn-primary form-submit"><i class="fa fa-fw fa-save"></i> Guardar</button>
	</form>
	
</div>