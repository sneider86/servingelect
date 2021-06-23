<?php

namespace App\Models; //Reservamos el espacio de nombre de la ruta app\models
use CodeIgniter\Model;
class ParametrosModel extends Model{
    protected $table      = 'parametros'; /* nombre de la tabla modelada/*/
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';  /* forma en que se retornan los datos */
    protected $useSoftDeletes = false; /* si hay eliminacion fisica de registro */

    protected $allowedFields = ['descripcion', 'usuario_crea','activo']; /* relacion de campos de la tabla */

    protected $useTimestamps = true; /*tipo de tiempo a utilizar */
    protected $createdField  = 'fecha_alta'; /*fecha automatica para la creacion */
    protected $updatedField  = ''; /*fecha automatica para la edicion */
    protected $deletedField  = ''; /*no se usara, es para la eliminacion fisica */

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function buscarParametros($tipo) {
        $this->select('parametros.id AS id_param, parametros.descripcion AS nombre_parametro');        
        $where = "id = $tipo AND activo = 1";
        $this->where($where);
        $datos = $this->first();
        //print_r($this->getLastQuery()); //mostrar lo que ejecuta el query, luego en ver codigo fuente extraemos el select que se ejecuta
        return $datos;
    }

    public function presentarParametro($id)
    {
        $this->select('parametros.*');
        $this->where('parametros.id', $id);
        $datos = $this->first();
        return $datos;
    }    

}
