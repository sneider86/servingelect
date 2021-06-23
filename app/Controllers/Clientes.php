<?php

namespace App\Controllers;


use App\Controllers\BaseController; /*la plantilla del controlador general de codeigniter */
use App\Models\RolesModel; /* clase a la cual se esta apuntando con los modelos */
use App\Models\ModulosModel;
use App\Models\ClientesModel;
use App\Models\DetalleParametrosModel;
use App\Models\PaisModel;
use App\Models\DepartamentosModel;
use App\Models\MunicipiosModel;
use App\Models\TercerosModel;
use App\Models\TemporalModel;
use App\Models\Correos_telefonosModel;
use App\Models\EmpresasModel;
use App\Models\PermisosModel;


class Clientes extends BaseController
{
    /*interactua el controlador con el modelo */
    protected $clientes, $roles, $modulos,$detalleparametros,$tipo_Cliente,$pais,$tipo_documento;
    protected $reglas, $reglasLogin, $reglasCambia, $reglasActualiza,$departamentos,$municipios;
    protected $terceros,$temporal,$correos_telefonos,$empresas,$permisos;

    public function __construct()
    {
        $this->clientes = new ClientesModel();
        $this->roles = new RolesModel();
        $this->modulos = new ModulosModel();
        $this->pais = new PaisModel();
        $this->detalleparametros = new DetalleParametrosModel();
        $this->tipo_Cliente = new DetalleParametrosModel();
        $this->departamentos = new DepartamentosModel();
        $this->municipios = new MunicipiosModel();
        $this->terceros = new TercerosModel();
        $this->temporal = new TemporalModel();
        $this->correos_telefonos = new Correos_telefonosModel();
        $this->empresas = new EmpresasModel();
        $this->permisos = new PermisosModel();
    }

