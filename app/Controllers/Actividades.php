<?php

namespace App\Controllers;


use App\Controllers\BaseController; /*la plantilla del controlador general de codeigniter */
use App\Models\RolesModel; /* clase a la cual se esta apuntando con los modelos */
use App\Models\ModulosModel;
use App\Models\SeccionesModel;
use App\Models\DivisionesModel;
use App\Models\GruposModel;
use App\Models\ActividadesModel;
use App\Models\PermisosModel;

class Actividades extends BaseController
{
    /*interactua el controlador con el modelo */
    protected $divisiones, $roles, $modulos, $secciones, $grupos, $actividades;
    protected $reglas,$permisos;

    public function __construct()
    {
        $this->divisiones = new DivisionesModel();
        $this->roles = new RolesModel();
        $this->modulos = new ModulosModel();
        $this->secciones = new SeccionesModel();
        $this->grupos = new GruposModel();
        $this->actividades = new ActividadesModel();
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
            $verActividades = $this->permisos->obtenerPermiso($session->id_rol,'Ver Actividades');
            $agregar = $this->permisos->obtenerPermiso($session->id_rol,'Agregar Actividad');
            $editar = $this->permisos->obtenerPermiso($session->id_rol,'Editar Actividad');
            $actualizar = $this->permisos->obtenerPermiso($session->id_rol, 'Actualizar Actividad');
            $eliminar = $this->permisos->obtenerPermiso($session->id_rol,'Eliminar Actividad');
        }else{
            $verActividades = "enabled='true'";
            $agregar = "enabled='true'";
            $editar = "enabled='true'";
            $actualizar = "enabled='true'";
            $eliminar = "enabled='true'";           
        }      

        if ($verActividades=="enabled='true'"){
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $secciones = $this->secciones->where('activo', 1)->findAll();      
        $datos = $this->actividades->obtenerGruposDivisionSeccion(1); 
        $divisiones = $this->divisiones->where('activo', $activo)->findAll(); 
        $grupos = $this->grupos->where('activo', $activo)->findAll(); 
        $actividades = $this->actividades->where('activo', $activo)->findAll(); 
        $data = ['titulo' => 'MANEJO DE ACTIVIDADES', 'actividades' => $actividades, 'roles' => $roles, 'modulos' => $modulos, 'secciones' => $secciones, 'divisiones' => $divisiones, 'datos' => $datos, 'grupos' => $grupos, 'agregar' => $agregar, 'editar' => $editar, 'actualizar' => $actualizar, 'eliminar' => $eliminar]; 

        echo view('header', $data);
        echo view('actividades/actividades', $data);
        echo view('footer');
        }else{
            return redirect()->to(base_url(). '/principal');
        }
    }

    public function eliminadas_actividades($activo = 0) 
    {
        $session = session();
        if ($session->id_rol!=1) {
            $activar = $this->permisos->obtenerPermiso($session->id_rol, 'Activar Actividad');
        }else{$activar = "enabled='true'"; }
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $secciones = $this->secciones->where('activo', 1)->findAll();
        $datos = $this->actividades->obtenerGruposDivisionSeccion(0);
        $divisiones = $this->divisiones->where('activo', 1)->findAll(); 
        $grupos = $this->grupos->where('activo', 1)->findAll(); 
        $actividades = $this->actividades->where('activo', $activo)->findAll();
        $data = ['titulo' => 'ACTIVIDADES ELIMINADAS', 'datos' => $grupos, 'roles' => $roles, 'modulos' => $modulos, 'secciones' => $secciones, 'divisiones' => $divisiones, 'datos' => $datos, 'actividades' => $actividades,'activar'=>$activar]; 

        echo view('header', $data);
        echo view('actividades/eliminadas_actividades', $data);
        echo view('footer');
    }

    public function nueva_actividad()
    {
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $where = "activo=1 order by nombre";
        $secciones = $this->secciones->where($where)->findAll();        
        $where = "activo=1 order by nombre";
        $divisiones = $this->divisiones->where($where)->findAll();        
        $where = "activo=1 order by nombre";
        $grupos = $this->grupos->where($where)->findAll();  

        $data = ['titulo' => 'CREAR ACTIVIDADES', 'roles' => $roles, 'modulos' => $modulos, 'secciones' => $secciones, 'divisiones' => $divisiones,'grupos' => $grupos];
        echo view('header', $data);
        echo view('actividades/nueva_actividad', $data);
        echo view('footer');
    }

    public function inserta_actividad(){
    $modulos = $this->modulos->buscar_modulos(1);
        $data = ['titulo' => 'CREAR ACTIVIDADESL', 'modulos' => $modulos];

        if ($this->request->getMethod() == "post" && $this->validate($this->reglas)) {
            $session = session();
            $this->actividades->save([
                'id_grupo' => $this->request->getPost('id_grupo'),
                'codigo' => $this->request->getPost('codigo'),                
                'nombre' => $this->request->getPost('nombre')
            ]);

            return redirect()->to(base_url() . '/actividades');

        } else {
            $roles = $this->roles->where('activo', 1)->findAll();
            $modulos = $this->modulos->buscar_modulos(1);                     
            $data = ['titulo' => 'CREAR ACTIVIDADES','roles' => $roles, 'modulos' => $modulos,'validaton' => $this->validator]; 
            echo view('header', $data);
            echo view('actividades/nueva_actividad', $data);
            echo view('footer');
        }
    }

    public function editar_actividad($id, $valid=null)
    { {
            
            $roles = $this->roles->where('activo', 1)->findAll();
            $modulos = $this->modulos->buscar_modulos(1);        
            $divisiones = $this->divisiones->where('activo', 1)->findAll(); 
            $secciones = $this->secciones->where('activo', 1)->findAll();   
            $grupos = $this->grupos->where('activo', 1)->findAll(); 
            $actividades = $this->actividades->where('codigo', $id)->first();        
            if($valid !== null){
                $data = ['titulo' => 'EDITAR GRUPO DE ACTIVIDADES', 'datos' => $actividades,'roles' => $roles, 'modulos' => $modulos, 'secciones' => $secciones, 'divisiones' => $divisiones, 'grupos' => $grupos,'validation' => $valid];
            }else{
                $data = ['titulo' => 'EDITAR GRUPO DE ACTIVIDADES', 'datos' => $actividades,'roles' => $roles, 'modulos' => $modulos, 'secciones' => $secciones, 'divisiones' => $divisiones, 'grupos' => $grupos];
            }            
            echo view('header', $data);
            echo view('actividades/editar_actividad', $data);
            echo view('footer');
        }
    }
    public function actualizar_actividad()
    {
        if ($this->request->getMethod() == "post" && $this->validate($this->reglas)) {
            $this->actividades->update($this->request->getPost('id'), [
            'nombre' => $this->request->getPost('nombre')
        ]);
            return redirect()->to(base_url() . '/actividades');
        } else {
            return $this->editar_actividad($this->request->getPost('id'),$this->validator);
        }
    }

    public function eliminar_actividad($codigo)
    {
        $this->actividades->update($codigo, ['activo' => 0]);
        return redirect()->to(base_url() . '/actividades');
    }
    public function activar_actividad($codigo)
    {
        $this->actividades->update($codigo, ['activo' => 1]);
        return redirect()->to(base_url() . '/actividades/eliminadas_actividades');
    }

    public function buscar_Actividad($codigo)
    {
        $datos = $this->actividades->where('codigo', $codigo)->first();         
        if($datos){return 'true';}else{return 'false';}        
    }
}
