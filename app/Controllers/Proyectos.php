<?php

namespace App\Controllers;



use App\Controllers\BaseController; /*la plantilla del controlador general de codeigniter */
use App\Models\RolesModel;
use App\Models\ModulosModel;
use App\Models\AccionesModel;
use App\Models\DotacionesModel;
use App\Models\DetalleParametrosModel;
use App\Models\FamiliasModel;
use App\Models\ProyectosModel;
use App\Models\TercerosModel;
use App\Models\PaisModel;
use App\Models\DepartamentosModel;
use App\Models\MunicipiosModel;

class Proyectos extends BaseController
{
    /*interactua el controlador con el modelo */
    protected $roles,  $proyectos, $detalleparametros, $familias, $grupos;
    protected $terceros,$modulos,$pais,$departamentos,$municipios;
    protected $reglas;

    public function __construct()
    {
        $this->roles = new RolesModel();
        $this->modulos = new ModulosModel();
        $this->proyectos = new AccionesModel();
        $this->proyectos = new DotacionesModel();
        $this->pais = new PaisModel();        
        $this->departamentos = new DepartamentosModel();
        $this->municipios = new MunicipiosModel();        
        $this->detalleparametros = new DetalleParametrosModel();
        $this->familias = new FamiliasModel();
        $this->grupos = new FamiliasModel();
        $this->proyectos = new ProyectosModel();
        $this->terceros = new TercerosModel();
    }

    /*Interactuamos con la vista con la funcion index */
    public function index($activo = 1)
    {
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $pais = $this->pais->where('activo', 1)->findAll();
        $familias = $this->familias->buscarporFamilia($activo);
        //$grupos = $this->familias->buscarGrupos(1);
        $u_medida = $this->detalleparametros->buscarDetalleParametros('Unidad de Medida');
        $proyectos = $this->proyectos->where('activo', $activo)->findAll();
        $data = ['titulo' => 'CREAR PROYECTOS', 'datos' =>  $proyectos, 'roles' => $roles, 'modulos' => $modulos, 'u_medida' => $u_medida, 'familias' => $familias, 'pais' => $pais];
        /* mostramos la vista */
        echo view('header', $data);
        echo view('proyectos/proyectos', $data);
        echo view('footer');
    }
    public function getGrupos($family = 1)
    {
        $where = "id_padre= $family and id_family!=id_padre order by nombre ";
        $datos = $this->familias->where($where)->findAll();
        $cadena = "<select id='grupo' name='grupo'>";
        foreach ($datos as $row) {
            $cadena = $cadena . '<option value=' . $row['id_family'] . '>' . $row['nombre'] . '</option>';
        }
        echo $cadena . "</select>";
    }

    public function getDepartamentos($codpais=2){        
        //$codpais = $_POST['pais'];       
        $where = "id_pais= $codpais order by nombre";
        $datos = $this->departamentos->where($where)->findAll();
        $cadena = "<select id='departamento' name='departamento'>";
        foreach ($datos as $row) {
            $cadena = $cadena.'<option value='. $row['id'].'>'. $row['nombre'].'</option>';
        }
        echo $cadena."</select>";
        //echo json_encode($departamentos);
    }

    public function getMunicipios($coddepartamento=0){
        //$coddepartamento = $_POST['coddepartamento'];
        $where = "id_departamento= $coddepartamento order by nombre ";
        $datos = $this->municipios->where($where)->findAll();
        $cadena = "<select id='municipio' name='municipio'>";
 
        foreach ($datos as $row) {
            $cadena = $cadena.'<option value='. $row['id'].'>'.utf8_encode($row['nombre']).'</option>';
        }
        echo $cadena."</select>";
        //echo json_encode($departamentos);
    }    

