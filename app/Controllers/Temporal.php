<?php

namespace App\Controllers;

use App\Controllers\baseController; /*la plantilla del controlador general de codeigniter */
use App\Models\TemporalModel;

class Temporal extends BaseController
{
    /*interactua el controlador con el modelo */
    protected $temporal;
    protected $reglas;

    public function __construct()
    {
        $this->temporal = new TemporalModel();
    }

    public function insertar($indicativo,$valor,$extension,$orden,$tipo,$fecha,$clave)
    {
        /*
        $indicativo = $_POST['indicativo']; 
        $valor = $_POST['valor']; 
        $extension = $_POST['extension'];
        $orden = $_POST['orden'];
        $tipo = $_POST['tipo'];
        $fecha = $_POST['fecha'];
        */
            $this->temporal->save([                
                'orden' => $orden,
                'valor' => $valor,
                'extension' => $extension,
                'indicativo' => $indicativo,
                'tipo' => $tipo,
                'fecha' => $fecha,
                'clave' => $clave
            ]);
        //} else {
        //    $error = 'Teléfono ya Existe en la Relación';
        //}
        //$res['datos'] = $this->cargaTelefono($valor, $tipo);  //lo cargamos para que se ejecuta
        //$res['error'] = $error;
        //echo json_encode($res);
    }
    
    public function eliminar($id,$campo)
    {
        $this->temporal->eliminarRegistro($id,$campo);
    }

    public function todosTemporal($activo) {  //consulta en el mismo modelo
        $this->select('*');
        $this->where('activo',$activo);
        $datos = $this->findAll();  //nos trae el registro encontrado 
        return $datos;
    }    
}
