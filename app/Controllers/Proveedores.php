<?php

namespace App\Controllers;


use App\Controllers\BaseController; /*la plantilla del controlador general de codeigniter */
use App\Models\RolesModel; /* clase a la cual se esta apuntando con los modelos */
use App\Models\ModulosModel;
use App\Models\ProveedoresModel;
use App\Models\DetalleParametrosModel;
use App\Models\PaisModel;
use App\Models\DepartamentosModel;
use App\Models\MunicipiosModel;
use App\Models\TercerosModel;
use App\Models\TemporalModel;
use App\Models\Correos_telefonosModel;
use App\Models\BancosModel;
use App\Models\EmpresasModel;


class Proveedores extends BaseController
{
    /*interactua el controlador con el modelo */
    protected $proveedores, $roles, $modulos,$detalleparametros,$tipo_proveedor,$pais,$tipo_documento;
    protected $reglas, $reglasLogin, $reglasCambia, $reglasActualiza,$departamentos,$municipios;
    protected $terceros,$temporal,$correos_telefonos,$tipo_Cuenta,$bancos,$empresas;

    public function __construct()
    {
        $this->proveedores = new ProveedoresModel();
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
        $this->bancos = new BancosModel();
        $this->empresas = new EmpresasModel();
    }

    public function index($activo = 1)
    {              
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        //$terceros = $this->terceros->where($where)->findAll();
        $proveedores = $this->proveedores->consulta_listaTerceros();
        $data = ['titulo' => 'MANEJO DE PROVEEDORES', 'datos' => $proveedores, 'roles' => $roles, 'modulos' => $modulos];
        
        echo view('header', $data);
        echo view('proveedores/proveedores', $data);
        echo view('footer');
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
        $proveedores = $this->proveedores->where('activo', $activo)->findAll();
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $where = " activo = 1 order by razon_social"; 
        $terceros = $this->terceros->where($where)->findAll();
        $data = ['titulo' => 'PROVEEDORES ELIMINADOS', 'datos' => $proveedores, 'roles' => $roles, 'modulos' => $modulos, 'terceros' => $terceros];
        /* mostramos la vista */
        echo view('header', $data);
        echo view('proveedores/eliminados', $data);
        echo view('footer');
    }


    public function nuevo()
    {               
        $tipo_Cliente = $this->detalleparametros->buscarDetalleParametros('Tipo de Cliente'); 
        $tipo_documento = $this->detalleparametros->buscarDetalleParametros('Tipo de Documento'); 
        $tipo_Cuenta = $this->detalleparametros->buscarDetalleParametros('Tipo de Cuenta Bancaria'); 
        $pais = $this->pais->where('activo', 1)->findAll();
        //$departamentos = $this->departamentos->where('activo', 1)->findAll();
        //$municipios = $this->municipios->where('activo', 1)->findAll();
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $where = " activo = 1 order by razon_social"; 
        $terceros = $this->terceros->where($where)->findAll(); 
        $bancos = $this->bancos->where('activo', 1)->findAll();
        $data = ['titulo' => 'DATOS DEL PROVEEDOR', 'roles' => $roles, 'modulos' => $modulos, 'tipo_documento' => $tipo_documento, 'tipo_Cliente' => $tipo_Cliente, 'pais' => $pais, 'terceros' => $terceros, 'tipo_cuenta' => $tipo_Cuenta, 'bancos' => $bancos];

        echo view('header', $data);
        echo view('proveedores/nuevo', $data);
        echo view('footer');
    }

