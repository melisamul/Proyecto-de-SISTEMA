<body onmousedown="elemento(event);">
    <div id="sistema"><p id="titulo" align="right"><strong>Sistema de Consultoría y Selección Empresarial</strong></p></div>
    <div id="cabeza" style="vertical-align:middle;"><div id="texto-cabeza"><p class="nombre">Gestión de Puestos</p></div></div>
    <div id="cabeza-boton" style="vertical-align:middle;">
        <table align="left" border="0" cellpadding="0" bgcolor="black" cellspacing="15" width="98.4%"> 
            <td align="left"><button onclick = "javaScript: window.history.back();">Atrás</button></td>
        </table>
    </div>
    <br>
    <div class="box-principal">
        <div id="cuerpo">
            <p align="left" style="font-style:italic; font-size:13px; color:#666">Puede completar algún criterio de busqueda o dar click en "buscar" directamente</p>
            <form id="form1" name="form1" method="post" action="auxiliar">
                <table align="center" width="600" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td height="40"><label for="codigo">C&oacutedigo:</label></td>
                      <td height="40"><input name="codigo" type="text" id="codigo" size="45" maxlength="11" placeholders="Ingrese Código" /></td>
                    </tr>
                    <tr>
                      <td height="40"><label for="puesto2">Puesto:</label></td>
                      <td height="40"><input name="puesto" type="text" id="puesto" size="45" maxlength="45" placeholders="Ingrese Puesto" /></td>
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
                    <tr>
                        <td></td>
                        <td align="right">
                            <input type="button" name="nuevo" id="nuevo" value="Nuevo" onclick="location = 'altaPuesto'" class="botones"/>
                            <input type="submit" name="buscar" id="buscar" value="Buscar" class="botones" /></td>
                    </tr>
                </table>
            </form>
            <p style="font-style:italic; color:#666">Resultados de Busqueda para puestos</p>
            <form id="2" name="form2" method="post" action="bajaPuesto" onsubmit="return validarformulario_gestionarPuesto(this)">
                <div id="scroll">
                    <table align="center" width="670" border="2" cellspacing="0" cellpadding="4">
                        <tr bgcolor="#cccccc">
                            <td height="20" width="20"><strong>C&oacutedigo</strong></td>
                            <td height="20" width="100"><strong>Puesto</strong></td>
                            <td height="20" width="90"><strong>Empresa</strong></td>
                            <td height="20" width="20"><strong></strong></td>
                        </tr>
                       <?php
                       //OBTENGO Y DECODIFICO EL RESULTADO DE LA BUSQUEDA
                        if (isset($_GET['valor'])){
                             $arreglo = $_GET['valor'];
                             $recibido=stripcslashes($arreglo);
                             $rec=urldecode($recibido);
                             $final=unserialize($rec);

                            //MUESTRO RESULTADOS EN LA TABLA
                            echo '<tr border="1">';
                            foreach ($final as $value) {
                                echo "<td>".$value['codigo']."</td>";
                                echo "<td>".$value['nombre']."</td>";
                                echo "<td>".$value['empresa']."</td>";
                                echo "<td align='center'>"
                                    . "<input type='radio' name='codigo' value='".$value['codigo']."' id='".$value['codigo']."' onclick='deseleccionar_todo()'/></td>";
                                echo "</tr>";
                            }   
                        }
                      ?>
                    </table>
                </div>
                <table align="right" width="600" border="0" cellspacing="0" cellpadding="10">
                    <tr>
                        <td></td>
                        <td align="right"><input type="submit" value="Eliminar" name="submit" id="Eliminar" class="botones" />
                        <input type="submit" value="Modificar" name="submit" id="Modificar" class="botones" /></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</body>
