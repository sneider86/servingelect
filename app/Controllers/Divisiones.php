<?php

namespace App\Controllers;


use App\Controllers\BaseController; /*la plantilla del controlador general de codeigniter */
use App\Models\RolesModel; /* clase a la cual se esta apuntando con los modelos */
use App\Models\ModulosModel;
use App\Models\SeccionesModel;
use App\Models\DivisionesModel;
use App\Models\PermisosModel;

class Divisiones extends BaseController
{
    /*interactua el controlador con el modelo */
    protected $divisiones, $roles, $modulos, $secciones;
    protected $reglas,$permisos;

    public function __construct()
    {
        $this->divisiones = new DivisionesModel();
        $this->roles = new RolesModel();
        $this->modulos = new ModulosModel();
        $this->secciones = new SeccionesModel();
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
            $verDivisiones = $this->permisos->obtenerPermiso($session->id_rol,'Ver Divisiones');
            $agregar = $this->permisos->obtenerPermiso($session->id_rol,'Agregar División');
            $editar = $this->permisos->obtenerPermiso($session->id_rol,'Editar División');
            $actualizar = $this->permisos->obtenerPermiso($session->id_rol, 'Actualizar RoDivisiónl');
            $eliminar = $this->permisos->obtenerPermiso($session->id_rol,'Eliminar División');
        }else{
            $verDivisiones = "enabled='true'";
            $agregar = "enabled='true'";
            $editar = "enabled='true'";
            $actualizar = "enabled='true'";
            $eliminar = "enabled='true'";           
        }      

        if ($verDivisiones=="enabled='true'"){
        $secciones = $this->secciones->where('activo', 1)->findAll();
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);       
        $datos = $this->divisiones->obtenerDivision(1); 
        $divisiones = $this->divisiones->where('activo', $activo)->findAll(); 
        $data = ['titulo' => 'MANEJO DIVISIONES DE ACTIVIDADES', 'datos' => $divisiones, 'roles' => $roles, 'modulos' => $modulos, 'secciones' => $secciones, 'datos' => $datos, 'agregar' => $agregar, 'editar' => $editar, 'actualizar' => $actualizar, 'eliminar' => $eliminar]; 

        echo view('header', $data);
        echo view('actividades/divisiones', $data);
        echo view('footer');
        }else{
            return redirect()->to(base_url(). '/principal');
        }
    }

    public function eliminadas_divisiones($activo = 0) 
    {
        $session = session();
        if ($session->id_rol!=1) {
            $activar = $this->permisos->obtenerPermiso($session->id_rol, 'Activar Rol');
        }else{$activar = "enabled='true'"; }
        $secciones = $this->secciones->where('activo', 1)->findAll();
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $datos = $this->divisiones->obtenerDivision(0); 
        $divisiones = $this->divisiones->where('activo', $activo)->findAll(); 
        $data = ['titulo' => 'DIVISIONES DE ACTIVIDADES ELIMINADAS', 'datos' => $divisiones, 'roles' => $roles, 'modulos' => $modulos, 'secciones' => $secciones, 'datos' => $datos, 'datos' => $datos, 'activar' => $activar]; 

        /* mostramos la vista */
        echo view('header', $data);
        echo view('actividades/eliminadas_divisiones', $data);
        echo view('footer');
    }

    public function nueva_divison()
    {
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $where = "activo=1 order by nombre";
        $secciones = $this->secciones->where($where)->findAll();        
        $data = ['titulo' => 'CREAR DIVISIONES DE ACTIVIDADES', 'roles' => $roles, 'modulos' => $modulos, 'secciones' => $secciones];
        echo view('header', $data);
        echo view('actividades/nueva_division', $data);
        echo view('footer');
    }

    public function inserta_division()
    {
        if ($this->request->getMethod() == "post" && $this->validate($this->reglas)) {
            $session = session();

            $resultado = $this->divisiones->insertaDivision($this->request->getPost('id_seccion'),$this->request->getPost('codigo'),$this->request->getPost('nombre'));            
            if(!$resultado){
                return redirect()->to(base_url() . '/divisiones');
            }
            return redirect()->to(base_url() . '/divisiones');
        } else {
            /*
            $roles = $this->roles->where('activo', 1)->findAll();
            $where = " activo = 1 order by padre_id,orden";
            $modulos = $this->modulos->where($where)->findAll();            
            $data = ['titulo' => 'CREAR DIVISIONES DE ACTIVIDADES','roles' => $roles, 'modulos' => $modulos,'validaton' => $this->validator]; 
            echo view('header', $data);
            echo view('actividades/nueva_division', $data);
            echo view('footer');
            */
        }
    }

    public function editar_division($id, $valid=null)
    { {
            
            $roles = $this->roles->where('activo', 1)->findAll();
            $modulos = $this->modulos->buscar_modulos(1);          
            $divisiones = $this->divisiones->where('codigo', $id)->first();
            $secciones = $this->secciones->where('activo', 1)->findAll();            
            if($valid !== null){
                $data = ['titulo' => 'EDITAR DIVISONES DE ACTIVIDADES', 'datos' => $divisiones,'roles' => $roles, 'modulos' => $modulos, 'secciones' => $secciones,'validation' => $valid];
            }else{
                $data = ['titulo' => 'EDITAR DIVISONES DE ACTIVIDADES', 'datos' => $divisiones,'roles' => $roles, 'modulos' => $modulos, 'secciones' => $secciones];
            }            
            echo view('header', $data);
            echo view('actividades/editar_division', $data);
            echo view('footer');
        }
    }
    public function actualizar_division()
    {
        if ($this->request->getMethod() == "post" && $this->validate($this->reglas)) {
            $this->divisiones->update($this->request->getPost('id'), [
            'nombre' => $this->request->getPost('nombre')
        ]);
            return redirect()->to(base_url() . '/divisiones');
        } else {
            return $this->editar_division($this->request->getPost('id'),$this->validator);
        }
    }

    public function eliminar_division($codigo)
    {
        $this->divisiones->update($codigo, ['activo' => 0]);
        return redirect()->to(base_url() . '/divisiones');
    }
    public function activar_division($codigo)
    {
        $this->divisiones->update($codigo, ['activo' => 1]);
        return redirect()->to(base_url() . '/divisiones/eliminadas_divisiones');
    }

    public function buscarDivision($id)
    {
        $returnData = array();
        $divisiones = $this->divisiones->presentarDivision($id);
        if (!empty($divisiones)) {
            array_push($returnData, $divisiones);
        }
        echo json_encode($returnData);
    }    

    public function buscar_Division($codigo)
    {
        $datos = $this->divisiones->where('codigo', $codigo)->first();         
        if($datos){return 'true';}else{return 'false';}        
    }
}
