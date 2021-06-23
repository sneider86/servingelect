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
                                        <input disabled class="form-control form-control-sm" id="numero_documento" name="numero_documento" title="Ingresa Nro Documento y Presiona Enter" type="text" value="<?php echo $datos['numero_documento'] ?>" onblur="buscarRegistro('/personal/buscarPersonal/','Personal')"></>
                                    </div>
                                    <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-9">
                                        <label>Razón Social</label>
                                        <input disabled class="form-control form-control-sm" onKeyUp="mayus(this);" id="razon_social" name="razon_social" type="text" value="<?php echo $datos['razon_social'] ?>" onblur="buscarRegistro('/personal/buscarPersonal/','Personal')"></>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div style="width: 550px; " class="card shadow-lg border-1 rounded-lg mt-1">
                <div class="card shadow-lg border-1 rounded-lg mt-1">
                    <div style="background: linear-gradient(90deg, #b2b8bc, #b2b8bc);height: 120px;" class="card-body col-md-5ths col-lg-5ths col-xs-6 col-sm-12">
                        <textarea style="background:linear-gradient(90deg, #b2b8bc, #b2b8bc)" disabled class="form-control" rows="3" cols="90" id="t_direccion" name="t_direccion"><?php echo $datos['v_resumen'] . "\n" . $datos['direccion'] . "\n" . $datos['municipio'] . " - " . $datos['departamento'] ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <form method="POST" name="f2" action="<?php echo base_url(); ?>/personal/actualizar" autocomplete="off">
                <div class="card shadow-lg border-1 rounded-lg mt-1">
                    <input hidden="true" class="form-control " id="id" name="id" type="text" value="<?php echo $datos['id_persona'] ?>"></>
                    <div style="background: linear-gradient(90deg, #6484a5, #22a7bf);">
                        <h3 style="font-weight: bold;font-size:16px;" class="text-center my-2"><?php echo $titulo; ?></h3>
                    </div>
                    <div style="background: linear-gradient(90deg, #b2b8bc, #dbddde);" class="card-body">
                        <div class="form-group col-12">
                            <div class="row">
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-3">
                                    <label>Tipo de Personal</label>
                                    <select class="form-control form-control-sm" id="tipo_persona" name="tipo_persona" type="text" required>
                                        <option value="">Seleccionar</option>
                                        <?php foreach ($tipo_personal as $row) { ?>
                                            <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $datos['tipo_persona']) {
                                                                                            echo 'selected';
                                                                                        } ?>><?php echo $row['valor']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-3">
                                    <label>Cargo Asignado</label>
                                    <select class="form-control form-control-sm" id="cargo" name="cargo" type="text" required>
                                        <option value="">Seleccionar</option>
                                        <?php foreach ($cargos as $row) { ?>
                                            <option value="<?php echo $row['id_cargo']; ?>" <?php if ($row['id_cargo'] == $datos['cargo']) {
                                                                                                echo 'selected';
                                                                                            } ?>><?php echo $row['nombre']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-2">
                                    <label>Estado Civil</label>
                                    <select class="form-control form-control-sm" id="estado_civil" name="estado_civil" type="text" required>
                                        <option value="">Seleccionar</option>
                                        <?php foreach ($estado_civil as $row) { ?>
                                            <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $datos['estado_civil']) {
                                                                                            echo 'selected';
                                                                                        } ?>><?php echo $row['valor']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-2">
                                    <label>Género</label>
                                    <select class="form-control form-control-sm" id="genero" name="genero" type="text" required>
                                        <option value="">Seleccionar</option>
                                        <?php foreach ($genero as $row) { ?>
                                            <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $datos['genero']) {
                                                                                            echo 'selected';
                                                                                        } ?>><?php echo $row['valor']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-2">
                                    <label>Tipo de Sangre</label>
                                    <select class="form-control form-control-sm" id="tipo_sangre" name="tipo_sangre" type="text" required>
                                        <option value="">Seleccionar</option>
                                        <?php foreach ($tipo_sangre as $row) { ?>
                                            <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $datos['tipo_sangre']) {
                                                                                            echo 'selected';
                                                                                        } ?>><?php echo $row['resumen']; ?></option>
                                        <?php } ?>

                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-3">
                                    <label>Clase de Libreta Militar</label>
                                    <select class="form-control form-control-sm" id="clase_libreta" name="clase_libreta" type="text" required>
                                        <option value="">Seleccionar</option>
                                        <?php foreach ($libreta_militar as $row) { ?>
                                            <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $datos['clase_libreta']) {
                                                                                            echo 'selected';
                                                                                        } ?>><?php echo $row['valor']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-3">
                                    <label>Número de Libreta Militar</label>
                                    <div class="input-group">
                                        <input class="form-control form-control-sm" id="numero_libreta" name="numero_libreta" type="text" value="<?php echo $datos['numero_libreta'] ?>"></>
                                        <span class="input-group-btn">
                                            <button title="Cargar PDF Libreta Militar" href="" class="btn btn-success  form-control-sm" type="button" id="btn_cargarLibreta"><i class="fas fa-download" data-toggle="modal" data-target="#modalCargarArchivos"></i></button>
                                            <button title="Ver PDF Libreta Militar" href="" class="btn btn-success  form-control-sm" type="button" id="btn_ver"><i class="fas fa-search"></i></button>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-1.5">
                                    <label>Camisa</label>
                                    <select class="form-control form-control-sm" id="camisa" name="camisa" type="text" required>
                                        <option value="">Seleccionar</option>
                                        <?php foreach ($camisa as $row) { ?>
                                            <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $datos['camisa']) {
                                                                                            echo 'selected';
                                                                                        } ?>><?php echo $row['resumen']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-1.5">
                                    <label>Pantalón</label>
                                    <select class="form-control form-control-sm" id="pantalon" name="pantalon" type="text" required>
                                        <option value="">Seleccionar</option>
                                        <?php foreach ($pantalon as $row) { ?>
                                            <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $datos['pantalon']) {
                                                                                            echo 'selected';
                                                                                        } ?>><?php echo $row['resumen']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-1.5">
                                    <label>Zapatos</label>
                                    <select class="form-control form-control-sm" id="zapatos" name="zapatos" type="text" required>
                                        <option value="">Seleccionar</option>
                                        <?php foreach ($zapatos as $row) { ?>
                                            <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $datos['zapatos']) {
                                                                                            echo 'selected';
                                                                                        } ?>><?php echo $row['resumen']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-1.5">
                                    <label>Guantes</label>
                                    <select class="form-control form-control-sm" id="guantes" name="guantes" type="text" required>
                                        <option value="">Seleccionar</option>
                                        <?php foreach ($guantes as $row) { ?>
                                            <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $datos['guantes']) {
                                                                                            echo 'selected';
                                                                                        } ?>><?php echo $row['resumen']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-3">
                                    <label>Nro. de Cuenta para Pago</label>
                                    <input class="form-control form-control-sm" id="cuenta_pago" name="cuenta_pago" type="text" value="<?php echo $datos['cuenta_pago'] ?>"></>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-3">
                                    <label>Tipo de Cuenta para Pago</label>
                                    <select class="form-control form-control-sm" id="tipoCuenta_pago" name="tipoCuenta_pago" type="text" required>
                                        <option value="">Seleccionar</option>
                                        <?php foreach ($tipo_cuenta as $row) { ?>
                                            <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $datos['tipo_cuenta']) {
                                                                                            echo 'selected';
                                                                                        } ?>><?php echo $row['valor']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-6">
                                    <label>Banco</label>
                                    <div class="input-group">
                                        <select class="form-control form-control-sm" id="banco_pago" name="banco_pago" type="text" required>
                                            <option value="">Seleccionar</option>
                                            <?php foreach ($bancos as $row) { ?>
                                                <option value="<?php echo $row['id_bco']; ?>" <?php if ($row['id_bco'] == $datos['banco_pago']) {
                                                                                                    echo 'selected';
                                                                                                } ?>><?php echo $row['nombre']; ?></option>
                                            <?php } ?>

                                        </select>
                                        <span class="input-group-btn">
                                            <button title="Cargar Certificación Bancaria" href="" class="btn btn-success  form-control-sm" type="button" id="btn_cargarCertificadoBanco"><i class="fas fa-download" data-toggle="modal" data-target="#modalCargarArchivos"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-3">
                                    <label>Nombres del Contacto</label>
                                    <input class="form-control form-control-sm" id="nombres_contacto" name="nombres_contacto" type="text" value="<?php echo $datos['nombres_contacto'] ?>"></>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-3">
                                    <label>Dirección del Contacto</label>
                                    <input class="form-control form-control-sm" id="direccion_contacto" name="direccion_contacto" type="text" value="<?php echo $datos['direccion_contacto'] ?>"></>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-2">
                                    <label>Teléfono Fijo </label>
                                    <input class="form-control form-control-sm" id="fijo_contacto" name="fijo_contacto" type="text" value="<?php echo $datos['fijo_contacto'] ?>"></>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-2">
                                    <label>Teléfono Celular </label>
                                    <input class="form-control form-control-sm" id="movil_contacto" name="movil_contacto" type="text" value="<?php echo $datos['movil_contacto'] ?>"></>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-2">
                                    <label>Parentesco </label>
                                    <select class="form-control form-control-sm" id="parentesco" name="parentesco" type="text" required>
                                        <option value="">Seleccionar</option>
                                        <?php foreach ($parentesco as $row) { ?>
                                                <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $datos['parentesco']) {echo 'selected';} ?>><?php echo $row['valor']; ?></option>
                                            <?php } ?>                                        
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-3">
                                    <label>Curso Altura/F.Vencimiento </label>
                                    <div class="input-group mb-3 ">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text" class="form-control-sm">
                                                <input type="checkbox" id="curso_altura" name="curso_altura" <?php if($datos['curso_altura']==1){
                                                    echo 'checked';
                                                }else{echo 'unchecked';} ?> aria-label="Checkbox for following text input">
                                            </div>
                                        </div>
                                        <input id="fechav_curso" name="fechav_curso" type="date" class="form-control form-control-sm" aria-label="Text input with checkbox" placeholder="F.Vencimiento">
                                        <span class="input-group-btn">
                                            <button title="Cargar Certificación Curso" href="" class="btn btn-success  form-control-sm" type="button" id="btn_cargarCertificado"><i class="fas fa-download" data-toggle="modal" data-target="#modalCargarArchivos"></i></button>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-3">
                                    <label>Examen Médico/F.Vencimiento </label>
                                    <div class="input-group mb-3 ">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text" class="form-control-sm">
                                                <input type="checkbox" aria-label="Checkbox for following text input">
                                            </div>
                                        </div>
                                        <input type="date" class="form-control form-control-sm" aria-label="Text input with checkbox" placeholder="F.Vencimiento">
                                        <span class="input-group-btn">
                                            <button title="Cargar Certificación Examen" href="" class="btn btn-success  form-control-sm" type="button" id="btn_cargarCertificadoMedico"><i class="fas fa-download" data-toggle="modal" data-target="#modalCargarArchivos"></i></button>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-3">
                                    <label>Certificado CONTE/F.Vigencia </label>
                                    <div class="input-group mb-3 ">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text" class="form-control-sm">
                                                <input type="checkbox" aria-label="Checkbox for following text input" id="ckk_Conte">
                                            </div>
                                        </div>
                                        <input type="date" class="form-control form-control-sm" aria-label="Text input with checkbox" placeholder="F.Vencimiento" id="f_vctoConte">
                                        <span class="input-group-btn">
                                            <button title="Cargar Certificación CONTE" href="" class="btn btn-success  form-control-sm" type="button" id="btn_cargarCertificadoConte"><i class="fas fa-download" data-toggle="modal" data-target="#modalCargarArchivos"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </br>
                        <a href="<?php echo base_url(); ?>/personal" class="btn btn-primary">Regresar</a>
                        <button type="submit" class="btn btn-success">Actualizar</button>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <!-- Modal Archivos-->
    <div width="50%" class="modal fade" id="modalCargarArchivos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form id="formSubir" action="subir" name="frm_1" class="form-block" enctype="multipart/form-data">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div style="background: linear-gradient(90deg, #b4c1d9, #b4c1d9);" class="modal-content">
                    <div class="modal-header">
                        <h5 style="color:#98040a;font-size:20px;font-weight:bold;" class="modal-title" id="exampleModalLabel">Subir Archivos</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div style="background: linear-gradient(90deg, #b2b8bc, #dbddde);" class="card-body">
                            <input hidden="true" type="text" id="ruta" name="ruta">
                            <div class="form-group col-12">
                                <div class="row">
                                    <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-12">
                                        <label>Archivo a Subir:</label>
                                        <input class="form-control form-control-sm" placeholder="Buscar" readonly id="fileText" name="fileText"></>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-12">
                                        </br>
                                        <label for="inputFile" class="btn btn-primary form-control-sm">&#128193;Subir</label>
                                        <input hidden="true" type="file" id="inputFile" name="inputFile">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-12">
                                        <progress id="progressBar" value="0" max="100" class="progressBar col-sm-12"></progress>
                                        <button id="btnEnviar" class="btn btn-success col-sm-12">Enviar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <script src="<?php echo base_url(); ?>/js/obtenerTexto.js"></script>
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
        });

        $('#btn_cargarLibreta').click(function() {
            var path_files = 'image/personal/libreta_militar/';
            var file_name = numero_libreta.value;
            document.getElementById("ruta").value = path_files;
        });

        $('#btn_cargarCertificado').click(function() {
            var path_files = 'image/personal/certificacion_bancaria/';
            var file_name = cuenta_pago.value;
            document.getElementById("ruta").value = path_files;
        });

        const btnEnviar = document.getElementById('#btnEnviar');
        const inputFile = document.querySelector("#inputFile");

        //btnEnviar.addEventListener("click", function() {

        $('#btnEnviar').click(function() {

            if (inputFile.files.length > 0) {
                let formData = new FormData();
                formData.append("archivo", inputFile.files[0]); // En la posición 0; es decir, el primer elemento  

                fetch("subir", {
                        method: 'POST',
                        body: formData,
                    })
                    .then(respuesta => respuesta.text())
                    .then(decodificado => {
                        console.log(decodificado);
                    });
            } else {
                // El usuario no ha seleccionado archivo
                swal('', 'Debes Seleccionar un Archivo', 'error');
            }
        });
    </script>