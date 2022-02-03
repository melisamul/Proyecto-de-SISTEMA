<?php namespace Controllers;

class GestorReportes{
    
    public function __construct(){ }

    public function traerEvaluaciones($p_codigo){
        $gestorCuestionario = new \Controllers\GestorCuestionarios();
        $listaeva= array();
        $listaEvaluaciones = $gestorCuestionario->recuperarCuestionariosFinalizados($p_codigo);//devolvemos los cuestionarios asociados al puesto cuyo campo fecha_creacion sera la identificacion en la vista para la evaluacion
        if($listaEvaluaciones->num_rows != 0){
            while($row = $listaEvaluaciones->fetch_array()){
                \array_push($listaeva, $row[0]);
            }
            //añado el puesto a la lista de evaluaciones
            \array_push($listaeva, $p_codigo);
            
            return $listaeva; // lista con fechas de evaluacion
        } else {
            return FALSE;
        }
    }
    
    public function emitirOrdendemerito($listafechas, $codigo){
        $listcandidatos = array();
        foreach ($listafechas as $fecha) {
            $lista = array();
            $candidatos = $this->listarcandidatos($fecha, $codigo);
            \array_push($lista, $fecha, $candidatos);
            \array_push($listcandidatos, $lista);
        }
        //echo '<br> candidatos ';print_r($listcandidatos);echo '<br>';
        $listafiltrada = $this->filtarListacandidatos($listcandidatos,$codigo);//HASTA ACA TENEMOS UNA LISTA DE CANDIDATOS ASOCIADOS A LAS EVALUACIONES
        
        return $listafiltrada;
        
    }
    private function filtarListacandidatos($listcandidatos,$codigopuesto){
        $gestorEvaluacion = new \Controllers\GestorEvaluacion();
        
        $listadelistas=$gestorEvaluacion->aplicarFiltros($listcandidatos,$codigopuesto);
    
        return $listadelistas;
    }
    
    private function listarcandidatos($fecha_creacion,$codigo){
        $gestorcuestionario= new \Controllers\GestorCuestionarios();
        
        $candidato=$gestorcuestionario->retornarCandidatosasociados($fecha_creacion,$codigo);
         
        return $candidato;
    }
    
} 
?>