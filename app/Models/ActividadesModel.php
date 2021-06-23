<?php

namespace App\Models; //Reservamos el espacio de nombre de la ruta app\models
use CodeIgniter\Model;
class ActividadesModel extends Model{
    protected $table      = 'actividades'; /* nombre de la tabla modelada/*/
    protected $primaryKey = 'codigo';

    protected $useAutoIncrement = false;

    protected $returnType     = 'array';  /* forma en que se retornan los datos */
    protected $useSoftDeletes = false; /* si hay eliminacion fisica de registro */

    protected $allowedFields = ['id_grupo', 'codigo','nombre','activo']; /* relacion de campos de la tabla */

    protected $useTimestamps = true; /*tipo de tiempo a utilizar */
    protected $createdField  = ''; /*fecha automatica para la creacion */
    protected $updatedField  = ''; /*fecha automatica para la edicion */
    protected $deletedField  = ''; /*no se usara, es para la eliminacion fisica */

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function obtenerGruposDivisionSeccion($tipo) {
        $this->select('actividades.*, d.id_seccion,d.nombre AS nombre_division, s.nombre AS nombre_seccion, g.codigo AS id_grupo, g.nombre AS nombre_grupo');
        $this->join('grupos AS g', 'g.codigo = actividades.id_grupo'); 
        $this->join('divisiones AS d', 'd.codigo = g.id_division');         
        $this->join('secciones AS s', 'd.id_seccion = s.codigo');     
        $this->where('actividades.activo',$tipo);      
        $datos = $this->findAll();
        //print_r($this->getLastQuery()); //mostrar lo que ejecuta el query, luego en ver codigo fuente extraemos el select que se ejecuta
        return $datos;
    }

}
