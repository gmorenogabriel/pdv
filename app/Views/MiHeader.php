<?php
$user_session = session();
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />-->
        <title>PDV - SB Admin</title>

        <!-- Personalizacion para DataTables ocupe menos espacio por renglon -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/custom.css" />        

         <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo base_url();?>font-awesome/css/font-awesome.min.css">

        <link href="<?php echo base_url(); ?>css/styles.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>css/dataTables.bootstrap4.min.css" rel="stylesheet" />
        
        <!-- Mi personalizacion de paneles -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/mis.css" media="screen" />
  
    </head>
        <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="<?php echo base_url(); ?>/inicio">PDV - GM</a>
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
            <ul class="navbar-nav ml-auto mr-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $user_session->nombre; ?><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
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
                            <div class="sb-sidenav-menu-heading">Interface</div>

                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#manejoCaja" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-shopping-basket"></i></div>
                                Caja
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="manejoCaja" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="<?php echo base_url(); ?>flujocaja"><i class="fa fa-balance-scale" aria-hidden="true"></i>&nbsp; Flujo Caja</a>
                                </nav>
                            </div>                           


                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fa fa-eye" aria-hidden="true"></i></div>
                                Productos
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="<?php echo base_url(); ?>productos"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp; Productos</a>
                                    <a class="nav-link" href="<?php echo base_url(); ?>unidades">Unidades</a>
                                    <a class="nav-link" href="<?php echo base_url(); ?>categorias">Categorías</a>
                                </nav>
                            </div>                           
                            

                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#manejoClientes" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Clientes
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="manejoClientes" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="<?php echo base_url(); ?>clientes"><i class="fa fa-user" aria-hidden="true"></i>&nbsp; Clientes</a>
                                </nav>
                            </div>                           
                            <!-- <a class="nav-link" href="<?php echo base_url(); ?>/clientes"><div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>Clientes</a> -->

                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#menuCompras" aria-expanded="false" aria-controls="menuCompras">
                            <div class="sb-nav-link-icon"><i class="fas fa-cash-register"></i></div>
                                Compras
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="menuCompras" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="<?php echo base_url(); ?>compras/nuevo">Nueva compra</a>
                                    <a class="nav-link" href="<?php echo base_url(); ?>compras">Compras</a>
                                </nav>
                            </div>                           
<!-- ------------------------------------------------------------------   -->                                                            
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#menuReportes" aria-expanded="false" aria-controls="menuReportes">
                            <div class="sb-nav-link-icon"><i class="fas fa-print"></i></i></div>
                                Reportes
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="menuReportes" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="<?php echo base_url(); ?>datatables"><i class="fas fa-users"></i>&nbsp; Usuarios</a>
                                </nav>
                            </div>                           

                            <div class="sb-sidenav-menu-heading">Configuración</div>
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Administración
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="<?php echo base_url(); ?>configuracion"><i class="fas fa-fw fa-wrench"></i>&nbsp; Configuración</a>
                                    <a class="nav-link" href="<?php echo base_url(); ?>monedas"><i class="fas fa-coins"></i>&nbsp; Monedas</a>
                                    <a class="nav-link" href="<?php echo base_url(); ?>usuarios/nuevo"><i class="fas fa-user"></i>&nbsp; Usuarios</a>
                                    <a class="nav-link" href="<?php echo base_url(); ?>menus"><i class="fas fa-user"></i>&nbsp; Menus</a>
                                    <a class="nav-link" href="<?php echo base_url(); ?>roles"><i class="fas fa-user"></i>&nbsp; Roles</a>
                                    <a class="nav-link" href="<?php echo base_url(); ?>permisos"><i class="fas fa-user"></i>&nbsp; Permisos</a>
                                </nav>
                            </div>

                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Start Bootstrap
                    </div>
                </nav>
            </div>
			