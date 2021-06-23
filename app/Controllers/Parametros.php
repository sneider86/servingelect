<?php

namespace App\Controllers;


use App\Controllers\BaseController; /*la plantilla del controlador general de codeigniter */
use App\Models\ParametrosModel;
use App\Models\RolesModel; /* clase a la cual se esta apuntando con los modelos */
use App\Models\ModulosModel;
use App\Models\DetalleParametrosModel;
use App\Models\PermisosModel;

class Parametros extends BaseController
{
    /*interactua el controlador con el modelo */
    protected $parametros, $roles, $modulos, $detalle_parametros;
    protected $reglas,$permisos;

    public function __construct()
    {
        $this->parametros = new ParametrosModel();
        $this->roles = new RolesModel();
        $this->modulos = new ModulosModel();
        $this->detalle_parametros = new DetalleParametrosModel();
        $this->permisos = new PermisosModel();

        helper(['form']);
        $this->reglas = [
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
            $verParametros = $this->permisos->obtenerPermiso($session->id_rol,'Ver Parámetros');
            $agregar = $this->permisos->obtenerPermiso($session->id_rol,'Agregar Parámetro');
            $agregarDetalles = $this->permisos->obtenerPermiso($session->id_rol,'Agregar Detalles de Parámetro');
            $editar = $this->permisos->obtenerPermiso($session->id_rol,'Editar Parámetro');
            $actualizar = $this->permisos->obtenerPermiso($session->id_rol, 'Actualizar Parámetro');
            $eliminar = $this->permisos->obtenerPermiso($session->id_rol,'Eliminar Parámetro');
        }else{
            $verParametros = "enabled='true'";
            $agregar = "enabled='true'";
            $agregarDetalles = "enabled='true'";
            $editar = "enabled='true'";
            $actualizar = "enabled='true'";
            $eliminar = "enabled='true'";           
        }
        if ($verParametros=="enabled='true'") {
            $roles = $this->roles->where('activo', 1)->findAll();
            $modulos = $this->modulos->buscar_modulos(1);
            $parametros = $this->parametros->where('activo', $activo)->findAll(); /*le asigno a la variable la consulta dada */
            $data = ['titulo' => 'MANEJO DE PARAMETROS', 'datos' => $parametros, 'roles' => $roles, 'modulos' => $modulos, 'agregar' => $agregar, 'agregarDetalles' => $agregarDetalles, 'editar' => $editar, 'actualizar' => $actualizar, 'eliminar' => $eliminar]; /*creamos el arreglo $data y se lo enviamos a la vista con los campos definidos, datos tendra toda la informacion resultante de la consulta */

            /* mostramos la vista */
            echo view('header', $data);
            echo view('parametros/parametros', $data);
            echo view('footer');
        }else{ return redirect()->to(base_url(). '/principal');}
    }

    public function detalle_parametros($id)
    {
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $parametros = $this->parametros->buscarParametros($id);        
        $detalle_parametros = $this->detalle_parametros->buscarDetalleporParametros($id); 

        $data = ['titulo' => 'MANEJO DETALLE DE PARAMETROS', 'datos' => $detalle_parametros, 'roles' => $roles, 'modulos' => $modulos, 'parametros' => $parametros]; 
        //, 'parametros' => $parametros
        /* mostramos la vista */
        echo view('header', $data);
        echo view('parametros/detalle_parametros', $data);
        echo view('footer');
    }

    public function agregar_detalle()
    {

        if ($this->request->getMethod() == "post" ) {
            $session = session();
            $this->detalle_parametros->save([
                'id_parametro'=>$this->request->getPost('id'),
                'valor' => $this->request->getPost('valor'),
                'resumen' => $this->request->getPost('resumen'),
                'usuario_crea' => $session->id_usuario
            ]);

            return redirect()->to(base_url() . '/parametros/detalle_parametros/'. $this->request->getPost('id'));
        } else {
            /*
            $roles = $this->roles->where('activo', 1)->findAll();
            $where = " activo = 1 order by padre_id,orden";
            $modulos = $this->modulos->where($where)->findAll();            
            $data = ['titulo' => 'CREAR PARAMETROS','roles' => $roles, 'modulos' => $modulos,'validaton' => $this->validator]; 
            echo view('header', $data);
            echo view('parametros/nuevo', $data);
            echo view('footer');
            */
        }
    }

