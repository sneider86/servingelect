<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>SERVINGELECT S.A.S</title>
    <link href="<?php echo base_url(); ?>/css/styles.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <script src="<?php echo base_url(); ?>/js/all.min.js"></script>
    <link rel="shortcut icon" href="<?php echo base_url(); ?>/image/logo.jpg">
    <script src="<?php echo base_url(); ?>/js/jquery-3.6.0.js"></script>
    <script src="<?php echo base_url(); ?>/js/jquery-ui/external/jquery/jquery.js"></script>
    <script src="<?php echo base_url(); ?>/js/jquery-ui/jquery-ui.min.js"></script>
</head>

<body style="background-image: url(<?php echo base_url(); ?>/image/logo.jpg); background-repeat: no-repeat;background-attachment: fixed;background-size: 100% 100%;" class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div style="background: linear-gradient(90deg, #6484a5, #22a7bf);" class="card-header">
                                    <h3 style="font-weight: bold;" class="text-center my-4">Iniciar Sesión</h3>
                                </div>
                                
                                <div class="card-body">
                                    <form method="post" action="<?php echo base_url(); ?>/usuarios/valida">
                                        <div class="form-group">
                                            <label class="small mb-1" for="usuario">Usuario</label>
                                            <input class="form-control py-4" id="usuario" name="usuario" type="text" placeholder="Ingresa tu Usuario" />
                                        </div>
                                        <div class="form-group">
                                            <label class="small mb-1" for="password">Contraseña</label>
                                            <input class="form-control py-4" id="password" name="password" type="password" placeholder="Ingresa la Contraseña" />
                                        </div>
                                        <div class="form-group" d-flex align-items-center justify-content-between mt-4 mb-0>
                                            <div class="custom-control custom-checkbox">
                                                <button class="btn btn-primary" type="submit">Ingresar</button>
                                            </div>
                                        </div>
                                        <?php if (isset($validation)) { ?>
                                            <div class="alert alert-danger">
                                                <?php echo $validation->listErrors(); ?>
                                            </div>
                                        <?php } ?>
                                        <!--con este php mostramos los errores que se presenten en caso que el usuario no exista. Pero se imprime como variable $error -->
                                        <?php if (isset($error)) { ?>
                                            <div class="alert alert-danger">
                                                <?php echo $error; ?>
                                            </div>
                                        <?php } ?>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="<?php echo base_url(); ?>/js/jquery-3.5.1.slim.min.js"></script>
    <script src="<?php echo base_url(); ?>/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>/js/scripts.js"></script>
</body>

</html>