<?php

namespace App\Controllers;


use App\Controllers\BaseController; /*la plantilla del controlador general de codeigniter */
use App\Models\RolesModel;
use App\Models\ModulosModel;

class Modulos extends BaseController
{
    /*interactua el controlador con el modelo */
    protected $roles,  $nodulos;
    protected $modulos;
    protected $reglas;

    public function __construct()
    {
        $this->roles = new RolesModel();
        $this->modulos = new ModulosModel();

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
        $where = " activo = 1 order by padre_id,orden";
        $modulos = $this->modulos->where($where)->findAll();
        $data = ['titulo' => 'MANEJO DE MODULOS', 'datos' =>  $modulos]; 
        /* mostramos la vista */
        echo view('header', $data);
        echo view('modulos/modulos', $data);
        echo view('footer');
    }

    public function eliminados($activo = 0) /*vista de los inactivos y por defecto se cargaran */
    {
        $roles = $this->roles->where('activo', $activo)->findAll(); /*le asigno a la variable la consulta dada */
        $modulos = $this->modulos->where('activo', 1)->findAll();
        $data = ['titulo' => 'MODULOS ELIMINADOS', 'datos' => $roles, 'modulos' => $modulos]; /*creamos el arreglo $data y se lo enviamos a la vista con los campos definidos, datos tendra toda la informacion resultante de la consulta */

        /* mostramos la vista */
        echo view('header', $data);
        echo view('modulos/eliminados', $data);
        echo view('footer');
    }

    public function nuevo()
    {
        $modulos = $this->modulos->where('activo', 1)->findAll();
        $roles = $this->roles->where('activo',1)->findAll();
        $data = ['titulo' => 'CREAR MODULOS', 'modulos' => $modulos, 'roles' => $roles];

        echo view('header', $data);
        echo view('modulos/nuevo', $data);
        echo view('footer');
    }

    public function insertar()
    {
        $where =" activo = 1 order by padre_id,orden";
        $modulos = $this->modulos->where($where)->findAll();
        $data = ['titulo' => 'CREAR MODULOS', 'modulos' => $modulos];

        if ($this->request->getMethod() == "post" && $this->validate($this->reglas)) {

            $this->modulos->save([
                'nombre' => $this->request->getPost('nombre'),
                'orden' => $this->request->getPost('orden'),
                'padre_id' => $this->request->getPost('padre_id'),
                'tipo' => $this->request->getPost('tipo'),
                'codigo' => $this->request->getPost('codigo'),
                'icon' => $this->request->getPost('icon'),
                'desktop' => 1,
                'aplicacion' => $this->request->getPost('aplicacion')
            ]);

            /* save=metodo de guardar []=por ser arreglos y los campos a guardar, getPost por si se usa uno de los 2 lo valide */
            return redirect()->to(base_url() . '/modulos');
            /* dejamos la accion en el mismo formulario */
            /* return redirect()->to(base_url() . '/roles'); redireccionamos el retorno despues de guardar a la pantalla de index o la principal de roles */
        } else {
            $data = ['titulo' => 'CREAR MODULOS','modulos' => $modulos,'validaton' => $this->validator]; 
            echo view('header', $data);
            echo view('modulos/nuevo', $data);
            echo view('footer');
        }
    }

    public function editar($id, $valid=null)
    { {
            $rol = $this->roles->where('id', $id)->first(); /*consulta de registro a editar */
            $modulos = $this->modulos->where('activo', 1)->first();
            $roles = $this->roles->where('activo',1)->findAll();

            if($valid !== null){
                $data = ['titulo' => 'EDITAR MODULOS', 'datos' => $rol, 'modulos' => $modulos,'roles' => $roles,'validation' => $valid];

            }else{
                $data = ['titulo' => 'EDITAR MODULOS', 'datos' => $rol, 'modulos' => $modulos,'roles' => $roles];
            }
            
            echo view('header', $data);
            echo view('modulos/editar', $data);
            echo view('footer');
        }
    }
    public function actualizar()
    {
        if ($this->request->getMethod() == "post" && $this->validate($this->reglas)) {
            $this->modulos->update($this->request->getPost('id'), [
                'nombre' => $this->request->getPost('nombre'),
                'orden' => $this->request->getPost('orden'),
                'padre_id' => $this->request->getPost('padre_id'),
                'tipo' => $this->request->getPost('tipo'),
                'codigo' => $this->request->getPost('codigo'),
                'icon' => $this->request->getPost('icon'),
                'desktop' => 1,
                'aplicacion' => $this->request->getPost('aplicacion')
        ]);
            return redirect()->to(base_url() . '/modulos');
        } else {
            return $this->editar($this->request->getPost('id'),$this->validator);
        }
    }

    public function eliminar($id)
    {
        $this->modulos->update($id, ['activo' => 0]);
        $modulos = $this->modulos->where('activo', 1)->findAll();
        return redirect()->to(base_url() . '/modulos');
    }
    public function activar($id)
    {
        $this->modulos->update($id, ['activo' => 1]);
        $modulos = $this->modulos->where('activo', 1)->findAll();
        return redirect()->to(base_url() . '/modulos/eliminados');
    }
}
