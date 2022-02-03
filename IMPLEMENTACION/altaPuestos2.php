<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="estilo.css" rel="stylesheet" type="text/css">
<title>SICSE V.01</title>
<style type="text/css">
body {
	background-color: #f0f0f0;
}
</style>
<script type="text/javascript">
  function agregar() {
    var agregar = document.getElementById('competenciasDes');
    var agregado = agregar.options[agregar.selectedIndex].value;
    var option = document.createElement("option");
    option.value=agregado;
    option.text=agregado;
    var s=document.getElementById('competenciasSel');
    s.appendChild(option);
agregar.removeChild(agregar.options[agregar.selectedIndex]);    
  }


function quitar() {
    var agregar = document.getElementById('competenciasSel');
    var agregado = agregar.options[agregar.selectedIndex].value;
    var option = document.createElement("option");
    option.value=agregado;
    option.text=agregado;
    var s=document.getElementById('competenciasDes');
    s.appendChild(option);
agregar.removeChild(agregar.options[agregar.selectedIndex]);    
  }
</script>
</head>
<?php
include("administrador_db.php");
?>
<body onmousedown="elemento(event);">
<div id="sistema">
<p id="titulo" align="right"><strong>Sistema de Consultoría y Selección Empresarial</strong></p>
</div>
<div id="cabeza" style="vertical-align:middle;">
<div style="margin:0 auto; padding-top:3px">
<p class="nombre">Alta de Puestos</p>
</div>
</div>
<div id="cuerpo">
    <table width="500" border="1" cellspacing="0" cellpadding="0">
    <tr bgcolor="#cccccc">
      <td height="50" bgcolor="#cccccc"><strong>Compentencias Seleccionadas</strong></td>
      <td height="50" bgcolor="#cccccc"><strong>Ponderaci&oacuten</strong>x</td>
    </tr>
     

    <?php
   //OBTENGO Y DECODIFICO EL RESULTADO DE LA BUSQUEDA
   if (isset($_GET['valor'])){
   $arreglo = $_GET['valor'];
   $recibido=stripcslashes($arreglo);
   $recibido=urldecode($recibido);
   $final=unserialize($recibido);
   
//MUESTRO RESULTADOS EN LA TABLA
foreach ($final as $registro) {
  echo "<tr>";
  echo "<td>".$registro[0]."</td>";
  echo "<td>".$registro[1]."</td>";
  echo "<td>".$registro[2]."</td>";
  echo "<td align='center'><input type='radio' name='checkbox' id='".$registro[0]."' onclick='deseleccionar_todo()'/></td>";
 // echo "<td><select type='option' name='seleccion'><option value=".$registro[0].">".$registro[0]."</option></select></td>";
  echo "</tr>";
}}
  ?>
  </table>
  <p>&nbsp;</p>
</div>
</body>
</html>