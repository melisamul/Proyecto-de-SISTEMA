<?php namespace Models_DAO;

class PuestoDAO implements \Models_DAO\AdministradorBD {
    private $conex;
    
    public function __construct(){ $this->conex = $GLOBALS['conex']; }
    
    public function get($p_atributo, $p_valor){
        $puesto = new \Models_Entitys\Puesto();
        $sql="SELECT DISTINCT * FROM puesto WHERE $p_atributo=$p_valor";
        $resultado= $this->conex->consultaRetorno($sql);
        if($resultado->num_rows != 0){
            foreach($resultado as $res){
                foreach ($res as $key => $value){
                    $puesto->set($key, $value);
                }
            }
        }
        return $puesto;
    }
    
    public function borrar($codigo){ 
        $sql= "UPDATE `puesto` SET `eliminado` = TRUE WHERE `codigo` = $codigo; ";
        $sql2 = "DELETE FROM `puesto_competencia` WHERE `Puesto_idPuesto` IN (SELECT DISTINCT idPuesto FROM puesto WHERE codigo = $codigo)";
        return array($sql,$sql2);
       }
    
    public function consultarPonderaciones($codigoCompetencia, $codigoPuesto){
        
        $sql="SELECT pc.ponderacion FROM Puesto_Competencia pc "
                . "JOIN puesto p ON (p.idpuesto=pc.puesto_idpuesto) "
                . "JOIN competencia c ON (pc.competencia_idcompetencia=c.idcompetencia) "
                . "WHERE p.codigo = $codigoPuesto AND c.codigo = $codigoCompetencia";
        $resultado = $this->conex->consultaRetorno($sql);
        if($resultado->num_rows != 0 ){
            foreach ($resultado as $res => $valor){
                return $valor['ponderacion'];
            }
        }else {
            return -1;
        }
    }
    public function consultarDatosPuestos($codigo){
        $lista=array(); $list = array();
        
        $sql2= "SELECT p.nombre, p.descripcion, e.nombre AS empresa "
                . "FROM puesto p JOIN empresa e ON (p.idempresa = e.idempresa) WHERE p.codigo = $codigo";
        $descripcion= $this->conex->consultaRetorno($sql2);
        
        if($descripcion->num_rows != 0) {
            foreach ($descripcion as $row){
                \array_push($lista, $row['nombre'], $row['descripcion'], $row['empresa']);
            }
        }
        
        $sql="SELECT c.codigo, c.nombre FROM puesto p "
                . "JOIN Puesto_Competencia pc ON (p.idpuesto = pc.puesto_idpuesto) "
                . "JOIN competencia c ON (pc.competencia_idcompetencia = c.idcompetencia) "
                . "WHERE p.codigo = $codigo ORDER BY c.nombre";
        $resultado = $this->conex->consultaRetorno($sql);
        
        if($resultado->num_rows != 0) {
            foreach ($resultado as $res) {
                $caract = array();
                $caract[0] = $res['codigo'];
                $caract[1] = $res['nombre'];
                \array_push($list, $caract);
            }
        }        
        \array_push($lista, $list);
        return $lista;
    }
        
    public function existeNombre($nombre){
        $existe = false;
        $sql = "SELECT codigo FROM puesto WHERE `nombre` = '$nombre' AND `eliminado` = 0";
	$resultado = $this->conex->consultaRetorno($sql);
        
	if($resultado->num_rows != 0) { $existe = true; }
        return $existe;
    }


    public function exists($data){
        $existe = FALSE;
        $sql = "SELECT codigo FROM puesto WHERE eliminado = 0 "
                . "AND codigo IN (SELECT codigo FROM puesto WHERE codigo = '".$data['codigo']."' OR nombre = '".$data['nombre']."')";
        $resultado = $this->conex->consultaRetorno($sql);
        
        if($resultado->num_rows != 0){
            $existe = TRUE;
        }
	
        return $existe;
    }

