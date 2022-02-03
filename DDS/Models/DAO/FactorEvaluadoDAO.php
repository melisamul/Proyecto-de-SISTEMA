<?php namespace Models_DAO;

 class FactorEvaluadoDAO implements \Models_DAO\AdministradorBD{

     private $conex;
     function __construct() {
        $this->conex = $GLOBALS['conex'];
    }
    public function borrar($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; } //metodo que recibe un INSTANCIA de una ENTITY del sistema. Debe eliminar dicha entida de la BD
    public function get_atributo($p_atributo, $p_parametro){ echo "<br>METODO NO IMPLEMENTADO ".$p_atributo." ".$p_parametro; }
    public function get($p_atributo, $p_parametro){ echo "<br>METODO NO IMPLEMENTADO ".$p_atributo." ".$p_parametro; }// BUSCAR
    public function update($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; }
    public function exists($p_atributo){ echo "<br>METODO NO IMPLEMENTADO ".$p_atributo; }
    public function set($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; }// BUSCAR
    public function insert($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; }   // INSERT
    
    public function listar($p_atrib){   
        $sql = "SELECT f.idfactor_evaluado, f.codigo, f.nombre, f.descripcion, f.puntaje "
                . "FROM `factor evaluado` f WHERE f.idcompetencia_evaluada = $p_atrib";
        
        $retorno = $this->conex->consultaRetorno($sql);
        $lista = array();
        
        if($retorno->num_rows != 0){
            $DAOpreg_ev = new \Models_DAO\PreguntaEvaluadaDAO();
            foreach ($retorno as $res) {
                $factor = new \Models_Entitys\FactorEvaluado();
                foreach ($res as $atributo => $valor) {
                    if($atributo == "idfactor_evaluado"){
                        $lista_preg = $DAOpreg_ev->listar($valor);
                        $factor->set('preguntas', $lista_preg);
                    } else { $factor->set($atributo, $valor); }
                }
                \array_push($lista, $factor);
            }
            return $lista;
        } else {
            return FALSE;
        }
    }
    
    
    public function inserts(\Models_Entitys\FactorEvaluado $p_factor, $p_codigo){ 
        $codigo = $p_factor->get("codigo");
        $nombre = $p_factor->get("nombre");
        $descrip = $p_factor->get("descripcion");
        $puntaje = 0;
        
        $sql = "INSERT INTO `factor evaluado` (`codigo`, `nombre`, `descripcion`, `puntaje`, `idCompetencia_Evaluada`) "
                . "SELECT $codigo, '$nombre', '$descrip', $puntaje, MAX(c.`idCompetencia_Evaluada`) "
                . "FROM `competencia evaluada` c "
                . "WHERE c.codigo = $p_codigo; ";
    
        return $sql;
        
    }   // INSERT
    
    public function generarSql($p_factorEv, $p_codigoComp) {
        $preguntaEvDAO = new \Models_DAO\PreguntaEvaluadaDAO(); 
        $retorno = array();
        
        $consulta = $this->inserts($p_factorEv, $p_codigoComp);
        \array_push($retorno, $consulta);
        
        $listPreguntasEv = $p_factorEv->get('preguntas');
        
        foreach ($listPreguntasEv as $pregEv) {
            $consulta = $preguntaEvDAO->generarSql($pregEv, $p_factorEv->get('codigo'));
            $retorno = \array_merge($retorno, $consulta);
        }
        
        return $retorno;
    }
    
    public function setearPuntaje($factor_ev, $codigo_competencia_ev, $clave_cuest) {
        
        $sql = "UPDATE `factor evaluado` SET `puntaje`= ".$factor_ev->get('puntaje')."  
            WHERE `codigo` = ".$factor_ev->get('codigo')." 
            AND `idCompetencia_Evaluada` IN (
            SELECT `idCompetencia_Evaluada` 
            FROM `competencia evaluada` ce 
            JOIN `cuestionario` c ON (c.idcuestionario = ce.idcuestionario) 
            WHERE ce.`codigo` = $codigo_competencia_ev AND c.clave = '$clave_cuest') 
            ";
        $this->conex->consultaSimple($sql);
        return TRUE;
    }
}
?>