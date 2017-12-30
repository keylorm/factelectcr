<!-- Breadcrumbs-->
<ol class="breadcrumb">
	<li class="breadcrumb-item">
	  <a href="/">Inicio</a>
	</li>
	<li class="breadcrumb-item">
	  <a href="/clientes">Clientes</a>
	</li>
	<li class="breadcrumb-item active">Ver cliente</li>
</ol>
<h1  class="text-center"><i class="fa fa-fw fa-handshake-o"></i> Clientes</h1>
<hr>

<div class="page-content">
	<div class="row">
		<div class="col-12 col-md-10"><h3 class=" text-center text-md-left"><i class="fa fa-fw fa-eye"></i> Ver cliente</h3></div>
		<div class="col-12 col-md-2"><a class="btn btn-primary float-md-right mb-3 mr-md-3 mx-auto d-block d-md-inline-block" href="/clientes/editar-cliente/<?=$cliente->cliente_id?>" role="button"><i class="fa fa-fw fa-edit"></i> Editar cliente</a></div>
	</div>
	
	<div class="card mb-3">
        <div class="card-header">
          	<i class="fa fa-handshake-o"></i> Información del cliente</div>
        <div class="card-body">
          	<p><span class="font-weight-bold">Nombre de cliente:</span> 
			<?=(isset($cliente->nombre_cliente))?$cliente->nombre_cliente:''?></p>
			
			<p><span class="font-weight-bold">Cédula del cliente:</span> 
			<?=(isset($cliente->cedula_cliente))?$cliente->cedula_cliente:''?></p>
			
		    
		    <?php if(isset($cliente_correo)){ ?> 
		   		<p><span class="font-weight-bold">Correos de contacto:</span> <br />
				<?php foreach($cliente_correo as $kcorreo => $vcorreo){ ?>
					<a href="mailto:<?=$vcorreo->correo_cliente?>"><?=$vcorreo->correo_cliente?></a> <br />		       
				<?php	
				} ?>
				</p>
		    <?php } ?>



		    <?php if(isset($cliente_telefono)){ ?>
		    	<p><span class="font-weight-bold">Teléfonos de contacto:</span> <br />
				<?php foreach($cliente_telefono as $ktelefono => $vtelefono){ ?>
					<a href="mailto:<?=$vtelefono->telefono_cliente?>"><?=$vtelefono->telefono_cliente?></a> <br />
				       
				<?php	
				} ?>
				</p>
		    <?php } ?>



		    <p><span class="font-weight-bold">Estado del cliente:</span> 
			<?=(isset($cliente->estado_cliente) && $cliente->estado_cliente==1)?'Activo':'Inactivo'?></p>
        </div>
        
    </div>
	
				
	
</div>