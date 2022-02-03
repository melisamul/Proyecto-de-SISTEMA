<?php namespace Models_Entitys;

class OpcionDeRespuesta {
//Atributos
    private $nombre;
    private $descripcion;
    private $opciones = array(); //lista de objetos Opcion
//Metodos
    public function __construct(){	}
    public function agregarElemento($p_opcion){ $this->opciones[] = $p_opcion; }
    public function set($p_atributo, $p_valor) { $this->$p_atributo = $p_valor; }
    public function get($p_atributo){ return $this->$p_atributo; }

    }

?>