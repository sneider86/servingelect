<?php

namespace App\Controllers;


use App\Controllers\BaseController; /*la plantilla del controlador general de codeigniter */
use App\Models\RolesModel;
use App\Models\ModulosModel;
use App\Models\PermisosModel;
use App\Models\DetalleParametrosModel;
use App\Models\ItemsModel;

use DateTimeZone;
use MessageFormatter;

class Items extends BaseController
{
    /*interactua el controlador con el modelo */
    protected $roles, $modulos, $permisos,$detalleparametros;
    protected $reglas,$items;

    public function __construct()
    {
        $this->roles = new RolesModel();
        $this->modulos = new ModulosModel();
        $this->permisos = new PermisosModel();
        $this->detalleparametros = new DetalleParametrosModel();        
        $this->items = new ItemsModel();
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
            $verItems = $this->permisos->obtenerPermiso($session->id_rol,'Ver Items');
            $agregar = $this->permisos->obtenerPermiso($session->id_rol,'Agregar Item');
            $editar = $this->permisos->obtenerPermiso($session->id_rol,'Editar Item');
            $actualizar = $this->permisos->obtenerPermiso($session->id_rol, 'Actualizar Item');
            $eliminar = $this->permisos->obtenerPermiso($session->id_rol,'Eliminar Item');
        }else{
            $verItems = "enabled='true'";
            $agregar = "enabled='true'";
            $editar = "enabled='true'";
            $actualizar = "enabled='true'";
            $eliminar = "enabled='true'";           
        }      

        if ($verItems=="enabled='true'"){            
            $items = $this->items->traerItems(1);
            $roles = $this->roles->where('activo', $activo)->findAll(); /*le asigno a la variable la consulta dada */
            $unidades = $this->detalleparametros->buscarDetalleParametros('Unidad de Medida'); 
            $modulos = $this->modulos->buscar_modulos(1);
            $data = ['titulo' => 'MANEJO ITEMS DE COTIZACION','usuario'=> $session->id_rol,'accion'=>'Agregar Items','datos' => $items, 'modulos' => $modulos, 'roles' => $roles, 'unidades' => $unidades, 'agregar' => $agregar, 'editar' => $editar, 'actualizar' => $actualizar, 'eliminar' => $eliminar]; /*creamos el arreglo $data y se lo enviamos a la vista con los campos definidos, datos tendra toda la informacion resultante de la consulta */
            /* mostramos la vista */
            echo view('header', $data);
            echo view('items/items', $data);
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
            $activar = $this->permisos->obtenerPermiso($session->id_rol, 'Activar Item');
        }else{$activar = "enabled='true'"; }
        $items = $this->items->traerItems(0);        
        $modulos = $this->modulos->buscar_modulos(1);
        $data = ['titulo' => 'ITEMS ELIMINADOS', 'datos' => $items, 'modulos' => $modulos,'activar'=>$activar];        
        echo view('header', $data);
        echo view('items/eliminados', $data);
        echo view('footer');
    }

    public function insertar()
    {
        $roles = $this->roles->where('activo', 1)->findAll(); /*le asigno a la variable la consulta dada */
        $modulos = $this->modulos->buscar_modulos(1);
        $data = ['titulo' => 'MANEJO DE ROLES', 'datos' => $roles, 'modulos' => $modulos, 'roles' => $roles];
        //$data = ['titulo' => 'CREAR ROL', 'modulos' => $modulos];

        if ($this->request->getMethod() == "post") {
            $session = session();
            $this->items->save([
                'descripcion' => $this->request->getPost('descripcion'),
                'unidad' => $this->request->getPost('unidad'),
                'usuario_crea' => $session->id_usuario
            ]);

            /* save=metodo de guardar []=por ser arreglos y los campos a guardar, getPost por si se usa uno de los 2 lo valide */
            return redirect()->to(base_url() . '/items');
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
            $actualizar = $this->permisos->obtenerPermiso($session->id_rol, 'Actualizar Item');
        }else{$actualizar = "enabled='true'"; }        
            $items = $this->items->presentarItems($id); 
            $unidades = $this->detalleparametros->buscarDetalleParametros('Unidad de Medida'); 
            $modulos = $this->modulos->buscar_modulos(1);
            $roles = $this->roles->where('activo', 1)->findAll();
            if ($valid !== null) {
                $data = ['titulo' => 'EDITAR ITEM', 'datos' => $items, 'modulos' => $modulos, 'roles' => $roles, 'unidades' => $unidades, 'actualizar' => $actualizar, 'validation' => $valid];
            } else {
                $data = ['titulo' => 'EDITAR ITEM', 'datos' => $items, 'modulos' => $modulos, 'roles' => $roles, 'unidades' => $unidades, 'actualizar' => $actualizar];
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
            $this->items->update($this->request->getPost('id_ed'), [
                'descripcion'  => $this->request->getPost('descripcion_ed'),
                'unidad'  => $this->request->getPost('unidad_ed')
            ]);
            return redirect()->to(base_url() . '/items');
        } else {
            return redirect()->to(base_url() . '/items');
            //return $this->editar($this->request->getPost('id'),$this->validator);
        }
    }
    public function eliminar($id)
    {
        $session = session();
        if ($this->request->getMethod() == "get") {
            $this->items->update($id, [
                'activo' => 0,
                'fecha_elimina' => date('Y-m-d H:i:s'),
                'usuario_elimina'  =>  $session->id_usuario
            ]);
            return redirect()->to(base_url() . '/items');
        }

        //$this->roles->update($id, ['activo' => 0],['usuario_elimina' =>  $session->id_usuario]);
        return redirect()->to(base_url() . '/items');
    }
    public function activar($id)
    {
        if ($this->request->getMethod() == "get") {
            $this->items->update($id, [
                'activo' => 1,
                'fecha_elimina' => 'Null',
                'usuario_elimina'  =>  'Null'
            ]);
            
        }
        //$this->roles->update($id, ['activo' => 1]);
        $where = " activo = 1 order by padre_id,orden";
        $modulos = $this->modulos->where($where)->findAll();
        return redirect()->to(base_url() . '/items/eliminados');
    }

    public function buscarItems($id)
    {
        $returnData = array();
        $items = $this->items->presentarItems($id);
        if (!empty($items)) {
            array_push($returnData, $items);
        }
        echo json_encode($returnData);
    }
}
