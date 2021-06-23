<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <!--<h5 class="mt-4"><?php echo $titulo; ?></h5>-->
            <!--con este php mostramos los errores que se presenten -->
            <?php if (isset($validation)) { ?>
                <div class="alert alert-danger">
                    <?php echo $validation->listErrors(); ?>
                </div>
            <?php } ?>  
            <form name="f1" id="nuevoCliente" method="POST" action="<?php echo base_url(); ?>/terceros/insertar" autocomplete="off">
                <div class="card shadow-lg border-1 rounded-lg mt-3">
                    <div style="background: linear-gradient(90deg, #6484a5, #22a7bf);">
                        <h3 style="font-weight: bold;font-size:22px;" class="text-center my-2"><?php echo $titulo; ?></h3>
                    </div>
                    <div style="background: linear-gradient(90deg, #b2b8bc, #dbddde);" class="card-body">
                        <div class="form-group col-12">
                            <div class="row">
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-3">
                                    <label>Tipo de Documento</label>
                                    <select class="form-control form-control-sm" id="tipo_documento" name="tipo_documento" type="text" required>
                                        <option value="">Seleccionar</option>
                                        <?php foreach ($tipo_documento as $parametro) { ?>
                                            <option value="<?php echo $parametro['id']; ?>"><?php echo $parametro['valor']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-3">
                                    <label>Número de Documento</label>
                                    <div class="input-group">
                                        <input class="form-control form-control-sm" id="numero_documento" name="numero_documento" type="text" required onblur=buscar_Documento(this.value) ></>
                                         <!--
                                        <span class="input-group-btn">
                                            <button disabled title="Cargar Documento en PDF" href="" class="btn btn-success  form-control-sm" type="button" id="btn_cargarDocumento"><i disabled class="fas fa-upload" data-toggle="modal" data-target="#modalCargarArchivos" onclick="ruta_Documento();" ></i></button>
                                            <!--
                                            <button title="Ver PDF Documento" href="" class="btn btn-success  form-control-sm" type="button" id="btn_ver"><i class="fas fa-search"></i></button>
                                           
                                        </span>
                                        -->
                                    </div>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-3">
                                    <label>Dígito de Verificación</label>
                                    <input class="form-control form-control-sm" id="dv" name="dv" type="text" disabled="true"></>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-3">
                                    <label>Tipo de Tercero</label>
                                    <select class="form-control form-control-sm" id="tipo_tercero" name="tipo_tercero" type="text" required>
                                        <option value="">Seleccionar</option>
                                        <?php foreach ($tipo_tercero as $tipotercero) { ?>
                                            <option value="<?php echo $tipotercero['id']; ?>"><?php echo $tipotercero['valor']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-6">
                                    <label>Primer Nombre</label>
                                    <input class="form-control form-control-sm" onKeyUp="mayus(this);" id="p_nombre" name="p_nombre" type="text" onblur="document.getElementById('razon_social').value=this.value"></>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-6">
                                    <label>Segundo Nombre</label>
                                    <input class="form-control form-control-sm" onKeyUp="mayus(this);" id="s_nombre" name="s_nombre" type="text" onblur="document.getElementById('razon_social').value = document.getElementById('p_nombre').value + ' ' + this.value"></>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-6">
                                    <label>Primer Apellido</label>
                                    <input class="form-control form-control-sm" onKeyUp="mayus(this);" id="p_apellido" name="p_apellido" type="text" onblur="document.getElementById('razon_social').value = document.getElementById('p_nombre').value + ' ' + document.getElementById('s_nombre').value + ' ' + this.value"></>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-6">
                                    <label>Segundo Apellido</label>
                                    <input class="form-control form-control-sm" onKeyUp="mayus(this);" id="s_apellido" name="s_apellido" type="text" onblur="document.getElementById('razon_social').value = document.getElementById('p_nombre').value + ' ' + document.getElementById('s_nombre').value + ' ' + document.getElementById('s_apellido').value + ' ' + this.value"></>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-xs-12 col-sm-12">
                                    <label>Razón Social</label>
                                    <input class="form-control form-control-sm" onKeyUp="mayus(this);" id="razon_social" name="razon_social" type="text"></>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <label>Dirección</label>
                                    <input class="form-control form-control-sm" id="direccion" name="direccion" type="text"></>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label>País</label>
                                    <select class="form-control form-control-sm" id="pais" name="pais" type="text" selected="selected" required>
                                        <option value="">Seleccionar</option>
                                        <?php foreach ($pais as $row) { ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <label>Departamento</label>
                                        <select class="form-control form-control-sm" id="departamento" name="departamento" type="text" required>
                                            <option value="">Seleccionar</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <label>Municipio</label>
                                        <select class="form-control form-control-sm" id="municipio" name="municipio" type="text" required>
                                            <option value="">Seleccionar</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-6">
                                    <label>Correos Electrónicos</label>
                                    <div class="input-group">
                                        <input class="form-control form-control-sm" disabled="true" id="inp_email" name="temail" type="email"></>
                                        <span class="input-group-btn">
                                            <button title="Ingresar Correos Electrónicos del Tercero" href="" class="btn btn-success  form-control-sm" type="button" id="btn_email" data-toggle="modal" data-target="#modalEmail"><span class=" fas fa-at"></span></button>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-3">
                                    <label>Teléfonos Fijos</label>
                                    <div class="input-group">
                                        <input class="form-control form-control-sm" disabled="true" id="inp_fijo" name="inp_fijo" type="text"></>
                                        <span class="input-group-btn">
                                            <button title="Ingresar Teléfonos Fijos del Tercero" href="" class="btn btn-success  form-control-sm" type="button" id="btn_fijo" data-toggle="modal" data-target="#modalTelefono"><span class=" fas fa-tty"></span></button>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-3">
                                    <label>Teléfonos Celulares</label>
                                    <div class="input-group">
                                        <input class="form-control form-control-sm" disabled="true" id="inp_celular" name="inp_celular" type="text"></>
                                        <span class="input-group-btn">
                                            <button title="Ingresar Teléfonos Celulares del Tercero" href="" class="btn btn-success  form-control-sm" type="button" id="btn_celular" data-toggle="modal" data-target="#modalCelular"><span class=" fas fa-mobile-alt"></span></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-5ths col-lg-5ths col-xs-12 col-sm-12">
                                    <label>Actividades Económicas</label>
                                    <div class="input-group">
                                        <input class="form-control form-control-sm" disabled="true" id="inp_actividad" name="inp_actividad" type="text"></>
                                        <span class="input-group-btn">
                                            <button title="Ingresar Actividad Económica del Tercero" href="" class="btn btn-success  form-control-sm" type="button" id="btn_actividad" data-toggle="modal" data-target="#modalActividad"><span class=" fab fa-battle-net"></span></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <label>Responsabilidad Tributaria</label>
                                        <div class="input-group">
                                            <select class="form-control form-control-sm" id="responsabilidad" name="responsabilidad" type="text" required>
                                                <option value="">Seleccionar</option>
                                                <?php foreach ($responsabilidades as $row) { ?>
                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['codigo'] . ' - ' . $row['nombre']; ?></option>
                                                <?php } ?>
                                            </select>
                                            <!--
                                            <span class="input-group-btn">
                                                <button title="Cargar Cámara de Comercio del Tercero" href="" src="<?php echo base_url(); ?>/image/trash.png" class="btn btn-success  form-control-sm" data-toggle="modal" data-target="#modalCargarArchivos" onclick="ruta_camaraComercio();" type="button" id="btn_rut"><i class="fas fa-upload" data-toggle="modal" data-target="#modalCargarArchivos" onclick="ruta_camaraComercio();" ></i>Cam.Com.</button>
                                            </span>
                                                -->
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-6">
                                        <label>Regimen de IVA</label>
                                        <div class="input-group">
                                            <select class="form-control form-control-sm" id="regimen" name="regimen" type="text" required>
                                                <option value="">Seleccionar</option>
                                                <?php foreach ($regimenes as $row) { ?>
                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['id'] . ' - ' . $row['nombre']; ?></option>
                                                <?php } ?>
                                            </select>
                                            <!--
                                            <span class="input-group-btn">
                                                <button title="Cargar RUT del Tercero" href="" src="<?php echo base_url(); ?>/image/trash.png" class="btn btn-success form-control-sm" onclick="ruta_Rut();" data-toggle="modal" data-target="#modalCargarArchivos" type="button" id="btn_rut"><i class="fas fa-upload" data-toggle="modal" data-target="#modalCargarArchivos" onclick="ruta_Rut();" ></i></span>Rut</button>
                                                
                                            </span>
                                                -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo base_url(); ?>/terceros" class="btn btn-primary">Regresar</a>
                        <button id="guardaCliente" type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </main>
    <!-- Modal Cargar Archivos-->
    <div width="50%" class="modal fade" id="modalCargarArchivos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form  method="POST" action="<?php echo base_url(); ?>/terceros/subir" name="frm_1" class="form-block" enctype="multipart/form-data">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div style="background: linear-gradient(90deg, #b4c1d9, #b4c1d9);" class="modal-content">
                    <div class="modal-header">
                        <h5 style="color:#98040a;font-size:20px;font-weight:bold;" class="modal-title" id="exampleModalLabel">Subir Archivo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div style="background: linear-gradient(90deg, #b2b8bc, #dbddde);" class="card-body">
                            <input hidden="true" type="text" id="docto" name="docto">
                            <input hidden="true" type="text" id="ruta" name="ruta">
                            <input hidden="true" type="text" id="prefijo" name="prefijo">
                            <div class="form-group col-12">
                                <div class="row">
                                    <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-12">
                                        <label>Archivo a Subir</label>
                                        <input class="form-control form-control-sm" placeholder="Buscar"  readonly id="fileText" name="fileText" ></>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-12">
                                        </br>
                                        <label for="inputFile" class="btn btn-primary form-control-sm">&#128193;Subir</label>
                                        <input hidden="true" type="file" id="inputFile" name="inputFile" onchange="upload_image();">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-12">
                                        <progress id="progressBar" value="0" max="100" class="progressBar col-sm-12"></progress>
                                        <button id="btnEnviar" class="btn btn-success col-sm-12" type="submit">Enviar</button>
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

    <!-- Modal Actividad-->
    <div class="modal fade" id="modalActividad" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form class="form-inline">
            <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
                <div style="background: linear-gradient(90deg, #b4c1d9, #b4c1d9);" class="modal-content">
                    <div class="modal-header">
                        <h5 style="color:#98040a;font-size:20px;font-weight:bold;" class="modal-title" id="exampleModalLabel">Agregar Actividades</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div style="background: linear-gradient(90deg, #b2b8bc, #dbddde);" class="card-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-5ths col-lg-5ths col-xs-8 col-sm-8">
                                        <input hidden="true" class="form-control form-control-sm" id="cd" name="cd" type="texto" required></>
                                        <label>Actividad</label>
                                        <div class="input-group">
                                            <select class="form-control form-control-sm" id="sel_actividad" name="sel_actividad" type="text" selected="selected" required>
                                                <option value="">Seleccionar</option>
                                                <?php foreach ($actividades as $row) { ?>
                                                    <option value="<?php echo $row['codigo']; ?>"><?php echo $row['codigo'] . '-' . $row['nombre']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-5ths col-lg-5ths col-xs-2 col-sm-2">
                                        <label>Fecha Inicio Act</label>
                                        <input class="form-control form-control-sm" id="fecha" name="fecha" type="date" required></>
                                    </div>
                                    <div class="col-md-5ths col-lg-5ths col-xs-2 col-sm-2">
                                        <label>Orden</label>
                                        <div class="input-group">
                                            <select class="form-control form-control-sm" id="orden4" name="orden4" type="text" required>
                                                <option value="P">Principal</option>
                                                <option value="S">Secundario</option>
                                            </select>
                                            <!--<span class="input-group-btn ">-->
                                            <button id="agregarActividad" type="button" class="btn btn-success form-control-sm">+ <span class="fab fa-battle-net"></span></button>
                                            <!--</span>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br />
                            <div id="adicionaActividad"></div>
                            <table id="tablaActividades" class="table table-bordered ">
                                <tr>
                                    <th>Código</th>
                                    <th>Actividad</th>
                                    <th>Fecha</th>
                                    <th>Orden</th>
                                    <th>Acción</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="ok_actividad" type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Modal Email-->
    <div class="modal fade" id="modalEmail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form class="form-inline">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div style="background: linear-gradient(90deg, #b4c1d9, #b4c1d9);" class="modal-content">
                    <div class="modal-header">
                        <h5 style="color:#98040a;font-size:20px;font-weight:bold;" class="modal-title" id="exampleModalLabel">Agregar Correos Electrónicos</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div style="background: linear-gradient(90deg, #b2b8bc, #dbddde);" class="card-body">
                            <div class="form-group" col-12>
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
                            <table id="tablaEmail" class="table table-bordered ">
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
    <!-- Modal Celular-->
    <div class="modal fade" id="modalCelular" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
    <!-- Modal Telefonos-->
    <div class="modal fade" id="modalTelefono" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
    <script>
        $(document).ready(function() {
            recargarDepartamentos('/terceros/getDepartamentos/');
            $('#pais').change(function() {
                recargarDepartamentos('/terceros/getDepartamentos/');
            });
            recargarMunicipios('/terceros/getMunicipios/');
            $('#departamento').change(function() {
                recargarMunicipios('/terceros/getMunicipios/');
            });
        })
        function buscar_Documento(codDocumento) {            
            tipoDocumento=document.getElementById("tipo_documento").value;
        $.ajax({            
            type: "PATH",
            url: "<?php echo base_url(); ?>/terceros/buscarDocumento/" + codDocumento + '/' + tipoDocumento,
            dataType: "json",
            success: function(r) {
                if (r[0][numero_documento]=codDocumento) {
                        swal('', 'Este Número de Documento (' + codDocumento + '), con éste Tipo de Documento ya Existe. Corrija', 'error');
                        document.getElementById("numero_documento").value ="";
                    } 
            }
        });
    };
        function ruta_camaraComercio() {
            document.getElementById("ruta").value = "image/terceros/camara_comercio/";
            document.getElementById("prefijo").value = "camCom_";
            document.getElementById("docto").value = "";
        };

        function ruta_Documento() {
            document.getElementById("ruta").value = "image/terceros/documento_identidad/";
            document.getElementById("prefijo").value = "DIden_";
            document.getElementById("docto").value = "";
        };

        function ruta_Rut() {
            document.getElementById("ruta").value = "image/terceros/rut/";
            document.getElementById("prefijo").value = "Rut_";
            document.getElementById("docto").value = '';
        };    
    </script>
    <script>
        var select = document.getElementById('tipo_tercero');
        select.addEventListener('change',
            function() {
                var selectedOption = this.options[select.selectedIndex];
                //console.log(selectedOption.value + ': ' + selectedOption.text);

                if (selectedOption.text == 'Persona Natural') {
                    document.getElementById("p_nombre").disabled = false;
                    document.getElementById("s_nombre").disabled = false;
                    document.getElementById("p_apellido").disabled = false;
                    document.getElementById("s_apellido").disabled = false;
                    document.getElementById("razon_social").disabled = true;

                } else {
                    document.getElementById("p_nombre").disabled = true;
                    document.getElementById("s_nombre").disabled = true;
                    document.getElementById("p_apellido").disabled = true;
                    document.getElementById("s_apellido").disabled = true;
                    document.getElementById("razon_social").disabled = false;
                }
            });
    </script>

