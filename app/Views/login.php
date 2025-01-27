<?php
$user_session = session();
if($user_session == null){
    return redirect()->to(base_url());
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>PDV - Login</title>
        
        <link href="<?php echo base_url(); ?>/css/styles.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
     <!--   <script src="<?php echo base_url(); ?>/js/all.min.js"></script> -->
        <style>
        .verticalhorizontal {
            margin: 10px auto 20px;
            display: block;
        }
</style>        
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header"><h3 class="text-center font-weight-light my-4">
                                <div class="verticalhorizontal">
                                        <img src="<?= base_url().'/images/logo.png'; ?>" alt="centered image"/>
                                    </div>
    
                                Iniciar Sesión</h3>
                                    </div>
                                    <div class="card-body">
                                    <!-- agregarmos mas controles -->
                                        <form method="POST" action="<?php echo base_url(); ?>usuarios/valida"> 
                                            <div class="form-group">
                                                <label class="small mb-1" for="usuario">Usuario</label>
                                                <input class="form-control py-4" 
                                                              id="usuario" name="usuario" 
                                                              type="text"
                                                              placeholder="Ingrese nombre usuario" 
                                                              autofocus="true" 
                                                              />
                                                              
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="password">Contraseña</label>
                                                <input class="form-control py-4" id="password" name="password" 
                                                type="password" placeholder="Ingrese su contraseña" />
                                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>

                                            </div>
                                            <!-- <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" id="rememberPasswordCheck" type="checkbox" />
                                                    <label class="custom-control-label" for="rememberPasswordCheck">Remember password</label>
                                                </div>
                                            </div>
-->
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <button class="btn btn-primary" type="submit">Login</button>
                                            </div> 

                                            <?php if(isset($validation)){ ?>
                                                <div class="alert alert-danger">
                                                    <?php echo $validation->listErrors(); ?>
                                                </div>
                                            <?php } ?>
<!-- var_dump($error); die(); ?> -->
                                            <?php if(isset($error)){ ?>
                                                <div class="alert alert-danger">
                                                <?php echo $error; ?>
                                                </div>
                                            <?php } ?>

                                        </form>
                                    </div>
<!--
                                    <div class="card-footer text-center">
                                        <div class="small"><a href="register.html">Need an account? Sign up!</a></div>
                                    </div>
-->
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Mis Puntos de Venta <?php echo date('Y'); ?></div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <!-- <script src="<?php echo base_url(); ?>js/jquery-3.5.1.slim.min.js"></script> -->
        <script src="<?php echo base_url(); ?>js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo base_url(); ?>js/scripts.js"></script>
        <!-- <script src="<?php echo base_url(); ?>js/Chart.js"></script>		 -->

		<!-- 
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
		<script src="js/scripts.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
		<script src="assets/demo/chart-area-demo.js"></script>
		<script src="assets/demo/chart-bar-demo.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
		<script src="js/datatables-simple-demo.js"></script>
		-->
	
    </body>
	
</html>