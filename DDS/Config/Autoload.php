<?php namespace Config;

class Autoload{
    public static function run(){
        spl_autoload_register(function($clase){
        $aux = str_replace("_", "/", $clase); //para reemplazar los _ de los namespaces y poden encotrar la ruta donde esta guardad la clase
	$ruta = str_replace("\\", "/", $aux).".php";
	include_once $ruta;
        }
        
        );
    }

    }

?>