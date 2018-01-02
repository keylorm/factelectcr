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
		<a href="/proyectos/extensiones/<?=$proyecto->proyecto_id?>">Extensiones</a>
	</li>
	<li class="breadcrumb-item active">Editar extensión</li>
</ol>

<h1 class="text-center">Extensiones de proyectos</h1>
<hr>

<div class="row">
	<div class="col-12 col-md-10"><h3 class=" text-center text-md-left"><i class="fa fa-fw fa-edit"></i> Editar extensión</h3></div>
	<div class="col-12 col-md-2"><a class="btn btn-primary float-md-right mb-3 mr-md-3 mx-auto d-block d-md-inline-block" href="/proyectos/extensiones/<?=$proyecto->proyecto_id?>" role="button"><i class="fa fa-fw fa-arrow-left"></i> Volver a extensiones</a></div>
</div>


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
	<form id="editarExtensionProyecto" class="form-validation" method="post" name="editarExtensionProyecto">
		<div class="card mb-3">
	        <div class="card-header">
	          	Información de la extensión</div>
	        <div class="card-body">
	        	<div class="row">
	        		<div class="col-12 col-md-6">
	        			<div class="form-group">
							<label for="proyecto_valor_oferta_extension_tipo_id">Tipo de extensión:</label>
							<select class="form-control" name="proyecto_valor_oferta_extension_tipo_id" id="proyecto_valor_oferta_extension_tipo_id" aria-describedby="tipoextensionHelp">
								<?php if(isset($extensiones_tipos)){
								 		foreach ($extensiones_tipos as $kextension => $vextension) {
								 			$selected = '';
									 		if(isset($proyecto_extension->proyecto_valor_oferta_extension_tipo_id)){
									 			if($proyecto_extension->proyecto_valor_oferta_extension_tipo_id == $vextension->proyecto_valor_oferta_extension_tipo_id){
									 				$selected='selected="selected"';
									 			}
									 		}
								 			?>
											<option value="<?=$vextension->proyecto_valor_oferta_extension_tipo_id?>" <?=$selected?>><?=$vextension->proyecto_valor_oferta_extension_tipo?></option>
								<?php 	}
									}
								?>
							</select>
							<small id="tipoextensionHelp" class="form-text text-muted">Indique el distrito donde se ubica el proyecto.<br/>
							</small>
						</div>
	        		</div>
	        		<div class="col-12 col-md-6">
	        			<div class="form-group">
							<label for="valor_oferta">Monto de la extension ($):</label>							
							<input type="text" name="valor_oferta" class="form-control input-money-mask " id="valor_oferta" value="<?=(isset($proyecto_extension->valor_oferta))?$proyecto_extension->valor_oferta:''?>" aria-describedby="valorExtensionHelp" >
							<small id="valorExtensionHelp" class="form-text text-muted">Ingrese el valor de la extensión.<br/>
							</small>
						</div>
	        		</div>
	        	</div>
	        	<div class="row">
	        		<div class="col-12">
	        			<div class="form-group">
							<label for="proyecto_valor_oferta_extension_descripcion">Descripción de la extensión:</label>
							<textarea class="form-control" name="proyecto_valor_oferta_extension_descripcion" id="proyecto_valor_oferta_extension_descripcion" rows="3" aria-describedby="descripcionHelp"><?=(isset($proyecto_extension->proyecto_valor_oferta_extension_descripcion))?$proyecto_extension->proyecto_valor_oferta_extension_descripcion:''?></textarea>
							<small id="descripcionHelp" class="form-text text-muted">Ingrese la descripción detallada de la extensión.<br/>
							</small>
							
						</div>
	        		</div>	        		
	        	</div>
	        </div>
	    </div>
		<button type="submit" class="btn btn-primary form-submit"><i class="fa fa-fw fa-save"></i> Guardar</button>
	</form>
</div>
