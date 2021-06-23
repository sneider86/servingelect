<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <!--<h5 class="mt-4"><?php echo $titulo; ?></h>-->
            <?php if (isset($validation)) { ?>
                <div class="alert alert-danger">
                    <?php echo $validation->listErrors(); ?>
                </div>
            <?php } ?>

            <form method="post" action="<?php echo base_url(); ?>/usuarios/actualizar" autocomplete="off">
                <div class="card shadow-lg border-1 rounded-lg mt-4">
                    <div style="background: linear-gradient(90deg, #6484a5, #22a7bf);">
                        <h3 style="font-weight: bold;font-size:22px;" class="text-center my-4"><?php echo $titulo; ?></h3>
                    </div>
                    <div style="background: linear-gradient(90deg, #b2b8bc, #dbddde);" class="card-body">
                        <input type="hidden" name="id" value="<?php echo $datos['id']; ?>" />
                        <div class="form-group col-12">
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <label>Usuario</label>
                                    <input class="form-control form-control-sm" id="usuario" name="usuario" type="text" value="<?php echo $datos['usuario'] ?>" disabled></>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label>Nombres y Apellidos</label>
                                    <input class="form-control form-control-sm" id="nombres" name="nombres" type="text" value="<?php echo $datos['nombres'] ?>" autofocus></>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <label>Rol</label>
                                        <select class="form-control form-control-sm" id="id_rol" name="id_rol" type="text" required>
                                            <option value="">Seleccionar Rol</option>
                                            <?php foreach ($roles as $rol) { ?>
                                                <option value="<?php echo $rol['id']; ?>" <?php if ($rol['id'] == $datos['id_rol']) {echo 'selected';} ?>><?php echo $rol['nombre']; ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <label>Email</label>
                                        <input class="form-control form-control-sm" id="email" name="email" type="email" value="<?php echo $datos['email'] ?>"></>
                                    </div>

                                </div>
                            </div>

                            <a href="<?php echo base_url(); ?>/usuarios" class="btn btn-primary">Regresar</a>
                            <button type="submit" class="btn btn-success">Actualizar</button>
                        </div>
                    </div>
            </form>
        </div>
    </main>