    public function index($activo = 1)
    {              
        $session = session();
        if($session->id_rol!=1){
            $verClientes = $this->permisos->obtenerPermiso($session->id_rol,'Ver Clientes');
            $agregar = $this->permisos->obtenerPermiso($session->id_rol,'Agregar Cliente');
            $editar = $this->permisos->obtenerPermiso($session->id_rol,'Editar Cliente');
            $actualizar = $this->permisos->obtenerPermiso($session->id_rol, 'Actualizar Cliente');
            $eliminar = $this->permisos->obtenerPermiso($session->id_rol,'Eliminar Cliente');
            $reporte = $this->permisos->obtenerPermiso($session->id_rol,'Reporte de Cliente');
        }else{
            $verClientes = "enabled='true'";
            $agregar = "enabled='true'";
            $editar = "enabled='true'";
            $actualizar = "enabled='true'";
            $eliminar = "enabled='true'"; 
            $reporte = "enabled='true'";           
        }   
        if ($verClientes=="enabled='true'"){   
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $clientes = $this->clientes->consulta_listaTercero();
        $data = ['titulo' => 'MANEJO DE CLIENTES', 'datos' => $clientes, 'roles' => $roles, 'modulos' => $modulos, 'agregar' => $agregar, 'editar' => $editar, 'actualizar' => $actualizar, 'eliminar' => $eliminar, 'reporte' => $reporte];
        
        echo view('header', $data);
        echo view('clientes/clientes', $data);
        echo view('footer');
        }else{
            return redirect()->to(base_url(). '/principal');
            $message ='Usted no Tiene Autorización para Ver esta Opción';
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
    }

    public function getDepartamentos(){
        $codpais = $_POST['codpais'];
        $where = "id_pais= $codpais order by nombre";
        $datos = $this->departamentos->where($where)->findAll();
        $cadena = "<select id='departamento' name='departamento'>";
 
        foreach ($datos as $row) {
            $cadena = $cadena.'<option value='. $row['codigo'].'>'. $row['nombre'].'</option>';
        }
        echo $cadena."</select>";
        //echo json_encode($departamentos);
    }

    public function getMunicipios(){
        $coddepartamento = $_POST['coddepartamento'];
        $where = "id_departamento= $coddepartamento order by nombre ";
        $datos = $this->municipios->where($where)->findAll();
        $cadena = "<select id='municipio' name='municipio'>";
 
        foreach ($datos as $row) {
            $cadena = $cadena.'<option value='. $row['codigo'].'>'.utf8_encode($row['nombre']).'</option>';
        }
        echo $cadena."</select>";
        //echo json_encode($departamentos);
    }

    public function eliminados($activo = 0)
    {
        $session = session();
        if ($session->id_rol!=1) {
            $activar = $this->permisos->obtenerPermiso($session->id_rol, 'Activar Cliente');
        }else{$activar = "enabled='true'"; }        
        $clientes = $this->clientes->where('activo', $activo)->findAll();
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $where = " activo = 1 order by razon_social"; 
        $terceros = $this->terceros->where($where)->findAll();
        $data = ['titulo' => 'CLIENTES ELIMINADOS', 'datos' => $clientes, 'roles' => $roles, 'modulos' => $modulos, 'terceros' => $terceros];
        /* mostramos la vista */
        echo view('header', $data);
        echo view('clientes/eliminados', $data);
        echo view('footer');
    }


    public function nuevo()
    {               
        $tipo_Cliente = $this->detalleparametros->buscarDetalleParametros('Tipo de Cliente'); 
        $tipo_documento = $this->detalleparametros->buscarDetalleParametros('Tipo de Documento'); 
        $pais = $this->pais->where('activo', 1)->findAll();
        //$departamentos = $this->departamentos->where('activo', 1)->findAll();
        //$municipios = $this->municipios->where('activo', 1)->findAll();
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $where = " activo = 1 order by razon_social"; 
        $terceros = $this->terceros->where($where)->findAll(); 
        $data = ['titulo' => 'DATOS DEL CLIENTE', 'roles' => $roles, 'modulos' => $modulos, 'tipo_documento' => $tipo_documento, 'tipo_Cliente' => $tipo_Cliente, 'pais' => $pais, 'terceros' => $terceros];

        echo view('header', $data);
        echo view('clientes/nuevo', $data);
        echo view('footer');
    }

    public function insertar()
    {
        if ($this->request->getMethod() == "post") {
            $session = session();

            $resultadoId = $this->clientes->insertaCliente($this->request->getPost('id'),$this->request->getPost('email_facturacion'),$this->request->getPost('nombre_contacto'),$this->request->getPost('rep_legal'),$this->request->getPost('email_replegal'),$session->id_usuario);

            //Inserta en tabla de telefonos desde la tabla temporal
            $resultado_telefonos = $this->temporal->where('activo', 1)->findAll();
            foreach ($resultado_telefonos as $row) {
                $clave = $row['tipo']. '_contCte';
                $this->correos_telefonos->save([
                    'id_tercero' => $resultadoId,
                    'valor' => $row['valor'],
                    'extension' => $row['extension'],
                    'tipo' => $row['tipo'],
                    'clave' => $clave,
                    'orden' => $row['orden'],
                    'fecha' => $row['fecha']
                ]);

            }  
            
            $this->temporal->eliminarTodo(1);
            return redirect()->to(base_url() . '/clientes');
        } else {
            $tipo_Cliente = $this->detalleparametros->buscarDetalleParametros('Tipo de Cliente'); 
            $tipo_documento = $this->detalleparametros->buscarDetalleParametros('Tipo de Documento'); 
            $pais = $this->pais->where('activo', 1)->findAll();
            $departamentos = $this->departamentos->where('activo', 1)->findAll();
            $municipios = $this->municipios->where('activo', 1)->findAll();            
            $roles = $this->roles->where('activo', 1)->findAll();
            $modulos = $this->modulos->buscar_modulos(1);
            $data = ['titulo' => 'CREAR CLIENTES', 'roles' => $roles,'modulos' => $modulos, 'tipo_documento' => $tipo_documento, 'tipo_Cliente' => $tipo_Cliente, 'pais' => $pais, 'departamentos' => $departamentos, 'municipios' => $municipios, 'validation' => $this->validator];
            echo view('header', $data);
            echo view('clientes/nuevo', $data);
            echo view('footer');
        }
    }

    public function editar($id, $valid = null)
    {
        $clientes = $this->clientes->traerCliente($id);
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        if ($valid !== null) {
            $data = ['titulo' => 'EDITAR CLIENTES', 'datos' => $clientes, 'roles' => $roles, 'modulos' => $modulos, 'validation' => $valid];
        } else {
            $data = ['titulo' => 'EDITAR CLIENTES', 'datos' => $clientes, 'roles' => $roles, 'modulos' => $modulos];
        }
        echo view('header', $data);
        echo view('clientes/editar', $data);
        echo view('footer');
    }
    public function actualizar()
    {
        if ($this->request->getMethod() == "post" ) {
            //$hash = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
            $this->clientes->update($this->request->getPost('id'), [
                //'usuario' => $this->request->getPost('usuario'),
                //'password' => $hash,
                'email_facturacion' => $this->request->getPost('email_facturacion'),
                'nombre_contacto' => $this->request->getPost('nombre_contacto'),
                'rep_legal' => $this->request->getPost('rep_legal'),
                'email_replegal' => $this->request->getPost('email_replegal')
            ]);
            return redirect()->to(base_url() . '/clientes');
        } else {
            return $this->editar($this->request->getPost('id'), $this->validator);
        }
    }

    public function eliminar($id)
    {
        $this->clientes->update($id, ['activo' => 0]);
        return redirect()->to(base_url() . '/clientes');
    }
    public function activar($id)
    {
        $this->clientes->update($id, ['activo' => 1]);
        return redirect()->to(base_url() . '/clientes/eliminados');
    }

    public function login()
    {
        echo view('login');
    }

    public function valida()
    {
        if ($this->request->getMethod() == "post" && $this->validate($this->reglasLogin)) {
            $usuario = $this->request->getPost('usuario'); //dato del formulario login
            $password = $this->request->getPost('password'); //dato del formulario login
            $datosUsuario = $this->clientes->where('usuario', $usuario)->first(); //consulta            
            if ($datosUsuario != null) {
                if (password_verify($password, $datosUsuario['password'])) {  //verificamos el password que sed trae en la consulta con el que oingresa el usuario
                    $datosRol = $this->roles->where('id', $datosUsuario['id_rol'])->first();
                    $datosSesion = [ //creamos la variable dee sesion en modo arreglo
                        'id_usuario' => $datosUsuario['id'],
                        'nombres' => $datosUsuario['nombres'],
                        'email' => $datosUsuario['email'],
                        'id_rol' => $datosUsuario['id_rol'],
                        'nombre_rol' => $datosRol['nombre']
                    ];
                    $session = session(); //variabloe de sesion a la cual le establecemos la sesion ($session y puede ser cualquier nombre de variable)
                    $session->set($datosSesion); //y a la nueva $session le asignamos el arreglo $datosSesion y ya nos crearia las variables de sesion para poder trabajar
                    //return redirect()->to(base_url() . '/clientes');   // debemos redireccionar a la vista principal o a la que decidamos
                    return redirect()->to(base_url() . '/principal');
                } else {
                    $data['error'] = "Contraseña Equivocada. Intentalo Nuevamente";
                    echo view('login', $data); //$data=informacion que se envia, o sea el mensaje de error
                }
            } else {
                $data['error'] = "El Usurio: " . $usuario . " no Existe.";
                echo view('login', $data);
            }
        } else {
            $data = ['validation' => $this->validator];  //se manda con data el resultado de errores
            echo view('login', $data);
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(base_url());
    }

    public function cambia_password()
    {

        $session = session(); //para tomar el id del usuario de la sesion logueada 
        $usuario = $this->clientes->where('id', $session->id_usuario)->first();
        $data = ['titulo' => 'CAMBIAR CONTRASEÑA', 'usuario' => $usuario];
        echo view('header');
        echo view('clientes/cambia_password', $data);
        echo view('footer');
    }

    public function actualizar_password()
    {
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        if ($this->request->getMethod() == "post" && $this->validate($this->reglasCambia)) {
            $session = session();
            $id_usuario = $session->id_usuario;
            $hash = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
            $this->clientes->update($id_usuario, ['password' => $hash]);
            $usuario = $this->clientes->where('id', $session->id_usuario)->first();  
            $data = ['titulo' => 'CAMBIAR CONTRASEÑA', 'usuario' => $usuario, 'mensaje' => 'Cambio de Contraseña Exitoso','roles' => $roles, 'modulos' => $modulos];

            echo view('header', $data);
            echo view('clientes/cambia_password', $data);
            echo view('footer');
        } else {
            $session = session(); //para tomar el id del usuario de la sesion logueada 
            $usuario = $this->clientes->where('id', $session->id_usuario)->first();
            $data = ['titulo' => 'CAMBIAR CONTRASEÑA','roles' => $roles, 'modulos' => $modulos, 'usuario' => $usuario, 'validation' => $this->validator];
            echo view('header');
            echo view('clientes/cambia_password', $data);
            echo view('footer');
        }
    }

    public function buscarPorPaises($codigo){
        $this->departamentos->select('*');
        $this->departamentos->where('id_pais',$codigo);
        $this->departamentos->where('activo',1);
        $datos = $this->departamentos->findAll(); //traer fila del producto encontrados
        $departamentos = array();
        $data = ['departamentos' => $departamentos];
    }

    public function municipiosPorDepartamentos($pais,$codigo){
        $this->municipios->select('*');
        $this->municipios->where('id_pais',$pais);
        $this->municipios->where('id_departamento',$codigo);
        $this->municipios->where('activo',1);
        $datos = $this->municipios->findAll(); //traer fila del producto encontrados
        $municipios = array();
        $data = ['municipios' => $municipios];
    }

    public function buscarCliente($id)
    {
        $returnData = array();
        $clientes = $this->clientes->buscarCliente($id);
        if (!empty($clientes)) {array_push($returnData, $clientes);}
        echo json_encode($returnData);      
    }
  
    function muestraClientesPdf(){
        $clientes = $this->clientes->consulta_listaTercero();
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $data = ['titulo' => 'Reporte de Terceros','datos' => $clientes, 'roles' => $roles, 'modulos' => $modulos];
        echo view('header',$data);
        echo view('/clientes/verClientes_pdf',$data);
        echo view('footer');
    }

    function reporteClientesPdf()
    {
        $session = session();
        $empresas = $this->empresas->where('id_empresa',1)->first();
        $clientes = $this->clientes->consulta_listaTercero();
        // podemos trabajar la consulta de esta forma o en una sola linea asi: 
        //$detalle_compra = $this->detalle_compra->select('*')->where('id_compra',$id_compra)->findAll();
        /*$this->detalle_compra->select('*');
        $this->detalle_compra->where('id_compra',$id_compra);
        $detalleCompra = $this->detalle_compra->findAll();
        */

        $pdf = new \FPDF('L','mm','letter');
        $pdf->AddPage();
        $pdf->SetMargins(5,10,10);
        $pdf->image(base_url().'/image/logoTransparente.png',230,5,14,16,'png');
        $pdf->SetTitle("Clientes");        
        $pdf->SetFont('Arial','B',14);      
        $pdf->Cell(40,5,utf8_decode($empresas['nombre']),0,1,'L');        
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(20,5,utf8_decode('Dirección: '),0,0,'L');
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(50,5,$empresas['direccion'],0,1,'L');
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(20,5,utf8_decode('Teléfonos: '),0,0,'L');
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(50,5,$empresas['telefonos'],0,1,'L');
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(20,5,'Email: ',0,0,'L');
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(100,5,$empresas['correo'],0,0,'L');
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(100,5,utf8_decode('Catálogo de Clientes a:  '). date('M-d-Y'),0,0,'L');
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(30,5,"Usuario: ". $session->usuario,0,0,'L');
        //$pdf->Line(10,46,210,46);
        $pdf->Ln();         
        $pdf->SetFont('Arial','B',10);
        $pdf->SetFillColor(86, 177, 124);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(264,5,'Detalles de Clientes',1,1,'C',1); //si colocamos el uno al final es que se toma la caracteristica de color: $pdf->Cell(200,5,'Detalles de Productos',1,1,'C',*1*);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(14,5,'Nro',1,0,'C');
        $pdf->Cell(10,5,'TD',1,0,'C');
        $pdf->Cell(25,5,'Documento',1,0,'C');
        $pdf->Cell(70,5,'Nombre del Tercero',1,0,'C');
        $pdf->Cell(50,5,utf8_decode('Direccion'),1,0,'C');
        $pdf->Cell(25,5,'Tipo',1,0,'C');
        $pdf->Cell(70,5,utf8_decode('Correo de Facturación'),1,1,'C');
        $pdf->SetFont('Arial','',8);
        $contador = 1;  
        $total = 0;  
        foreach($clientes as $row){
            $pdf->Cell(14,5,$contador,1,0,'C');
            $pdf->Cell(10,5,$row['resumen'],1,0,'L');
            $pdf->Cell(25,5,$row['numero_documento'],1,0,'L');
            $pdf->Cell(70,5,utf8_decode($row['razon_social']),1,0,'L');
            $pdf->Cell(50,5,utf8_decode($row['direccion']),1,0,'L');
            $pdf->Cell(25,5,utf8_decode($row['v_resumen']),1,0,'L');
            $pdf->Cell(70,5,utf8_decode($row['email_facturacion']),1,1,'L');
            $contador ++;
        }
        $pdf->Ln();       
        $this->response->setHeader('Content-Type', 'application/pdf');
        $pdf->Output("terceros.pdf", "I");
    }    
}