    public function eliminados($activo = 0) /*vista de los inactivos y por defecto se cargaran */
    {
        $session = session();
        if ($session->id_rol!=1) {
            $activar = $this->permisos->obtenerPermiso($session->id_rol, 'Activar Rol');
        }else{$activar = "enabled='true'"; }
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $parametros = $this->parametros->where('activo', $activo)->findAll(); /*le asigno a la variable la consulta dada */
        $data = ['titulo' => 'PARAMETROS ELIMINADOS', 'datos' => $parametros, 'roles' => $roles, 'modulos' => $modulos,'activar'=>$activar]; /*creamos el arreglo $data y se lo enviamos a la vista con los campos definidos, datos tendra toda la informacion resultante de la consulta */

        /* mostramos la vista */
        echo view('header', $data);
        echo view('parametros/eliminados', $data);
        echo view('footer');
    }

    public function nuevo()
    {
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $data = ['titulo' => 'CREAR PARAMETROS', 'roles' => $roles, 'modulos' => $modulos];
        echo view('header', $data);
        echo view('parametros/nuevo', $data);
        echo view('footer');
    }

    public function insertar()
    {

        if ($this->request->getMethod() == "post" && $this->validate($this->reglas)) {
            $session = session();
            $this->parametros->save([
                'descripcion' => $this->request->getPost('descripcion'),
                'usuario_crea' => $session->id_usuario
            ]);

            /* save=metodo de guardar []=por ser arreglos y los campos a guardar, getPost por si se usa uno de los 2 lo valide */
            return redirect()->to(base_url() . '/parametros');
            /* dejamos la accion en el mismo formulario */
            /* return redirect()->to(base_url() . '/parametros'); redireccionamos el retorno despues de guardar a la pantalla de index o la principal de parametros */
        } else {
            $roles = $this->roles->where('activo', 1)->findAll();
            $modulos = $this->modulos->buscar_modulos(1);           
            $data = ['titulo' => 'CREAR PARAMETROS','roles' => $roles, 'modulos' => $modulos,'validaton' => $this->validator]; 
            echo view('header', $data);
            echo view('parametros/nuevo', $data);
            echo view('footer');
        }
    }

    public function editar($id, $valid=null)
    { {
            $parametro = $this->parametros->where('id', $id)->first(); /*consulta de registro a editar */
            $roles = $this->roles->where('activo', 1)->findAll();
            $modulos = $this->modulos->buscar_modulos(1);
            if($valid !== null){
                $data = ['titulo' => 'EDITAR PARAMETROS', 'datos' => $parametro,'roles' => $roles, 'modulos' => $modulos,'validation' => $valid];

            }else{
                $data = ['titulo' => 'EDITAR PARAMETROS', 'datos' => $parametro,'roles' => $roles, 'modulos' => $modulos];
            }
            
            echo view('header', $data);
            echo view('parametros/editar', $data);
            echo view('footer');
        }
    }
    public function actualizar()
    {
        if ($this->request->getMethod() == "post" ) {
            $this->parametros->update($this->request->getPost('id_ed'), [
            'descripcion' => $this->request->getPost('descripcion_ed')
        ]);
            return redirect()->to(base_url() . '/parametros');
        } else {
            return redirect()->to(base_url() . '/parametros');
            //return $this->editar($this->request->getPost('id'),$this->validator);
        }
    }

    public function eliminar($id)
    {
        $this->parametros->update($id, ['activo' => 0]);
        return redirect()->to(base_url() . '/parametros');
    }
    public function activar($id)
    {
        $this->parametros->update($id, ['activo' => 1]);
        return redirect()->to(base_url() . '/parametros/eliminados');
    }

    public function buscarParametro($id)
    {
        $returnData = array();
        $parametros = $this->parametros->presentarParametro($id);
        if (!empty($parametros)) {
            array_push($returnData, $parametros);
        }
        echo json_encode($returnData);
    }    
}
