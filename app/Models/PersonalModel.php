<?php

namespace App\Models; //Reservamos el espacio de nombre de la ruta app\models
use CodeIgniter\Model;
class PersonalModel extends Model{
    protected $table      = 'personal'; /* nombre de la tabla modelada/*/
    protected $primaryKey = 'id_persona';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';  /* forma en que se retornan los datos */
    protected $useSoftDeletes = false; /* si hay eliminacion fisica de registro */

    protected $allowedFields = ['id_tercero','tipo_persona', 'cargo','estado_civil','genero','tipo_sangre','clase_libreta','numero_libreta','camisa','pantalon','zapatos','guantes','cuenta_pago','tipo_cuenta','banco_pago','nombres_contacto','direccion_contacto','fijo_contacto','movil_contacto','parentesco','curso_altura','fechav_curso','sucursal','activo','usuario_crea','sucursal']; /* relacion de campos de la tabla */

    protected $useTimestamps = true; /*tipo de tiempo a utilizar */
    protected $createdField  = 'fecha_alta'; /*fecha automatica para la creacion */
    protected $updatedField  = 'fecha_edit'; /*fecha automatica para la edicion */
    protected $deletedField  = ''; /*no se usara, es para la eliminacion fisica */

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function consulta_listaTerceros() {  //consulta en el mismo modelo para llenar la tabla de compra 
        $this->select('personal.*,tipo_documento,numero_documento,razon_social,direccion,tipo_tercero,d.resumen,v.valor as v_resumen, c.nombre as nombre_cargo');
        $this->join('terceros as t','id_tercero=t.id');
        $this->join('detalleparametros as d','d.id=t.tipo_documento');
        $this->join('v_detalleparametros as v','v.id=personal.tipo_persona');
        $this->join('cargos as c','c.id_cargo=personal.cargo');
        $this->where('t.activo', 1);
        $this->orderBy('t.razon_social');
        $datos = $this->findAll();  //nos trae la tabla completa 
        return $datos;
    }

    public function insertaPersonal($id_tercero, $cargo,$nombre_contacto, $rep_legal, $email_replegal,$id_usuario){

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

    public function buscarPersonal($id) {
        $this->select('personal.id_tercero');        
        $this->where('personal.id_tercero',$id);
        $datos = $this->first();
        return $datos;
    }

    public function traerPersona($id) {
        $this->select('personal.*,t.tipo_documento,t.numero_documento,t.razon_social,t.direccion,t.tipo_tercero,d.resumen,v.valor as v_resumen,dp.nombre as departamento,m.nombre as municipio');
        $this->join('terceros as t','id_tercero=t.id');
        $this->join('detalleparametros as d','d.id=t.tipo_documento');
        $this->join('v_detalleparametros as v','v.id=t.tipo_tercero');   
        $this->join('departamentos as dp','dp.id=departamento');
        $this->join('municipios as m','m.id=municipio'); 
        $this->where('personal.id_persona',$id);
        $datos = $this->first();
        return $datos;
    }      
}
