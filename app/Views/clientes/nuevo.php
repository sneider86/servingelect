<div id="layoutSidenav_content">
    <main>
        <div class="row col-sm-12">
            <div style="width:550px" class="card shadow-lg border-1 rounded-lg mt-1">
                <!--<h5 class="mt-4"><?php echo $titulo; ?></h5>-->
                <!--con este php mostramos los errores que se presenten -->
                <?php if (isset($validation)) { ?>
                    <div class="alert alert-danger">
                        <?php echo $validation->listErrors(); ?>
                    </div>
                <?php } ?>
                <form name="f1" method="" autocomplete="off">
                    <div class="card shadow-lg border-1 rounded-lg mt-1">
                        <div style="background: linear-gradient(90deg, #b2b8bc, #b2b8bc);" class="card-body">
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-3">
                                        <label>Nro.Documento</label>
                                        <input class="form-control form-control-sm" id="numero_documento" name="numero_documento" title="Ingresa Nro Documento y Presiona Enter" type="text" onblur="buscarRegistro('/clientes/buscarCliente/','Cliente')"></>
                                    </div>
                                    <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-9">
                                        <label>Razón Social</label>
                                        <input class="form-control form-control-sm" onKeyUp="mayus(this);" id="razon_social" name="razon_social" type="text" onblur="buscarRegistro('/clientes/buscarCliente/','Cliente')"></>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div style="width: 560px; " class="card shadow-lg border-1 rounded-lg mt-1">
                <div class="card shadow-lg border-1 rounded-lg mt-1">
                    <div style="background: linear-gradient(90deg, #b2b8bc, #b2b8bc);height: 120px;" class="card-body col-md-5ths col-lg-5ths col-xs-6 col-sm-12">
                        <textarea style="background:linear-gradient(90deg, #b2b8bc, #b2b8bc)" disabled class="form-control" rows="3" cols="90" id="t_direccion" name="t_direccion"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="container p-1 my-1 border ">
            <form name="f2" method="POST" action="<?php echo base_url(); ?>/clientes/insertar" autocomplete="off">
                <div class="card shadow-lg border-1 rounded-lg mt-1">
                    <input hidden="true" class="form-control " id="id" name="id" type="text"></>
                    <div style="background: linear-gradient(90deg, #6484a5, #22a7bf);">
                        <h3 style="font-weight: bold;font-size:16px;" class="text-center my-2"><?php echo $titulo; ?></h3>
                    </div>
                    <div style="background: linear-gradient(90deg, #b2b8bc, #dbddde);" class="card-body">
                        <div class="form-group col-12">
                            <div class="row">
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-6">
                                    <label>Correo Facturación Electrónica</label>
                                    <div class="input-group">
                                        <input class="form-control form-control-sm" id="email_facturacion" name="email_facturacion" type="email"></>
                                    </div>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-6">
                                    <label>Nombres del Contacto</label>
                                    <input class="form-control form-control-sm" onKeyUp="mayus(this);" id="nombre_contacto" name="nombre_contacto" type="text"></>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-6">
                                    <label>Correos Electrónicos del Contacto</label>
                                    <div class="input-group">
                                        <input class="form-control form-control-sm" disabled="true" id="inp_email" name="inp_email" type="email"></>
                                        <span class="input-group-btn">
                                            <button title="Ingresar Correos Electrónicos del Contacto" href="" class="btn btn-success  form-control-sm" type="button" id="btn_email" data-toggle="modal" data-target="#modalEmailCte"><span class=" fas fa-at"></span></button>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-3">
                                    <label>Tel.Fijos del Contacto</label>
                                    <div class="input-group">
                                        <input class="form-control form-control-sm" disabled="true" id="inp_fijo" name="inp_fijo" type="email"></>
                                        <span class="input-group-btn">
                                            <button title="Ingresar Tel.Fijos del Contacto" href="" class="btn btn-success  form-control-sm" type="button" id="btn_fijo" data-toggle="modal" data-target="#modalTelefonosCte"><span class=" fas fa-tty"></span></button>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-3">
                                    <label>Tel.Celulares del Contacto</label>
                                    <div class="input-group">
                                        <input class="form-control form-control-sm" disabled="true" id="inp_celular" name="inp_celular" type="text"></>
                                        <span class="input-group-btn">
                                            <button title="Ingresar Tel.Celulares del Contacto" href="" class="btn btn-success  form-control-sm" type="button" id="btn_celular" data-toggle="modal" data-target="#modalCelularCte"><span class=" fas fa-mobile-alt"></span></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-6">
                                    <label>Representante Legal</label>
                                    <input class="form-control form-control-sm" onKeyUp="mayus(this);" id="rep_legal" name="rep_legal" type="text"></>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-6">
                                    <label>Correo Representante Legal</label>
                                    <div class="input-group">
                                        <input class="form-control form-control-sm" id="email_replegal" name="email_replegal" type="email"></>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo base_url(); ?>/clientes" class="btn btn-primary">Regresar</a>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </div>
            </form>
        </div>

    </main>

    <!-- Modal Email-->
    <div class="modal fade" id="modalEmailCte" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form class="form-inline">
            <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
                <div style="background: linear-gradient(90deg, #b4c1d9, #b4c1d9);" class="modal-content">
                    <div class="modal-header">
                        <h5 style="color:#98040a;font-size:20px;font-weight:bold;" class="modal-title" id="exampleModalLabel">Agregar Correos Electrónicos</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div style="background: linear-gradient(90deg, #b2b8bc, #dbddde);" class="card-body">
                            <div class="form-group col-12">
                                <div class="row col-12">
                                    <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-6">
                                        <input hidden="true" class="form-control form-control-sm" id="fecha2" name="fecha2" type="date" value=""></>
                                        <label>Email</label>
                                        <input class="form-control form-control-sm" id="email" name="inp_email" type="inp_email" required pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}"></>
                                    </div>

                                    <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-6">
                                        <label>Orden</label>
                                        <div class="input-group">
                                            <select class="form-control form-control-sm" id="orden2" name="orden2" type="text" required>
                                                <option value="P">Principal</option>
                                                <option value="S">Secundario</option>
                                            </select>
                                            <span class="input-group-btn ">
                                                <button id="agregarEmail" type="button" class="btn btn-success form-control-sm">+ <span class=" fas fa-at"></span></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br />
                            <div id="adicionaEmail"></div>
                            <table id="tablaEmail" class="table table-bordered table-hover ">
                                <tr>
                                    <th>Email</th>
                                    <th>Prioridad</th>
                                    <th>Acción</th>
                                </tr>
                            </table>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button id="ok_email" type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Modal Telefonos-->
    <div class="modal fade" id="modalTelefonosCte" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form class="form-inline">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div style="background: linear-gradient(90deg, #b4c1d9, #b4c1d9);" class="modal-content">
                    <div class="modal-header">
                        <h5 style="color:#98040a;font-size:20px;font-weight:bold;" class="modal-title" id="exampleModalLabel">Agregar Teléfonos</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div style="background: linear-gradient(90deg, #b2b8bc, #dbddde);" class="card-body">
                            <div class="form-group col-12">
                                <div class="row">
                                    <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-1">
                                        <label>Indicativo</label>
                                        <input class="form-control form-control-sm" id="indicativo" name="indicativo" type="text" value="035" required></>
                                    </div>
                                    <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-3">
                                        <label>Número</label>
                                        <input minlength="7" maxlength="7" class="form-control form-control-sm" id="valor" name="valor" type="text" autofocus required></>
                                    </div>
                                    <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-3">
                                        <label>Extensiones</label>
                                        <input class="form-control form-control-sm" id="extension" name="extension" type="text" value="0" required></>
                                    </div>
                                    <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-4">
                                        <label>Orden</label>
                                        <div class="input-group">
                                            <select class="form-control form-control-sm" id="orden" name="orden" type="text" required>
                                                <option value="P">Principal</option>
                                                <option value="S">Secundario</option>
                                            </select>
                                            <span class="input-group-btn ">
                                                <button id="agregar" type="button" class="btn btn-success form-control-sm">+ <span class=" fas fa-tty"></span></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br />
                            <div id="adicionados"></div>
                            <table id="tablaTelefonos" class="table table-bordered table-hover ">
                                <tr>
                                    <th>Indicativo</th>
                                    <th>Valor</th>
                                    <th>Extension</th>
                                    <th>Prioridad</th>
                                    <th>Tipo</th>
                                    <th>Acción</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="ok_telefono" type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Modal Celular-->
    <div class="modal fade" id="modalCelularCte" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form class="form-inline">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div style="background: linear-gradient(90deg, #b4c1d9, #b4c1d9);" class="modal-content">
                    <div class="modal-header">
                        <h5 style="color:#98040a;font-size:20px;font-weight:bold;" class="modal-title" id="exampleModalLabel">Agregar Celulares</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div style="background: linear-gradient(90deg, #b2b8bc, #dbddde);" class="card-body">
                            <div class="form-group col-12">
                                <div class="row">

                                    <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-4">
                                        <label>Número</label>
                                        <input maxlength="10" class="form-control form-control-sm" id="valor3" name="valor3" type="text" autofocus required></>
                                    </div>

                                    <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-6">
                                        <label>Orden</label>
                                        <div class="input-group">
                                            <select class="form-control form-control-sm" id="orden3" name="orden3" type="text" required>
                                                <option value="P">Principal</option>
                                                <option value="S">Secundario</option>
                                            </select>
                                            <span class="input-group-btn ">
                                                <button id="agregarCelular" type="button" class="btn btn-success form-control-sm">+ <span class=" fas fa-mobile-alt"></span></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </br>
                            <div id="adicionaCelular"></div>
                            <table id="tablaCelulares" class="table table-bordered table-hover ">
                                <tr>
                                    <th>Valor</th>
                                    <th>Prioridad</th>
                                    <th>Tipo</th>
                                    <th>Acción</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="ok_celular" type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script>
        $(function() {
            $("#numero_documento").autocomplete({
                source: "<?php echo base_url(); ?>/terceros/autocompleteData/" + 'numero_documento',
                minLength: 3,
                select: function(event, ui) {
                    event.preventDefault();
                    $("#numero_documento").val(ui.item.value);
                    $("#razon_social").val(ui.item.razon_social);
                    $("#id").val(ui.item.id);
                    $('#t_direccion').val(ui.item.v_resumen + '\n' + ui.item.direccion + '\n' + ui.item.municipio + ' - ' + ui.item.departamento);
                }
            });

            $("#razon_social").autocomplete({
                source: "<?php echo base_url(); ?>/terceros/autocompleteData/" + 'razon_social',
                minLength: 3,
                select: function(event, ui) {
                    event.preventDefault();
                    $("#razon_social").val(ui.item.value);
                    $("#numero_documento").val(ui.item.numero_documento);
                    $("#id").val(ui.item.id);
                    $("#razon_social").val(ui.item.value);
                    $("#numero_documento").val(ui.item.numero_documento);
                    $('#t_direccion').val(ui.item.v_resumen + '\n' + ui.item.direccion + '\n' + ui.item.municipio + ' - ' + ui.item.departamento);
                }
            });
            $('#ok_email').click(function() {
                var nFilas = $("#tablaEmail tr").length;
                for (let i = 1; i < nFilas; i++) {
                    if (document.getElementById("tablaEmail").rows[i].cells[1].innerHTML == 'P') {
                        inp_email.value = document.getElementById("tablaEmail").rows[i].cells[0].innerHTML;
                    }
                }
            });
        });

    </script>