<?php 
    if(isset($_GET['valor']) == true){
        $arreglo = $_GET['valor'];
        $recibido=stripcslashes($arreglo);
        $rec=urldecode($recibido);
        $final=unserialize($rec);
    }
?>
<body onmousedown="elemento(event);">
    <div id="sistema"><p id="titulo" align="right"><strong>Sistema de Consultoría y Selección Empresarial</strong></p></div>
    <div id="cabeza" style="vertical-align:middle;"><div id="texto-cabeza"><p class="nombre">Gestión Puestos: Alta de Puestos</p></div></div>
    <div id="cabeza-boton" style="vertical-align:middle;">
        <table align="left" border="0" cellpadding="0" bgcolor="black" cellspacing="15" width="98.4%"> 
            <td align="left"><button onclick = "javaScript: window.history.back();">Atrás</button></td>
        </table>
    </div>
    <div class="box-principal">
        <div id="cuerpo">
            <p align="right" style="font-style:italic; font-size:12px; color:#666">(*)Campos Obligatorios</p>
            <form name="form1" action="ponderaciones" method="post" onsubmit="return validarformulario_altaPuesto(this);">
                <table align="center" width="500" border="0" cellspacing="0" cellpadding="5">
                    <tr>
                        <td height="20"><div align="right"><span class="obligados">(*)</span> Código: </div></td>
                        <td height="30"><div align="left">
                            <label for="codigo"></label>
                            <input name="codigo" type="text" id="codigo" size="32" maxlength="8" <?php if(isset($_GET['valor']) == true){ echo 'value='.$final['codigo'].''; } ?> />
                            <div id='oculto2' style='display:none;'><p style="color:#F00; font-size:12px;">(*)Este campo no puede estar vacio</p></div>
                            <div id='oculto2codigo' style='display:none;'><p style="color:#F00; font-size:12px;">(*)Este campo solo puede contener numeros enteros</p></div>
                            <?php if((isset($_GET['valor']) == true) && (($final['aceptar'] == 'codigo') || ($final['aceptar'] == 'codnom'))){ 
                                echo '<p style="color:#F00; font-size:12px;">(*)Este el codigo ya EXISTE ! </p></div>'; 
                            } ?>
                            </div></td>
                    </tr>
                    <tr>
                        <td height="40"><div align="right"><span class="obligados">(*)</span> Puesto: </div></td>
                        <td height="40"><div align="left">
                            <label for="puesto"></label>
                            <input name="puesto" type="text" id="puesto" size="32" maxlength="30" style="text-transform:uppercase;" <?php if(isset($_GET['valor']) == true){ echo 'value='.$final['puesto'].''; } ?> />
                            <div id='oculto3' style='display:none;'><p style="color:#F00; font-size:12px;">(*)Este campo no puede estar vacio</p></div>
                            <?php if((isset($_GET['valor']) == true) && (($final['aceptar'] == 'nombre') || ($final['aceptar'] == 'codnom'))){ 
                                echo '<p style="color:#F00; font-size:12px;">(*)Este nombre de puesto ya EXISTE ! </p></div>'; 
                            } ?>
                            </div></td>
                    </tr>
                    <tr>
                        <td height="40"><div align="right"><span class="obligados"></span> Descripción: </div></td>
                        <td height="40"><div align="left">
                            <label for="descripcion"></label>
                            <textarea type="text" name="descripcion" cols="30" rows="5" maxlength="155" id="descripcion" style="text-transform:uppercase;" onkeydown="keydownFunction()" onkeyup="keyupFunction()">
                                 <?php if(isset($_GET['valor']) == true){ echo $final['descripcion']; } ?> 
                            </textarea>
                            <div id='oculto' style='display:none;'><p style="color:#F00; font-size:12px;">(*)Cantidad máxima 150 caracteres</p></div>
                            </div></td>
                    </tr>
                    <tr>
                        <td height="40"><div align="right"> <span class="obligados">(*)</span> Empresa:</div></td>
                        <td height="40"><div align="left">
                            <label for="empresa"></label>
                            <select name="empresa" id="empresa">
                                <option value="valorpordefecto" selected>Selecione empresa</option>
                                <?php
                                    $gestorPuesto = new Controllers\GestorPuestos();
                                    $resultado = $gestorPuesto->recuperarEmpresas();
                                    \natsort($resultado);
                                    foreach($resultado as $key => $value){
                                        if((isset($_GET['valor']) == true) && ($value == $final['empresa'])){ 
                                            echo '<option value= "'.$final['empresa'].'" selected>'.$final['empresa'].'</option>'; 
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
                                $gestorComp = new Controllers\GestorCompetencias();
                                $result = $gestorComp->recuperarCompetencias();
                                function ordename ($a, $b) {    
                                        return strcmp ($a[1] , $b[1]);                                    
                                }
                                \usort($result, 'ordename');
                                if(empty($result) == FALSE){
                                    foreach($result as $key => $res){
                                        echo '<option id="'.$res[0].'" value="'.$res[1].'">'.$res[1].'</option>';
                                    }
                                }
                            ?>
                            </select></div></td>
                        <td><p align="center"></p>
                            <p align="center">
                                <a href="#" onclick="javascript: agregar();"><img src="<?php echo URL; ?>Views/images/boton2.jpg" onmouseover="javascript:this.src='<?php echo URL; ?>Views/images/boton4.jpg';"onmouseout="javascript:this.src='<?php echo URL; ?>Views/images/boton2.jpg';"/></a></p>
                                <p align="center">
                                <a href="#" onclick="javascript: quitar();"><img src="<?php echo URL; ?>Views/images/boton3.jpg" onmouseover="javascript:this.src='<?php echo URL; ?>Views/images/boton.jpg';"onmouseout="javascript:this.src='<?php echo URL; ?>Views/images/boton3.jpg';"/></a></p>
                        </td>
                        <td><label for="competenciasSel"></label>
                            <div align="center">
                                <label><select name="competenciasSel[]" size="5" multiple="MULTIPLE" id="competenciasSel" style="width:100px;"></select></label>
                            </div></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="2" height="40" align="right">
                            <div id='oculto5' style='display:none;'><p style="color:#F00; font-size:12px;">(*)Debe seleccionar al menos una competencia</p></div>
                            <input class="botones" type="submit" name="aceptar" id="aceptar" value="Aceptar"/>
                            <input class="botones" type="reset" name="cancelar" id="cancelar" value="Cancelar" onclick="location='gestionarPuesto'"/>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</body>