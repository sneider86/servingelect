<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">

            <?php if (isset($validation)) { ?>
                <div class="alert alert-danger">
                    <?php echo $validation->listErrors(); ?>
                </div>
            <?php } ?>
            <form method="post" action="<?php echo base_url(); ?>/parametros/agregar_detalle" autocomplete="off">
                <input type="hidden" name="id" value="<?php echo $parametros['id_param']; ?>" />
                <div class="card shadow-lg border-1 rounded-lg mt-3">
                    <div style="background: linear-gradient(90deg, #6484a5, #22a7bf);">
                        <h3 style="font-weight: bold;font-size:22px;" class="text-center my-2"><?php echo $titulo; ?></h3>
                    </div>
                    <div style="background: linear-gradient(90deg, #b2b8bc, #dbddde);" class="card-body">
                        <div class="form-group col-12">
                            <div class="row">                          
                                <div class="col-12 col-sm-3">
                                    <label>Parámetro</label>
                                    <input disabled class="form-control" id="nombre_parametro" name="nombre_parametro" value="<?php echo $parametros['nombre_parametro']; ?>" type="text"></>
                                </div>
                                <div class="col-12 col-sm-3">
                                    <!--  el ancho de la columna col-12 para pc y que abarque toda la pantalla y col-6 para moviles t barcara 6 columnas? -->
                                    <label>Nombre del Detalle</label>
                                    <input class="form-control" id="valor" name="valor" type="text" autofocus required></>
                                </div>
                                <div class="col-12 col-sm-2">
                                    <label>Abreviado</label>
                                    <input class=" form-control" id="resumen" name="resumen" type="text" autofocus required>                           
                                </div>
                                <div class="col-12 col-sm-3">
                                    <a style="height:2rem;" href="<?php echo base_url(); ?>/parametros/" class="btn btn-primary">Regresar</a>
                                    <button style="height:2rem;" type="submit" class="btn btn-success">Agregar</button>
                                </div>                                                       
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-sm table-striped" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr style="color:#98040a;font-weight:300;text-align:center;font-size:14px;">
                                        <th>Id</th>
                                        <th>Descripcion</th>
                                        <th>Abreviado</th>
                                        <th>Parámetro</th>
                                        <th> </th>
                                        <th> </th>
                                    </tr>
                                    <tbody style="font-family:Arial;font-size:12px;">
                                    <?php foreach ($datos as $dato) { ?>
                                        <td><?php echo $dato['id']; ?></td>
                                        <td><?php echo $dato['valor']; ?></td>
                                        <td><?php echo $dato['resumen']; ?></td>
                                        <td><?php echo $dato['id_cod'] . '-' . $dato['descripcion']; ?></td>
                                        <td style="height:0.2rem;width:1rem;"><a href="<?php echo base_url() . '/parametros/editar/' . $dato['id']; ?>" title="Editar Registro"><input type="image" src="<?php echo base_url(); ?>/image/edit.png" width="16" height="16"></input></a></td>

                                        <td style="height:0.2rem;width:1rem;"><a href="#" data-href="<?php echo base_url() . '/parametros/eliminar/' . $dato['id']; ?>" data-toggle="modal" data-target="#modal-confirma" data-placement="top" title="Eliminar Registro"><input type="image" src="<?php echo base_url(); ?>/image/trash.png"  width="16" height="16"></input></a></td>                                        
                                        </tr>
                                    <?php } ?>
                                    </tbody>

                                </thead>
                                
                                
                            </table>
                        </div>

                    </div>

            </form>
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
