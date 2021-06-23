<?php

namespace App\Controllers;


use App\Controllers\BaseController; /*la plantilla del controlador general de codeigniter */
use App\Models\RolesModel; /* clase a la cual se esta apuntando con los modelos */
use App\Models\ModulosModel;
use App\Models\TercerosModel;
use App\Models\DetalleParametrosModel;
use App\Models\PaisModel;
use App\Models\DepartamentosModel;
use App\Models\MunicipiosModel;
use App\Models\Correos_telefonosModel;
use App\Models\TemporalModel;
use App\Models\ActividadesModel;
use App\Models\RegimenesModel;
use App\Models\ResponsabilidadesModel;
use App\Models\EmpresasModel;
use App\Models\PermisosModel;

class Terceros extends BaseController
{
    /*interactua el controlador con el modelo */
    protected $terceros, $roles, $modulos, $detalleparametros, $tipo_tercero, $pais, $tipo_documento;
    protected $reglas, $reglasLogin, $reglasCambia, $reglasActualiza, $departamentos, $municipios;
    protected $correos_telefonos, $temporal, $actividades, $responsabilidades, $regimenes;
    protected $telefono_fijo, $telefono_movil, $actividad,$empresas,$permisos;

    public function __construct()
    {
        $this->terceros = new TercerosModel();
        $this->roles = new RolesModel();
        $this->modulos = new ModulosModel();
        $this->detalleparametros = new DetalleParametrosModel();
        $this->tipo_tercero = new DetalleParametrosModel();
        $this->tipo_documento = new DetalleParametrosModel();
        $this->pais = new PaisModel();
        $this->departamentos = new DepartamentosModel();
        $this->municipios = new MunicipiosModel();
        $this->correos_telefonos = new Correos_telefonosModel();
        $this->temporal = new TemporalModel();
        $this->actividades = new ActividadesModel();
        $this->responsabilidades = new ResponsabilidadesModel();
        $this->regimenes = new RegimenesModel();
        $this->telefono_fijo = new Correos_telefonosModel();
        $this->telefono_movil = new Correos_telefonosModel();
        $this->actividad = new Correos_telefonosModel();
        $this->empresas = new EmpresasModel();
        $this->permisos = new PermisosModel();

        helper(['form']);
    }

    public function index($activo = 1)
    {
        $session = session();
        if($session->id_rol!=1){
            $verTerceros = $this->permisos->obtenerPermiso($session->id_rol,'Ver Terceros');
            $agregar = $this->permisos->obtenerPermiso($session->id_rol,'Agregar Tercero');
            $editar = $this->permisos->obtenerPermiso($session->id_rol,'Editar Tercero');
            $actualizar = $this->permisos->obtenerPermiso($session->id_rol, 'Actualizar Tercero');
            $eliminar = $this->permisos->obtenerPermiso($session->id_rol,'Eliminar Tercero');
            $reporte = $this->permisos->obtenerPermiso($session->id_rol,'Reporte de Terceros');
        }else{
            $verTerceros = "enabled='true'";
            $agregar = "enabled='true'";
            $editar = "enabled='true'";
            $actualizar = "enabled='true'";
            $eliminar = "enabled='true'";
            $reporte = "enabled='true'";           
        }      

        if ($verTerceros=="enabled='true'") {
            $terceros = $this->terceros->listaTercero($activo = 1);
            $roles = $this->roles->where('activo', 1)->findAll();
            $modulos = $this->modulos->buscar_modulos(1);
            $data = ['titulo' => 'MANEJO DE TERCEROS', 'datos' => $terceros, 'roles' => $roles, 'modulos' => $modulos, 'agregar' => $agregar, 'editar' => $editar,'eliminar' => $eliminar, 'actualizar' => $actualizar, 'reporte' => $reporte];
            echo view('header', $data);
            echo view('terceros/terceros', $data);
            echo view('footer');
        }else{
            return redirect()->to(base_url(). '/principal');
        }
    }

    public function getDepartamentos($codpais = 2)
    {
        //$codpais = $_POST['pais'];       
        $where = "id_pais= $codpais order by nombre";
        $datos = $this->departamentos->where($where)->findAll();
        $cadena = "<select id='departamento' name='departamento'>";
        foreach ($datos as $row) {
            $cadena = $cadena . '<option value=' . $row['id'] . '>' . $row['nombre'] . '</option>';
        }
        echo $cadena . "</select>";
        //echo json_encode($departamentos);
    }

