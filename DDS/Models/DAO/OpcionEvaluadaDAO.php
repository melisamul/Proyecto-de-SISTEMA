<?php namespace Models_DAO;

class OpcionEvaluadaDAO implements \Models_DAO\AdministradorBD{
    private $conex;
    
    public function __construct() {
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
        $sql = "SELECT nombre, valor_elegido, ponderacion_evaluada, orden_visualizacion "
                . "FROM `opcion evaluada` WHERE idpregunta_evaluada = $p_atrib";
        
        $retorno = $this->conex->consultaRetorno($sql);

        if($retorno->num_rows != 0){
            $lista = array();
            foreach ($retorno as $res) {
                $opc_ev = new \Models_Entitys\OpcionEvaluada();
                foreach ($res as $atributo => $valor) {
                    $opc_ev->set($atributo, $valor); 
                }
                \array_push($lista, $opc_ev);
            }
            return $lista;
        } else {
            return FALSE;
        }
    }
    
    public function inserts(\Models_Entitys\OpcionEvaluada $p_opc, $p_codigo){ 
        $nombre = $p_opc->get("nombre");
        $orden = $p_opc->get("orden_visualizacion");
        $ponderacion = $p_opc->get("ponderacion_evaluada");
        
        $sql = "INSERT INTO `opcion evaluada` (`nombre`,`ponderacion_evaluada`, `idPregunta_Evaluada`,`orden_visualizacion`) "
                . "SELECT '$nombre', $ponderacion, MAX(p.`idPregunta_Evaluada`), $orden "
                . "FROM `pregunta evaluada` p  "
                . "WHERE p.codigo = $p_codigo; ";
    
        return $sql;
        
    }   // INSERT
    
    public function generarSql($p_opcionEv, $p_codigoPreg) {
        
        $consulta = $this->inserts($p_opcionEv, $p_codigoPreg);
        
        return $consulta;
    }
}
?>