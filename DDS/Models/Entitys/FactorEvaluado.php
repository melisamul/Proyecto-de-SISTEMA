<?php namespace Models_Entitys;

class FactorEvaluado {
//Atributos
    private $codigo;
    private $nombre;
    private $descripcion;
    private $puntaje;
    private $preguntas = array(); //lista de objetos Pregunta
//Metodos
    public function __construct(){}
    public function setPuntaje($p_puntaje){ $this->puntaje = $p_puntaje; }
    public function agregarPregunta($p_pregunta){ $this->preguntas[] = $p_pregunta;	}
    public function set($p_atributo, $p_valor) { $this->$p_atributo = $p_valor; }
    public function get($p_atributo){ return $this->$p_atributo; }
    
    public function clonar(\Models_Entitys\Factor $factor) {
    
        $this->codigo = $factor->get('codigo');
        $this->descripcion = $factor->get('descripcion');
        $this->nombre = $factor->get('nombre');
        
        $listPreguntas_ev = array();
        $contador = 0;
        
        $preguntas = $factor->get('preguntas');
        $lista = $this->seleccionarPreguntas($preguntas);
        
        while (count($lista) > $contador){ 
            
            $preg_ev = new \Models_Entitys\PreguntaEvaluada();
            $preg_ev->clonar($lista[$contador]);
            \array_push($listPreguntas_ev, $preg_ev);
            $contador++;
        }      
        
        $this->preguntas = $listPreguntas_ev;
    }
    
    private function seleccionarPreguntas($p_preguntas) { 
        
        $retorno = array();
        $res = shuffle($p_preguntas);
        if($res == 1){
            $claves_aleatorias = array_rand($p_preguntas, 2);
            \array_push($retorno, $p_preguntas[$claves_aleatorias[0]], $p_preguntas[$claves_aleatorias[1]]);
        }
        
        return $retorno;
    }
    
    public function calcularPuntaje() {
        $sumatoria = 0;
        foreach ($this->preguntas as $pregunta_ev) {
            $ponderacion_respuesta = $pregunta_ev->retornar_valor_respuesta();
            $sumatoria = $sumatoria + $ponderacion_respuesta;
        }
        $this->puntaje = $sumatoria / 2;
        
        return $this->puntaje;
    }
    
    }
		
?>