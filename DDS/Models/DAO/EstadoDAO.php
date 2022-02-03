<?php namespace Models_DAO;

class EstadoDAO implements \Models_DAO\AdministradorBD {
    
    private $conex;
    public function __construct(){ $this->conex = $GLOBALS['conex']; }
    
    public function borrar($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; } //metodo que recibe un INSTANCIA de una ENTITY del sistema. Debe eliminar dicha entida de la BD
    public function listar($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; } //
    public function get_atributo($p_atributo, $p_parametro){ echo "<br>METODO NO IMPLEMENTADO ".$p_atributo." ".$p_parametro; }
    public function get($p_atributo, $p_parametro){ echo "<br>METODO NO IMPLEMENTADO ".$p_atributo." ".$p_parametro; }// BUSCAR
    public function update($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; }
    public function exists($p_atributo){ echo "<br>METODO NO IMPLEMENTADO ".$p_atributo; }
    
    public function set($p_objeto){ 
        $clave_cuest = $p_objeto['clave'];
        $fecha_estado = $p_objeto['estado'];
        $estado = $fecha_estado->get('estado');
        
        $sql = "INSERT INTO `cuestionario_has_estado`(`Cuestionario_idCuestionario`, `Estado_idEstado`, `fechayhora`) "
                . "SELECT c.idCuestionario, e.idEstado, '".$fecha_estado->get('fechayhora')."' "
                . "FROM cuestionario c, estado e "
                . "WHERE c.clave = '".$clave_cuest."' AND e.tipo = '".$estado->get('tipo')."';";
        return $sql; 
        
    }// Retornara la consulta sql para el ingreso atomico
    
    public function insert($p_objeto){ 
        $clave_cuest = $p_objeto['clave'];
        $estado = $p_objeto['estado'];
        
        $sql = "INSERT INTO `cuestionario_has_estado`(`Cuestionario_idCuestionario`, `Estado_idEstado`, `fechayhora`) "
                . "SELECT c.idcuestionario, e.idestado, CURRENT_TIMESTAMP "
                . "FROM cuestionario c, estado e WHERE c.clave = '$clave_cuest' AND e.tipo = '$estado';";
        $this->conex->consultaSimple($sql);
        
        return 1;
    }   // INSERT

}

