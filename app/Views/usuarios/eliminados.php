<?php
$session = session();
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h5 class="mt-4"><?php echo $titulo; ?></h5>
            <div>
                <p>
                    <a style="height:2rem" href="<?php echo base_url(); ?>/usuarios" class="btn btn-warning">Regresar</a>
                </p>
            </div>
            <br>
            <div class="table-responsive">
                <table class="table table-bordered table-sm table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr style="color:#98040a;font-weight:300;text-align:center;font-size:14px;">
                            <th>Id</th>
                            <th>Usuario</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Nombre Rol</th>
                            <th> </th>
                        </tr>
                    </thead>
                    <tbody style="font-family:Arial;font-size:12px;">
                        <?php foreach ($datos as $dato) { ?>
                            <tr>
                                <td><?php echo $dato['id']; ?></td>
                                <td><?php echo $dato['usuario']; ?></td>
                                <td><?php echo $dato['nombres']; ?></td>
                                <td><?php echo $dato['email']; ?></td>
                                <td><?php echo $dato['id_rol']; ?></td>
                                <td><?php echo $session->nombre_rol; ?></td>

                                <td style="height:0.2rem;width:1rem;"><input href="#" data-href="<?php echo base_url() . '/usuarios/activar/' . $dato['id']; ?>" <?php echo $activar; ?> data-toggle="modal" data-target="#modal-confirma" data-placement="top" title="Activar Registro" type="image" src="<?php echo base_url(); ?>/image/recycleIII.png" width="16" height="16"></input></td>
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
                    <h5 style="color:#98040a;font-size:20px;font-weight:bold;" class="modal-title" id="exampleModalLabel">Activar Registro</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div style="text-align:center;font-weight:bold;" class="modal-body">
                    <p>Seguro Desea Activar ??ste Registro?</p>
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
                <div style="color:white">Copyright &copy; EK-Soft * Desarrollo de Software * <?php echo date('Y'); ?></div>
                <div>
                    <a style="color:white" href="#">Facebook</a>
                    &middot;
                    <a style="color:white" href="#">P??gina Web</a>
                </div>
            </div>
        </div>
    </footer>

</div>
</div>

</body>

</html>