<?php
//ini_set("display_errors","on");
require_once "conexao/conn.php";
$email = base64_decode($_GET["e"]);
if(isset($_GET["scs"])){
    $alerta = $_GET["scs"];
}elseif(isset($_GET["error"])){
    $alerta = $_GET["error"];
}else{
    $alerta = 0;
}
// server should keep session data for AT LEAST 1 hour
ini_set('session.gc_maxlifetime', 3600);

// each client should remember their session id for EXACTLY 1 hour
session_set_cookie_params(3600);
session_start();
//print session_status();
$conexao = conectar();
$sql ="
 select
    id_usuario as \"id_usuario\",
    nm_usuario AS \"nm_usuario\",
    senha_usuario AS \"senha_usuario\",
    email_usuario AS \"email_usuario\"
 from
    usuario
 where
    email_usuario = '{$email}'
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

//Session::start($email);

print "<header class='mdl-layout__header'>";
   print "<div class='mdl-layout__header-row'>";
   //<img src="imagens/logo.png" alt="wecash">
      print "<span class='mdl-layout-title'>WeCash</span>";
      print "<div class='mdl-layout-spacer'></div>";
      print "<span class='header-current__total'></span>";
   print "</div>";
   print "<div class='mdl-layout__tab-bar mdl-js-ripple-effect'>";
      print "<a href='#tab_movimentacao' class='mdl-layout__tab' id='movimentacao'>Movimentacao</a>";
      print "<a href='#tab_historico' class='mdl-layout__tab is-active' id='historico'>Histórico</a>";
      print "<a href='#tab_planejamento' class='mdl-layout__tab' id='planejamento'>Planejamento</a>";
   print "</div>";
print "</header>";
print "<div class='mdl-layout__drawer'>";
   print "<span class='mdl-layout-title'>";
      print "<div class='back-title'>";
         print "<div id='conteudo-title'>";
            print "<ul class='list-title'>";
               print "<li><img class='img_user_title mdl-button--raised' src='imagens/foto.gif'></li>";
               print "<li class='user-info-1'>{$_SESSION["nm_usuario"]}</li>";
               print "<li class='user-info-2'>{$_SESSION["email_usuario"]}</li>";
            print "</ul>";
            print "<div class='hr'></div>";
         print "</div>";
      print "</div>";
   print "</span>";
   print "<nav class='mdl-navigation'>";
         print "<ul class='navigation-list' style='list-style-type:none;padding:10px;margin-top:10px;'>";
            print "<li><a class='mdl-navigation__link' id='goToSettings' href='javascript:void(0);'><img src='imagens/settings.png' class='menu-icon'>Configurações</a></li>";
            print "<li><a class='mdl-navigation__link' id='getOut' href='rest/control.php?action=logout'><img src='imagens/exit-to-app.png' class='menu-icon'>Sair</a></li>";
         print "</ul>";
      print "</nav>";
print "</div>";

?>