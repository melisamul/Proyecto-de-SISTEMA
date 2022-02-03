<?php namespace Models_Entitys;

class PreguntaEvaluada {
//Atributos
    private $codigo;
    private $pregunta;
    private $descripcion;
    private $opciones_evaluadas = array(); //lista de objetos Ponderacion
    private $orden_enBloque; //orden de aparicion en el bloque 
    
//Metodos
    public function __construct(){}
    public function set($p_atributo, $p_valor) { $this->$p_atributo = $p_valor; }
    public function get($p_atributo){ return $this->$p_atributo; }

    public function clonar(\Models_Entitys\Pregunta $pregunta) {
    
        $this->codigo = $pregunta->get('codigo');
        $this->pregunta = $pregunta->get('pregunta');
        $this->descripcion = $pregunta->get('descripcion');
        
        $ponderaciones = $pregunta->get('ponderaciones');
        $contador = 0;
        $arreglo = array();
        while (count($ponderaciones) > $contador){
            $opcionEv = new \Models_Entitys\OpcionEvaluada();
            $opcionEv->clonar($ponderaciones[$contador]);
            \array_push($arreglo, $opcionEv);
            $contador++;
        }
        $this->opciones_evaluadas = $arreglo;
            
    }
    
    public function retornar_valor_respuesta() {
        $ponderacion = 0;
        foreach ($this->opciones_evaluadas as $opcion_ev) {
            if ($opcion_ev->get('valor_elegido') == TRUE){
                $ponderacion = $opcion_ev->get('ponderacion_evaluada');
            }
        }
        return $ponderacion;
    }
    
    }

?>