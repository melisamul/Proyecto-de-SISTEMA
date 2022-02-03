<?php namespace Views;

class Template {
    public $usuario_logeado;
    public $mostrar;
    public function __construct(){
?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <link href="<?php echo URL.'';?>Views/Template/css/estiloTab.css" rel="stylesheet" type="text/css"/>
                <link href="<?php echo URL.'';?>Views/Template/css/estilo.css" rel="stylesheet" type="text/css"/>
                <script type="text/javascript" src="//localhost/DDS/Views/Template/javaScript/funcionesJava.js"></script>
                <style type="text/css"> body { background-color: #f0f0f0; } </style>
                <title>SICSE V.01</title>
            </head>
<?php
    }
    public function __destruct(){
?>
                <table align="center" border="0" cellpadding="0" bgcolor="black" cellspacing="4" height="35" width="800">
                    <tr>
                        <td style=" color: white; text-align: left;"><?php  if($this->mostrar !== FALSE){ echo "SiCSE - Hoy es ".date('d/m/Y'); }?></td>
                        <td style=" color: white; text-align: right;"><?php if($this->usuario_logeado !== FALSE){ echo $this->usuario_logeado;}?></td>
                    </tr>
                </table>
        </html>
<?php
    }
}


?>