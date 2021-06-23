<?php

namespace App\Controllers;


use App\Controllers\BaseController; /*la plantilla del controlador general de codeigniter */
use App\Models\PermisosModel;
use App\Models\RolesModel; /* clase a la cual se esta apuntando con los modelos */
use App\Models\ModulosModel;
use App\Models\TercerosModel;
use App\Models\AccionesModel;

class Permisos extends BaseController
{
  /*interactua el controlador con el modelo */
  protected $permisos, $terceros, $roles, $modulos, $acciones;

  public function __construct()
  {
    $this->terceros = new TercerosModel();
    $this->roles = new RolesModel();
    $this->modulos = new ModulosModel();
    $this->permisos = new PermisosModel();
    $this->acciones = new AccionesModel();
  }
  public function index($activo = 1)
  {
    $session = session();
    if($session->id_rol!=1){
        $verPermisos = $this->permisos->obtenerPermiso($session->id_rol,'Ver Permisos');
        $agregar = $this->permisos->obtenerPermiso($session->id_rol,'Agregar Permisos');
    }else{
        $verPermisos = "enabled='true'";
        $agregar = "enabled='true'";          
    }      

    if ($verPermisos=="enabled='true'") {
        $terceros = $this->terceros->listaTercero(1);
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $data = ['titulo' => 'MANEJO DE PERMISOS', 'datos' => $terceros, 'roles' => $roles, 'modulos' => $modulos, 'verPermisos' => $verPermisos, 'agregar' => $agregar];
        echo view('header', $data);
        echo view('permisos/permisos', $data);
        echo view('footer');
    }else{return redirect()->to(base_url(). '/principal');}
  }

  public function nuevo()
  {

      $roles = $this->roles->where('activo', 1)->findAll();
      $modulos = $this->modulos->buscar_modulos(1);
      $data = ['titulo' => 'CREAR TERCEROS', 'roles' => $roles, 'modulos' => $modulos];
      echo view('header', $data);
      echo view('permisos/nuevo', $data);
      echo view('footer');
  }

  public function insertar($rol,$accion,$permiso)
    {
            $session = session();
            $resultadoId = $this->permisos->insertaPermiso($rol, $accion, $permiso,$session->id_usuario);
            return $resultadoId;
    }

  public function obtenerPermiso($usuario, $accion)
  {
    $permisos = $this->permisos->obtenerPermiso($usuario, $accion);
    return $permisos;
  }
  public function buscar_Acciones($modulos, $rol)
  {
    $returnData = array();    
    //$datos = $this->acciones->where('id_modulo', $modulos)->findAll();  
    $datos = $this->acciones->traer_Acciones($modulos, $rol);  
    if (!empty($datos)) {array_push($returnData, $datos);}
    echo json_encode($returnData);   
  }

  public function buscar_Permisos($rol)
  {
    $returnData = array();
    $datos = $this->permisos->lista_Permisos($rol);   
    if (!empty($datos)) {array_push($returnData, $datos);}
    echo json_encode($returnData);   
  }

}
