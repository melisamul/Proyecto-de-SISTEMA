<?php namespace Models_Entitys;

class fechaEstado {
//Atributos
    private $fechayhora;
    private $estado;
//Metodos
    public function __construct(){}
    public function set($p_atributo, $p_valor) { $this->$p_atributo = $p_valor; }
    public function get($p_atributo){ return $this->$p_atributo; }
    public function crearEstado($estado) {
        $estado_nuevo = new \Models_Entitys\Estado();
        $estado_nuevo->set('estado', $estado);
        $this->estado = $estado_nuevo;
        $fechahora= getdate();
        $hora = $fechahora['hours'] - 3;
        $fechahoraactual= ''.$fechahora['year'].'-'.$fechahora['mon'].'-'.$fechahora['mday'].' '.$hora.':'.$fechahora['minutes'].'';
        $this->fechayhora = $fechahoraactual;
    }
    
    }
    
?>