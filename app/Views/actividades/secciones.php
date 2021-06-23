<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h5 class="mt-2"><?php echo $titulo; ?></h5>
            <div>
                <p>
                    <input style="height:2rem;width:6rem;" class="btn btn-info" id="btn_nuevo" data-toggle="modal" data-target="#modalNuevo" value="Agregar">
                    <a style="height:2rem;width:7rem;" href="<?php echo base_url(); ?>/secciones/eliminados_seccion" class="btn btn-warning">Eliminados</a>                    
                </p>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-sm table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr style="color:#98040a;font-weight:300;text-align:center;font-size:14px;">
                            <th>Código</th>
                            <th>Nombre de la Sección</th>
                            <th> </th>
                            <th> </th>
                        </tr>
                    </thead>
                    <tbody style="font-family:Arial;font-size:12px;">
                        <?php foreach ($datos as $dato) { ?>
                            <td><?php echo $dato['codigo']; ?></td>
                            <td><?php echo $dato['nombre']; ?></td>

                            <td id="inp_edita" style="height:0.2rem;width:1rem;"><input href="#" data-toggle="modal" data-target="#modalEditar" onclick="seleccionaSeccion(<?php echo "'".$dato['codigo']."'"; ?>);" type="image" src="<?php echo base_url(); ?>/image/edit.png" width="16" height="16" title="Editar Registro" ></input></td>

                            <td style="height:0.2rem;width:1rem;"><input href="#" data-href="<?php echo base_url() . '/secciones/elimina_seccion/' . $dato['codigo']; ?>" data-toggle="modal" data-target="#modal-confirma" type="image" src="<?php echo base_url(); ?>/image/trash.png" width="16" height="16" title="Eliminar Registro" ></input></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Modal Editar Registro-->
    <form method="POST" action="<?php echo base_url(); ?>/secciones/actualizar_seccion" autocomplete="off">
        <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div style="background: linear-gradient(90deg, #b4c1d9 , #b4c1d9);" class="modal-content">
                    <div class="modal-header">
                        <h5 style="color:#98040a;font-size:20px;font-weight:bold;" class="modal-title" id="exampleModalLabel">Editar Secciones</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <input type="hidden" id="id_ed" name="id_ed" />
                        <div class="form-group col-12">
                            <div class="row">
                                <div class="col-12 col-sm-2">
                                    <label>Código</label>
                                    <input disabled readonly class="form-control form-control-sm" id="codigo_ed" name="codigo_ed" type="text"></>
                                </div>
                                <div class="col-12 col-sm-12">
                                    <label>Nombre de la Sección</label>
                                    <input class="form-control form-control-sm" id="nombre_ed" name="nombre_ed" type="text" required></>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="<?php echo base_url(); ?>/secciones" style="height:2rem;width:6rem;" class="btn btn-primary">Regresar</a>
                        <button <?php echo $actualizar; ?> style="height:2rem;width:6rem;" type="submit" class="btn btn-success">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>    

    <!-- Modal Agregar Registro-->
    <form method="POST" action="<?php echo base_url(); ?>/secciones/inserta_seccion" autocomplete="off">
        <div class="modal fade" id="modalNuevo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div style="background: linear-gradient(90deg, #b4c1d9 , #b4c1d9);" class="modal-content">
                    <div class="modal-header">
                        <h5 style="color:#98040a;font-size:20px;font-weight:bold;" class="modal-title" id="exampleModalLabel">Agregar Secciones</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group col-12">
                            <div class="row">
                                <div class="col-12 col-sm-2">
                                    <label>Código</label>
                                    <input class="form-control form-control-sm" onblur="buscarSeccion(this)" id="codigo" name="codigo" type="text" autofocus required></>
                                </div>

                                <div class="col-12 col-sm-12">
                                    <label>Nombre de la Sección</label>
                                    <input class="form-control form-control-sm" id="nombre" name="nombre" type="text" required></>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="<?php echo base_url(); ?>/secciones" class="btn btn-primary">Regresar</a>
                        <button type="submit" class="btn btn-success">Guardar</button>
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
</body>
</html>
<script type="text/javascript">
    function seleccionaSeccion(id) {
        document.getElementById('id_ed').value = id;
        //if(codigo){document.getElementById('codigo_ed').value = codigo;}
        $.ajax({
            type: "PATH",
            url: "<?php echo base_url(); ?>/secciones/buscarSeccion/" + id,
            //data: cadena,
            dataType: "json",
            success: function(r) {
                $('#codigo_ed').val(r[0]["codigo"]);
                $('#nombre_ed').val(r[0]["nombre"]);
            },
            error: function() {
                console.log("No se ha podido obtener la información");
            }
        })
    }

    function buscarSeccion(id) {
        appendTo: "#modalNuevo",
        $.ajax({
            type: "PATH",
            url: "<?php echo base_url(); ?>/secciones/buscar_Seccion/" + document.getElementById('codigo').value,
            dataType: "json",
            success: function(r) {
                if (r) {
                    swal('', 'El Código de Seccion Ingresado ya Existe. Verifique y Corrija.', '');
                    document.getElementById('codigo').value="";
                    document.getElementById('codigo').focus();
                }
            }            
        })
    }

</script>