<?php
$sysDAO = new \Models_DAO\sysParamDAO();
if(empty($_POST) === FALSE){
    $datos = $_POST;
    $gestorUsuario = new Controllers\GestorUsuarios();
    $retorno = $gestorUsuario->ingresarConsultor($datos);
    if(is_bool($retorno) == TRUE){
        //CODIFICO EL RESULTADO Y LO ENVIO
	$resul= serialize(5);
	$result=urlencode($resul);
        header("Location: autentificar?valor=".$result);
    }

    $sysDAO->registrarconsultor($retorno->get('user'));
    //$GLOBALS['template']->mostrar = TRUE;
    $GLOBALS['template']->usuario_logeado = "CONSULTOR: ".$retorno->get('apellido').", ".$retorno->get('nombre');

} else {
    $retorno = $sysDAO->logueado();
    if(is_bool($retorno) === TRUE){
        //CODIFICO EL RESULTADO Y LO ENVIO
	$resul= serialize(5);
	$result=urlencode($resul);
        header("Location: autentificar?valor=".$result);
    }
}
?>
<body onmousedown="elemento(event);">
    <div id="sistema"><p id="titulo" align="right"><strong>Sistema de Consultoría y Selección Empresarial</strong></p></div>
    <div id="cabeza" style="vertical-align:middle;"><div id="texto-cabeza"><p class="nombre">Menu Consultor</p></div></div>
    <div id="cabeza-boton" style="vertical-align:middle;">
        <table align="left" border="0" cellpadding="0" bgcolor="black" cellspacing="15" width="98.4%"> 
            <td align="left"><button onclick = "javaScript: window.history.back();">Atrás</button></td>
        </table>
    </div>
    <div class="box-principal">
        <div id="cuerpo" style="margin-top:10px;">
            <div align="center">
                <table align="center" width="600" border="0" cellspacing="3" cellpadding="3">
                    <tr>
                        <td><div align="center">                          
                            <button style="height:60px; width:120px;" class="botonesPrincipal" onclick="location = '//localhost/DDS/Evaluar/evaluar'"><p>Evaluar<br/>Candidatos</p></button>
                            </div></td>
                        <td><div align="center">
                                <button style="height:60px; width:120px;" class="botonesPrincipal" onclick="location = '//localhost/DDS/Orden/ordenMerito'">Orden de Mérito</button>
                            </div></td>
                        <td><div align="center">
                            <button style="height:60px; width:120px;" class="botonesPrincipal"><p>Reporte<br />Comparativo</p></button>
                            </div></td>
                    </tr>
                    <tr>
                        <td><div align="center">
                            <input style="height:60px; width:120px;" class="botonesPrincipal" type="button" name="puestos" onclick="location = '//localhost/DDS/Puestos/gestionarPuesto'" value="Puestos" />                           
                        </div></td>
                        <td><div align="center">
                            <input style="height:60px; width:120px;" class="botonesPrincipal" type="button" name="Competencias" value="Competencias" />                            
                        </div></td>
                        <td><div align="center">
                            <input style="height:60px; width:120px;" class="botonesPrincipal" type="button" name="Factores" value="Factores" />                                
                        </div></td>
                    </tr>
                    <tr>
                        <td><div align="center">
                            <input style="height:60px; width:120px;" class="botonesPrincipal" type="button" name="Preguntas" value="Preguntas" />
                        </div></td>
                        <td><div align="center">
                            <button style="height:60px; width:120px;" class="botonesPrincipal"><p>Opcion de<br />Respuesta</p></button>                                
                        </div></td>
                        <td><div align="center">
                            <input  style="height:60px; width:120px;" class="botonesPrincipal" type="button" name="salir" onclick="location = 'arranque'" value="Salir" />
                        </div></td>
                    </tr>
                </table>
            </div>
            <div align="center"><img src="<?php echo URL.'';?>Views/images/fondo2.png" width="500" height="210" alt="imagenSICSE" /></div>
        </div>
    </div>
</body>