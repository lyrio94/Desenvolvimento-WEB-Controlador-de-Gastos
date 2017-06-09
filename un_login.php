<?php

$email = $_POST["email"];
$senha = md5($_POST["senha"]);
$retorno = 1;

$sql = "select count(*) from usuario where email_usuario = '{$email}' and senha_usuario = md5({$senha})";

$conexao = conectar();
$stmt = mysqli_query($sonexao, $sql);
$rs = mysqli_fetch_array($stmt);

if($rs[0] != 0){
   session_start();
   $sSql = "select * from usuario where email_usuario = '{$email}' and senha_usuario = md5({$senha})";
   $sStmt = mysqli_query($sonexao, $sSql);
   $sRs = mysqli_fetch_array($sStmt);
   $sRs["nm_usuario"] = $_SESSION["nome_usuario"];
   $sRs["senha_usuario"] = $_SESSION["senha_usuario"];
   $sRs["email_usuario"] = $_SESSION["email_usuario"];
   header("Location:inicial.php");
}else{
   $retorno = 2;
   header("Location:principla.php");
}
?>