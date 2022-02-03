<?php namespace Models_DAO;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class AuditorDAO implements \Models_DAO\AdministradorBD {
     
    private $conex;
    
    public function __construct(){ $this->conex = $GLOBALS['conex']; }
    public function borrar($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; } //metodo que recibe un INSTANCIA de una ENTITY del sistema. Debe eliminar dicha entida de la BD
    public function listar($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; } //
    public function get_atributo($p_atributo, $p_parametro){ echo "<br>METODO NO IMPLEMENTADO ".$p_atributo." ".$p_parametro; }
    public function get($p_atributo, $p_parametro){ echo "<br>METODO NO IMPLEMENTADO ".$p_atributo." ".$p_parametro; }// BUSCAR
    public function update($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; }
    public function exists($p_atributo){ echo "<br>METODO NO IMPLEMENTADO ".$p_atributo; }
    public function set($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; }// BUSCAR
    public function insert($p_objeto){ echo "<br>METODO NO IMPLEMENTADO ".$p_objeto; }   // INSERT
    
    
    public function inserts($auditoria){
        $puestoDAO = new \Models_DAO\PuestoDAO();
        $user=$auditoria->get('consultor');
        $fecha= $auditoria->get('fecha');
        $codigo=$auditoria->get('entidad')->get('codigo');
        $sql1 = $puestoDAO->borrar($codigo);
        $sql2="INSERT INTO `registro_de_auditoria`( `fecha`, `idConsultor`) "
                . "SELECT '$fecha', c.idconsultor FROM consultor c WHERE c.user='".$user->get('user')."';";
        $sql3="UPDATE `puesto`  SET `idRegistro_de_Auditoria` = (SELECT MAX(idregistro_de_auditoria) FROM registro_de_auditoria ) "
                . "WHERE codigo = $codigo";
        return $this->conex->generalAtomic(array($sql1[0],$sql1[1],$sql2,$sql3));        
    }
    
}
?>