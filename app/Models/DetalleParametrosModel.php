<?php

namespace App\Models; //Reservamos el espacio de nombre de la ruta app\models
use CodeIgniter\Model;

class DetalleParametrosModel extends Model
{
    protected $table      = 'detalleparametros'; /* nombre de la tabla modelada/*/
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';  /* forma en que se retornan los datos */
    protected $useSoftDeletes = false; /* si hay eliminacion fisica de registro */

    protected $allowedFields = ['valor', 'id_parametro', 'resumen', 'usuario_crea', 'activo']; /* relacion de campos de la tabla */

    protected $useTimestamps = true; /*tipo de tiempo a utilizar */
    protected $createdField  = 'fecha_alta'; /*fecha automatica para la creacion */
    protected $updatedField  = ''; /*fecha automatica para la edicion */
    protected $deletedField  = ''; /*no se usara, es para la eliminacion fisica */

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function buscarDetalleporParametros($tipo)
    {
        $this->select('detalleparametros.*, p.id AS id_cod, p.descripcion');
        $this->join('parametros AS p', 'p.id = detalleparametros.id_parametro');
        $this->where('detalleparametros.id_parametro=', $tipo);
        $datos = $this->findAll();
        //print_r($this->getLastQuery()); //mostrar lo que ejecuta el query, luego en ver codigo fuente extraemos el select que se ejecuta
        return $datos;
    }

    public function buscarDetalleParametros($tipo) {
        $this->select('detalleparametros.*');
        $this->join('parametros AS d', 'd.id = id_parametro');  //join es  como si se estuviera colocando un inner join en el select
        $datos = $this->where(['descripcion' => $tipo,'d.activo' =>1])->findAll();
                //print_r($this->getLastQuery()); //mostrar lo que ejecuta el query, luego en ver codigo fuente extraemos el select que se ejecuta
        return $datos;
    }
}
