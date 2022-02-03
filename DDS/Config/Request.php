<?php namespace Config; 

class Request{
    private $controlador;
    private $metodo;
    private $argumento;
    
    public function __construct(){
        if(isset($_GET['url'])) {
            $ruta = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
            $ruta = $this->multiexplode(array("/","?"),$ruta);
            
            $ruta = array_filter($ruta);
            if($ruta[0] == "index.php"){
                $this->controlador = "Usuarios";
            } else {
                $this->controlador = strtolower(array_shift($ruta));
            }
            $this->metodo = strtolower(array_shift($ruta));
            if(!$this->metodo){
                $this->metodo = "arranque";
            }
            $this->argumento = $ruta;
        }
	else {
            $this->controlador = "Usuarios";
            $this->metodo = "arranque";
	}
    }

    private function multiexplode ($delimiters,$string) {
    
    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
    }
    
    public function get($atributo){ return $this->$atributo; }

    }

?>