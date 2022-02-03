<?php 

    if(isset($_GET['var'])){    
        $recibido=stripcslashes($_GET['var']);
        $rec=urldecode($recibido);
        $datos=unserialize($rec);        
        $gestorCuestionario = new \Controllers\GestorCuestionarios();
        $res = $gestorCuestionario->comprobarEstado($datos['clave']);
        switch ($res) {
            case 1:
                $continuar = TRUE;
                break;
            default:
                $continuar = FALSE;
                break;
        }
        if($continuar == FALSE){
            $resul = serialize($res);
            $result=urlencode($resul);
            header("Location: /DDS/Usuarios/autentificar?valor=".$resul);
        }
        
    ?>
<body onmousedown="elemento(event);">
    <div id="sistema"><p id="titulo" align="right"><strong>Sistema de Consultoría y Selección Empresarial</strong></p></div>
    <div id="cabeza" style="vertical-align:middle;"><div id="texto-cabeza"><p class="nombre">Cuestionario</p></div></div>
    <div id="cabeza-boton" style="vertical-align:middle;">
        <table align="left" border="0" cellpadding="0" bgcolor="black" cellspacing="15" width="98.4%"> 
            <td align="left"><button onclick = "javaScript: window.history.back();">Atrás</button></td>
        </table>
    </div>
    <div class="box-principal">
        <div id="cuerpo" style="margin-top:10px;">
            <p style="color: #666; font-style: italic; font-size: 16px;"> Instrucciones </p>
            <div style="border-style:solid; border-color:#666; height:310px; width:700px; margin-top:2px;">
            
                <p style="font-size: 14px; margin-left: 10px; text-align: left;">
                    <?php $instruc = $gestorCuestionario->recuperaInstruciones(); 
                    $instruc_arreglo = explode("-", $instruc);
                    //echo "<br>";
                    foreach ($instruc_arreglo as $segmento) {
                        echo $segmento."<br><br>";
                    }
                    ?> </p>
            </div>
            <div align="right" style="margin-top:10px;">
                <form action="//localhost/DDS/Cuestionarios/iniciarCuestionario" method="post" name="form1" >
                    <input class="text" type="hidden" value="<?php echo $datos['clave']?>" name="clave"/>
                    <input class="botones" type="submit" value="Aceptar" />
                    <input class="botones" type="reset" value="Cancelar" onclick="javaScript: window.history.back();"/>
                </form>  
            </div>
        </div>
    </div>
</body>
<?php 
    }
?>