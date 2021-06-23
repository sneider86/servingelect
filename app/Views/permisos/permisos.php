<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid ">
            <div class="row">
                <h5 class="mt-4"><?php echo $titulo; ?></h5>
                <form action="" style="display: grid;grid-template-columns: 500px 1fr">
                    <fieldset style="float: left;width: 90%;">
                        <div class="card shadow-lg border-1 rounded-lg mt-1">
                            <div style="background: linear-gradient(90deg, #b2b8bc, #b2b8bc);" class="card-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-12">
                                            <label>Roles</label>
                                            <select class="form-control form-control-sm" id="rol" name="rol" type="text" onchange="mostrarPermisos();">
                                                <option value="">Seleccionar</option>
                                                <?php foreach ($roles as $row) { ?>
                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-12">
                                            <label>Módulos</label>
                                            <select class="form-control form-control-sm" id="modulos" name="modulos" type="text" onchange="mostrarAccion();" required>
                                                <option value="">Seleccionar</option>
                                                <?php foreach ($modulos as $row) { ?>
                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="table-responsive" style="width:100%; height:250px; overflow: scroll-verticall;">
                                        <table class="table table-bordered table-sm table-striped" width="100%" cellspacing="0">
                                            <thead>
                                                <tr style=" font-family:Arial;color:#98040a;font-weight:300;text-align:center;font-size:14px;">
                                                    <th>Id</th>
                                                    <th>Acción</th>
                                                    <th><input type="checkbox" class="switch" id="switch" name="switch">
                                                </tr>
                                            </thead>
                                            <tbody id="tbl_acciones" style="font-family:Arial;font-size:12px;">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset style="float: left;width: 140%;">
                        <div class="card shadow-lg border-1 rounded-lg mt-1">
                            <div style="background: linear-gradient(90deg, #b2b8bc, #b2b8bc);" class="card-body">
                                <div class="form-group ">
                                    <div class="row">
                                        <a href="<?php echo base_url(); ?>/principal" style="height:2rem;width:6rem;" class="btn btn-primary form-control-sm">Regresar</a>

                                        <input <?php echo $agregar; ?> style="height:2rem;width:6rem;" class="btn btn-success" id="pasar" value="Agregar">

                                        <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-12">
                                            <br>
                                            <h5 class="mt-2"><?php echo 'Lista de Autorizaciones'; ?></h5>
                                        </div>
                                    </div>

                                    <div class="table-responsive" style="width:100%; height:300px; overflow: scroll-verticall;">
                                        <table class="table table-bordered table-sm table-striped" width="100%" cellspacing="0">
                                            <thead ">
                                            <tr style=" font-family:Arial;color:#98040a;font-weight:300;text-align:center;font-size:14px;">
                                                <th>Id</th>
                                                <th>Módulo</th>
                                                <th>Acción</th>
                                                <th>Estado</th>
                                                <!--<th><input type="checkbox" id="autoriza" name="autoriza">-->
                                                </tr>
                                            </thead>
                                            <tbody id="tbl_autoriza" style="font-family:Arial;font-size:12px;">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                </form>
            </div>
    </main>

    </html>
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

    <script>
        $(function() {
            $("#modulos").on("change", function() {
                var select = document.getElementById("modulos"), //El <select>
                    value = select.value, //El valor seleccionado
                    n_modulo = select.options[select.selectedIndex].innerText; //El texto de la opción seleccionada
            });
            $("#switch").on("change", function() {
                $("#tbl_acciones input[type='checkbox'].sw").prop("checked", this.checked);
            });

            $("#tbl_acciones tbody").on("change", "input[type='checkbox'].sw", function() {
                if ($("#tbl_acciones tbody input[type='checkbox'].sw").length == $("#tbl_acciones tbody input[type='checkbox'].sw:checked").length) {
                    $("#sw").prop("checked", true);
                } else {
                    $("#sw").prop("checked", false);
                }
            });

            $("#pasar").click(function() {

                var n_modulo, modulo, accion, chequeo, cod_modulo, id_accion, cod_rol, n_rol;
                var _row = '';
                var select = document.getElementById("modulos"), //El <select>
                    cod_modulo = select.value, //El valor seleccionado
                    n_modulo = select.options[select.selectedIndex].innerText; //El texto de la opción seleccionada

                var select2 = document.getElementById("rol"), //El <select>
                    cod_rol = select2.value, //El valor seleccionado
                    n_rol = select2.options[select2.selectedIndex].innerText; //El texto de la opción seleccionada                    

                modulo = n_modulo;
                //$('#tbl_autoriza').html('');
                $("#tbl_acciones input[type=checkbox]:checked").each(function() {
                    var _row = '';
                    var result = [];
                    var i = 1;
                    // buscamos el td más cercano en el DOM hacia "arriba"
                    // luego encontramos los td adyacentes a este
                    $(this).closest('td').siblings().each(function() {
                        result[i] = $(this).text();
                        ++i;
                    });
                    modulo = n_modulo;
                    accion = result[2];
                    id_accion = result[1];
                    var permiso = 1;
                    _row += '<tr><td>' + id_accion + '</td><td>' + modulo + '</td><td>' + accion + '</td><td style="text-align:center">' + `<input type="checkbox" checked>` + '</td></tr>';
                    $('#tbl_autoriza').append(_row);
                    cadena = "id_usuario=" + cod_rol +
                        "&id_accion=" + id_accion +
                        "&permiso=" + permiso;
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>/permisos/insertar/" + cod_rol + '/' + id_accion + "/" + permiso,
                        data: 'cadena',
                        success: function(r) {}
                    })
                });

            });

        });

        function mostrarAccion() {
            rol = document.getElementById("rol").value;
            modulo = document.getElementById("modulos").value;
            $.ajax({
                type: "PATH",
                url: "<?php echo base_url(); ?>/permisos/buscar_Acciones/" + modulo + '/' + rol,
                dataType: "json",
                success: function(r) {
                    if (r.length != 0) {
                        //if (r) {
                        $("#tbl_acciones").html("");
                        for (var i = 0; i < r[0].length; i++) {
                            var tr = `<tr>
                            <td>` + r[0][i]['id'] + `</td>
                            <td>` + r[0][i]['nombre'] + `</td>
                            <td style="text-align:center">` + `<input type="checkbox" class="sw">` + `</td>
                            </tr>`;
                            $("#tbl_acciones").append(tr)
                        }
                        //}
                    } else {
                        swal('', 'No Existen Acciones Generadas para éste Módulo. Informe', '');
                    }
                }
            })
        }

        function mostrarPermisos() {
            rol = document.getElementById("rol").value;
            $("#tbl_acciones").html("");
            $.ajax({
                type: "PATH",
                url: "<?php echo base_url(); ?>/permisos/buscar_Permisos/" + rol,
                dataType: "json",
                success: function(r) {
                    console.log(r);
                    if (r.length != 0) {
                        $("#tbl_autoriza").html("");

                        for (var i = 0; i < r[0].length; i++) {
                            if (r[0][i]['permiso'] == 1) {
                                estado = 'checked'
                            } else {
                                estado = 'unchecked'
                            }
                            var tr = `<tr>
                            <td>` + r[0][i]['id_accion'] + `</td>
                            <td>` + r[0][i]['nombre_modulo'] + `</td>
                            <td>` + r[0][i]['nombre_accion'] + `</td>
                            <td style="text-align:center">` + `<input <?php echo $agregar; ?> type="checkbox" class="sw"` + estado + `>` + `</td>
                            </tr>`;
                            $("#tbl_autoriza").append(tr)
                        }
                    }
                }
            })
        }
    </script>