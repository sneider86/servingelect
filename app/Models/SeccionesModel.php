<?php

namespace App\Models; //Reservamos el espacio de nombre de la ruta app\models
use CodeIgniter\Model;
class SeccionesModel extends Model{
    protected $table      = 'secciones'; /* nombre de la tabla modelada/*/
    protected $primaryKey = 'codigo';
    protected $useAutoIncrement = false;
    protected $returnType     = 'array';  /* forma en que se retornan los datos */
    protected $useSoftDeletes = false; /* si hay eliminacion fisica de registro */
    protected $allowedFields = ['codigo','nombre','activo']; /* relacion de campos de la tabla */
    protected $useTimestamps = true; /*tipo de tiempo a utilizar */
    protected $createdField  = ''; /*fecha automatica para la creacion */
    protected $updatedField  = ''; /*fecha automatica para la edicion */
    protected $deletedField  = ''; /*no se usara, es para la eliminacion fisica */
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function insertaSeccion($codigo, $nombre){
        if($this->insert([    
            'codigo' => $codigo, 
            'nombre' => $nombre
        ])){return true;}else{return false;} // $this->insertID(); //trae el id insertado en cliente
    }  

    public function presentarSeccion($id)
    {
        $this->select('secciones.*');
        $this->where('secciones.codigo', $id);
        $datos = $this->first();
        return $datos;
    }
}
