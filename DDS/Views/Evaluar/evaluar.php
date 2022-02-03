<body onmousedown="elemento(event);" onload="obtener();">
    <div id="sistema"><p id="titulo" align="right"><strong>Sistema de Consultoría y Selección Empresarial</strong></p></div>
    <div id="cabeza" style="vertical-align:middle;"><div id="texto-cabeza"><p class="nombre">Evaluación de Candidatos</p></div></div>
    <div id="cabeza-boton" style="vertical-align:middle;">
        <table align="left" border="0" cellpadding="" bgcolor="black" cellspacing="15" width="98.4%"> 
            <td align="left"><button onclick = "javaScript: window.history.back();">Atrás</button></td>
        </table>
    </div>
    <div class="box-principal">
        <div id="cuerpo" style="margin-top:10px; font-size: 16px; align-self: center;">
            <table align="center" width="550" border="0" cellspacing="0" cellpadding="20">
                <tr>
                  <td><label for="apellido">Apellido: </label>
                      <input id="apellido" name="apellido" type="text" size="15" placeholder="Ingrese Apellido" onkeyup="filtar();" /></td>
                  <td><label for="nombre">Nombre:</label>
                    <input id="nombre" name="nombre" type="text" size="15" placeholder="Ingrese Nombre" onkeyup="filtar();"/></td>
                </tr>
                <tr align="center">
                    <td colspan="5"><label align="center">Número de Candidato:
                        <select name="nCandidato" size="1" id="nCandidato" onchange="filtar();">
                            <option value="">Ingrese número</option>
                            <?php
                                $gestorUsuario = new \Controllers\GestorUsuarios();
                                $listaCandidatos=$gestorUsuario->recuperarCandidatos(); // lista de objetos candidatos
                                foreach ($listaCandidatos as $key => $valor) {
                                        $nro = $valor->get('nrocandidato');
                                        echo "<option value=".$nro.">".$nro."</option>";
                                }
                            ?>
                        </select>
                        </label>
                    </td>
                </tr>
            </table><br>
            <form action="evaluar2" method="post" name="form1" onsubmit="return validarformulario_evaluar();">
                <table align="center" width="550" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="200" height="20">
                            <span class="obligados">(*)</span>
                            <span style="font-size: 12px">Seleccione uno o más candidatos:</span>
                        </td>
                        <td></td>
                        <td width="200" height="20" style="font-size: 11px">Candidatos a evaluar</td>
                    </tr>
                    <tr>
                        <td width="200"><label for="competenciasDes"></label>
                            <div align="center">
                                <select name="competenciasDes" size="8" multiple="MULTIPLE" id="competenciasDes" style="width:150px">
                                <?php
                                    $arreglo= array();
                                    foreach ($listaCandidatos as $key => $valor) {
                                            $apellido = $valor->get('apellido');
                                            $nombre = $valor->get('nombre');
                                            $num = $valor->get('nrocandidato');
                                            $arreglo2= array ($num,$apellido,$nombre);
                                            array_push($arreglo, $arreglo2);
                                    }

                                    foreach ($arreglo as $valor) {
                                        echo '<option value="'.$valor[0].'" id="'.$valor[0].'">'.$valor[0].'  '.$valor[1].'  '.$valor[2].'</option>';  
                                    }
                                ?>
                                </select>
                            </div>
                        </td>
                        <td><p align="center"></p>
                            <p align="center"> <a href="#" onclick="javascript: agregar();"><img src="<?php echo URL; ?>Views/images/boton2.jpg" alt="sig" onmouseover="javascript:this.src='<?php echo URL; ?>Views/images/boton4.jpg';"onmouseout="javascript:this.src='<?php echo URL; ?>Views/images/boton2.jpg';"/></a></p>
                            <p align="center"> <a href="#" onclick="javascript: quitar();"><img src="<?php echo URL; ?>Views/images/boton3.jpg" alt="ant" onmouseover="javascript:this.src='<?php echo URL; ?>Views/images/boton.jpg';"onmouseout="javascript:this.src='<?php echo URL; ?>Views/images/boton3.jpg';"/></a></p></td>
                        <td width="200"><label for="competenciasSel"></label>
                            <div align="center"><label>
                                <select name="competenciasSel[]" size="8" multiple="multiple" id="competenciasSel" style="width:150px;"></select>
                                </label>
                            </div>
                        </td>
                    </tr>
                </table>
                <br>
                <table align="center" width="550" border="0" cellspacing="0" cellpadding="0">
                    <td align="right"><div id='oculto' style='display:none;'><p style="color:#F00; font-size:14px;">(*) Seleccione al menos un candidato</p></div></td>
                    <td align="right"><div><input style="margin-right:10px; width:80px;" class="botones" type="submit" name="aceptar" id="aceptar" value="Siguiente"/></div></td>
                </table>
            </form>
        </div>
    </div>
</body>