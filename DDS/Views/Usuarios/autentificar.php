<?php
    $sys = new \Models_DAO\sysParamDAO();
    $sys->desregistrarconsultor();
    
    $GLOBALS['template']->mostrar = TRUE;
    //OBTENGO Y DECODIFICO EL RESULTADO DE LA BUSQUEDA
    if (isset($_GET['valor'])){
        $arreglo = $_GET['valor'];
        $recibido=stripcslashes($arreglo);
        $recibido=urldecode($recibido);
        $final=unserialize($recibido);
        switch ($final) {
            case 0:
                echo '<script type="text/javascript">alert("ERROR: SUPERAR EL TIEMPO DE COMPLETAR EL CUESTIONARIO")</script>';
                break;
            case 2:
                echo '<script type="text/javascript">alert("ERROR: SE DETECTARON ANOMALIAS EN LOS DATOS INGRESADOS. INTENTELO NUEVAMENTE ")</script>';
                break;
            case 3:
                echo '<script type="text/javascript">alert("ERROR: SUPERAR EL TIEMPO MAXIMO DE ACTIVO")</script>';
                break;
            case 4:
                echo '<script type="text/javascript">alert("ERROR: EL CUESTIONARIO YA SE ENCONTRABA CERRADO")</script>';
                break;
            case 5:
                echo '<script type="text/javascript">alert("ERROR: LOGIN INVALIDO. INTENTELO NUEVAMENTE ")</script>';
                break;
            case 6:
                echo '<script type="text/javascript">alert("ERROR: NO POSEE CUESTIONARIOS ACTIVOS ")</script>';
                break;
        }
    }
?>
<body onmousedown="elemento(event);">
    <div id="sistema"><p id="titulo" align="right"><strong>Sistema de Consultoría y Selección Empresarial</strong></p></div>
    <div id="cabeza" style="vertical-align:middle;"><div id="texto-cabeza"><p class="nombre">Autentificar Usuario</p></div></div>
    <div id="cabeza-boton" style="vertical-align:middle;">
        <table align="left" border="0" cellpadding="0" bgcolor="black" cellspacing="15" width="98.4%"> 
            <td align="left"><button onclick = "javaScript: window.history.back();">Atrás</button></td>
        </table>
    </div>
    <div class="box-principal">
        <div id="cuerpo">
            <div id="container">
                <!--Pestaña 1 activa por defecto-->
                <input id="tab-1" type="radio" name="tab-group" checked="checked" />
                <label class="etiqueta" for="tab-1">Ingresar como Consultor</label>
                <!--Pestaña 2 inactiva por defecto-->
                <input id="tab-2" type="radio" name="tab-group" />
                <label class="etiqueta" for="tab-2">Realizar Cuestionario</label>
                <!--Contenido a mostrar/ocultar-->
                <div id="content">
                    <!--Contenido de la Pestaña 1-->
                    <div id="content-1">
                        <form action="menu" method="post" name="form1" onsubmit="return Validar_autenticar('usuario','clave')" >
                            <table width="650" border="0" cellspacing="10" cellpadding="0" style="margin-top:30px;">
                                <tr>
                                    <td align="right">Usuario:</td>
                                    <td>
                                        <input class="campodetexto" type="text" name="usuario" id="usuario" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td><td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="right">Contraseña:</td>
                                    <td><label for="clave">
                                        <input class="campodetexto" type="password" name="clave" id="clave" />
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="100">&nbsp;</td>
                                    <td height="100" align="right">
                                        <input class="botones" type="submit"  name="aceptar" id="aceptar" value="Aceptar" style="height:35px; width:60px;"/>
                                        <input class="botones" type="button" name="cerrar" id="cerrar" value="Cerrar" style="height:35px; width:60px;" onclick="location='//localhost/DDS/Usuarios/arranque'"/>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                    <!--Contenido de la Pestaña 2-->
                    <div id="content-2">
                        <form name="form2" method="post" action="//localhost/DDS/Usuarios/ingresarCandidato" onsubmit="return Validar_autenticar2(this)">
                            <table width="650" border="0" cellspacing="0" cellpadding="10" style="margin-top:20px;">
                                <tr>
                                    <td align="right"><label>Tipo:
                                        <select name="tipo" size="1" id="tipo">
                                            <option value="0">Seleccione un tipo</option>
                                        <?php
                                          $gestorUsuario = new \Controllers\GestorUsuarios();
                                          $resultado = $gestorUsuario->recuperarTipoDocumento();
                                          foreach($resultado as $key => $value){
                                              echo '<option value= "'.$value.'">'.$value.'</option>';
                                          }
                                      ?>
                                        </select>
                                        </label></td>
                                    <td align="center"><label>Nº de Documento:
                                        <input type="text" name="documento" id="documento" />
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center"><label>Contraseña:
                                        <input type="password" name="clave" id="clave2" />
                                    </label></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td align="right">
                                        <input class="botones" type="submit" name="aceptar2" id="aceptar2" value="Aceptar" style="height:35px; width:60px;" />
                                        <input class="botones" type="button" name="cerrar2" id="cerrar2" onclick="location='//localhost/DDS/Usuarios/arranque'" value="Cerrar" style="height:35px; width:60px;" />
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>