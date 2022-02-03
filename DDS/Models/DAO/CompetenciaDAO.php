<?php namespace Models_DAO;

class CompetenciaDAO implements \Models_DAO\AdministradorBD{
    private $conex;
    
    public function __construct(){ $this->conex = $GLOBALS['conex']; }
    
    public function get($p_atributo, $p_valor){
        $comp = new \Models_Entitys\Competencia();
	
        $sql="SELECT DISTINCT * FROM competencia c WHERE c.$p_atributo='$p_valor'";			
	$resultado= $this->conex->consultaRetorno($sql);
        
        if($resultado->num_rows != 0){
            foreach($resultado as $key => $value){
                foreach ($value as $atributo => $valor){
                    $comp->set($atributo, $valor);
                }
            }
        return $comp;
        } else {
            return false;
        }
    }

    public function get_atributo($p_atributo, $p_codigo){ 
        $sql = "SELECT $p_atributo FROM competencia WHERE codigo = $p_codigo";
        $res = $this->conex->consultaRetorno($sql);
        
        if($res->num_rows != 0){
            foreach ($res as $valor){
                $resul = $valor[$p_atributo];
            }
            return $resul;
        } else {
            return false;
        }
    }

    public function listAll()//devuelve un arreglo de objetos
    {// se realiza la consulta
	$Sql="SELECT DISTINCT * FROM competencia ORDER BY nombre";
	$resultado = $this->conex->consultaRetorno($Sql);
	$lista = array();
        if($resultado->num_rows != 0){
            foreach ($resultado as $row){
                $competencia = new \Models_Entitys\Competencia();
                $competencia->set("codigo", $row["codigo"]);
                $competencia->set("nombre", $row["nombre"]);
                $competencia->set("descripcion", $row["descripcion"]);
                array_push($lista, $competencia);
            }
        }
	return $lista;
    }

    
    public function listAllDisponibles()//devuelve un arreglo de objetos
    {// se realiza la consulta
	$Sql="SELECT * FROM competencia WHERE idCompetencia NOT IN (SELECT competencia_idCompetencia FROM puesto_competencia) ORDER BY nombre";
	$resultado = $this->conex->consultaRetorno($Sql);
	$lista = array();
        foreach ($resultado as $row){
            $competencia = new \Models_Entitys\Competencia();
            $competencia->set("codigo", $row["codigo"]);
            $competencia->set("nombre", $row["nombre"]);
            $competencia->set("descripcion", $row["descripcion"]);
            array_push($lista, $competencia);
        }
	return $lista;
    }

    
    public function borrar($p_objeto){}
    public function listar($p_objeto){}
    public function set($p_objeto){}
    public function insert($p_objeto){}   // INSERT
    public function update($p_objeto){}
    public function exists($p_atributo){}

    }

?>