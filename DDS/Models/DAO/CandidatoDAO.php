<?php namespace Models_DAO;

class CandidatoDAO implements \Models_DAO\AdministradorBD {
    
    private $conex; 
    
    public function __construct() {
        $this->conex = $GLOBALS['conex'];
    }
    
    public function borrar($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; } //metodo que recibe un INSTANCIA de una ENTITY del sistema. Debe eliminar dicha entida de la BD
    public function listar($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; } //
    public function get_atributo($p_atributo, $p_parametro){ echo "<br>METODO NO IMPLEMENTADO ".$p_atributo." ".$p_parametro; }
    public function update($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; }
    public function exists($p_atributo){ echo "<br>METODO NO IMPLEMENTADO ".$p_atributo; }
    public function set($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; }// BUSCAR
    public function insert($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; }   // INSERT

    public function get($p_atributo, $p_parametro){ 
        $candidato = new \Models_Entitys\Candidato();
        $sql="SELECT DISTINCT c.*, t.tipo AS tipodocumento "
                . "FROM candidato c JOIN tipoDocumento t ON (t.iddocumento = c.idtipodocumento) "
                . "WHERE $p_atributo=$p_parametro";			
        $resultado= $this->conex->consultaRetorno($sql);
        if($resultado->num_rows != 0){
            foreach($resultado as $res){
                foreach ($res as $key => $value){
                    $candidato->set($key, $value);
                }
            }
        }
        return $candidato;
    }
    
    public function listarAll(){
        $Sql="SELECT nrocandidato, nombre, apellido 
                FROM candidato can 
                JOIN cuestionario cues ON (can.idcandidato = cues.idcandidato) 
                JOIN cuestionario_has_estado che ON (cues.idcuestionario = che.cuestionario_idcuestionario) 
                JOIN estado e ON (e.idestado = che.estado_idestado) 
                WHERE e.tipo = 'FINALIZADO' 
                UNION 
                (SELECT nrocandidato, nombre, apellido 
                FROM candidato  
                WHERE idcandidato NOT IN (SELECT idcandidato FROM cuestionario)) 
                ORDER BY nrocandidato";
        $resultado = $this->conex->consultaRetorno($Sql);
        
        $lista= array ();
        if($resultado->num_rows != 0){
            
        foreach ($resultado as $cand){
            $candidato = new \Models_Entitys\Candidato();
            foreach($cand as $key =>$value){
                $candidato->set($key, $value);
            }
            \array_push($lista, $candidato);
        }		
        return $lista;
        }
        else {return FALSE;}
    }
    
    
}

?>
