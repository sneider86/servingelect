<?php
// definimos una variable de sesion para obtener los datos de mi sesion y mostrar el nombre del usuario al lado del icono de
$user_session = session();
$password = $user_session->password;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <link href="<?php echo base_url(); ?>/css/styles.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/css/jquery-ui-1.9.2.custom.css" rel="stylesheet" />
    <script src="<?php echo base_url(); ?>/js/sweetalert.min.js"></script>
    <link href="<?php echo base_url(); ?>/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
    <script src="<?php echo base_url(); ?>/js/all.min.js"></script>
    <script src="<?php echo base_url(); ?>/js/jquery-ui-1.9.2.custom.js"></script>
    <script src="<?php echo base_url(); ?>/js/jquery-3.6.0.js"></script>
    <script src="<?php echo base_url(); ?>/js/jquery-ui/external/jquery/jquery.js"></script>
    <script src="<?php echo base_url(); ?>/js/jquery-ui/jquery-ui.min.js"></script>
    <link rel="shortcut icon" href="<?php echo base_url(); ?>/image/logo.jpg" />

    <link rel="stylesheet" type="text/css" href="http://www.prepbootstrap.com/Content/shieldui-lite/dist/css/light/all.min.css" />
    <script type="text/javascript" src="http://www.prepbootstrap.com/Content/shieldui-lite/dist/js/shieldui-lite-all.min.js"></script>

    <script type="text/javascript" src="http://www.prepbootstrap.com/Content/data/shortGridData.js"></script>

</head>

<body style="background: linear-gradient(90deg, #eaedf0, #eaedf0);" class="sb-nav-fixed">
    <nav style="background: linear-gradient(90deg, #a4b5c6, #0356a8);" class="sb-topnav navbar navbar-expand navbar-dark bg-dark">

        <img style="margin:0.5em; width:45px; height:45px;" src="<?php echo base_url(); ?>/image/logo.jpg"></img>
        <a class="navbar-brand" href="index.html">SERVINGELECT S.A.S</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <!-- Navbar-->
        <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $user_session->nombres; ?> <i class="fas fa-user fa-fw"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalCambiaPassword">Cambiar Contraseña</a>
                    <!--<a class="dropdown-item" href="#">Log de Actividad</a>-->
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?php echo base_url(); ?>/usuarios/logout">Cerrar Sesión</a>
                </div>
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <!--#0356a8, #0356a8-->
            <nav style="background: linear-gradient(90deg, #0356a8, #a4b5c6);" class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    </br>
                    <div class="nav">
                        <div style="color:#eaedf0;text-align:center;font-weight: 600;font-family: cursive;font-size: 20px;">Menú del Sistema</div>
                    </div>
                    </br>
                    <div class="nav">
                        <?php foreach ($modulos as $dato) { ?>
                            <?php if ($dato['tipo'] == "Carpeta") {
                                $padre = $dato['padre_id']; ?>
                                <a class="nav-link collapsed form-control-sm" href="#" data-toggle="collapse" data-target="#<?php echo $dato['aplicacion']; ?>" aria-expanded="false" aria-controls="collapseLayouts">
                                    <div class="sb-nav-link-icon"><i style="color:yellow;" class="<?php echo $dato['icon']; ?> "></i></div>
                                    <?php echo $dato['nombre']; ?>
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                            <?php } else ?>
                            <?php { ?>
                                <?php if ($dato['padre_id'] == $padre && $dato['tipo'] == "Modulo") { ?>
                                    <div class="collapse" id="<?php echo $dato['aplicacion']; ?>" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link form-control-sm" href="<?php echo base_url(); ?><?php echo $dato['codigo']; ?>"><i style="color:#88f051;" class="<?php echo $dato['icon']; ?>"></i><?php echo $dato['nombre']; ?></a>
                                        </nav>
                                    </div>
                                    </a>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>

                    </div>
                </div>
            </nav>
        </div>

        <!-- Modal Nuevo Usuario-->
        <div width="50%" class="modal fade" id="modalCambiaPassword" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <form method="post" action="<?php echo base_url(); ?>/usuarios/cambiaClave" class="form-block" enctype="multipart/form-data">
                <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                    <div style="background: linear-gradient(90deg, #b4c1d9, #b4c1d9);" class="modal-content">
                        <div class="modal-header">
                            <h5 style="color:#98040a;font-size:20px;font-weight:bold;" class="modal-title" id="exampleModalLabel">Cambiar Contraseña</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div id="id_modal" class="modal-body">
                            <div style="background: linear-gradient(90deg, #b2b8bc, #dbddde);" class="card-body">
                                <div class="form-group col-12">
                                    <div class="row">
                                        <input hidden id="id" name="id" type="text" value="<?php echo $user_session->id_usuario; ?>"></>
                                        <div class="col-12 col-sm-6">
                                            <label>Usuario</label>
                                            <input disabled class="form-control form-control-sm" id="c_usuario" name="c_usuario" type="text" value="<?php echo $user_session->usuario; ?>" autofocus></>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <label>Nombres y Apellidos</label>
                                            <input disabled class="form-control form-control-sm" id="c_nombres" name="c_nombres" type="text" value="<?php echo $user_session->nombres; ?>"></>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-6">
                                            <label>Contraseña Anterior</label>
                                            <input class="form-control form-control-sm" id="password_Anterior" name="password_Anterior" type="password" onblur="verificaAnterior()"></>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-6">
                                            <label>Nueva Contraseña</label>
                                            <input disabled class="form-control form-control-sm" id="password_nuevo" name="password_nuevo" type="password" value=""></>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <label>Repetir Contraseña</label>
                                            <input disabled class="form-control form-control-sm" id="repite_password" name="repite_password" type="password" onblur="verificaNueva()"></>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a id="btn_cerrarModal" class="btn btn-primary form-control-sm" >Regresar</a>
                            <button disabled id="btn_cambiar" type="submit" class="btn btn-success form-control-sm">Cambiar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
</body>
<script>
    function verificaAnterior() {
        var clave = document.getElementById('password_Anterior').value;
        var id = document.getElementById('id').value;
        $.ajax({
            type: "PATH",
            url: "<?php echo base_url(); ?>/usuarios/verificaUsuario/" + id + '/' + clave,
            dataType: "json",
            success: function(r) {
                if (r != 'ok') {
                    swal('', 'Contraseña no Valida. Corrija', 'error');
                    $('#password_Anterior').val('');
                    $('#password_Anterior').focus();
                } else {
                    $('#password_nuevo').removeAttr('disabled');
                    $('#repite_password').removeAttr('disabled');
                    $('#password_nuevo').focus();
                }
            },
            error: function() {
                console.log("No se ha podido obtener la Información");
            }
        })
    };

    function verificaNueva() {
        var clave_nueva = document.getElementById('password_nuevo').value;
        var clave_rnueva = document.getElementById('repite_password').value;
        if (clave_nueva != clave_rnueva) {
            swal('', 'Contraseñas no Coinciden. Corrija', 'error');
            $('#password_nuevo').val('');
            $('#repite_password').val('');
            $('#password_nuevo').focus();
        } else {
            $('#btn_cambiar').removeAttr('disabled');
            $('#btn_cambiar').focus();
        }
    }

    $('#btn_cerrarModal').click(function() {
        $("#modalCambiaPassword .close").click();
    });

</script>
