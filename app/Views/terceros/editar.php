<?php
$pdf_documento = "/image/terceros/documento_identidad/" . 'DIden_' . $datos['numero_documento'] . '.pdf';
$pdf_camara = "/image/terceros/camara_comercio/" . 'camCom_' . $datos['numero_documento'] . '.pdf';
$pdf_rut = "/image/terceros/rut/" . 'Rut_' . $datos['numero_documento'] . '.pdf';
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <!--<h5 class="mt-4"><?php echo $titulo; ?></h>-->
            <?php if (isset($validation)) { ?>
                <div class="alert alert-danger">
                    <?php echo $validation->listErrors(); ?>
                </div>
            <?php } ?>

            <form method="post" action="<?php echo base_url(); ?>/terceros/actualizar" autocomplete="off">
                <div class="card shadow-lg border-1 rounded-lg mt-3">
                    <div style="background: linear-gradient(90deg, #6484a5, #22a7bf);">
                        <h3 style="font-weight: bold;font-size:22px;" class="text-center my-2"><?php echo $titulo; ?></h3>
                    </div>
                    <input type="hidden" id="id" name="id" value="<?php echo $datos['tipo_documento']; ?>" />
                    <div style="background: linear-gradient(90deg, #b2b8bc, #dbddde);" class="card-body">
                        <div class="form-group col-12">
                            <div class="row">
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-3">
                                    <label>Tipo de Documento</label>
                                    <select class="form-control form-control-sm" id="tipo_documento" name="tipo_documento" type="text" required>
                                        <option value="">Seleccionar</option>
                                        <?php foreach ($tipo_documento as $row) { ?>
                                            <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $datos['tipo_documento']) {
                                                                                            echo 'selected';
                                                                                        } ?>><?php echo $row['valor']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-3">
                                    <label>Número de Documento</label>
                                    <div class="input-group">
                                        <input class="form-control form-control-sm" id="numero_documento" name="numero_documento" type="text" value="<?php echo $datos['numero_documento'] ?>" required></>
                                        <span class="input-group-btn">

                                            <button title="Cargar Documento en PDF" href="" class="btn btn-success  form-control-sm" type="button" id="btn_cargarDocumento"><i class="fas fa-upload" data-toggle="modal" data-target="#modalCargarArchivos" onclick="ruta_Documento();"></i></button>

                                            <button title="Ver PDF Documento" href="" class="btn btn-success  form-control-sm" type="button" data-toggle="modal" data-target="#modalPDF"><i class="fas fa-eye" onclick="ruta_Documento();"></i></button>

                                        </span>
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
                                        <?php foreach ($tipo_tercero as $row) { ?>
                                            <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $datos['tipo_tercero']) {
                                                                                            echo 'selected';
                                                                                        } ?>><?php echo $row['valor']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-6">
                                    <label>Primer Nombre</label>
                                    <input class="form-control form-control-sm" onKeyUp="mayus(this);" id="p_nombre" name="p_nombre" type="text" onblur="document.getElementById('razon_social').value=this.value" value="<?php echo $datos['p_nombre'] ?>"></>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-6">
                                    <label>Segundo Nombre</label>
                                    <input class="form-control form-control-sm" onKeyUp="mayus(this);" id="s_nombre" name="s_nombre" type="text" onblur="document.getElementById('razon_social').value = document.getElementById('p_nombre').value + ' ' + this.value" value="<?php echo $datos['s_nombre'] ?>"></>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-6">
                                    <label>Primer Apellido</label>
                                    <input class="form-control form-control-sm" onKeyUp="mayus(this);" id="p_apellido" name="p_apellido" type="text" onblur="document.getElementById('razon_social').value = document.getElementById('p_nombre').value + ' ' + document.getElementById('s_nombre').value + ' ' + this.value" value="<?php echo $datos['p_apellido'] ?>"></>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-6">
                                    <label>Segundo Apellido</label>
                                    <input class="form-control form-control-sm" onKeyUp="mayus(this);" id="s_apellido" name="s_apellido" type="text" onblur="document.getElementById('razon_social').value = document.getElementById('p_nombre').value + ' ' + document.getElementById('s_nombre').value + ' ' + document.getElementById('p_apellido').value + ' ' + this.value" value="<?php echo $datos['s_apellido'] ?>"></>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-xs-12 col-sm-12">
                                    <label>Razón Social</label>
                                    <input class="form-control form-control-sm" onKeyUp="mayus(this);" id="razon_social" name="razon_social" type="text" value="<?php echo $datos['razon_social'] ?>"></>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <label>Dirección</label>
                                    <input class="form-control form-control-sm" id="direccion" name="direccion" type="text" value="<?php echo $datos['direccion'] ?>"></>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label>País</label>
                                    <select class="form-control form-control-sm" id="pais" name="pais" type="text" selected="selected" required>
                                        <option value="">Seleccionar</option>
                                        <?php foreach ($pais as $row) { ?>
                                            <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $datos['pais']) {
                                                                                            echo 'selected';
                                                                                        } ?>><?php echo $row['nombre']; ?></option>
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
                                            <?php foreach ($departamentos as $row) { ?>
                                                <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $datos['departamento']) {
                                                                                                echo 'selected';
                                                                                            } ?>><?php echo $row['nombre']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <label>Municipio</label>
                                        <select class="form-control form-control-sm" id="municipio" name="municipio" type="text" required>
                                            <option value="">Seleccionar</option>
                                            <?php foreach ($municipios as $row) { ?>
                                                <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $datos['municipio']) {
                                                                                                echo 'selected';
                                                                                            } ?>><?php echo $row['nombre']; ?></option>
                                            <?php } ?>
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
                                        <input class="form-control form-control-sm" disabled="true" id="inp_email" name="temail" type="email" value="<?php echo $correos_telefonos['valor']; ?>"></>
                                        <span class="input-group-btn">
                                            <button title="Ingresar Correos Electrónicos del Tercero" href="" class="btn btn-success  form-control-sm" type="button" id="btn_email" data-toggle="modal" data-target="#modalEmail"><span class=" fas fa-at"></span></button>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-3">
                                    <label>Teléfonos Fijos</label>
                                    <div class="input-group">
                                        <input class="form-control form-control-sm" disabled="true" id="inp_fijo" name="inp_fijo" type="text" value="<?php echo $telefono_fijo['valor']; ?>"></>
                                        <span class="input-group-btn">
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-3">
                                    <label>Teléfonos Celulares</label>
                                    <div class="input-group">
                                        <input class="form-control form-control-sm" disabled="true" id="inp_celular" name="inp_celular" type="text" value="<?php echo $telefono_movil['valor']; ?>"></>
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
                                        <input class="form-control form-control-sm" disabled="true" id="inp_actividad" name="inp_actividad" type="text" value="<?php echo $actividad['valor']; ?>"></>

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
                                                    <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $datos['responsabilidad']) {
                                                                                                    echo 'selected';
                                                                                                } ?>><?php echo $row['codigo'] . ' - ' . $row['nombre']; ?></option>
                                                <?php } ?>

                                            </select>
                                            <button title="Cargar Cámara de Comercio del Tercero" href="" class="btn btn-success  form-control-sm" type="button" id="btn_cargarDocumento"><i class="fas fa-upload" data-toggle="modal" data-target="#modalCargarArchivos" onclick="ruta_camaraComercio();"></i></button>

                                            <button title="Ver PDF Cámara Comercio" href="" class="btn btn-success  form-control-sm" type="button" data-toggle="modal" data-target="#modalCamara"><i class="fas fa-eye" onclick="ruta_camaraComercio();"></i></button>

                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-6">
                                        <label>Regimen de IVA</label>
                                        <div class="input-group">
                                            <select class="form-control form-control-sm" id="regimen" name="regimen" type="text" required>
                                                <option value="">Seleccionar</option>
                                                <?php foreach ($regimenes as $row) { ?>
                                                    <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $datos['regimen']) {
                                                                                                    echo 'selected';
                                                                                                } ?>><?php echo $row['id'] . ' - ' . $row['nombre']; ?></option>
                                                <?php } ?>
                                            </select>

                                            <button title="Cargar RUT del Tercero" href="" class="btn btn-success  form-control-sm" type="button" id="btn_cargarDocumento"><i class="fas fa-upload" data-toggle="modal" data-target="#modalCargarArchivos" onclick="ruta_Rut();"></i></button>

                                            <button title="Ver RUT del Tercero" href="" class="btn btn-success  form-control-sm" type="button" data-toggle="modal" data-target="#modalRut"><i class="fas fa-eye" onclick="ruta_Rut();"></i></button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo base_url(); ?>/terceros" style="height:2rem;width:6rem;" class="btn btn-primary">Regresar</a>
                        <button <?php echo $actualizar; ?> style="height:2rem;width:6rem;" id="guardaCliente" type="submit" class="btn btn-success">Actualizar</button>


                    </div>
            </form>
        </div>
    </main>

