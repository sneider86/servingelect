<?php

namespace App\Models; //Reservamos el espacio de nombre de la ruta app\models
use CodeIgniter\Model;
class GruposModel extends Model{
    protected $table      = 'grupos'; /* nombre de la tabla modelada/*/
    protected $primaryKey = 'codigo';

    protected $useAutoIncrement = false;

    protected $returnType     = 'array';  /* forma en que se retornan los datos */
    protected $useSoftDeletes = false; /* si hay eliminacion fisica de registro */

    protected $allowedFields = ['id_division','codigo','nombre','activo']; /* relacion de campos de la tabla */

    protected $useTimestamps = true; /*tipo de tiempo a utilizar */
    protected $createdField  = ''; /*fecha automatica para la creacion */
    protected $updatedField  = ''; /*fecha automatica para la edicion */
    protected $deletedField  = ''; /*no se usara, es para la eliminacion fisica */

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function obtenerGrupoDivisionSeccion($tipo) {
        $this->select('grupos.*, d.id_seccion,d.nombre AS nombre_division, s.nombre AS nombre_seccion');
        $this->join('divisiones AS d', 'd.codigo = grupos.id_division');         
        $this->join('secciones AS s', 'd.id_seccion = s.codigo');     
        $this->where('grupos.activo',$tipo);      
        $datos = $this->findAll();
        //print_r($this->getLastQuery()); //mostrar lo que ejecuta el query, luego en ver codigo fuente extraemos el select que se ejecuta
        return $datos;
    }


}
