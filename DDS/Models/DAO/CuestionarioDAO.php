<?php namespace Models_DAO;

class CuestionarioDAO implements \Models_DAO\AdministradorBD {
    
    private $conex;
    
    public function __construct() { $this->conex = $GLOBALS['conex']; }
    
    public function borrar($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; } //metodo que recibe un INSTANCIA de una ENTITY del sistema. Debe eliminar dicha entida de la BD
    public function listar($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; } //
    public function get_atributo($p_atributo, $p_parametro){ echo "<br>METODO NO IMPLEMENTADO ".$p_atributo." ".$p_parametro; }
    public function get($p_atributo, $p_parametro){ echo "<br>METODO NO IMPLEMENTADO ".$p_atributo." ".$p_parametro; }// BUSCAR
    public function exists($p_atributo){ echo "<br>METODO NO IMPLEMENTADO ".$p_atributo; }
    public function set($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; }// BUSCAR
    public function insert($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; }
    
    public function update($p_cuestionario){ 
        
        $sql_c = "UPDATE `cuestionario` SET `cantidad_accesos`= ".$p_cuestionario->get('cantidad_accesos').", "
                . "`ultimo_acceso`= '".$p_cuestionario->get('ultimo_acceso')."' WHERE `clave` = '".$p_cuestionario->get('clave')."';";
        
        $datos = $p_cuestionario->ultimoEstadoyFecha();
        
        $sql_i = "INSERT INTO `cuestionario_has_estado`(`Cuestionario_idCuestionario`, `Estado_idEstado`, `fechayhora`) 
                    SELECT c.idCuestionario, e.idEstado, '$datos[1]' 
                    FROM cuestionario c, estado e
                    WHERE c.clave = '".$p_cuestionario->get('clave')."' AND e.tipo = '".$datos[0]->get('estado')."';";
        
        $consultas = array($sql_c,$sql_i);
        
        return $this->conex->generalAtomic($consultas);
    }
    
    public function cantidad_bloque_cuestionario($clave) {
        $sql = "SELECT COUNT(idBloque) AS cantidad
                FROM `cuestionario` c 
                JOIN `bloque` b ON (c.idcuestionario = b.idcuestionario)
                WHERE c.clave = '$clave';";
        $retorno = $this->conex->consultaRetorno($sql);
        if($retorno->num_rows != 0){
            foreach ($retorno as $res) {
                return $res['cantidad'];
            }
        } else {
            return FALSE;
        }
    }
    
    
    public function listarCuestionarios($codigo){ //lista todos lso cuestionarios asociados a un puesto
        
        $sql="SELECT c.* "
                . "FROM cuestionario c "
                . "JOIN puesto p ON (p.idpuesto=c.idpuesto) WHERE p.codigo= $codigo;";
        $retorno = $this->conex->consultaRetorno($sql);
        $array= array();
        if($retorno->num_rows != 0){
            foreach ($retorno as $key){
                $cuestionario= new \Models_Entitys\Cuestionario();
                foreach ($key as $atributo => $valor) {
                    $cuestionario->set($atributo, $valor);
                    if ($atributo == 'clave'){
                        $estados = $this->retornarEstados($valor);
                        $cuestionario->set('cambiosEstado', $estados);
                    }
                }
                \array_push($array,$cuestionario);
            }
                    
            return $array;
        }else {
            return false;
        }
    }
    
    public function cantidadPreguntasEnCuestionario($p_clave) {
        $sql = "SELECT count(preguntas) as cantidad 
                FROM (SELECT pe.idpregunta_evaluada as preguntas
                FROM `cuestionario` c
                JOIN bloque b ON (c.idcuestionario=b.idcuestionario)
                JOIN `pregunta evaluada` pe ON (pe.idbloque = b.idbloque)
                WHERE c.clave= '$p_clave') T1";
        $retorno = $this->conex->consultaRetorno($sql);
        if($retorno->num_rows != 0){
            foreach ($retorno as $res){
                return $res['cantidad'];
            }
        } else {
            return 0;
        }
    }

