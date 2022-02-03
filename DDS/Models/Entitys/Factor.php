<?php namespace Models_Entitys;

class Factor {
//Atributos
    private $codigo;
    private $nombre;
    private $descripcion;
    private $nro_de_orden;
    private $preguntas = array(); //lista de objetos Pregunta
//Metodos
    public function __construct(){}
    public function agregarPregunta($p_pregunta){ $this->preguntas[] = $p_pregunta;	}
    public function set($p_atributo, $p_valor) { $this->$p_atributo = $p_valor; }
    public function get($p_atributo){ return $this->$p_atributo; }
    
    public function mapear(){
        if(empty($this->preguntas) == TRUE){
            $preguntaDAO = new \Models_DAO\PreguntaDAO;
            $retorno = $preguntaDAO->listar($this->codigo);
            if($retorno != FALSE){
                $this->preguntas = $retorno;
            }
        }
    }

    }
		
?>