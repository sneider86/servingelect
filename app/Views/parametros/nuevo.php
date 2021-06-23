<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <?php if (isset($validation)) { ?>
                <div class="alert alert-danger">
                    <?php echo $validation->listErrors(); ?>
                </div>
            <?php } ?>
            <form method="POST" action="<?php echo base_url(); ?>/parametros/insertar" autocomplete="off">
            <div class="card shadow-lg border-1 rounded-lg mt-3">
                    <div style="background: linear-gradient(90deg, #6484a5, #22a7bf);">
                        <h3 style="font-weight: bold;font-size:22px;" class="text-center my-4"><?php echo $titulo; ?></h3>
                    </div>
                    <div style="background: linear-gradient(90deg, #b2b8bc, #dbddde);" class="card-body">
                        <div class="col-12 col-sm-12">
                            <label>Descripción del Parámetro</label>
                            <input class="form-control form-control-sm" id="descripcion" name="descripcion" type="text" value="<?php echo set_value('descripcion') ?>" autofocus ></>
                        </div>
                    </div>
                </div>
                <br />
                <a href="<?php echo base_url(); ?>/parametros/" class="btn btn-primary">Regresar</a>
                <button type="submit" class="btn btn-success">Guardar</button>
            </form>

        </div>
    </main>