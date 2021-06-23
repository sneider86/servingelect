<?php

namespace App\Controllers;


use App\Controllers\BaseController; /*la plantilla del controlador general de codeigniter */
use App\Models\ParametrosModel;
use App\Models\RolesModel; /* clase a la cual se esta apuntando con los modelos */
use App\Models\ModulosModel;
use App\Models\DetalleParametrosModel;

class DetalleParametros extends BaseController
{
    /*interactua el controlador con el modelo */
    protected $parametros, $roles, $modulos,$detalle_parametros;
    protected $reglas;

    public function __construct()
    {
        $this->parametros = new ParametrosModel();
        $this->roles = new RolesModel();
        $this->modulos = new ModulosModel();
        $this->detalle_parametros = new DetalleParametrosModel();

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
    public function index($id_parametro)
    {
        $roles = $this->roles->where('activo', 1)->findAll();
        $where = " activo = 1 order by padre_id,orden";
        $modulos = $this->modulos->where($where)->findAll();

        //$parametros = $this->detalle_parametros->buscarDetalleParametros($id_parametro);          
        $detalle_parametros = $this->detalle_parametros->buscarDetalleParametros($id_parametro); 
        
        $data = ['titulo' => 'MANEJO DE DETALLE DE PARAMETROS', 'datos' => $detalle_parametros, 'roles' => $roles, 'modulos' => $modulos]; 

        /* mostramos la vista */
        echo view('header', $data);
        echo view('parametros/detalle_parametros', $data);
        echo view('footer');
    }

    public function detalle_parametros($id_parametro)
    { 
        $roles = $this->roles->where('activo', 1)->findAll();
        $where = " activo = 1 order by padre_id,orden";
        $modulos = $this->modulos->where($where)->findAll();

        //$parametros = $this->detalle_parametros->buscarDetalleParametros($id_parametro);          
        $detalle_parametros = $this->detalle_parametros->buscarDetalleParametros($id_parametro); 
        
        $data = ['titulo' => 'MANEJO DE DETALLE DE PARAMETROS', 'datos' => $detalle_parametros, 'roles' => $roles, 'modulos' => $modulos]; 
            echo view('header', $data);
            echo view('parametros/detalle_parametros', $data);
            echo view('footer');
        
    }
    public function eliminados($activo = 0) /*vista de los inactivos y por defecto se cargaran */
    {
        $roles = $this->roles->where('activo', 1)->findAll();
        $where = " activo = 1 order by padre_id,orden";
        $modulos = $this->modulos->where($where)->findAll();
        $parametros = $this->parametros->where('activo', $activo)->findAll(); /*le asigno a la variable la consulta dada */
        $data = ['titulo' => 'PARAMETROS ELIMINADOS', 'datos' => $parametros, 'roles' => $roles, 'modulos' => $modulos]; /*creamos el arreglo $data y se lo enviamos a la vista con los campos definidos, datos tendra toda la informacion resultante de la consulta */

        /* mostramos la vista */
        echo view('header', $data);
        echo view('parametros/eliminados', $data);
        echo view('footer');
    }

    public function nuevo()
    {
        $roles = $this->roles->where('activo', 1)->findAll();
        $where = " activo = 1 order by padre_id,orden";
        $modulos = $this->modulos->where($where)->findAll();
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
            $where = " activo = 1 order by padre_id,orden";
            $modulos = $this->modulos->where($where)->findAll();            
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
            $where = " activo = 1 order by padre_id,orden";
            $modulos = $this->modulos->where($where)->findAll(); 
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
        if ($this->request->getMethod() == "post" && $this->validate($this->reglas)) {
            $this->parametros->update($this->request->getPost('id'), [
            'descripcion' => $this->request->getPost('descripcion')
        ]);
            return redirect()->to(base_url() . '/parametros');
        } else {
            return $this->editar($this->request->getPost('id'),$this->validator);
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
}
