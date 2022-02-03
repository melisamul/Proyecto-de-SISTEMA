<?php namespace Models_DAO;

class OpcionesDAO implements \Models_DAO\AdministradorBD {
    
    private $conex;


    public function __construct() {
        $this->conex = $GLOBALS['conex'];
    }

    public function borrar($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; } //metodo que recibe un INSTANCIA de una ENTITY del sistema. Debe eliminar dicha entida de la BD
    public function get_atributo($p_atributo, $p_parametro){ echo "<br>METODO NO IMPLEMENTADO ".$p_atributo." ".$p_parametro; }
    public function update($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; }
    public function exists($p_atributo){ echo "<br>METODO NO IMPLEMENTADO ".$p_atributo; }
    public function set($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; }// BUSCAR
    public function insert($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; }   // INSERT

    
    public function get($p_atributo, $p_parametro){ 
        $sql = "SELECT p.* FROM opcion p WHERE $p_atributo = $p_parametro;";
        
        $retorno = $this->conex->consultaRetorno($sql);
        
        if($retorno->num_rows != 0){
            $opc = new \Models_Entitys\Opcion();
            foreach ($retorno as $row) {
                foreach ($row as $key => $value) {
                    $opc->set($key, $value);
                }
            }
            return $opc;
        } else {
            return FALSE;
        }
                
    }
    
    public function listar($param) {
        $sql = "SELECT o.* FROM opcion o "
                . "JOIN `opcion de respuesta` op ON (o.idopcion_de_respuesta = op.idopcion_de_respuesta) "
                . "WHERE op.idopcion_de_respuesta = $param;";
        $retorno = $this->conex->consultaRetorno($sql);
        
        if($retorno->num_rows != 0){
            $lista = array();
            foreach ($retorno as $row) {
                $opc = new \Models_Entitys\Opcion();
                foreach ($row as $key => $value) {
                    $opc->set($key, $value);
                }
                \array_push($lista, $opc);
            }
            return $lista;
        } else {
            return FALSE;
        }
    }
    
    public function unaOpcion_respuesta($param) {
        $sql = "SELECT o.* FROM `opcion de respuesta` o JOIN pregunta p ON (o.idopcion_de_respuesta = p.idopcion_de_respuesta) "
                . "WHERE p.codigo = $param;";
        $retorno = $this->conex->consultaRetorno($sql);
        
        if($retorno->num_rows != 0){
            foreach ($retorno as $row) {
                $opc_r = new \Models_Entitys\OpcionDeRespuesta();
                foreach ($row as $key => $value) {
                    $opc_r->set($key, $value);
                    if($key == 'idopcion_de_respuesta'){
                        $opc = $this->listar($value);
                        $opc_r->set('opciones', $opc);
                    }
                }
            }
            return $opc_r;
        } else {
            return FALSE;
        } 
    }
    
}

?>
