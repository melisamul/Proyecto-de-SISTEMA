<?php namespace Controllers;

class GestorUsuarios{

    public function __construct() { }
    
 public function generar_claves_nuevas($p_arreglo) {
     $conClaves = array();
     $indice = 0;
     
     while (count($p_arreglo) != $indice){
         $cand = $this->recuperaUnCandidato($p_arreglo[$indice]);
         $clave = $this->generarClave();
         \array_push($conClaves, array($cand, $clave));
         $indice++;
     }
     
     return $conClaves;
 }

    public function ingresarConsultor($entrada){
        
        $ldap= new \Models\LDAP();
        $validacion = true;
        $retorno = $this->validarDatos($entrada);
        
        foreach ($retorno as $key => $value){
            if($value == "FALSE"){ $validacion = false; }
        }
        
        if($validacion == 1){
            $contraseña=$entrada['clave'];
            $usuario = $entrada['usuario'];
        
            $result=$ldap->validarLogin($usuario,$contraseña);
        
            if($result == 0){
                return false;
            } else { 
                $consultor = $this->recueperarConsultor($usuario);
                return $consultor; 
            }
        
        } else { return false;}
    }
    
    private function recueperarConsultor($user){
        $usuarioDAO = new \Models_DAO\UsuarioDAO();
        $consultor = $usuarioDAO->get_consultor($user);
        return $consultor;
    }


    public function ingresarCandidato(){
        $usuarioDAO = new \Models_DAO\UsuarioDAO();
        $cuestionarioDAO = new \Models_DAO\CuestionarioDAO();
        $entrada = $_POST; $validacion = true;
        $resp = $this->validarDatos($entrada);
        foreach ($resp as $key => $value){ if($value == "FALSE"){ $validacion = false; } }
        if($validacion == true){
            $respuesta = $cuestionarioDAO->getCuestionariosActivos($entrada['clave']);
            if(is_bool($respuesta) == TRUE){
                $resul= serialize(6); $result=urlencode($resul); //6 -> representa error por falta de cuestionarios activos
                header("Location: //localhost/DDS/Usuarios/autentificar?valor=".$result);
            } else { 
                //$candidato = $usuarioDAO->get("nrodocumento", $entrada['documento']);
                //$respuesta->set('candidato', $candidato);
                $resul= serialize($_POST); $result=urlencode($resul);
                header("Location: //localhost/DDS/Cuestionario/instrucciones?var=".$result);
            }
        } else {
            $resul= serialize(2); $result=urlencode($resul);//2 -> representa error en las validaciones de tipo y longitud
            header("Location: //localhost/DDS/Usuarios/autentificar?valor=".$result);
        }
    }
    
    public function recuperarCandidatos() {
        $candidatoDAO = new \Models_DAO\CandidatoDAO();
        return $candidatoDAO->listarAll();
    }
    
    public function recuperaUnCandidato($p_nro_cand) {
        $candidatoDAO = new \Models_DAO\CandidatoDAO();
        return $candidatoDAO->get('nroCandidato', $p_nro_cand);
    }
    public function buscarCandidatos($p_arreglo){
        $userDAO = new \Models_DAO\UsuarioDAO();
        
        if ($p_arreglo['apellido'] == "") {$apellido = "'%'";} else { $apellido = "'%".$p_arreglo['apellido']."%'";}
	if ($p_arreglo['nombre'] == "") {$nombre = "'%'";} else { $nombre = "'%".$p_arreglo['nombre']."%'";}
	if ($p_arreglo['nro'] == "") {$nro = "'%'";} else { $nro = "'%".$p_arreglo['nro']."%'";}
        
        $lista = array('apellido' => $apellido, 'nombre' => $nombre, 'nro' => $nro, );
        
        $retorno = $userDAO->listar($lista);
        
        /*$clave = 0;
        $arreglo = array();
        while (count($retorno) != $clave ) {
            $elemento = array( 
                'nombre' => $retorno[$clave]->get("nombre"), 
                'apellido' => $retorno[$clave]->get("apellido"), 
                'nro' => $retorno[$clave]->get("nroCuestionario"),
                );
            
            \array_push($arreglo, $elemento);
            $clave++; 
        }   
        return $arreglo;*/
        return $retorno;
    }
    
    public function generarClave() {
        return $this->generateRandomString(6);
    }
    
    private function generateRandomString($length) { 
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length); 
    }
    
    public function recuperarTipoDocumento() {
        $userDAO = new \Models_DAO\UsuarioDAO();
        $retorno = $userDAO->listAll_tipos();
        return $retorno;
    }

    private function validarDatos($datos){ //debe ser private
        $retorno = array();
        foreach ($datos as $key => $value) {
            switch ($key) {
                case 'usuario': $var = $this->validarTipo("string", $value); if($var == "TRUE") { $var = $this->validarLongitud("string", 45 ,$value); } 
                break;
                case 'tipo': $var = $this->validarTipo("string", $value); if($var == "TRUE") { $var = $this->validarLongitud("string", 10 , $value); }
                break;
                case 'documento': $var = $this->validarTipo("integer", $value); if($var == "TRUE") { $var = $this->validarLongitud("integer", 10, $value); }
                break;
                case 'clave': $var = $this->validarTipo("string", $value); if($var == "TRUE") { $var = $this->validarLongitud("string", 10, $value); }
                break;
                case 'clave2': $var = $this->validarTipo("string", $value); if($var == "TRUE") { $var = $this->validarLongitud("string", 10, $value); }
                break;
                default: $var = "NO ES POSIBLE VALIDAR EL CAMPO: ".$key;
                break;
            }
            $retorno[$key] = $var; 
        }
        return $retorno;
    }

    private function validarTipo($tipo, $objeto){ //debe ser private
        switch ($tipo) {
            case 'integer':
                if(is_numeric($objeto)) { $var = "TRUE"; } else { $var = "FALSE"; }
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
    
    }

?>