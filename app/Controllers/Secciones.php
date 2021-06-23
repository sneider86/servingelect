<?php

namespace App\Controllers;


use App\Controllers\BaseController; /*la plantilla del controlador general de codeigniter */
use App\Models\ParametrosModel;
use App\Models\RolesModel; /* clase a la cual se esta apuntando con los modelos */
use App\Models\ModulosModel;
use App\Models\SeccionesModel;
use App\Models\PermisosModel;

class Secciones extends BaseController
{
    /*interactua el controlador con el modelo */
    protected $secciones, $roles, $modulos;
    protected $reglas, $permisos;

    public function __construct()
    {
        $this->secciones = new ParametrosModel();
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
        if ($session->id_rol != 1) {
            $verSeccion = $this->permisos->obtenerPermiso($session->id_rol, 'Ver Secciones');
            $agregar = $this->permisos->obtenerPermiso($session->id_rol, 'Agregar Sección');
            $editar = $this->permisos->obtenerPermiso($session->id_rol, 'Editar Sección');
            $actualizar = $this->permisos->obtenerPermiso($session->id_rol, 'Actualizar Sección');
            $eliminar = $this->permisos->obtenerPermiso($session->id_rol, 'Eliminar Sección');
        } else {
            $verSeccion = "enabled='true'";
            $agregar = "enabled='true'";
            $editar = "enabled='true'";
            $actualizar = "enabled='true'";
            $eliminar = "enabled='true'";
        }

        if ($verSeccion == "enabled='true'") {
            $roles = $this->roles->where('activo', 1)->findAll();
            $modulos = $this->modulos->buscar_modulos(1);
            $secciones = $this->secciones->where('activo', $activo)->findAll();
            $data = ['titulo' => 'MANEJO DE SECCIONES', 'datos' => $secciones, 'roles' => $roles, 'modulos' => $modulos, 'agregar' => $agregar, 'editar' => $editar, 'actualizar' => $actualizar, 'eliminar' => $eliminar];
            /* mostramos la vista */
            echo view('header', $data);
            echo view('actividades/secciones', $data);
            echo view('footer');
        } else {
            return redirect()->to(base_url() . '/principal');
            $message = 'Usted no Tiene Autorización para Ver esta Opción';
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
    }

    public function eliminados_seccion($activo = 0)
    {
        $session = session();
        if ($session->id_rol != 1) {
            $activar = $this->permisos->obtenerPermiso($session->id_rol, 'Activar Sección');
        } else {
            $activar = "enabled='true'";
        }
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $secciones = $this->secciones->where('activo', $activo)->findAll();
        $data = ['titulo' => 'SECCIONES ELIMINADAS', 'datos' => $secciones, 'roles' => $roles, 'modulos' => $modulos, 'activar' => $activar];

        echo view('header', $data);
        echo view('actividades/eliminados_seccion', $data);
        echo view('footer');
    }

    public function nueva_seccion()
    {
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $data = ['titulo' => 'CREAR SECCIONES', 'roles' => $roles, 'modulos' => $modulos];
        echo view('header', $data);
        echo view('actividades/nueva_seccion', $data);
        echo view('footer');
    }

    public function inserta_seccion()
    {
        if ($this->request->getMethod() == "post" && $this->validate($this->reglas)) {
            $session = session();
            $resultado = $this->secciones->insertaSeccion($this->request->getPost('codigo'), $this->request->getPost('nombre'));
            if (!$resultado) {
                return $this->nueva_seccion();
            }

            /*
            $this->secciones->save([
                'codigo' => strtoupper($this->request->getPost('codigo')),
                'nombre' => strtoupper($this->request->getPost('nombre'))
            ]);
            */
            /* save=metodo de guardar []=por ser arreglos y los campos a guardar, getPost por si se usa uno de los 2 lo valide */
            return redirect()->to(base_url() . '/secciones');
            /* dejamos la accion en el mismo formulario */
            /* return redirect()->to(base_url() . '/secciones'); redireccionamos el retorno despues de guardar a la pantalla de index o la principal de secciones */
        } else {
            $roles = $this->roles->where('activo', 1)->findAll();
            $modulos = $this->modulos->buscar_modulos(1);
            $data = ['titulo' => 'CREAR SECCIONES', 'roles' => $roles, 'modulos' => $modulos, 'validaton' => $this->validator];
            echo view('header', $data);
            echo view('actividades/nueva_seccion', $data);
            echo view('footer');
        }
    }

    public function edita_seccion($id, $valid = Null)
    {

        $seccion = $this->secciones->where('codigo', $id)->first();
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        if ($valid !== null) {
            $data = ['titulo' => 'EDITAR SECCION', 'datos' => $seccion, 'roles' => $roles, 'modulos' => $modulos, 'validation' => $valid];
        } else {
            $data = ['titulo' => 'EDITAR SECCION', 'datos' => $seccion, 'roles' => $roles, 'modulos' => $modulos];
        }

        echo view('header', $data);
        echo view('actividades/editar_seccion', $data);
        echo view('footer');
    }

    public function actualizar_seccion()
    {

        if ($this->request->getMethod() == "post") {
            $this->secciones->update($this->request->getPost('id_ed'), [
                'nombre' => $this->request->getPost('nombre_ed')
            ]);
            return redirect()->to(base_url() . '/secciones');
        } else {
            //return $this->edita_seccion($this->request->getPost('id'), $this->validator);
            return redirect()->to(base_url() . '/secciones');
        }
    }
    public function elimina_seccion($id)
    {
        $this->secciones->update($id, ['activo' => 0]);
        return redirect()->to(base_url() . '/secciones');
    }
    public function activa_seccion($id)
    {
        $this->secciones->update($id, ['activo' => 1]);
        return redirect()->to(base_url() . '/secciones/eliminados_seccion');
    }

    public function buscarSeccion($id)
    {
        $returnData = array();
        $secciones = $this->secciones->presentarSeccion($id);
        if (!empty($secciones)) {
            array_push($returnData, $secciones);
        }
        echo json_encode($returnData);
    }
    public function buscar_Seccion($codigo)
    {
        $datos = $this->secciones->where('codigo', $codigo)->first();
        if ($datos) {
            return 'true';
        } else {
            return 'false';
        }
    }
}
