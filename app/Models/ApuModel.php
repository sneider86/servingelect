<?php

namespace App\Models; //Reservamos el espacio de nombre de la ruta app\models
use CodeIgniter\Model;

class ApuModel extends Model
{
    protected $table      = 'apus';
    protected $primaryKey = 'id_apu';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';  
    protected $useSoftDeletes = false; 
    protected $allowedFields = ['descripcion', 'unidad', 'maneja_detalle','activo', 'usuario_crea'];
    protected $useTimestamps = true;
    protected $createdField  = 'fecha_alta'; 
    protected $updatedField  = '';
    protected $deletedField  = ''; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function presentarApu($id)
    {
        $this->select('apus.*, d.valor AS nombre_unidad');
        $this->join('detalleparametros AS d', 'apus.unidad = d.id');
        $this->where('apus.id_apu', $id);
        $datos = $this->first();
        return $datos;
    }
    
    public function traerApus($activo=0)
    {
        $this->select('apus.*,  d.valor AS nombre_unidad');
        $this->join('detalleparametros AS d', 'apus.unidad = d.id');
        $this->where('apus.activo', $activo);
        $datos = $this->findall();
        return $datos;
    }
}
