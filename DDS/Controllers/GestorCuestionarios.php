<?php namespace Controllers;

class GestorCuestionarios {

    function __construct() { }
    
    function iniciarCuestionario() {
        $DAoCuestionario = new \Models_DAO\CuestionarioDAO();
        $clave_cuest = $_POST['clave'];
        $cuestionario = $DAoCuestionario->get_cuestionario($clave_cuest);
        if($cuestionario !== FALSE){
            $fecha = date('y-m-d');
            $cuestionario->set('ultimo_acceso', $fecha);
            $cantidad_accesos = $cuestionario->get('cantidad_accesos');
            $cantidad_nueva = $cantidad_accesos - 1;
            if($cantidad_nueva > 0){
                $cuestionario->set('cantidad_accesos', $cantidad_nueva);
            }
            $cuestionario->setEstado('EN PROCESO');
            $bandera = $DAoCuestionario->update($cuestionario);
            if($bandera === TRUE){ $serializar = $cuestionario->get('clave'); } 
            else { $serializar = $bandera; }
        } //ver el else por el error de 
        $resul= serialize($serializar); 
        $result=urlencode($resul);
        header("Location: //localhost/DDS/Cuestionario/cuestionario?seawalker=".$result);
    }
    
    public function esUltimoBloque($clave) {
        $DAoCuestionario = new \Models_DAO\CuestionarioDAO();
        $cuestionario = $DAoCuestionario->get_cuestionario($clave);
        $cantidad_bloques = $DAoCuestionario->cantidad_bloque_cuestionario($clave);
        $bloque = $cuestionario->get('ultimo_bloque_accedido');
        if($cantidad_bloques === $bloque->get('numero')){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function guardar_respuestas($p_arreglo, $p_clave) {
        $DAOcuest = new \Models_DAO\CuestionarioDAO();
        $bloque = $DAOcuest->retornarUltimoBloqueAccedido($p_clave, array());
        $resp = $DAOcuest->guardar_respuestas($p_arreglo, $bloque->get("numero"), $p_clave);
        return $resp;
    }
    
    public function retornar_bloque($clave) {
        $DAOcuest = new \Models_DAO\CuestionarioDAO();
        $cuestionario = $DAOcuest->get_cuestionario($clave);
        if($cuestionario != FALSE){
            return $cuestionario->get('ultimo_bloque_accedido');
        } else { 
            return FALSE; 
        }
    }
    public function cantidadPreguntasCuestionario($p_clave) {
        $cuestionarioDAO = new \Models_DAO\CuestionarioDAO();
        return $cuestionarioDAO->cantidadPreguntasEnCuestionario($p_clave);
    }
    public function recuperar_proximo_bloque($p_clave) {
        $cuestionarioDAO = new \Models_DAO\CuestionarioDAO();
        
        $cuest = $cuestionarioDAO->get_cuestionario($p_clave);
        $bloque = $cuest->get("ultimo_bloque_accedido");
        
        return $bloque;
    }
    
    public function comprobarEstado($p_clave) {
        $DAOcuest = new \Models_DAO\CuestionarioDAO();
        $estados = $DAOcuest->retornarEstados($p_clave);
        if($estados != FALSE){
            $cuest = new \Models_Entitys\Cuestionario(); $cuest->set('cambiosEstado', $estados);
            $estadoActual = $cuest->ultimoEstado();
            switch ($estadoActual->get('tipo')) {
                case 'ACTIVO': 
                    $bool = $this->evaluarTiempoActivo($p_clave);
                    if($bool == TRUE){
                        $ret = TRUE;
                    } else { $ret = 2; }
                    break;
                case 'EN PROCESO':
                    $ret = TRUE;
                    break;
                default:
                    $ret = 3;
                    break;
            }
        } else { $ret = FALSE; }
        return $ret;
    }
    
    public function evaluarTiempoActivo($p_clave) {
        $DAOcuest = new \Models_DAO\CuestionarioDAO();
        $DAOEstado = new \Models_DAO\EstadoDAO();
        $retorno = $DAOcuest->comprobarTiempoActivo($p_clave);
        if($retorno == TRUE){
            //$DAOcuest->setEstado('EN PROCESO', $p_clave);
            return TRUE;
        } elseif ($retorno == 3) {
            return $retorno; //es una falla de la base de datos        
        } else {
            $estado = array('clave' => $p_clave, 'estado' => 'SIN CONTESTAR');
            $DAOEstado->insert($estado);
            return FALSE;
        }
    }
    
    public function retornarCandidatosasociados($fecha_creacion,$codigo){
        $cuestionarioDAO= new \Models_DAO\CuestionarioDAO();
        
        $candidatos=$cuestionarioDAO->retornarcandidatos($fecha_creacion,$codigo);

        return $candidatos;
    }
    
    public function recuperaInstruciones() {
        $cuestionarioDAO= new \Models_DAO\CuestionarioDAO();
        $instruc=$cuestionarioDAO->instrucciones();
        return $instruc;
    }
    public function recuperarCuestionariosFinalizados($codigo){
        $cuestionarioDAO= new \Models_DAO\CuestionarioDAO();
        $fechascuestionarios=$cuestionarioDAO->consultarFechacuestionario($codigo);
        return $fechascuestionarios;
    }
    
    public function crear($listCandidatos_clave, $listaCaract) {
        
        $gestorEvaluacion = new \Controllers\GestorEvaluacion();
        
        $sys = new \Models_DAO\sysParamDAO();
        $inst = $sys->retornar('instruccion_cuestionario');
        $cand_acc = $sys->retornar('cantidad_accesos');
        
        $list_compEv = $gestorEvaluacion->crearEvaluacion($listaCaract);
        if(is_string($list_compEv[0]) == FALSE){
            $cuest = new \Models_Entitys\Cuestionario();
            
            $bloque = $this->armarBloques($list_compEv); 
            
            $hoy = \getdate(time());
            $fecha = $hoy['year']."-".$hoy['mon']."-".$hoy['mday']." ".$hoy['hours'].":".$hoy['minutes'].":".$hoy['seconds'];
            $fecha_estado = new \Models_Entitys\fechaEstado();
            $fecha_estado->set('fechayhora', $fecha);
            $fecha_estado->set('estado', $this->instancia_estado('ACTIVO'));

            $cuest->set('candidato', $listCandidatos_clave[0]);
            $cuest->set('clave', $listCandidatos_clave[1]);
            $cuest->set('fecha_de_creacion', $fecha);
            $cuest->set('cantidad_accesos', $cand_acc);
            $cuest->set('instrucciones', $inst);
            $cuest->set('cambiosEstado', $fecha_estado);
            $cuest->set('competenciasEvaluadas', $list_compEv);
            $cuest->set('ultimo_bloque_accedido', $bloque);
            
            return $cuest;
        } else {
            return $list_compEv;//FALSE
        }
    }
    
    private function instancia_estado($param) {
        $estado = new \Models_Entitys\Estado();
        $estado->set('tipo', $param);
        return $estado;
    }
    
    private function armarBloques($p_lisComEv) {
        
        $listaSelec = array();
        $listaBloques = array();
        foreach ($p_lisComEv as $key => $competencia) {
            $listFactorEv = $competencia->get('factores');
            foreach ($listFactorEv as $clave => $factor) {
                $listPreguntas = $factor->get('preguntas');
                $listaSelec = \array_merge($listaSelec, $listPreguntas);    
            }
        }
        
        $contador = 0;
        $nroBloque = 0;
        
        \shuffle($listaSelec);
        
        while(count($listaSelec) > $contador){ 
            if($nroBloque == ($contador/4)){
                $bloque = new \Models_Entitys\Bloque();
                \array_push($listaBloques, $bloque);
                $nroBloque++;
                $ordenPreguntas = 1;
                $bloque->set('numero', $nroBloque);
            } 
            $pregunta = $listaSelec[$contador];
            $pregunta->set('orden',$ordenPreguntas);
            $ordenPreguntas++;
            $bloque->agregar_pregunta($pregunta);
            $contador++;
        }
        
        return $listaBloques;
    }
    
    private function desordenar($lista) {
        $reordenada = array();
        \arsort($lista);
        $claves = \array_rand($lista, count($lista));
        $key = 0;
        while (count($lista) != $key) {
            $reordenada[$key] = $lista[$claves[$key]];
        }
        
        return $reordenada;
        
    }   

}


?>