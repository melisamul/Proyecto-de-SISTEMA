<?php namespace Models_Entitys;

class Competencia {
//Atributos
    private $codigo;
    private $nombre;
    private $descripcion;
    private $factores = array(); //lista de objetos Factor
//Metodos
    public function __construct(){	}
    public function agregarFactor($p_factor){ $this->factores[] = $p_factor; }
    public function set($p_atributo, $p_valor) { $this->$p_atributo = $p_valor; }
    public function get($p_atributo){ return $this->$p_atributo; }
    
    public function competencia_esEvaluable() {
        $contador = 0;
        $evaluables = 0;
        $cantidad_factores = count($this->factores);
        while ($cantidad_factores > $contador) {
            $fact = $this->factores[$contador];
         
            if(\count($fact->get('preguntas')) >= 2){ 
                $evaluables++;
            } 
            $contador++;
        }
        if($evaluables != 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function mapear(){
        if(empty($this->factores) == TRUE){
            $factoresDAO = new \Models_DAO\FactorDAO;
            $retorno = $factoresDAO->listar($this->codigo);
            if($retorno != FALSE){
                $this->factores = $retorno;
            }
        }
    }

}
		
?>