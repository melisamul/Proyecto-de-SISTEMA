<?php namespace Controllers;

class GestorPuestos{
    public function __construct(){ }
    
    public function comprobarPuestoEliminar($codigo){
        $puestoDAO = new \Models_DAO\PuestoDAO();
        $puesto=$puestoDAO->get('codigo',$codigo);
        
        $resp = $puesto->poseeEvaluacionesActivas();
        
        return $resp;
        
    }
    
    public function eliminameElPuesto($codigo){
        //echo '<script type="text/javascript">alert("'.$codigo.'")</script>';
        $puestoDAO = new \Models_DAO\PuestoDAO();
        $auditor= new \Controllers\GestorAuditor();
        
        $puesto=$puestoDAO->get('codigo',$codigo);
        $resp = $puesto->poseeEvaluacionesActivas();
        if($resp == FALSE){
            $puesto->set("eliminado", TRUE);
        }
        return $auditor->registrarEliminacion($puesto);
    }
    
    public function buscarPuestosEv(){
        $entrada = $_POST;
        $puestoDAO = new \Models_DAO\PuestoDAO();
        
        $respuesta = $puestoDAO->listarpuestosev($entrada);
        if($respuesta != FALSE){
            $listaRetorno = array();
            foreach ($respuesta as $res) {
                $listP = array();
                $cantCand = $puestoDAO->contarCandidatos($res['codigo']);
                $cantCuest = $puestoDAO->contarCuestionarios($res['codigo']);
                \array_push($listP, $res['codigo']);
                \array_push($listP, $res['nombre']);
                \array_push($listP, $res['empresa']);
                \array_push($listP, $cantCand);
                \array_push($listP, $cantCuest);
                \array_push($listaRetorno, $listP);
            }
        } else { return 2; }
        
        //CODIFICO EL RESULTADO Y LO ENVIO
	$result=serialize($listaRetorno);
	$resul=urlencode($result);
        header("Location: //localhost/DDS/Orden/ordenMerito?valor=".$resul);
        
        return TRUE;
        
    }
    
    
    public function recuperarEmpresas(){
        $empDAO = new \Models_DAO\EmpresaDAO();
        $retorno = $empDAO->listAll();
        $listaNombres = [];
        /* @var $key type string */
        foreach ($retorno as $key => $value) {
            $listaNombres[] = $value->get("nombre");
        }
        return $listaNombres;
    }
    
    public function recuperaUnaEmpresa(\Models_Entitys\Puesto $param) {
        $empDAO = new \Models_DAO\EmpresaDAO();
        $idEmpresa = $param->get('empresa');
        
        if(is_int($idEmpresa)){
            $empresa = $empDAO->get('idEmpresa', $idEmpresa);
            $param->set('empresa', $empresa);
        }
    }
    
    public function recuperaUnPuesto($p_codigo) {
        $puestoDAO = new \Models_DAO\PuestoDAO();
        $puesto = $puestoDAO->get('codigo', $p_codigo);
        $puesto->mapeador();
        return $puesto;
    }
    
    public function recuperarPuestos(){
        $puestoDAO = new \Models_DAO\PuestoDAO();
        $retorno = $puestoDAO->listAll();
        return $retorno;
    }
    
    public function recuperarCaracteristicas($param) {
        $caractDAO = new \Models_DAO\CaracteristicasDAO();
        
        if(is_null($param->get('caracteristicas'))){
            $listcaract = $caractDAO->get('codigo', $param->get('codigo'));
            $param->set('caracteristicas', $listcaract);
        }
    }
    
    public function recuperarCuestionarios($param) {
        $cuestDAO = new \Models_DAO\CuestionarioDAO();
        
        if(is_null($param->get('cuestionarios'))){
            $listcuest = $cuestDAO->get('codigo', $param->get('codigo'));
            $param->set('cuestionarios', $listcuest);
        }
    }
    
