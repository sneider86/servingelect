<?php

namespace App\Controllers;



use App\Controllers\BaseController; /*la plantilla del controlador general de codeigniter */
use App\Models\RolesModel;
use App\Models\ModulosModel;
use App\Models\AccionesModel;
use App\Models\DotacionesModel;
use App\Models\DetalleParametrosModel;
use App\Models\FamiliasModel;

class Dotaciones extends BaseController
{
    /*interactua el controlador con el modelo */
    protected $roles,  $dotaciones, $detalleparametros, $familias, $grupos;
    protected $modulos;
    protected $reglas;

    public function __construct()
    {
        $this->roles = new RolesModel();
        $this->modulos = new ModulosModel();
        $this->dotaciones = new AccionesModel();
        $this->dotaciones = new DotacionesModel();
        $this->detalleparametros = new DetalleParametrosModel();
        $this->familias = new FamiliasModel();
        $this->grupos = new FamiliasModel();
    }

    /*Interactuamos con la vista con la funcion index */
    public function index($activo = 1)
    {
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $dotaciones = $this->dotaciones->listaporDetalleParametros($activo);
        $familias = $this->familias->buscarporFamilia($activo);
        //$grupos = $this->familias->buscarGrupos(1);
        $u_medida = $this->detalleparametros->buscarDetalleParametros('Unidad de Medida');
        $data = ['titulo' => 'MANEJO DE DOTACIONES', 'datos' =>  $dotaciones, 'roles' => $roles, 'modulos' => $modulos, 'u_medida' => $u_medida, 'familias' => $familias];
        /* mostramos la vista */
        echo view('header', $data);
        echo view('dotaciones/dotaciones', $data);
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
    public function eliminados($activo = 0)
    {
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $dotaciones = $this->dotaciones->listaporDetalleParametros($activo);
        $u_medida = $this->detalleparametros->buscarDetalleParametros('Unidad de Medida');
        $data = ['titulo' => 'MANEJO DE DOTACIONES', 'datos' =>  $dotaciones, 'roles' => $roles, 'modulos' => $modulos, 'u_medida' => $u_medida];
        echo view('header', $data);
        echo view('dotaciones/eliminados', $data);
        echo view('footer');
    }

    public function nuevo()
    {
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $data = ['titulo' => 'CREAR DOTACIONES', 'modulos' => $modulos, 'roles' => $roles];

        echo view('header', $data);
        echo view('dotaciones/nuevo', $data);
        echo view('footer');
    }

    public function insertar()
    {
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $dotaciones = $this->dotaciones->where('activo', 1)->findAll();
        $u_medida = $this->detalleparametros->buscarDetalleParametros('Unidad de Medida');
        $data = ['titulo' => 'MANEJO DE DOTACIONES', 'datos' =>  $dotaciones, 'roles' => $roles, 'modulos' => $modulos, 'u_medida' => $u_medida];
        $session = session();
        if ($this->request->getMethod() == "post") {
            $this->dotaciones->save([
                'codigo' => $this->request->getPost('codigo'),
                'descripcion' => $this->request->getPost('descripcion'),
                'ultimo_costo' => $this->request->getPost('costo'),
                'unidad_medida' => $this->request->getPost('u_medida'),
                'id_familia' => $this->request->getPost('grupo'),
                'usuario_crea' => $session->id_usuario
            ]);
            return redirect()->to(base_url() . '/dotaciones');
        } else {
            echo view('header', $data);
            echo view('dotaciones/nuevo', $data);
            echo view('footer');
        }
    }

    public function editar($id, $valid = null)
    {
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $grupos = $this->familias->buscarGrupos(1);
        $dotaciones = $this->dotaciones->where('id_dotacion', $id)->first();
        if ($valid !== null) {
            $data = ['titulo' => 'EDITAR DOTACIONES', 'datos' => $dotaciones, 'modulos' => $modulos, 'roles' => $roles, 'grupos' => $grupos, 'validation' => $valid];
        } else {
            $data = ['titulo' => 'EDITAR DOTACIONES', 'datos' => $dotaciones, 'modulos' => $modulos, 'grupos' => $grupos, 'roles' => $roles];
        }
        echo view('header', $data);
        //echo view('dotaciones', $data);
        echo view('dotaciones/editar', $data);
        echo view('footer');
    }

    public function buscarDotacion($id)
    {
        $returnData = array();
        $dotaciones = $this->dotaciones->presentarDotacion($id);
        if (!empty($dotaciones)) {array_push($returnData, $dotaciones);}
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
            $this->dotaciones->update($this->request->getPost('id'), [
                'nombre' => $this->request->getPost('nombre'),
                'id_modulo' => $this->request->getPost('id_modulo')
            ]);
            return redirect()->to(base_url() . '/dotaciones');
        } else {
            return $this->editar($this->request->getPost('id'), $this->validator);
        }
    }

    public function eliminar($id)
    {
        $this->dotaciones->update($id, ['activo' => 0]);
        return redirect()->to(base_url() . '/dotaciones');
    }
    public function activar($id)
    {
        $this->dotaciones->update($id, ['activo' => 1]);
        return redirect()->to(base_url() . '/dotaciones/eliminados');
    }
}
