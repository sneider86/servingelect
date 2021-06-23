<?php
$session = session();
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h5 class="mt-4"><?php echo $titulo; ?></h5>
            <div>
                <p>
                    <a style="height:2rem;" href="<?php echo base_url(); ?>/dotaciones/nuevo" class="btn btn-info" data-toggle="modal" data-target="#modalNuevaDotacion">Agregar</a>
                    
                    <a style="height:2rem;" href="<?php echo base_url(); ?>/dotaciones/eliminados" class="btn btn-warning">Eliminados</a>
                </p>
            </div>
            <br>
            <div class="table-responsive">
                <table class="table table-bordered table-sm table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr style="color:#98040a;font-weight:300;text-align:center;font-family:Arial;font-size:14px;">
                            <th>Id</th>
                            <th hidden="true">Codigo</th>
                            <th>Descripción</th>
                            <th>Grupo</th>
                            <th>Familia</th>
                            <th>U.Medida</th>
                            <th>Ult.Costo</th>
                            <th> </th>
                            <th> </th>
                        </tr>
                    </thead>
                    <tbody id="tbDotacion" style="font-family:Arial;font-size:12px;">
                        <?php foreach ($datos as $dato) { ?>
                            <td><?php echo $dato['id_dotacion']; ?></td>
                            <td hidden="true"><?php echo $dato['codigo']; ?></td>
                            <td><?php echo $dato['descripcion']; ?></td>
                            <td><?php echo $dato['nombre_grupo']; ?></td>
                            <td><?php echo $dato['nombre_familia']; ?></td>
                            <td><?php echo $dato['valor']; ?></td>
                            <td style="text-align:right;"><?php echo number_Format($dato['ultimo_costo'], 2, '.', ','); ?></td>
                            <?php $cod = $dato['id_dotacion']; ?>
                            <td style="height:0.2rem;width:1rem;"><a href="#" data-toggle="modal" data-target="#modalEditaDotacion" onclick="seleccionaDotacion(<?php echo $dato['id_dotacion'] ?>);"><input type="image" src="<?php echo base_url(); ?>/image/edit.png" width="16" height="16"></input></a></td>

                            <td style="height:0.2rem;width:1rem;"><a href="#" data-href="<?php echo base_url() . '/dotaciones/eliminar/' . $dato['id_dotacion']; ?>" data-toggle="modal" data-target="#modal-confirma" data-placement="top" title="Eliminar Registro"><input type="image" src="<?php echo base_url(); ?>/image/trash.png" width="16" height="16"></input></a></td>

                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </main>
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

<!-- Modal Edita Dotación-->
<div width="50%" class="modal fade" id="modalEditaDotacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form method="post" action="<?php echo base_url(); ?>/dotaciones/insertar" class="form-block" enctype="multipart/form-data">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div style="background: linear-gradient(90deg, #b4c1d9, #b4c1d9);" class="modal-content">
                <div class="modal-header">
                    <h5 style="color:#98040a;font-size:20px;font-weight:bold;" class="modal-title" id="exampleModalLabel">Editar Dotaciones</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div style="background: linear-gradient(90deg, #b2b8bc, #dbddde);" class="card-body">
                        <input hidden="true" id="id_dotacion_ed" name="id_dotacion_ed"></>
                        <div class="form-group col-12">
                            <div class="row">
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-12">
                                    <label>Código (Barra)</label>
                                    <input class="form-control form-control-sm" id="codigo_ed" name="codigo_ed"></>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-12">
                                    <label>Descripción</label>
                                    <input class="form-control form-control-sm" id="descripcion_ed" name="descripcion_ed"></>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-6">
                                    <label>Familias</label>
                                    <select class="form-control form-control-sm" id="familia_ed" name="familia_ed" type="text" required>
                                        <option value="">Seleccionar Familia</option>
                                        <?php foreach ($familias as $row) { ?>
                                            <option value="<?php echo $row['id_family']; ?>"><?php echo $row['nombre']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-6">
                                    <label>Grupos</label>
                                    <select class="form-control form-control-sm" id="grupo_ed" name="grupo_ed" type="text" required>
                                        <option value="">Seleccionar</option>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-3">
                                    <label>Ultimo Costo</label>
                                    <input style="text-align:right" class="form-control form-control-sm" id="costo_ed" name="costo_ed"></>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-9">
                                    <label>Unidad de Medida</label>
                                    <select class="form-control form-control-sm" id="u_medida_ed" name="u_medida_ed" type="text" required>
                                        <option value="">Seleccionar Unidad</option>
                                        <?php foreach ($u_medida as $row) { ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['valor']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo base_url(); ?>/dotaciones" class="btn btn-primary form-control-sm">Regresar</a>
                    <button type="submit" class="btn btn-success form-control-sm">Actualizar</button>
                </div>
            </div>
        </div>
    </form>
</div>


<!-- Modal Nueva Dotación-->
<div width="50%" class="modal fade" id="modalNuevaDotacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form method="post" action="<?php echo base_url(); ?>/dotaciones/insertar" class="form-block" enctype="multipart/form-data">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div style="background: linear-gradient(90deg, #b4c1d9, #b4c1d9);" class="modal-content">
                <div class="modal-header">
                    <h5 style="color:#98040a;font-size:20px;font-weight:bold;" class="modal-title" id="exampleModalLabel">Crear Dotaciones</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div style="background: linear-gradient(90deg, #b2b8bc, #dbddde);" class="card-body">
                        <div class="form-group col-12">
                            <div class="row">
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-12">
                                    <label>Código (Barra)</label>
                                    <input class="form-control form-control-sm" id="codigo" name="codigo"></>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-12">
                                    <label>Descripción</label>
                                    <input class="form-control form-control-sm" id="descripcion" name="descripcion"></>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-6">
                                    <label>Familias</label>
                                    <select class="form-control form-control-sm" id="familia" name="familia" type="text" required>
                                        <option value="">Seleccionar Familia</option>
                                        <?php foreach ($familias as $row) { ?>
                                            <option value="<?php echo $row['id_family']; ?>"><?php echo $row['nombre']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-6">
                                    <label>Grupos</label>
                                    <select class="form-control form-control-sm" id="grupo" name="grupo" type="text" required>
                                        <option value="">Seleccionar</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-3">
                                    <label>Ultimo Costo</label>
                                    <input class="form-control form-control-sm" id="costo" name="costo"></>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-9">
                                    <label>Unidad de Medida</label>
                                    <select class="form-control form-control-sm" id="u_medida" name="u_medida" type="text" required>
                                        <option value="">Seleccionar Unidad</option>
                                        <?php foreach ($u_medida as $row) { ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['valor']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo base_url(); ?>/dotaciones" class="btn btn-primary form-control-sm">Regresar</a>
                    <button type="submit" class="btn btn-success form-control-sm">Guardar</button>
                </div>
            </div>
        </div>
    </form>
</div>

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
</body>

</html>

<script>
    $(document).ready(function() {
        recargarGrupos('familia', 'grupo', '/dotaciones/getGrupos/');
        $('#familia').change(function() {
            recargarGrupos('familia', 'grupo', '/dotaciones/getGrupos/');
        });

        recargarGrupos('familia_ed', 'grupo_ed', '/dotaciones/getGrupos/');
        $('#familia_ed').change(function() {
            recargarGrupos('familia_ed', 'grupo_ed', '/dotaciones/getGrupos/');
        });
    })

    function seleccionaDotacion(id) {

        document.getElementById('id_dotacion_ed').value = id;
        //if(codigo){document.getElementById('codigo_ed').value = codigo;}
        $.ajax({
            type: "PATH",
            url: "<?php echo base_url(); ?>/dotaciones/buscarDotacion/" + id,
            //data: cadena,
            dataType: "json",
            success: function(r) {
                //buscarFamilia(r[0]["id_padre"]);
                $('#codigo_ed').val(r[0]["codigo"]);
                $('#descripcion_ed').val(r[0]["descripcion"]);
                $('#familia_ed').val(r[0]["id_padre"]);
                $('#grupo_ed').val(r[0]["id_familia"]);
                $('#u_medida_ed').val(r[0]["unidad_medida"]);
                $('#costo_ed').val(Intl.NumberFormat("en-US").format(r[0]["ultimo_costo"]));
            },
            error: function() {
                console.log("No se ha podido obtener la información");
            }
        })
    }

    function buscarFamilia(cod_familia) {
        $.ajax({
            type: "PATH",
            url: "<?php echo base_url(); ?>/dotaciones/mostrarGrupos/" + cod_familia,
            dataType: "json",
            success: function(result) {
                console.log(result);
                result.forEach(function(result, index) {
                    //console.log(`${index} : ${r}`);
                    grupo_ed.value=result[0][0][id_family];
                    grupo_ed.text=result[0][0][nombre];
                });
            }
        });
    };
</script>