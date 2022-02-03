<?php namespace Models_DAO;

class PreguntaEvaluadaDAO implements \Models_DAO\AdministradorBD{
    
    private $conex;
    
    public function __construct() { $this->conex = $GLOBALS['conex']; }
    public function borrar($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; } //metodo que recibe un INSTANCIA de una ENTITY del sistema. Debe eliminar dicha entida de la BD 
    public function get($p_atributo, $p_parametro){ echo "<br>METODO NO IMPLEMENTADO ".$p_atributo." ".$p_parametro; }// BUSCAR
    public function get_atributo($p_atributo, $p_parametro){ echo "<br>METODO NO IMPLEMENTADO ".$p_atributo." ".$p_parametro; }
    public function update($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; }
    public function exists($p_atributo){ echo "<br>METODO NO IMPLEMENTADO ".$p_atributo; }
    public function set($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; }// BUSCAR
    public function insert($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; }   // INSERT
    
    public function get_id($p_codigo){ 
        
        $sql = "SELECT MAX(`idPregunta_Evaluada`) AS id FROM `pregunta evaluada` WHERE codigo = $p_codigo;";
        $retorno = $this->conex->consultaRetorno($sql);
        if($retorno->num_rows != 0){
            foreach ($retorno as $value) {
                return $value['id'];
            }
        }
    }
    
    public function listar($p_atrib){
        $sql = "SELECT idpregunta_evaluada, codigo, pregunta, descripcion, orden_enBloque "
                . "FROM `pregunta evaluada` WHERE idfactor_evaluado = $p_atrib";
        
        $retorno = $this->conex->consultaRetorno($sql);

        if($retorno->num_rows != 0){
            $lista = array();
            $DAOopcion_ev = new \Models_DAO\opcionEvaluadaDAO();
            foreach ($retorno as $res) {
                $preg_ev = new \Models_Entitys\PreguntaEvaluada();
                foreach ($res as $atributo => $valor) {
                    if($atributo == "idpregunta_evaluada"){
                        $lista_preg = $DAOopcion_ev->listar($valor);
                        $preg_ev->set('opciones_evaluadas', $lista_preg);
                    } else { $preg_ev->set($atributo, $valor); }
                }
                \array_push($lista, $preg_ev);
            }
            return $lista;
        } else {
            return FALSE;
        }
    }
    
    public function inserts(\Models_Entitys\PreguntaEvaluada $p_preg, $p_codigo){ 
        $codigo = $p_preg->get("codigo");
        $pregunta = $p_preg->get("pregunta");
        $descrip = $p_preg->get("descripcion");
        
        $sql = "INSERT INTO `pregunta evaluada` (`codigo`, `pregunta`, `descripcion`, `idFactor_Evaluado`)  "
                . "SELECT $codigo, '$pregunta', '$descrip', MAX(f.`idFactor_Evaluado`) "
                . "FROM `factor evaluado` f  "
                . "WHERE f.codigo = $p_codigo; ";
    
        return $sql;
        
    }   // INSERT
    
    public function generarSql($p_preguntasEv, $p_codigoFac) {
        $opcionEvDAO = new \Models_DAO\OpcionEvaluadaDAO();
        $retorno = array();
        
        $consulta = $this->inserts($p_preguntasEv, $p_codigoFac);
        \array_push($retorno, $consulta);
        
        $listOpcionesEv = $p_preguntasEv->get('opciones_evaluadas');
        foreach ($listOpcionesEv as $opcionEv) {
            $consulta = $opcionEvDAO->generarSql($opcionEv, $p_preguntasEv->get('codigo'));
            \array_push($retorno, $consulta);
        }
        
        return $retorno;
    }
    public function recuperarPreguntasEvaluadas($idbloque, $listaPreEv){    
        if(empty($listaPreEv) == FALSE){
            $sql = "SELECT pe.codigo FROM `pregunta evaluada` pe JOIN `bloque` b ON (pe.idbloque=b.idbloque) WHERE b.idbloque=$idbloque";
            $resultado= $this->conex->consultaRetorno($sql);

            $lista = array();

            if($resultado->num_rows != 0){
                foreach($resultado as $res){
                    $preg_ev = $this->pertenece($listaPreEv, $res['codigo']);
                    if($preg_ev != FALSE){
                        \array_push($lista, $preg_ev);
                    }
                }
                return $lista;

            } else {
                return false;
            }    
        }
    }
    
    public function pertenece($lista, $codigo) {
        foreach ($lista as $preg) {
            if($preg->get('codigo') === $codigo){
                return $preg;
            }
        }
    }
}