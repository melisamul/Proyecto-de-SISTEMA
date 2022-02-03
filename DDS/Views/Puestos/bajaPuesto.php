<body onmousedown="elemento(event);">
<div id="sistema">
<p id="titulo" align="right"><strong>Sistema de Consultoría y Selección Empresarial</strong></p>
</div>
<div id="cabeza" style="vertical-align:middle;">
    <div style="margin:0 auto; padding-top:10px; height:55px; ">
        <p class="nombre">Gestion de Puestos</p>
    </div>    
    <table align="left" border="0" cellpadding="" bgcolor="black" cellspacing="18" width="98.4%"> 
        <td align="left"><button onclick = "javaScript: window.history.back();">Atrás</button></td>
    </table>
</div>
<?php
    
    if(isset($_GET['valor']) == FALSE){
        if($_POST['submit'] == 'Modificar'){
            $resultado=serialize($_POST['codigo']);
            $resul=urlencode($resultado);
            header("Location: modificarPuesto?valor=".$resul);
        } else {
            $codigo = $_POST['codigo']; 
            $gestor = new Controllers\GestorPuestos();
            $retorno = $gestor->comprobarPuestoEliminar($codigo);    

            if($retorno == TRUE){
            ?>
                <script type="text/javascript">
                  alert("El puesto no puedo ser eliminado, ya que presenta evaluaciones Activas o en Proceso.");
                  window.location.href='gestionarPuesto';
                </script>
            <?php
            } else { echo '<input type="hidden" value='.$codigo.' id="codigo"/>'; ?> <a name="javascript"></a> <?php } 

        }
    } else {
        $codigo = $_GET['valor'];
        $gestor = new Controllers\GestorPuestos();
        $retorno = $gestor->eliminameElPuesto($codigo);
        if($retorno == TRUE){
            ?>
                <script type="text/javascript">
                    alert("El puesto fue eliminado");
                    window.location.href='gestionarPuesto';
                </script>
            <?php
        } else {
            ?>
                <script type="text/javascript">
                    alert("El puesto NO pudo ser eliminado. SE presentarion problemas en la BASE DE DATOS. INFORME A SU ADMINISTRADOR.");
                    window.location.href='gestionarPuesto';
                </script>
            <?php

        }
        
    }
    ?>
        
    <script language="JavaScript" type="text/javascript">
        var statusConfirm = confirm("Los datos del puesto seran eliminados del sistema ¿Desea continuar?");
        if (statusConfirm == true)
        {
            var felipe = document.getElementById("codigo");
            
            location.href="bajaPuesto?valor=".concat(felipe.value);
        }
        else
        {
        location.href="gestionarPuesto";
        }
    </script>    
</body>