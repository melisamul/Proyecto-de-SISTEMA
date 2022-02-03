<body onmousedown="elemento(event);" onload="cargaDatos();">
    <div id="sistema"><p id="titulo" align="right"><strong>Sistema de Consultoría y Selección Empresarial</strong></p></div>
    <div id="cabeza" style="vertical-align:middle;"><div id="texto-cabeza"><p class="nombre">Evaluación de Candidatos</p></div></div>
    <div id="cabeza-boton" style="vertical-align:middle;">
        <table align="left" border="0" cellpadding="0" bgcolor="black" cellspacing="15" width="98.4%"> 
            <td align="left"><button onclick = "javaScript: window.history.back();">Atrás</button></td>
        </table>
    </div>
    <div class="box-principal">
        <form action="evaluar3" method="post" name="form1" onsubmit="return validarformulario_Evaluar2();">    
            <?php 
                //ENMASCARO LA LISTA DE CANDIDATOS QUE DEBE VIAJAR AL PROXIMO FORMULARIO
                foreach ($_POST['competenciasSel'] as $candidatos){
                    echo '<input type="hidden" name="candidatos[]" value="'.$candidatos.'">';
                }
                echo '<input type="hidden" name="codigo" id="codigoPuesto">';

                //ESTO ES PARA EL RELLENADO DE LOS DATOS DE LA VISTA
                $gestorPuestos = new \Controllers\GestorPuestos();
                $puestos = $gestorPuestos->recuperarPuestos();
                echo '<select hidden multiple="yes" id="puestos">';
                foreach ($puestos as $puesto) {
                    $caracteristica = $puesto->get('caracteristicas');
                    echo '<option value="'.$puesto->get("nombre").','.$puesto->get("empresa")->get("nombre").','.$puesto->get("codigo").'">';
                }
                echo '</select>';
                echo '<select hidden multiple="yes" id="caracteristicas">';
                foreach ($puestos as $puesto) {
                    $caracteristicas = $puesto->get('caracteristicas');
                    foreach ($caracteristicas as $caracteristica){
                        echo '<option value="'.$puesto->get("nombre").','.$caracteristica->get("competencia")->get("nombre").','.$caracteristica->get("ponderacion").'">';
                    }
                }
                echo '</select>';
            ?>
            <div id="cuerpo" style="margin-top:10px;">
                <p align="right" style="font-style:italic; color:#666; font-size: 12px;">(*)Campos Obligatorios</p>
                <p style="color: #666; font-style: italic; font-size: 14px;">Seleccione el Puesto o Función a evaluar:</p>
                <table align="center" width="550" border="0" cellspacing="2" cellpadding="10">
                    <tr>
                        <td><span style="color: #666; font-size: 14px;">(*)</span> Función o Puesto:</td>
                        <td><label>
                                <select name="puesto" size="1" id="puesto" style="width:250px;" onchange="seleccionoPuesto();">
                                    <option value="0">Seleccione un Puesto</option>
                                </select>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td><span style="font-size: 14px; color: #666;">(*)</span> Empresa</td>
                        <td><label>
                            <select name="empresa" size="1" id="empresa" style="width:250px;" onchange="seleccionoEmpresa();">
                                <option value="0">Seleccione una Empresa</option>
                            </select>
                            </label>
                        </td>
                    </tr>
                </table>
                <br>
                <p style="color: #666; font-style: italic; font-size: 14px;">Competencias asociadas a Puestos o Función</p>
                <table align="center" width="550" border="1" cellspacing="0" cellpadding="5" id="tablaCompPon"></table><br>
                <div align="right" id='oculto' style='display:none;'><p style="color:#F00; font-size:12px;">(*) Seleccione un puesto para realizar la evaluación</p></div>
                <div align="right"><input class="botones" type="submit" name="Aceptar" value="Siguiente" style="width:90px;"/></div>
            </div>
        </form>
    </div>
</body>