<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <?php if (isset($validation)) { ?>
                <div class="alert alert-danger">
                    <?php echo $validation->listErrors(); ?>
                </div>
            <?php } ?>
            <form method="POST" action="<?php echo base_url(); ?>/actividades/inserta_actividad" autocomplete="off">
                <div class="card shadow-lg border-1 rounded-lg mt-3">
                    <div style="background: linear-gradient(90deg, #6484a5, #22a7bf);">
                        <h3 style="font-weight: bold;font-size:22px;" class="text-center my-4"><?php echo $titulo; ?></h3>
                    </div>
                    <div style="background: linear-gradient(90deg, #b2b8bc, #dbddde);" class="card-body">
                        <div class="form-group col-12">
                            <div class="row">
                            <label>Grupo</label>
                            <select class="form-control form-control-sm" id="id_grupo" name="id_grupo" type="text" autofocus required>
                                <option value="">Seleccionar Grupo</option>
                                <?php foreach ($grupos as $row) { ?>
                                    <option value="<?php echo $row['codigo']; ?>"><?php echo $row['nombre']; ?></option>
                                <?php } ?>

                            </select>                                
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-3">
                                    <label>Código de la Actividad</label>
                                    <input class="form-control form-control-sm" id="codigo" name="codigo" type="text" required></>
                                </div>

                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-12">
                                    <label>Nombre de la Actividad</label>
                                    <input class="form-control" id="nombre" name="nombre" type="text" required></>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <a href="<?php echo base_url(); ?>/actividades/" class="btn btn-primary">Regresar</a>
                <button type="submit" class="btn btn-success">Guardar</button>
            </form>
        </div>
    </main>