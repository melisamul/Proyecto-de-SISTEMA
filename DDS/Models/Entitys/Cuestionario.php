<?php namespace Models_Entitys;

class Cuestionario {
//Atributos
    private $clave;
    private $nroCuestionario;
    private $fecha_de_creacion;
    private $instrucciones;
    private $cantidad_accesos;
    private $ultimo_acceso;
    private $candidato;
    private $cambiosEstado = array(); //lista de objetos fechasEstados
    private $competenciasEvaluadas = array();
    private $ultimo_bloque_accedido = "NULL";
    

//Metodos
    public function __construct(){}
    public function set($p_atributo, $p_valor) { $this->$p_atributo = $p_valor; }
    public function get($p_atributo){ return $this->$p_atributo; }
    
    public function ultimoEstado(){
        $indice = 1;
        $fechaMax = $this->cambiosEstado[0]->get('fechayhora');
        $estadoRetorno = $this->cambiosEstado[0]->get('estado');
        while (count($this->cambiosEstado) != $indice) {
            $fechaEstado = $this->cambiosEstado[$indice]->get('fechayhora');
            if($fechaMax < $fechaEstado){
                $fechaMax = $fechaEstado;
                $estadoRetorno = $this->cambiosEstado[$indice]->get('estado');
            }
            $indice++;
        }
        return $estadoRetorno;
    }
    
    public function ultimoEstadoyFecha(){
        $indice = 1;
        $retorno = array();
        $fechaMax = $this->cambiosEstado[0]->get('fechayhora');
        $estado = $this->cambiosEstado[0]->get('estado');
        while (count($this->cambiosEstado) != $indice) {
            $fechaEstado = $this->cambiosEstado[$indice]->get('fechayhora');
            if($fechaMax < $fechaEstado){
                $fechaMax = $fechaEstado;
                $estado = $this->cambiosEstado[$indice]->get('estado');
            }
            $indice++;
        }
        \array_push($retorno, $estado, $fechaMax);
        return $retorno;
    }
    
    public function setEstado($estado) {
        $fechaEstado = new \Models_Entitys\fechaEstado();
        $fechaEstado->crearEstado($estado);
        \array_push($this->cambiosEstado, $fechaEstado);
    }


    public function mapear() {
        if(empty($this->cambiosEstado) == TRUE){
            $DAOcuest = new \Models_DAO\CuestionarioDAO();
            $this->cambiosEstado = $DAOcuest->retornarEstados($this->clave);
        }
        if(empty($this->competenciasEvaluadas) == TRUE){
            $DAOcompEv = new \Models_DAO\CompetenciaEvaluadaDAO();
            $this->competenciasEvaluadas = $DAOcompEv->recuperar($this->clave);
        }
        
        if($this->ultimo_bloque_accedido == "NULL"){
            $lista = $this->listarPreguntas();
            $this->ultimo_bloque_accedido = $DAOcuest->retornarUltimoBloqueAccedido($this->clave, $lista);
        }
    }
    
    public function listarPreguntas() {
        $retorno = array();
        if(empty($this->competenciasEvaluadas) == TRUE){
            $DAOcompEv = new \Models_DAO\CompetenciaEvaluadaDAO();
            $this->competenciasEvaluadas = $DAOcompEv->recuperar($this->clave);
        }
        $comp_ev = $this->competenciasEvaluadas;
        foreach ($comp_ev as $res) {
            $lista = $res->listarPreguntas();
            $retorno = \array_merge($retorno, $lista);
        }
        return $retorno;
    }
    
    public function consultaEstaCompleto(){
        //consultar en la base de datos
        foreach ($this->cambiosEstado as $fechaEstado){
            if($fechaEstado->get('estado')->get('tipo') == 'COMPLETO'){ 
                return TRUE;
            }
        }
        return FALSE;
    }
    public function consultarFechaInicio(){
        foreach ($this->cambiosEstado as $fechaEstado) {
            if($fechaEstado->get('estado')->get('tipo') == 'EN PROCESO'){
                $fecha = $fechaEstado->get('fechayhora');
            }
        }
        return $fecha;
    }
    public function consultarFechaFin(){
        //$cuestionarioDAO= new \Models_DAO\CuestionarioDAO();
        //$fecha=$cuestionarioDAO->consultarFechaFinCuestionario($clave);
        foreach ($this->cambiosEstado as $fechaEstado) {
            if($fechaEstado->get('estado')->get('tipo') == 'COMPLETO'){
                $fecha = $fechaEstado->get('fechayhora');
            }
        }
        return $fecha;
    }
    public function consultaPonderacionAlcanzada(){
        //$compEvDAO= new \Models_DAO\CompetenciaEvaluadaDAO();
        $suma_ponderaciones=0;
        $suma_puntajes = 0;
        //$ponderacionpuntaje = $compEvDAO->consultarPonderacionPuntaje($this->clave);
        
        foreach($this->competenciasEvaluadas as $key ){//lista de listas ponderacion-puntaje
            $suma_ponderaciones = $suma_ponderaciones + $key->get('ponderacion'); 
            $suma_puntajes = $key->get('puntaje') + $suma_puntajes;
        }
        $arreglo = array('ponderaciones' => $suma_ponderaciones, 'puntajes' => $suma_puntajes);
        return $arreglo;
    }
    
    
    public function consultarEstadoPreFinalizado(){
        //$cuestionarioDAO= new \Models_DAO\CuestionarioDAO();
        //$estadopre=$cuestionarioDAO->consultarPenultimoEstado($this->clave);
        $fechaMax = $this->cambiosEstado[0]->get('fechayhora');
        $estadopre = $this->cambiosEstado[0]->get('estado');
        foreach ($this->cambiosEstado as $fechaEstado) {
            if($fechaEstado->get('estado') != 'FINALIZADO'){
                $fecha = $fechaEstado->get('fechayhora');
                if($fechaMax < $fecha){
                    $fechaMax = $fecha;
                    $estadopre = $fechaEstado->get('estado');
                }
            }
        }
        return $estadopre;
    }
    
    
    public function calcularPuntaje() {
        foreach ($this->competenciasEvaluadas as $competencia_ev) {
            $retorno = $competencia_ev->calcularPuntaje();
        }
        
        return $retorno;
    }
    
    }

?>