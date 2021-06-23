<?php

namespace App\Models; 
use CodeIgniter\Model;
class AccionesModel extends Model{
    protected $table      = 'acciones'; 
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array'; 
    protected $useSoftDeletes = false;
    protected $allowedFields = ['nombre','id_modulo','id_padre','activo','usuario_crea'];
    protected $useTimestamps = true; 
    protected $createdField  = 'fecha_alta'; 
    protected $updatedField  = ''; 
    protected $deletedField  = 'deleted_at'; 
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function presentarAccion($id)
    {
        $this->select('acciones.*, m.nombre AS nombre_modulo,m.id as id_modulo');
        $this->join('modulos AS m', 'acciones.id_modulo = m.id');
        $this->where('acciones.id', $id);
        $datos = $this->first();
        return $datos;
    }
    public function listarAccion($activo)
    {
        $this->select('acciones.*, m.nombre AS nombre_modulo,m.id as id_modulo');
        $this->join('modulos AS m', 'acciones.id_modulo = m.id');
        $this->where('acciones.activo', $activo);
        $datos = $this->findall();
        return $datos;
    }  
    
    public function traer_Acciones($modulos, $rol)
    {
        $where = "acciones.id_modulo = $modulos";
        $variable = "acciones.id=b.id_accion AND b.id_usuario="."$rol";
        $this->select('acciones.*');
        $this->join('permisos as b',$variable,'left');
        $this->where($where);
        //$this->where('acciones.id_modulo', $modulos);
        $this->where('b.id_accion', NULL);
        $this->orderBy('acciones.id_modulo');
        $this->orderBy('acciones.id_padre');
        $datos = $this->findall();
        return $datos;
    }      
    
}

