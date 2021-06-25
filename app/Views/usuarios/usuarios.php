<?php
$session = session();
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h5 class="mt-4"><?php echo $titulo; ?></h5>
            <div>
                <p>
                    <input <?php echo $agregar; ?> style="height:2rem;width:6rem;" href="<?php echo base_url(); ?>/usuarios/nuevo" data-toggle="modal" data-target="#modalNuevoUsuario" class="btn btn-info" Value="Agregar">

                    <a style="height:2rem;width:7rem;" href="<?php echo base_url(); ?>/usuarios/eliminados" class="btn btn-warning">Eliminados</a>
                </p>
            </div>
            <br>
            <div class="table-responsive">
                <table class="table table-bordered table-sm table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr style="font-family:Arial;color:#98040a;font-weight:300;text-align:center;font-size:14px;">
                            <th>Id</th>
                            <th>Usuario</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th> </th>
                            <th> </th>
                        </tr>
                    </thead>
                    <tbody style="font-family:Arial;font-size:14px;">
                        <?php foreach ($datos as $dato) { ?>
                            <td><?php echo $dato['id']; ?></td>
                            <td><?php echo $dato['usuario']; ?></td>
                            <td><?php echo $dato['nombres']; ?></td>
                            <td><?php echo $dato['email']; ?></td>
                            <td><?php echo $dato['nombre_rol']; ?></td>

                            <td style="height:0.2rem;width:1rem;"><input href="#" data-toggle="modal" data-target="#modalEditaUsuario" onclick="seleccionaUsuario(<?php echo $dato['id'] ?>);" type="image" src="<?php echo base_url(); ?>/image/edit.png" width="16" height="16" title="Editar Registro" <?php echo $editar; ?>></input></td>

                            <td style="height:0.2rem;width:1rem;"><input href="#" data-href="<?php echo base_url() . '/usuarios/eliminar/' . $dato['id']; ?>" data-toggle="modal" data-target="#modal-confirma" type="image" src="<?php echo base_url(); ?>/image/trash.png" width="16" height="16" title="Eliminar Registro" <?php echo $eliminar; ?>></input></td>

                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <!-- Modal Edita Usuario-->
    <form method="POST" action="<?php echo base_url(); ?>/usuarios/actualizar" class="form-block" enctype="multipart/form-data">
        <div width="50%" class="modal fade" id="modalEditaUsuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div style="background: linear-gradient(90deg, #b4c1d9, #b4c1d9);" class="modal-content">
                    <div class="modal-header">
                        <h5 style="color:#98040a;font-size:20px;font-weight:bold;" class="modal-title" id="exampleModalLabel">Editar Usuario</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="id_modal" class="modal-body">
                        <input type="hidden" id="id_ed" name="id_ed" />
                        <div style="background: linear-gradient(90deg, #b2b8bc, #dbddde);" class="card-body">
                            <div class="form-group col-12">
                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <label>Usuario</label>
                                        <input disabled="true" class="form-control form-control-sm" id="usuario_ed" name="usuario_ed" type="text" value="" readonly></>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <label>Nombres y Apellidos</label>
                                        <input class="form-control form-control-sm" id="nombres_ed" name="nombres_ed" type="text" value=""></>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12 col-sm-6">
                                            <label>Rol</label>
                                            <select class="form-control form-control-sm" id="id_rol_ed" name="id_rol_ed" type="text" required>
                                                <option value="">Seleccionar Rol</option>
                                                <?php foreach ($roles as $rol) { ?>
                                                    <option value="<?php echo $rol['id']; ?>"><?php echo $rol['nombre']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <label>Email</label>
                                            <input class="form-control form-control-sm" id="email_ed" name="email_ed" type="email" value=""></>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="<?php echo base_url(); ?>/usuarios" class="btn btn-primary form-control-sm">Regresar</a>
                        <button <?php echo $actualizar; ?> type="submit" class="btn btn-success form-control-sm">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>


    <!-- Modal Nuevo Usuario-->
    <div width="50%" class="modal fade" id="modalNuevoUsuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form method="post" action="<?php echo base_url(); ?>/usuarios/insertar" class="form-block" enctype="multipart/form-data">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div style="background: linear-gradient(90deg, #b4c1d9, #b4c1d9);" class="modal-content">
                    <div class="modal-header">
                        <h5 style="color:#98040a;font-size:20px;font-weight:bold;" class="modal-title" id="exampleModalLabel">Crear Usuario</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="id_modal" class="modal-body">
                        <div style="background: linear-gradient(90deg, #b2b8bc, #dbddde);" class="card-body">
                            <div class="form-group col-12">
                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <label>Usuario</label>
                                        <input class="form-control form-control-sm" id="usuario" name="usuario" type="text" value="" autofocus></>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <label>Nombres y Apellidos</label>
                                        <input class="form-control form-control-sm" id="nombres" name="nombres" type="text" value=""></>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <label>Contraseña</label>
                                        <input class="form-control form-control-sm" id="password" name="password" type="password" value=""></>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <label>Repetir Contraseña</label>
                                        <input class="form-control form-control-sm" id="rpassword" name="rpassword" type="password" value=""></>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12 col-sm-6">
                                            <label>Rol</label>
                                            <select class="form-control form-control-sm" id="id_rol" name="id_rol" type="text" required>
                                                <option value="">Seleccionar Rol</option>
                                                <?php foreach ($roles as $rol) { ?>
                                                    <option value="<?php echo $rol['id']; ?>"><?php echo $rol['nombre']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <label>Email</label>
                                            <input class="form-control form-control-sm" id="email" name="email" type="email" value=""></>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="<?php echo base_url(); ?>/usuarios" class="btn btn-primary form-control-sm">Regresar</a>
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
    function seleccionaUsuario(id) {
        document.getElementById('id_ed').value = id;
        //if(codigo){document.getElementById('codigo_ed').value = codigo;}
        $.ajax({
            type: "PATH",
            url: "<?php echo base_url(); ?>/usuarios/buscarUsuario/" + id,
            //data: cadena,
            dataType: "json",
            success: function(r) {
                $('#id_ed').val(r[0]["id"]);
                $('#usuario_ed').val(r[0]["usuario"]);
                $('#nombres_ed').val(r[0]["nombres"]);
                $('#id_rol_ed').val(r[0]["id_rol"]);
                $('#email_ed').val(r[0]["email"]);
            },
            error: function() {
                console.log("No se ha podido obtener la información");
            }
        })
    }
</script>
