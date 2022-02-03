<?php namespace Models_Entitys;

class Opcion {
//Atributos
    private $nombre;
    private $orden_visualizacion;
//Metodos
    public function __construct(){}
    public function set($p_atributo, $p_valor) { $this->$p_atributo = $p_valor; }
    public function get($p_atributo){ return $this->$p_atributo; }

    }

?>