<?php namespace Models_Entitys;

class Candidato{
//Atributos
    private $nrocandidato;
    private $nombre;
    private $apellido;
    private $tipodocumento;
    private $nrodocumento;
    private $fecha_de_nacimiento;
    private $genero;
    private $nacionalidad;
    private $email;
    private $escolaridad;
//Metodos
    public function __construct() {}
    public function set($p_atributo, $p_valor) { $this->$p_atributo = $p_valor; }
    public function get($p_atributo){ return $this->$p_atributo; }

    }
    
?>