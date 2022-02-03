<?php namespace Models_DAO;
  
class UsuarioDAO implements \Models_DAO\AdministradorBD{
    
    private $conex; 
    
    public function __construct() { $this->conex = $GLOBALS['conex']; }
    
    public function borrar($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; } //metodo que recibe un INSTANCIA de una ENTITY del sistema. Debe eliminar dicha entida de la BD
    public function get_atributo($p_atributo, $p_parametro){ echo "<br>METODO NO IMPLEMENTADO ".$p_atributo." ".$p_parametro; }
    public function update($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; }
    public function exists($p_atributo){ echo "<br>METODO NO IMPLEMENTADO ".$p_atributo; }
    public function set($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; }// BUSCAR
    public function insert($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; }   // INSERT
    
    public function listAll_tipos(){
        $Sql="SELECT DISTINCT * FROM tipoDocumento";
        $resultado = $this->conex->consultaRetorno($Sql);
			
        $lista = array();
        if($resultado->num_rows != 0){
            foreach ($resultado as $row){
                \array_push($lista, $row['tipo']);
            }
        }
        return $lista;
    }
    
    public function get($p_atributo, $p_valor){
        $candidato = new \Models_Entitys\Candidato();
        $sql="SELECT DISTINCT * FROM candidato WHERE $p_atributo='$p_valor'";			
        $resultado= $this->conex->consultaRetorno($sql);
        
        if($resultado->num_rows != 0){
            foreach($resultado as $res){
                foreach ($res as $key => $value) {
                    $candidato->set($key, $value);
                }
            }
            return $candidato;
        } else {
            return FALSE;
        }
    }
    
    public function get_consultor($p_user){
        $consultor = new \Models_Entitys\Consultor();
        $sql="SELECT DISTINCT * FROM consultor WHERE user='$p_user'";			
        $resultado= $this->conex->consultaRetorno($sql);
        
        if($resultado->num_rows != 0){
            foreach($resultado as $res){
                foreach ($res as $key => $value) {
                    $consultor->set($key, $value);
                }
            }
            return $consultor;
        } else {
            return FALSE;
        }
    }
    
    public function listar($lista){
        $listRetorno = array();
        
        $sql = "SELECT c.*, t.tipo FROM candidato c "
                . "JOIN tipodocumento t ON (c.idtipodocumento = t.iddocumento) "
                . "WHERE nombre LIKE '".$lista['nombre']."' OR apellido LIKE '".$lista['apellido']."' OR nrocandidato LIKE ".$lista['nro']."";
        
        $resultado = $this->conex->consultaRetorno($sql);
        
        if($resultado->num_rows != 0){
            foreach($resultado as $res){
                foreach ($res as $key => $value) {
                    $candidato = new \Models_Entitys\Candidato();
                    $candidato->set($key, $value);
                    if($key == "tipo"){
                        \array_push($listRetorno, $candidato);
                    }
                }
                return $listRetorno;
            }
        } else {
            return FALSE;
        }
    }
    
}
?>

