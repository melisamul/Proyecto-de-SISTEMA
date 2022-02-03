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
            <p align="left" style="font-style:italic; font-size:14px; color:#666">Ponderé las competencias seleccionadas: </p>
            <form  method="post" action="finalmodificar" name="form1" onsubmit="return validarPonderaciones()">
                <table align="center" width="500" border="1" cellspacing="0" cellpadding="5">
                    <tr bgcolor="#cccccc">
                        <td height="35" bgcolor="#cccccc"><strong>Compentencias Seleccionadas</strong></td>
                        <td height="35" bgcolor="#cccccc"><strong>Ponderaci&oacuten </strong></td>
                    </tr>
                    <?php
                    if (isset($_POST)) {
                        //print_r($_POST);
                        if(count($_POST) == 5){ 
                            $resultado=serialize($_POST['codigo']);
                            $resul=urlencode($resultado);
                            header("Location: modificarPuesto?valor=".$resul);
                        }
                        $DAOPuesto = new Models_DAO\PuestoDAO();
                        $esNom = $DAOPuesto->existeNombre($_POST['puesto']);
                        if($esNom == TRUE){
                            $nomActual = $DAOPuesto->get_atributo('nombre', $_POST['codigo']);
                            if($_POST['puesto'] != $nomActual){ 
                                $_POST['aceptar'] = 'nombre'; 
                                $resultado=serialize($_POST); $resul=urlencode($resultado);
                                header("Location: modificarPuesto?error=".$resul);
                            }
                        }
                        $gestorCom = new Controllers\GestorCompetencias();
                        $gestorPuesto = new Controllers\GestorPuestos();
                        $codigo = $_POST['codigo'];
                        $puesto = $_POST['puesto'];
                        $descripcion = $_POST['descripcion'];
                        $empresa = $_POST['empresa'];
                        $lista = $_POST['competenciasSel'];

                        echo '<input type="hidden" name="codigo" id="codigo" value="'.$codigo.'">'
                            . '<input type="hidden" name="puesto" id="puesto" value="'.$puesto.'">'
                            . '<input type="hidden" name="descripcion" id="descripcion" value="'.$descripcion.'">'
                            . '<input type="hidden" name="empresa" id="empresa" value="'.$empresa.'">';

                        if(count($lista)!= 0){
                            echo '<input type="hidden" name="cantidad" id="cantidad" value="'.count($lista).'">';
                            foreach ($lista as $clave => $codigoCom){
                                $nombre = $gestorCom->recuperarNombre($codigoCom);
                                if(is_bool($nombre) == false){
                                    echo '<tr bgcolor="#cccccc">
                                        <td height="50" bgcolor="#FFFFFF">'.$nombre.'</td><td height="50" bgcolor="#FFFFFF"><label>
                                        <div align="center" style="vertical-align:middle;">';                
                                        $pond = $gestorPuesto->recuperarPonderacion($codigoCom, $codigo); 
                                        if($pond != -1) { 
                                            echo '<input type="text" name="competenciasSel['.$codigoCom.']" id="'.$clave.'" value="'.$pond.'"/>'; 
                                        } else {
                                            echo '<input type="text" name="competenciasSel['.$codigoCom.']" id="'.$clave.'" />';}
                                        echo '</div></label></td></tr>';
                                }
                            }
                        }
                     }
                    ?>
                </table><br>
                <div align="right">
                    <input class="botones" type="submit" name="Aceptar" value="Aceptar" />
                    <input type="button" name="Cancelar" value="Cancelar" class="botones"/> 
                </div>
            </form>
        </div>
    </div>
</body>