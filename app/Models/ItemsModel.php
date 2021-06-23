<?php

namespace App\Models; //Reservamos el espacio de nombre de la ruta app\models
use CodeIgniter\Model;

class ItemsModel extends Model
{
    protected $table      = 'items_cotiza';
    protected $primaryKey = 'id_item';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';  
    protected $useSoftDeletes = false; 
    protected $allowedFields = ['descripcion', 'unidad', 'activo', 'usuario_crea'];
    protected $useTimestamps = true;
    protected $createdField  = 'fecha_alta'; 
    protected $updatedField  = '';
    protected $deletedField  = ''; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function presentarItems($id)
    {
        $this->select('items_cotiza.*, d.valor AS nombre_unidad');
        $this->join('detalleparametros AS d', 'items_cotiza.unidad = d.id');
        $this->where('items_cotiza.id_item', $id);
        $datos = $this->first();
        return $datos;
    }
    
    public function traerItems($activo=0)
    {
        $this->select('items_cotiza.*,  d.valor AS nombre_unidad');
        $this->join('detalleparametros AS d', 'items_cotiza.unidad = d.id');
        $this->where('items_cotiza.activo', $activo);
        $datos = $this->findall();
        return $datos;
    }
}
