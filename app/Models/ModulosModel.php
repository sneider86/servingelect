<?php

namespace App\Models; 
use CodeIgniter\Model;
class ModulosModel extends Model{
    protected $table      = 'modulos'; 
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array'; 
    protected $useSoftDeletes = false;
    protected $allowedFields = ['activo','nombre','orden','padre_id','orden_padre','tipo','codigo','icono','desktop','aplicacion'];
    protected $useTimestamps = true; 
    protected $createdField  = 'fecha_alta'; 
    protected $updatedField  = ''; 
    protected $deletedField  = ''; 
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;


    function buscar_modulos($activo=0){
        $this->select('modulos.*');
        $this->where('activo',$activo);
        $this->orderBy('orden_padre');
        $this->orderBy('orden');
        $datos = $this->findAll();
        return $datos;
    }
}
