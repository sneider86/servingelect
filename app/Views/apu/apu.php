<style>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 30px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;  
}

.slider:before {
  position: absolute;
  content: "No";
  height: 22px;
  width: 22px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;  
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
  content:'  Si';
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h5 class="mt-4"><?php echo $titulo; ?></h5>
            <div>
                <p>
                    <input <?php echo $agregar; ?> style="height:2rem;width:6rem;" class="btn btn-info" id="btn_nuevo" data-toggle="modal" data-target="#modalNuevo" value="Agregar">
                    <a style="height:2rem;width:7rem;" href="<?php echo base_url(); ?>/apu/eliminados" class="btn btn-warning">Eliminados</a>
                </p>
            </div>
            <br>
            <div class="table-responsive">
                <table class="table table-bordered table-sm table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr style="color:#98040a;font-weight:300;text-align:center;font-family:Arial;font-size:14px;">
                            <th>Id</th>
                            <th>Descripción</th>
                            <th>Unidad</th>
                            <th>Detalle</th>
                            <th> </th>
                            <th> </th>
                        </tr>
                    </thead>
                    <tbody style="font-family:Arial;font-size:14px;">
                        <?php foreach ($datos as $dato) { ?>
                            <td><?php echo $dato['id_apu']; ?></td>
                            <td><?php echo $dato['descripcion']; ?></td>
                            <td><?php echo $dato['nombre_unidad']; ?></td>
                            <td><?php if($dato['maneja_detalle']=='on'){echo 'Si';}else{echo 'No';}?></td>

                            <td id="inp_edita" style="height:0.2rem;width:1rem;"><input href="#" data-toggle="modal" data-target="#modalEditar" onclick="seleccionaApu(<?php echo $dato['id_apu'] ?>);" type="image" src="<?php echo base_url(); ?>/image/edit.png" width="16" height="16" title="Editar Registro" <?php echo $editar; ?>></input></td>

                            <td style="height:0.2rem;width:1rem;"><input href="#" data-href="<?php echo base_url() . '/apu/eliminar/' . $dato['id_apu']; ?>" data-toggle="modal" data-target="#modal-confirma" type="image" src="<?php echo base_url(); ?>/image/trash.png" width="16" height="16" title="Eliminar Registro" <?php echo $eliminar; ?>></input></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

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
    <?php if (isset($validation)) { ?>
        <div class="alert alert-danger">
            <?php echo $validation->listErrors(); ?>
        </div>
    <?php } ?>

    <!-- Modal Editar Registro-->
    <form method="POST" action="<?php echo base_url(); ?>/apu/actualizar" autocomplete="off">
        <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div style="background: linear-gradient(90deg, #b4c1d9 , #b4c1d9);" class="modal-content">
                    <div class="modal-header">
                        <h5 style="color:#98040a;font-size:20px;font-weight:bold;" class="modal-title" id="exampleModalLabel">Editar A.P.U para Cotización</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id_ed" name="id_ed" />
                        <div class="form-group col-12">
                            <div class="row">
                                <div class="col-12 col-sm-12">
                                    <label>Descripción</label>
                                    <textarea class="form-control form-control-sm" rows="3" cols="90" id="descripcion_ed" name="descripcion_ed" required></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-12">
                                    <label>Unidad</label>
                                    <select class="form-control form-control-sm" id="unidad_ed" name="unidad_ed" type="text" required>
                                        <option value="">Seleccionar Unidad</option>
                                        <?php foreach ($unidades as $row) { ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['valor']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <label>Maneja Detalle</label>
                                    <div class="row">
                                        <label class="switch">
                                            <input type="checkbox" id="detalles_ed" name="detalles_ed">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="<?php echo base_url(); ?>/apu" style="height:2rem;width:6rem;" class="btn btn-primary">Regresar</a>
                        <input <?php echo $actualizar; ?> style="height:2rem;width:6rem;" class="btn btn-success" type="submit" value="Actualizar">
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Modal Agregar Registro-->
    <form method="POST" action="<?php echo base_url(); ?>/apu/insertar" autocomplete="off">
        <div class="modal fade" id="modalNuevo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div style="background: linear-gradient(90deg, #b4c1d9 , #b4c1d9);" class="modal-content">
                    <div class="modal-header">
                        <h5 style="color:#98040a;font-size:20px;font-weight:bold;" class="modal-title" id="exampleModalLabel">Agregar A.P.U para Cotización</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group col-12">
                            <div class="row">
                                <div class="col-12 col-sm-12">
                                    <label>Descripción</label>
                                    <textarea class="form-control form-control-sm" rows="3" cols="90" id="descripcion" name="descripcion" required></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-12">
                                    <label>Unidad</label>
                                    <select class="form-control form-control-sm" id="unidad" name="unidad" type="text" required>
                                        <option value="">Seleccionar Unidad</option>
                                        <?php foreach ($unidades as $row) { ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['valor']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <label>Maneja Detalle</label>
                                    <div class="row">
                                        <label class="switch">
                                            <input type="checkbox" checked id="detalles" name="detalles">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="<?php echo base_url(); ?>/apu" class="btn btn-primary">Regresar</a>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
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
    function seleccionaApu(id) {
        document.getElementById('id_ed').value = id;
        var check='';
        //if(codigo){document.getElementById('codigo_ed').value = codigo;}
        $.ajax({
            type: "PATH",
            url: "<?php echo base_url(); ?>/apu/buscarApu/" + id,
            //data: cadena,
            dataType: "json",
            success: function(r) {
                if(r[0]["maneja_detalle"]=='on'){check='checked';atributo='checked';}else{check='uncheked';atributo='unchecked';}
                $('#id_ed').val(r[0]["id_apu"]);
                $('#descripcion_ed').val(r[0]["descripcion"]);
                $('#unidad_ed').val(r[0]["unidad"]);
                $('#detalles_ed').attr(atributo,check);
            },
            error: function() {
                console.log("No se ha Podido Obtener la Información");
            }
        })
    }
</script>