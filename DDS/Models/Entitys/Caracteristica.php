<?php namespace Models_Entitys;

class Caracteristica{
//Atributos
    private $ponderacion;
    private $competencia; 
//Metodos
    public function __construct(){ }
    public function get($p_atributo){ return $this->$p_atributo; }
    public function set($p_atributo, $p_valor) { $this->$p_atributo = $p_valor; }
    
    public function estaIncluida($p_compSelect) {
        
        foreach ($p_compSelect as $arreglo) {
            if(is_array($arreglo) == TRUE){
                foreach ($arreglo as $key => $valor) {
                    //echo '<script type="text/javascript">alert("codigo '.$this->competencia->get('codigo').' valor array '.$valor.'")</script>';
                    if(($this->competencia->get('codigo') == $valor) == TRUE){
                        return TRUE;
                    }
                }
            } else {
                //echo '<script type="text/javascript">alert("codigo '.$this->competencia->get('codigo').' valor arreglo '.$arreglo.'")</script>';
                if(($this->competencia->get('codigo') == $arreglo) == TRUE){
                    return TRUE;
                }
            }
        }
        return FALSE;
    }

    }
    
?>