<?php namespace Models_DAO;

class CaracteristicasDAO implements \Models_DAO\AdministradorBD {
    private $conex;
    public function __construct(){ $this->conex = $GLOBALS['conex']; }
    
    public function listar($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; } //
    public function get_atributo($p_atributo, $p_parametro){ echo "<br>METODO NO IMPLEMENTADO ".$p_atributo." ".$p_parametro; }
    public function set($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; }// BUSCAR
    public function exists($p_atributo){ echo "<br>METODO NO IMPLEMENTADO ".$p_atributo; }
    
    public function guardarCaracteristicas($caracteristica,$idPuesto){
        
        $compDAO=new \Models_DAO\CompetenciaDAO();
        
        $competencia = $caracteristica->get("competencia");
        $codigoComp = $competencia->get("codigo");
	
        $idComp = $compDAO->get_atributo("idCompetencia", $codigoComp);
        
        $valor= $caracteristica->get("valor");
	
        $sql="INSERT INTO puesto_competencia (ponderacion,Competencia_idCompetencia,Puesto_idPuesto) "
                . "VALUES ($valor, $idComp, $idPuesto)";
        
	$this->conex->consultaSimple($sql);
        
        return 0;
    } 
    
    public function generarSql($caracteristica, $p_codigo){
        
        $compDAO=new \Models_DAO\CompetenciaDAO();
        
        $competencia = $caracteristica->get("competencia");
        $codigoComp = $competencia->get("codigo");
	
        $idComp = $compDAO->get_atributo("idCompetencia", $codigoComp);
        
        $valor= $caracteristica->get("valor");
	
        $sql="INSERT INTO puesto_competencia (ponderacion,Competencia_idCompetencia,Puesto_idPuesto) "
                . "SELECT $valor, $idComp, p.idPuesto FROM puesto p WHERE p.codigo = $p_codigo;";
        
	
        return $sql;
    } 

    public function borrar($p_arreglo){
        
        $compDAO=new \Models_DAO\CompetenciaDAO();
        
        $caracteristica = $p_arreglo['caracteristica'];
        $idPuesto = $p_arreglo['id'];
        
        $competencia = $caracteristica->get("competencia");
        $codigoComp = $competencia->get("codigo");
	
        $idComp = $compDAO->get_atributo("idCompetencia", $codigoComp);
	
        $sql = "DELETE FROM puesto_competencia WHERE Competencia_idCompetencia = $idComp AND Puesto_idPuesto = $idPuesto;";
        
        return $sql;
        
    }
    
    public function insert($p_arreglo){
        
        $compDAO=new \Models_DAO\CompetenciaDAO();
        
        $caracteristica = $p_arreglo['caracteristica'];
        $p_codigo = $p_arreglo['codigo'];
        
        $competencia = $caracteristica->get("competencia");
        $codigoComp = $competencia->get("codigo");
	
        $idComp = $compDAO->get_atributo("idCompetencia", $codigoComp);
        
        $valor= $caracteristica->get("valor");
	
        $sql="INSERT INTO puesto_competencia (ponderacion,Competencia_idCompetencia,Puesto_idPuesto) "
                . "SELECT $valor, $idComp, p.idPuesto FROM puesto p WHERE p.codigo = $p_codigo;";
        
        return $sql;
    }
    
    public function update($p_arreglo){
        
        $compDAO=new \Models_DAO\CompetenciaDAO();
        
        $caracteristica = $p_arreglo['caracteristica'];
        $idPuesto = $p_arreglo['id'];
        
        $competencia = $caracteristica->get("competencia");
        $codigoComp = $competencia->get("codigo");
	
        $idComp = $compDAO->get_atributo("idCompetencia", $codigoComp);
        
        $valor= $caracteristica->get("valor");
	
        $sql = "UPDATE puesto_competencia SET ponderacion = $valor "
                . "WHERE Competencia_idCompetencia = $idComp "
                . "AND Puesto_idPuesto = $idPuesto;";
        return $sql;
    }
    
    public function get($p_atributo, $p_parametro) {
        
        $sql = "SELECT c.codigo, c.nombre, c.descripcion, pc.ponderacion FROM puesto_competencia pc "
                . "JOIN puesto p ON (p.idPuesto = pc.Puesto_idPuesto) "
                . "JOIN competencia c ON (c.idCompetencia = pc.Competencia_idCompetencia) "
                . "WHERE p.$p_atributo = '$p_parametro'";
        
        $resultado = $this->conex->consultaRetorno($sql);
        
        if($resultado != 0) {
            $lista = array();
            foreach ($resultado as $key => $valor){
                if($key == 'codigo'){
                    $caract = new \Models_Entitys\Caracteristica();
                    $comp = new \Models_Entitys\Competencia();
                }

                if($key == 'ponderacion'){
                    $caract->set($key, $valor);
                    $caract->set('competencia', $comp);
                    \array_push($lista, $caract);
                } else {
                    $comp->set($key, $valor);
                }
            }
            return $lista;
        } else {
            return FALSE;
        }
    }
    
    public function devolver($p_codigo) {
        
        $lista = array();
        
        $sql = "SELECT c.codigo, c.nombre, c.descripcion, pc.ponderacion "
                . "FROM puesto p JOIN puesto_competencia pc ON ( p.idPuesto = pc.Puesto_idPuesto ) "
                . "JOIN competencia c ON (pc.Competencia_idCompetencia = c.idCompetencia ) "
                . "WHERE p.codigo =$p_codigo";
        
        $resultado = $this->conex->consultaRetorno($sql);
        
        if($resultado->num_rows != 0){
            foreach ($resultado as $res) {
                $caract = new \Models_Entitys\Caracteristica();
                $comp = new \Models_Entitys\Competencia();
                foreach ($res as $key => $value) {
                    if($key != 'ponderacion') {
                        $comp->set($key, $value);
                    }
                    else { 
                        $caract->set('ponderacion', $value); 
                    }
                }
                $comp->mapear();
                $caract->set('competencia', $comp);
                \array_push($lista, $caract);
            }
        }
        
        return $lista;
    }
    }
?>