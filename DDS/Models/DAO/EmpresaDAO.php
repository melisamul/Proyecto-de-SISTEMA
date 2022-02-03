<?php namespace Models_DAO;

class EmpresaDAO implements \Models_DAO\AdministradorBD {
    private $conex;
    public function __construct(){ $this->conex = $GLOBALS['conex']; }
    
    public function borrar($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; } //metodo que recibe un INSTANCIA de una ENTITY del sistema. Debe eliminar dicha entida de la BD
    public function listar($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; } //
    public function update($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; }
    public function exists($p_atributo){ echo "<br>METODO NO IMPLEMENTADO ".$p_atributo; }
    public function set($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; }// BUSCAR
    public function insert($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; }   // INSERT
    
    public function get($p_atributo, $p_valor){
        $empr = new \Models_Entitys\Empresa();
        
        $sql="SELECT DISTINCT * FROM empresa WHERE $p_atributo='$p_valor'";			
        $resultado= $this->conex->consultaRetorno($sql);
        
        if($resultado->num_rows != 0){
            foreach($resultado as $value){
                foreach ($value as $atributo => $valor){
                    $empr->set($atributo, $valor);
                }
            }
            
            return $empr;
        }
        else{ return false; }
    }

    public function devolver($p_valor){
        $empr = new \Models_Entitys\Empresa();
        
        $sql="SELECT DISTINCT e.nombre, e.telefono, e.contacto, e.direccion "
                . "FROM empresa e JOIN puesto p ON (p.idEmpresa = e.idEmpresa) WHERE p.codigo='$p_valor'";			
        $resultado= $this->conex->consultaRetorno($sql);
        
        if($resultado->num_rows != 0){
            foreach($resultado as $value){
                foreach ($value as $atributo => $valor){
                    $empr->set($atributo, $valor);
                }
            }
            return $empr;
        }
        else{ return false; }
    }
    
    public function get_atributo($p_atributo, $p_nombre){ 
        $sql = "SELECT $p_atributo FROM empresa WHERE nombre = '$p_nombre'";
        $res = $this->conex->consultaRetorno($sql);
        foreach ($res as $valor){
                $resul = $valor[$p_atributo];
            }
        return $resul; 
    }

    public function listAll()//devuelve un arreglo de objetos
    {// se realiza la consulta
        $Sql="SELECT DISTINCT * FROM empresa";
        $resultado = $this->conex->consultaRetorno($Sql);
			
        $lista = array();
        foreach ($resultado as $row){
            $empresa = new \Models_Entitys\Empresa();
            $empresa->set("nombre", $row["nombre"]);
            $empresa->set("telefono", $row["telefono"]);
            $empresa->set("contacto", $row["contacto"]);
            $empresa->set("direccion", $row["direccion"]);
            array_push($lista, $empresa);
        }
        return $lista;
    }
}

?>