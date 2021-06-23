<?php
$session = session();
?>
<div id="layoutSidenav_content" target="_blank">
    <main>
        <div class="container-fluid">
            <?php if (isset($validation)) { ?>
                <div class="alert alert-danger">
                    <?php echo $validation->listErrors(); ?>
                </div>
            <?php } ?>
            <input class="form-control" id="usuario" name="usuario" type="hidden" value="<?php echo $session->id_usuario; ?>" ></>            
            <form style="width:600px;" method="POST" action="<?php echo base_url(); ?>/dotaciones/insertar" autocomplete="off">
                <div  class="card shadow-lg border-1 rounded-lg mt-1">
                    <div style="background: linear-gradient(90deg, #6484a5, #22a7bf);">
                        <h3 style="font-weight: bold;font-size:22px;" class="text-center my-1"><?php echo $titulo; ?></h3>
                    </div>
                    <div style="background: linear-gradient(90deg, #b2b8bc, #dbddde);" class="card-body">
                        <div class="form-group col-12">
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <label>Código (Barra)</label>
                                    <input class="form-control form-control-sm" id="codigo" name="codigo" type="text" value="<?php echo set_value('nombre') ?>" autofocus></>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label>Nombre</label>
                                    <input class="form-control form-control-sm" id="descripcion" name="descripcion" type="text" value="<?php echo set_value('nombre') ?>" autofocus></>
                                </div
                            </div>
                            <div class="row">
                            <div class="col-12 col-sm-6">
                                    <label>Ultimo Costo</label>
                                    <input class="form-control form-control-sm" id="nombre" name="nombre" type="text" value="<?php echo set_value('nombre') ?>" autofocus></>
                                </div>                                 
                                <div class="col-12 col-sm-6">
                                    <label>Unidad de Medida</label>
                                    <select class="form-control form-control-sm" id="id_modulo" name="id_modulo" type="text" required>
                                        <option value="">Seleccionar Módulo</option>
                                        <?php foreach ($modulos as $row) { ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                               
                            </div>                            
                        </div>
                        <a href="<?php echo base_url(); ?>/dotaciones" class="btn btn-primary">Regresar</a>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </div>
            </form>

        </div>
    </main>