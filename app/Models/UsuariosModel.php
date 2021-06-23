<?php

namespace App\Models; //Reservamos el espacio de nombre de la ruta app\models
use CodeIgniter\Model;
class UsuariosModel extends Model{
    protected $table      = 'usuarios'; /* nombre de la tabla modelada/*/
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';  /* forma en que se retornan los datos */
    protected $useSoftDeletes = false; /* si hay eliminacion fisica de registro */

    protected $allowedFields = ['usuario','email','password','nombres', 'id_rol','activo','usuario_crea']; /* relacion de campos de la tabla */

    protected $useTimestamps = true; /*tipo de tiempo a utilizar */
    protected $createdField  = 'fecha_alta'; /*fecha automatica para la creacion */
    protected $updatedField  = 'fecha_edit'; /*fecha automatica para la edicion */
    protected $deletedField  = 'deleted_at'; /*no se usara, es para la eliminacion fisica */

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function listarUsuarios($activo)
    {
        $this->select('usuarios.*, r.nombre AS nombre_rol');
        $this->join('roles AS r', 'id_rol = r.id');
        $this->where('usuarios.activo', $activo);
        $datos = $this->findall();
        return $datos;
    }
    public function presentarUsuario($id)
    {
        $this->select('usuarios.*, r.nombre AS nombre_rol');
        $this->join('roles AS r', 'id_rol = r.id');
        $this->where('usuarios.id', $id);
        $datos = $this->first();
        return $datos;
    }
}
