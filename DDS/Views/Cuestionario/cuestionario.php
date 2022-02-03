<body onmousedown="elemento(event);">
    <div id="sistema"><p id="titulo" align="right"><strong>Sistema de Consultoría y Selección Empresarial</strong></p></div>
    <div id="cabeza" style="vertical-align:middle;"><div id="texto-cabeza"><p class="nombre">Cuestionario</p></div></div>
    <div id="cabeza-boton" style="vertical-align:middle;">
        <table align="left" border="0" cellpadding="" bgcolor="black" cellspacing="15" width="98.4%"> 
            <td align="left"><button onclick = "">Salir</button></td>
        </table>
    <div class="box-principal">
        <div id="cuerpo" style="align-items: left; margin-top:10px; width:800px; height:400px;">
            <?php
            if(isset($_GET['seawalker'])){
                $recibido = $_GET['seawalker'];
                $datos = stripcslashes($recibido);
                $datos2 = urldecode($datos);
                $clave = unserialize($datos2);
                
                if($clave !== FALSE){
                    $gestorCuestionario = new \Controllers\GestorCuestionarios();
                    $bloque = $gestorCuestionario->retornar_bloque($clave);
                    //print_r($bloque);
                    if($bloque === FALSE){
                        echo '<script> alert("ERROR: Imposible encontrar su proximo BLOQUE de preguntas. Comuniquese con el ADMINISTRADOR "); </script>';
                    } else {
                ?>
                <?php 
                    $cantidad_preg = $gestorCuestionario->cantidadPreguntasCuestionario($clave);
                    $contador = 1;
                    foreach ($bloque->get('preguntas') as $este => $pregunta) {
                ?>
                    <div style="float:left; width:380px; height:170px; padding-top:10px; border-color:#F7F7F7; border-style:groove;">
                        <table width="370" border="0" cellspacing="0" cellpadding="0" align="left">
                            <tr>
                                <td>Pregunta <?php echo $contador."/".$cantidad_preg;?> 
                                    <span style="color: #F00; font-style: italic; font-size: 16px;">
                                        <label id="e<?php echo $este; ?>" style="visibility:hidden;">(*) La pregunta no ha sido respondida</label>
                                    </span></td>
                            </tr>
                            <tr>
                                <td style="text-align: left; padding-left:20px; font-size: 14px"><?php echo $pregunta->get('pregunta');?></td>
                            </tr>
                            <tr>
                                <td style="text-align: left; padding-left:20px">

                            <?php
                                $contador++;
                                foreach ($pregunta->get('opciones_evaluadas') as $val => $opcion){
                                    ?>
                                    <label><span style="font-size: 12px"><?php echo $val; ?>:</span></label>
                                    <label id="respuesta<?php echo $val; ?>"><span style="font-size: 14px"><?php echo $opcion->get('nombre'); ?></span></label><br>
                            <?php
                              } ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: left; padding-left: 20px; color: #999; font-style: italic; font-size: 14px;">Seleccione una respuesta</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; padding-left:20px;"> 
                                  <?php
                                  foreach ($pregunta->get('opciones_evaluadas') as $val => $opcion){
                                      echo '<label><input type="radio" name="'.$este.'" id="'.$val.'" value="'.$opcion->get('nombre').'"/>'.$val.'</label>';
                                  }
                                  ?>
                                </td>
                            </tr>

                        </table>  
                    </div>
                    <?php
                        }
                        echo '<script> arregloCodigos = new Array(); </script>';
                        foreach ($bloque->get('preguntas') as $indice => $pregunta) {
                            echo '<script> arregloCodigos.push('.$pregunta->get('codigo').'); </script>';
                        }
                    ?>
                <form action="//localhost/DDS/Evaluacion/siguientebloque" method="post" name="form1" onsubmit="return validarformulario_cuestionario();">
                    <div style="clear:both; width:770px; text-align:right;">
                        <input type="hidden" name="arreglo" id="arreglo"/>
                        <input type="hidden" name="clave" value="<?php echo $clave;?>"/>
                        <?php 
                            $bool = $gestorCuestionario->esUltimoBloque($clave);
                            if($bool === FALSE){
                        ?>
                                <button type="submit" class="botones" name="boton" value="Siguiente">Siguiente</button>
                        <?php 
                            } else {
                        ?>
                                <button type="submit" class="botones" name="boton" value="Finalizar">Finalizar</button>
                        <?php 
                            }  
                        ?>        
                    </div>
                </form>
                    <?php } //Cierre del else
                } //Cierre del if
            }    ?>
        </div>
    </div>
</body>

