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
<p align="right" style="font-style:italic; color:#666">(*)Campos Obligatorios</p>
<form name="form1" action="">
<table width="500" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="40"><div align="right"><span class="obligados">(*)</span> Código:</div></td>
    <td height="40"><div align="left">
      <label for="codigo"></label>
      <input name="codigo" type="text" id="codigo" size="8" maxlength="8" />
    </div></td>
  </tr>
  <tr>
    <td height="40"><div align="right"><span class="obligados">(*)</span> Puesto:</div></td>
    <td height="40"><div align="left">
      <label for="puesto"></label>
      <input name="puesto" type="text" id="puesto" size="30" maxlength="30" style="text-transform:uppercase;" />
    </div></td>
  </tr>
  <tr>
    <td height="40"><div align="right"><span class="obligados">(*)</span> Descripción:</div></td>
    <td height="40"><div align="left">
      <label for="descripcion"></label>
      <textarea name="descripcion" cols="30" rows="5" id="descripcion" style="text-transform:uppercase;"></textarea>
    </div></td>
  </tr>
  <tr>
    <td height="40"><div align="right"> <span class="obligados">(*)</span> Empresa:</div></td>
    <td height="40"><div align="left">
      <label for="empresa"></label>
      <select name="empresa" id="empresa">
        <option value="">Selecione empresa</option>
        <?php
        $var2 = new empresa();
		$resultado=$var2->listarNombres();
		foreach($resultado as $res){
				echo '<option value="'.$res.'">'.$res.'</option>';
			}
		?>
      </select>
    </div></td>
  </tr>
</table>
</form>
<form name="form2" action="altaPuestos2.php" method="post">
<table width="500" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="40" colspan="3"><span class="obligados">(*)</span> Caracteristicas:</td>
    </tr>
  <tr>
    <td><label for="competenciasDes"></label>
      <div align="center">
      
      
      
        <select name="competenciasDes" size="5" multiple="multiple" id="competenciasDes" style="width:100px">
          
        <?php
        $var2 = new competencia();
		$resultado=$var2->listarNombres();
		foreach($resultado as $res){
				echo '<option value="'.$res.'">'.$res.'</option>';
			}
		?>
        </select>
        
        
        
        
      </div></td>
    <td><p align="center">
      <input type="button" name="agregar" id="agregar" value=">>>" onclick="agregar()" />
    </p>
      <p align="center">
        <label>
          <input type="button" name="quitar" id="<<<" value="<<<" onclick="quitar()" />
        </label>
      </p></td>
    <td><label for="competenciasSel"></label>
      <div align="center">
        <select name="competenciasSel" size="5" multiple="multiple" id="competenciasSel" style="width:100px">
          
        </select>
      </div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><input class="botones" type="button" name="aceptar" id="aceptar" value="Aceptar" />
      <input class="botones" type="submit" name="cancelar" id="cancelar" value="Cancelar" /></td>
    </tr>
</table>
</form>

</div>
</body>
</html>