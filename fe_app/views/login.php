<div class="row">
	<div class="col-12 col-md-3 col-lg-4 "></div>
	<div class="col-12 col-md-6 col-lg-4">
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
		<div class="login-container">
			<h1 class="text-center">Bienvenido</h1>
			<form action="" method="post">
				<div class="form-group">
					<label for="usuario">Usuario</label>
					<input type="text" class="form-control" id="usuario" name="usuario" placeholder="">
				</div>
				<div class="form-group">
					<label for="password">Contraseña</label>
					<input type="password" class="form-control" id="password" name="password" placeholder="">
				</div>

				<button type="submit" class="btn btn-primary">Ingresar</button>
			</form>
		</div>
	</div>
	<div class="col-12 col-md-3 col-lg-4 "></div>
</div>