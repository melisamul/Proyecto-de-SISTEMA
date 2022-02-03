<?php namespace Models_Entitys;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class AuditorDeSucesos {
    public $fecha; 
    public $consultor;
    public $tipomovimiento;
    public $entidad;
    
    public function __construct() {
        $hoy = \getdate(time());
        $this->fecha = $hoy['year']."-".$hoy['mon']."-".$hoy['mday']." ".$hoy['hours'].":".$hoy['minutes'].":".$hoy['seconds'];
    }
    public function set($p_atributo, $p_valor) { $this->$p_atributo = $p_valor; }
    public function get($p_atributo){ return $this->$p_atributo; }
    
}


?>
