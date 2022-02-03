<?php namespace Models_DAO;

  
 class CompetenciaEvaluadaDAO implements \Models_DAO\AdministradorBD{

    private $conex;
    function __construct() { $this->conex = $GLOBALS['conex']; }

    public function recuperar($p_clave) {
        $DAOfactor_ev = new \Models_DAO\FactorEvaluadoDAO();
        $lista = array();
        $sql = "SELECT cv.idcompetencia_evaluada, cv.codigo, cv.nombre, cv.descripcion, cv.ponderacion, cv.puntaje "
                . "FROM `competencia evaluada` cv "
                . "JOIN cuestionario c ON (c.idcuestionario = cv.idcuestionario) "
                . "WHERE c.clave = '$p_clave'";
        $retorno = $this->conex->consultaRetorno($sql);
        if($retorno->num_rows != 0){
            foreach ($retorno as $res) {
                $comp_ev = new \Models_Entitys\CompetenciaEvaluada();
                foreach ($res as $atributo => $valor) {
                    if($atributo == "idcompetencia_evaluada") {
                        $lista_fac = $DAOfactor_ev->listar($valor);
                        $comp_ev->set('factores', $lista_fac);
                    } else { $comp_ev->set($atributo, $valor); }
                }
                \array_push($lista, $comp_ev);
            }
        }
        return $lista;
    }
    
    public function consultarPonderacionPuntaje($clave){
        
        $sql="SELECT ce.ponderacion, ce.puntaje FROM ´competencia evaluada´ ce "
                . "JOIN cuestionario cuest ON (ce.cuestionario_idcuestionario=cuest.idcuestionario) "
                . "WHERE cuest.clave=$clave ";
        
        $ponderacion=$this->conex->consultaRetorno($sql);
        return $ponderacion;
    }
    
    public function inserts(\Models_Entitys\CompetenciaEvaluada $p_competencia, $p_clave){ 
        $codigo = $p_competencia->get("codigo");
        $nombre = $p_competencia->get("nombre");
        $descrip = $p_competencia->get("descripcion");
        $ponderacion = $p_competencia->get("ponderacion");
        $puntaje = 0;
        
        $sql = "INSERT INTO `competencia evaluada` (`codigo`, `nombre`, `descripcion`, `ponderacion`, `puntaje`, `idCuestionario`) "
                . "SELECT $codigo, '$nombre', '$descrip', $ponderacion, $puntaje, c.idCuestionario "
                . "FROM cuestionario c "
                . "WHERE c.clave = '$p_clave'; ";
    
        return $sql;
        
    }
    
    public function generarSql($p_competenciaEv, $p_claveCuest) {
        $factorEvDAO = new \Models_DAO\FactorEvaluadoDAO();
        $retorno = array();
        
        $consulta = $this->inserts($p_competenciaEv, $p_claveCuest);
        \array_push($retorno, $consulta);
        
        $listFactoresEv = $p_competenciaEv->get('factores');
        
        foreach ($listFactoresEv as $facEv) {
            $consulta = $factorEvDAO->generarSql($facEv, $p_competenciaEv->get('codigo'));
            $retorno = \array_merge($retorno, $consulta);
        }
        
        return $retorno;
    }
    
    public function setearPuntaje($competencia_ev, $clave_cuestionario) {
        $DAoFactor_evaluado = new \Models_DAO\FactorEvaluadoDAO();
        $sql = "UPDATE `competencia evaluada` SET `puntaje`= ".$competencia_ev->get('puntaje')." "
                . "WHERE `codigo` = ".$competencia_ev->get('codigo')." "
                . "AND `idCuestionario` IN (SELECT idCuestionario FROM cuestionario WHERE clave = '$clave_cuestionario')";
        $this->conex->consultaSimple($sql);
        
        foreach ($competencia_ev->get('factores') as $factor_ev) {
            $DAoFactor_evaluado->setearPuntaje($factor_ev, $competencia_ev->get('codigo'), $clave_cuestionario);
        }
        return TRUE;
    }
    
    public function insert($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; }   // INSERT
    public function borrar($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; } //metodo que recibe un INSTANCIA de una ENTITY del sistema. Debe eliminar dicha entida de la BD
    public function listar($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; } //
    public function get_atributo($p_atributo, $p_parametro){ echo "<br>METODO NO IMPLEMENTADO ".$p_atributo." ".$p_parametro; }
    public function get($p_atributo, $p_parametro){ echo "<br>METODO NO IMPLEMENTADO ".$p_atributo." ".$p_parametro; }// BUSCAR
    public function update($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; }
    public function exists($p_atributo){ echo "<br>METODO NO IMPLEMENTADO ".$p_atributo; }
    public function set($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; }// BUSCAR

}

?>

