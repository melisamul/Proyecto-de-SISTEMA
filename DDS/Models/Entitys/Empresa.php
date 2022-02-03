<?php namespace Models_Entitys;
	
class Empresa {
//Atributos
    private $nombre;
    private $direccion;
    private $contacto;
    private $telefono;
//Metodos
    public function __construct(){}
    public function get($p_atributo){ return $this->$p_atributo; }
    public function set($p_atributo, $p_valor) { $this->$p_atributo = $p_valor; }

    }

?>