    public function insert($p_objeto){ // ver lo de añadir caracteristicas para la competencia
        $empDAO= new \Models_DAO\EmpresaDAO();
        $caractDAO = new \Models_DAO\CaracteristicasDAO();
        $consultas = array(); //Arreglo para juntar todas las SQL y realizarlas en un sola operación ATOMICA
        $codigo=$p_objeto->get("codigo"); $nombre=$p_objeto->get("nombre");
        $descripcion=$p_objeto->get("descripcion"); $empresa = $p_objeto->get("empresa");
        $nomEmpresa = $empresa->get("nombre");
        
        if(($idemp=$empDAO->get_atributo("idEmpresa", $nomEmpresa))!= NULL){ $idempresa=$idemp; }
        
        $caracteristicas=$p_objeto->get("caracteristicas");
        $consultas[] = $sql="INSERT INTO  puesto (codigo, nombre, descripcion,idEmpresa)"
            . "VALUES  ($codigo,'$nombre','$descripcion',$idempresa);";
        
        if(count($caracteristicas)!=0){
            foreach ($caracteristicas as $key => $arreglo){
                /* @var $array type */
                foreach ($arreglo as $clave => $caract){
                    $consultas[] = $caractDAO->generarSql($caract, $codigo);
                }
            }
        }
        $res = $this->conex->generalAtomic($consultas);
        
        return $res;
    }
		
    public function get_atributo($p_atributo, $p_codigo){ 
        $sql = "SELECT $p_atributo FROM puesto WHERE codigo = $p_codigo";
        $res = $this->conex->consultaRetorno($sql);
        if($res->num_rows != 0){
            foreach ($res as $row){
                $resul = $row[$p_atributo];
            }
            return $resul;
        } else {
            return false;
        }
    }

    public function listar($p_arreglo){
        if ($p_arreglo['codigo'] == "") {$codigo = "'%'";} else { $codigo = "'%".$p_arreglo['codigo']."%'";}
	if ($p_arreglo['puesto'] == "") {$puesto = "'%'";} else { $puesto = "'%".$p_arreglo['puesto']."%'";}
	if ($p_arreglo['empresa'] == "") {$empresa = "'%'";} else { $empresa = "'%".$p_arreglo['empresa']."%'";}
        $sql = "SELECT  p.codigo, p.nombre, e.nombre AS empresa "
                . "FROM puesto p JOIN empresa e ON(p.idEmpresa=e.idEmpresa) "
                . "WHERE p.codigo LIKE ".$codigo." AND p.nombre LIKE ".$puesto." AND e.nombre LIKE ".$empresa." AND p.eliminado = 0";
	$retornoConsul = $this->conex->consultaRetorno($sql);
        $lista = array();
        foreach ($retornoConsul as $key => $value){
            $lista[$key] = $value;
	}
        return $lista;
    }
    
    public function listarpuestosev($p_arreglo){
        if ($p_arreglo['codigo'] == "") {$codigo = "'%'";} else { $codigo = "'%".$p_arreglo['codigo']."%'";}
	if ($p_arreglo['puesto'] == "") {$puesto = "'%'";} else { $puesto = "'%".$p_arreglo['puesto']."%'";}
	if ($p_arreglo['empresa'] == "") {$empresa = "'%'";} else { $empresa = "'%".$p_arreglo['empresa']."%'";}
        $sql = "SELECT  p.codigo, p.nombre, e.nombre AS empresa 
                FROM puesto p JOIN empresa e ON (p.idEmpresa=e.idEmpresa) 
                WHERE p.codigo LIKE ".$codigo." 
                AND p.nombre LIKE ".$puesto." 
                AND e.nombre LIKE ".$empresa." 
                AND p.eliminado = 0 
                AND p.idpuesto IN ( 
                SELECT c.idpuesto 
                FROM cuestionario c 
                JOIN cuestionario_has_estado ce ON (ce.cuestionario_idcuestionario = c.idcuestionario) 
                JOIN estado e ON (e.idestado = ce.estado_idestado) 
                WHERE e.tipo = 'FINALIZADO' 
                )";
	$retornoConsul = $this->conex->consultaRetorno($sql);
        if($retornoConsul->num_rows != 0){
            return $retornoConsul;
        } else {
            return FALSE;
        }
    }
    
    public function contarCandidatos($codigo){
        //cuenta la cantidad de candidatos para el puesto 
        $sql="SELECT COUNT(c.idcandidato) AS cantidad FROM candidato c "
                . "JOIN cuestionario cuest ON (c.idcandidato = cuest.idcandidato) "
                . "JOIN puesto p ON (cuest.idpuesto = p.idpuesto) WHERE p.codigo = $codigo";
        $cantidadcandidatos=$this->conex->consultaRetorno($sql);
        if($cantidadcandidatos->num_rows != 0){
            foreach ($cantidadcandidatos as $cand) {
                return $cand['cantidad'];
            }
        } else {
            return FALSE;
        }
    }
    
