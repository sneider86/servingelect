<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">

                <?php if (isset($validation)) { ?>
                    <div class="alert alert-danger">
                        <?php echo $validation->listErrors(); ?>
                    </div>
                <?php } ?>
                <form method="post" action="<?php echo base_url(); ?>/parametros/actualizar" autocomplete="off">
                    <input type="hidden" name="id" value="<?php echo $datos['id']; ?>" />
                    <div class="card shadow-lg border-1 rounded-lg mt-3">
                        <div style="background: linear-gradient(90deg, #6484a5, #22a7bf);">
                            <h3 style="font-weight: bold;font-size:22px;" class="text-center my-4"><?php echo $titulo; ?></h3>
                        </div>
                        <div style="background: linear-gradient(90deg, #b2b8bc, #dbddde);" class="card-body">
                            <div class="col-12 col-sm-12">
                                <!--  el ancho de la columna col-12 para pc y que abarque toda la pantalla y col-6 para moviles t barcara 6 columnas? -->
                                <label>Descripción del Parámetro</label>
                                <input class="form-control form-control-sm" id="descripcion" name="descripcion" type="text" value="<?php echo $datos['descripcion']; ?> " autofocus required></>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <a href="<?php echo base_url(); ?>/parametros" class="btn btn-primary">Regresar</a>
                    <button type="submit" class="btn btn-success">Actualizar</button>
                </form>
        </div>
    </main>