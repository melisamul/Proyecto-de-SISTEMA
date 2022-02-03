<?php namespace Models;
class LDAP {
    
    private $conex;
    public function __construct(){ $this->conex = new \Models\Conexion(); }
    
    public function validarLogin($p_user,$p_pass){
        
        $sql="SELECT * FROM ldap WHERE user='$p_user' AND pass='$p_pass'";
        
        $result = $this->conex->consultaRetorno($sql);
        
        if($result->num_rows != 0){
            return true;
        }else{ return false; }
    }
}
?>