<?php

namespace App\Models; //Reservamos el espacio de nombre de la ruta app\models
use CodeIgniter\Model;
class PermisosModel extends Model{
    protected $table      = 'permisos'; /* nombre de la tabla modelada/*/
    protected $primaryKey = 'id_permiso';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';  /* forma en que se retornan los datos */
    protected $useSoftDeletes = false; /* si hay eliminacion fisica de registro */
    protected $allowedFields = ['id_usuario','id_accion','permiso','activo','usuario_crea','fecha_elimina','usuario_elimina']; /* relacion de campos de la tabla */
    protected $useTimestamps = true; /*tipo de tiempo a utilizar */
    protected $createdField  = 'fecha_alta'; /*fecha automatica para la creacion */
    protected $updatedField  = ''; /*fecha automatica para la edicion */
    protected $deletedField  = ''; /*no se usará, es para la eliminación física */
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function insertaPermiso($rol, $accion ,$permiso, $usuario){
        $this->insert([
            'id_usuario' => $rol,
            'id_accion' => $accion,
            'permiso' => $permiso,
            'usuario_crea' => $usuario
        ]);
        return $this->insertID(); //trae el id insertado en la compra
    }

    public function obtenerPermiso($usuario,$accion) {
        $this->select('permisos.*');
        $this->join('acciones AS a', 'a.id = permisos.id_accion');   
        $this->where('permisos.id_usuario', $usuario); 
        $this->where('a.nombre', $accion);    
        $datos = $this->first();
        if($datos){
            if($datos['permiso']==1){
                return "enabled='true'";
            }else{return "disabled='true'";}    
        }else {return "disabled='true'";}
    }

    public function lista_Permisos($rol) {
        $this->select('permisos.*,r.id as cod_rol,a.id as id_accion,a.nombre as nombre_accion,m.nombre as nombre_modulo');
        $this->join('roles AS r', 'r.id = permisos.id_usuario');   
        $this->join('acciones AS a', 'a.id = permisos.id_accion');   
        $this->join('modulos AS m', 'a.id_modulo = m.id');  
        $this->where('permisos.id_usuario', $rol);    
        $datos = $this->findAll();
        return $datos;
    }    

}
