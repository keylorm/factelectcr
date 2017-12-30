<!-- Breadcrumbs-->
<ol class="breadcrumb">
	<li class="breadcrumb-item">
	  <a href="/">Inicio</a>
	</li>
	<li class="breadcrumb-item">
	  <a href="/proveedores">Proveedores</a>
	</li>
	<li class="breadcrumb-item active">Ver proveedor</li>
</ol>
<h1  class="text-center"><i class="fa fa-fw fa-handshake-o"></i> Proveedores</h1>
<hr>

<div class="page-content">
	<div class="row">
		<div class="col-12 col-md-10"><h3 class=" text-center text-md-left"><i class="fa fa-fw fa-eye"></i> Ver proveedor</h3></div>
		<div class="col-12 col-md-2"><a class="btn btn-primary float-md-right mb-3 mr-md-3 mx-auto d-block d-md-inline-block" href="/proveedores/editar-proveedor/<?=$proveedor->proveedor_id?>" role="button"><i class="fa fa-fw fa-edit"></i> Editar proveedor</a></div>
	</div>
	<div class="card mb-3">
        <div class="card-header">
          	<i class="fa fa-shopping-bag"></i> Información del proveedor</div>
        <div class="card-body">
          	<p><span class="font-weight-bold">Nombre de proveedor:</span> 
			<?=(isset($proveedor->nombre_proveedor))?$proveedor->nombre_proveedor:''?></p>
			
			<p><span class="font-weight-bold">Cédula del proveedor:</span> 
			<?=(isset($proveedor->cedula_proveedor))?$proveedor->cedula_proveedor:''?></p>
			
		    
		    <?php if(isset($proveedor_correo)){ ?> 
		   		<p><span class="font-weight-bold">Correos de contacto:</span> <br />
				<?php foreach($proveedor_correo as $kcorreo => $vcorreo){ ?>
					<a href="mailto:<?=$vcorreo->correo_proveedor?>"><?=$vcorreo->correo_proveedor?></a> <br />		       
				<?php	
				} ?>
				</p>
		    <?php } ?>



		    <?php if(isset($proveedor_telefono)){ ?>
		    	<p><span class="font-weight-bold">Teléfonos de contacto:</span> <br />
				<?php foreach($proveedor_telefono as $ktelefono => $vtelefono){ ?>
					<a href="mailto:<?=$vtelefono->telefono_proveedor?>"><?=$vtelefono->telefono_proveedor?></a> <br />
				       
				<?php	
				} ?>
				</p>
		    <?php } ?>



		    <p><span class="font-weight-bold">Estado del proveedor:</span> 
			<?=(isset($proveedor->estado_proveedor) && $proveedor->estado_proveedor==1)?'Activo':'Inactivo'?></p>
        </div>
        
    </div>
	
	
				
	
</div>