<?php
$session = session();
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h5 class="mt-4"><?php echo $titulo; ?></h5>
            <div class="row col-md-5ths col-lg-5ths col-xs-6 col-sm-6">
            <p>
                <a style="height:2rem;" href="<?php echo base_url();?>/personal/nuevo" class="btn btn-info">Agregar</a>
                <a style="height:2rem;" href="<?php echo base_url();?>/personal/eliminados" class="btn btn-warning">Eliminados</a>
            </p>
            <div class="dropdown col-md-5ths col-lg-5ths col-xs-6 col-sm-6">
                    <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" id="mnReportes" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Reportes
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="<?php echo base_url(); ?>/personal/muestraPersonalPdf">Catálogo de Personal(Pdf)</a>
                    </div>
                </div>            
            </div>
            <br>
            <div class="table-responsive">
                <table class="table table-bordered table-sm table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>                        
                        <tr style="font-family:Arial;color:#98040a;font-weight:300;text-align:center;font-size:14px;">
                            <th hidden="true">Id</th>
                            <th>TD</th>
                            <th>Número</th>
                            <th>Razón Social</th>
                            <th>Direccción</th>
                            <th>Personal</th>
                            <th>Cargo</th>
                            <th> </th>
                            <th> </th>                            
                        </tr>
                    </thead>
                    <tbody style="font-family:Arial;font-size:12px;">
                    <?php foreach($datos as $dato) { ?>     
                        <td hidden="true"><?php echo $dato['id_persona'];?></td>                      
                            <td><?php echo $dato['tipo_documento'].'-'.$dato['resumen'];?></td>
                            <td><?php echo $dato['numero_documento'];?></td>
                            <td><?php echo $dato['razon_social'];?></td>
                            <td><?php echo $dato['direccion'];?></td>
                            <td><?php echo $dato['tipo_persona'].'-'.$dato['v_resumen'];?></td>
                            <td><?php echo $dato['nombre_cargo'];?></td>
                            <td style="height:0.2rem;width:1rem;"><a href="<?php echo base_url(). '/personal/editar/'.$dato['id_persona']; ?>" title="Editar Registro"><input type="image" src="<?php echo base_url(); ?>/image/edit.png" width="16" height="16"></input></a></td> 
                            <td style="height:0.2rem;width:1rem;"><a href="#" data-href="<?php echo base_url(). '/personal/eliminar/'.$dato['id_persona']; ?>" data-toggle="modal" data-target="#modal-confirma" data-placement="top" title="Eliminar Registro"><input type="image" src="<?php echo base_url(); ?>/image/trash.png" width="16" height="16"></input></a></td>                            
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
</body>
</html>