<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">

            <?php if (isset($validation)) { ?>
                <div class="alert alert-danger">
                    <?php echo $validation->listErrors(); ?>
                </div>
            <?php } ?>

            <form method="post" action="<?php echo base_url(); ?>/acciones/actualizar" autocomplete="off">
                <input type="hidden" name="id" value="<?php echo $datos['id']; ?>" />
                <div class="card shadow-lg border-1 rounded-lg mt-3">
                    <div style="background: linear-gradient(90deg, #6484a5, #22a7bf);">
                        <h3 style="font-weight: bold;font-size:22px;" class="text-center my-4"><?php echo $titulo; ?></h3>
                    </div>
                    <div style="background: linear-gradient(90deg, #b2b8bc, #dbddde);" class="card-body">

                        <div class="form-group col-12">
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <label>Nombre</label>
                                    <input class="form-control form-control-sm" id="nombre" name="nombre" type="text" value="<?php echo $datos['nombre']; ?> " autofocus required></>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label>Módulo</label>
                                    <select class="form-control form-control-sm" id="id_modulo" name="id_modulo" type="text" required>
                                        <option value="">Seleccionar Módulo</option>
                                        <?php foreach ($modulos as $row) { ?>
                                            <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $datos['id_modulo']) {
                                                                                            echo 'selected';
                                                                                        } ?>><?php echo $row['nombre']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <br>
                        <a href="<?php echo base_url(); ?>/acciones" class="btn btn-primary">Regresar</a>
                        <button type="submit" class="btn btn-success">Actualizar</button>
                    </div>
                </div>
            </form>

        </div>
    </main>