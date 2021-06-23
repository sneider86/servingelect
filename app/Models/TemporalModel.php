<?php

namespace App\Models; //Reservamos el espacio de nombre de la ruta app\models
use CodeIgniter\Model;
class TemporalModel extends Model{
    protected $table      = 'temporal'; /* nombre de la tabla modelada/*/
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';  /* forma en que se retornan los datos */
    protected $useSoftDeletes = false; /* si hay eliminacion fisica de registro */

    protected $allowedFields = ['valor','extension','tipo','orden','indicativo','activo','fecha','clave']; /* relacion de campos de la tabla */

    protected $useTimestamps = false; /*tipo de tiempo a utilizar */
    protected $createdField  = ''; /*fecha automatica para la creacion */
    protected $updatedField  = ''; /*fecha automatica para la edicion */
    protected $deletedField  = ''; /*no se usara, es para la eliminacion fisica */

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function porTelefono($numero, $tipo) {  //consulta en el mismo modelo
        $this->select('*');
        $this->where('valor', $numero);
        $this->where('tipo', $tipo);
        $datos = $this->get()->getRow();  //nos trae el registro encontrado 
        return $datos;
    }

    public function eliminarRegistro($id,$campo) {  
        $this->where($campo, $id);
        $this->delete();
    }

    public function eliminarTodo($id) {   
        $this->where('activo', $id);      
        $this->delete();
    }
}
