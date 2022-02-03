<?php
include("administrador_db.php");
//OBTENGO LOS PARAMETROS A BUSCAR Y BUSCO
if ($_POST['codigo'] == "") {$codigo = "'%'";} else { $codigo = "'%".$_POST['codigo']."%'";}
if ($_POST['puesto'] == "") {$puesto = "'%'";} else { $puesto = "'%".$_POST['puesto']."%'";}
if ($_POST['empresa'] == "") {$empresa = "'%'";} else { $empresa = "'%".$_POST['empresa']."%'";}
$sql = "p.codigo LIKE ".$codigo." AND p.nombre LIKE ".$puesto." AND e.nombre LIKE ".$empresa;
$puesto=new puesto();
$resultado=$puesto->buscarPuestos($sql);
//CODIFICO EL RESULTADO Y LO ENVIO
$resul=serialize($resultado);
$resul=urlencode($resul);
header("Location: http://localhost/dds/gestionarPuesto.php?valor=".$resul);
?>