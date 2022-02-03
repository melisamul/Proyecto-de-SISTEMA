<?php namespace Controllers;

 class GestorEvaluacion {

    public function __construct() { }
    
    function transformarArray($cadena_array){
        $retorno = array();
        if($cadena_array !== ''){
            $par_arreglo = explode(",", $cadena_array);
            $j = 1;
            for($i = 0; $i < count($par_arreglo); $i++){
                $nuevoarray = array();
                \array_push($nuevoarray, $par_arreglo[$i], $par_arreglo[$j]);
                \array_push($retorno, $nuevoarray);
                $j = $j+2;
                $i++;
            }
        }
        return $retorno;
        
    }
    
    public function siguientebloque(){
        $gestorCuest = new \Controllers\GestorCuestionarios();
        $datos = $_POST; $ret = TRUE;
        $arreglo = $this->transformarArray($datos['arreglo']);
        if(empty($arreglo) == FALSE){
            $ret = $gestorCuest->guardar_respuestas($arreglo, $datos['clave']);
        } 
        if($ret == TRUE){
            if($datos['boton'] === 'Siguiente'){
                $serializar = $datos['clave'];
            } 
            elseif($datos['boton'] === 'Finalizar') {
                $cuestionarioDAO = new \Models_DAO\CuestionarioDAO();
                $evaluarDAO = new \Models_DAO\EvaluacionDAO();
                $cuestionario = $cuestionarioDAO->get_cuestionario($datos['clave']);
                $retorno = $cuestionario->calcularPuntaje();
                if($retorno == TRUE){
                    $evaluarDAO->setearPuntajes($cuestionario);
                    $cuestionario->setEstado('COMPLETO');
                    $serializar =  $cuestionarioDAO->update($cuestionario);
                    $resul = serialize($serializar); 
                    $result=urlencode($resul);
                    header("Location: //localhost/DDS/Cuestionario/cuestionarioFinal?seawalker=".$result);
                    return TRUE;
                }
            }
        } else {
            $serializar = FALSE;  
        } 
        $resul = serialize($serializar); 
        $result=urlencode($resul);
        header("Location: //localhost/DDS/Cuestionario/cuestionario?seawalker=".$result);
        return TRUE;
    }
    
    public function crearEvaluacion($listCaracteristicas){
        
        $ret = $this->esEvaluable($listCaracteristicas);
        if(is_array($ret) == FALSE) {
            $listCompEv = array();
            $contador = 0;
            while (count($listCaracteristicas) > $contador){ 
                $caract = $listCaracteristicas[$contador];
                $comp = $caract->get('competencia');
                $ponderacion = $caract->get('ponderacion');
                $comp_ev = new \Models_Entitys\CompetenciaEvaluada();
                $comp_ev->clonar($comp, $ponderacion);
            
                \array_push($listCompEv, $comp_ev);
            
                $contador++;
            }
            
            return $listCompEv;
        }
        else{ 
            return $ret;//FALSE
        }
    }
    
    private function esEvaluable($lista) {
        $contador = 0; $bandera = 1;
        $ret = array();
        while (\count($lista) > $contador){ 
            $caract = $lista[$contador];
            $comp = $caract->get('competencia');
            
            $bool = $comp->competencia_esEvaluable();
            if($bool == FALSE){
                $bandera = 0;
                \array_push($ret, $comp->get('nombre'));
            }
            $contador++;
        }
        
        if($bandera == 0){ 
            return $ret;
        } else {
            return TRUE;
        }
    }

    public function evaluarCandidatos($p_lista, $p_codigoPuesto) {
        
        $gestorPuestos = new \Controllers\GestorPuestos();
        $gestorUsuario = new \Controllers\GestorUsuarios();
        $gestorCuestionario = new \Controllers\GestorCuestionarios();
        $evaluacionDAO = new \Models_DAO\EvaluacionDAO();
        
        $puesto = $gestorPuestos->recuperaUnPuesto($p_codigoPuesto);
        $listaCand_conClaves = array();
        foreach ($p_lista as $row) {
            $candidato = $gestorUsuario->recuperaUnCandidato($row['nrocandidato']);
            $conClave = array($candidato, $row['clave']);
            \array_push($listaCand_conClaves, $conClave); 
        }
        
        $listCaracteristicas = $puesto->get('caracteristicas');
        $conteo = 0;
        $listaCuestionarios = array();
        while(count($listaCand_conClaves) > $conteo){ 
            $cuestionario = $gestorCuestionario->crear($listaCand_conClaves[$conteo], $listCaracteristicas);
            if(is_array($cuestionario) == FALSE){
                \array_push($listaCuestionarios, $cuestionario);
                $conteo++;
            } else {
                return $cuestionario;
            }
        }
        $logrado = $evaluacionDAO->sets($listaCuestionarios, $p_codigoPuesto);
        if($logrado === TRUE){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function aplicarFiltros($listcandidatos,$codigo){
        $cuestionarioDAO= new \Models_DAO\CuestionarioDAO();
        $listaponderacionAlcanzada=array(); $listaponderacionNoAlcanzada=array();
        $listaActivos=array(); $listaEnProcesos=array();
        $listaIncompletos=array(); 
        
        foreach ($listcandidatos as $arreglo){
            foreach ($arreglo[1] as $candidato) {
                $nrocandidato = $candidato->get('nrocandidato');
                $cuestionario = $cuestionarioDAO->retornarCuestionario($nrocandidato,$codigo,$arreglo[0]);//trae un cuestionario
                if($cuestionario != FALSE){
                    $nombre = ''.$candidato->get('apellido').', '.$candidato->get('nombre');
                    if($cuestionario->consultaEstaCompleto() == TRUE){
                        $puntaje = $cuestionario->consultaPonderacionAlcanzada();
                        $fecha_inicio = $cuestionario->consultarFechaInicio();
                        $fecha_fin = $cuestionario->consultarFechaFin();
                        $calculo = ($puntaje['puntajes']*100)/$puntaje['ponderaciones'];                        
                        if($calculo < 70){
                            \array_push($listaponderacionNoAlcanzada, array($nombre, $candidato->get('tipodocumento'),$candidato->get('nrodocumento'), $puntaje['puntajes'], $fecha_inicio, $fecha_fin, $cuestionario->get('cantidad_accesos')));  
                        }
                        else{
                             \array_push($listaponderacionAlcanzada, array($nombre, $candidato->get('tipodocumento'),$candidato->get('nrodocumento'), $puntaje['puntajes'], $fecha_inicio, $fecha_fin, $cuestionario->get('cantidad_accesos')));
                        }
                    } else {
                        $estado = $cuestionario->consultarEstadoPreFinalizado();
                        switch($estado->get('tipo')){
                            case'ACTIVO':
                                \array_push($listaActivos, array($nombre, $candidato->get('tipodocumento'),$candidato->get('nrodocumento'), $cuestionario->get('fecha_de_creacion'), $cuestionario->get('ultimo_acceso'), $cuestionario->get('cantidad_accesos')));  
                                break;
                            case'EN PROCESO':
                                \array_push($listaEnProcesos, array($nombre, $candidato->get('tipodocumento'),$candidato->get('nrodocumento'), $cuestionario->get('fecha_de_creacion'), $cuestionario->get('ultimo_acceso'), $cuestionario->get('cantidad_accesos')));
                                break;
                            case'INCOMPLETO':
                                \array_push($listaIncompletos, array($nombre, $candidato->get('tipodocumento'),$candidato->get('nrodocumento'), $cuestionario->get('fecha_de_creacion'), $cuestionario->get('ultimo_acceso'), $cuestionario->get('cantidad_accesos')));
                                break; 
                            default: 
                                echo "segmentation fault";
                                break;                    
                        }
                    }
                } else { return  FALSE; }
            }
        }
        
        $listaX = array('activos'=> $listaActivos,'enProcesos'=> $listaEnProcesos,'incompletos'=> $listaIncompletos);
        $listadelista=array('aprobados' => $listaponderacionAlcanzada, 'desaprobados' => $listaponderacionNoAlcanzada, 'otros' => $listaX,);
        return $listadelista;    
    }
}
?>