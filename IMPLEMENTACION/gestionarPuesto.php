<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="estilo.css" rel="stylesheet" type="text/css">
<title>SICSE V.01</title>
<!--SCRIPT QUE GESTIONA LOS CHECKBOX PARA MANTENER UNO ACTIVO -->
<script type="text/javascript">
function deseleccionar_todo(){ 
  var id_click = elemento(event);
  var ele = document.getElementById(id_click);
  if (ele.checked) 
    {for (i=0;i<document.form2.elements.length;i++) 
      if(document.form2.elements[i].type == "checkbox")
        if (document.form2.elements[i].id!==id_click)
          document.form2.elements[i].disabled='disabled'; }
        else 
            {for (i=0;i<document.form2.elements.length;i++)
              if(document.form2.elements[i].type == "checkbox")
                if (document.form2.elements[i].id!==id_click)
                  document.form2.elements[i].disabled=!document.form2.elements[i].disabled;
                }
}
function elemento(e){
  if (e.srcElement)
    tag = e.srcElement.id;
  else if (e.target)
      tag = e.target.id;
 return (tag);
}
</script>
<style type="text/css">
body {
	background-color: #f0f0f0;
}
</style>
</head>

<body onmousedown="elemento(event);">
<div id="sistema">
<p id="titulo" align="right"><strong>Sistema de Consultoría y Selección Empresarial</strong></p>
</div>
<div id="cabeza" style="vertical-align:middle;">
<div style="margin:0 auto; padding-top:3px">
<p class="nombre">Gestion de Puestos</p>
</div>
</div>
<div id="cuerpo">
<?php
include("administrador_db.php");
?>
<form id="form1" name="form1" method="post" action="auxiliar.php">
  <table width="500" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="40"><label for="codigo">C&oacutedigo:</label></td>
      <td height="40"><input name="codigo" type="text" id="codigo" size="11" maxlength="11" placeholders="Ingrese Código" /></td>
    </tr>
    <tr>
      <td height="40"><label for="puesto2">Puesto:</label></td>
      <td height="40"><input name="puesto" type="text" id="puesto" size="45" maxlength="45" placeholders="Ingrese Puesto" /></td>
    </tr>
    <tr>
      <td height="40"><label for="empresa2">Empresa:</label></td>
      <td height="40"><select name="empresa" id="empresa">
        <option value="">Selecione empresa</option>
        <?php
        $var2 = new empresa();
		$resultado=$var2->listarNombres();
		foreach($resultado as $res){
				echo '<option value="'.$res.'">'.$res.'</option>';
			}
		?>
      </select></td>
    </tr>
    <tr>
      <td height="40" align="center"><input type="button" name="nuevo" id="nuevo" value="Nuevo" class="botones"/></td>
      <td height="40" align="center"><input type="submit" name="buscar" id="buscar" value="Buscar" class="botones" /></td>
    </tr>
  </table>
 </form>
<p style="font-style:italic; color:#666">Resultados de Busqueda para puestos</p>
<form id="2" name="form2" method="post" >
<div id="scroll">

<table width="500" border="1" cellspacing="0" cellpadding="0">
  
  <tr bgcolor="#cccccc">
    <td height="50"><strong>C&oacutedigo</strong></td>
    <td height="50"><strong>Puesto</strong></td>
    <td height="50"><strong>Empresa</strong></td>
    <td height="50"><strong>Check Option</strong></td>
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
</div>
</form>
<table width="500" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><input type="submit" value="Eliminar" 
         name="Eliminar" id="Eliminar" class="botones" /></td>
    <td align="center"><input type="submit" value="Modfcar" 
         name="Submit" id="Modificar" class="botones" /></td>
  </tr>
</table>

<form name="form3" action="" method="post">
</form>

<form name="form4" action="" method="post">
</form>

</div>
</body>
</html>