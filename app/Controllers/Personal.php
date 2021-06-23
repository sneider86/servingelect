<?php

namespace App\Controllers;


use App\Controllers\BaseController; /*la plantilla del controlador general de codeigniter */
use App\Models\RolesModel; /* clase a la cual se esta apuntando con los modelos */
use App\Models\ModulosModel;
use App\Models\PersonalModel;
use App\Models\DetalleParametrosModel;
use App\Models\PaisModel;
use App\Models\DepartamentosModel;
use App\Models\MunicipiosModel;
use App\Models\TercerosModel;
use App\Models\TemporalModel;
use App\Models\Correos_telefonosModel;
use App\Models\BancosModel;
use App\Models\CargosModel;
use App\Models\EmpresasModel;

class Personal extends BaseController
{
    /*interactua el controlador con el modelo */
    protected $personal, $roles, $modulos, $detalleparametros, $tipo_proveedor, $pais, $tipo_documento;
    protected $reglas, $reglasLogin, $reglasCambia, $reglasActualiza, $departamentos, $municipios;
    protected $terceros, $temporal, $correos_telefonos, $tipo_Cuenta, $bancos, $cargos, $ruta,$empresas;

    public function __construct()
    {
        $this->personal = new PersonalModel();
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
        $this->cargos = new CargosModel();
        $this->empresas = new EmpresasModel();
    }

    public function index($activo = 1)
    {
        $roles = $this->roles->where('activo', 1)->findAll();
        $where = " activo = 1 order by padre_id,orden";
        $modulos = $this->modulos->buscar_modulos(1);
        $personal = $this->personal->consulta_listaTerceros();
        $data = ['titulo' => 'MANEJO DE PERSONAL', 'datos' => $personal, 'roles' => $roles, 'modulos' => $modulos];

        echo view('header', $data);
        echo view('personal/personal', $data);
        echo view('footer');
    }

    public function getDepartamentos()
    {
        $codpais = $_POST['codpais'];
        $where = "id_pais= $codpais order by nombre";
        $datos = $this->departamentos->where($where)->findAll();
        $cadena = "<select id='departamento' name='departamento'>";

        foreach ($datos as $row) {
            $cadena = $cadena . '<option value=' . $row['codigo'] . '>' . $row['nombre'] . '</option>';
        }
        echo $cadena . "</select>";
        //echo json_encode($departamentos);
    }

    public function getMunicipios()
    {
        $coddepartamento = $_POST['coddepartamento'];
        $where = "id_departamento= $coddepartamento order by nombre ";
        $datos = $this->municipios->where($where)->findAll();
        $cadena = "<select id='municipio' name='municipio'>";

        foreach ($datos as $row) {
            $cadena = $cadena . '<option value=' . $row['codigo'] . '>' . utf8_encode($row['nombre']) . '</option>';
        }
        echo $cadena . "</select>";
        //echo json_encode($departamentos);
    }

    public function eliminados($activo = 0)
    {
        $personal = $this->personal->where('activo', $activo)->findAll();
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $where = " activo = 1 order by razon_social";
        $terceros = $this->terceros->where($where)->findAll();
        $data = ['titulo' => 'PROVEEDORES ELIMINADOS', 'datos' => $personal, 'roles' => $roles, 'modulos' => $modulos, 'terceros' => $terceros];
        /* mostramos la vista */
        echo view('header', $data);
        echo view('personal/eliminados', $data);
        echo view('footer');
    }

