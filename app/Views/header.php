<?php
$user_session = session();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>PDV - SB Admin</title>
		<link href="<?php echo base_url(); ?>css/style.min.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url();?>css/styles.css" rel="stylesheet" />
<!--		<script src="<?php echo base_url(); ?>font-awesome/css/font-awesome.all.min.css" rel="stylesheet">></script> -->
		
   <!-- CSS de Bootstrap
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS 
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- Font Awesome 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
<!-- Bootstrap CSS -->
<link href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- FontAwesome (opcional, para íconos) -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<!-- SB Admin 2 CSS -->
<link href="path/to/sb-admin-2.min.css" rel="stylesheet">

	<!-- Mensages Personalizados 
	<script src="<?php echo base_url(); ?>js/sweetalert2.all.min.js" crossorigin="anonymous"></script>
	-->
	<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	
    <!-- Estilos personalizados -->
    <link href="<?php echo base_url(); ?>css/styles.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>css/style.min.css" rel="stylesheet" />
</head>
        <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="<?php echo base_url(); ?>inicio">PDV - GM</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
             Navbar-->
            <ul class="navbar-nav ms-auto"> <!-- mr-md-3 my-2 my-md-0"> -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $user_session->nombre; ?><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="<?php echo base_url(); ?>usuarios/cambia_password"><i class="fa fa-key" style="color: #339af0;"></i> Cambiar Contraseña</a>
                        <a class="dropdown-item" href="#">Activity Log</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo base_url(); ?>usuarios/logout"><i class="fas fa-sign-out-alt" style="color: #845ef7;"></i> Cerrar Sesión</a>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
<!--
                        <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="index.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
-->                            
                           <!-- 1er DIVISION SideBar Caja-->
                            <div class="sb-sidenav-menu-heading">Interface</div>
							<a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#menuCaja" aria-expanded="false" aria-controls="menuCaja">
                            <div class="sb-nav-link-icon"><i class="fas fa-shopping-basket"></i></div>
                                Caja
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                             <!-- ITEM dentro de Caja -->
                            <div class="collapse" id="menuCaja" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="<?php echo base_url(); ?>flujocaja"><i class="fa fa-balance-scale" aria-hidden="true"></i>&nbsp; Flujo Caja</a>
                                </nav>
                            </div>							

                          <!-- 2da DIVISION SideBar Productos-->
							<a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#menuProductos" aria-expanded="false" aria-controls="menuProductos">
                            <div class="sb-nav-link-icon"><i class="fa-brands fa-product-hunt"></i></div>
							Productos
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                             <!-- ITEM dentro de Productos -->
                            <div class="collapse" id="menuProductos" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
									<a class="nav-link" href="<?php echo base_url(); ?>productos"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp; Productos</a>
                                    <a class="nav-link" href="<?php echo base_url(); ?>unidades"><i class="fa-brands fa-unity" aria-hidden="true"></i>&nbsp; Unidades</a>
                                    <a class="nav-link" href="<?php echo base_url(); ?>categorias"><i class="fa-solid fa-layer-group"></i>&nbsp; Categorías</a>
                                </nav>
                            </div>							                      

                          <!-- 3era DIVISION SideBar Clientes-->
							<a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#menuClientes" aria-expanded="false" aria-controls="menuClientes">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Clientes
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                             <!-- ITEM dentro de Clientes -->
                            <div class="collapse" id="menuClientes" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
									<a class="nav-link" href="<?php echo base_url(); ?>compras/nuevo"><i class="fa fa-cash-register" aria-hidden="true"></i>&nbsp; Nueva Compra</a>
                                    <a class="nav-link" href="<?php echo base_url(); ?>compras"><i class="fa-solid fa-basket-shopping"></i></i>&nbsp; Compras</a>
                                </nav>
                            </div>							                      
                       
					   <!-- 4ta DIVISION SideBar Reportes-->
							<a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#menuReportes" aria-expanded="false" aria-controls="menuReportes">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-print"></i></div>
                                Reportes
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                             <!-- ITEM dentro de Clientes -->
                            <div class="collapse" id="menuReportes" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="<?php echo base_url(); ?>datatables"><i class="fas fa-users"></i>&nbsp; Usuarios</a
                                </nav>
                            </div>							                      

                      
					   <!-- 5ta DIVISION SideBar Configuracion-->
					        <div class="sb-sidenav-menu-heading">Configuración</div>
							<a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#menuAdmin" aria-expanded="false" aria-controls="menuAdmin">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Administración
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                             <!-- ITEM dentro de Configuracion -->
                            <div class="collapse" id="menuAdmin" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="<?php echo base_url(); ?>configuracion"><i class="fas fa-fw fa-wrench"></i>&nbsp; Configuración</a>
                                    <a class="nav-link" href="<?php echo base_url(); ?>monedas"><i class="fas fa-coins"></i>&nbsp; Monedas</a>
                                    <a class="nav-link" href="<?php echo base_url(); ?>usuarios"><i class="fas fa-user"></i>&nbsp; Usuarios</a>
                                    <a class="nav-link" href="<?php echo base_url(); ?>menus"><i class="fa-solid fa-cubes-stacked"></i>&nbsp; Menus</a>
                                    <a class="nav-link" href="<?php echo base_url(); ?>roles"><i class="fa-regular fa-face-rolling-eyes"></i>&nbsp; Roles</a>
                                    <a class="nav-link" href="<?php echo base_url(); ?>permisos"><i class="fa-solid fa-thumbs-up"></i>&nbsp; Permisos</a>									
                                </nav>
                            </div>		
    
<!-- ------------------------------------------------------------------   -->                                                            
                    

                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Start Bootstrap
                    </div>
                </nav>
            </div>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>