    public function buscarPuestos($entrada){
        $puestoDAO = new \Models_DAO\PuestoDAO();
        $validacion = "FALSE";
	$respuesta = $this->validarDatos($entrada);
        foreach ($respuesta as $key => $value){
            if($value == "TRUE"){ $validacion = "TRUE"; }
        }
        if($validacion == "TRUE"){ $listPuestos = $puestoDAO->listar($entrada); }
        else { echo "<br>No fueron superadas las validaciones<br>"; }
	
        return $listPuestos;
    }
    
    public function recuperarDatosPuesto($codigo){
        $puestoDAO = new \Models_DAO\PuestoDAO();
        $datos= $puestoDAO->consultarDatosPuestos($codigo);
        // datos es un array que contiene como primer elemento la descripciond el puesto y segundo elemento una lista de listas, que contienen los campos nombre y codigo de competencias asociadas al puesto
        return $datos;
    }
    
    public function recuperarPonderacion($codigoCompetencia, $codigoPuesto){
        $puestoDAO = new \Models_DAO\PuestoDAO();
        
        $ponderacion= $puestoDAO->consultarPonderaciones($codigoCompetencia, $codigoPuesto);
        // un solo dato.. la ponderacion.
        return $ponderacion;
    }
    
    public function modificarPuesto($entrada){
        $puestoDAO = new \Models_DAO\PuestoDAO();
        $empresaDAO = new \Models_DAO\EmpresaDAO();
        $validacion = true; $retorno = 3;
        
        $resp = $this->validarDatos($entrada);
        foreach ($resp as $key => $value){ if($value == "FALSE"){ $validacion = false; } }
        
        if($validacion == true){
            $puesto = $puestoDAO->get("codigo", $entrada["codigo"]);
            if($puesto->comparaNombre($entrada["puesto"]) == false){
                $booleanR = $puestoDAO->existeNombre($entrada["puesto"]);
                if($booleanR == false){ $puesto->set("nombre", $entrada["puesto"]); }
                else{ return 2; }
            }
            $emp = $empresaDAO->get("nombre", $entrada["empresa"]);
            $puesto->set("empresa", $emp);
            $puesto->set("descripcion", $entrada["descripcion"]);
            $listCaract = $this->crearListaCaracteristicas($entrada["caracteristicas"]);
            $puesto->actualizarCaracteristicas($listCaract);
            $retorno = $puestoDAO->update($puesto);
        }
        return $retorno;
    }

    public function darAltaPuestos($entrada){
        $puestoDAO = new \Models_DAO\PuestoDAO();
	$empresaDAO = new \Models_DAO\EmpresaDAO();
        $validacion = TRUE;
        $finalizado = FALSE;
        
	$resp = $this->validarDatos($entrada);
        
        foreach ($resp as $key => $value){
            //echo "<br>Resultados de la validacion:";
            if($value == "FALSE"){ $validacion = FALSE; }
                //echo "<br>Esta campo ".$key." fue ".$value;
        }
        //echo "<br> validacion : ".$validacion;
        if($validacion == TRUE){
            $arreglo = array(
                'nombre' => $entrada["puesto"], 
                'codigo' => $entrada["codigo"], 
		);

            $booleanR = $puestoDAO->exists($arreglo);
            //echo "<br>este: ".$booleanR; 
            if($booleanR == false){
                $nombre = $entrada["empresa"];
		$emp = $empresaDAO->get('nombre',$nombre); 
                $listCaract = $this->crearListaCaracteristicas($entrada["caracteristicas"]);
		//INSTANCIO EL PUESTO Y LO SETEO
                $puestoNuevo = new \Models_Entitys\Puesto();
                $puestoNuevo->set("codigo", $entrada["codigo"]);
                $puestoNuevo->set("nombre", $entrada["puesto"]);
                $puestoNuevo->set("descripcion", $entrada["descripcion"]);
		$puestoNuevo->agregarElemento($listCaract); 
		$puestoNuevo->set("empresa", $emp); 
		$finalizado = $puestoDAO->insert($puestoNuevo);
            }
            else {  
                    $entrada['aceptar'] = 'codnom';
                    $resultado=serialize($entrada);
                    $resul=urlencode($resultado);
                    header("Location: altaPuesto?valor=".$resul); 
            }
	}
	return $finalizado;
    }

