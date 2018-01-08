<div class="row">
	<div class="col-12 col-md-3  "></div>
	<div class="col-12 col-md-6 ">
		<div class="login-container" id="login">
			<h1 class="">Iniciar sesión</h1>
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
			<form action="" method="post">
				<div class="form-group">
					<label for="usuario">Correo electrónico</label>
					<input type="text" class="form-control" id="usuario" name="usuario" placeholder="">
				</div>
				<div class="form-group">
					<label for="password">Contraseña</label>
					<input type="password" class="form-control" id="password" name="password" placeholder="">
				</div>

				<button type="submit" class="btn btn-primary mb-3"><i class="fa fa-unlock fa-margin"></i> Iniciar sesión</button>
				<a href="<?php echo site_url('/recuperar-contraseña'); ?>" class="btn btn-default mb-3">
	                He olvidado mi contraseña
	            </a>
			</form>
		</div>
	</div>
	<div class="col-12 col-md-3  "></div>
</div>