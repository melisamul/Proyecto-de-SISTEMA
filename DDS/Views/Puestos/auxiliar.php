<?php

	$datos = $_POST;

	$gestor = new \Controllers\GestorPuestos();

	$resultado=$gestor->buscarPuestos($datos);

	//CODIFICO EL RESULTADO Y LO ENVIO
	$resul=serialize($resultado);
	$resul=urlencode($resul);
        header("Location: gestionarPuesto?valor=".$resul);
?>