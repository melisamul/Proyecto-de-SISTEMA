<?php namespace Models_Entitys;

class OpcionEvaluada {
//Atributos
    private $nombre;
    private $orden_visualizacion;
    private $valor_elegido; //se setea cuando el candidato complete el bloque con algun valor elegido
    private $ponderacion_evaluada;
//Metodos
    public function __construct(){}			
    public function set($p_atributo, $p_valor) { $this->$p_atributo = $p_valor; }
    public function get($p_atributo){ return $this->$p_atributo; }
    
    public function clonar(\Models_Entitys\Ponderacion $ponderacion) {
        
        $opcion = $ponderacion->get('opcion');
        
        $this->nombre = $opcion->get('nombre');
        $this->ponderacion_evaluada = $ponderacion->get('ponderacion');
        $this->orden_visualizacion = $opcion->get('orden_visualizacion');
        
    }

    }

?>