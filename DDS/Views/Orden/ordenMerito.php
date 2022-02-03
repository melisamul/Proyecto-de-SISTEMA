<body onmousedown="elemento(event);" onload="obtener();">
    <div id="sistema"><p id="titulo" align="right"><strong>Sistema de Consultoría y Selección Empresarial</strong></p></div>
    <div id="cabeza" style="vertical-align:middle;"><div id="texto-cabeza"><p class="nombre">Orden de Mérito</p></div></div>
    <div id="cabeza-boton" style="vertical-align:middle;">
        <table align="left" border="0" cellpadding="" bgcolor="black" cellspacing="15" width="98.4%"> 
            <td align="left"><button onclick="javascript:window.history.back();">Atrás</button></td>
        </table>
    </div>
    <br>
    <div class="box-principal">
        <div id="cuerpo" style="margin-top:5px; font-size: 12px;"><p style="font-style: italic; color: #999; font-size: 14px;">Seleccione al menos un criterio para la búsqueda</p>
            <form id="form1" name="form1" method="post" action="//localhost/DDS/Puestos/buscarPuestosEv"> 
                <table align= "center" width="600" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td height="40"><label for="codigo">C&oacutedigo:</label></td>
                      <td height="40"><input type="text" name="codigo" id="codigo" size="45" maxlength="11" placeholders="Ingrese Código"/></td>
                    </tr>
                    <tr>
                      <td height="40"><label for="puesto2">Puesto:</label></td>
                      <td height="40"><input type="text" name="puesto" id="puesto" size="45" maxlength="45" placeholders="Ingrese Puesto" /></td>
                    </tr>
                    <tr>
                        <td height="40"><label for="empresa2">Empresa:</label></td>
                        <td height="40">
                            <select name="empresa" id="empresa">
                                <option value="">Selecione empresa</option>
                                <?php
                                    $gestor = new Controllers\GestorPuestos();
                                    $resultado = $gestor->recuperarEmpresas();
                                    \natsort($resultado);
                                    foreach($resultado as $key => $value){
                                        echo '<option value= "'.$value.'">'.$value.'</option>';
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                        <td></td>                    
                </table>
                <div align="right">
                            <input class="botones" type="submit" name="buscar" id="buscar" value="Buscar" />
                            <input class="botones" type="button" name="cancelar" id="cancelar" value="Cancelar" onClick="location='//localhost/DDS/Usuarios/menu'" />
                </div>
            </form>
            <p style="font-style:italic; color:#666">Resultados de Búsqueda para puestos</p>    
            <form id="2" name="form2" method="post" action="ordenMerito2" onsubmit="return validar_ordenMerito1(this);">
                <div id="scroll">   
                    <table align ="center" width="682" border="1" cellspacing="0" cellpadding="5">
                        <tr bgcolor="#cccccc">
                            <td height="30" bgcolor="#cccccc"><strong>Código</strong></td>
                            <td height="30" bgcolor="#cccccc"><strong>Puesto</strong></td>
                            <td height="30" bgcolor="#cccccc"><strong>Empresa</strong></td>
                            <td height="30" bgcolor="#cccccc">Candidatos</td>
                            <td height="30" bgcolor="#cccccc">Evaluaciones</td>
                            <td height="30" bgcolor="#cccccc"><strong>Emitir Orden de Merito</strong></td>
                        </tr>
                        <?php
                        //OBTENGO Y DECODIFICO EL RESULTADO DE LA BUSQUEDA
                        if (isset($_GET['valor'])){
                            $arreglo = $_GET['valor'];
                            $recibido=stripcslashes($arreglo);
                            $recibido=urldecode($recibido);
                            $final=unserialize($recibido);

                            if($final == 2) {
                                echo '<script type="text/javascript">alert("NO SE ENCONTRARON PUESTOS CON LAS CONDICIONES UTILIZADAS");</script>';
                            }
                            else {
                                //MUESTRO RESULTADOS EN LA TABLA
                                echo "<tr>";  
                                foreach ($final as $registro) {
                                    echo "<tr>";
                                    echo "<td>".$registro[0]."</td>";
                                    echo "<td>".$registro[1]."</td>";
                                    echo "<td>".$registro[2]."</td>";
                                    echo "<td>".$registro[3]."</td>";
                                    echo "<td>".$registro[4]."</td>";
                                    echo "<td align='center'><input type='radio' name='checkbox' value='".$registro[0]."' onclick='deseleccionar_todo()'/></td>";
                                    echo "</tr>";
                                }
                            }
                        }
                        ?>
                    </table>
                </div>
            <div align="right"><input class="botones" value="Confirmar" type="submit" name="confirmar" style="width:80px;"/> </div>
        </form>
        <p></p>
        </div>
    </div>
</body>
   