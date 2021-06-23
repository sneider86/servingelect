<?php

namespace App\Models; //Reservamos el espacio de nombre de la ruta app\models
use CodeIgniter\Model;
class TercerosModel extends Model{
    protected $table      = 'terceros'; /* nombre de la tabla modelada/*/
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';  /* forma en que se retornan los datos */
    protected $useSoftDeletes = false; /* si hay eliminacion fisica de registro */

    protected $allowedFields = ['tipo_documento','numero_documento','dv','razon_social', 'tipo_tercero','direccion','pais','departamento','municipio','activo','sucursal','usuario_crea','p_nombre','s_nombre','p_apellido','s_apellido','responsabilidad','regimen']; /* relacion de campos de la tabla */

    protected $useTimestamps = true; /*tipo de tiempo a utilizar */
    protected $createdField  = 'fecha_alta'; /*fecha automatica para la creacion */
    protected $updatedField  = 'fecha_edit'; /*fecha automatica para la edicion */
    protected $deletedField  = ''; /*no se usara, es para la eliminacion fisica */

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function insertaTercero($tipo_documento, $numero_documento,$dv ,$p_nombre, $s_nombre, $p_apellido, $s_apellido ,$razon_social, $tipo_tercero, $direccion, $pais, $departamento, $municipio ,$responsabilidad,$regimen, $id_usuario){

        $this->insert([
            'tipo_documento' => $tipo_documento,
            'numero_documento' => $numero_documento,
            'dv' => $dv,
            'p_nombre' => $p_nombre,
            's_nombre' => $s_nombre,
            'p_apellido' => $p_apellido,
            's_apellido' => $s_apellido,
            'razon_social' => $razon_social,
            'tipo_tercero' => $tipo_tercero,
            'direccion' => $direccion,
            'pais' => $pais,
            'departamento' => $departamento,
            'municipio' => $municipio,
            'sucursal' => 1,
            'responsabilidad' => $responsabilidad,
            'regimen' => $regimen,
            'usuario_crea' => $id_usuario
        ]);
        return $this->insertID(); //trae el id insertado en la compra
    }

    public function listaTercero($activo) { //
        $this->select('terceros.*,d.resumen,v.valor as v_resumen');        
        $this->join('detalleparametros as d','d.id=tipo_documento');
        $this->join('v_detalleparametros as v','v.id=tipo_tercero');
        $this->where('terceros.activo', $activo);
        $this->orderBy('razon_social');
        $datos = $this->findAll();  //nos trae la tabla completa 
        return $datos;
    }

    public function buscaTerceros($campo,$valor) {
        $this->select('terceros.*,d.resumen,v.valor as v_resumen,dp.nombre as nombre_departamento,m.nombre as nombre_municipio');        
        $this->join('detalleparametros as d','d.id=tipo_documento');
        $this->join('v_detalleparametros as v','v.id=tipo_tercero');
        $this->join('departamentos as dp','dp.id=departamento');
        $this->join('municipios as m','m.id=municipio');
        //$this->where($where);
        $this->like($campo, $valor);
        $datos = $this->findAll();
        return $datos;
    }

    public function mostrarTerceros($id) {
        $this->select('terceros.*,d.resumen,v.valor as v_resumen');        
        $this->join('detalleparametros as d','d.id=tipo_documento');
        $this->join('v_detalleparametros as v','v.id=tipo_tercero');
        $this->where('terceros.id',$id);
        $datos = $this->first();
        return $datos;
    }

    public function buscarTerceros($numero,$tipo) {
        $this->select('terceros.*');        
        $this->where('terceros.numero_documento',$numero);
        $this->where('terceros.tipo_documento',$tipo);
        $datos = $this->first();
        return $datos;
    }

}