    public function crearListaCaracteristicas($arreglo){ //debe ser private
        $listCaract = array();
        $competenciaDAO = new \Models_DAO\CompetenciaDAO(); //Fatal implementar el competenciaDAO
        foreach ($arreglo as $key1 => $value1) {
            $caract = new \Models_Entitys\Caracteristica(); 
            foreach ($value1 as $key2 => $value2) {
                switch($key2){
                    case 'ponderacion':
                        $caract->set("valor", $value2); 
                    break;
                    case 'competencia':
                        $comp = $competenciaDAO->get("codigo",$value2); //falta hacer la clase y el metodo
                        $caract->set("competencia", $comp); 
                    break;
		}
            }
            $listCaract[] = $caract;
	}
        return $listCaract;
    }

    private function validarDatos($datos){ //debe ser private
        $retorno = array();
        foreach ($datos as $key => $value) {
            switch ($key) {
                case 'codigo':
                    $var = $this->validarTipo("integer", $value);
                    if($var == "TRUE") { $var = $this->validarLongitud("integer", 11 ,$value); } 
                break;
                case 'empresa':
                    $var = $this->validarTipo("string", $value);
                    if($var == "TRUE") {$var = $this->validarLongitud("string", 45 ,$value);}
                break;
                case 'puesto':						
                    $var = $this->validarTipo("string", $value);
                    if($var == "TRUE") { $var = $this->validarLongitud("string", 45 , $value); }
                break;
                case 'descripcion':
                    $var = $this->validarTipo("string", $value);
                    if($var == "TRUE") { $var = $this->validarLongitud("string", 150, $value); }
                break;
                case 'caracteristicas':
                    $this->validarDatos($value);
                break;
                case 'ponderacion':
                    $var = $this->validarTipo("integer", $value);
                    if($var == "TRUE") { $var = $this->validarLongitud("integer", 2, $value); }
                break;
                case 'competencia':
                    $var = $this->validarTipo("integer", $value);
                    if($var == "TRUE") { $var = $this->validarLongitud("integer", 5 , $value); }
                break;
                default:
                    $var = "NO ES POSIBLE VALIDAR EL CAMPO: ".$key;
                break;
            }

            $retorno[$key] = $var; 
        }
	
        return $retorno;
    }

    private function validarTipo($tipo, $objeto){ //debe ser private
        switch ($tipo) {
            case 'integer':
                if(is_int($objeto)) { $var = "TRUE"; } else { $var = "FALSE"; }
            break;
            case 'string':
                if(is_string($objeto)) { $var = "TRUE"; } else { $var = "FALSE"; }
            break;
            case 'boolean':
                if(is_bool($objeto)) { $var = "TRUE"; } else { $var = "FALSE"; }
            break;
            case 'array':
                if(is_array($objeto)) { $var = "TRUE"; } else { $var = "FALSE"; }
            break;
            default:
                $var = "Tipo no contemplado";
            break;
	}

	return $var;
    }

    private function validarLongitud($tipo, $longitud, $objeto){ //debe ser private
        switch ($tipo) {
            case 'integer':
                if(strlen($objeto) <= $longitud) { $var = "TRUE"; } else { $var = "FALSE"; }
            break;
            case 'string':
                if(strlen($objeto) <= $longitud) { $var = "TRUE"; } else { $var = "FALSE"; }
            break;
            case 'array':
                if(count($objeto) <= $longitud) { $var = "TRUE"; } else { $var = "FALSE"; }
            break;
            default:
                $var = "Tipo no contemplado";
            break;
	}
        return $var;	
    }

		//private function validarNulidad($booleano, $objeto){}
    }

?>