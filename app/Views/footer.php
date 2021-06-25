<div>

    <link href="<?php echo base_url(); ?>/css/styles.css" rel="stylesheet" />
    <script src="<?php echo base_url(); ?>/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>/js/scripts.js"></script>
    <script src="<?php echo base_url(); ?>/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/demo/datatables-demo.js"></script>
    <script src="<?php echo base_url(); ?>/js/funciones.js"></script>

</div>

<script>
    $('#modal-confirma').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });

    function recargarDepartamentos(ruta) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>" + ruta + $('#pais').val(),
            data: "codpais=" + $('#pais').val(),
            success: function(r) {
                $('#departamento').html(r);
            }
        });
    };

    function recargarMunicipios(ruta) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>" + ruta + $('#departamento').val(),
            data: "coddepartamento=" + $('#departamento').val(),
            success: function(r) {
                $('#municipio').html(r);
            }
        });
    };

    function buscarRegistro(ruta, registro) {
        id = document.getElementById("id").value;
        if (id != 0) {
            $.ajax({
                type: "PATH",
                url: "<?php echo base_url(); ?>" + ruta + id,
                dataType: "json",
                success: function(r) {
                    console.log(r[0]["id_tercero"]);
                    if (r[0]["id_tercero"] == id) {
                        swal('', 'Ya Existe un Registro de ' + registro + ' para este Tercero', 'error');
                        $("#id").val("");
                        $("#numero_documento").val("");
                        $("#razon_social").val("");
                        $("#razon_social").focus();
                    }
                }
            })
        }
    };

    function recargarGrupos($campo1, $campo2, $ruta) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>" + $ruta + $('#' + $campo1).val(),
            data: "$campo1=" + $('#' + $campo1).val(),
            success: function(r) {
                $('#' + $campo2).html(r);
            }
        });
    }

    function mayus(e) {
        e.value = e.value.toUpperCase();
    }

    function mensaje_Error(mensaje) {
        swal('', mensaje, 'error');
    }
    $('#agregarEmail').click(function() {
        var valor = document.getElementById("email").value;
        var orden = document.getElementById("orden2").value;
        var extension = 0;
        var fecha = new Date(); //Fecha actual
        var clave = 'E';
        fecha = extraeFecha(fecha);
        var nFilas = $("#tablaEmail tr").length;
        var sw = false;
        if (verificar(nFilas, 0, valor, "tablaEmail", valor)) {
            var sw = false;
            if (verificar(nFilas, 1, orden, "tablaEmail", 'P')) {
                if (valor.length > 0) {
                    if (orden.length > 0) {
                        //var i = 1; //contador para asignar id al boton que borrara la fila
                        var i = $("#tablaEmail tr").length + 1;
                        var fila = '<tr id="row' + i + '"><td>' + valor + '</td><td>' + orden + '</td><td><button  type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">Quitar</button></td></tr>'; //esto seria lo que contendria la fila
                        //i++;
                        $('#tablaEmail tr:last').after(fila);
                        $("#adicionaEmail").text(""); //esta instruccion limpia el div adicioandos para que no se vayan acumulando
                        var nFilas = $("#tablaEmail tr").length;
                        //$("#adicionaEmail").append(nFilas - 1);
                        //le resto 1 para no contar la fila del header
                        document.getElementById("email").value = "";
                        //document.getElementById("orden2").value = "";
                        document.getElementById("email").focus();
                        cadena = "valor=" + valor +
                            "&extension=" + extension +
                            "&orden=" + orden +
                            "&tipo=" + tipo +
                            "&indicativo=" + indicativo +
                            "&fecha=" + fecha;
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url(); ?>/temporal/insertar/" + indicativo + "/" + valor + "/" + extension + "/" + orden + "/" + tipo + "/" + fecha + "/" + clave,
                            data: cadena,
                            success: function(r) {}
                        })
                    } else {
                        swal('', 'Debe Seleccionar la Prioridad', 'error');
                    }
                } else {
                    swal('', 'Debe Ingresar el Correo Electrónico', 'error');
                }
            } else {
                swal('', 'Solo Puede Tener un Correo Principal en la Lista', 'error');
            }
        } else {
            swal('', 'Ya existe este Correo en la Lista', 'error');
        }
    });

    $(document).on('click', '.btn_remove', function() {
        var button_id = $(this).attr("id");
        var valores = new Array();
        i = 0;
        $(this).parents("tr").find("td").each(function() {
            valores[i] = $(this).html();
            i++;
        });
        numTel = valores[0];
        $('#row' + button_id + '').remove(); //borra la fila
        $("#adicionaEmail").text("");
        var nFilas = $("#tablaEmail tr").length;
        var valor = document.getElementById("email").value;
        var extension = 0;
        var indicativo = "035";
        var orden = document.getElementById("email").value;

        cadena = "valor=" + valor +
            "&extension=" + extension +
            "&orden=" + orden +
            "&tipo=" + tipo +
            "&indicativo=" + indicativo;

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>/temporal/eliminar/" + numTel + '/' + 'valor',
            data: cadena,
            success: function(r) {
                if (!r) {
                    swal('', 'Registro Eliminado Satisfactoriamente...', '');
                } else {
                    swal('', 'No se Pudo Eliminar el Registro. Informe!', 'error');
                }
            }
        })
    });

    $('#agregar').click(function() {
        var valor = document.getElementById("valor").value;
        var extension = document.getElementById("extension").value;
        var orden = document.getElementById("orden").value;
        var indicativo = document.getElementById("indicativo").value;
        var fecha = new Date(); //Fecha actual
        var clave = 'F';
        fecha = extraeFecha(fecha);
        var sw = false;
        var nFilas = $("#tablaTelefonos tr").length;
        if (verificar(nFilas, 1, valor, "tablaTelefonos", valor)) {
            var sw = false;
            if (verificar(nFilas, 3, orden, "tablaTelefonos", 'P')) {
                if (indicativo.length > 0) {
                    if (valor.length > 0) {
                        if (extension.length > 0) {
                            if (orden.length > 0) {
                                //var i = 1; //contador para asignar id al boton que borrara la fila
                                var i = $("#tablaTelefonos tr").length + 1;
                                var fila = '<tr id="row' + i + '"><td>' + indicativo + '</td><td>' + valor + '</td><td>' + extension + '</td><td>' + orden + '</td><td>' + tipo + '</td><td><button  type="button" name="remove" id="' + i + '" class="btn btn-danger btn_removeT">Quitar</button></td></tr>'; //esto seria lo que contendria la fila
                                //i++;
                                $('#tablaTelefonos tr:last').after(fila);
                                $("#adicionados").text(""); //esta instruccion limpia el div adicioandos para que no se vayan acumulando
                                var nFilas = $("#tablaTelefonos tr").length;
                                //$("#adicionados").append(nFilas - 1);
                                //le resto 1 para no contar la fila del header
                                document.getElementById("valor").value = "";
                                document.getElementById("extension").value = "0";
                                document.getElementById("indicativo").value = "035";
                                //document.getElementById("orden").value = "";
                                document.getElementById("valor").focus();

                                cadena = "valor=" + valor +
                                    "&extension=" + extension +
                                    "&orden=" + orden +
                                    "&tipo=" + tipo +
                                    "&indicativo=" + indicativo;

                                $.ajax({
                                    type: "POST",
                                    url: "<?php echo base_url(); ?>/temporal/insertar/" + indicativo + "/" + valor + "/" + extension + "/" + orden + "/" + tipo + "/" + fecha + "/" + clave,
                                    data: cadena,
                                    success: function(r) {

                                    }
                                })
                            } else {
                                swal('', 'Debe Seleccionar la Prioridad', 'error');
                            }
                        } else {
                            swal('', 'Debe Ingresar el(los) Números de Extension, si no Hay Coloque 0', 'error');
                        }
                    } else {
                        swal('', 'Debe Ingresar el Número del Teléfono', 'error');
                    }
                } else {
                    swal('', 'Debe Ingresar el Indicativo del Teléfono', 'error');
                }
            } else {
                swal('', 'Solo Puede Tener un Teléfono Principal en la Lista', 'error');
            }
        } else {
            swal('', 'Ya Existe este Teléfono en la Lista', 'error');
        }
    });
    $(document).on('click', '.btn_removeT', function() {
        var button_id = $(this).attr("id");
        //var numTel = $("tr td")[0].innerHTML;
        var valores = new Array();
        i = 0;
        $(this).parents("tr").find("td").each(function() {
            valores[i] = $(this).html();
            i++;
        });
        numTel = valores[1];
        $('#row' + button_id + '').remove(); //borra la fila
        $("#adicionados").text("");
        var nFilas = $("#tablaTelefonos tr").length;
        var valor = document.getElementById("valor").value;
        var extension = document.getElementById("extension").value;
        var orden = document.getElementById("orden").value;
        cadena = "valor=" + valor +
            "&extension=" + extension +
            "&orden=" + orden +
            "&tipo=" + tipo;
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>/temporal/eliminar/" + numTel + '/' + 'valor',
            data: cadena,
            success: function(r) {
                if (!r) {
                    swal('', 'Registro Eliminado Satisfactoriamente...', '');
                } else {
                    swal('', 'No se Pudo Eliminar el Registro. Informe!', 'error');
                }
            }
        })
    });
    $('#agregarCelular').click(function() {
        var valor = document.getElementById("valor3").value;
        var extension = "0";
        var orden = document.getElementById("orden3").value;
        var indicativo = "035";
        var fecha = new Date(); //Fecha actual
        var clave = 'C';
        fecha = extraeFecha(fecha);
        var sw = false;
        var nFilas = $("#tablaCelulares tr").length;
        if (verificar(nFilas, 0, valor, "tablaCelulares", valor)) {
            var sw = false;
            if (verificar(nFilas, 1, orden, "tablaCelulares", 'P')) {
                if (valor.length > 0 && valor.length == 10) {
                    if (orden.length > 0) {
                        //var i = 1; //contador para asignar id al boton que borrara la fila
                        var i = $("#tablaCelulares tr").length + 1;
                        var fila = '<tr id="row' + i + '"><td>' + valor + '</td><td>' + orden + '</td><td>' + tipo + '</td><td><button  type="button" name="remove" id="' + i + '" class="btn btn-danger removeCelular">Quitar</button></td></tr>'; //esto seria lo que contendria la fila
                        //i++;
                        $('#tablaCelulares tr:first').after(fila);
                        $("#adicionaCelular").text(""); //esta instruccion limpia el div adicioandos para que no se vayan acumulando
                        var nFilas = $("#tablaCelulares tr").length;
                        //$("#adicionados").append(nFilas - 1);
                        //le resto 1 para no contar la fila del header
                        document.getElementById("valor3").value = "";
                        //document.getElementById("extension3").value = "0";
                        //document.getElementById("orden").value = "";
                        document.getElementById("valor3").focus();

                        cadena = "valor=" + valor +
                            "&extension=" + extension +
                            "&orden=" + orden +
                            "&tipo=" + tipo +
                            "&indicativo=" + indicativo;

                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url(); ?>/temporal/insertar/" + indicativo + "/" + valor + "/" + extension + "/" + orden + "/" + tipo + "/" + fecha + "/" + clave,
                            data: cadena,
                            success: function(r) {

                            }
                        })
                    } else {
                        swal('', 'Debe Seleccionar la Prioridad', 'error');
                    }
                } else {
                    swal('', 'Número de Teléfono Equivocado o sin Ingresar', 'error');
                }
            } else {
                swal('', 'Solo Puede Tener un Celular Principal en la Lista', 'error');
            }
        } else {
            swal('', 'Ya Existe este Celular en la Lista', 'error');
        }
    });
    $(document).on('click', '.removeCelular', function() {
        var button_id = $(this).attr("id");
        var valores = new Array();
        i = 0;
        tipo = "C";
        $(this).parents("tr").find("td").each(function() {
            valores[i] = $(this).html();
            i++;
        });
        numTel = valores[0];
        //cuando da click obtenemos el id del boton       
        $('#row' + button_id + '').remove(); //borra la fila
        //limpia el para que vuelva a contar las filas de la tabla
        $("#adicionaCelular").text("");
        var nFilas = $("#tablaTelefonos tr").length;
        //$("#adicionados").append(nFilas - 1);
        var valor = document.getElementById("valor").value;
        var extension = 0;
        var orden = document.getElementById("orden").value;

        cadena = "valor=" + valor +
            "&extension=0" +
            "&orden=" + orden +
            "&tipo=" + tipo;

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>/temporal/eliminar/" + numTel + '/' + 'valor',
            data: cadena,
            success: function(r) {
                if (!r) {
                    swal('', 'Registro Eliminado Satisfactoriamente...', '');
                } else {
                    swal('', 'No se Pudo Eliminar el Registro. Informe!', 'error');
                }
            },
            error: function() {
                console.log("No se ha podido obtener la información");
            }

        })
    });

    $("#sel_banco").change(function() {
        id_banco.value = $(this).val(); // Capturamos el valor del select
        txt_banco.value = $(this).find('option:selected').text(); // Capturamos el texto del option seleccionado
        //id_banco.value = valor;
        //txt_banco.value = texto;
    });

    $("#sel_tipoCta").change(function() {
        var valor_tipoCta = $(this).val(); // Capturamos el valor del select
        var texto_tipoCta = $(this).find('option:selected').text(); // Capturamos el texto del option seleccionado
        id_tipoCta.value = valor_tipoCta;
        txt_tipoCta.value = texto_tipoCta;
    });
    $(document).on('click', '.btn_removeCuenta', function() {
        var button_id = $(this).attr("id");
        //var numTel = $("tr td")[0].innerHTML;
        var valores = new Array();
        i = 0;
        $(this).parents("tr").find("td").each(function() {
            valores[i] = $(this).html();
            i++;
        });
        numTel = valores[2];

        $('#row' + button_id + '').remove(); //borra la fila
        $("#adicionaCuentas").text("");
        var nFilas = $("#tablaCuentas tr").length;
        var valor = valores[1];
        var extension = "0";
        var orden = document.getElementById("orden").value;
        cadena = "valor=" + valor +
            "&extension=" + extension +
            "&orden=" + orden;
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>/temporal/eliminar/" + numTel + '/' + 'extension',
            data: cadena,
            success: function(r) {
                if (!r) {
                    swal('', 'Registro Eliminado Satisfactoriamente...', '');
                } else {
                    swal('', 'No se Pudo Eliminar el Registro. Informe!', 'error');
                }
            }
        })
    });
    $('#agregarCuenta').click(function() {
        var texto = txt_banco.value; // Capturamos el valor del select
        var indicativo = id_banco.value; //document.getElementById("sel_banco").value;       
        var valor = texto.substring(3);
        var extension = document.getElementById("numero_cuenta").value;
        var orden = document.getElementById("orden4").value;
        var tipo = document.getElementById("sel_tipoCta").value;
        var texto = txt_tipoCta.value; // Capturamos el valor del select   
        var fecha = new Date(); //Fecha actual
        var clave = 'K';
        fecha = extraeFecha(fecha);
        var sw = false;
        var nFilas = $("#tablaCuentas tr").length;
        var sw = false;
        if (verificar(nFilas, 3, orden, "tablaCuentas", 'P')) {
            if (valor.length > 0) {
                if (extension.length > 0) {
                    if (tipo.length > 0) {
                        if (orden.length > 0) {
                            //var i = 1; //contador para asignar id al boton que borrara la fila
                            var i = $("#tablaCuentas tr").length + 1;
                            var fila = '<tr id="row' + i + '"><td>' + indicativo + '</td><td>' + valor + '</td><td>' + extension + '</td><td>' + texto + '</td><td>' + orden + '</td><td><button  type="button" name="remove" id="' + i + '" class="btn btn-danger btn_removeCuenta">Quitar</button></td></tr>'; //esto seria lo que contendria la fila
                            //i++;
                            $('#tablaCuentas tr:last').after(fila);
                            $("#adicionaCuentas").text(""); //esta instruccion limpia el div adicioandos para que no se vayan acumulando
                            var nFilas = $("#tablaCuentas tr").length;
                            //$("#adicionados").append(nFilas - 1);
                            //le resto 1 para no contar la fila del header
                            document.getElementById("sel_banco").value = "";
                            document.getElementById("numero_cuenta").value = "";
                            document.getElementById("extension").value = "0";
                            document.getElementById("sel_tipoCta").value = "";
                            //document.getElementById("orden").value = "";
                            document.getElementById("sel_banco").focus();

                            cadena = "valor=" + valor +
                                "&extension=" + extension +
                                "&orden=" + orden +
                                "&tipo=" + tipo +
                                "&indicativo=" + indicativo;

                            $.ajax({
                                type: "POST",
                                url: "<?php echo base_url(); ?>/temporal/insertar/" + indicativo + "/" + valor + "/" + extension + "/" + orden + "/" + tipo + "/" + fecha + "/" + clave,
                                data: cadena,
                                success: function(r) {}
                            })
                        } else {
                            swal('', 'Debe Seleccionar la Prioridad', 'error');
                        }
                    } else {
                        swal('', 'Debe Seleccionar el Tipo de la Cuenta', 'error');
                    }
                } else {
                    swal('', 'Debe Ingresar el Número de la Cuenta', 'error');
                }
            } else {
                swal('', 'Debe Seleccionar un Banco', 'error');
            }
        } else {
            swal('', 'Solo Puede Tener una Cuenta Principal en la Lista', 'error');
        }
    });


    function extraeFecha(fecha) {
        var mes = fecha.getMonth() + 1; //obteniendo mes
        var dia = fecha.getDate(); //obteniendo dia
        var ano = fecha.getFullYear(); //obteniendo año
        if (dia < 10) {
            dia = '0' + dia;
        }
        if (mes < 10) {
            mes = '0' + mes;
        }
        return ano + "-" + mes + "-" + dia;
    }

    function verificar(nFilas, j, valor, tabla, control) {
        var sw = false;
        var cont = 0;
        for (let i = 1; i < nFilas; i++) {
            if (document.getElementById(tabla).rows[i].cells[j].innerHTML == valor && document.getElementById(tabla).rows[i].cells[j].innerHTML == control) {
                return false;
            }
        }
        return true;
    };

    $('#btn_celular').click(function() {
        tipo = "C";
    });
    $('#btn_fijo').click(function() {
        tipo = "F";
    });
    $('#btn_email').click(function() {
        tipo = "E";
        indicativo = "0";
        fecha = "";
    });
    $('#btn_actividad').click(function() {
        tipo = "A";
    });
    $('#ok_email').click(function() {
        var nFilas = $("#tablaEmail tr").length;
        for (let i = 1; i < nFilas; i++) {
            if (document.getElementById("tablaEmail").rows[i].cells[1].innerHTML == 'P') {
                inp_email.value = document.getElementById("tablaEmail").rows[i].cells[0].innerHTML;
            }
        }
    });
    $('#ok_telefono').click(function() {
        var nFilas = $("#tablaTelefonos tr").length;
        for (let i = 1; i < nFilas; i++) {
            if (document.getElementById("tablaTelefonos").rows[i].cells[3].innerHTML == 'P') {
                inp_fijo.value = document.getElementById("tablaTelefonos").rows[i].cells[1].innerHTML;
            }
        }
    });
    $('#ok_celular').click(function() {
        var nFilas = $("#tablaCelulares tr").length;
        for (let i = 1; i < nFilas; i++) {
            if (document.getElementById("tablaCelulares").rows[i].cells[1].innerHTML == 'P') {
                inp_celular.value = document.getElementById("tablaCelulares").rows[i].cells[0].innerHTML;
            }
        }
    });
    $('#ok_actividad').click(function() {
        var nFilas = $("#tablaActividades tr").length;
        for (let i = 1; i < nFilas; i++) {
            if (document.getElementById("tablaActividades").rows[i].cells[3].innerHTML == 'P') {
                inp_actividad.value = document.getElementById("tablaActividades").rows[i].cells[1].innerHTML;
            }
        }
    });
    $('#ok_cuenta').click(function() {
        var nFilas = $("#tablaCuentas tr").length;
        for (let i = 1; i < nFilas; i++) {
            if (document.getElementById("tablaCuentas").rows[i].cells[4].innerHTML == 'P') {
                inp_cuenta.value = document.getElementById("tablaCuentas").rows[i].cells[2].innerHTML;
                inp_banco.value = document.getElementById("tablaCuentas").rows[i].cells[1].innerHTML;
                inp_tipo_cuenta.value = document.getElementById("tablaCuentas").rows[i].cells[3].innerHTML;
            }
        }
    });

    $("#sel_actividad").change(function() {
        var valor = $(this).val(); // Capturamos el valor del select
        var texto = $(this).find('option:selected').text(); // Capturamos el texto del option seleccionado
        cd.value = valor + '-' + texto;
    });
    $('#agregarActividad').click(function() {
        var texto = cd.value; // Capturamos el valor del select
        var codigo = texto.substring(0, 4);
        var valor = texto.substring(5);
        var fecha = document.getElementById("fecha").value;
        var orden = document.getElementById("orden4").value;
        var clave = 'A';
        var indicativo = 0;
        var sw = false;
        var nFilas = $("#tablaActividades tr").length;
        if (verificar(nFilas, 3, orden, "tablaActividades", 'P')) {
            var i = $("#tablaActividades tr").length + 1;
            var fila = '<tr id="row' + i + '"><td>' + codigo + '</td><td>' + valor + '</td><td>' + fecha + '</td><td>' + orden + '</td><td><button  type="button" name="remove" id="' + i + '" class="btn btn-danger removeActividad">Quitar</button></td></tr>'; //esto seria lo que contendria la fila
            //i++;
            $('#tablaActividades tr:last').after(fila);
            $("#adicionaActividad").text(""); //esta instruccion limpia el div adicioandos para que no se vayan acumulando
            var nFilas = $("#tablaActividades tr").length;
            document.getElementById("fecha").value = "";
            //document.getElementById("orden").value = "";
            document.getElementById("sel_actividad").focus();
            cadena = "extension=" + codigo +
                "&indicativo=" + indicativo +
                "&valor=" + valor +
                "&fecha=" + fecha +
                "&tipo=" + tipo +
                "&orden=" + orden;
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>/temporal/insertar/" + indicativo + "/" + valor + "/" + extension + "/" + orden + "/" + tipo + "/" + fecha + "/" + clave,
                data: cadena,
                success: function(r) {}
            })
        } else {
            swal('', 'Solo Puede Tener un Actividad Principal en la Lista', 'error');
        }
    });
    $(document).on('click', '.removeActividad', function() {
        var texto = 0;
        var codigo = 0;
        var valor = 0;
        var fecha = 0;
        var orden = 0;
        var indicativo = 0;
        var button_id = $(this).attr("id");
        var valores = new Array();
        i = 0;
        tipo = "A";
        $(this).parents("tr").find("td").each(function() {
            valores[i] = $(this).html();
            i++;
        });
        numTel = valores[0];
        //cuando da click obtenemos el id del boton       
        $('#row' + button_id + '').remove(); //borra la fila
        //limpia el para que vuelva a contar las filas de la tabla
        $("#adicionaActividad").text("");
        var nFilas = $("#tablaActividades tr").length;
        //$("#adicionados").append(nFilas - 1);
        var valor = document.getElementById("valor").value;
        var extension = 0;
        var orden = document.getElementById("orden").value;
        cadena = "extension=" + codigo +
            "&indicativo=" + indicativo +
            "&valor=" + valor +
            "&fecha=" + fecha +
            "&tipo=" + tipo +
            "&orden=" + orden;

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>/temporal/eliminar/" + numTel + '/' + 'extension',
            data: cadena,
            success: function(r) {
                if (!r) {
                    swal('', 'Registro Eliminado Satisfactoriamente...', '');
                } else {
                    swal('', 'No se Pudo Eliminar el Registro. Informe!', 'error');
                }
            }
        })
    });

    function upload_image() { //Funcion encargada de enviar el archivo via AJAX
        //$(".upload-msg").text('Cargando...');
        //document.getElementById("docto").val=document.getElementById("inputFile")
        var inputFileImage = document.getElementById("inputFile");
        var file = inputFileImage.files[0];
        var data = new FormData();
        data.append('inputFile', file);
        $("#docto").val(numero_documento.value);
        $.ajax({
            //url: "<?php echo base_url(); ?>/terceros/subir", // Url to which the request is send
            type: "POST", // Type of request to be send, called as method
            data: data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false, // To send DOMDocument or non processed data file it is set to false
            success: function(r) // A function to be called if request succeeds
            {
                $('#mensaje').val(r[0]["error"]);

            }
        });
    };
</script>
</body>

</html>
