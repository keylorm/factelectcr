<?php if($loggedin){ ?>
<!-- Navigation-->

	<nav class="navbar navbar-inverse" role="navigation">
	    <div class="container-fluid">
	        <div class="navbar-header">
	            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#ip-navbar-collapse">
	                <span class="sr-only">Toggle navigation</span>
	                Menú &nbsp; <i class="fa fa-bars"></i>
	            </button>
	        </div>

	        <div class="collapse navbar-collapse" id="ip-navbar-collapse">
	            <ul class="nav navbar-nav d-block">
	                <li><a href="/" class="hidden-md">Inicio</a>
	                    <a href="/" class="visible-md-inline-block"><i class="fa fa-dashboard"></i></a>
	                </li>

	                <li class="dropdown">
	                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
	                        
	                        <span class="hidden-md">Clientes</span>
	                        <i class="visible-md-inline fa fa-users"></i>
	                    </a>
	                    <ul class="dropdown-menu position-absolute">
	                        <li><a href="/clientes/agregar-cliente">Agregar cliente</a></li>
	                        <li><a href="/clientes/">Ver clientes</a></li>
	                    </ul>
	                </li>

	                <li class="dropdown">
	                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
	                        
	                        <span class="hidden-md">Facturas</span>
	                        <i class="visible-md-inline fa fa-file-text"></i>
	                    </a>
	                    <ul class="dropdown-menu position-absolute">
	                        <li><a href="/facturas/agregar-factura" class="create-invoice">Crear factura</a></li>
	                        <li><a href="/facturas">Ver facturas</a></li>
	                    </ul>
	                </li>
              

	                <li class="dropdown">
	                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
	                        
	                        <span class="hidden-md">Productos</span>
	                        <i class="visible-md-inline fa fa-database"></i>
	                    </a>
	                    <ul class="dropdown-menu position-absolute">
	                        <li><a href="/productos/agregar-producto">Agregar producto</a></li>
	                        <li><a href="/productos/">Ver productos</a></li>
	                    </ul>
	                </li>

	                <li class="dropdown">
	                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
	                        
	                        <span class="hidden-md">Reportes</span>
	                        <i class="visible-md-inline fa fa-bar-chart"></i>
	                    </a>
	                    <ul class="dropdown-menu position-absolute">
	                        <li><a href="/reportes/listado-facturas/">Reporte de facturas</a></li>
	                        <li><a href="/reportes/ventas-por-cliente/">Ventas por cliente</a></li>
	                        <li><a href="/reportes/ventas-por-ano/">Ventas por año</a></li>
	                        <li><a href="/reportes/ventas-por-mes/">Ventas por mes</a></li>
	                    </ul>
	                </li>

	            </ul>

	           

	            <ul class="nav navbar-nav navbar-right d-block">
	                

	                <li class="dropdown">
	                    <a href="#" class="tip icon dropdown-toggle" data-toggle="dropdown"
	                       title="Configuración"
	                       data-placement="bottom">
	                        <i class="fa fa-cogs"></i>
	                        <span class="visible-xs">&nbsp;Configuración</span>
	                    </a>
	                    <ul class="dropdown-menu position-absolute">
	                        <li><a href="/configuracion/empresas/">Gestionar empresas</a></li>	                        
	                        <li><a href="/configuracion/usuarios/">Gestionar usuarios</a></li>
	                        
	                    </ul>
	                </li>
	                <li>
	                    <a href="<?php echo site_url('/usuarios/editar-perfil'); ?>"
	                       class="tip icon" data-placement="bottom"
	                       title="">
	                        <i class="fa fa-user"></i>
	                        <span class="visible-xs">&nbsp;
	                           Perfil</span>
	                    </a>
	                </li>
	                <li>
	                    <a href="<?php echo site_url('/logout'); ?>"
	                       class="tip icon logout" data-placement="bottom"
	                       title="Cerrar sesión">
	                        <i class="fa fa-power-off"></i>
	                        <span class="visible-xs">&nbsp; Cerrar sesión</span>
	                    </a>
	                </li>
	            </ul>
	        </div>
	    </div>
	</nav>
<?php } ?>