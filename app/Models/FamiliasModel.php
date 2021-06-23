<?php

namespace App\Models; 
use CodeIgniter\Model;
class FamiliasModel extends Model{
    protected $table      = 'family_dotaciones'; 
    protected $primaryKey = 'id_family';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array'; 
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id_padre','nombre','activo','usuario_crea'];
    protected $useTimestamps = true; 
    protected $createdField  = 'fecha_alta'; 
    protected $updatedField  = 'fecha_edit'; 
    protected $deletedField  = 'deleted_at'; 
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function buscarporFamilia($activo){

        $this->select('family_dotaciones.*');        
        $this->where('id_family=id_padre');
        $this->where('activo=',$activo);
        $datos = $this->findAll();        
        return $datos;
    }
    public function buscarporGrupo($family){
        $this->select('family_dotaciones.*');        
        $this->where('id_padre=',$family);
        $this->where('id_padre!=id_family');
        $this->where('activo=1');
        $datos = $this->findAll();
        return $datos;
    }    
  
}

