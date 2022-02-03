<?php namespace Models_Entitys;

class Consultor {
//Atributos
    private $idConsultor;
    private $nombre;
    private $apellido;
    private $puestoConsultor;
    private $user;
//Metodos
    public function __construct(){}
    public function get($p_atributo){ return $this->$p_atributo; }
    public function set($p_atributo, $p_valor) { $this->$p_atributo = $p_valor; }

    }

?>