<?php

namespace App\Controllers;



use App\Controllers\BaseController; /*la plantilla del controlador general de codeigniter */
use App\Models\RolesModel;
use App\Models\ModulosModel;
use App\Models\AccionesModel;
use App\Models\PermisosModel;

class Acciones extends BaseController
{
    /*interactua el controlador con el modelo */
    protected $roles,  $acciones, $permisos;
    protected $modulos;
    protected $reglas;

    public function __construct()
    {
        $this->roles = new RolesModel();
        $this->modulos = new ModulosModel();
        $this->acciones = new AccionesModel();
        $this->permisos = new PermisosModel();

        helper(['form']);

        $this->reglas = [
            'nombre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El Campo {field} es Obligatorio.'
                ]
            ],
            'id_modulo' => [
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
            $Acciones = $this->permisos->obtenerPermiso($session->id_rol, 'Ver Acciones');
            $agregar = $this->permisos->obtenerPermiso($session->id_rol,'Agregar Acción');
            $editar = $this->permisos->obtenerPermiso($session->id_rol,'Editar Acción');
            $actualizar = $this->permisos->obtenerPermiso($session->id_rol,'Actualizar Acción');
            $eliminar = $this->permisos->obtenerPermiso($session->id_rol,'Eliminar Acción'); 
        }else{
            $Acciones = "enabled='true'";
            $agregar = "enabled='true'";
            $editar = "enabled='true'";
            $actualizar = "enabled='true'";
            $eliminar = "enabled='true'";           
        }       
        if ($Acciones == "enabled='true'") {
            $roles = $this->roles->where('activo', 1)->findAll();
            $modulos = $this->modulos->buscar_modulos(1);
            $acciones = $this->acciones->where('activo', $activo)->findAll();
            $data = ['titulo' => 'MANEJO DE ACCIONES', 'datos' =>  $acciones, 'roles' => $roles, 'modulos' => $modulos, 'agregar' => $agregar, 'editar' => $editar, 'actualizar' => $actualizar, 'eliminar' => $eliminar];
            /* mostramos la vista */
            echo view('header', $data);
            echo view('acciones/acciones', $data);
            echo view('footer');
        } else {
            return redirect()->to(base_url() . '/principal');
            $message = 'Usted no Tiene Autorización para Ver esta Opción';
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
    }

    public function eliminados($activo = 0)
    {
        $session = session();
        if ($session->id_rol!=1) {
            $activar = $this->permisos->obtenerPermiso($session->id_rol,'Activar Acción');
        }else{$activar = "enabled='true'"; }        
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $acciones = $this->acciones->where('activo', $activo)->findAll();
        $data = ['titulo' => 'ACCIONES ELIMINADAS', 'datos' => $acciones, 'modulos' => $modulos, 'roles' => $roles, 'activar' => $activar];
        echo view('header', $data);
        echo view('acciones/eliminados', $data);
        echo view('footer');
    }

    public function nuevo()
    {
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $data = ['titulo' => 'CREAR ACCIONES', 'modulos' => $modulos, 'roles' => $roles];

        echo view('header', $data);
        echo view('acciones/nuevo', $data);
        echo view('footer');
    }

    public function insertar()
    {
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $data = ['titulo' => 'CREAR ACCIONES', 'modulos' => $modulos];
        $session = session();
        if ($this->request->getMethod() == "post" && $this->validate($this->reglas)) {

            $this->acciones->save([
                'nombre' => $this->request->getPost('nombre'),
                'id_modulo' => $this->request->getPost('id_modulo'),
                'usuario_crea' => $session->id_usuario
            ]);
            return redirect()->to(base_url() . '/acciones');
        } else {
            $data = ['titulo' => 'CREAR MODULOS', 'roles' => $roles, 'modulos' => $modulos, 'validaton' => $this->validator];
            echo view('header', $data);
            echo view('acciones/nuevo', $data);
            echo view('footer');
        }
    }

    public function editar($id, $valid = null)
    { {
            $roles = $this->roles->where('activo', 1)->findAll();
            $modulos = $this->modulos->buscar_modulos(1);
            $acciones = $this->acciones->where('id', $id)->first();
            if ($valid !== null) {
                $data = ['titulo' => 'EDITAR ACCIONES', 'datos' => $acciones, 'modulos' => $modulos, 'roles' => $roles, 'validation' => $valid];
            } else {
                $data = ['titulo' => 'EDITAR ACCIONES', 'datos' => $acciones, 'modulos' => $modulos, 'roles' => $roles];
            }

            echo view('header', $data);
            echo view('acciones/editar', $data);
            echo view('footer');
        }
    }
    public function actualizar()
    {
        if ($this->request->getMethod() == "post" ) {
            $this->acciones->update($this->request->getPost('id_ed'), [
                'nombre' => $this->request->getPost('nombre_ed'),
                'id_modulo' => $this->request->getPost('id_modulo_ed')
            ]);
            return redirect()->to(base_url() . '/acciones');
        } else {
            return redirect()->to(base_url() . '/acciones');
            //return $this->editar($this->request->getPost('id'), $this->validator);
        }
    }

    public function eliminar($id)
    {
        $this->acciones->update($id, ['activo' => 0]);
        //$modulos = $this->modulos->where('activo', 1)->findAll();
        return redirect()->to(base_url() . '/acciones');
    }
    public function activar($id)
    {
        $this->acciones->update($id, ['activo' => 1]);
        //$modulos = $this->modulos->where('activo', 1)->findAll();
        return redirect()->to(base_url() . '/acciones/eliminados');
    }

    public function buscarAccion($id)
    {
        $returnData = array();
        $acciones = $this->acciones->presentarAccion($id);
        if (!empty($acciones)) {
            array_push($returnData, $acciones);
        }
        echo json_encode($returnData);
    }    
}
