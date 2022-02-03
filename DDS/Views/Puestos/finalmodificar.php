<?php

    $caracteristicas = array();
    $datos = array();
    foreach ($_POST as $key => $value) {
        switch ($key) {
            case 'codigo':
                $datos[$key] = (int) $value;
                break;
            case 'puesto':
                $datos[$key] = $value;
                break;
            case 'descripcion':
                $datos[$key] = $value;
                break;
            case 'empresa':
                $datos[$key] = $value;
                break;
            case 'competenciasSel':
                foreach ($value as $codComp => $valor) {
                    $caracteristicas[] = array("competencia" => (int) $codComp, "ponderacion" => (int) $valor,);
                }
                $datos['caracteristicas'] = $caracteristicas;
                break;
            default:
                break;
        }
    }
    
    $gestorP = new Controllers\GestorPuestos();
    
    $resul = $gestorP->modificarPuesto($datos);
    //echo '<script type="text/javascript">alert("'.$resul.'")</script>';
    if($resul == FALSE){
    ?>
        <script type="text/javascript">
          alert("El puesto no se ha modificado.");
          window.location.href='modificarPuesto';
        </script>
    <?php
    } else { ?> <a name="javascript"></a> <?php } ?>

<script language="JavaScript" type="text/javascript">
    var statusConfirm = confirm("El puesto ha sido modificado ¿Desea modificar otro?");
    if (statusConfirm == true)
    {
        location.href="gestionarPuesto";
    }
    else
    {
        location.href="/DDS/Usuarios/menu";
    }
</script>
    
    
    /*if($resul == 0){
        echo '<script type="text/javascript">alert("FALLA ACTUALIZACION")</script>';
    }
    if($resul == 2){
        echo '<script type="text/javascript">alert("FALLA NOMBRE")</script>';
    }
    if($resul == 3){
        echo '<script type="text/javascript">alert("FALLA VALIDACION")</script>';
    }*/


?>
