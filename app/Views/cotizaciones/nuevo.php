<style>
    .tab button {
        background: linear-gradient(90deg, #6484a5, #6484a5);
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 7px 8px;
        transition: 0.3s;
    }

    /* Change background color of buttons on hover */
    .tab button:hover {
        background-color: #f20b5b;
    }

    /* Create an active/current tablink class */
    .tab button.active {
        background-color: #efef25;
    }

    /* Style the tab content */
    .tabcontent .tabcontent2 {
        display: none;
        padding: 6px 12px;
        border: 0px solid #efef25;
        border-top: none;
        animation: fadeEffect 1s;
    }

    /* Go from zero to full opacity */
    @keyframes fadeEffect {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    /* Estilos de la tabla */
    th {
        font-size: 13px;
        font-weight: normal;
        padding: 8px;
        background: #b9c9fe;
        border-top: 4px solid #aabcfe;

        border-bottom: 1px solid #fff;
        color: #039;
    }

    td {
        padding: 8px;
        background: #e8edff;
        border-bottom: 1px solid #fff;
        color: #669;
        border-top: 1px solid transparent;
    }

    tr:hover td {
        background: #d0dafd;
        color: #339;
    }

    .editar {
        color: blue;
        cursor: pointer;
    }

    #contenedorForm {
        margin-left: 45px;
        font-size: 12px;
    }

    .boton {
        color: black;
        padding: 5px;
        margin: 10px;
        background-color: #b9c9fe;
        font-weight: bold;
    }

    thead tr th {
        position: sticky;
        top: 0;
        z-index: 10;
    }
</style>
<div id="layoutSidenav_content">
    <main>
        <div style="background: linear-gradient(90deg, #a4b5c6, #a4b5c6);" class="card shadow-lg border-1 rounded-lg mt-0">
            <div style="background: linear-gradient(90deg, #6484a5, #22a7bf);">
                <h3 style="font-weight: bold;font-size:22px;" class="text-center my-1"><?php echo $titulo; ?></h3>
            </div>
            <div class="tabs">
                <button class="tablinks" onclick="openCity(event, 'Cliente')" id="defaultOpen">Cliente</button>
                <button class="tablinks" onclick="openCity(event, 'Cuerpo')" id="Apu">A.P.U.</button>
                <button class="tablinks" onclick="openCity(event, 'DApu')" id="Dapu">Ver PDF</button>
            </div>
            <div id="Cliente" class="tabcontent">
                <form class="form">
                    <div class="card shadow-lg border-1 rounded-lg mt-1">
                        <div style="background: linear-gradient(90deg, #b2b8bc, #b2b8bc);" class="card-body">
                            <div class="form-group">
                                <div class="row col-sm-12">
                                    <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-8">
                                        <label>Razón Social</label>
                                        <input class="form-control form-control-sm" onKeyUp="mayus(this);" id="razon_social" name="razon_social" type="text" "></>
                                    </div>
                                    <div class=" col-md-5ths col-lg-5ths col-xs-6 col-sm-4">
                                        <label>Fecha de Emisión</label>
                                        <input class="form-control form-control-sm" id="fecha" name="fecha" type="date"></>
                                    </div>
                                    <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-8">
                                        <textarea style="background:linear-gradient(90deg, #b2b8bc, #b2b8bc)" disabled class="form-control" rows="3" cols="90" id="t_direccion" name="t_direccion"></textarea>
                                    </div>

                                    <div class="col-md-5ths col-lg-5ths col-xs-6 col-sm-12">
                                        <label>Proyecto</label>
                                        <input class="form-control form-control-sm" id="proyecto" name="proyecto" type="text"></>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <a href="<?php echo base_url(); ?>/cotizaciones" class="btn btn-primary">Regresar</a>
                <button id="sgte_Cte" type="button" class="btn btn-success">Siguiente</button>
            </div>
        </div>
        <div id="Cuerpo" class="tabcontent">
            <div class="row col-md-12">
                <div class="col-sm-9">
                    <h4 class="text-xs-center">Detalle de la Cotización</h4>
                </div>
                <div class="col-sm-3">
                    <input id="agregar_item" style="height:2rem;width:6rem;" class="btn btn-primary" id="btn_nuevo" value="+ Item">
                    <a id="agregar_detalle" class="btn btn-warning">+ Detalle Item</a>
                </div>
            </div>
            <div class="table-responsive" style="width:100%; height:400px; overflow: scroll-verticall;">
                <table class="table table-bordered table-sm table-striped header_fijo" id="" width="100%" cellspacing="0">
                    <thead>
                        <tr style="color:#98040a;font-weight:300;text-align:center;font-family:Arial;font-size:14px;">
                            <th hidden style="width:30px">Idx</th>
                            <th style="width:30px">#</th>
                            <th style="width:550px">Descripción</th>
                            <th style="width:50px">Detalle</th>
                            <th style="width:70px">Cnt</th>
                            <th style="width:120px">Precio</th>
                            <th style="width:120px">SubTotal</th>
                            <th style="width:20px" colspan="2">Acción</th>

                        </tr>
                    </thead>
                    <tbody id="tbl_detalles" style="font-family:Arial;font-size:10px;">
                        <tr style="color:#98040a;font-weight:300;text-align:center;font-family:Arial;font-size:12px;">
                            <td hidden id="1">1</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><input onclick="transformarEnEditableItem(this)" type="image" src="<?php echo base_url(); ?>/image/edit.png" width="16" height="14" title="Editar Registro"></input></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <a id="regresar_Apu" class="btn btn-primary">Regresar</a>
            <button id="sgte_Apu" type="button" class="btn btn-success">Guardar</button>
        </div>
        <div id="DApu" class="tabcontent">
            <h3>COTIZACION</h3>
            <p>Mostrar</p>
            <a id="regresar_DApu" class="btn btn-primary">Regresar</a>
        </div>

    </main>
</div>
<!-- Modal Detalles de APU-->
<div class="modal fade" id="modalDetalles" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form class="form-inline">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div style="background: linear-gradient(90deg, #b4c1d9, #b4c1d9);" class="modal-content">
                <div class="modal-header">
                    <h5 style="color:#98040a;font-size:20px;font-weight:bold;" class="modal-title" id="exampleModalLabel">Detalles de A.P.U.</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="id_modal" class="modal-body">
                    <div style="background: linear-gradient(90deg, #b2b8bc, #dbddde);" class="container">
                        <form>
                            <div class="row">
                                <div class="col-md-5ths col-lg-2">
                                    <label>Tipo</label>
                                    <select class="form-control form-control-sm" id="tipo" name="tipo" type="text" required>
                                        <option value="">Seleccionar</option>
                                        <?php foreach ($conceptos as $row) { ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['valor'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-5ths col-lg-3">
                                    <label>Descripción</label>
                                    <div class="input-group">
                                        <input class="form-control form-control-sm" id="mitem" name="mitem" type="text" required></>
                                    </div>
                                </div>
                                <div class="col-lg-1">
                                    <label>Und</label>
                                    <div class="input-group">
                                        <input disabled class="form-control form-control-sm" id="munidad" name="munidad" type="text" required></>
                                    </div>
                                </div>
                                <div class="col-lg-1">
                                    <label>CNT</label>
                                    <div class="input-group">
                                        <input class="form-control form-control-sm" id="mcantidad" name="mcantidad" type="text" required></>
                                    </div>
                                </div>
                                <div class="col-lg-1">
                                    <label>%</label>
                                    <div class="input-group">
                                        <input class="form-control form-control-sm" id="mporcentaje" name="mporcentaje" type="text" required></>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <label>Precio</label>
                                    <div class="input-group">
                                        <input class="form-control form-control-sm" id="mprecio" name="mprecio" type="text" required onblur="calculaSubtotal()"></>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <label>SubTotal</label>
                                    <div class="input-group">
                                        <input disabled class="form-control form-control-sm" id="msubtotal" name="msubtotal" type="text" required></>
                                        <span class="input-group-btn ">
                                            <button id="agregar_concepto" type="button" class="btn btn-success form-control-sm">+</span></button>
                                        </span>
                                    </div>
                                </div>

                            </div>

                        </form>
                        <div class="row col-md-12">
                            <div class="table-responsive" style="width:100%; height:300px; overflow: scroll-verticall;">
                                <table class="table table-bordered table-sm table-striped header_fijo" id="" width="100%" cellspacing="0">
                                    <thead>
                                        <tr style="color:#98040a;font-weight:300;text-align:center;font-family:Arial;font-size:14px;">
                                            <th style="width:40px;">#</th>
                                            <th style="width:300px;">DESCRIPCION</th>
                                            <th style="width:50px">UND</th>
                                            <th style="width:60px">CANT</th>
                                            <th style="width:40px">%</th>
                                            <th style="width:120px">Vr.Unitario</th>
                                            <th style="width:120px">Vr.Total</th>
                                            <th style="width:20px">Acción</th>

                                        </tr>
                                    </thead>
                                    <tbody id="tbl_item" style="font-family:Arial;font-size:10px;">

                                    </tbody>
                                </table>
                            </div>
                        </div>


                    </div>

                </div>
                <div class="modal-footer">
                    <div>
                        <input style="text-align:right;" disabled class="form-control form-control-sm" id="total" name="total" type="text"></>
                    </div>
                    <button id="ok_detalles" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function transformarEnEditable(nodo) {
        //El nodo recibido es SPAN
        //if (editando == false) {
        var nodoTd = nodo.parentNode; //Nodo TD
        var nodoTr = nodoTd.parentNode; //Nodo TR
        //var nodoContenedorForm = document.getElementById('contenedorForm'); //Nodo DIV
        var nodosEnTr = nodoTr.getElementsByTagName('td');
        var id = nodosEnTr[0].textContent;
        var descripcion = nodosEnTr[1].textContent;
        //var unidad = nodosEnTr[2].textContent;
        var detalle = nodosEnTr[2].textContent;
        var cantidad = nodosEnTr[3].textContent;
        var precio = nodosEnTr[4].textContent;
        var subtotal = nodosEnTr[5].textContent;
        var nuevoCodigoHtml = '<td  hidden style="width:10px;" id="' + id + '" >' + id + '</td><td><input disabled type="text" name="item" id="item" value="' + "" + '" size="1"</td>' +
            '<td><textarea id="descripcion" name="descripcion" rows="2" cols="90"></textarea></td>' +
            '<td style="text-align:center"><input class="checkbox" type="checkbox" name="detalle" id="detalle" size="2"></td>' +
            '<td><input type="text" name="cantidad" id="cantidad" value="' + cantidad + '" size="6" onblur="calculaSubtotalPrincipal()"></td>' +
            '<td><input type="text" name="precio" id="precio" value="' + precio + '" size="12" onblur="calculaSubtotalPrincipal()"></td>' +
            '<td><input disabled type="text" name="subtotal" id="subtotal" value="' + subtotal + '" size="12"></td><td><input onclick="guardarDetalle(this)" type="image" src="<?php echo base_url(); ?>/image/save.png" width="20" height="22" title="Guardar Registro"></input></td>' + '<td><input class="deletePpal" type="image" src="<?php echo base_url(); ?>/image/eliminar.png" width="20" height="22" title="Eliminar Registro"></input></td>';
        nodoTr.innerHTML = nuevoCodigoHtml;

        //} else {
        //    alert('Solo se puede editar una línea. Recargue la página para poder editar otra');
        //}
    }

    function transformarEnEditableItem(nodo) {

        //El nodo recibido es SPAN
        //if (editando == false) {
        var nodoTd = nodo.parentNode; //Nodo TD
        var nodoTr = nodoTd.parentNode; //Nodo TR
        //var nodoContenedorForm = document.getElementById('contenedorForm'); //Nodo DIV
        var nodosEnTr = nodoTr.getElementsByTagName('td');
        var id = nodosEnTr[0].textContent;
        var descripcion = nodosEnTr[1].textContent;
        var unidad = nodosEnTr[2].textContent;
        var nuevoCodigoHtml = '<td  hidden style="width:10px;" id=' + id + '>' + id + '</td><td><input type="text" name="item" id="item" value="' + "" + '" size="1"></td>' +
            '<td><textarea  id="descripcion" name="descripcion" rows="1" cols="90"></textarea></td>' +
            '<td>' + '' + '</td>' +
            '<td>' + '' + '</td>' +
            '<td>' + '' + '</td>' +
            '<td>' + '' + '</td>' + '<td><input onclick="guardarItem()" type="image" src="<?php echo base_url(); ?>/image/save.png" width="18" height="18" title="Guardar Registro"></input></td>' + '<td><input onclick="eliminarItem(this)" type="image" src="<?php echo base_url(); ?>/image/eliminar.png" width="20" height="18" title="Eliminar Registro"></input></td>';
        nodoTr.innerHTML = nuevoCodigoHtml;

        //editando = "false";
        //} else {
        //    alert('Solo se puede editar una línea. Recargue la página para poder editar otra');
        //}
    }

    document.getElementById("defaultOpen").click();

    function openCity(evt, cityName) {
        // Declare all variables
        var i, tabcontent, tablinks;

        // Get all elements with class="tabcontent" and hide them
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        // Get all elements with class="tablinks" and remove the class "active"
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }

        // Show the current tab, and add an "active" class to the button that opened the tab
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    };

    function openCity2(evt, cityName) {
        // Declare all variables
        var i, tabcontent, tablinks;

        // Get all elements with class="tabcontent" and hide them
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        // Get all elements with class="tablinks" and remove the class "active"
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }

        // Show the current tab, and add an "active" class to the button that opened the tab
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    };


        function guardarItem() {
            alert("as");
        }

    /*
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
        
    };*/

    function calculaSubtotalPrincipal() {
        var precio = document.getElementById("precio").value;
        var cantidad = document.getElementById("cantidad").value;
        var subtotal = (parseFloat(cantidad) * parseFloat(precio));
        document.getElementById("subtotal").value = subtotal;
    };

    function calculaSubtotal() {
        var precio = document.getElementById("mprecio").value;
        var cantidad = document.getElementById("mcantidad").value;
        var porcentaje = document.getElementById("mporcentaje").value;
        var subtotal = (parseFloat(cantidad) * parseFloat(precio)) * parseFloat(porcentaje);
        document.getElementById("msubtotal").value = subtotal;
    };

    function calcula_total() {
        var data = [];
        $("td.sTotal").each(function() {
            data.push(parseFloat($(this).text()));
        });
        var suma = data.reduce(function(a, b) {
            return a + b;
        }, 0);
        $("#total").val(suma);

    };

    $("#item").autocomplete({
        source: "<?php echo base_url(); ?>/cotizaciones/autocompleteData/" + 'descripcion',
        minLength: 3,
        appendTo: "#id_modal", // ID del modal o body
        select: function(event, ui) {
            event.preventDefault();
            $("#item").val(ui.item.value);
            $("#unidad").val(ui.unidad_medida.value);
        }
    });
    $(document).on('change', '.checkbox', function() {
        if (this.checked) {
            $("#modalDetalles").modal("show");
        };
    });
    $('#ok_detalles').click(function() {
        //document.getElementById("cantidad").value = 100;
        document.getElementById("precio").value = document.getElementById("total").value;
        $("#precio").attr("disabled", 'true');
        $("#subtotal").attr("disabled", 'true');
        $("#modalDetalles input").val("");
        $("#modalDetalles select").val("");
        $("#tbl_item tr").remove();
        //$('#modalDetalles .close').click();

    });
    $(document).on('click', '.delete', function(event) {
        event.preventDefault();
        $(this).closest('tr').remove();
        calcula_total();
    });

    $(document).on('click', '.deletePpal', function(event) {
        event.preventDefault();
        $(this).closest('tr').remove();
    });

    $('#sgte_Cte').click(function() {
        document.getElementById("Apu").click();
    });
    $('#sgte_Apu').click(function() {
        document.getElementById("Dapu").click();
    });
    $('#regresar_Apu').click(function() {
        document.getElementById("defaultOpen").click();
    });
    $('#regresar_DApu').click(function() {
        document.getElementById("Apu").click();
    });
    $("#razon_social").autocomplete({
        source: "<?php echo base_url(); ?>/terceros/autocompleteData/" + 'razon_social',
        minLength: 3,
        select: function(event, ui) {
            event.preventDefault();
            $("#razon_social").val(ui.item.value);
            $('#t_direccion').val(ui.item.numero_documento + '\n' + ui.item.direccion + '\n' + ui.item.municipio + ' - ' + ui.item.departamento);
        }
    });
    $('#agregar_item').click(function() {
        var nFila = $("#tbl_detalles tr").length + 1;
        var _row = '';
        _row += '<tr style="color:#98040a;font-weight:300;text-align:center;font-family:Arial;font-size:12px;"><td  hidden style="width:10px;" id="' + nFila + '" >' + nFila + '</td><td>' + '' + '</td><td>' + '' + '</td><td>' + '' + '</td><td>' + '' + '</td><td>' + '' + '</td><td>' + '' + '</td><td><input onclick="transformarEnEditableItem(this)" type="image" src="<?php echo base_url(); ?>/image/edit.png" width="16" height="14" title="Editar Registro"></input></td></tr>';
        $('#tbl_detalles').append(_row);
    });
    $('#agregar_detalle').click(function() {
        var nFila = $("#tbl_detalles tr").length + 1;
        var _row = '';
        _row += '<tr style="color:#98040a;font-weight:300;text-align:center;font-family:Arial;font-size:12px;"><td  hidden style="width:10px;" id="' + nFila + '">' + nFila + '</td><td>' + '' + '</td><td>' + '' + '</td><td style="text-align:center">' + `<input type="checkbox" >` + '</td><td>' + '' + '</td><td>' + '' + '</td><td>' + '' + '</td><td><input onclick="transformarEnEditable(this)" type="image" src="<?php echo base_url(); ?>/image/edit.png" width="16" height="14" title="Editar Registro"></input></td> </tr>';
        $('#tbl_detalles').append(_row);
    });

    $('#agregar_concepto').click(function() {
        var cod = document.getElementById("tipo").value;
        if (cod != 0) {
            var combo = document.getElementById("tipo");

            var seleccionado = combo.options[combo.selectedIndex].text;
            c_subtotal = parseFloat(document.getElementById("msubtotal").value);
            var _row = '';
            _row += '<tr style="color:#98040a;font-weight:300;text-align:center;font-family:Arial;font-size:12px;"><td style="width:40px;">' + seleccionado + '</td><td style="width:300px;">' + document.getElementById("mitem").value + '</td><td style="width:50px;">' + document.getElementById("munidad").value + '</td><td style="width:60px;">' + document.getElementById("mcantidad").value + '</td><td style="width:40px;">' + document.getElementById("mporcentaje").value + '</td><td style="width:120px;">' + document.getElementById("mprecio").value + '</td><td class="sTotal" style="width:120px;">' + document.getElementById("msubtotal").value + '</td><td style="width:30px;"><input class="delete" type="image" src="<?php echo base_url(); ?>/image/eliminar.png" width="16" height="14" title="Eliminar Registro"></input></td> </tr>';
            $('#tbl_item').append(_row);
            calcula_total();
            $("#mitem").val("");
            $("#munidad").val("");
            $("#mcantidad").val("");
            $("#mprecio").val("");
            $("#mporcentaje").val("");
            $("#msubtotal").val("");
        } else {
            swal('Debe Seleccionar el Tipo. Corrija', '');
            cod = document.getElementById("tipo").focus();
        }

    });
</script>
