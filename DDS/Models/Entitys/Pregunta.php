<?php namespace Models_Entitys;

class Pregunta {
//Atributos
    private $codigo;
    private $pregunta;
    private $descripcion;
    private $ponderaciones = array(); //lista de objetos Ponderacion
    private $opciondeRespuesta = NULL;
    
//Metodos
    public function __construct(){}
    public function agregarPonderacion($p_ponderacion){ $this->ponderaciones[] = $p_ponderacion; }
    public function set($p_atributo, $p_valor) { $this->$p_atributo = $p_valor; }
    public function get($p_atributo){ return $this->$p_atributo; }
  
    public function mapear(){
        if(empty($this->ponderaciones) == TRUE){
            $preguntaDAO = new \Models_DAO\PreguntaDAO();
            $retorno = $preguntaDAO->listarPonderaciones($this->codigo);
            if($retorno != FALSE){
                $this->ponderaciones = $retorno;
            }
        }
        if($this->opciondeRespuesta == NULL){
            $opcionesDAO = new \Models_DAO\OpcionesDAO();
            $retorno = $opcionesDAO->unaOpcion_respuesta($this->codigo);
            if($retorno != FALSE){
                $this->opciondeRespuesta = $retorno;
            }
        }
    }
    
    }

?>