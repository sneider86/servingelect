<?php
$session = session();
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h5 class="mt-4"><?php echo $titulo; ?></h5>
            <div>
                <p>
                    <input <?php echo $agregar; ?> style="height:2rem;width:6rem;" class="btn btn-info" id="btn_nuevo" data-toggle="modal" data-target="#modalNuevo" value="Agregar">
                    <a style="height:2rem;" href="<?php echo base_url(); ?>/acciones/eliminados" class="btn btn-warning">Eliminados</a>
                </p>
            </div>
            <br>
            <div class="table-responsive">
                <table class="table table-bordered table-sm table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr style="color:#98040a;font-weight:300;text-align:center;font-family:Arial;font-size:14px;">
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Módulo</th>
                            <th>Activo</th>
                            <th> </th>
                            <th> </th>
                        </tr>
                    </thead>
                    <tbody style="font-family:Arial;font-size:14px;">
                        <?php foreach ($datos as $dato) { ?>
                            <td><?php echo $dato['id']; ?></td>
                            <td><?php echo $dato['nombre']; ?></td>
                            <td><?php echo $dato['id_modulo']; ?></td>
                            <td><?php echo $dato['activo']; ?></td>

                            <td id="inp_edita" style="height:0.2rem;width:1rem;"><input href="#" data-toggle="modal" data-target="#modalEditar" onclick="seleccionaAccion(<?php echo $dato['id'] ?>);" type="image" src="<?php echo base_url(); ?>/image/edit.png" width="16" height="16" title="Editar Registro" <?php echo $editar; ?> ></input></td>

                            <td style="height:0.2rem;width:1rem;"><input href="#" data-href="<?php echo base_url() . '/acciones/eliminar/' . $dato['id']; ?>" data-toggle="modal" data-target="#modal-confirma"  type="image" src="<?php echo base_url(); ?>/image/trash.png" width="16" height="16" title="Eliminar Registro" <?php echo $eliminar; ?> ></input></td>

                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <!-- Modal Editar Registro-->
    <form method="POST" action="<?php echo base_url(); ?>/acciones/actualizar" autocomplete="off">
        <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div style="background: linear-gradient(90deg, #b4c1d9 , #b4c1d9);" class="modal-content">
                    <div class="modal-header">
                        <h5 style="color:#98040a;font-size:20px;font-weight:bold;" class="modal-title" id="exampleModalLabel">Editar Acciones</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id_ed" name="id_ed" />
                        <div class="form-group col-12">
                        <div class="row">
                                <div class="col-12 col-sm-12">
                                    <label>Nombre</label>
                                    <input class="form-control form-control-sm" id="nombre_ed" name="nombre_ed" type="text" autofocus required></>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-12">
                                    <label>Módulo</label>
                                    <select class="form-control form-control-sm" id="id_modulo_ed" name="id_modulo_ed" type="text" required>
                                        <option value="">Seleccionar Módulo</option>
                                        <?php foreach ($modulos as $row) { ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="<?php echo base_url(); ?>/acciones" style="height:2rem;width:6rem;" class="btn btn-primary">Regresar</a>
                        <button <?php echo $actualizar ; ?> type="submit" style="height:2rem;width:6rem;" class="btn btn-success">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>    
    <!-- Modal Agregar Acciones-->
    <form method="POST" action="<?php echo base_url(); ?>/acciones/insertar" autocomplete="off">
        <div class="modal fade" id="modalNuevo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div style="background: linear-gradient(90deg, #b4c1d9 , #b4c1d9);" class="modal-content">
                    <div class="modal-header">
                        <h5 style="color:#98040a;font-size:20px;font-weight:bold;" class="modal-title" id="exampleModalLabel">Agregar Acción</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group col-12">
                            <div class="row">
                                <div class="col-12 col-sm-12">
                                    <label>Nombre</label>
                                    <input class="form-control form-control-sm" id="nombre" name="nombre" type="text" autofocus required></>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-12">
                                    <label>Módulo</label>
                                    <select class="form-control form-control-sm" id="id_modulo" name="id_modulo" type="text" required>
                                        <option value="">Seleccionar Módulo</option>
                                        <?php foreach ($modulos as $row) { ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="<?php echo base_url(); ?>/acciones" style="height:2rem;width:6rem;" class="btn btn-primary">Regresar</a>
                        <button type="submit" style="height:2rem;width:6rem;" class="btn btn-success">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Modal -->
    <div class="modal fade" id="modal-confirma" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div style="background: linear-gradient(90deg, #838da0, #b4c1d9);" class="modal-content">
                <div class="modal-header">
                    <h5 style="color:#98040a;font-size:20px;font-weight:bold;" class="modal-title" id="exampleModalLabel">Eliminación de Registro</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div style="text-align:center;font-weight:bold;" class="modal-body">
                    <p>Seguro Desea Eliminar éste Registro?</p>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-light" data-dismiss="modal">No</button> -->
                    <button type="button" class="btn btn-light" data-dismiss="modal">No</button>
                    <a class="btn btn-danger btn-ok">Si</a>
                </div>
            </div>
        </div>
    </div>

    <footer style="background: linear-gradient(90deg, #0356a8, #22a7bf);" class="py-4 bg-light mt-auto">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between small">
                <div style="color:white">Copyright &copy; EK-Soft *Desarrollo de Software* <?php echo date('Y'); ?></div>
                <div style="color:white">
                    <a style="color:white" href="#">Facebook</a>
                    &middot;
                    <a style="color:white" href="#">Página Web</a>
                </div>
            </div>
        </div>
    </footer>
</div>
</div>
</body>

</html>
<script type="text/javascript">
    function seleccionaAccion(id) {
        document.getElementById('id_ed').value = id;
        //if(codigo){document.getElementById('codigo_ed').value = codigo;}
        $.ajax({
            type: "PATH",
            url: "<?php echo base_url(); ?>/acciones/buscarAccion/" + id,
            //data: cadena,
            dataType: "json",
            success: function(r) {
                $('#id_ed').val(r[0]["id"]);
                $('#nombre_ed').val(r[0]["nombre"]);
                $('#id_modulo_ed').val(r[0]["id_modulo"]);
            },
            error: function() {
                console.log("No se ha podido obtener la información");
            }
        })
    }
</script>