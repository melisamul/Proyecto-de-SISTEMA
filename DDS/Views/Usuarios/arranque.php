<?php
    $sys = new \Models_DAO\sysParamDAO();
    $sys->desregistrarconsultor();
    $GLOBALS['template']->mostrar = FALSE;
    $GLOBALS['template']->usuario_logeado = FALSE;
    
?>
<body>
    <div>
    <table width="500" align="center">
        <tr>
            <td height="300" align="left">
                <link href='http://localhost/DDS/Views/Template/css/cosmos.css?family=Josefin+Sans' rel='stylesheet' type='text/css'>
                <h1>
                    <em>S</em>
                    <em>i</em>
                    <em class="planet left">°</em>
                    <em>C</em>
                    <em class="planet right">°</em>
                    <em>S</em>
                    <em>E</em>
                </h1>
            </td>
        </tr>
        <tr>
            <td height="50" align="center">
                <div>
                    <MARQUEE WIDTH=100% SCROLLAMOUNT=15><font size="6">SISTEMA DE CONSULTORIA Y SELECCION EMPRESARIAL</font></MARQUEE>
                </div>
            </td>
        </tr>
        <tr>
            <td height="150" align="center">
                <input style="height:30px; width:100px;" type="button" value="Ingresar" class="botones" onclick="location = '//localhost/DDS/Usuarios/autentificar'"></input>
            </td>
        </tr>
    </table>
    </div>
</body>