    public function nuevo()
    {
        $tipo_Cliente = $this->detalleparametros->buscarDetalleParametros('Tipo de Cliente');
        $tipo_documento = $this->detalleparametros->buscarDetalleParametros('Tipo de Documento');
        $tipo_Cuenta = $this->detalleparametros->buscarDetalleParametros('Tipo de Cuenta Bancaria');
        $genero = $this->detalleparametros->buscarDetalleParametros('Género');
        $estado_civil = $this->detalleparametros->buscarDetalleParametros('Estado Civil');
        $tipo_sangre = $this->detalleparametros->buscarDetalleParametros('Tipo de Sangre');
        $tipo_personal = $this->detalleparametros->buscarDetalleParametros('Tipo de Personal');
        $libreta_militar = $this->detalleparametros->buscarDetalleParametros('Libreta Militar');
        $camisa = $this->detalleparametros->buscarDetalleParametros('Tallas de Camisa');
        $pantalon = $this->detalleparametros->buscarDetalleParametros('Tallas de Pantalon');
        $zapatos = $this->detalleparametros->buscarDetalleParametros('Tallas de Zapatos');
        $guantes = $this->detalleparametros->buscarDetalleParametros('Tallas de Guantes');
        $parentesco = $this->detalleparametros->buscarDetalleParametros('Parentesco');
        $pais = $this->pais->where('activo', 1)->findAll();
        //$departamentos = $this->departamentos->where('activo', 1)->findAll();
        //$municipios = $this->municipios->where('activo', 1)->findAll();
        $roles = $this->roles->where('activo', 1)->findAll();
        $cargos = $this->cargos->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $where = " activo = 1 order by razon_social";
        $terceros = $this->terceros->where($where)->findAll();
        $where = " activo = 1 order by nombre";
        $bancos = $this->bancos->where($where)->findAll();
        $data = ['titulo' => 'DATOS DEL PERSONAL', 'roles' => $roles, 'modulos' => $modulos, 'tipo_documento' => $tipo_documento, 'tipo_Cliente' => $tipo_Cliente, 'pais' => $pais, 'terceros' => $terceros, 'tipo_cuenta' => $tipo_Cuenta, 'bancos' => $bancos, 'tipo_personal' => $tipo_personal, 'genero' => $genero, 'camisa' => $camisa, 'pantalon' => $pantalon, 'zapatos' => $zapatos, 'guantes' => $guantes, 'estado_civil' => $estado_civil, 'tipo_sangre' => $tipo_sangre, 'libreta_militar' => $libreta_militar, 'cargos' => $cargos, 'parentesco' => $parentesco];

        echo view('header', $data);
        echo view('personal/nuevo', $data);
        echo view('footer');
    }

    public function insertar()
    {
        if ($this->request->getMethod() == "post") {
            $session = session();
            $this->personal->save([
                'id_tercero' => $this->request->getPost('id'),
                'tipo_persona' => $this->request->getPost('tipo_persona'),
                'cargo' => $this->request->getPost('cargo'),
                'estado_civil' => $this->request->getPost('estado_civil'),
                'genero' => $this->request->getPost('genero'),
                'tipo_sangre' => $this->request->getPost('tipo_sangre'),
                'clase_libreta' => $this->request->getPost('clase_libreta'),
                'numero_libreta' => $this->request->getPost('numero_libreta'),
                'camisa' => $this->request->getPost('camisa'),
                'pantalon' => $this->request->getPost('pantalon'),
                'zapatos' => $this->request->getPost('zapatos'),
                'guantes' => $this->request->getPost('guantes'),
                'cuenta_pago' => $this->request->getPost('cuenta_pago'),
                'tipo_cuenta' => $this->request->getPost('tipoCuenta_pago'),
                'banco_pago' => $this->request->getPost('banco_pago'),
                'nombres_contacto' => $this->request->getPost('nombres_contacto'),
                'direccion_contacto' => $this->request->getPost('direccion_contacto'),
                'fijo_contacto' => $this->request->getPost('fijo_contacto'),
                'movil_contacto' => $this->request->getPost('movil_contacto'),
                'parentesco' => $this->request->getPost('parentesco'),
                'sucursal' => 1,
                'usuario_crea' => $session->id_usuario
            ]);

            return redirect()->to(base_url() . '/personal');
        } else {
            $tipo_Cliente = $this->detalleparametros->buscarDetalleParametros('Tipo de Cliente');
            $tipo_documento = $this->detalleparametros->buscarDetalleParametros('Tipo de Documento');
            $tipo_Cuenta = $this->detalleparametros->buscarDetalleParametros('Tipo de Cuenta Bancaria');
            $genero = $this->detalleparametros->buscarDetalleParametros('Género');
            $estado_civil = $this->detalleparametros->buscarDetalleParametros('Estado Civil');
            $tipo_sangre = $this->detalleparametros->buscarDetalleParametros('Tipo de Sangre');
            $tipo_personal = $this->detalleparametros->buscarDetalleParametros('Tipo de Personal');
            $libreta_militar = $this->detalleparametros->buscarDetalleParametros('Libreta Militar');
            $camisa = $this->detalleparametros->buscarDetalleParametros('Tallas de Camisa');
            $pantalon = $this->detalleparametros->buscarDetalleParametros('Tallas de Pantalon');
            $zapatos = $this->detalleparametros->buscarDetalleParametros('Tallas de Zapatos');
            $guantes = $this->detalleparametros->buscarDetalleParametros('Tallas de Guantes');
            $parentesco = $this->detalleparametros->buscarDetalleParametros('Parentesco');
            $pais = $this->pais->where('activo', 1)->findAll();
            //$departamentos = $this->departamentos->where('activo', 1)->findAll();
            //$municipios = $this->municipios->where('activo', 1)->findAll();
            $roles = $this->roles->where('activo', 1)->findAll();
            $cargos = $this->cargos->where('activo', 1)->findAll();
            $modulos = $this->modulos->buscar_modulos(1);
            $where = " activo = 1 order by razon_social";
            $terceros = $this->terceros->where($where)->findAll();
            $where = " activo = 1 order by nombre";
            $bancos = $this->bancos->where($where)->findAll();
            $data = ['titulo' => 'DATOS DEL PERSONAL', 'roles' => $roles, 'modulos' => $modulos, 'tipo_documento' => $tipo_documento, 'tipo_Cliente' => $tipo_Cliente, 'pais' => $pais, 'terceros' => $terceros, 'tipo_cuenta' => $tipo_Cuenta, 'bancos' => $bancos, 'tipo_personal' => $tipo_personal, 'genero' => $genero, 'camisa' => $camisa, 'pantalon' => $pantalon, 'zapatos' => $zapatos, 'guantes' => $guantes, 'estado_civil' => $estado_civil, 'tipo_sangre' => $tipo_sangre, 'libreta_militar' => $libreta_militar, 'cargos' => $cargos, 'parentesco' => $parentesco];
            echo view('header', $data);
            echo view('personal/nuevo', $data);
            echo view('footer');
        }
    }