<!-- Modal Cargar Archivos-->
<div width="50%" class="modal fade" id="modalCargarArchivos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form  method="POST" action="<?php echo base_url(); ?>/terceros/subir" id="form1" name="form1" class="form-block" enctype="multipart/form-data">
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
                                        <input type="file" id="inputFile" name="inputFile" onchange="upload_image();">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-12">
                                        <progress id="progressBar" value="0" max="100" class="progressBar col-sm-12"></progress>
                                        <button id="btnEnviar" class="btn btn-success col-sm-12" onclick="onSubmitForm()" type="button">Enviar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Modal PDF Rut-->
    <div class="modal fade" id="modalRut" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form method="" action="" name="frm_rut" class="form-block" enctype="multipart/form-data">
            <div class="modal-dialog  modal-lg modal-fluid modal-notify modal-info" role="document">
                <div style="background: linear-gradient(90deg, #b4c1d9, #b4c1d9);" class="modal-content">
                    <div class="modal-header">
                        <h5 style="color:#98040a;font-size:20px;font-weight:bold;" class="modal-title" id="exampleModalLabel">Ver RUT (PDF)</h5>
                        <button id="btnCerrar" class="btn btn-success col-sm-3" onclick="cerrarModal()" type="button">Cerrar</button>
                    </div>
                    <div class="modal-body">
                        <div style="background: linear-gradient(90deg, #b2b8bc, #dbddde);" class="card-body">
                            <input hidden="true" type="text" id="docto" name="docto">
                            <input hidden="true" type="text" id="ruta" name="ruta">
                            <input hidden="true" type="text" id="prefijo" name="prefijo">
                            <object id="objeto" class="PDFdoc" width="100%" height="400px" type="application/pdf" data="<?php echo base_url(); ?><?php echo $pdf_rut ?>"></object>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>

    <!-- Modal PDF Camara Comercio-->
    <div class="modal fade" id="modalCamara" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form method="" action="" name="frm_camara" class="form-block" enctype="multipart/form-data">
            <div class="modal-dialog  modal-lg modal-fluid modal-notify modal-info" role="document">
                <div style="background: linear-gradient(90deg, #b4c1d9, #b4c1d9);" class="modal-content">
                    <div class="modal-header">
                        <h5 style="color:#98040a;font-size:20px;font-weight:bold;" class="modal-title" id="exampleModalLabel">Ver PDF (Cámara Comercio)</h5>
                        <button id="btnCerrar" class="btn btn-success col-sm-3" onclick="cerrarModal()" type="button">Cerrar</button>
                    </div>
                    <div class="modal-body">
                        <div style="background: linear-gradient(90deg, #b2b8bc, #dbddde);" class="card-body">
                            <input hidden="true" type="text" id="docto" name="docto">
                            <input hidden="true" type="text" id="ruta" name="ruta">
                            <input hidden="true" type="text" id="prefijo" name="prefijo">
                            <object id="objeto" class="PDFdoc" width="100%" height="400px" type="application/pdf" data="<?php echo base_url(); ?><?php echo $pdf_camara ?>"></object>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Modal PDF Documento-->
    <div class="modal fade" id="modalPDF" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form method="" action="" name="frm_documento" class="form-block" enctype="multipart/form-data">
            <div class="modal-dialog  modal-lg modal-fluid modal-notify modal-info" role="document">
                <div style="background: linear-gradient(90deg, #b4c1d9, #b4c1d9);" class="modal-content">
                    <div class="modal-header">
                        <h5 style="color:#98040a;font-size:20px;font-weight:bold;" class="modal-title" id="exampleModalLabel">Ver PDF(Doc. Identidad)</h5>
                        <button id="btnCerrar" class="btn btn-success col-sm-3" onclick="cerrarModal()" type="button">Cerrar</button>
                    </div>
                    <div class="modal-body">
                        <div style="background: linear-gradient(90deg, #b2b8bc, #dbddde);" class="card-body">
                            <input hidden="true" type="text" id="docto" name="docto">
                            <input hidden="true" type="text" id="ruta" name="ruta">
                            <input hidden="true" type="text" id="prefijo" name="prefijo">
                            <object id="objeto" class="PDFdoc" width="100%" height="400px" type="application/pdf" data="<?php echo base_url(); ?><?php echo $pdf_documento ?>"></object>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script language="javascript" type="text/javascript">
        $(document).ready(function() {

        });

        function cerrarModal() {
            $('#objeto').val='';
            $('#frm_rut').trigger('reset');
            $('#frm_camara').trigger('reset');
            $('#frm_documento').trigger('reset');
            $("#modalRut").modal('hide');
            $("#modalCamara").modal('hide');
            $("#modalPDF").modal('hide');
        }
        function onSubmitForm(){            
            var frm = document.getElementById('form1');
            var data = new FormData(frm);
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function(){
                if(this.readyState == 4){
                    var msg = xhttp.responseText;
                    if(msg =='success'){
                        alert(msg);
                        $("#modalCargarArchivos").modal('hide');
                    }
                }
            };
            xhttp.open('POST',"<?php echo base_url(); ?>/terceros/subir",true);
            xhttp.send(data);
            $('#form1').trigger('reset');
            $("#modalCargarArchivos").modal('hide');
            //$('body').removeClass('modal-open');
            //$('.modal-backdrop').remove();
        }
        function ruta_camaraComercio() {
            document.getElementById("ruta").value = "image/terceros/camara_comercio/";
            document.getElementById("prefijo").value = "camCom_";
            document.getElementById("docto").value = "";
        }

        function ruta_Documento() {
            document.getElementById("ruta").value = "image/terceros/documento_identidad/";
            document.getElementById("prefijo").value = "DIden_";
            document.getElementById("docto").value = "";
        }

        function ruta_Rut() {
            document.getElementById("ruta").value = "image/terceros/rut/";
            document.getElementById("prefijo").value = "Rut_";
            document.getElementById("docto").value = '';
        }
    </script>