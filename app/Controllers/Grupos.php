<?php

namespace App\Controllers;


use App\Controllers\BaseController; /*la plantilla del controlador general de codeigniter */
use App\Models\RolesModel; /* clase a la cual se esta apuntando con los modelos */
use App\Models\ModulosModel;
use App\Models\SeccionesModel;
use App\Models\DivisionesModel;
use App\Models\GruposModel;
use App\Models\PermisosModel;

class Grupos extends BaseController
{
    /*interactua el controlador con el modelo */
    protected $divisiones, $roles, $modulos, $secciones, $grupos;
    protected $reglas,$permisos;

    public function __construct()
    {
        $this->divisiones = new DivisionesModel();
        $this->roles = new RolesModel();
        $this->modulos = new ModulosModel();
        $this->secciones = new SeccionesModel();
        $this->grupos = new GruposModel();
        $this->permisos = new PermisosModel();

        helper(['form']);
        $this->reglas = [
            'nombre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El Campo {field} es Obligatorio.'
                ]
            ]
        ];
    }

    public function index($activo = 1) 
    {
        $session = session();
        if($session->id_rol!=1){
            $verGrupos = $this->permisos->obtenerPermiso($session->id_rol,'Ver Grupos');
            $agregar = $this->permisos->obtenerPermiso($session->id_rol,'Agregar Grupo');
            $editar = $this->permisos->obtenerPermiso($session->id_rol,'Editar Grupo');
            $actualizar = $this->permisos->obtenerPermiso($session->id_rol, 'Actualizar Grupo');
            $eliminar = $this->permisos->obtenerPermiso($session->id_rol,'Eliminar Grupo');
        }else{
            $verGrupos = "enabled='true'";
            $agregar = "enabled='true'";
            $editar = "enabled='true'";
            $actualizar = "enabled='true'";
            $eliminar = "enabled='true'";           
        }      

        if ($verGrupos=="enabled='true'") {
            $roles = $this->roles->where('activo', 1)->findAll();
            $modulos = $this->modulos->buscar_modulos(1);
            $secciones = $this->secciones->where('activo', 1)->findAll();
            $datos = $this->grupos->obtenerGrupoDivisionSeccion(1);
            $divisiones = $this->divisiones->where('activo', $activo)->findAll();
            $grupos = $this->grupos->where('activo', $activo)->findAll();
            $data = ['titulo' => 'MANEJO GRUPOS DE ACTIVIDADES', 'datos' => $grupos, 'roles' => $roles, 'modulos' => $modulos, 'secciones' => $secciones, 'divisiones' => $divisiones, 'datos' => $datos, 'agregar' => $agregar, 'editar' => $editar, 'actualizar' => $actualizar, 'eliminar' => $eliminar];

            echo view('header', $data);
            echo view('actividades/grupos', $data);
            echo view('footer');
        }else{
            return redirect()->to(base_url(). '/principal');
        }
    }

    public function eliminados_grupos($activo = 0) 
    {
        $session = session();
        if ($session->id_rol!=1) {
            $activar = $this->permisos->obtenerPermiso($session->id_rol, 'Activar Grupo');
        }else{$activar = "enabled='true'"; }
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $secciones = $this->secciones->where('activo', 1)->findAll();
        $datos = $this->grupos->obtenerDivisionSeccion(0);
        $divisiones = $this->divisiones->where('activo', 1)->findAll(); 
        $grupos = $this->grupos->where('activo', $activo)->findAll(); 
        $data = ['titulo' => 'GRUPOS DE ACTIVIDADES ELIMINADAS', 'datos' => $grupos, 'roles' => $roles, 'modulos' => $modulos, 'secciones' => $secciones, 'divisiones' => $divisiones, 'datos' => $datos,'activar'=>$activar]; 

        echo view('header', $data);
        echo view('actividades/eliminados_grupos', $data);
        echo view('footer');
    }

    public function nuevo_grupo()
    {
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $where = "activo=1 order by nombre";
        $secciones = $this->secciones->where($where)->findAll();        
        $where = "activo=1 order by nombre";
        $divisiones = $this->divisiones->where($where)->findAll();        

        $data = ['titulo' => 'CREAR GRUPOS DE ACTIVIDADES', 'roles' => $roles, 'modulos' => $modulos, 'secciones' => $secciones, 'divisiones' => $divisiones];
        echo view('header', $data);
        echo view('actividades/nuevo_grupo', $data);
        echo view('footer');
    }

    public function inserta_grupo()
    {
        if ($this->request->getMethod() == "post" && $this->validate($this->reglas)) {
            $session = session();
            $this->grupos->save([
                'id_division' => $this->request->getPost('id_division'),
                'codigo' => $this->request->getPost('codigo'),                
                'nombre' => $this->request->getPost('nombre')
            ]);
            return redirect()->to(base_url() . '/grupos');

        } else {
            return redirect()->to(base_url() . '/grupos');
            /*
            $roles = $this->roles->where('activo', 1)->findAll();
            $where = " activo = 1 order by padre_id,orden";
            $modulos = $this->modulos->where($where)->findAll();                      
            $data = ['titulo' => 'CREAR GRUPOS DE ACTIVIDADES','roles' => $roles, 'modulos' => $modulos,'validaton' => $this->validator]; 
            echo view('header', $data);
            echo view('actividades/nuevo_grupo', $data);
            echo view('footer');
            */
        }
    }

    public function editar_grupo($id, $valid=null)
    { {
            
            $roles = $this->roles->where('activo', 1)->findAll();
            $modulos = $this->modulos->buscar_modulos(1);          
            $divisiones = $this->divisiones->where('activo', 1)->findAll(); 
            $secciones = $this->secciones->where('activo', 1)->findAll();   
            $grupos = $this->grupos->where('codigo', $id)->first();         
            if($valid !== null){
                $data = ['titulo' => 'EDITAR GRUPO DE ACTIVIDADES', 'datos' => $grupos,'roles' => $roles, 'modulos' => $modulos, 'secciones' => $secciones, 'divisiones' => $divisiones,'validation' => $valid];
            }else{
                $data = ['titulo' => 'EDITAR GRUPO DE ACTIVIDADES', 'datos' => $grupos,'roles' => $roles, 'modulos' => $modulos, 'secciones' => $secciones, 'divisiones' => $divisiones];
            }            
            echo view('header', $data);
            echo view('actividades/editar_grupo', $data);
            echo view('footer');
        }
    }
    public function actualizar_grupo()
    {
        if ($this->request->getMethod() == "post" && $this->validate($this->reglas)) {
            $this->grupos->update($this->request->getPost('id'), [
            'nombre' => $this->request->getPost('nombre')
        ]);
            return redirect()->to(base_url() . '/grupos');
        } else {
            return $this->editar_grupo($this->request->getPost('id'),$this->validator);
        }
    }

    public function eliminar_grupo($codigo)
    {
        $this->grupos->update($codigo, ['activo' => 0]);
        return redirect()->to(base_url() . '/grupos');
    }
    public function activar_grupo($codigo)
    {
        $this->grupos->update($codigo, ['activo' => 1]);
        return redirect()->to(base_url() . '/grupos/eliminados_grupos');
    }

    public function buscar_Grupo($codigo)
    {
        $datos = $this->grupos->where('codigo', $codigo)->first();         
        if($datos){return 'true';}else{return 'false';}        
    }

}
