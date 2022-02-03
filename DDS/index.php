<?php

        define('DS', DIRECTORY_SEPARATOR);
	define('ROOT', realpath(dirname(__FILE__)) . DS);
	define('URL', "http://localhost/DDS/");
        

        require_once "Config/Autoload.php";
	\Config\Autoload::run();
        $conex = new \Models\Conexion();
        $template = new \Views\Template();
        //require_once "Views/Template.php";
        
        \Config\Enrutador::run(new \Config\Request());
        
?>