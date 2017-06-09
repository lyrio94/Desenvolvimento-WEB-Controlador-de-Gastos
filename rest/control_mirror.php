<?php
    ini_set("display_errors","on");
    date_default_timezone_set('America/Sao_Paulo');
    require_once '../util/conexao.php';
    require_once 'rest.php';

    class Control{

        function Control($action){
            $this->$action();
        }

        private function recusarPedido(){
            $rest = new Rest();
            print $rest->recusarPedido($_POST["id_pedido"],$_POST["id_device"]);
        }

        private function recusarPedidos(){
            $rest = new Rest();
            print $rest->recusarPedidos($_POST["id_pedido"],$_POST["id_device"]);
        }

        private function recusarCotacao(){
            $rest = new Rest();
            print $rest->recusarCotacao($_POST["id_cotacao"]);
        }

        private function recusarCotacoes(){
            $rest = new Rest();
            print $rest->recusarCotacoes($_POST["id_cotacao"]);
        }

        private function encaminharMercadoria(){
            $rest = new Rest();
            print $rest->encaminharMercadoria($_POST["id_pedido"], $_POST["id_device"]);
        }

        private function encaminharMercadorias(){
            $rest = new Rest();
            print $rest->encaminharMercadorias($_POST["id_pedido"], $_POST["id_device"]);
        }

        private function listarCotacoes(){
            $rest = new Rest();
            print $rest->listarCotacoes($_POST["registration_id"]);
        }

        private function settingsCotacao(){
            $rest = new Rest();
            print $rest->settingsCotacao($_POST["id_usuario"],$_POST["registration_id"],$_POST["id_fornecedor"]);
        }

        private function settingsPedido(){
            $rest = new Rest();
            print $rest->settingsPedido($_POST["id_usuario"],$_POST["registration_id"],$_POST["id_fornecedor"]);
        }

        private function listarPedidos(){
            $rest = new Rest();
            print $rest->listarPedidos($_POST["registration_id"]);
        }

        private function pedido(){
            $rest = new Rest();
            $itens = $rest->itens($_POST["id_pedido"], $_POST["id_device"]);
            $parcelas = $rest->parcelas($_POST["id_pedido"]);
            print '{"pedido":{
                "itens": '.$itens.',
                "parcelas": '.$parcelas.'
            }}';

        }

        private function cotacao(){

            $rest = new Rest();
            $parametros = $rest->parametros($_POST["id_cotacao"]);
            $itens = $rest->itensCotacao($_POST["id_cotacao"]);
            print '{"cotacao":{
                "parametros" : '.json_encode($parametros).',
                "itens": '.$itens.'
            }}';
        }

        private function parametros(){
            $rest = new Rest();
            print "<pre>";
            print_r($rest->parametros($_POST["id_cotacao"]));
            print "</pre>";
        }

        private function registrarDevice(){
            $rest = new Rest();
            print $rest->registrarDevice($_POST["id_usuario"], $_POST["registration_id"], $_POST["phone_id"], $_POST["phone_number"], $_POST["phone_api"]);
            //$rest->registrarDevice($_GET["id_usuario"], $_GET["registration_id"]);
        }

        private function sendMessage(){
            $rest = new Rest();
            $rest->sendMessage();
        }

        private function login(){

            $rest = new Rest();
            print $rest->login($_POST["nr_cgc"], $_POST["nm_usuario"], $_POST["nm_senha"]);

        }

        private function logo(){
            $file = "../social/img/logo/" . $_GET["image"] . "-1-logo.jpg";
            header("content-type: image/jpeg");
            if(file_exists($file)){
                print file_get_contents($file);
            }else{
                print base64_decode("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tJhRRRXSZhRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAHIIIGf8AOK+gPgouLLW+c/vUH5Cvn/nacHH/AOuvor4KoB4b1l/4jdKM/ga4sx/hG9Dc9t/j/ClpP4/wpa+cPRCiiigAooooAKKKKACiiigAooooAKKKKAEbpTSSEB96c3Smt/qvxH86GB88/GpR/beiyY+Ywuv5NXiFe4/Gn/kKaL/uSf8AoQrw6vpcD/BR5tf4wooorrMQooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKAFHORX0Z8FwR4W1U9muVP6GvnRep9+P1r6S+DCj/hA79+/2wr+VcOY/wTehrI9j/j/Clo75or509EKKKKACiiigAooooAKKKKACiiigAooooARulNb/AFX4j+dObpTW/wBV+I/nQwPnv40/8hTRf9yT/wBCFeHV7j8af+Qpov8AuSf+hCvDq+lwX8FHm1/jCiiiusxCiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAcv3h9R/MV9KfBj/kn1/wD9fzV81Dr9Ofy5r6W+DQ2/D7UPa/cfoD/WuDMv4Jth5JTsew0UgOaWvnU7npBRRRTAKKKKACiiigAooooAKKKKACiiigBG6U1v9V+I/nTiMimnkbfcfzqZNKwHz38af+Qpov8AuSf+hCvDq9y+NI/4mmif7kn8xXhxGBX0+B/go82urTEooorrMQooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKX1yccUlKBuO3O3PegC5YadfanfrbWFrPdTMDlYlyV7ZPtzX018LNK1PSPBt9a6pZyWczXjSKr9wQB/SvOvg48R+IOpK3+ua0YqvoAyV9JLguSBjgE14eZ1nzch14ekn7xJ3ooorykdoUUUUwCiiigAooooAKKKKACiiigAooooAKjP3vxqSm7eaiabsB8/fGSOabWNEWOGR8RuWKqSBk14XxnHRhncD1Ffd0tvDIwMkUcmOBuXOK+OPGEcUfxP1uODiEXJCgdBivdy+s5e4jgxUWpXOYI4zSUpPyikr1jmCiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigApRxz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");
            }
        }

        private function logoFornecedor(){
            $file = "../social/img/logo/" . $_GET["image"] . "-2-logo.jpg";
            header("content-type: image/jpeg");
            if(file_exists($file)){
                print file_get_contents($file);
            }else{
                print base64_decode("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tJhRRRXSZhRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAHIIIGf8AOK+gPgouLLW+c/vUH5Cvn/nacHH/AOuvor4KoB4b1l/4jdKM/ga4sx/hG9Dc9t/j/ClpP4/wpa+cPRCiiigAooooAKKKKACiiigAooooAKKKKAEbpTSSEB96c3Smt/qvxH86GB88/GpR/beiyY+Ywuv5NXiFe4/Gn/kKaL/uSf8AoQrw6vpcD/BR5tf4wooorrMQooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKAFHORX0Z8FwR4W1U9muVP6GvnRep9+P1r6S+DCj/hA79+/2wr+VcOY/wTehrI9j/j/Clo75or509EKKKKACiiigAooooAKKKKACiiigAooooARulNb/AFX4j+dObpTW/wBV+I/nQwPnv40/8hTRf9yT/wBCFeHV7j8af+Qpov8AuSf+hCvDq+lwX8FHm1/jCiiiusxCiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAcv3h9R/MV9KfBj/kn1/wD9fzV81Dr9Ofy5r6W+DQ2/D7UPa/cfoD/WuDMv4Jth5JTsew0UgOaWvnU7npBRRRTAKKKKACiiigAooooAKKKKACiiigBG6U1v9V+I/nTiMimnkbfcfzqZNKwHz38af+Qpov8AuSf+hCvDq9y+NI/4mmif7kn8xXhxGBX0+B/go82urTEooorrMQooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKX1yccUlKBuO3O3PegC5YadfanfrbWFrPdTMDlYlyV7ZPtzX018LNK1PSPBt9a6pZyWczXjSKr9wQB/SvOvg48R+IOpK3+ua0YqvoAyV9JLguSBjgE14eZ1nzch14ekn7xJ3ooorykdoUUUUwCiiigAooooAKKKKACiiigAooooAKjP3vxqSm7eaiabsB8/fGSOabWNEWOGR8RuWKqSBk14XxnHRhncD1Ffd0tvDIwMkUcmOBuXOK+OPGEcUfxP1uODiEXJCgdBivdy+s5e4jgxUWpXOYI4zSUpPyikr1jmCiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigApRxz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");
            }
        }

        private function item(){

            $file = "../upload/produtos/" . $_GET["image"];

            if(file_exists($file . ".jpg")) {
                header("content-type: image/jpeg");
                print file_get_contents($file . ".jpg");
            }else if(file_exists($file . ".png")){
                header("content-type: image/png");
                //imagepng(imagecreatefrompng($file . ".png"));
                print file_get_contents($file . ".png");
            }else{
                header("content-type: image/png");
                $file = "../catalago/no_image.png";
                print file_get_contents($file);
            }
        }

        private function formasPagamento(){
            $rest = new Rest();
            print $rest->formasPagamento();
        }

        private function salvarCotacao()
        {

            $rest = new Rest();
            $id_device = $_POST["id_device"];
            $id_cotacao = $_POST["id_cotacao"];
            $id_usuario = $_POST["id_usuario"];
            $id_forma = $_POST["id_forma"];
            $dt_validade_proposta = $_POST["dt_validade_proposta"];
            $vl_minimo_faturamento = str_replace(".", ",", $_POST["vl_min_faturamento"]);
            $te_frete = $_POST["te_frete"];

            $retorno = $rest->salvar_cotacao($id_cotacao, $id_forma, $dt_validade_proposta, $vl_minimo_faturamento, $te_frete);

            if ($retorno == 1) {

                for ($i = 0; $i < count($_POST["id_produto"]); $i++) {

                    $id_produto = $_POST["id_produto"][$i];
                    $nm_marca = $_POST["nm_marca"][$i];
                    $vl_item = str_replace(".", ",", $_POST["vl_item"][$i]);
                    $qt_cotado = str_replace(".", ",", $_POST["qt_cotado"][$i]);
                    $nr_prazo = $_POST["nr_prazo"][$i];
                    $nm_unidade = $_POST["nm_unidade"][$i];
                    $vl_ipi = str_replace(".", ",", $_POST["vl_ipi"][$i]);
                    $cs_tem = ($_POST["cs_tem"][$i] == "true") ? 1 : 0;
                    $cs_importado = ($_POST["cs_importado"][$i] == "true") ? "S" : "N";

                    $retorno = $rest->salvar_item($id_cotacao, $id_produto, $id_usuario, $cs_tem, $vl_item, $nm_marca, $qt_cotado, $nm_unidade, $nr_prazo, $vl_ipi, $cs_importado, $id_device);

                    if ($retorno != 1) {
                        break;
                    }

                }

            }

            switch($retorno){
                case 1:
                    print json_encode((object)array("OK" => true, "message" => "Cotação sincronizada com sucesso."));
                    break;
                case 2:
                    print json_encode((object)array("OK" => false, "message" => "Essa cotação já foi enviado para o cliente por outro usuário."));
                    break;
                case 3:
                    print json_encode((object)array("OK" => false, "message" => "Não foi possível sincronizar as alterações. Essa solicitação foi FECHADA pelo comprador (para receber os preços) enquanto você preenchia o formulário."));
                    break;
                default:
                    print json_encode((object)array("OK" => false, "message" => "Arrrrrg, algum erro ocorreu - Debug RETORNO: " . $retorno));
            }


        }

        private function enviarCotacao(){
            $rest = new Rest();
            print $rest->enviar_cotacao($_POST["id_cotacao"]);
        }

        private function reativarCotacao(){
            $rest = new Rest();
            print $rest->reativar_cotacao($_POST["id_cotacao"]);
        }

        private function limparCotacao(){
            $rest = new Rest();
            $rest->limpar_cotacao($_POST["id_cotacao"]);
        }

        private function sincronizarItens(){
            $rest = new Rest();
            print '{"itens":'.$rest->sincronizarItens($_POST["registration_id"]).'}';
        }

    }

    if(isset($_GET["action"])) {
        new Control($_GET["action"]);
    }

    if(isset($_POST["action"])) {
        new Control($_POST["action"]);
    }

?>