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
    
    $gestor = new Controllers\GestorPuestos();
    $var = $gestor->darAltaPuestos($datos);    
    if($var == FALSE){
    ?>
        <script type="text/javascript">
          alert("El puesto no se ha registrado.");
          window.location.href='altaPuesto';
        </script>
    <?php
    } else { ?> <a name="javascript"></a> <?php } ?>

<script language="JavaScript" type="text/javascript">
    var statusConfirm = confirm("El puesto ha sido creado ¿Desea crear otro puesto?");
    if (statusConfirm == true)
    {
        location.href="altaPuesto";
    }
    else
    {
    location.href="gestionarPuesto";
    }
</script>
