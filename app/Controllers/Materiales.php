<?php
namespace App\Controllers;



use App\Controllers\BaseController; /*la plantilla del controlador general de codeigniter */
use App\Models\RolesModel;
use App\Models\ModulosModel;
use App\Models\AccionesModel;
use App\Models\MaterialesModel;
use App\Models\DetalleParametrosModel;
use App\Models\FamiliasMaterialesModel;

class Materiales extends BaseController
{
    /*interactua el controlador con el modelo */
    protected $roles,  $materiales,$detalleparametros,$familias_materiales,$grupos;
    protected $modulos;
    protected $reglas;

    public function __construct()
    {
        $this->roles = new RolesModel();
        $this->modulos = new ModulosModel();
        $this->acciones = new AccionesModel();
        $this->materiales = new MaterialesModel();
        $this->detalleparametros = new DetalleParametrosModel();
        $this->familias_materiales = new FamiliasMaterialesModel();
        $this->grupos = new FamiliasMaterialesModel();


    }

    /*Interactuamos con la vista con la funcion index */
    public function index($activo = 1) 
    {

        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $materiales = $this->materiales->listaporDetalleParametros($activo);
        $familias = $this->familias_materiales->buscarporFamilia($activo);
        //$grupos = $this->familias->buscarporGrupos($activo);
        $u_medida = $this->detalleparametros->buscarDetalleParametros('Unidad de Medida');
        $data = ['titulo' => 'MANEJO DE MATERIALES', 'datos' =>  $materiales,'roles' => $roles, 'modulos' => $modulos, 'u_medida' => $u_medida, 'familias' => $familias]; 
        /* mostramos la vista */
        echo view('header', $data);
        echo view('materiales/materiales', $data);
        echo view('footer');
    }
    public function getGrupos($family=1){
        $where = "id_padre= $family and id_family!=id_padre order by nombre ";
        $datos = $this->familias_materiales->where($where)->findAll();
        $cadena = "<select id='grupo' name='grupo'>";
        foreach ($datos as $row) {
            $cadena = $cadena.'<option value='. $row['id_family'].'>'.$row['nombre'].'</option>';
        }
        echo $cadena."</select>";
    }
    public function eliminados($activo = 0)
    {
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $materiales = $this->materiales->listaporDetalleParametros($activo);
        $u_medida = $this->detalleparametros->buscarDetalleParametros('Unidad de Medida');
        $data = ['titulo' => 'MANEJO DE MATERIALES', 'datos' =>  $materiales,'roles' => $roles, 'modulos' => $modulos, 'u_medida' => $u_medida]; 
        echo view('header', $data);
        echo view('materiales/eliminados', $data);
        echo view('footer');
    }

    public function nuevo()
    {
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $data = ['titulo' => 'CREAR MATERIALES', 'modulos' => $modulos, 'roles' => $roles];

        echo view('header', $data);
        echo view('materiales/nuevo', $data);
        echo view('footer');
    }

    public function insertar()
    {
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $materiales = $this->familias_materiales->where('activo', 1)->findAll();
        $u_medida = $this->detalleparametros->buscarDetalleParametros('Unidad de Medida');
        $data = ['titulo' => 'MANEJO DE MATERIALES', 'datos' =>  $materiales,'roles' => $roles, 'modulos' => $modulos, 'u_medida' => $u_medida]; 
        $session = session();  
        if ($this->request->getMethod() == "post") {

            $this->materiales->save([
                'codigo' => $this->request->getPost('codigo_mat'),
                'descripcion' => $this->request->getPost('descripcion_mat'),
                'ultimo_costo' => $this->request->getPost('costo_mat'),
                'unidad_medida' => $this->request->getPost('u_medida_mat'),
                'id_familia' => $this->request->getPost('grupo_mat'),
                'usuario_crea' => $session->id_usuario
            ]);
            return redirect()->to(base_url().'/materiales');
        } else { 
            echo view('header', $data);
            echo view('materiales/nuevo', $data);
            echo view('footer');
        }
    }

    public function editar($id, $valid=null)
    { {
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
            $materiales = $this->materiales->where('id',$id)->first();
            if($valid !== null){
                $data = ['titulo' => 'EDITAR MATERIALES', 'datos' => $materiales, 'modulos' => $modulos,'roles' => $roles,'validation' => $valid];

            }else{
                $data = ['titulo' => 'EDITAR MATERIALES', 'datos' => $materiales, 'modulos' => $modulos,'roles' => $roles];
            }
            
            echo view('header', $data);
            echo view('materiales/editar', $data);
            echo view('footer');
        }
    }
    public function actualizar()
    {
        if ($this->request->getMethod() == "post" && $this->validate($this->reglas)) {
            $this->materiales->update($this->request->getPost('id'), [
                'nombre' => $this->request->getPost('nombre'),
                'id_modulo' => $this->request->getPost('id_modulo')
        ]);
            return redirect()->to(base_url() . '/materiales');
        } else {
            return $this->editar($this->request->getPost('id'),$this->validator);
        }
    }

    public function eliminar($id)
    {
        $this->materiales->update($id, ['activo' => 0]);
        return redirect()->to(base_url() . '/materiales');
    }
    public function activar($id)
    {
        $this->materiales->update($id, ['activo' => 1]);
        return redirect()->to(base_url() . '/materiales/eliminados');
    }
}
