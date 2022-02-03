<body onmousedown="elemento(event);">
    <div id="sistema"><p id="titulo" align="right"><strong>Sistema de Consultoría y Selección Empresarial</strong></p></div>
    <div id="cabeza" style="vertical-align:middle;"><div id="texto-cabeza"><p class="nombre">Cuestionario</p></div></div>
    <div id="cabeza-boton" style="vertical-align:middle;">
        <table align="left" border="0" cellpadding="" bgcolor="black" cellspacing="15" width="98.4%"> 
            <td style=" color: white; text-align: center;">Informe de su operación</td>
        </table>
    </div>
    <div class="box-principal">
        <div id="cuerpo" style="margin-top:10px; font-size: 16px; align-self: center;">
            <br>
            <table align="center" width="550" border="1" cellspacing="3" cellpadding="70">
                <?php
                    $recibido = stripcslashes($_GET['seawalker']);
                    $rec = urldecode($recibido);
                    $final = unserialize($rec);
                    
                    if($final !== TRUE ){
                ?>
                <td align="center">
                    <p>LOS DATOS NO PUDIERON SER RESGUARDADOS. <br><br> Comuniquese con el ADMINISTRADOR para resolver este inconveniente. </p>
                    <button class="botones" onclick="location ='//localhost/DDS/Usuarios/arranque'">Abandonar</button>
                </td>


                <?php
                    } else {
                ?>
                <td align="center"><br>
                    <p> ¡ CUESTIONARIO COMPLETADO ! <br><br> Has culminado con la evaluación <br> Presiona SALIR y nos comunicaremos contigo una vez deteminado el resultado </p><br><br><br>
                    <button class="botones" onclick="location ='//localhost/DDS/Usuarios/arranque'">SALIR</button>
                </td>   
                <?php
                    }
                ?>
            </table>
        </div>
    </div>
</body>
