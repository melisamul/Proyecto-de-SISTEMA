<?php namespace Models_Entitys;

class Bloque {
    //Atrubutos
    private $numero;
    private $preguntas = array();
    private $idcuestionario;
    //Metodos
    public function __construct(){}
    public function agregar_pregunta($p_pregunta) { \array_push($this->preguntas, $p_pregunta); }
    public function set($p_atributo, $p_valor) { $this->$p_atributo = $p_valor; }
    public function get($p_atributo){ return $this->$p_atributo; }
    		
    
    }
	
?>