<?php

namespace App\Models; //Reservamos el espacio de nombre de la ruta app\models
use CodeIgniter\Model;
class ProveedoresModel extends Model{
    protected $table      = 'proveedores'; /* nombre de la tabla modelada/*/
    protected $primaryKey = 'id_p';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';  /* forma en que se retornan los datos */
    protected $useSoftDeletes = false; /* si hay eliminacion fisica de registro */

    protected $allowedFields = ['id_tercero','nombre_contacto', 'cargo','rep_legal','email_replegal','activo','usuario_crea','sucursal']; /* relacion de campos de la tabla */

    protected $useTimestamps = true; /*tipo de tiempo a utilizar */
    protected $createdField  = 'fecha_alta'; /*fecha automatica para la creacion */
    protected $updatedField  = 'fecha_edit'; /*fecha automatica para la edicion */
    protected $deletedField  = ''; /*no se usara, es para la eliminacion fisica */

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function consulta_listaTerceros() {  //consulta en el mismo modelo para llenar la tabla de compra 
        $this->select('proveedores.*,tipo_documento,numero_documento,razon_social,direccion,tipo_tercero,d.resumen,v.valor as v_resumen');
        $this->join('terceros as t','id_tercero=t.id');
        $this->join('detalleparametros as d','d.id=t.tipo_documento');
        $this->join('v_detalleparametros as v','v.id=t.tipo_tercero');
        $this->where('t.activo', 1);
        $this->orderBy('t.razon_social');
        $datos = $this->findAll();  //nos trae la tabla completa 
        return $datos;
    }

    public function insertaProveedor($id_tercero, $cargo,$nombre_contacto, $rep_legal, $email_replegal,$id_usuario){
        $this->insert([
            'id_tercero' => $id_tercero,
            'cargo' => $cargo,
            'nombre_contacto' => $nombre_contacto,
            'rep_legal' => $rep_legal,
            'email_replegal' => $email_replegal,
            'sucursal' => 1,
            'usuario_crea' => $id_usuario
        ]);
        return $this->insertID(); //trae el id insertado en cliente
    }    

    public function buscarProveedor($id) {
        $this->select('proveedores.id_tercero');        
        $this->where('proveedores.id_tercero',$id);
        $datos = $this->first();
        return $datos;
    }    

    public function traerProveedor($id) {
        $this->select('proveedores.*,t.tipo_documento,t.numero_documento,t.razon_social,t.direccion,t.tipo_tercero,d.resumen,v.valor as v_resumen,dp.nombre as departamento,m.nombre as municipio');
        $this->join('terceros as t','id_tercero=t.id');
        $this->join('detalleparametros as d','d.id=t.tipo_documento');
        $this->join('v_detalleparametros as v','v.id=t.tipo_tercero');   
        $this->join('departamentos as dp','dp.id=departamento');
        $this->join('municipios as m','m.id=municipio'); 
        $this->where('proveedores.id_p',$id);
        $datos = $this->first();
        return $datos;
    }      
}
