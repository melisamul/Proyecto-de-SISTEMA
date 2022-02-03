<?php namespace Controllers;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class GestorAuditor{
   public function __construct(){ }
   
   public function registrarEliminacion($puesto){
       $userDAO = new \Models_DAO\sysParamDAO();      
       $consultor = $userDAO->logueado();
       $auditorsucesos= new \Models_DAO\AuditorDAO();
       $auditoria=new \Models_Entitys\AuditorDeSucesos();
       $auditoria->set('consultor', $consultor);
       $auditoria->set('entidad', $puesto);
       $auditoria->set('tipomovimiento', 'eliminacion');
       
       return $auditorsucesos->inserts($auditoria);     
   }
}


?>