<?php
/**
* Programador: Vijay Lopes Kapoor
* Data: 10/05/2017
**/
ini_set("display_errors","on");
date_default_timezone_set("America/Sao_Paulo");

require_once "conexao/conn.php";
//require_once "../database/LoginDAO.php";

class Session{

   private $sessao;

   private static function _start($email){
      session_start();
      $conexao = conectar();
      $sql = "
      select id_usuario from usuario where email_usuario = '{$email}'
      ";
      $stmt = mysqli_query($conexao, $sql);
      $rs = mysqli_fetch_array($stmt);
      self::setSessionVariables($rs[0]);
   }

   public static function stop(){
       // remove all session variables
       session_unset();

       // destroy the session
       session_destroy();
   }

   public static function setSessionVariables($id){
         $sql = "
         select
            id_usuario as \"id_usuario\",
            nm_usuario AS \"nm_usuario\",
            senha_usuario AS \"senha_usuario\",
            email_usuario AS \"email_usuario\"
         from
            usuario
         where
            id_usuario = {$id}
         ";
         
      try{
            $conexao = conectar();

            $stmt = mysqli_query($conexao, $sql);
            $rs = mysqli_fetch_array($stmt);
            $_SESSION["id_usuario"] = $rs["id_usuario"];
            $_SESSION["nm_usuario"] = $rs["nm_usuario"];
            $_SESSION["email_usuario"] = $rs["email_usuario"];
            $_SESSION["senha_usuario"] = $rs["senha_usuario"];

      }catch(Exception $e){

      }
   }

   private static function _setSessionVariables($array){
         $_SESSION['data'] = $array;
   }

   public static function start($email){
            self::_start($email);
   }

}

//Session::start("juju@gmail.com");
//print $_SESSION["id_usuario"];

?>