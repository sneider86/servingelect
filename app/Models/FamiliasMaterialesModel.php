<?php

namespace App\Models; 
use CodeIgniter\Model;
class FamiliasMaterialesModel extends Model{
    protected $table      = 'family_materiales'; 
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

        $this->select('family_materiales.*');        
        $this->where('id_family=id_padre');
        $this->where('activo=',$activo);
        $datos = $this->findAll();
        //print_r($this->getLastQuery()); //mostrar lo que ejecuta el query, luego en ver codigo fuente extraemos el select que se ejecuta
        return $datos;
    }
    public function buscarporGrupo($family){

        $this->select('family_materiales.*');        
        $this->where('id_family=',$family);
        $this->where('activo=1');
        $datos = $this->findAll();
        return $datos;
    }    
}

