<?php

namespace App\Models; //Reservamos el espacio de nombre de la ruta app\models
use CodeIgniter\Model;
class Correos_telefonosModel extends Model{
    protected $table      = 'correos_telefonos'; /* nombre de la tabla modelada/*/
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';  /* forma en que se retornan los datos */
    protected $useSoftDeletes = false; /* si hay eliminacion fisica de registro */

    protected $allowedFields = ['indicativo','clave','id_tercero','valor','extension','tipo','orden','fecha']; /* relacion de campos de la tabla */

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

    public function porTercero($id,$clave) {  //consulta en el mismo modelo
        $this->select('*');
        $this->where('id_tercero', $id);
        $this->where('clave', $clave);
        $this->where('orden', 'P');
        $datos = $this->first();  //nos trae el registro encontrado 
       return $datos;
    }

    public function eliminarRegistro($id) {  
        $this->where('valor', $id);
        $this->delete();
    }

}
