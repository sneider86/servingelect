<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h5 class="mt-4"><?php echo $titulo; ?></h5>
            <div>
            <p>
                <a style="height:2rem;" href="<?php echo base_url();?>/modulos/nuevo" class="btn btn-info">Agregar</a>
                <a style="height:2rem;" href="<?php echo base_url();?>/modulos/eliminados" class="btn btn-warning">Eliminados</a>
            </p>
            </div>
            <br>
            <div class="table-responsive">
                <table class="table table-bordered table-sm table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>                        
                        <tr style="color:#98040a;font-weight:300;text-align:center;font-size:14px;">
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Orden</th>
                            <th>Tipo</th>
                            <th>Padre</th>
                            <th>Ruta</th>
                            <th>Icono</th>
                            <th>Id Target</th>
                            <th> </th>
                            <th> </th>                            
                        </tr>
                    </thead>
                    <tbody style="font-family:Arial;font-size:14px;">
                    <?php foreach($datos as $dato) { ?>
                            <td><?php echo $dato['id'];?></td>
                            <td><?php echo $dato['nombre'];?></td>
                            <td><?php echo $dato['orden'];?></td>
                            <td><?php echo $dato['tipo'];?></td>
                            <td><?php echo $dato['padre_id'];?></td>
                            <td><?php echo $dato['codigo'];?></td>
                            <td><?php echo $dato['icon'];?></td>
                            <td><?php echo $dato['aplicacion'];?></td>

                            <td style="height:0.2rem;width:1rem;"><a href="<?php echo base_url(). '/modulos/editar/'.$dato['id']; ?>" title="Editar Registro"><i class="fas fa-pencil-alt"></i></a></td> 
                            <td style="height:0.2rem;width:1rem;"><a href="#" data-href="<?php echo base_url(). '/modulos/eliminar/'.$dato['id']; ?>" data-toggle="modal" data-target="#modal-confirma" data-placement="top" title="Eliminar Registro"><i color="#cb1a2a" class="fas fa-trash"></i></a></td>
                            
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
<script src="js/jquery-3.5.1.slim.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/scripts.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap4.min.js"></script>
<script src="assets/demo/datatables-demo.js"></script>

</body>

</html>