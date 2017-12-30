<?php if($loggedin){ ?>
<!-- Navigation-->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
		<a class="navbar-brand" href="/">Instatec CR</a>
		<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
		  <span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarResponsive">
		  <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
		    <li class="nav-item" >
		      <a class="nav-link" href="/">
		        <i class="fa fa-fw fa-dashboard"></i>
		        <span class="nav-link-text">Inicio</span>
		      </a>
		    </li>
		    <li class="nav-item" >
		      <a class="nav-link" href="/proyectos">
		        <i class="fa fa-fw fa-area-chart"></i>
		        <span class="nav-link-text">Proyectos</span>
		      </a>
		    </li>
		    <?php if(isset($rol_id) && $rol_id=='1'){ ?>
			    <li class="nav-item" >
			      <a class="nav-link" href="/clientes">
			        <i class="fa fa-fw fa-handshake-o"></i>
			        <span class="nav-link-text">Clientes</span>
			      </a>
			    </li>
			    <li class="nav-item" >
			      <a class="nav-link" href="/proveedores">
			        <i class="fa fa-fw fa-shopping-bag"></i>
			        <span class="nav-link-text">Proveedores</span>
			      </a>
			    </li>
			    <li class="nav-item" >
			      <a class="nav-link" href="/reportes">
			        <i class="fa fa-fw fa-table"></i>
			        <span class="nav-link-text">Reportes</span>
			      </a>
			    </li>
		    <?php } ?>

		  </ul>
		  <ul class="navbar-nav sidenav-toggler">
		    <li class="nav-item">
		      <a class="nav-link text-center" id="sidenavToggler">
		        <i class="fa fa-fw fa-angle-left"></i>
		      </a>
		    </li>
		  </ul>
		  <ul class="navbar-nav ml-auto">		    
		    <li class="nav-item">
		      <a class="nav-link" href="/logout">
		        <i class="fa fa-fw fa-sign-out"></i>Cerrar sesión</a>
		    </li>
		  </ul>
		</div>
	</nav>
	<!--<a class="menu-toggle icon-menu" data-toggle="collapse" href="#menu" aria-expanded="false" aria-controls="collapseExample"></a>
	<nav id="menu" class="collapse">
		<ul class="nav justify-content-center">
			<li class="nav-item"><a class="nav-link" href="/dashboard">Inicio</a></li>
			<li class="nav-item"><a class="nav-link" href="/proyectos">Proyectos</a></li>
			<?php if(isset($rol_id) && $rol_id=='1'){ ?>
				<li class="nav-item"><a class="nav-link" href="/clientes">Clientes</a></li>
				<li class="nav-item"><a class="nav-link" href="/proveedores">Proveedores</a></li>
				<li class="nav-item"><a class="nav-link" href="/reportes">Reportes</a></li>
			<?php } ?>
			<li class="nav-item"><a class="nav-link" href="/logout">Cerrar Sesión</a></li>
		</ul>
	</nav>-->

<?php } ?>