    public function eliminados($activo = 0)
    {
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $proyectos = $this->proyectos->listaporDetalleParametros($activo);
        $u_medida = $this->detalleparametros->buscarDetalleParametros('Unidad de Medida');
        $data = ['titulo' => 'MANEJO DE DOTACIONES', 'datos' =>  $proyectos, 'roles' => $roles, 'modulos' => $modulos, 'u_medida' => $u_medida];
        echo view('header', $data);
        echo view('proyectos/eliminados', $data);
        echo view('footer');
    }

    public function nuevo()
    {
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $pais = $this->pais->where('activo', 1)->findAll();
        $where = " activo = 1 order by razon_social"; 
        $terceros = $this->terceros->where($where)->findAll();         
        $data = ['titulo' => 'CREAR DOTACIONES', 'modulos' => $modulos, 'roles' => $roles, 'pais' => $pais, 'terceros' => $terceros];
        echo view('header', $data);
        echo view('proyectos/nuevo', $data);
        echo view('footer');
    }

    public function insertar()
    {
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $proyectos = $this->proyectos->where('activo', 1)->findAll();
        $u_medida = $this->detalleparametros->buscarDetalleParametros('Unidad de Medida');
        $data = ['titulo' => 'MANEJO DE DOTACIONES', 'datos' =>  $proyectos, 'roles' => $roles, 'modulos' => $modulos, 'u_medida' => $u_medida];
        $session = session();
        if ($this->request->getMethod() == "post") {

            $this->proyectos->save([
                'codigo' => $this->request->getPost('codigo'),
                'descripcion' => $this->request->getPost('descripcion'),
                'ultimo_costo' => $this->request->getPost('costo'),
                'unidad_medida' => $this->request->getPost('u_medida'),
                'id_familia' => $this->request->getPost('grupo'),
                'usuario_crea' => $session->id_usuario
            ]);
            return redirect()->to(base_url() . '/proyectos');
        } else {
            echo view('header', $data);
            echo view('proyectos/nuevo', $data);
            echo view('footer');
        }
    }

    public function editar($id, $valid = null)
    {
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $grupos = $this->familias->buscarGrupos(1);
        $proyectos = $this->proyectos->where('id_dotacion', $id)->first();
        if ($valid !== null) {
            $data = ['titulo' => 'EDITAR DOTACIONES', 'datos' => $proyectos, 'modulos' => $modulos, 'roles' => $roles, 'grupos' => $grupos, 'validation' => $valid];
        } else {
            $data = ['titulo' => 'EDITAR DOTACIONES', 'datos' => $proyectos, 'modulos' => $modulos, 'grupos' => $grupos, 'roles' => $roles];
        }
        echo view('header', $data);
        //echo view('proyectos', $data);
        echo view('proyectos/editar', $data);
        echo view('footer');
    }

    public function buscarDotacion($id)
    {
        $returnData = array();
        $proyectos = $this->proyectos->presentarDotacion($id);
        if (!empty($proyectos)) {array_push($returnData, $proyectos);}
        echo json_encode($returnData);
    }
    public function mostrarGrupos($family)
    {
        $returnData = array();
        $grupos = $this->familias->buscarporGrupo($family);
        if (!empty($grupos)) {array_push($returnData, $grupos);}
        echo json_encode($returnData);
    }
    public function actualizar()
    {
        if ($this->request->getMethod() == "post" && $this->validate($this->reglas)) {
            $this->proyectos->update($this->request->getPost('id'), [
                'nombre' => $this->request->getPost('nombre'),
                'id_modulo' => $this->request->getPost('id_modulo')
            ]);
            return redirect()->to(base_url() . '/proyectos');
        } else {
            return $this->editar($this->request->getPost('id'), $this->validator);
        }
    }

    public function eliminar($id)
    {
        $this->proyectos->update($id, ['activo' => 0]);
        return redirect()->to(base_url() . '/proyectos');
    }
    public function activar($id)
    {
        $this->proyectos->update($id, ['activo' => 1]);
        return redirect()->to(base_url() . '/proyectos/eliminados');
    }
}
