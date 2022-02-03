<body onmousedown="elemento(event);">
    <div id="sistema"><p id="titulo" align="right"><strong>Sistema de Consultoría y Selección Empresarial</strong></p></div>
    <div id="cabeza" style="vertical-align:middle;"><div id="texto-cabeza"><p class="nombre">Evaluación de Candidatos</p></div></div>
    <div id="cabeza-boton" style="vertical-align:middle;">
        <table align="left" border="0" cellpadding="" bgcolor="black" cellspacing="15" width="98.4%"> 
            <td style=" color: white; text-align: center;">Informe de su operación</td>
        </table>
    </div>
    <div class="box-principal">
        <div id="cuerpo" style="margin-top:10px; font-size: 16px; align-self: center;">
            <br>
            <table align="center" width="550" border="1" cellspacing="3" cellpadding="80">
                <?php
                    $recibido = stripcslashes($_POST['datos']);
                    $rec = urldecode($recibido);
                    $final = unserialize($rec);
                    //print_r($final);
                    $gestorEvaluacion = new Controllers\GestorEvaluacion();
                    $resultado = $gestorEvaluacion->evaluarCandidatos($final['lista'], $final['codigo']);

                    if($resultado !== TRUE && $resultado !== FALSE){
                ?>
                <td align="center">
                    <p>LA EVALUACIÓN NO A SIDO CREADA. <br><br> Las siguentes competencias NO POSEEN LOS REQUERIMIENTO MINIMOS para su evaluación:</p>
                    <form action="evaluar2" method="post" name="form1">
                        <?php
                        $i = 1;
                        foreach ($resultado as $res) {
                            echo '<p>'.$i.' - '.$res.'</p><br>';
                            $i++;
                        }
                        foreach ($final['competenciasSel'] as $comp){
                            echo '<input type="text" hidden="true" name="competenciasSel[]" value="'.$comp.'">';
                        }
                        ?>
                        <button class="botones" type="submit">Seleccionar otro Puesto</button> 
                        <button class="botones" onclick="location ='//localhost/DDS/Usuarios/menu'">Abandonar</button>
                    </form> 
                </td>


                <?php
                    }elseif ($resultado === FALSE) {
                ?>
                <td align="center"><br>
                    <p>LA EVALUACIÓN NO A SIDO CREADA. <br><br> FALLA EN LA TRANSACCIONES CON LA BASE DE DATOS </p><br><br><br>
                    <button class="botones" onclick="location ='//localhost/DDS/Usuarios/menu'">REGRESAR AL MENÚ CONSULTOR</button>
                </td>   
                <?php
                    }else {
                ?>
                <td align="center">
                    <p id="parrafo1">LA EVALUACIÓN A SIDO CREADA <br><br> ¿Desea exportar la lista de los candidatos con sus claves a un archivo EXCEL?</p>
                    <p id="parrafo2" style="display: none;">EL DOCUMENTO A SIDO CREADO <br><br> Comenzo el proceso de descarga </p>
                    <form action="//localhost/reporteexcel/reporteexcel.php" method="post" name="form1" onsubmit="return ocultar_evaluar();">
                        <?php
                            $resul= serialize($final['lista']);
                            $result=urlencode($resul);
                            echo '<input type="hidden" id="datos" name="datos" value="'.$result.'"/>';
                        ?>

                        <button class="botones" type="submit" id="si">SI</button> 
                        <button class="botones" type="reset" id="no" onclick="location ='//localhost/DDS/Usuarios/menu'">NO</button>
                        <button class="botones" type="reset" id="salir" style="display: none" onclick="location ='//localhost/DDS/Usuarios/menu'">REGRESAR AL MENÚ</button>
                    </form>
                </td>
                <?php 
                    }
                ?>
            </table>
        </div>
    </div>
</body>