    public function getMunicipios($coddepartamento = 0)
    {
        //$coddepartamento = $_POST['coddepartamento'];
        $where = "id_departamento= $coddepartamento order by nombre ";
        $datos = $this->municipios->where($where)->findAll();
        $cadena = "<select id='municipio' name='municipio'>";

        foreach ($datos as $row) {
            $cadena = $cadena . '<option value=' . $row['id'] . '>' . utf8_encode($row['nombre']) . '</option>';
        }
        echo $cadena . "</select>";
        //echo json_encode($departamentos);
    }

    public function eliminados($activo = 0)
    {
        $session = session();
        if ($session->id_rol!=1) {
            $activar = $this->permisos->obtenerPermiso($session->id_rol, 'Activar Rol');
        }else{$activar = "enabled='true'"; }
        $terceros = $this->terceros->listaTercero($activo);
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        //$terceros = $this->terceros->where('activo', $activo)->findAll();
        $data = ['titulo' => 'TERCEROS ELIMINADOS', 'datos' => $terceros, 'roles' => $roles, 'modulos' => $modulos,'activar'=>$activar];
        /* mostramos la vista */
        echo view('header', $data);
        echo view('terceros/eliminados', $data);
        echo view('footer');
    }

    public function nuevo()
    {
        $tipo_tercero = $this->detalleparametros->buscarDetalleParametros('Tipo de Tercero');
        $tipo_documento = $this->detalleparametros->buscarDetalleParametros('Tipo de Documento');
        $pais = $this->pais->where('activo', 1)->findAll();
        //$departamentos = $this->departamentos->where('activo', 1)->findAll();
        //$municipios = $this->municipios->where('activo', 1)->findAll();
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $actividades = $this->actividades->where('activo', 1)->findAll();
        $responsabilidades = $this->responsabilidades->where('activo', 1)->findAll();
        $regimenes = $this->regimenes->where('activo', 1)->findAll();
        $data = ['titulo' => 'CREAR TERCEROS', 'roles' => $roles, 'modulos' => $modulos, 'tipo_documento' => $tipo_documento, 'tipo_tercero' => $tipo_tercero, 'pais' => $pais, 'actividades' => $actividades, 'responsabilidades' => $responsabilidades, 'regimenes' => $regimenes];
        echo view('header', $data);
        echo view('terceros/nuevo', $data);
        echo view('footer');
    }

