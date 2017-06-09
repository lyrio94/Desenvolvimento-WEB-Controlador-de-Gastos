<?php
ini_set("display_errors","on");
date_default_timezone_set('America/Sao_Paulo');
require_once '../conexao/conn.php';
require_once 'rest.php';

class Control{

    function Control($action){
        $this->$action();
    }

    private function logout(){
        if(session_status() == 2){
            session_unset();
            session_destroy();
        }
        header("Location: ../principal.php");
    }

    private function login(){
        $rest = new Rest();
        $logado = $rest->login($_POST["email_usuario"], $_POST["senha_usuario"]);
        $header_location = "../inicial.php?scs=login&e=".base64_encode($_POST["email_usuario"]);
        if($logado == 0){
            $header_location = "../principal.php?error=login";
        }
        header("Location: {$header_location}");
    }

    private function cadastrarUsuario(){
        $rest = new Rest();
        ($rest->cadastrarUsuario(utf8_decode($_POST["nome_usuario"]), $_POST["email_usuario"], $_POST["senha_usuario"])) ? header("Location: ../principal.php?scs=cadastro?e=".base64_encode($_POST["email_usuario"])) : header("Location: ../principal.php?error=cadastro");
    }

    private function addMovimentacao(){
        $rest = new Rest();
        print $rest->addMovimentacao($_POST["nm_movimentacao"],$_POST["vl_movimentacao"],$_POST["dt_movimentacao"],$_POST["cs_identificador"],$_POST["id_usuario"],$_POST["id_categoria"],$_POST["id_conta"],$_GET["mes"]);
        $rest->updateSaldo($_POST["id_conta"], $_POST["id_usuario"]);
//        header("Location: ../inicial.php");
    }
    
    private function listaMovimentacao(){
        $rest = new Rest();
        print $rest->listaMovimentacao($_POST["usuario"],$_POST["mes"]);
    }

    private function excluir_movimentacao(){
        $rest = new Rest();
        print $rest->excluir_movimentacao($_POST["id_movimentacao"], $_POST["id_usuario"], $_POST["id_conta"]);
        $rest->updateSaldo($_POST["id_conta"], $_POST["id_usuario"]);
    }

    private function addConta(){
        $rest = new Rest();
        $rest->addConta(utf8_encode($_POST["nm_conta"]),$_POST["id_usuario"],$_POST["sd_conta"]);
        header("Location: ../inicial.php");
    }

    private function listaConta(){
        $rest = new Rest();
        print $rest->listaConta($_POST["usuario"]);
    }

    private function excluir_conta(){
        $rest = new Rest();
        print $rest->excluir_conta($_POST["id_conta"], $_POST["id_usuario"]);
    }

    private function presentSaldo(){
        $rest = new Rest();
        print $rest->presentSaldo($_POST["id_usuario"]);
    }

    private function addCategoria(){
        $rest = new Rest();
        $rest->addCategoria($_POST["nm_categoria"], $_POST["id_usuario"], $_POST["id_tipo_categoria"]);
    }

    private function listaTipoCategoria(){
        $rest = new Rest();
        print $rest->listaTipoCategoria();
    }

    private function categorias(){
        $rest = new Rest();
        print $rest->categorias($_POST["id_usuario"]);
    }

    private function listaPlanejamento(){
        $rest = new Rest();
        print $rest->listaPlanejamento($_POST["usuario"]);
    }

}

if(isset($_GET["action"])) {
    new Control($_GET["action"]);
}

if(isset($_POST["action"])) {
    new Control($_POST["action"]);
}

?>