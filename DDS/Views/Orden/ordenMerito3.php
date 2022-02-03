<!--SCRIPT QUE GESTIONA LOS CHECKBOX PARA MANTENER UNO ACTIVO -->
<style type="text/css">
body {
	background-color: #f0f0f0;
}
#cuerpo #container #content #content-1 form table {
	font-size: 12px;
}
#cuerpo #container #content #content-2 form table {
	font-size: 10px;
}
#cuerpo #container #content #content-2 form table {
	font-size: 12px;
}
</style>
<body onmousedown="elemento(event);" >
    <div id="sistema"><p id="titulo" align="right"><strong>Sistema de Consultoría y Selección Empresarial</strong></p></div>
    <div id="cabeza" style="vertical-align:middle;"><div id="texto-cabeza"><p class="nombre">Orden de Mérito</p></div></div>
    <div id="cabeza-boton" style="vertical-align:middle;">
        <table align="left" border="0" cellpadding="" bgcolor="black" cellspacing="15" width="98.4%"> 
            <td align="left"><button onclick="javascript:window.history.back();">Atrás</button></td>
        </table>
    </div>
    <br>
    <?php
        $datos = $_POST;
        $lista = explode(',', $datos['lista'][0]);
        $gestorReportes = new Controllers\GestorReportes();
        $respuesta = $gestorReportes->emitirOrdendemerito($lista, $datos['codigo']);
    ?>
    <div class="box-principal">
        <div id="cuerpo">
            <div id="container">
                <!--Pestaña 1 activa por defecto-->
                <input id="tab-1" type="radio" name="tab-group" checked="checked" />
                <label class="etiqueta" for="tab-1">Cuestionarios Completos</label>
                <!--Pestaña 2 inactiva por defecto-->
                <input id="tab-2" type="radio" name="tab-group" />
                <label class="etiqueta" for="tab-2">Cuestionarios Incompletos</label>

                <!--Contenido a mostrar/ocultar-->
                <div id="content">

                <!--Contenido de la Pestaña 1-->
                <div id="content-1" align="right">
                    <form action="" method="post" name="form1" onsubmit="">
                        <table width="650" border="1" cellspacing="0" cellpadding="5">
                            <tr bgcolor="#cccccc" align="center">
                                <td height="50" bgcolor="#cccccc"><strong>Candidatos</strong></td>
                                <td height="50" bgcolor="#cccccc"><strong>Tipo Doc</strong></td>
                                <td height="50" bgcolor="#cccccc"><strong>Nro Doc</strong></td>
                                <td bgcolor="#cccccc"><strong>Puntaje<br>(Mínimo 70%)</strong></td>
                                <td bgcolor="#cccccc"><strong>Fecha inicio</strong></td>
                                <td height="50" bgcolor="#cccccc"><strong>Fecha Fin</strong></td>
                                <td bgcolor="#cccccc"><strong>Cantidad <br> de Accesos</strong></td>
                            </tr>
     
                            <?php
                                echo '<td>APROBADOS</td>';
                                echo "<tr>";
                                foreach ($respuesta['aprobados'] as $variable) {
                                    foreach ($variable as $value) {
                                       echo "<td>".$value."</td>";
                                    }
                                    echo "</tr>";
                                }
                                
                                echo '<td>NO APROBADOS</td>';
                                echo "<tr>";
                                foreach ($respuesta['desaprobados'] as $variable) {
                                    foreach ($variable as $value) {
                                       echo "<td>".$value."</td>";
                                    }
                                    echo "</tr>";
                                }
                                
                            ?>
                        </table>
                        <br>
                        <input type="button" onclick='window.print();' value='Imprimir' class="botones" style="width:80px; height:25px;"/>
                        <input type="reset" name="cancelar" id="cancelar" value="Cancelar" onclick="location='//localhost/DDS/Usuarios/menu'" class="botones" style="width:80px; height:25px;"/>
                    </form>
                </div>
                <!--Contenido de la Pestaña 2-->
                <div id="content-2" align="right">
                    <form name="form2" method="post" action="">
                         <table width="650" border="1" cellspacing="0" cellpadding="5">
                            <tr bgcolor="#cccccc">
                                    <td height="50" align="center" bgcolor="#cccccc"><strong>Candidatos</strong></td>
                                    <td height="50" align="center" bgcolor="#cccccc"><strong>Tipo Doc</strong></td>
                                    <td height="50" align="center" bgcolor="#cccccc"><strong>Nro Doc</strong></td>
                                    <td align="center" bgcolor="#cccccc"><strong>Fecha Inicio</strong></td>
                                    <td height="50" align="center" bgcolor="#cccccc"><strong>último Acceso</strong></td>
                                    <td align="center" bgcolor="#cccccc"><strong>Cantidad de Accesos</strong></td>
                            </tr>
                                <?php
                                echo '<td>ACTIVOS</td>';
                                echo "<tr>";
                                foreach ($respuesta['otros']['activos'] as $variable) {
                                    foreach ($variable as $value) {
                                       echo "<td>".$value."</td>";
                                    }
                                    echo "</tr>";
                                }
                                echo '<td>EN PROCESO</td>';
                                echo "<tr>";
                                foreach ($respuesta['otros']['enProcesos'] as $variable) {
                                    foreach ($variable as $value) {
                                       echo "<td>".$value."</td>";
                                    }
                                    echo "</tr>";
                                }
                                echo '<td>INCOMPLETOS</td>';
                                echo "<tr>";
                                foreach ($respuesta['otros']['incompletos'] as $variable) {
                                    foreach ($variable as $value) {
                                       echo "<td>".$value."</td>";
                                    }
                                    echo "</tr>";
                                }
                                
                                ?>
                            </table>
                            <br>
                            <input type="button" onclick='window.print();' value='Imprimir' class="botones" style="width:80px; height:25px;"/>
                            <input type="reset" name="cancelar" id="cancelar" value="Cancelar" onclick="location='//localhost/DDS/Usuarios/menu'" class="botones" style="width:80px; height:25px;"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>