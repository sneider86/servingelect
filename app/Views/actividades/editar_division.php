<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">

            <?php if (isset($validation)) { ?>
                <div class="alert alert-danger">
                    <?php echo $validation->listErrors(); ?>
                </div>
            <?php } ?>
            <form method="post" action="<?php echo base_url(); ?>/divisiones/actualizar_division" autocomplete="off">
                <input type="hidden" id="id" name="id" value="<?php echo $datos['codigo']; ?>" />                
                <div class="card shadow-lg border-1 rounded-lg mt-3">
                    <div style="background: linear-gradient(90deg, #6484a5, #22a7bf);">
                        <h3 style="font-weight: bold;font-size:22px;" class="text-center my-4"><?php echo $titulo; ?></h3>
                    </div>

                    <div style="background: linear-gradient(90deg, #b2b8bc, #dbddde);" class="card-body">
                        <div class="form-group col-12">
                            <div class="row">
                                <label>Sección</label>
                                <select disabled class="form-control form-control-sm" id="id_seccion" name="id_seccion" type="text" autofocus required>
                                    <option value=""></option>
                                    <?php foreach ($secciones as $seccion) { ?>
                                        <option value="<?php echo $seccion['codigo']; ?>"
                                        <?php if ($seccion['codigo'] == $datos['id_seccion']) {echo "selected";} ?>
                                        >                                        
                                        <?php echo $seccion['nombre']; ?>
                                        </option>
                                    <?php } ?>
                                </select>

                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-2">
                                    <label>Código de la División</label>
                                    <input class="form-control form-control-sm" id="codigo" name="codigo" type="text" value="<?php echo $datos['codigo']; ?> " disabled autofocus required></>
                                </div>

                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-12">
                                    <label>Nombre de la División</label>
                                    <input class="form-control form-control-sm" id="nombre" name="nombre" type="text" value="<?php echo $datos['nombre']; ?> " required></>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
                <br />
                <a href="<?php echo base_url(); ?>/divisiones" class="btn btn-primary">Regresar</a>
                <button type="submit" class="btn btn-success">Actualizar</button>
            </form>
        </div>
    </main>