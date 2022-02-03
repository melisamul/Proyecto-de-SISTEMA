<?php
    $gestorP = new \Controllers\GestorPuestos();  
        
    if (isset($_GET['valor'])){
        $recibido=stripcslashes($_GET['valor']);
        $rec=urldecode($recibido); $codigo=unserialize($rec);
        $datos = $gestorP->recuperarDatosPuesto($codigo);
        $nom = $datos[0]; $desc = $datos[1];
        $empresa = $datos[2]; $listComp = $datos[3];
    }
    if(isset($_GET['error'])){
        $recibido=stripcslashes($_GET['error']);
        $rec=urldecode($recibido); $final=unserialize($rec);
        $codigo = $final['codigo'];
        $nom = $final['puesto']; $desc = $final['descripcion'];
        $empresa = $final['empresa']; $listComp = $final['competenciasSel'];
    }
 ?>
<body onmousedown="elemento(event);">
    <div id="sistema"><p id="titulo" align="right"><strong>Sistema de Consultoría y Selección Empresarial</strong></p></div>
    <div id="cabeza" style="vertical-align:middle;"><div id="texto-cabeza"><p class="nombre">Gestión Puestos: Modificar Puestos</p></div></div>
    <div id="cabeza-boton" style="vertical-align:middle;">
        <table align="left" border="0" cellpadding="0" bgcolor="black" cellspacing="15" width="98.4%"> 
            <td align="left"><button onclick = "javaScript: window.history.back();">Atrás</button></td>
        </table>
    </div>
    <div class="box-principal">
        <div id="cuerpo">
            <p align="right" style="font-style:italic; font-size:12px; color:#666">(*)Campos Obligatorios</p>
            <form name="form1" method="post" action="ponderaciones_1" onsubmit="return validarformulario_modificarPuesto(this);">
                <table align="center" width="500" border="0" cellspacing="0" cellpadding="5">
                    <tr>
                        <td height="20"><div align="right"><span class="obligados">(*)</span> Código:</div></td>
                        <td height="30"><div align="left">
                              <label for="codigo"></label><label id="codigolavel"><?php echo $codigo; ?></label>
                              <input name="codigo" type="hidden" readonly value="<?php echo $codigo; ?>" id="codigo"/>
                        </div></td>
                    </tr>
                    <tr>
                        <td height="40"><div align="right"><span class="obligados">(*)</span> Puesto:</div></td>
                        <td height="40"><div align="left">
                            <label for="puesto"></label>
                            <input name="puesto" type="text" value="<?php echo $nom; ?>" id="puesto" size="30" maxlength="30" style="text-transform:uppercase;" />
                            <div id='oculto3' style='display:none;'><p style="color:#F00; font-size:12px;">(*)Este campo no puede estar vacio</p></div>
                            <?php if((isset($_GET['error']) == true) && ($final['aceptar'] == 'nombre')){ 
                                      echo '<p style="color:#F00; font-size:12px;">(*)Este nombre de puesto ya EXISTE ! </p></div>'; 
                            } ?>
                        </div></td>
                    </tr>
                    <tr>
                        <td height="40"><div align="right"><span class="obligados"></span> Descripción:</div></td>
                        <td height="40"><div align="left">
                            <label for="descripcion"></label>
                            <textarea name="descripcion" cols="30" rows="5" id="descripcion" style="text-transform:uppercase;" onkeydown="keydownFunction()" onkeyup="keyupFunction()"><?php echo $desc; ?></textarea>
                            <div id='oculto' style='display:none;'><p style="color:#F00; font-size:12px;">(*)Cantidad máxima 150 caracteres</p></div>
                        </div></td>
                    </tr>
                    <tr>
                        <td height="40"><div align="right"> <span class="obligados">(*)</span> Empresa:</div></td>
                        <td height="40"><div align="left">
                            <label for="empresa"></label>
                                <select name="empresa" id="empresa">
                                    <option value="valorpordefecto">Selecione empresa</option>
                                    <?php
                                    $resultado = $gestorP->recuperarEmpresas();
                                    \natsort($resultado);
                                    foreach($resultado as $key => $value){
                                        if($value == $empresa){ 
                                            echo '<option value= "'.$empresa.'" selected>'.$empresa.'</option>'; 
                                        } else {
                                            echo '<option value= "'.$value.'">'.$value.'</option>';
                                        }
                                    }
                                  ?>
                                </select>
                            <div id='oculto4' style='display:none;'><p style="color:#F00; font-size:12px;">(*)Debe seleccionar una empresa</p></div>
                            </div></td>
                    </tr>
                </table>
                <table align="center" width="420" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td height="40" colspan="3"><span class="obligados">(*)</span> Caracteristicas:</td>
                    </tr>
                    <tr>
                        <td><label for="competenciasDes"></label>
                        <div align="center"><select name="competenciasDes" size="5" multiple="multiple" id="competenciasDes" style="width:100px">
                        <?php
                          $gestorC = new Controllers\GestorCompetencias();
                          $result = $gestorC->recuperarCompentencias2($listComp, $codigo);
                          function ordename ($a, $b) {
                              return strcmp ($a[1] , $b[1]);                                    
                          }
                          \usort($result, 'ordename');
                          if(empty($result) == FALSE){
                              foreach($result as $key => $res){
                                  //echo '<script type="text/javascript">alert("codigo '.$res[0].' nombre '.$res[1].'")</script>';
                                  echo '<option id="'.$res[0].'" value="'.$res[1].'">'.$res[1].'</option>';
                              }
                          }
                        ?>
                        </select></div>
                    </td>
                    <td><p align="center"></p>
                        <p align="center"><a href="#" onclick="javascript: agregar();"><img src="<?php echo URL; ?>Views/images/boton2.jpg" onmouseover="javascript:this.src='<?php echo URL; ?>Views/images/boton4.jpg';"onmouseout="javascript:this.src='<?php echo URL; ?>Views/images/boton2.jpg';"/></a></p>
                        <p align="center"><a href="#" onclick="javascript: quitar();"><img src="<?php echo URL; ?>Views/images/boton3.jpg" onmouseover="javascript:this.src='<?php echo URL; ?>Views/images/boton.jpg';"onmouseout="javascript:this.src='<?php echo URL; ?>Views/images/boton3.jpg';"/></a></p>
                    </td>
                    <td><label for="competenciasSel"></label>
                        <div align="center"><select name="competenciasSel[]" size="5" multiple="MULTIPLE" id="competenciasSel" style="width:100px;">
                        <?php
                          if(empty($listComp) == FALSE){
                              $contador = 0;
                              while (count($listComp) > $contador) {
                                  $listC = $listComp[$contador];
                                  if(isset($_GET['error'])){
                                      echo '<option id="'.$listC[0].'" value="'.$listC[0].'" >'.$gestorC->recuperarNombre($listC[0]).'</option>'; 
                                  } else {
                                      echo '<option id="'.$listC[0].'" value="'.$listC[0].'">'.$listC[1].'</option>'; 
                                  }
                                  $contador++;
                              }
                          }

                        ?>
                            </select>
                        </div></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="2" height="40" align="right">
                            <div id='oculto5' style='display:none;'><p style="color:#F00; font-size:12px;">(*)Debe seleccionar al menos una competencia</p></div><br>
                            <input class="botones" type="submit" name="aceptar" id="aceptar" value="Aceptar"/>
                            <input class="botones" type="reset" name="cancelar" id="cancelar" value="Cancelar" onclick="location='gestionarPuesto'"/>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</body>