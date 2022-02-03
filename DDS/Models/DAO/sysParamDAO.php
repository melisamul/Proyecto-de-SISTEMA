<?php namespace Models_DAO;

class sysParamDAO {
    
    private $conex;
    
    public function __construct() { $this->conex = $GLOBALS['conex']; }
    
    public function retornar($param) {
        $sql = "SELECT $param FROM sys_param WHERE idsys_param = 1";
        $retorno = $this->conex->consultaRetorno($sql);
        
        if($retorno->num_rows != 0){
            foreach ($retorno as $row) {
                return $row[$param];
            }
        }
    }
    
    public function registrarconsultor($p_user) {
        $sql = "UPDATE `sys_param` SET `user_log`= '$p_user' WHERE `idsys_param` = 1";
        $this->conex->consultaSimple($sql);
    }
    
    public function desregistrarconsultor() {
        $sql = "UPDATE `sys_param` SET `user_log`= 'NULL' WHERE `idsys_param` = 1";
        $this->conex->consultaSimple($sql);
    }
    
    public function logueado() {
        $sql = "SELECT user_log FROM sys_param";
        $respuesta = $this->conex->consultaRetorno($sql);
        if($respuesta->num_rows != 0){
            $DAOuser = new \Models_DAO\UsuarioDAO();
            foreach ($respuesta as $row) {
                $consultor = $DAOuser->get_consultor($row['user_log']);
            }
            return $consultor;
        } else { return FALSE; }
    }
}
