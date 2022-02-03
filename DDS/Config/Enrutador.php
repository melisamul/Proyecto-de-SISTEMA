<?php namespace Config;

class Enrutador{

    public static function run(Request $request){
	//Cargar Vista
        $ruta = ROOT . "Views" . DS . $request->get("controlador") . DS . $request->get("metodo") . ".php"; 
	if(is_readable($ruta)) {
            $arg = $request->get('argumento');
            if(empty($arg) == FALSE){
                $ruta = ROOT . "Views" . DS . $request->get("controlador") . DS . $request->get("metodo") .'?'.$request->get('argumento') . ".php";
            }
            require_once $ruta;
	} else {
            $controlador = "Gestor".$request->get('controlador');
            $ruta = ROOT . "Controllers" . DS . $controlador . ".php";
            $metodo = $request->get("metodo");
            if($metodo == "index.php"){
                $metodo = "autentificar";
            }
            $argumento = $request->get("argumento");
            if(is_readable($ruta)){
                require_once $ruta;
                $mostrar = "Controllers\\" . $controlador;
                $controlador = new $mostrar;
                if(!isset($argumento)){
                    $datos = call_user_func(array($controlador, $metodo));
                }else {
                    $datos = call_user_func_array(array($controlador, $metodo), $argumento);
                }
            } 
        }
    }
    
    }

?>