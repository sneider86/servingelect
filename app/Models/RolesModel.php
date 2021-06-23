<?php

namespace App\Models; //Reservamos el espacio de nombre de la ruta app\models
use CodeIgniter\Model;

class RolesModel extends Model
{
    protected $table      = 'roles';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';  /* forma en que se retornan los datos */
    protected $useSoftDeletes = false; /* si hay eliminacion fisica de registro */
    protected $allowedFields = ['nombre', 'descripcion', 'padre', 'activo', 'usuario_crea', 'fecha_elimina', 'usuario_elimina'];
    protected $useTimestamps = true; /*tipo de tiempo a utilizar */
    protected $createdField  = 'fecha_alta'; /*fecha automatica para la creacion */
    protected $updatedField  = ''; /*fecha automatica para la edicion */
    protected $deletedField  = ''; /*no se usara, es para la eliminacion fisica */

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function presentarRol($id)
    {
        $this->select('roles.*, r.nombre AS nombre_padre,r.id as id_padre');
        $this->join('v_roles AS r', 'roles.padre = r.id');
        $this->where('roles.id', $id);
        $datos = $this->first();
        return $datos;
    }

    public function mostrarEliminados($activo=0)
    {
        $this->select('roles.*, u.nombres AS nombre_usuario, r.nombre AS nombre_padre');
        $this->join('usuarios AS u', 'roles.usuario_elimina = u.id');
        $this->join('v_roles AS r', 'roles.padre = r.id');
        $this->where('roles.activo', $activo);
        $datos = $this->findall();
        return $datos;
    }
}
