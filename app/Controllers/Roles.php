<?php

namespace App\Controllers;


use App\Controllers\BaseController; /*la plantilla del controlador general de codeigniter */
use App\Models\RolesModel;
use App\Models\ModulosModel;
use App\Models\PermisosModel;

use DateTimeZone;
use MessageFormatter;

class Roles extends BaseController
{
    /*interactua el controlador con el modelo */
    protected $roles, $modulos, $permisos;
    protected $reglas;

    public function __construct()
    {
        $this->roles = new RolesModel();
        $this->modulos = new ModulosModel();
        $this->permisos = new PermisosModel();
        helper(['form']);

        $this->reglas = [
            'nombre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El Campo {field} es Obligatorio.'
                ]
            ],
            'descripcion' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El Campo {field} es Obligatorio.'
                ]
            ]
        ];
    }

    /*Interactuamos con la vista con la funcion index */
    public function index($activo = 1) /* 2 vistas la de los activos y la de los inactivos y por defecto se cargara la vista de los activos */
    {
        $session = session();
        if($session->id_rol!=1){
            $verRoles = $this->permisos->obtenerPermiso($session->id_rol,'Ver Roles');
            $agregar = $this->permisos->obtenerPermiso($session->id_rol,'Agregar Rol');
            $editar = $this->permisos->obtenerPermiso($session->id_rol,'Editar Rol');
            $actualizar = $this->permisos->obtenerPermiso($session->id_rol, 'Actualizar Rol');
            $eliminar = $this->permisos->obtenerPermiso($session->id_rol,'Eliminar Rol');
        }else{
            $verRoles = "enabled='true'";
            $agregar = "enabled='true'";
            $editar = "enabled='true'";
            $actualizar = "enabled='true'";
            $eliminar = "enabled='true'";           
        }      

        if ($verRoles=="enabled='true'"){            
            $roles = $this->roles->where('activo', $activo)->findAll(); /*le asigno a la variable la consulta dada */
            $modulos = $this->modulos->buscar_modulos(1);
            $data = ['titulo' => 'MANEJO DE ROLES','usuario'=> $session->id_rol,'accion'=>'Agregar Roles','datos' => $roles, 'modulos' => $modulos, 'roles' => $roles, 'agregar' => $agregar, 'editar' => $editar, 'actualizar' => $actualizar, 'eliminar' => $eliminar]; /*creamos el arreglo $data y se lo enviamos a la vista con los campos definidos, datos tendra toda la informacion resultante de la consulta */
            /* mostramos la vista */
            echo view('header', $data);
            echo view('roles/roles', $data);
            echo view('footer');            
        }else{
            return redirect()->to(base_url(). '/principal');
            $message ='Usted no Tiene Autorización para Ver esta Opción';
            echo "<script type='text/javascript'>alert('$message');</script>";
        }

    }

    public function nuevo()
    {
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $data = ['titulo' => 'CREAR ROL', 'modulos' => $modulos, 'roles' => $roles];

        echo view('header', $data);
        echo view('roles/nuevo', $data);
        echo view('footer');
    }
    public function eliminados($activo = 0)
    {    
        $session = session();
        if ($session->id_rol!=1) {
            $activar = $this->permisos->obtenerPermiso($session->id_rol, 'Activar Rol');
        }else{$activar = "enabled='true'"; }
        $roles = $this->roles->mostrarEliminados($activo);        
        $modulos = $this->modulos->buscar_modulos(1);
        $data = ['titulo' => 'ROLES ELIMINADOS', 'datos' => $roles, 'modulos' => $modulos,'activar'=>$activar]; /*creamos el arreglo $data y se lo enviamos a la vista con los campos definidos, datos tendra toda la informacion resultante de la consulta */

        /* mostramos la vista */
        echo view('header', $data);
        echo view('roles/eliminados', $data);
        echo view('footer');
    }

    public function insertar()
    {
        $roles = $this->roles->where('activo', 1)->findAll(); /*le asigno a la variable la consulta dada */
        $modulos = $this->modulos->buscar_modulos(1);
        $data = ['titulo' => 'MANEJO DE ROLES', 'datos' => $roles, 'modulos' => $modulos, 'roles' => $roles];
        //$data = ['titulo' => 'CREAR ROL', 'modulos' => $modulos];

        if ($this->request->getMethod() == "post" && $this->validate($this->reglas)) {

            $this->roles->save([
                'nombre' => $this->request->getPost('nombre'),
                'descripcion' => $this->request->getPost('descripcion'),
                'padre' => $this->request->getPost('padre')
            ]);

            /* save=metodo de guardar []=por ser arreglos y los campos a guardar, getPost por si se usa uno de los 2 lo valide */
            return redirect()->to(base_url() . '/roles');
            /* dejamos la accion en el mismo formulario */
            /* return redirect()->to(base_url() . '/roles'); redireccionamos el retorno despues de guardar a la pantalla de index o la principal de roles */
        } else {
            $data = ['titulo' => 'CREAR ROL', 'modulos' => $modulos, 'validaton' => $this->validator];
            echo view('header', $data);
            echo view('roles/nuevo', $data);
            echo view('footer');
        }
    }

    public function editar($id, $valid = null)
    { {
        $session = session();
        if ($session->id_rol!=1) {
            $actualizar = $this->permisos->obtenerPermiso($session->id_rol, 'Actualizar Rol');
        }else{$actualizar = "enabled='true'"; }        
            $rol = $this->roles->where('id', $id)->first(); /*consulta de registro a editar */
            $modulos = $this->modulos->buscar_modulos(1);
            $roles = $this->roles->where('activo', 1)->findAll();
            if ($valid !== null) {
                $data = ['titulo' => 'EDITAR ROL', 'datos' => $rol, 'modulos' => $modulos, 'roles' => $roles, 'actualizar' => $actualizar, 'validation' => $valid];
            } else {
                $data = ['titulo' => 'EDITAR ROL', 'datos' => $rol, 'modulos' => $modulos, 'roles' => $roles, 'actualizar' => $actualizar];
            }

            echo view('header', $data);
            echo view('roles/editar', $data);
            echo view('footer');
        }
    }
    public function actualizar()
    {
        //$session = session();
        if ($this->request->getMethod() == "post") {
            $this->roles->update($this->request->getPost('id_ed'), [
                'nombre' => $this->request->getPost('nombre_ed'),
                'descripcion'  => $this->request->getPost('descripcion_ed'),
                'padre'  => $this->request->getPost('padre_ed')
            ]);
            return redirect()->to(base_url() . '/roles');
        } else {
            return redirect()->to(base_url() . '/roles');
            //return $this->editar($this->request->getPost('id'),$this->validator);
        }
    }
    public function eliminar($id)
    {
        $session = session();
        if ($this->request->getMethod() == "get") {
            $this->roles->update($id, [
                'activo' => 0,
                'fecha_elimina' => date('Y-m-d H:i:s'),
                'usuario_elimina'  =>  $session->id_usuario
            ]);
            return redirect()->to(base_url() . '/roles');
        }

        //$this->roles->update($id, ['activo' => 0],['usuario_elimina' =>  $session->id_usuario]);
        return redirect()->to(base_url() . '/roles');
    }
    public function activar($id)
    {
        if ($this->request->getMethod() == "get") {
            $this->roles->update($id, [
                'activo' => 1,
                'fecha_elimina' => 'Null',
                'usuario_elimina'  =>  'Null'
            ]);
            
        }
        //$this->roles->update($id, ['activo' => 1]);
        $where = " activo = 1 order by padre_id,orden";
        $modulos = $this->modulos->where($where)->findAll();
        return redirect()->to(base_url() . '/roles/eliminados');
    }

    public function buscarRol($id)
    {
        $returnData = array();
        $roles = $this->roles->presentarRol($id);
        if (!empty($roles)) {
            array_push($returnData, $roles);
        }
        echo json_encode($returnData);
    }
}