    public function editar($id, $valid = null)
    {       
        $persona = $this->personal->traerPersona($id);

        $tipo_personal = $this->detalleparametros->buscarDetalleParametros('Tipo de Personal');
        $cargos = $this->cargos->where('activo', 1)->findAll();
        $estado_civil = $this->detalleparametros->buscarDetalleParametros('Estado Civil');
        $genero = $this->detalleparametros->buscarDetalleParametros('Género');
        $tipo_sangre = $this->detalleparametros->buscarDetalleParametros('Tipo de Sangre');
        $libreta_militar = $this->detalleparametros->buscarDetalleParametros('Libreta Militar');
        $camisa = $this->detalleparametros->buscarDetalleParametros('Tallas de Camisa');
        $pantalon = $this->detalleparametros->buscarDetalleParametros('Tallas de Pantalon');
        $zapatos = $this->detalleparametros->buscarDetalleParametros('Tallas de Zapatos');
        $guantes = $this->detalleparametros->buscarDetalleParametros('Tallas de Guantes');
        $tipo_Cuenta = $this->detalleparametros->buscarDetalleParametros('Tipo de Cuenta Bancaria');
        $where = " activo = 1 order by nombre";
        $bancos = $this->bancos->where($where)->findAll();
        $parentesco = $this->detalleparametros->buscarDetalleParametros('Parentesco');

        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        if ($valid !== null) {
            $data = ['titulo' => 'EDITAR USUARIO', 'datos' => $persona, 'roles' => $roles, 'modulos' => $modulos, 'tipo_personal' => $tipo_personal, 'cargos' => $cargos, 'estado_civil' => $estado_civil, 'genero' => $genero, 'tipo_sangre' => $tipo_sangre, 'libreta_militar' => $libreta_militar, 'camisa' => $camisa, 'pantalon' => $pantalon, 'zapatos' => $zapatos, 'guantes' => $guantes, 'tipo_cuenta' => $tipo_Cuenta, 'bancos' => $bancos, 'validation' => $valid];
        } else {
            $data = ['titulo' => 'EDITAR USUARIO', 'datos' => $persona, 'roles' => $roles,'tipo_personal' => $tipo_personal, 'cargos' => $cargos, 'estado_civil' => $estado_civil, 'genero' => $genero, 'tipo_sangre' => $tipo_sangre, 'libreta_militar' => $libreta_militar, 'modulos' => $modulos, 'camisa' => $camisa, 'pantalon' => $pantalon, 'zapatos' => $zapatos, 'guantes' => $guantes, 'tipo_cuenta' => $tipo_Cuenta, 'bancos' => $bancos, 'parentesco' => $parentesco];
        }
        echo view('header', $data);
        echo view('personal/editar', $data);
        echo view('footer');
    }
    public function actualizar()
    {
        if ($this->request->getMethod() == "post" ) {
            //$hash = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
            $this->personal->update($this->request->getPost('id'), [
                'tipo_persona' => $this->request->getPost('tipo_persona'),
                'cargo' => $this->request->getPost('cargo'),
                'estado_civil' => $this->request->getPost('estado_civil'),
                'genero' => $this->request->getPost('genero'),
                'tipo_sangre' => $this->request->getPost('tipo_sangre'),
                'clase_libreta' => $this->request->getPost('clase_libreta'),
                'numero_libreta' => $this->request->getPost('numero_libreta'),
                'camisa' => $this->request->getPost('camisa'),
                'pantalon' => $this->request->getPost('pantalon'),
                'zapatos' => $this->request->getPost('zapatos'),
                'guantes' => $this->request->getPost('guantes'),
                'cuenta_pago' => $this->request->getPost('cuenta_pago'),
                'tipo_cuenta' => $this->request->getPost('tipoCuenta_pago'),
                'banco_pago' => $this->request->getPost('banco_pago'),
                'nombres_contacto' => $this->request->getPost('nombres_contacto'),
                'direccion_contacto' => $this->request->getPost('direccion_contacto'),
                'fijo_contacto' => $this->request->getPost('fijo_contacto'),
                'movil_contacto' => $this->request->getPost('movil_contacto'),
                'parentesco' => $this->request->getPost('parentesco'),
                'curso_altura' => $this->request->getPost('curso_altura'),
                'fechav_curso' => $this->request->getPost('fechav_curso')
            ]);
            return redirect()->to(base_url() . '/personal');
        } else {
            return $this->editar($this->request->getPost('id'), $this->validator);
        }
    }