    public function contarCuestionarios($codigo){
        //cuenta la cantidad de cuestionarios para el puesto
        $sql="SELECT COUNT(DISTINCT cuest.fecha_de_creacion) AS cantidad "
                . "FROM cuestionario cuest JOIN puesto p ON (cuest.idpuesto = p.idpuesto) "
                . "JOIN cuestionario_has_estado che ON (cuest.idcuestionario = che.cuestionario_idcuestionario) "
                . "JOIN estado e ON (che.estado_idestado = e.idestado) WHERE p.codigo = $codigo AND e.tipo = 'finalizado'";
        $cantidadcuestionarios= $this->conex->consultaRetorno($sql);
        if($cantidadcuestionarios->num_rows != 0){
            foreach ($cantidadcuestionarios as $cant){
                return $cant['cantidad'];
            }
        } else {
            return FALSE;
        }
    }
    
    public function update($p_objeto){
        $empDAO= new \Models_DAO\EmpresaDAO();
        $caractDAO = new \Models_DAO\CaracteristicasDAO();

        $consultas = array(); //Arreglo para juntar todas las SQL y realizarlas en un sola operación ATOMICA
        
        $codigo=$p_objeto->get("codigo"); 
        $nombre=$p_objeto->get("nombre");
        $descripcion=$p_objeto->get("descripcion"); 
        $empresa = $p_objeto->get("empresa");
        $nomEmpresa = $empresa->get("nombre");
        
        $idPuesto = $this->get_atributo("idPuesto", $codigo);
        
        if(($idemp=$empDAO->get_atributo("idEmpresa", $nomEmpresa))!= NULL){
            $idempresa=$idemp;
        }
        $caracteristicas=$p_objeto->get("caracteristicas");
        $consultas[] = "UPDATE puesto SET codigo=$codigo, nombre='$nombre', descripcion='$descripcion',"
                    . " idEmpresa=$idempresa WHERE idPuesto = $idPuesto;";
        
        if(count($caracteristicas)!=0){
            foreach ($caracteristicas as $key => $arreglo){      
                switch($key) {
                    case 'modificados':
                        foreach ($arreglo as $clave => $caract) {
                            $param = ['caracteristica' => $caract, 'id' =>  $idPuesto,];
                            $sql = $caractDAO->update($param);
                            $consultas[] = $sql;
                        }
                        break;
                    case 'eliminados':
                        foreach ($arreglo as $clave => $caract) {
                            $param = ['caracteristica' => $caract, 'id' =>  $idPuesto,];
                            $sql = $caractDAO->borrar($param);
                            $consultas[] = $sql;
                        }
                        break;
                    case 'nuevos':
                        foreach ($arreglo as $clave => $caract) {
                            $param = ['caracteristica' => $caract, 'codigo' =>  $codigo,];
                            $sql = $caractDAO->insert($param);
                            $consultas[] = $sql;
                        }
                        break;
                    default:
                        break;
                }
            }
        }
        $res = $this->conex->generalAtomic($consultas);
        
        return $res;
    }
    
    public function listAll() {
        $empresaDAO = new \Models_DAO\EmpresaDAO();
        $Sql="SELECT codigo, nombre, descripcion, idEmpresa FROM puesto WHERE eliminado = 0";
        $resultado = $this->conex->consultaRetorno($Sql);
			
        $lista = array();
        if($resultado->num_rows != 0){
            foreach ($resultado as $arreglo){
                foreach ($arreglo as $key => $valor){
                    if($key == 'codigo'){
                        $puesto = new \Models_Entitys\Puesto();
                    }

                    $puesto->set($key, $valor);

                    if($key == 'idEmpresa'){
                        $empresa = $empresaDAO->get('idEmpresa', $valor);
                        $puesto->set('empresa', $empresa);
                        \array_push($lista, $puesto);
                    }
                    $puesto->mapeador();
                }
            }
        }
        return $lista;
    }
    
    public function set($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; }// BUSCAR
    
    } 

?>