<script>
function validarYarreglarformulario_ordenMerito2() {
    var error = 1;
    var todas = document.getElementById("todas");
    //si se selecciono TODAS
    var arreglo = new Array();
    if (todas.checked) {
        for (i=0;i<document.form1.elements.length;i++) {
            if(document.form1.elements[i].type == "checkbox"){
                if(document.form1.elements[i].id != 'todas'){
                    arreglo.push(document.form1.elements[i].id);
                }
            }
        }
        error = 0;
    } else {
        for (i=0;i<document.form1.elements.length;i++){ 
            if(document.form1.elements[i].type == "checkbox"){	
                if (document.form1.elements[i].checked) {
                    arreglo.push(document.form1.elements[i].id);
                    error = 0;
                } 
            }
        }
    }

    if(error == 0){
        var campo = document.getElementById('lista');
        campo.value = arreglo;
        return true;
    } else {
        alert('¡ Debe seleccionar AL MENOS UNA evaluación para continuar ! ');
        return false;
    }
}
</script>
<body onmousedown="elemento(event);" >
    <div id="sistema"><p id="titulo" align="right"><strong>Sistema de Consultoría y Selección Empresarial</strong></p></div>
    <div id="cabeza" style="vertical-align:middle;"><div id="texto-cabeza"><p class="nombre">Orden de Mérito</p></div></div>
    <div id="cabeza-boton" style="vertical-align:middle;">
        <table align="left" border="0" cellpadding="" bgcolor="black" cellspacing="15" width="98.4%"> 
            <td align="left"><button onclick="javascript:window.history.back();">Atrás</button></td>
        </table>
    </div>
    <br>
    <div class="box-principal">
        <div id="cuerpo" style="margin-top:5px; font-size: 12px;"><p style="font-style: italic; color: #999; font-size: 16px;">Seleccione las Evaluaciones para el Orden de Mérito</p>
            <form name="form1" method="post" action="ordenMerito3" onsubmit="return validarYarreglarformulario_ordenMerito2(this);">
                <table align="center" width="700" border="1" cellspacing="0" cellpadding="10">
                    <tr bgcolor="#cccccc">
                        <td height="50" bgcolor="#cccccc">Evaluación</td>
                        <td height="50" bgcolor="#cccccc"><strong>Fecha</strong></td>
                        <td height="50" bgcolor="#cccccc"><strong>Seleccione una Opcion</strong></td>
                    </tr>
                        <?php
                            $codigo = $_POST['checkbox'];
                            echo '<input name="codigo" type="hidden" id="codigo" value="'.$codigo.'" />';
                            echo '<input name="lista[]" type="hidden" id="lista"/>';
                            //consultar porque si saco el echo no me lo muestra en un script posterior. funcion bien del echo en este lugar
                            $gestorReportes = new Controllers\GestorReportes();

                            $resp = $gestorReportes->traerEvaluaciones($codigo);

                            if($resp != FALSE){
                                $posCodigo = count($resp) - 1;
                                //MUESTRO RESULTADOS EN LA TABLA
                        ?>
                    <tr>
                        <?php   
                            foreach ($resp as $key => $var) {
                                    if($posCodigo != $key){
                                        $numero = $key + 1; ?>
                                        <td> Evaluacion N° <?php echo $numero; ?> </td>
                                        <td> <?php echo $var ?> </td>
                                        <td align='center'><input type="checkbox" name="fecha" id="<?php echo $var; ?>" /></td>
                                        </tr> <?php
                                    }
                                } ?>
                    <tr>
                        <td>TODAS</td><td></td>
                        <td align='center'><input type="checkbox" name="todas" id="todas" /></td>
                    </tr>
                    <?php
                        } else {
                            echo '<script type="text/javascript">alert("OCURRIO UN ERROR EN LA BUSQUEDA DE LAS EVALUACIONES");</script>';
                        }
                    ?>
                </table><br>
                <div align="right">
                    <input type="submit" class="botones" value="Confirmar" name="confirmar" style="width:80px;"/> 
                </div>
            </form>
        </div>
    </div>
</body>
