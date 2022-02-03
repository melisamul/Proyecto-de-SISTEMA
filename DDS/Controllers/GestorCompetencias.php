<?php namespace Controllers;
    
class GestorCompetencias {

    public function __construct() { }
        
    public function recuperarCompetencias(){
        $DAOcomp = new \Models_DAO\CompetenciaDAO();
        $respuesta = $DAOcomp->listAllDisponibles();
        $lista = array();

        foreach ($respuesta as $key => $value) {
            $aux = array();
            $nombre = $value->get("nombre");
            $codigo = $value->get("codigo");
            \array_push($aux, $codigo, $nombre);
            $lista[] = $aux;
        } 
        return $lista;
    }
    
    public function recuperarCompentencias2($p_compSelect, $p_codigo_puesto) {
        $gestorPuesto = new \Controllers\GestorPuestos();
        $DAOcomp = new \Models_DAO\CompetenciaDAO();
        $puesto = $gestorPuesto->recuperaUnPuesto($p_codigo_puesto);
        $disponibles = $DAOcomp->listAllDisponibles();
        $lista = array();
        foreach ($disponibles as $competenciaD) {
            $bandera = $this->estaSeleccionado($competenciaD->get('codigo'), $p_compSelect);
            if($bandera == FALSE){
                $arreglo = array(); \array_push($arreglo, $competenciaD->get('codigo'), $competenciaD->get('nombre'));
                $lista[] = $arreglo;
            }
        }
        $arregloComp = $puesto->retornarCompentenciasNoSeleccionadas($p_compSelect);
        foreach ($arregloComp as $competencia) {
            $arreglo = array(); \array_push($arreglo, $competencia->get('codigo'), $competencia->get('nombre'));
            $lista[] = $arreglo;
        }
        return $lista;
    }
    
    private function estaSeleccionado($p_codigo, $p_lista) {
        foreach ($p_lista as $key => $valor) {
            if(($valor == $p_codigo) === TRUE){
                return \TRUE;
            }
        }
        return \FALSE;
    }

    public function recuperarNombre($p_codigo){
        $DAOcomp = new \Models_DAO\CompetenciaDAO();
        $respuesta = $DAOcomp->get_atributo("nombre", $p_codigo);
        return $respuesta;
    }
    
    }
?>