    public function insertar()
    {
        if ($this->request->getMethod() == "post") {
            $session = session();
            $p_nombre = strtoupper($this->request->getPost('p_nombre'));
            $s_nombre = strtoupper($this->request->getPost('s_nombre'));
            $p_apellido = strtoupper($this->request->getPost('p_apellido'));
            $s_apellido = strtoupper($this->request->getPost('s_apellido'));

            if ($this->request->getPost('tipo_tercero') == 4) {
                $r_social = $p_nombre . ' ' . $s_nombre . ' ' . $p_apellido . ' ' . $s_apellido;
            } else {
                $r_social = $this->request->getPost('razon_social');
                $p_nombre = "";
                $s_nombre = "";
                $p_apellido = "";
                $s_apellido = "";
            }

            $resultadoId = $this->terceros->insertaTercero($this->request->getPost('tipo_documento'), $this->request->getPost('numero_documento'), 0, strtoupper($p_nombre), strtoupper($s_nombre), strtoupper($p_apellido), strtoupper($s_apellido), $r_social, $this->request->getPost('tipo_tercero'), $this->request->getPost('direccion'), $this->request->getPost('pais'), $this->request->getPost('departamento'), $this->request->getPost('municipio'), $this->request->getPost('responsabilidad'), $this->request->getPost('regimen'), $session->id_usuario);
            //Inserta en tabla de telefonos desde la tabla temporal
            $resultado_telefonos = $this->temporal->where('activo', 1)->findAll();
            foreach ($resultado_telefonos as $row) {
                $clave = $row['tipo'] . '_Terc';
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

            return redirect()->to(base_url() . '/terceros');
        } else {
            $tipo_Tercero = $this->detalleparametros->buscarDetalleParametros('Tipo de Tercero');
            $tipo_documento = $this->detalleparametros->buscarDetalleParametros('Tipo de Documento');
            $pais = $this->pais->where('activo', 1)->findAll();
            $departamentos = $this->departamentos->where('activo', 1)->findAll();
            $municipios = $this->municipios->where('activo', 1)->findAll();
            $roles = $this->roles->where('activo', 1)->findAll();
            $modulos = $this->modulos->buscar_modulos(1);
            $actividades = $this->actividades->where('activo', 1)->findAll();
            $data = ['titulo' => 'CREAR TERCEROS', 'roles' => $roles, 'modulos' => $modulos, 'tipo_documento' => $tipo_documento, 'tipo_Tercero' => $tipo_Tercero, 'pais' => $pais, 'departamentos' => $departamentos, 'municipios' => $municipios, 'actividades' => $actividades, 'validation' => $this->validator];
            echo view('header', $data);
            echo view('terceros/nuevo', $data);
            echo view('footer');
        }
    }

    public function editar($id, $valid = null)
    {
        $session = session();
        if ($session->id_rol!=1) {
            $actualizar = $this->permisos->obtenerPermiso($session->id_rol, 'Actualizar Tercero');
        }else{$actualizar = "enabled='true'"; }        

        $tipo_tercero = $this->detalleparametros->buscarDetalleParametros('Tipo de Tercero');
        $tipo_documento = $this->detalleparametros->buscarDetalleParametros('Tipo de Documento');
        $pais = $this->pais->where('activo', 1)->findAll();
        $departamentos = $this->departamentos->where('activo', 1)->findAll();
        $municipios = $this->municipios->where('activo', 1)->findAll();
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $actividades = $this->actividades->where('activo', 1)->findAll();
        $responsabilidades = $this->responsabilidades->where('activo', 1)->findAll();
        $regimenes = $this->regimenes->where('activo', 1)->findAll();
        $terceros = $this->terceros->mostrarTerceros($id);
        $correos_telefonos = $this->correos_telefonos->porTercero($id, 'E_Terc');
        if ($correos_telefonos == null) {
            $correos_telefonos['valor'] = "";
        }
        $telefono_fijo = $this->correos_telefonos->porTercero($id, 'F_Terc');
        if ($telefono_fijo == null) {
            $telefono_fijo['valor'] = "";
        }
        $telefono_movil = $this->correos_telefonos->porTercero($id, 'C_Terc');
        if ($telefono_movil == null) {
            $telefono_movil['valor'] = "";
        }
        $actividad = $this->correos_telefonos->porTercero($id, 'A_Terc');
        if ($actividad == null) {
            $actividad['valor'] = "";
        }

        if ($valid !== null) {
            $data = ['titulo' => 'EDITAR TERCEROS', 'datos' => $terceros, 'roles' => $roles, 'modulos' => $modulos, 'tipo_documento' => $tipo_documento, 'tipo_tercero' => $tipo_tercero, 'pais' => $pais, 'actividades' => $actividades, 'responsabilidades' => $responsabilidades, 'regimenes' => $regimenes, 'departamentos' => $departamentos, 'municipios' => $municipios, 'correos_telefonos' => $correos_telefonos, 'telefono_fijo' => $telefono_fijo, 'telefono_movil' => $telefono_movil, 'actividad' => $actividad,'actualizar'=>$actualizar];
        } else {
            $data = ['titulo' => 'EDITAR TERCEROS', 'datos' => $terceros, 'roles' => $roles, 'modulos' => $modulos, 'tipo_documento' => $tipo_documento, 'tipo_tercero' => $tipo_tercero, 'pais' => $pais, 'actividades' => $actividades, 'responsabilidades' => $responsabilidades, 'regimenes' => $regimenes, 'departamentos' => $departamentos, 'municipios' => $municipios, 'correos_telefonos' => $correos_telefonos, 'telefono_fijo' => $telefono_fijo, 'telefono_movil' => $telefono_movil, 'actividad' => $actividad,'actualizar'=>$actualizar];
        }
        echo view('header', $data);
        echo view('terceros/editar', $data);
        echo view('footer');
    }
    public function actualizar()
    {
        $session = session();
        $p_nombre = strtoupper($this->request->getPost('p_nombre'));
        $s_nombre = strtoupper($this->request->getPost('s_nombre'));
        $p_apellido = strtoupper($this->request->getPost('p_apellido'));
        $s_apellido = strtoupper($this->request->getPost('s_apellido'));

        if ($this->request->getPost('tipo_tercero') == 4) {
            $r_social = $p_nombre . ' ' . $s_nombre . ' ' . $p_apellido . ' ' . $s_apellido;
        } else {
            $r_social = $this->request->getPost('razon_social');
            $p_nombre = "";
            $s_nombre = "";
            $p_apellido = "";
            $s_apellido = "";
        }

        if ($this->request->getMethod() == "post") {
            //$hash = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
            $this->terceros->update($this->request->getPost('id'), [
                'tipo_documento' => $this->request->getPost('tipo_documento'),
                'numero_documento' => $this->request->getPost('numero_documento'),
                'dv' => $this->request->getPost('dv'),
                'p_nombre' => $this->request->getPost('p_nombre'),
                's_nombre' => $this->request->getPost('s_nombre'),
                'p_apellido' => $this->request->getPost('p_apellido'),
                's_apellido' => $this->request->getPost('s_apellido'),
                'razon_social' => $this->request->getPost('razon_social'),
                'tipo_tercero' => $this->request->getPost('tipo_tercero'),
                'direccion' => $this->request->getPost('direccion'),
                'pais' => $this->request->getPost('pais'),
                'departamento' => $this->request->getPost('departamento'),
                'municipio' => $this->request->getPost('municipio'),
                'responsabilidad' => $this->request->getPost('responsabilidad'),
                'regimen' => $this->request->getPost('regimen')
            ]);
            return redirect()->to(base_url() . '/terceros');
        }
    }

    public function eliminar($id)
    {
        $this->terceros->update($id, ['activo' => 0]);
        return redirect()->to(base_url() . '/terceros');
    }
    public function activar($id)
    {
        $this->terceros->update($id, ['activo' => 1]);
        return redirect()->to(base_url() . '/terceros/eliminados');
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
            $datosUsuario = $this->terceros->where('usuario', $usuario)->first(); //consulta            
            if ($datosUsuario != null) {
                if (password_verify($password, $datosUsuario['password'])) {  //verificamos el password que sed trae en la consulta con el que oingresa el usuario
                    $datosRol = $this->roles->where('id', $datosUsuario['id_rol'])->first();
                    $datosSesion = [ //creamos la variable de sesion en modo arreglo
                        'id_usuario' => $datosUsuario['id'],
                        'nombres' => $datosUsuario['nombres'],
                        'email' => $datosUsuario['email'],
                        'usuario' => $datosUsuario['usuario'],
                        'id_rol' => $datosUsuario['id_rol'],
                        'nombre_rol' => $datosRol['nombre']
                    ];
                    $session = session(); //variabloe de sesion a la cual le establecemos la sesion ($session y puede ser cualquier nombre de variable)
                    $session->set($datosSesion); //y a la nueva $session le asignamos el arreglo $datosSesion y ya nos crearia las variables de sesion para poder trabajar
                    //return redirect()->to(base_url() . '/terceros');   // debemos redireccionar a la vista principal o a la que decidamos
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
        $usuario = $this->terceros->where('id', $session->id_usuario)->first();
        $data = ['titulo' => 'CAMBIAR CONTRASEÑA', 'usuario' => $usuario];
        echo view('header');
        echo view('terceros/cambia_password', $data);
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
            $this->terceros->update($id_usuario, ['password' => $hash]);
            $usuario = $this->terceros->where('id', $session->id_usuario)->first();
            $data = ['titulo' => 'CAMBIAR CONTRASEÑA', 'usuario' => $usuario, 'mensaje' => 'Cambio de Contraseña Exitoso', 'roles' => $roles, 'modulos' => $modulos];

            echo view('header', $data);
            echo view('terceros/cambia_password', $data);
            echo view('footer');
        } else {
            $session = session(); //para tomar el id del usuario de la sesion logueada 
            $usuario = $this->terceros->where('id', $session->id_usuario)->first();
            $data = ['titulo' => 'CAMBIAR CONTRASEÑA', 'roles' => $roles, 'modulos' => $modulos, 'usuario' => $usuario, 'validation' => $this->validator];
            echo view('header');
            echo view('terceros/cambia_password', $data);
            echo view('footer');
        }
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

    public function autocompleteData($campo)
    {
        $returnData = array();
        $valor = $this->request->getGet('term');
        //$terceros = $this->terceros->like($campo, $valor)->where('activo', 1)->findAll();     
        $terceros = $this->terceros->buscaTerceros($campo, $valor);
        if (!empty($terceros)) {
            foreach ($terceros as $row) {
                $data['id'] = $row['id'];
                $data['value'] = $row[$campo];
                $data['razon_social'] = $row['razon_social'];
                $data['direccion'] = $row['direccion'];
                $data['v_resumen'] = $row['v_resumen'];
                $data['numero_documento'] = $row['numero_documento'];
                $data['departamento'] = $row['nombre_departamento'];
                $data['municipio'] = $row['nombre_municipio'];
                $data['label'] = $row['numero_documento'] . ' - ' . $row['razon_social'];

                array_push($returnData, $data); //le asignamos la consulta al arreglo definido: returnData
            }
        }
        echo json_encode($returnData);
    }

    public function subir()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $file_name = $_FILES["inputFile"]["name"];
            $ruta = $_POST['ruta'];
            $prefijo = $_POST['prefijo'];
            //$new_name_file = 'files/' . date("Ymdhis") . '.' . $extension;            
            if ($file_name != '' || $file_name != null) {
                $file_type = $_FILES["inputFile"]["type"];
                list($type, $extension) = explode("/", $file_type);
                if ($extension == 'pdf') {
                    $file_tmp_name = $_FILES['inputFile']['tmp_name'];
                    $file_name_new = $_POST['docto'];
                    $new_name_file = $ruta . $prefijo . $file_name_new . '.' . $extension;
                    if (copy($file_tmp_name, $new_name_file)) {
                        return;
                    }
                }
            }
        } else {
            return;
            // echo 'Error';
        }
    }

    public function buscarDocumento($numero,$tipo)
    {
        $returnData = array();
        $terceros = $this->terceros->buscarTerceros($numero,$tipo);
        if (!empty($terceros)) {array_push($returnData, $terceros);}
        echo json_encode($returnData);      
    }

    function muestraTercerosPdf(){
        $terceros = $this->terceros->listaTercero(1);
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $data = ['titulo' => 'Reporte de Terceros','datos' => $terceros, 'roles' => $roles, 'modulos' => $modulos];
        echo view('header',$data);
        echo view('/terceros/verTerceros_pdf',$data);
        echo view('footer');
    }

    function reporteTercerosPdf()
    {
        $session = session();
        $empresas = $this->empresas->where('id_empresa',1)->first();
        $terceros = $this->terceros->listaTercero(1);
        // podemos trabajar la consulta de esta forma o en una sola linea asi: 
        //$detalle_compra = $this->detalle_compra->select('*')->where('id_compra',$id_compra)->findAll();
        /*$this->detalle_compra->select('*');
        $this->detalle_compra->where('id_compra',$id_compra);
        $detalleCompra = $this->detalle_compra->findAll();
        */

        $pdf = new \FPDF('P','mm','letter');
        $pdf->AddPage();
        $pdf->SetMargins(5,10,10);
        $pdf->image(base_url().'/image/logoTransparente.png',185,5,14,16,'png');
        $pdf->SetTitle("Terceros");        
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
        $pdf->Cell(70,5,$empresas['correo'],0,0,'L');
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(88,5,utf8_decode('Catálogo de Terceros a:  '). date('M-d-Y'),0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(30,5,"Usuario: ". $session->usuario,0,0,'L');
        //$pdf->Line(10,46,210,46);
        $pdf->Ln();

         
        $pdf->SetFont('Arial','B',10);
        $pdf->SetFillColor(86, 177, 124);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(204,5,'Detalles de Terceros',1,1,'C',1); //si colocamos el uno al final es que se toma la caracteristica de color: $pdf->Cell(200,5,'Detalles de Productos',1,1,'C',*1*);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(14,5,'Nro',1,0,'C');
        $pdf->Cell(10,5,'TD',1,0,'C');
        $pdf->Cell(25,5,'Documento',1,0,'C');
        $pdf->Cell(70,5,'Nombre del Tercero',1,0,'C');
        $pdf->Cell(60,5,'Direccion',1,0,'C');
        $pdf->Cell(25,5,'Tipo',1,1,'C');
        $pdf->SetFont('Arial','',8);
        $contador = 1;  
        $total = 0;  
        foreach($terceros as $row){
            $pdf->Cell(14,5,$contador,1,0,'C');
            $pdf->Cell(10,5,$row['resumen'],1,0,'L');
            $pdf->Cell(25,5,$row['numero_documento'],1,0,'L');
            $pdf->Cell(70,5,utf8_decode($row['razon_social']),1,0,'L');
            $pdf->Cell(60,5,utf8_decode($row['direccion']),1,0,'L');
            $pdf->Cell(25,5,utf8_decode($row['v_resumen']),1,1,'L');
            $contador ++;
        }
        $pdf->Ln();       
        $this->response->setHeader('Content-Type', 'application/pdf');
        $pdf->Output("terceros.pdf", "I");

    }

}
