<?php

namespace App\Models; 
use CodeIgniter\Model;
class MaterialesModel extends Model{
    protected $table      = 'materiales'; 
    protected $primaryKey = 'id_material';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array'; 
    protected $useSoftDeletes = false;
    protected $allowedFields = ['codigo','descripcion','unidad_medida','ultimo_costo','id_familia','activo','usuario_crea'];
    protected $useTimestamps = true; 
    protected $createdField  = 'fecha_alta'; 
    protected $updatedField  = 'fecha_edit'; 
    protected $deletedField  = 'deleted_at'; 
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function listaporDetalleParametros($activo){

        $this->select('materiales.*, id, valor, v_familiasmateriales.nombre AS nombre_grupo,f.nombre as nombre_familia');
        $this->join('detalleparametros ', 'id = unidad_medida');
        $this->join('v_familiasmateriales','materiales.id_familia = v_familiasmateriales.id_family');
        $this->join('family_materiales as f','f.id_family = v_familiasmateriales.id_padre');
        $this->where('materiales.activo',$activo);
        $datos = $this->findAll();
        //print_r($this->getLastQuery()); //mostrar lo que ejecuta el query, luego en ver codigo fuente extraemos el select que se ejecuta
        return $datos;
    }
}

