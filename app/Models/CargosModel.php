<?php

namespace App\Models; //Reservamos el espacio de nombre de la ruta app\models
use CodeIgniter\Model;
class CargosModel extends Model{
    protected $table      = 'cargos'; /* nombre de la tabla modelada/*/
    protected $primaryKey = 'id_cargo';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';  /* forma en que se retornan los datos */
    protected $useSoftDeletes = false; /* si hay eliminacion fisica de registro */

    protected $allowedFields = ['nombre','activo']; /* relacion de campos de la tabla */

    protected $useTimestamps = true; /*tipo de tiempo a utilizar */
    protected $createdField  = ''; /*fecha automatica para la creacion */
    protected $updatedField  = ''; /*fecha automatica para la edicion */
    protected $deletedField  = ''; /*no se usara, es para la eliminacion fisica */

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
 
}