    public function guardar_respuestas($p_arreglo, $num_bq, $p_clave) {
        $consultas = array();
        foreach ($p_arreglo as $row) {
            $sql = $this->generarSql_respuestas($row, $num_bq, $p_clave);
            \array_push($consultas, $sql);
        }
        $resp = $this->conex->generalAtomic($consultas);
        return $resp;
    }
    
    public function generarSql_respuestas($p_arreglo, $num_bq, $p_clave) {
        
        $sql = "UPDATE  `opcion evaluada` SET  `valor_elegido` = ( 
                SELECT TRUE 
                FROM cuestionario c 
                JOIN bloque b ON (c.idCuestionario = b.idCuestionario) 
                JOIN  `pregunta evaluada` pe ON (b.idbloque = pe.idbloque) 
                WHERE c.clave = '$p_clave' 
                AND b.numero = $num_bq 
                AND pe.codigo = $p_arreglo[0])
                WHERE nombre = '$p_arreglo[1]' 
                AND idPregunta_Evaluada IN (
                SELECT idPregunta_Evaluada 
                FROM cuestionario c 
                JOIN bloque b ON (c.idCuestionario = b.idCuestionario) 
                JOIN  `pregunta evaluada` pe ON (b.idbloque = pe.idbloque) 
                WHERE c.clave = '$p_clave' 
                AND b.numero = $num_bq 
                AND pe.codigo = $p_arreglo[0])";              
        return $sql;        
    }


    public function comprobarTiempoActivo($p_clave) {
        $sql = "SELECT CASE (s.tiempo_activo >= (SELECT TO_DAYS(CURDATE()) - TO_DAYS(ce.fechayhora) "
                . "FROM cuestionario c JOIN cuestionario_has_estado ce ON (ce.`Cuestionario_idCuestionario` = c.`idCuestionario`) "
                . "WHERE c.clave = '$p_clave' AND ce.`Estado_idEstado` = 1)) "
                . "WHEN 1 THEN TRUE ELSE FALSE END AS RES "
                . "FROM sys_param s;";
        $respuesta = $this->conex->consultaRetorno($sql);
        if($respuesta->num_rows != 0){
            $row = $respuesta->fetch_array(MYSQLI_ASSOC);
            if($row['RES'] == TRUE){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return 3;
        }
    }
    
    public function get_cuestionario($clave){
        //FUNCION QUE DEVUELVE UN CUESTIONARIO
        $cuestionario= new \Models_Entitys\Cuestionario();
        $sql = "SELECT DISTINCT c.* FROM `sys_param` s, cuestionario c "
                . "JOIN cuestionario_has_estado ce ON (ce.cuestionario_idcuestionario = c.idcuestionario) "
                . "JOIN estado e ON (e.idestado = ce.estado_idestado) "
                . "WHERE c.clave = '$clave' "
                . "AND s.duracion_evaluacion >= (SELECT TO_DAYS(CURDATE()) - TO_DAYS(c.fecha_de_creacion) "
                . "FROM cuestionario c WHERE c.clave = '$clave');";
        $retorno = $this->conex->consultaRetorno($sql);
        if ($retorno->num_rows != 0) {
            foreach ($retorno as $row) {
                foreach ($row as $key => $value) {
                    $cuestionario->set($key, $value);
                }
            }
            $cuestionario->mapear();
            return $cuestionario;
        } else {
            return FALSE;
        }
    }
    
    public function instrucciones() {
        $sql = "SELECT instruccion_cuestionario FROM sys_param;";
        $retorno= $this->conex->consultaRetorno($sql);
        
        if($retorno->num_rows != 0){
            foreach ($retorno as $row) {
                return $row['instruccion_cuestionario'];
            }
        } else {
            return FALSE;
        }
        
    }
    
    public function inserts(\Models_Entitys\Cuestionario $p_cuestionario, $p_codigoPuesto){ 
        $fecha = $p_cuestionario->get("fecha_de_creacion");
        $candidato = $p_cuestionario->get("candidato");
        $instruc = $p_cuestionario->get("instrucciones");
        $accesos = $p_cuestionario->get("cantidad_accesos");
        $clave = $p_cuestionario->get("clave");
        
        $sql = "INSERT INTO cuestionario (fecha_de_creacion, idPuesto, idCandidato, instrucciones, cantidad_accesos, clave) "
                . "SELECT '$fecha', p.idPuesto, c.idCandidato, '$instruc', $accesos, '$clave' "
                . "FROM puesto p, candidato c "
                . "WHERE p.codigo = $p_codigoPuesto AND c.nroCandidato = ".$candidato->get('nrocandidato')."; ";
    
        return $sql;
        
    }   // INSERT
    
    private function generarSql_Bloque($p_bloque, $claveCuest){ 
        $DAoPreguntaEv = new \Models_DAO\PreguntaEvaluadaDAO();
        $nro = $p_bloque->get('numero');
        $preguntas = $p_bloque->get('preguntas');
        
        $retorno = [];
        $sql_bloque = "INSERT INTO `bloque`(`numero`, `idCuestionario`) "
                . "SELECT $nro, c.idCuestionario FROM cuestionario c WHERE c.clave = '".$claveCuest."'; ";
        \array_push($retorno, $sql_bloque);
        
        $contador = 0;
        while(count($preguntas) > $contador) {
            $codigo = $preguntas[$contador]->get('codigo');
            $sql = "UPDATE `pregunta evaluada` SET `orden_enBloque` = $nro, `idBloque` = 
                    (SELECT MAX(b.idBloque) FROM bloque b 
                    JOIN cuestionario c ON (c.idCuestionario = b.idCuestionario) WHERE c.clave = '$claveCuest') 
                    WHERE `idpregunta_evaluada` IN (
                    SELECT * FROM
                    (
                        SELECT MAX(`idpregunta_evaluada`)
                        FROM `pregunta evaluada`
                        WHERE codigo = $codigo
                        ) AS subquery
                    )";
            \array_push($retorno, $sql);
            $contador++;
            
        }
        
        return $retorno;
    }

    public function generarSql($p_cuestionario, $p_codigoPuesto) {
        $competenciaEvDAO = new \Models_DAO\CompetenciaEvaluadaDAO();
        $estadoDAO = new \Models_DAO\EstadoDAO();
        $retorno = array();
        
        $consulta1 = $this->inserts($p_cuestionario, $p_codigoPuesto);
        \array_push($retorno, $consulta1);
        
        $listCompetenciasEv = $p_cuestionario->get('competenciasEvaluadas');
        $listBloques = $p_cuestionario->get('ultimo_bloque_accedido'); 
        foreach ($listCompetenciasEv as $compEv) {
            $consulta = $competenciaEvDAO->generarSql($compEv, $p_cuestionario->get('clave'));
            $retorno = \array_merge($retorno, $consulta);
        }
        $contador = 0;
        while(count($listBloques) > $contador){ 
            $consulta2 = $this->generarSql_Bloque($listBloques[$contador], $p_cuestionario->get('clave'));
            $retorno = \array_merge($retorno, $consulta2);
            $contador++;
        }
        
        $consulta3 = $estadoDAO->set(array('clave' => $p_cuestionario->get('clave'), 'estado' => $p_cuestionario->get('cambiosEstado')));
        \array_push($retorno, $consulta3);
        
        return $retorno;
    }


    public function getCuestionariosActivos($clave){
               
        $cuestionario = new \Models_Entitys\Cuestionario();
        
        $sql = "SELECT fecha_de_creacion, instrucciones, cantidad_accesos, clave, ultimo_acceso "
                . "FROM cuestionario WHERE clave = '$clave' AND idCuestionario "
                . "NOT IN (SELECT Cuestionario_idCuestionario "
                . "FROM cuestionario_has_estado "
                . "WHERE Estado_idEstado IN (SELECT idEstado "
                . "FROM estado WHERE tipo = 'INCOMPLETO' OR tipo = 'FINALIZADO'));";
        
        $retorno = $this->conex->consultaRetorno($sql);
        
        if($retorno->num_rows != 0){
            foreach ($retorno as $array){
                foreach ($array as $atributo => $valor) {
                    $cuestionario->set($atributo, $valor);
                }
            }
            $bloque = $this->retornarUltimoBloqueAccedido($clave);
            $cuestionario->set('ultimo_bloque_accedido', $bloque);
            return $cuestionario;
        }else {
            return false;
        }
    }
    
    public function retornarUltimoBloqueAccedido($clave, $listaPreg){
        $bloque= new \Models_Entitys\Bloque();
        $preg_evDAO = new \Models_DAO\PreguntaEvaluadaDAO();
        
        $sql="SELECT MIN( b.idBloque ) AS idBloque, b.numero
                FROM  `bloque` b
                JOIN  `cuestionario` c ON ( b.idCuestionario = c.idCuestionario ) 
                WHERE c.clave =  '$clave'
                AND b.idBloque NOT IN (
                SELECT b.idBloque
                FROM  `pregunta evaluada` p
                JOIN  `bloque` b ON ( p.idBloque = b.idBloque ) 
                JOIN  `opcion evaluada` op ON ( op.idPregunta_Evaluada = p.idPregunta_Evaluada ) 
                JOIN  `cuestionario` c ON ( b.idCuestionario = c.idCuestionario ) 
                WHERE op.valor_elegido = TRUE AND c.clave = '$clave'
                )
                ";
        
         $result= $this->conex->consultaRetorno($sql);
         if($result->num_rows != 0){
            $idbloque = NULL;
            foreach ($result as $res) {
                foreach ($res as $key => $value) {
                    $bloque->set($key, $value);
                    if($key == 'idBloque'){
                        $idbloque=$value;
                    }
                }
            }
            if($idbloque != NULL){
                $preguntas = $preg_evDAO->recuperarPreguntasEvaluadas($idbloque, $listaPreg);
                $bloque->set('preguntas', $preguntas); 
            }
            return $bloque;
         } else { return false; }
    }
    
    
    public function consultarFechacuestionario($codigo){
        $sql="SELECT DISTINCT fecha_de_creacion FROM cuestionario cu "
                . "JOIN puesto p ON (p.idpuesto=cu.idpuesto) "
                . "JOIN cuestionario_has_estado che ON (cu.idcuestionario=che.cuestionario_idcuestionario) "
                . "JOIN estado e ON (che.estado_idestado=e.idestado) "
                . "WHERE p.codigo=$codigo and e.tipo='finalizado';";
        $result= $this->conex->consultaRetorno($sql);
        return $result;
    }
    public function consultarfechaFin($cuestionario_clave){
        
        $sql="SELECT che.fechayhora FROM cuestionario cu "
                . "JOIN cuestionario_has_estado che  ON (cu.idcuestionario=che.cuestionario_idcuestionario) "
                . "JOIN estado e ON (che.estado_idestado=e.idestado) WHERE cu.clave = '$clave' AND e.tipo='completo';";
        $resultado=$this->conex->consultaRetorno(sql);
        return $resultado;
        
    }
    
    public function retornarEstados($p_clave){ 
        $sql = "SELECT ce.fechayhora, e.tipo FROM cuestionario_has_estado ce "
                . "JOIN cuestionario c ON (c.idcuestionario = ce.cuestionario_idcuestionario) "
                . "JOIN estado e ON (e.idestado = ce.estado_idestado) WHERE c.clave = '$p_clave';";
        
        $resultado = $this->conex->consultaRetorno($sql);
        if($resultado->num_rows != 0){
            $lista = array();
            foreach ($resultado as $res) {               
                $estado = new \Models_Entitys\Estado();
                $estado->set('tipo', $res['tipo']);
                $fecha = new \Models_Entitys\fechaEstado();
                $fecha->set('fechayhora', $res['fechayhora']);
                $fecha->set('estado', $estado);
                \array_push($lista, $fecha);
            }
            return $lista;
        } else {
            return FALSE;
        }
    }
     ////////// CDU 028
    public function retornarCuestionario($nrocandidato,$codigo, $fecha){ 
        $cuestionario= new \Models_Entitys\Cuestionario();
        $sql="SELECT cu.fecha_de_creacion, cu.instrucciones, cu.cantidad_accesos, cu.clave, cu.ultimo_acceso "
                . "FROM cuestionario cu JOIN candidato ca ON ( ca.idcandidato = cu.idcandidato ) "
                . "JOIN puesto p ON ( cu.idpuesto = p.idpuesto ) WHERE ca.nrocandidato = $nrocandidato "
                . "AND p.codigo = $codigo AND cu.fecha_de_creacion = '$fecha';";
        
        $resultado=$this->conex->consultaRetorno($sql);
        
        if($resultado->num_rows != 0){
            foreach ($resultado as $res) {
                foreach ($res as $key => $value) {
                    $cuestionario->set($key, $value);
                }
            }
            $cuestionario->mapear();
            return $cuestionario;
        } else {
            return FALSE;
        }
    }
    public function consultarPenultimoEstado($clave){
        $sql="SELECT e.tipo FROM `cuestionario_has_estado` ce "
                . "JOIN estado e ON (ce.estado_idEstado=e.idEstado) "
                . "JOIN cuestionario c ON (c.idcuestionario = ce.cuestionario_idcuestionario) "
                . "WHERE  c.clave = '$clave' AND ce.estado_idEstado IN (SELECT MAX(estado_idEstado) "
                . "FROM `cuestionario_has_estado` WHERE estado_idEstado <> 6);";
        $resultado=$this->conex->consultaRetorno($sql);
        if($resultado->num_rows != 0){
            foreach ($resultado as $key ) {
                $preEstado=$key['tipo'];
            }
            return $preEstado;
        } else {
            return FALSE;
        }
    }
    
    public function consultarFechaFinCuestionario($clave){
        $sql="SELECT ce.`fechayhora` FROM `cuestionario_has_estado` ce "
                . "JOIN estado e ON (e.idEstado = ce.estado_idestado) "
                . "JOIN cuestionario c ON (c.idCuestionario = ce.cuestionario_idcuestionario) "
                . "WHERE c.clave = '$clave' AND e.tipo ='completo';";
        $resultado=$this->conex->consultaRetorno($sql);
        foreach($resultado as $row){
            $fecha=$row['fechayhora'];
        }
        return $fecha;
    }

    public function retornarcandidatos($fecha_creacion,$codigo){
        
        $sql = "SELECT ca.apellido, ca.nombre, ca.nrodocumento, ca.fecha_de_nacimiento, ca.nrocandidato, "
                . "ca.genero, ca.nacionalidad, ca.email, ca.escolaridad, td.tipo as tipodocumento "
                . "FROM candidato ca JOIN cuestionario cu ON ( ca.idcandidato = cu.idcandidato ) "
                . "JOIN tipodocumento td ON ( ca.idtipodocumento = td.iddocumento ) "
                . "JOIN puesto p ON ( cu.idpuesto = p.idpuesto ) "
                . "WHERE cu.fecha_de_creacion = '$fecha_creacion' AND p.codigo = $codigo;";
        
        $result = $this->conex->consultaRetorno($sql);
        $listacandidatos = array();
        if($result->num_rows != 0){
            foreach($result as $res ){
                $candidato = new \Models_Entitys\Candidato();
                foreach ($res as $key => $value){
                    $candidato->set($key, $value);
                }
                \array_push($listacandidatos, $candidato);
            }
            return $listacandidatos;
        } else {
            return FALSE;
        }
    }
}


?>