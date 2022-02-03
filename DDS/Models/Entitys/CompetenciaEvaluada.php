<?php namespace Models_Entitys;

class CompetenciaEvaluada {
//Atributos
    private $codigo;
    private $nombre;
    private $descripcion;
    private $ponderacion;
    private $puntaje;
    private $factores = array(); //lista de objetos Factor
//Metodos
    public function __construct(){}
    public function set($p_atributo, $p_valor) { $this->$p_atributo = $p_valor; }
    public function agregarFactor($p_factor){ $this->factores[] = $p_factor; }
    public function get($p_atributo){ return $this->$p_atributo; }
    
    public function listarPreguntas() {
        $retorno = array();
        foreach ($this->factores as $res) {
            $lista = $res->get('preguntas');
            $retorno = \array_merge($retorno, $lista);
        }
        return $retorno;
     
    }
    
    public function clonar(\Models_Entitys\Competencia $competencia, $ponderacion) {
    
        $this->codigo = $competencia->get('codigo');
        $this->nombre = $competencia->get('nombre');
        $this->descripcion = $competencia->get('descripcion');
        $this->ponderacion = $ponderacion;
        
        $listFactores_ev = array();
        $listFactores = $competencia->get('factores');
        $contador = 0;
        while(count($listFactores) > $contador){ 
            $fact = $listFactores[$contador];
            if(count($fact->get('preguntas')) >= 2){
                $factor_ev = new \Models_Entitys\FactorEvaluado();
                $factor_ev->clonar($fact);
            
                \array_push($listFactores_ev, $factor_ev);
            }
            $contador++;
        }
        
        $this->factores = $listFactores_ev;
        
    }
    
    
    public function calcularPuntaje() {
        $sumatoria = 0;
        foreach ($this->factores as $factor_ev) {
            $puntaje_factor = $factor_ev->calcularPuntaje();
            $sumatoria = $sumatoria + $puntaje_factor;
        }
        
        $this->puntaje = ($sumatoria / (count($this->factores)));
        return TRUE;
    }

    }
		
?>