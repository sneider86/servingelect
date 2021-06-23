<?php

namespace App\Models; //Reservamos el espacio de nombre de la ruta app\models
use CodeIgniter\Model;
class CotizacionesModel extends Model{
    protected $table      = 'cotizaciones'; /* nombre de la tabla modelada/*/
    protected $primaryKey = 'id_cotiza';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';  /* forma en que se retornan los datos */
    protected $useSoftDeletes = false; /* si hay eliminacion fisica de registro */

    protected $allowedFields = ['id_cliente','email_facturacion','nombre_contacto', 'rep_legal','email_replegal','activo','usuario_crea','sucursal']; /* relacion de campos de la tabla */

    protected $useTimestamps = true; /*tipo de tiempo a utilizar */
    protected $createdField  = 'fecha_alta'; /*fecha automatica para la creacion */
    protected $updatedField  = 'fecha_edit'; /*fecha automatica para la edicion */
    protected $deletedField  = ''; /*no se usara, es para la eliminacion fisica */

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function consulta_listaTercero() {  //consulta en el mismo modelo para llenar la tabla de compra 
        $this->select('clientes.*,tipo_documento,numero_documento,razon_social,direccion,tipo_tercero,d.resumen,v.valor as v_resumen');
        $this->join('terceros as t','id_tercero=t.id');
        $this->join('detalleparametros as d','d.id=t.tipo_documento');
        $this->join('v_detalleparametros as v','v.id=t.tipo_tercero');
        $this->where('t.activo', 1);
        $this->orderBy('t.razon_social');
        $datos = $this->findAll();  //nos trae la tabla completa 
        return $datos;
    }

    public function insertaCliente($id_tercero, $email_facturacion,$nombre_contacto, $rep_legal, $email_replegal,$id_usuario){

        $this->insert([
            'id_tercero' => $id_tercero,
            'email_facturacion' => $email_facturacion,
            'nombre_contacto' => $nombre_contacto,
            'rep_legal' => $rep_legal,
            'email_replegal' => $email_replegal,
            'sucursal' => 1,
            'usuario_crea' => $id_usuario
        ]);
        return $this->insertID(); //trae el id insertado en cliente
    }   
    
    public function buscarCliente($id) {
        $this->select('clientes.id_tercero');        
        $this->where('clientes.id_tercero',$id);
        $datos = $this->first();
        return $datos;
    }

    public function listarCotizaciones() {
        $this->select('cotizaciones.*,t.tipo_documento,t.numero_documento,t.razon_social,t.direccion,t.tipo_tercero,d.resumen,v.valor as v_resumen,dp.nombre as departamento,m.nombre as municipio');
        $this->join('clientes as c','id_cliente=c.id');
        $this->join('terceros as t','t.id=c.id');
        $this->join('detalleparametros as d','d.id=t.tipo_documento');
        $this->join('v_detalleparametros as v','v.id=t.tipo_tercero');   
        $this->join('departamentos as dp','dp.id=departamento');
        $this->join('municipios as m','m.id=municipio'); 
        $datos = $this->findAll();
        return $datos;
    }    
}
