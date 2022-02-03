<script type="text/javascript">
        var campo = document.getElementById("datos");
        campo.visibility=false;
</script>
<body onmousedown="elemento(event);">
    <div id="sistema"><p id="titulo" align="right"><strong>Sistema de Consultoría y Selección Empresarial</strong></p></div>
    <div id="cabeza" style="vertical-align:middle;"><div id="texto-cabeza"><p class="nombre">Evaluación de Candidatos</p></div></div>
    <div id="cabeza-boton" style="vertical-align:middle;">
        <table align="left" border="0" cellpadding="0" bgcolor="black" cellspacing="15" width="98.4%"> 
            <td align="left"><button onclick = "javaScript: window.history.back();">Atrás</button></td>
        </table>
    </div>
    <div class="box-principal">
        <div id="cuerpo" style="margin-top:2px; font-weight: bold; font-size: 14px;">
            <form name="form1" method="post" action="guardar">
                <p style="color: #666; font-style: italic; font-size: 14px;">Se creará una evaluación con los siguientes datos: </p>
                <table align="center" width="600" border="0" cellspacing="0" cellpadding="0">
                    <tr><td><p style="color: #666; font-style: italic; font-size: 14px;">Empresa: <?php echo $_POST['empresa'];?></p></td></tr>
                    <tr><td><p style="color: #666; font-style: italic; font-size: 14px;">Puesto: <?php echo $_POST['puesto'];?></p></td></tr>
                </table>
                <p style="color: #666; font-style: italic; font-size: 14px;">Canditatos con sus claves de acceso: </p>
                <table align="center" width="650" border="1" cellspacing="0" cellpadding="3">
                    <tr bgcolor="#cccccc">
                        <td height="50" bgcolor="#cccccc">Apellido</td>
                        <td height="50" bgcolor="#cccccc"><strong>Nombre</strong></td>
                        <td bgcolor="#cccccc">Tipo Doc</td>
                        <td height="50" bgcolor="#cccccc"><strong>Nº de Documento</strong></td>
                        <td bgcolor="#cccccc">Clave de Acceso</td>
                    </tr>
                    <?php
                    //print_r($_POST);
                    $datos = $_POST;//array('candidatos' => array(1,2,3), 'codigo' => 11,);
                    $gestorUsuario = new Controllers\GestorUsuarios();
                    $gestorEvaluacion = new Controllers\GestorEvaluacion();
                    $conClaves = $gestorUsuario->generar_claves_nuevas($datos['candidatos']);
                   //MUESTRO RESULTADOS EN LA TABLA
                      echo "<tr>";
                      $maestro = array();
                      foreach ($conClaves as $variable) {
                          echo "<td height='30'>".$variable[0]->get('apellido')."</td>";
                          echo "<td height='30'>".$variable[0]->get('nombre')."</td>";
                          echo "<td height='30'>".$variable[0]->get('tipodocumento')."</td>";
                          echo "<td height='30'>".$variable[0]->get('nrodocumento')."</td>";
                          echo "<td height='30'>".$variable[1]."</td>";
                          echo "</tr>";
                          $arreglo = array('apellido' => $variable[0]->get('apellido'), 'nombre' => $variable[0]->get('nombre'), 'tipodocumento' => $variable[0]->get('tipodocumento'), 'nrodocumento' => $variable[0]->get('nrodocumento'), 'nrocandidato' => $variable[0]->get('nrocandidato'),'clave' => $variable[1]);
                          \array_push($maestro, $arreglo);
                       }
                       $enviar = array('lista' => $maestro, 'codigo' =>  $datos['codigo'], 'competenciasSel' => $datos['candidatos']);
                       $resul= serialize($enviar);
                       $result=urlencode($resul);

                       echo '<input type="hidden" id="datos" name="datos" value="'.$result.'"/>';
                 ?>
                </table> 
                <br>
                <div align="right">
                    <input type="button"  class="botones" value="Cancelar" name="confirmar" style="width:80px;"/>
                    <input type="submit"  class="botones" value="Finalizar" name="confirmar" style="width:80px;"/> 
                </div>
            </form>
        </div>
    </div>
</body>
