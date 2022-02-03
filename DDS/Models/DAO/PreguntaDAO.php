<?php namespace Models_DAO;

class PreguntaDAO implements \Models_DAO\AdministradorBD {
    
    private $conex;

    public function __construct() { $this->conex = $GLOBALS['conex']; }

    public function borrar($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; } //metodo que recibe un INSTANCIA de una ENTITY del sistema. Debe eliminar dicha entida de la BD
    public function get_atributo($p_atributo, $p_parametro){ echo "<br>METODO NO IMPLEMENTADO ".$p_atributo." ".$p_parametro; }
    public function get($p_atributo, $p_parametro){ echo "<br>METODO NO IMPLEMENTADO ".$p_atributo." ".$p_parametro; }// BUSCAR
    public function update($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; }
    public function exists($p_atributo){ echo "<br>METODO NO IMPLEMENTADO ".$p_atributo; }
    public function set($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; }// BUSCAR
    public function insert($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; }   // INSERT

    
    public function listar($p_codigo){ 
        
        $sql = "SELECT p.* FROM pregunta p JOIN factor f ON (f.idfactor = p.factor_idfactor) "
                . "WHERE f.codigo = $p_codigo";
        $retorno = $this->conex->consultaRetorno($sql);
        
        if($retorno->num_rows != 0){        
            $lista = array();
            foreach ($retorno as $row) {
                $pregunta = new \Models_Entitys\Pregunta();
                foreach ($row as $key => $value) {
                    $pregunta->set($key, $value);
                }
                $pregunta->mapear();
                \array_push($lista, $pregunta);
            }
            return $lista;
        } else {
            return FALSE;
        }   
    }
    
    public function listarPonderaciones($p_codigo) {
        $opcionDAO = new \Models_DAO\OpcionesDAO();
        $sql = "SELECT po.* FROM pregunta_opcion po JOIN pregunta p ON (p.idpregunta = po.pregunta_idpregunta) "
                . "WHERE p.codigo = $p_codigo; ";
        
        $retorno = $this->conex->consultaRetorno($sql);
        
        if($retorno->num_rows != 0){
            $lista = array();
            foreach ($retorno as $row) {
                $pond = new \Models_Entitys\Ponderacion();
                foreach ($row as $key => $value) {
                    $pond->set($key, $value);
                    if($key == 'Opcion_idOpcion'){
                        $opc = $opcionDAO->get('idopcion', $value);
                        $pond->set('opcion', $opc);
                    }
                }
                \array_push($lista, $pond);
            }
            return $lista;
        } else {
            return FALSE;
        }
    }
    
}

?>
