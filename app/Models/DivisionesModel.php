<?php

namespace App\Models; //Reservamos el espacio de nombre de la ruta app\models
use CodeIgniter\Model;
class DivisionesModel extends Model{
    protected $table      = 'divisiones'; /* nombre de la tabla modelada/*/
    protected $primaryKey = 'codigo';
    protected $useAutoIncrement = false;
    protected $returnType     = 'array';  /* forma en que se retornan los datos */
    protected $useSoftDeletes = false; /* si hay eliminacion fisica de registro */
    protected $allowedFields = ['id_seccion','codigo','nombre','activo']; /* relacion de campos de la tabla */
    protected $useTimestamps = true; /*tipo de tiempo a utilizar */
    protected $createdField  = ''; /*fecha automatica para la creacion */
    protected $updatedField  = ''; /*fecha automatica para la edicion */
    protected $deletedField  = ''; /*no se usara, es para la eliminacion fisica */
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function obtenerDivision($tipo) {
        $this->select('divisiones.*, divisiones.id_seccion, s.nombre as nombre_seccion');
        $this->join('secciones AS s', 'divisiones.id_seccion = s.codigo');   
        $this->where('divisiones.activo',$tipo);      
        $datos = $this->findAll();
        //print_r($this->getLastQuery()); //mostrar lo que ejecuta el query, luego en ver codigo fuente extraemos el select que se ejecuta
        return $datos;
    }

    public function insertaDivision($id_seccion,$codigo, $nombre){
        if($this->insert([ 
            'id_seccion' => strtoupper($id_seccion),   
            'codigo' => $codigo, 
            'nombre' => $nombre
        ])){return true;}else{return false;} // $this->insertID(); //trae el id insertado en cliente
    }  

    public function presentarDivision($id)
    {
        $this->select('divisiones.*');
        $this->where('divisiones.codigo', $id);
        $datos = $this->first();
        return $datos;
    }    
}
