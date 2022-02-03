<?php namespace Models;

class Conexion{
    private $datos = array(
        "host"=> "localhost",
        "user"=> "root",
	"pass"=> "",
	"db"=> "mydb"
    );
		
    
    private $con;
    
    public function __construct(){
        $this->con = \mysqli_connect($this->datos['host'], $this->datos['user'], $this->datos['pass'], $this->datos['db']);
        /* Comprobar la conexión */
        if (!$this->con) {
            printf("Falló la conexión: %s\n", \mysqli_connect_error());
            exit();
        }
    }

    public function consultaSimple($sql){
        $this->con->query($sql);
    }

    public function consultaRetorno($sql){
        $datos = $this->con->query($sql);
        return $datos;
    }
    
    public function getCon(){ return $this->con; }
    
    public function generalAtomic(Array $consultas){ 
        //EN ESTE MODULO HACEMOS LA INSERSION DE UNA VEZ DE FORMA ATOMICA
        $enlace = $this->con;
        
        /* Desactivar la autoconsignación */
        \mysqli_autocommit($enlace, FALSE);

        \mysqli_query($enlace, "CREATE TABLE Language LIKE CountryLanguage");

        /* Hace las insersiones en orden */
        foreach ($consultas as $key => $sql_) {
            \mysqli_query($enlace, $sql_);    
        }
        
        /* Consignar la transación */
        if (!\mysqli_commit($enlace)) {
            echo '<script type="text/javascript">alert("ERROR: Falló la consignación de la transacción atomica")</script>';
            return false;
        }
        
        /* Cerrar la conexión */
        //\mysqli_close($enlace);
        
        return true;
    }
    
}
?>