    public function insertar()
    {
        if ($this->request->getMethod() == "post") {
            $session = session();

            $resultadoId = $this->proveedores->insertaProveedor($this->request->getPost('id'),$this->request->getPost('cargo'),$this->request->getPost('nombre_contacto'),$this->request->getPost('rep_legal'),$this->request->getPost('email_replegal'),$session->id_usuario);

            //Inserta en tabla de telefonos desde la tabla temporal
            $resultado_telefonos = $this->temporal->where('activo', 1)->findAll();
            foreach ($resultado_telefonos as $row) {
                if($row['clave']=='K'){$clave = $row['clave']. '_ctaProv';}else{$clave = $row['tipo']. '_contCte';}
                
                
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
            return redirect()->to(base_url() . '/proveedores');
        } else {
            $tipo_Cliente = $this->detalleparametros->buscarDetalleParametros('Tipo de Cliente'); 
            $tipo_documento = $this->detalleparametros->buscarDetalleParametros('Tipo de Documento'); 
            $pais = $this->pais->where('activo', 1)->findAll();
            $departamentos = $this->departamentos->where('activo', 1)->findAll();
            $municipios = $this->municipios->where('activo', 1)->findAll();            
            $roles = $this->roles->where('activo', 1)->findAll();
            $modulos = $this->modulos->buscar_modulos(1);
            $data = ['titulo' => 'CREAR PROVEEDORES', 'roles' => $roles,'modulos' => $modulos, 'tipo_documento' => $tipo_documento, 'tipo_Cliente' => $tipo_Cliente, 'pais' => $pais, 'departamentos' => $departamentos, 'municipios' => $municipios, 'validation' => $this->validator];
            echo view('header', $data);
            echo view('proveedores/nuevo', $data);
            echo view('footer');
        }
    }

    public function editar($id, $valid = null)
    {

        $proveedor = $this->proveedores->traerProveedor($id);
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $where = " activo = 1 order by razon_social"; 
        $terceros = $this->terceros->where($where)->findAll(); 
        $bancos = $this->bancos->where('activo', 1)->findAll();    
        $tipo_Cuenta = $this->detalleparametros->buscarDetalleParametros('Tipo de Cuenta Bancaria');   
        if ($valid !== null) {
            $data = ['titulo' => 'EDITAR PROVEEDOR', 'datos' => $proveedor, 'roles' => $roles, 'modulos' => $modulos, 'terceros' => $terceros, 'bancos' => $bancos, 'tipo_Cuenta' => $tipo_Cuenta, 'validation' => $valid];
        } else {
            $data = ['titulo' => 'EDITAR PROVEEDOR', 'datos' => $proveedor, 'roles' => $roles, 'terceros' => $terceros, 'bancos' => $bancos, 'tipo_Cuenta' => $tipo_Cuenta, 'modulos' => $modulos];
        }
        echo view('header', $data);
        echo view('proveedores/editar', $data);
        echo view('footer');
    }
    
    public function actualizar()
    {
        if ($this->request->getMethod() == "post" ) {
            $this->proveedores->update($this->request->getPost('id'), [
                'nombre_contacto' => $this->request->getPost('nombre_contacto'),
                'cargo' => $this->request->getPost('cargo'),
                'rep_legal' => $this->request->getPost('rep_legal'),
                'email_replegal' => $this->request->getPost('email_replegal')
            ]);
            return redirect()->to(base_url() . '/proveedores');
        } else {
            return $this->editar($this->request->getPost('id'), $this->validator);
        }
    }

    public function eliminar($id)
    {
        $this->proveedores->update($id, ['activo' => 0]);
        return redirect()->to(base_url() . '/proveedores');
    }
    public function activar($id)
    {
        $this->proveedores->update($id, ['activo' => 1]);
        return redirect()->to(base_url() . '/proveedores/eliminados');
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
            $datosUsuario = $this->proveedores->where('usuario', $usuario)->first(); //consulta            
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
                    //return redirect()->to(base_url() . '/proveedores');   // debemos redireccionar a la vista principal o a la que decidamos
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
        $usuario = $this->proveedores->where('id', $session->id_usuario)->first();
        $data = ['titulo' => 'CAMBIAR CONTRASEÑA', 'usuario' => $usuario];
        echo view('header');
        echo view('proveedores/cambia_password', $data);
        echo view('footer');
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

    public function buscarProveedor($id)
    {
        $returnData = array();
        $proveedores = $this->proveedores->buscarProveedor($id);
        if (!empty($proveedores)) {array_push($returnData, $proveedores);}
        echo json_encode($returnData);      
    }

    function muestraProveedoresPdf(){
        $proveedores = $this->proveedores->consulta_listaTerceros();
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $data = ['titulo' => 'Reporte de Proveedores','datos' => $proveedores, 'roles' => $roles, 'modulos' => $modulos];
        echo view('header',$data);
        echo view('/proveedores/verProveedores_pdf',$data);
        echo view('footer');
    }

    function reporteProveedoresPdf()
    {
        $session = session();
        $empresas = $this->empresas->where('id_empresa',1)->first();
        $proveedores = $this->proveedores->consulta_listaTerceros();
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
        $pdf->SetTitle("Proveedores");        
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
        $pdf->Cell(100,5,utf8_decode('Catálogo de Proveedores a:  '). date('M-d-Y'),0,0,'L');
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(30,5,"Usuario: ". $session->usuario,0,0,'L');
        //$pdf->Line(10,46,210,46);
        $pdf->Ln();         
        $pdf->SetFont('Arial','B',10);
        $pdf->SetFillColor(86, 177, 124);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(264,5,'Detalles de Proveedores',1,1,'C',1); //si colocamos el uno al final es que se toma la caracteristica de color: $pdf->Cell(200,5,'Detalles de Productos',1,1,'C',*1*);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(14,5,'Nro',1,0,'C');
        $pdf->Cell(10,5,'TD',1,0,'C');
        $pdf->Cell(25,5,'Documento',1,0,'C');
        $pdf->Cell(70,5,'Nombre del Tercero',1,0,'C');
        $pdf->Cell(50,5,utf8_decode('Direccion'),1,0,'C');
        $pdf->Cell(25,5,'Tipo',1,0,'C');
        $pdf->Cell(70,5,utf8_decode('Contacto'),1,1,'C');
        $pdf->SetFont('Arial','',8);
        $contador = 1;  
        $total = 0;  
        foreach($proveedores as $row){
            $pdf->Cell(14,5,$contador,1,0,'C');
            $pdf->Cell(10,5,$row['resumen'],1,0,'L');
            $pdf->Cell(25,5,$row['numero_documento'],1,0,'L');
            $pdf->Cell(70,5,utf8_decode($row['razon_social']),1,0,'L');
            $pdf->Cell(50,5,utf8_decode($row['direccion']),1,0,'L');
            $pdf->Cell(25,5,utf8_decode($row['v_resumen']),1,0,'L');
            $pdf->Cell(70,5,utf8_decode($row['nombre_contacto']),1,1,'L');
            $contador ++;
        }
        $pdf->Ln();       
        $this->response->setHeader('Content-Type', 'application/pdf');
        $pdf->Output("terceros.pdf", "I");
    }    
}
