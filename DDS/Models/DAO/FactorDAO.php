<?php namespace Models_DAO;

class FactorDAO implements \Models_DAO\AdministradorBD {
    
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

    
    public function listar($p_codigo){ 
        
        $sql = "SELECT f.* FROM factor f JOIN competencia c ON (c.idcompetencia = f.competencia_idcompetencia) "
                . "WHERE c.codigo = $p_codigo";
        $retorno = $this->conex->consultaRetorno($sql);
        
        if($retorno->num_rows != 0){
            $lista = array();
            foreach ($retorno as $row) {
                $factor = new \Models_Entitys\Factor();
                foreach ($row as $key => $value) {
                    $factor->set($key, $value);
                }
                $factor->mapear();
                \array_push($lista, $factor);
            }
            return $lista;
        } else {
            return FALSE;
        }   
    }
    
}

?>
