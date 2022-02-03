<?php namespace Models_Entitys;

class Puesto {
//Atributos
    private $codigo;
    private $nombre;
    private $descripcion;
    private $eliminado;
    private $empresa = "NULL"; 
    private $caracteristicas = array(); //lista de objetos Caracteristica
    private $cuestionarios = array(); //lista de objetos Cuestionario
//Metodos
    public function __construct(){ }
    
    public function poseeEvaluacionesActivas(){
        $retorno = $this->mapeador(); //retorno cuestionarios y  me fijo si estan activos o en proceso
        if($retorno == TRUE){
            if(empty($this->cuestionarios) == FALSE){
                foreach($this->cuestionarios as $cuest){
                    $estado= $cuest->ultimoEstado();
                    if($estado->get('tipo')=='ACTIVO' || $estado->get('tipo') =='EN PROCESO'){ 
                        return TRUE; 
                    }
                }
                return FALSE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }
    
    public function actualizarCaracteristicas($p_lista) {
        
        $this->mapeador();
        
        $nuevos = array(); $actualizados = array();
        
        foreach ($p_lista as $key => $elem) {
            $resp = $this->existeElemento($elem);
            if(is_bool($resp) == false){
                $comp = $this->fueModificado($elem, $resp);
                if($comp == 0){ //es una caracteristicas modificada
                    $actualizados[] = $elem;
                }
                $this->eliminarElemento($resp);
            } else { 
                $nuevos[] = $elem;
            }
        }
        $borrados = $this->caracteristicas;
        $lista = array('modificados' => $actualizados, 'eliminados' => $borrados, 'nuevos' => $nuevos,);
        $this->caracteristicas = $lista;
    }
    
    public function comparaNombre($param) {
        if(strnatcasecmp($this->nombre, $param) == 0){
            return true;
        } 
        return false;
    }
    private function eliminarElemento($param) {
        foreach ($this->caracteristicas as $key => $value) {
            $comp1 = $param->get("competencia");
            $comp2 = $value->get("competencia");
            if($comp1->get("codigo") == $comp2->get("codigo")){
                unset($this->caracteristicas[$key]);
                return true;
            }            
        }
        return false;
    }

    private function existeElemento($elemento){
        $listCaract = $this->caracteristicas;
        foreach ($listCaract as $key => $caract){
            $comp1 = $caract->get("competencia");
            $comp2 = $elemento->get("competencia");
            if($comp1->get("codigo") == $comp2->get("codigo")){
                return $caract;
            }
        }
        return false;
    }
    
    private function fueModificado($param1, $param2) {
        $return= false;
        $pond1 = $param1->get("ponderacion");
        $pond2 = $param2->get("ponderacion");
        if($pond1 == $pond2){
            $return = true;
        }
        return $return;
    }
    
    public function mapeador(){ 

        $retorno = TRUE;
        if(empty($this->cuestionarios) == TRUE){
            $DAOcuestionario = new \Models_DAO\CuestionarioDAO();
            $respuesta = $DAOcuestionario->listarCuestionarios($this->codigo);
                    
            if ($respuesta != FALSE){
                $this->cuestionarios = $respuesta;
            }                
            else{
                $retorno = FALSE;
            }   
        }
        
        if($this->empresa == "NULL"){
            $DAOempresa = new \Models_DAO\EmpresaDAO();
            $emp = $DAOempresa->devolver($this->codigo);
            if(is_bool($emp) == FALSE){ $this->empresa = $emp; }
        }
        if(empty($this->caracteristicas) == TRUE){
            $DAOcaract = new \Models_DAO\CaracteristicasDAO();
            $caract = $DAOcaract->devolver($this->codigo);
            if(empty($caract) == FALSE){ $this->caracteristicas = $caract; }
        }
        
        return $retorno;
    }
    
    public function retornarCompentenciasNoSeleccionadas($p_compSelect) {
        $retorno = array();
        foreach ($this->caracteristicas as $caracteristica) {
            if($caracteristica->estaIncluida($p_compSelect) == FALSE){
                \array_push($retorno, $caracteristica->get('competencia'));
            }
        }
        return $retorno;
    }
			
    public function agregarElemento($p_caracteristica){	$this->caracteristicas[] = $p_caracteristica; } // deberiamos controlar la clase del obj recibido como parametro ??? 
    public function agregarCuestionario($p_cuestionario){ $this->cuestionarios[] = $p_cuestionario; } // idem a los de arriba ¿?
    public function set($p_atributo, $p_valor) { $this->$p_atributo = $p_valor; }
    public function get($p_atributo){ return $this->$p_atributo; }
    
    }
    
?>