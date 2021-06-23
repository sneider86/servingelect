<?php

namespace App\Models; 
use CodeIgniter\Model;
class ProyectosModel extends Model{
    protected $table      = 'proyectos'; 
    protected $primaryKey = 'id_proyecto';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array'; 
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id_cliente','tipo_proyecto','nombre_proyecto','descripcion','valor','fases','direccion_proyecto','municipio','sucursal','activo','usuario_crea'];
    protected $useTimestamps = true; 
    protected $createdField  = 'fecha_alta'; 
    protected $updatedField  = 'fecha_edit'; 
    protected $deletedField  = 'deleted_at'; 
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    /*
    public function listaporDetalleParametros($activo){

        $this->select('dotaciones.*, id, valor, v_familiasdotaciones.nombre AS nombre_grupo,f.nombre as nombre_familia');
        $this->join('detalleparametros ', 'id = unidad_medida');
        $this->join('v_familiasdotaciones','dotaciones.id_familia = v_familiasdotaciones.id_family');
        $this->join('family_dotaciones as f','f.id_family = v_familiasdotaciones.id_padre');
        $this->where('dotaciones.activo',$activo);
        $datos = $this->findAll();
        //print_r($this->getLastQuery()); //mostrar lo que ejecuta el query, luego en ver codigo fuente extraemos el select que se ejecuta
        return $datos;
    }

    public function presentarDotacion($id){

        $this->select('dotaciones.*, id, valor, v_familiasdotaciones.nombre AS nombre_grupo,f.nombre as nombre_familia,f.id_padre');
        $this->join('detalleparametros ', 'id = unidad_medida');
        $this->join('v_familiasdotaciones','dotaciones.id_familia = v_familiasdotaciones.id_family');
        $this->join('family_dotaciones as f','f.id_family = v_familiasdotaciones.id_padre');
        $this->where('dotaciones.id_dotacion',$id);
        $datos = $this->first();
        //print_r($this->getLastQuery()); //mostrar lo que ejecuta el query, luego en ver codigo fuente extraemos el select que se ejecuta
        return $datos;
    }    
    */
}

