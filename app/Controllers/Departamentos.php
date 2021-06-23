<?php

namespace App\Controllers;


use App\Controllers\BaseController; /*la plantilla del controlador general de codeigniter */
use App\Models\RolesModel;
use App\Models\ModulosModel;
use App\Models\PaisModel;

class Departamentos extends BaseController
{
    /*interactua el controlador con el modelo */
    protected $roles, $modulos, $pais;
    protected $reglas;

    public function __construct()
    {
        $this->roles = new RolesModel();
        $this->modulos = new ModulosModel();
        $this->pais = new PaisModel();
        helper(['form']);
  }

    /*Interactuamos con la vista con la funcion index */
    public function index($activo = 1) /* 2 vistas la de los activos y la de los inactivos y por defecto se cargara la vista de los activos */
    {
        $roles = $this->roles->where('activo', $activo)->findAll(); /*le asigno a la variable la consulta dada */
        $where = " activo = 1 order by padre_id,orden";        
        $modulos = $this->modulos->where($where)->findAll(); 
        $data = ['titulo' => 'MANEJO DE ROLES', 'datos' => $roles, 'modulos' => $modulos]; /*creamos el arreglo $data y se lo enviamos a la vista con los campos definidos, datos tendra toda la informacion resultante de la consulta */

        /* mostramos la vista */
        echo view('header', $data);
        echo view('roles/roles', $data);
        echo view('footer');
    }

}
