<?php namespace Models_DAO;

 class EvaluacionDAO implements \Models_DAO\AdministradorBD {
    private $conex;
    
    function __construct() { $this->conex = $GLOBALS['conex']; }
    
    public function borrar($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; } //metodo que recibe un INSTANCIA de una ENTITY del sistema. Debe eliminar dicha entida de la BD
    public function listar($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; } //
    public function get_atributo($p_atributo, $p_parametro){ echo "<br>METODO NO IMPLEMENTADO ".$p_atributo." ".$p_parametro; }
    public function get($p_atributo, $p_parametro){ echo "<br>METODO NO IMPLEMENTADO ".$p_atributo." ".$p_parametro; }// BUSCAR
    public function update($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; }
    public function exists($p_atributo){ echo "<br>METODO NO IMPLEMENTADO ".$p_atributo; }
    public function insert($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; }   // INSERT
    public function set($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; }// BUSCAR
    
    public function sets($p_listaCuest, $p_codigoPuesto){ 
        
        $cuestionarioDAO = new \Models_DAO\CuestionarioDAO();
        $arreglo_sql = array();
        
        foreach ($p_listaCuest as $res) {
            
            $consulta = $cuestionarioDAO->generarSql($res, $p_codigoPuesto);
            $arreglo_sql = \array_merge($arreglo_sql, $consulta);
        }
        
        /*foreach ($arreglo_sql as $key => $value) {
            echo '<br>'.$value.'<br>';
        }*/
        return $this->conex->generalAtomic($arreglo_sql);
    } 
    
    public function setearPuntajes($cuestionario) {
        $DAoCompetencias_ev = new \Models_DAO\CompetenciaEvaluadaDAO();
        
        foreach ($cuestionario->get('competenciasEvaluadas') as $competencia_ev) {
            $retorno = $DAoCompetencias_ev->setearPuntaje($competencia_ev, $cuestionario->get('clave'));
        }        
        
        return $retorno;
    }
    
}
?>

