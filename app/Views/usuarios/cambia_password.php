<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h5 class="mt-4"><?php echo $titulo; ?></h>
                <?php if (isset($validation)) { ?>
                    <div class="alert alert-danger">
                        <?php echo $validation->listErrors(); ?>
                    </div>
                <?php } ?>

                <form method="post" action="<?php echo base_url(); ?>/usuarios/actualizar_password" autocomplete="off">

                    <div class="form-group col-12">
                        <!-- Agregar las filas y mostrar los campos -->
                        <div class="row">
                            <!-- Grupos de elementos que se agregan en el form por filas -->
                            <!--  la fila -->
                            <div class="col-12 col-sm-6">
                                <!--  el ancho de la columna col-12 para pc y que abarque toda la pantalla y col-6 para moviles t barcara 6 columnas? -->
                                <label>Usuario</label>
                                <input class="form-control" id="usuario" name="usuario" type="text" value="<?php echo $usuario['usuario']; ?> " disabled></>
                            </div>
                            <div class="col-12 col-sm-6">
                                <!--  el ancho de la columna col-12 para pc y que abarque toda la pantalla y col-6 para moviles t barcara 6 columnas? -->
                                <label>Nombre</label>
                                <input class="form-control" id="nombre" name="nombre" type="text" value="<?php echo $usuario['nombre']; ?> " disabled></>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-12">
                        <!-- Agregar las filas y mostrar los campos -->
                        <div class="row">
                            <!-- Grupos de elementos que se agregan en el form por filas -->
                            <!--  la fila -->
                            <div class="col-12 col-sm-6">
                                <!--  el ancho de la columna col-12 para pc y que abarque toda la pantalla y col-6 para moviles t barcara 6 columnas? -->
                                <label>Contraseña</label>
                                <input class="form-control" id="password" name="password" type="password" value="" required></>
                            </div>
                            <div class="col-12 col-sm-6">
                                <!--  el ancho de la columna col-12 para pc y que abarque toda la pantalla y col-6 para moviles t barcara 6 columnas? -->
                                <label>Confirma Contraseña</label>
                                <input class="form-control" id="rpassword" name="rpassword" type="password" value="" required></>
                            </div>
                        </div>
                    </div>                    

                    <a href="<?php echo base_url(); ?>/usuarios" class="btn btn-primary">Regresar</a>
                    <button type="submit" class="btn btn-success">Actualizar</button>
                    <?php if (isset($mensaje)) { ?>
                    <div class="alert alert-success">
                        <?php echo $mensaje; ?>
                    </div>
                <?php } ?>
                </form>

        </div>
    </main>