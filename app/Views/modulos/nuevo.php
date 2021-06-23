<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <?php if (isset($validation)) { ?>
                <div class="alert alert-danger">
                    <?php echo $validation->listErrors(); ?>
                </div>
            <?php } ?>
            <form method="POST" action="<?php echo base_url(); ?>/modulos/insertar" autocomplete="off">
                <div class="card shadow-lg border-1 rounded-lg mt-3">
                    <div style="background: linear-gradient(90deg, #6484a5, #22a7bf);">
                        <h3 style="font-weight: bold;font-size:22px;" class="text-center my-4"><?php echo $titulo; ?></h3>
                    </div>
                    <div style="background: linear-gradient(90deg, #b2b8bc, #dbddde);" class="card-body">
                        <div class="form-group col-12">
                            <div class="row">
                                <div class="col-12 col-sm-4">
                                    <label>Nombre</label>
                                    <input class="form-control" id="nombre" name="nombre" type="text" value="<?php echo set_value('nombre') ?>" autofocus></>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <label>Tipo</label>
                                    <input class="form-control" id="tipo" name="tipo" type="text" value="<?php echo set_value('tipo') ?>" required></>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <label>Módulo Padre</label>
                                    <select class="form-control" id="padre" name="padre" type="text" required>
                                        <option value="">Seleccionar Módulo</option>
                                        <?php foreach ($modulos as $row) { ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-sm-4">
                                    <label>Ruta</label>
                                    <input class="form-control" id="codigo" name="codigo" type="text" value="<?php echo set_value('codigo') ?>" ></>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <label>Icono</label>
                                    <input class="form-control" id="icon" name="icon" type="text" value="<?php echo set_value('icon') ?>" required></>
                                </div>
                                <div class="col-12 col-sm-4">
  
                                    <label>Id Target</label>
                                    <input class="form-control" id="aplicacion" name="aplicacion" type="text" value="<?php echo set_value('aplicacion') ?>" required></>
                              
                                </div>
                            </div>


                        </div>
                        <a href="<?php echo base_url(); ?>/modulos" class="btn btn-primary">Regresar</a>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </div>
            </form>

        </div>
    </main>