    public function eliminar($id)
    {
        $this->personal->update($id, ['activo' => 0]);
        return redirect()->to(base_url() . '/personal');
    }
    public function activar($id)
    {
        $this->personal->update($id, ['activo' => 1]);
        return redirect()->to(base_url() . '/personal/eliminados');
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
            $datosUsuario = $this->personal->where('usuario', $usuario)->first(); //consulta            
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
                    //return redirect()->to(base_url() . '/personal');   // debemos redireccionar a la vista principal o a la que decidamos
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

    public function buscarPorPaises($codigo)
    {
        $this->departamentos->select('*');
        $this->departamentos->where('id_pais', $codigo);
        $this->departamentos->where('activo', 1);
        $datos = $this->departamentos->findAll(); //traer fila del producto encontrados
        $departamentos = array();
        $data = ['departamentos' => $departamentos];
    }

    public function municipiosPorDepartamentos($pais, $codigo)
    {
        $this->municipios->select('*');
        $this->municipios->where('id_pais', $pais);
        $this->municipios->where('id_departamento', $codigo);
        $this->municipios->where('activo', 1);
        $datos = $this->municipios->findAll(); //traer fila del producto encontrados
        $municipios = array();
        $data = ['municipios' => $municipios];
    }

    public function buscarPersonal($id)
    {
        $returnData = array();
        $personal = $this->personal->buscarPersonal($id);
        if (!empty($personal)) {
            array_push($returnData, $personal);
        }
        echo json_encode($returnData);
    }

    public function subir()
    {

        $ruta = $this->request->getPost('ruta');
        $archivo = $this->request->getPost('textFile');
        echo 'Aqui --> ' . $ruta;
        exit;
        $archivo = $_FILES['archivo'];
        $resultado = move_uploaded_file($archivo, $ruta . $archivo);
        if ($resultado) {
            echo "Subido con éxito";
        } else {
            echo "Error al subir archivo";
        }
    }

    function muestraPersonalPdf(){
        $personal = $this->personal->consulta_listaTerceros();
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $data = ['titulo' => 'Reporte de Personal','datos' => $personal, 'roles' => $roles, 'modulos' => $modulos];
        echo view('header',$data);
        echo view('/personal/verPersonal_pdf',$data);
        echo view('footer');
    }

    function reportePersonalPdf()
    {
        $session = session();
        $empresas = $this->empresas->where('id_empresa',1)->first();
        $personal = $this->personal->consulta_listaTerceros();
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
        $pdf->Cell(100,5,utf8_decode('Catálogo de Personal a:  '). date('M-d-Y'),0,0,'L');
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
        $pdf->Cell(70,5,utf8_decode('Contacto'),1,1,'C');
        $pdf->SetFont('Arial','',8);
        $contador = 1;  
        $total = 0;  
        foreach($personal as $row){
            $pdf->Cell(14,5,$contador,1,0,'C');
            $pdf->Cell(10,5,$row['resumen'],1,0,'L');
            $pdf->Cell(25,5,$row['numero_documento'],1,0,'L');
            $pdf->Cell(70,5,utf8_decode($row['razon_social']),1,0,'L');
            $pdf->Cell(50,5,utf8_decode($row['direccion']),1,0,'L');
            $pdf->Cell(25,5,utf8_decode($row['v_resumen']),1,0,'L');
            $pdf->Cell(70,5,utf8_decode($row['nombres_contacto']),1,1,'L');
            $contador ++;
        }
        $pdf->Ln();       
        $this->response->setHeader('Content-Type', 'application/pdf');
        $pdf->Output("terceros.pdf", "I");
    }        
}
