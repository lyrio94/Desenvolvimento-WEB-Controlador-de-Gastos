<?php

    class Rest{

        public function login($nr_cgc, $nm_usuario, $nm_senha){

            try{

                $conexao = new Conexao();
                $conexao->conectar();

                $sql = "select count(*) from usuarios where nr_cgc = '".$nr_cgc."' and cs_tipo = 2";
                    $stmt = oci_parse($conexao -> conexao, $sql);
                    oci_execute($stmt);
                    while($verificacao_cgc = oci_fetch_array($stmt)){
                        $cgc = $verificacao_cgc[0];
                    }

                    $invalid_cnpj = "2";
                    if($cgc == 0){
                        print '{"erro":{"code":'.json_encode($invalid_cnpj).'}}';
                        return;
                    }

                $sql = "select count(*) from usuarios where upper(nm_usuario) = upper('".$nm_usuario."') and nr_cgc = '".$nr_cgc."' and cs_tipo = 2";
                    $stmt = oci_parse($conexao -> conexao,$sql);
                    oci_execute($stmt);
                    while($verificacao_usuario = oci_fetch_array($stmt)){
                        $usuario = $verificacao_usuario[0];
                    }

                    $invalid_usuario = "3";
                    if($usuario == 0){
                        print '{"erro":{"code":'.json_encode($invalid_usuario).'}}';
                        return;
                    }

                $sql = "select count(*) from usuarios where nm_senha = md5('".$nm_senha."') and nr_cgc = '".$nr_cgc."' and upper(nm_usuario) = upper('".$nm_usuario."') and cs_tipo = 2";
                    $stmt = oci_parse($conexao -> conexao,$sql);
                    oci_execute($stmt);
                    while($verificacao_senha = oci_fetch_array($stmt)){
                        $senha = $verificacao_senha[0];
                    }

                    $invalid_senha = "4";
                    if($senha == 0){
                        print '{"erro":{"code":'.json_encode($invalid_senha).'}}';
                        return;
                    }



                $rs = oci_new_cursor($conexao->conexao);
                $stmt = oci_parse($conexao->conexao, "BEGIN REST_APP.LOGIN(:CGC, :USUARIO, :SENHA, :RS); END;");

                oci_bind_by_name($stmt, ":RS", $rs, -1, OCI_B_CURSOR);
                oci_bind_by_name($stmt, ":CGC", $nr_cgc, 20);
                oci_bind_by_name($stmt, ":USUARIO", $nm_usuario, 100);
                oci_bind_by_name($stmt, ":SENHA", $nm_senha, 100);

                oci_execute($stmt);
                oci_execute($rs);

                $json = array();
                while($data = oci_fetch_array($rs, OCI_ASSOC)){
                    array_walk($data, function (&$entry) {
                        $entry = utf8_encode($entry);
                    });
                    $json[] = $data;
                }

                return '{"usuario":'.json_encode($json[0]).'}';

            }catch(Exception $ex){

            }

        }

        private function prepara_in($array){

            $limite = 999;
            $ins = array_chunk($array, $limite);
            $sql = "";
            foreach ($ins as $in){
                $in = implode(',', $in);
                if($in!=""){
                    $sql .= " AND ID_SINCRONIZACAO IN ({$in}) ";
                }
            }
            return $sql;
        }

        private function vistoCotacao($conexao, $id_cotacao){
            $sql = "UPDATE COTACOES SET CS_NOVO = 'N' WHERE ID_COTACAO = :ID";
            try{
                $dml = oci_parse($conexao, $sql);
                oci_bind_by_name($dml, ':ID', $id_cotacao);
                oci_execute($dml);
            }catch(Exception $ex){

            }
        }

        public function listarCotacoes($hs_device){

            try{

                $conexao = new Conexao();
                $conexao->conectar();

                $sql = "
                SELECT C.ID_COTACAO as \"id_cotacao\",
                       C.ID_COTACAO_MD5 as \"id_cotacao_md5\",
                       C.CS_NOVO as \"cs_novo\",
                       RETORNA_DATA_JAVA(C.DT_COTACAO) as \"dt_cotacao\",
                       RETORNA_DATA_JAVA(C.DT_RECEBIMENTO) as \"dt_recebimento\",
                       (SELECT NVL(C.ID_FORMA,CXF.ID_FORMA) FROM COMPRADORXFORNECEDOR CXF WHERE ID_COMPRADOR = SOL.ID_COMPRADOR AND ID_FORNECEDOR = F.ID_FORNECEDOR ) AS \"id_forma\",
                       (SELECT NVL(C.TE_FRETE,CXF.TE_FRETE) FROM COMPRADORXFORNECEDOR CXF WHERE ID_COMPRADOR = SOL.ID_COMPRADOR AND ID_FORNECEDOR = F.ID_FORNECEDOR ) as \"te_frete\",
                       (SELECT NVL(NVL(C.VL_MIN_FATURAMENTO, CXF.VL_MIN_FATURAMENTO),0) FROM COMPRADORXFORNECEDOR CXF WHERE ID_COMPRADOR = SOL.ID_COMPRADOR AND ID_FORNECEDOR = F.ID_FORNECEDOR ) as \"vl_min_faturamento\",
                       SOL.ID_SOLICITACAO as \"id_solicitacao\",
                       SOL.NR_SOLICITACAO_CLIENTE as \"nr_solicitacao_cliente\",
                       RETORNA_DATA_JAVA(SOL.DT_VALIDADE) as \"dt_validade\",
                       RETORNA_DATA_JAVA(SOL.DT_FECHAMENTO) as \"dt_fechamento\",
                       SOL.ID_COMPRADOR as \"id_comprador\",
                       (SELECT NM_FANTASIA FROM COMPRADORES WHERE ID_COMPRADOR = SOL.ID_COMPRADOR) as \"fantasia_comprador\",
                       (SELECT NR_TELEFONE FROM COMPRADORES WHERE ID_COMPRADOR = SOL.ID_COMPRADOR) as \"telefone_comprador\",
                       SOL.ID_COMPRADOR_FATURA as \"id_comprador_fatura\",
                       (SELECT NM_FANTASIA FROM COMPRADORES WHERE ID_COMPRADOR = SOL.ID_COMPRADOR_FATURA) as \"fantasia_fatura\",
                       (SELECT NR_TELEFONE FROM COMPRADORES WHERE ID_COMPRADOR = SOL.ID_COMPRADOR_FATURA) as \"telefone_fatura\",
                       F.NR_CGC as \"nr_cgc\",
                       F.NM_FANTASIA as \"nm_fantasia\",
                       ST.ID_SITUACAO as \"id_situacao\",
                       ST.NM_SITUACAO_FORNECEDOR as \"nm_situacao\",
                       (
                        SELECT LISTAGG(UD.ID_USUARIO, ',')
                               WITHIN GROUP (ORDER BY UD.ID_USUARIO)
                          FROM USUARIO_DEVICE UD, CA_PERMISSOES_COMPRADORES PC, DEVICES D
                         WHERE UD.ID_DEVICE = D.ID_DEVICE
                         AND PC.ID_USUARIO = UD.ID_USUARIO
                         AND PC.ID_COMPRADOR = SOL.ID_COMPRADOR
                         AND D.HS_DEVICE = '$hs_device'
                       ) AS \"usuarios\",
                       (SELECT FP.NM_FORMA FROM FORMAS_PAGAMENTO FP WHERE FP.ID_FORMA = C.ID_FORMA) AS \"nm_forma\",
                       F.ID_FORNECEDOR AS \"id_fornecedor\",
                       F.NM_FANTASIA AS \"nm_fantasia\",
                       F.NR_CGC AS \"nr_cgc\",
                       S.ID_SINCRONIZACAO AS \"id_sincronizacao\",
                       SOL.TE_OBSERVACAO AS \"te_observacao\",
                       SOL.NR_PRAZO_MAXIMO_ENTREGA AS \"nr_prazo_maximo_entrega\",
                       LE.ID_ENTREGA AS \"id_entrega\",
                       LE.TE_ENDERECO AS \"te_endereco\",
                       LE.TE_COMPLEMENTO AS \"te_complemento\",
                       LE.NM_CIDADE AS \"nm_cidade\",
                       LE.NM_BAIRRO AS \"nm_bairro\",
                       LE.NR_CEP AS \"nr_cep\",
                       LE.SG_UF AS \"sg_uf\"
                  FROM DEVICES D,
                       SINCRONIZACAO S,
                       ACAO_SINCRONIZACAO A,
                       COTACOES C,
                       SOLICITACOES SOL,
                       LOCAIS_ENTREGA LE,
                       COMPRADORES CP,
                       FORNECEDORES F,
                       SITUACOES ST
                 WHERE S.ID_DEVICE = D.ID_DEVICE
                   AND S.ID_ACAO = A.ID_ACAO
                   AND S.ID = C.ID_COTACAO
                   AND C.ID_SOLICITACAO = SOL.ID_SOLICITACAO
                   AND C.ID_SITUACAO = ST.ID_SITUACAO
                   AND SOL.ID_COMPRADOR_FATURA = CP.ID_COMPRADOR
                   AND SOL.ID_ENTREGA = LE.ID_ENTREGA
                   AND C.ID_FORNECEDOR = F.ID_FORNECEDOR
                   AND D.HS_DEVICE = :HASH
                   AND A.CS_TIPO_ACAO = 'C'
                   AND S.DT_DEVICE IS NULL
                ";

                $stmt = oci_parse($conexao->conexao, $sql);
                oci_bind_by_name($stmt, ':HASH', $hs_device);
                $rs = oci_execute($stmt);

                $json = array();
                $ids = array();
                while($data = oci_fetch_array($stmt, OCI_ASSOC + OCI_RETURN_NULLS)){
                    $ids[] = $data["id_sincronizacao"];
                    array_walk($data, function (&$entry) {
                        if($entry!=null) {
                            $entry = utf8_encode($entry);
                        }
                    });
                    $data["usuarios"] = explode(",",$data["usuarios"]);
                    $json[] = $data;
                }

                //$ids = join(",", $ids);
                if(is_array($ids)){
                    $ins = $this->prepara_in($ids);
                    if($ins!="") {
                        $sql = "UPDATE SINCRONIZACAO SET DT_DEVICE = SYSDATE WHERE 1=1 " . $ins;
                        $dml = oci_parse($conexao->conexao, $sql);
                        oci_execute($dml);
                    }
                }

                return '{"cotacoes":'.json_encode($json).'}';

            }catch (Exception $ex){
                return "";
            }

        }

        public function formasPagamento(){

            $sql = "SELECT ID_FORMA as \"id_forma\",
                           NM_FORMA as \"nm_forma\"
                      FROM FORMAS_PAGAMENTO
                   ";

            try{
                $conexao = new Conexao();
                $conexao->conectar();
                $stmt = oci_parse($conexao->conexao, $sql);
                $rs = oci_execute($stmt);
                $json = array();
                while($data = oci_fetch_array($stmt, OCI_ASSOC)){
                    array_walk($data, function (&$entry) {
                        $entry = utf8_encode($entry);
                    });
                    $json[] = $data;
                }

                return '{"formas_pagamento":'.json_encode($json).'}';

            }catch (Exception $ex){

            }

        }

        private function verificaPedidoPendente($id_pedido){

            $sql = "SELECT ID_SITUACAO FROM PEDIDOS WHERE ID_PEDIDO = :PEDIDO ";
            try{
                $conexao = new Conexao();
                $conexao->conectar();
                $cursor = oci_parse($conexao->conexao, $sql);
                oci_bind_by_name($cursor, ':PEDIDO', $id_pedido);
                oci_execute($cursor);
                $pedido = oci_fetch_object($cursor);

                if($pedido->ID_SITUACAO==22 || $pedido->ID_SITUACAO == 23){
                    return (object)array("isPendente" => true, "idSituacao" => $pedido->ID_SITUACAO);
                }

                return (object)array("isPendente" => false, "idSituacao" => $pedido->ID_SITUACAO);

                $conexao->fechar();

            }catch (Exception $ex){

                return false;

            }

        }

        private function _encaminharMercadoria($id_pedido, $id_device){
            $sql = "UPDATE PEDIDOS SET ID_SITUACAO = 24 WHERE ID_PEDIDO = :ID ";
            try {

                $conexao = new Conexao();
                $conexao->conectar();
                $this->database_session($conexao->conexao, $id_device);
                $dml = oci_parse($conexao->conexao, $sql);
                oci_bind_by_name($dml, ':ID', $id_pedido);
                oci_execute($dml);
                $conexao->fechar();
                return true;
            } catch (Exception $ex) {
                return false;
            }
            return false;
        }

        public function encaminharMercadoria($id_pedido, $id_device){
            $obVerificar = $this->verificaPedidoPendente($id_pedido);
            if($obVerificar->isPendente) {
                if($this->_encaminharMercadoria($id_pedido, $id_device)){
                    return json_encode((object)array("OK" => true, "ERROR" => false, "message" => ("Pedido encaminhado com sucesso"), "idSituacao" => $obVerificar->idSituacao));
                }else{
                    return json_encode((object)array("OK" => false, "ERROR" => true, "message" => ("Este pedido não pode ser encaminhado. Entre em contato com o Mercado na Rede"), "idSituacao" => $obVerificar->idSituacao));
                }
            }else{
                return json_encode((object)array("OK" => false, "ERROR" => true, "message" => ("Este pedido não pode ser encaminhado"), "idSituacao" => $obVerificar->idSituacao));
            }
        }

        public function encaminharMercadorias($ids_pedido, $id_device){

      $mensagens = array();
            foreach($ids_pedido as $key => $value){

                $id_pedido = $value;
        
                $result = $this->verificaPedidoPendente($id_pedido);              

                if($result->isPendente){
                    if($this->_encaminharMercadoria($id_pedido, $id_device)){
                        $mensagens[] = (object)array("id_pedido" => $id_pedido, "id_situacao" => 24);
                    }else{
                        $mensagens[] = (object)array("id_pedido" => $id_pedido, "id_situacao" => $result->idSituacao);
                    }
                }else{
                    $mensagens[] = (object)array("id_pedido" => $id_pedido, "id_situacao" => $result->idSituacao);
                }
            }

            print json_encode($mensagens);

        }

        public function _recusarPedido($id_pedido, $id_device){
            $sql = "UPDATE PEDIDOS SET ID_SITUACAO = 40 WHERE ID_PEDIDO = :ID ";
            try{
                $conexao = new Conexao();
                $conexao->conectar();
                $this->database_session($conexao->conexao, $id_device);
                $dml = oci_parse($conexao->conexao, $sql);
                oci_bind_by_name($dml, ':ID', $id_pedido);
                oci_execute($dml);
                $conexao->fechar();

                return true;

            }catch(Exception $ex){

                return false;

            }
            return false;
        }

        public function recusarPedido($id_pedido, $id_device){

            $obVerificar = $this->verificaPedidoPendente($id_pedido);

            if($obVerificar->isPendente) {
                if($this->_recusarPedido($id_pedido, $id_device)){
                    return json_encode((object)array("OK" => true, "ERROR" => false, "message" => ("Pedido recusado com sucesso"), "idSituacao" => $obVerificar->idSituacao));
                }else{
                    return json_encode((object)array("OK" => false, "ERROR" => true, "message" => ("Este pedido não pode ser recusado. Entre em contato com o Mercado na Rede"), "idSituacao" => $obVerificar->idSituacao));
                }
            }else{
                return json_encode((object)array("OK" => false, "ERROR" => true, "message" => ("Este pedido não pode ser recusado"), "idSituacao" => $obVerificar->idSituacao));
            }

        }

        public function recusarPedidos($ids_pedido, $id_device){

            $mensagens = array();
            foreach($ids_pedido as $key => $value){

                $id_pedido = $value;

                $result = $this->verificaPedidoPendente($id_pedido, $id_device);

                if($result->isPendente){
                    if($this->_recusarPedido($id_pedido, $id_device)){
                        $mensagens[] = (object)array("id_pedido" => $id_pedido, "id_situacao" => 40);
                    }else{
                        $mensagens[] = (object)array("id_pedido" => $id_pedido, "id_situacao" => $result->idSituacao);
                    }
                }else{
                    $mensagens[] = (object)array("id_pedido" => $id_pedido, "id_situacao" => $result->idSituacao);
                }
            }

            print json_encode($mensagens);

        }

        public function _recusarCotacao($id_cotacao){
            $sql = "UPDATE COTACOES SET DT_COTACAO = SYSDATE, ID_SITUACAO = 13 WHERE ID_COTACAO = :ID ";
            try{
                $conexao = new Conexao();
                $conexao->conectar();
                $dml = oci_parse($conexao->conexao, $sql);
                oci_bind_by_name($dml, ':ID', $id_cotacao);
                oci_execute($dml);
                $conexao->fechar();
                return true;
            }catch(Exception $ex){
                return false;
            }
            return false;
        }

        public function recusarCotacao($id_cotacao){

            $result = $this->verificaCotacaoFechada($id_cotacao);

            if(!$result->isAberta){
                return json_encode( (object)array("OK" => false, "ERROR" => true, "id_cotacao" => $id_cotacao, "id_situacao" => 6,  "dt_fechamento" => $result->dt_fechamento, "message" => "Essa cotação fechou antes da sua resposta.") );
            }else{
                $result = $this->verificarCotacaoRecebida($id_cotacao);
                if($result->isPendente){
                    if($this->_recusarCotacao($id_cotacao)){
                        return json_encode( (object)array("OK" => true, "ERROR" => false, "id_cotacao" => $id_cotacao, "id_situacao" => 13, "dt_fechamento" => null, "message" => "Cotação recusada com sucesso" ) );
                    }else{
                        return json_encode( (object)array("OK" => false, "ERROR" => true, "id_cotacao" => $id_cotacao, "id_situacao" => $result->idSituacao, "dt_fechamento" => null, "message" => "Essa cotação não pode ser recusada, entre em contato com o Mercado na Rede") );
                    }
                }else{
                    return json_encode( (object)array("OK" => false, "ERROR" => true, "id_cotacao" => $id_cotacao, "id_situacao" => $result->idSituacao, "dt_fechamento" => null, "message" => "Essa cotação não pode ser recusada, entre em contato com o Mercado na Rede") );
                }
            }

        }

        public function recusarCotacoes($ids_cotacao){

            $mensagens = array();
            foreach($ids_cotacao as $key => $value){

                $id_cotacao = $value;

                $result = $this->verificaCotacaoFechada($id_cotacao);

                if(!$result->isAberta){
                    $mensagens[] = (object)array("id_cotacao" => $id_cotacao, "id_situacao" => 6,  "dt_fechamento" => $result->dt_fechamento);
                }else{
                    $result = $this->verificarCotacaoRecebida($id_cotacao);
                    if($result->isPendente){
                        if($this->_recusarCotacao($id_cotacao)){
                            $mensagens[] = (object)array("id_cotacao" => $id_cotacao, "id_situacao" => 13, "dt_fechamento" => null);
                        }else{
                            $mensagens[] = (object)array("id_cotacao" => $id_cotacao, "id_situacao" => $result->idSituacao, "dt_fechamento" => null);
                        }
                    }else{
                        $mensagens[] = (object)array("id_cotacao" => $id_cotacao, "id_situacao" => $result->idSituacao, "dt_fechamento" => null);
                    }
                }
            }

            print json_encode($mensagens);

        }

        private function verificaCotacaoFechada($id_cotacao){

            $sql = "
                    SELECT (SELECT RETORNA_DATA_JAVA(DT_FECHAMENTO) FROM SOLICITACOES WHERE ID_SOLICITACAO = C.ID_SOLICITACAO) DT_FECHAMENTO
                      FROM COTACOES C
                     WHERE ID_COTACAO = :ID
            ";

            try{
                $conexao = new Conexao();
                $conexao->conectar();
                $cursor = oci_parse($conexao->conexao, $sql);
                oci_bind_by_name($cursor, ':ID', $id_cotacao);
                oci_execute($cursor);
                $cotacao = oci_fetch_object($cursor);

                return (object)array("isAberta" => is_null($cotacao->DT_FECHAMENTO), "dt_fechamento" => $cotacao->DT_FECHAMENTO);

            }catch (Exception $ex){
                return (object)array("isAberta" => false, "dt_fechamento" => null);
            }

        }

        private function verificarCotacaoRecebida($id_cotacao){

            $sql = "SELECT ID_SITUACAO FROM COTACOES WHERE ID_COTACAO = :ID ";
            try{
                $conexao = new Conexao();
                $conexao->conectar();
                $cursor = oci_parse($conexao->conexao, $sql);
                oci_bind_by_name($cursor, ':ID', $id_cotacao);
                oci_execute($cursor);
                $cotacao = oci_fetch_object($cursor);

                if($cotacao->ID_SITUACAO==11){
                    return (object)array("isPendente" => true, "idSituacao" => $cotacao->ID_SITUACAO);
                }

                return (object)array("isPendente" => false, "idSituacao" => $cotacao->ID_SITUACAO);

                $conexao->fechar();

            }catch (Exception $ex){

                return false;

            }
        }


        public function settingsCotacao($id_usuario, $hs_device, $id_fornecedor){
            try{

                $sql = "
                        SELECT C.ID_COTACAO as \"id_cotacao\",
                               C.ID_COTACAO_MD5 as \"id_cotacao_md5\",
                               C.CS_NOVO as \"cs_novo\",
                               RETORNA_DATA_JAVA(C.DT_COTACAO) as \"dt_cotacao\",
                               RETORNA_DATA_JAVA(C.DT_RECEBIMENTO) as \"dt_recebimento\",
                               (SELECT NVL(C.ID_FORMA,CXF.ID_FORMA) FROM COMPRADORXFORNECEDOR CXF WHERE ID_COMPRADOR = S.ID_COMPRADOR AND ID_FORNECEDOR = F.ID_FORNECEDOR ) AS \"id_forma\",
                               (SELECT NVL(C.TE_FRETE,CXF.TE_FRETE) FROM COMPRADORXFORNECEDOR CXF WHERE ID_COMPRADOR = S.ID_COMPRADOR AND ID_FORNECEDOR = F.ID_FORNECEDOR ) as \"te_frete\",
                               NVL((SELECT NVL(NVL(C.VL_MIN_FATURAMENTO, CXF.VL_MIN_FATURAMENTO),0) FROM COMPRADORXFORNECEDOR CXF WHERE ID_COMPRADOR = S.ID_COMPRADOR AND ID_FORNECEDOR = F.ID_FORNECEDOR ),0) as \"vl_min_faturamento\",
                               S.ID_SOLICITACAO as \"id_solicitacao\",
                               S.NR_SOLICITACAO_CLIENTE as \"nr_solicitacao_cliente\",
                               RETORNA_DATA_JAVA(S.DT_VALIDADE) as \"dt_validade\",
                               RETORNA_DATA_JAVA(S.DT_FECHAMENTO) as \"dt_fechamento\",
                               S.ID_COMPRADOR as \"id_comprador\",
                               (SELECT NM_FANTASIA FROM COMPRADORES WHERE ID_COMPRADOR = S.ID_COMPRADOR) as \"fantasia_comprador\",
                               (SELECT NR_TELEFONE FROM COMPRADORES WHERE ID_COMPRADOR = S.ID_COMPRADOR) as \"telefone_comprador\",
                               S.ID_COMPRADOR_FATURA as \"id_comprador_fatura\",
                               (SELECT NM_FANTASIA FROM COMPRADORES WHERE ID_COMPRADOR = S.ID_COMPRADOR_FATURA) as \"fantasia_fatura\",
                               (SELECT NR_TELEFONE FROM COMPRADORES WHERE ID_COMPRADOR = S.ID_COMPRADOR_FATURA) as \"telefone_fatura\",
                               F.NR_CGC as \"nr_cgc\",
                               F.NM_FANTASIA as \"nm_fantasia\",
                               ST.ID_SITUACAO as \"id_situacao\",
                               ST.NM_SITUACAO_FORNECEDOR as \"nm_situacao\",
                               (
                                SELECT LISTAGG(UD.ID_USUARIO, ',')
                                       WITHIN GROUP (ORDER BY UD.ID_USUARIO)
                                  FROM USUARIO_DEVICE UD, CA_PERMISSOES_COMPRADORES PC, DEVICES D
                                 WHERE UD.ID_DEVICE = D.ID_DEVICE
                                 AND PC.ID_USUARIO = UD.ID_USUARIO
                                 AND PC.ID_COMPRADOR = S.ID_COMPRADOR
                                 AND D.HS_DEVICE = '$hs_device'
                               ) AS \"usuarios\",
                               (SELECT FP.NM_FORMA FROM FORMAS_PAGAMENTO FP WHERE FP.ID_FORMA = C.ID_FORMA) AS \"nm_forma\",
                               F.ID_FORNECEDOR AS \"id_fornecedor\",
                               F.NM_FANTASIA AS \"nm_fantasia\",
                               F.NR_CGC AS \"nr_cgc\",
                               S.TE_OBSERVACAO AS \"te_observacao\",
                               S.NR_PRAZO_MAXIMO_ENTREGA AS \"nr_prazo_maximo_entrega\",
                               LE.ID_ENTREGA AS \"id_entrega\",
                               LE.TE_ENDERECO AS \"te_endereco\",
                               LE.TE_COMPLEMENTO AS \"te_complemento\",
                               LE.NM_CIDADE AS \"nm_cidade\",
                               LE.NM_BAIRRO AS \"nm_bairro\",
                               LE.NR_CEP AS \"nr_cep\",
                               LE.SG_UF AS \"sg_uf\"
                        FROM COTACOES C,
                             SOLICITACOES S,
                             LOCAIS_ENTREGA LE,
                             FORNECEDORES F,
                             SITUACOES ST
                        WHERE C.ID_SOLICITACAO = S.ID_SOLICITACAO
                          AND C.ID_FORNECEDOR = F.ID_FORNECEDOR
                          AND C.ID_SITUACAO = ST.ID_SITUACAO
                          AND S.ID_ENTREGA = LE.ID_ENTREGA
                          AND C.ID_SITUACAO IN (11,12,13)
                          AND S.ID_COMPRADOR IN (SELECT C.ID_COMPRADOR
                                                      FROM COMPRADORES C, USUARIOS U, CA_PERMISSOES_COMPRADORES P
                                                    WHERE U.ID_USUARIO=P.ID_USUARIO
                                                      AND C.ID_COMPRADOR = P.ID_COMPRADOR
                                                      AND U.ID_USUARIO= :USUARIO  )
                          AND C.ID_FORNECEDOR = :FORNECEDOR
                          AND C.DT_RECEBIMENTO > SYSDATE - 3
                          ORDER BY DT_RECEBIMENTO DESC
                ";


                $conexao = new Conexao();
                $conexao->conectar();
                $stmt = oci_parse($conexao->conexao, $sql);
                #oci_bind_by_name($stmt, ':HASH', $hs_device);
                oci_bind_by_name($stmt, ':FORNECEDOR', $id_fornecedor);
                oci_bind_by_name($stmt, ':USUARIO', $id_usuario);
                $rs = oci_execute($stmt);

                $json = array();
                while($data = oci_fetch_array($stmt, OCI_ASSOC + OCI_RETURN_NULLS)){
                    array_walk($data, function (&$entry) {
                        if($entry!=null) {
                            $entry = utf8_encode($entry);
                        }
                    });
                    $data["usuarios"] = explode(",",$data["usuarios"]);
                    $json[] = $data;
                }

                return '{"cotacoes":'.json_encode($json).'}';

            }catch(Exceiption $ex){

            }
        }

        public function settingsPedido($id_usuario, $hs_device, $id_fornecedor){
            try{
                $sql = "
                 SELECT P.ID_PEDIDO as \"id_pedido\",
                        P.ID_PEDIDO_MD5 as \"id_pedido_md5\",
                        P.NR_PEDIDO_CLIENTE as \"nr_pedido_cliente\",
                        RETORNA_DATA_JAVA(P.DT_RECEBIMENTO)  as \"dt_recebimento\",
                        P.TE_FRM_PAGAMENTO AS \"te_frm_pagamento\",
                        NVL(P.VL_DESCONTO,0) AS \"vl_desconto\",
                        P.CS_NOVO \"cs_novo\",
                        P.ID_COMPRADOR_FATURA as \"id_comprador_fatura\",
                        (SELECT NM_FANTASIA FROM COMPRADORES WHERE ID_COMPRADOR = P.ID_COMPRADOR_FATURA) AS \"pedido_fantasia_fatura\",
                        (SELECT NR_TELEFONE FROM COMPRADORES WHERE ID_COMPRADOR = P.ID_COMPRADOR_FATURA) as \"telefone_fatura\",
                        C.ID_COMPRADOR \"id_comprador\",
                        C.NM_FANTASIA \"nm_fantasia\",
                        C.NR_TELEFONE \"telefone_comprador\",
                        ST.ID_SITUACAO as \"id_situacao\",
                        ST.NM_SITUACAO_FORNECEDOR as \"nm_situacao\",
                        F.ID_FORNECEDOR AS \"id_fornecedor\",
                        F.NR_CGC AS \"nr_cgc\",
                        F.NM_FANTASIA AS \"fantasia_fornecedor\",
                        S.ID_SOLICITACAO AS \"id_solicitacao\",
                        S.NR_SOLICITACAO_CLIENTE AS \"nr_solicitacao_cliente\",
                        RETORNA_DATA_JAVA(S.DT_VALIDADE) as \"dt_validade\",
                        RETORNA_DATA_JAVA(S.DT_FECHAMENTO) AS \"dt_fechamento\",
                        S.ID_COMPRADOR AS \"solicitacao_comprador\",
                        (SELECT NM_FANTASIA FROM COMPRADORES WHERE ID_COMPRADOR = S.ID_COMPRADOR) AS \"solicitacao_fantasia\",
                        S.ID_COMPRADOR_FATURA AS \"solicitacao_comprador_fatura\",
                        (SELECT NM_FANTASIA FROM COMPRADORES WHERE ID_COMPRADOR = S.ID_COMPRADOR_FATURA) AS \"solicitacao_fantasia_fatura\",
                        (SELECT NR_TELEFONE FROM COMPRADORES WHERE ID_COMPRADOR = S.ID_COMPRADOR_FATURA) AS \"solicitacao_telefone_fatura\",
                        (
                          SELECT LISTAGG(UD.ID_USUARIO, ',')
                                 WITHIN GROUP (ORDER BY UD.ID_USUARIO)
                            FROM USUARIO_DEVICE UD, CA_PERMISSOES_COMPRADORES PC, DEVICES D
                           WHERE UD.ID_DEVICE = D.ID_DEVICE
                           AND PC.ID_USUARIO = UD.ID_USUARIO
                           AND PC.ID_COMPRADOR = P.ID_COMPRADOR
                           AND D.HS_DEVICE = '$hs_device'
                         ) AS \"usuarios\",
                         S.TE_OBSERVACAO AS \"te_observacao\",
                         S.NR_PRAZO_MAXIMO_ENTREGA AS \"nr_prazo_maximo_entrega\",
                         LE.ID_ENTREGA AS \"id_entrega\",
                         LE.TE_ENDERECO AS \"te_endereco\",
                         LE.TE_COMPLEMENTO AS \"te_complemento\",
                         LE.NM_CIDADE AS \"nm_cidade\",
                         LE.NM_BAIRRO AS \"nm_bairro\",
                         LE.NR_CEP AS \"nr_cep\",
                         LE.SG_UF AS \"sg_uf\"
                 FROM PEDIDOS P,
                      SOLICITACOES S,
                      COMPRADORES C,
                      SITUACOES ST,
                      FORNECEDORES F,
                      LOCAIS_ENTREGA LE
                 WHERE P.ID_FORNECEDOR= :FORNECEDOR
                    AND P.ID_FORNECEDOR = F.ID_FORNECEDOR
                    AND NVL(P.CS_PREPEDIDO,0) = 0
                    AND P.ID_SOLICITACAO = S.ID_SOLICITACAO
                    AND S.ID_ENTREGA = LE.ID_ENTREGA
                    AND C.ID_COMPRADOR_GRUPO IN (SELECT C.ID_COMPRADOR
                                                      FROM COMPRADORES C, USUARIOS U, CA_PERMISSOES_COMPRADORES P
                                                    WHERE U.ID_USUARIO=P.ID_USUARIO
                                                      AND C.ID_COMPRADOR = P.ID_COMPRADOR
                                                      AND U.ID_USUARIO= :USUARIO  )
                   AND P.ID_SITUACAO = ST.ID_SITUACAO
                   AND P.ID_COMPRADOR_FATURA = C.ID_COMPRADOR
                   AND (ST.ID_SITUACAO=22 OR ST.ID_SITUACAO=23)
                ";

                #print $sql;

                $conexao = new Conexao();
                $conexao->conectar();
                $stmt = oci_parse($conexao->conexao, $sql);
                #oci_bind_by_name($stmt, ':HASH', $hs_device);
                oci_bind_by_name($stmt, ':FORNECEDOR', $id_fornecedor);
                oci_bind_by_name($stmt, ':USUARIO', $id_usuario);
                $rs = oci_execute($stmt);

                $json = array();
                while($data = oci_fetch_array($stmt, OCI_ASSOC)){
                    array_walk($data, function (&$entry) {
                        $entry = utf8_encode($entry);
                    });
                    $data["usuarios"] = explode(",",$data["usuarios"]);
                    $json[] = $data;
                }

                return '{"pedidos":'.json_encode($json).'}';

            }catch(Exception $ex){

            }
        }

        public function listarPedidos($hs_device){

            try{

                $conexao = new Conexao();
                $conexao->conectar();

                $sql = "
                SELECT P.ID_PEDIDO as \"id_pedido\",
                       P.ID_PEDIDO_MD5 as \"id_pedido_md5\",
                       P.NR_PEDIDO_CLIENTE as \"nr_pedido_cliente\",
                       RETORNA_DATA_JAVA(P.DT_RECEBIMENTO)  as \"dt_recebimento\",
                       ST.ID_SITUACAO as \"id_situacao\",
                       ST.NM_SITUACAO_FORNECEDOR as \"nm_situacao\",
                       C.ID_COMPRADOR as \"id_comprador\",
                       C.NM_FANTASIA  as \"nm_fantasia\",
                       C.NR_TELEFONE  as \"telefone_comprador\",
                       P.ID_COMPRADOR_FATURA as \"id_comprador_fatura\",
                       (SELECT NM_FANTASIA FROM COMPRADORES WHERE ID_COMPRADOR = P.ID_COMPRADOR_FATURA) AS \"pedido_fantasia_fatura\",
                       (SELECT NR_TELEFONE FROM COMPRADORES WHERE ID_COMPRADOR = P.ID_COMPRADOR_FATURA) as \"telefone_fatura\",
                       (
                        SELECT LISTAGG(UD.ID_USUARIO, ',')
                               WITHIN GROUP (ORDER BY UD.ID_USUARIO)
                          FROM USUARIO_DEVICE UD, CA_PERMISSOES_COMPRADORES PC
                         WHERE UD.ID_DEVICE = D.ID_DEVICE
                         AND PC.ID_USUARIO = UD.ID_USUARIO
                         AND PC.ID_COMPRADOR = C.ID_COMPRADOR
                       ) as \"usuarios\",
                       S.ID_SINCRONIZACAO AS \"id_sincronizacao\",
                       P.TE_FRM_PAGAMENTO AS \"te_frm_pagamento\",
                       NVL(P.VL_DESCONTO,0) AS \"vl_desconto\",
                       F.ID_FORNECEDOR AS \"id_fornecedor\",
                       F.NR_CGC AS \"nr_cgc\",
                       F.NM_FANTASIA AS \"fantasia_fornecedor\",
                       SL.ID_SOLICITACAO AS \"id_solicitacao\",
                       SL.NR_SOLICITACAO_CLIENTE AS \"nr_solicitacao_cliente\",
                       RETORNA_DATA_JAVA(SL.DT_VALIDADE) as \"dt_validade\",
                       RETORNA_DATA_JAVA(SL.DT_FECHAMENTO) AS \"dt_fechamento\",
                       SL.ID_COMPRADOR AS \"solicitacao_comprador\",
                       (SELECT NM_FANTASIA FROM COMPRADORES WHERE ID_COMPRADOR = SL.ID_COMPRADOR) AS \"solicitacao_fantasia\",
                       SL.ID_COMPRADOR_FATURA AS \"solicitacao_comprador_fatura\",
                       (SELECT NM_FANTASIA FROM COMPRADORES WHERE ID_COMPRADOR = SL.ID_COMPRADOR_FATURA) AS \"solicitacao_fantasia_fatura\",
                       (SELECT NR_TELEFONE FROM COMPRADORES WHERE ID_COMPRADOR = SL.ID_COMPRADOR_FATURA) AS \"solicitacao_telefone_fatura\",
                       P.CS_NOVO as \"cs_novo\",
                       SL.TE_OBSERVACAO AS \"te_observacao\",
                       SL.NR_PRAZO_MAXIMO_ENTREGA AS \"nr_prazo_maximo_entrega\",
                       LE.ID_ENTREGA AS \"id_entrega\",
                       LE.TE_ENDERECO AS \"te_endereco\",
                       LE.TE_COMPLEMENTO AS \"te_complemento\",
                       LE.NM_CIDADE AS \"nm_cidade\",
                       LE.NM_BAIRRO AS \"nm_bairro\",
                       LE.NR_CEP AS \"nr_cep\",
                       LE.SG_UF AS \"sg_uf\"
                  FROM DEVICES D,
                       SINCRONIZACAO S,
                       ACAO_SINCRONIZACAO A,
                       PEDIDOS P,
                       SITUACOES ST,
                       COMPRADORES C,
                       FORNECEDORES F,
                       SOLICITACOES SL,
                       LOCAIS_ENTREGA LE
                 WHERE S.ID_DEVICE = D.ID_DEVICE
                   AND S.ID_ACAO = A.ID_ACAO
                   AND S.ID = P.ID_PEDIDO
                   AND P.ID_SOLICITACAO = SL.ID_SOLICITACAO
                   AND SL.ID_ENTREGA = LE.ID_ENTREGA
                   AND P.ID_SITUACAO = ST.ID_SITUACAO
                   AND P.ID_COMPRADOR = C.ID_COMPRADOR
                   AND P.ID_FORNECEDOR = F.ID_FORNECEDOR
                   AND D.HS_DEVICE = :HASH
                   AND A.CS_TIPO_ACAO = 'P'
                   AND S.DT_DEVICE IS NULL
                ";

                #print $sql;

                $stmt = oci_parse($conexao->conexao, $sql);
                oci_bind_by_name($stmt, ':HASH', $hs_device);
                $rs = oci_execute($stmt);

                $json = array();
                $ids = array();
                while($data = oci_fetch_array($stmt, OCI_ASSOC)){
                    $ids[] = $data["id_sincronizacao"];
                    array_walk($data, function (&$entry) {
                        $entry = utf8_encode($entry);
                    });
                    $data["usuarios"] = explode(",",$data["usuarios"]);
                    $json[] = $data;
                }

                if(is_array($ids)) {
                    $ins = $this->prepara_in($ids);
                    if ($ins != "") {
                        $sql = "UPDATE SINCRONIZACAO SET DT_DEVICE = SYSDATE WHERE DT_DEVICE IS NULL ".$ins;
                        $dml = oci_parse($conexao->conexao, $sql);
                        oci_execute($dml);
                    }
                }
                return '{"pedidos":'.json_encode($json).'}';

            }catch(Exception $ex){

            }

        }

        public function parcelas($id_pedido){
            $sql = "SELECT PP.DT_PARCELA as \"dt_parcela\",
                           PP.VL_PARCELA as \"vl_parcela\"
                      FROM PARCELAS_PEDIDO PP
                     WHERE PP.ID_PEDIDO = :PEDIDO";
            try{
                $conexao = new Conexao();
                $conexao->conectar();
                $stmt = oci_parse($conexao->conexao, $sql);
                oci_bind_by_name($stmt, ':PEDIDO', $id_pedido);
                $rs = oci_execute($stmt);
                $json = array();
                while($data = oci_fetch_array($stmt, OCI_ASSOC)){
                    array_walk($data, function (&$entry) {
                        $entry = utf8_encode($entry);
                    });
                    $json[] = $data;
                }

                return json_encode($json);

            }catch (Exception $ex){

            }
        }

        public function parametros($id_cotacao){
            try{

                $sql = "
                select comp.id_comprador as \"id_comprador\",
                       comp.id_comprador_grupo as \"id_comprador_grupo\",
                       comp.nr_cgc as \"nr_cgc\",
                       comp.sg_uf as \"sg_uf\",
                       cot.id_fornecedor as \"id_fornecedor\",
                       cot.id_solicitacao as \"id_solicitacao\",
                       comp.nr_cgc as \"nr_cgc\",
                       decode((select cs_marcas_solicitadas from defaults where nr_cgc = comp2.nr_cgc and cs_tipo = 1),1,2,d.CS_ESCOLHER_MARCA)  as \"cs_erp\",
                       d.cs_erp_outras as \"cs_erp_outras\",
                       d.cs_marca_combo as \"cs_marca_combo\",
                       d.cs_marca_diversos as \"cs_marca_diversos\",
                       d.cs_exportar_marca_em_obs as \"cs_exportar_marca_em_obs\",
                       d.cs_apresentar_observacao as \"cs_apresentar_observacao\",
                       d.cs_cotacao_observacao as \"cs_cotacao_observacao\",
                       d.ds_separador as \"ds_separador\"
                  from compradores comp,
                       compradores comp2,
                       cotacoes cot,
                       solicitacoes sol,
                       defaults d
                 where id_cotacao = :cotacao
                   and sol.id_solicitacao = cot.id_solicitacao
                   and sol.id_comprador_fatura = comp.id_comprador
                   and comp.id_comprador_grupo = comp2.id_comprador
                   and comp2.nr_cgc = d.nr_cgc
                   and d.cs_tipo = 1
                ";

                $conexao = new Conexao();
                $conexao->conectar();
                $stmt = oci_parse($conexao->conexao, $sql);
                oci_bind_by_name($stmt, ':cotacao', $id_cotacao);
                //$rs = oci_execute($stmt);
                oci_execute($stmt);
                /*$json = array();



                while($data = oci_fetch_array($stmt, OCI_ASSOC)){
                    array_walk($data, function (&$entry) {
                        $entry = utf8_encode($entry);
                    });
                    $json[] = $data;
                }

                return json_encode($json);
                */

                return oci_fetch_object($stmt);

            }catch (Exception $ex){

            }
        }

        public function itensCotacao($id_cotacao){
            try{

                $conexao = new Conexao();
                $conexao->conectar();
                $this->vistoCotacao($conexao->conexao, $id_cotacao);

                $defaults = $this->parametros($id_cotacao);

                $sql = "
               SELECT MAX(DADOS.ID_ITENS_COTACAO) as \"id_itens_cotacao\",
                      MAX(DADOS.PRODUTO) as \"nm_produto\",
                      MAX(DADOS.CD_PRODUTO) as \"cd_produto\",
                      MAX(DADOS.NM_MARCA) as \"nm_marca_produtos\",
                      MAX(DADOS.CS_OBRIGATORIO_MARCA) as \"cs_obrigatorio_marca\",
                      MAX(DADOS.FABRICANTE)  as \"nm_fabricante\",
                      MAX(DADOS.UNIDADE)  as \"nm_unidade\",
                      NVL(SUM(DADOS.QUANTIDADE),0) as \"qt_solicitado\",
                      NVL(MAX(DADOS.ENTREGA_PRAZO),0)  as \"nr_prazo_maximo_entrega\",
                      MAX(DADOS.ENTREGA_OBSERVACAO) ENTREGA_OBSERVACAO,
                      MAX(DADOS.ENTREGA_ENDERECO) ENTREGA_ENDERECO,
                      MAX(DADOS.ENTREGA_BAIRRO) ENTREGA_BAIRRO,
                      MAX(DADOS.ENTREGA_CIDADE) ENTREGA_CIDADE,
                      MAX(DADOS.ENTREGA_ESTADO) ENTREGA_ESTADO,
                      MAX(DADOS.COTACAO_OBSERVACAO) as \"te_observacao\",
                      MAX(DADOS.COTACAO_MARCA) as \"nm_marca\",
                      NVL(MAX(DADOS.COTACAO_PRECO),0) as \"vl_item\",
                      NVL(MAX(DADOS.COTACAO_UNIDADE), MAX(DADOS.UNIDADE)) as \"nm_unidade_cotada\",
                      NVL(SUM(DADOS.COTACAO_QUANTIDADE),0) as \"qt_cotado\",
                      MAX(DADOS.COTACAO_PRAZO_ENTREGA) as \"nr_prz_entrega\",
                      NVL(MAX(DADOS.COTACAO_IPI),0) as \"vl_ipi\",
                      NVL(SUM(DADOS.COTACAO_TOTAL),0) COTACAO_TOTAL,
                      MAX(DADOS.ID_PRODUTO)  as \"id_produto\",
                      MAX(DADOS.ID_ENTREGA)  as \"id_entrega\",
                      MAX(DADOS.ID_FABRICANTE)  as \"id_fabricante\",
                      MAX(DADOS.REFERENCIA)  as \"cd_referencia_solicitacao\",
                      MAX(DADOS.MARCA)  as \"nm_marca_solicitada\",
                      decode(to_char( MAX(DADOS.HISTORICO_DATA) ,'yyyy'),to_char(sysdate,'yyyy'),to_char(MAX(DADOS.HISTORICO_DATA),'dd/mm'),to_char(MAX(DADOS.HISTORICO_DATA),'dd/mm/yyyy')) HISTORICO_DATA,
                      MAX(DADOS.HISTORICO_PRECO) HISTORICO_PRECO,
                      NVL(SUM(DADOS.HISTORICO_QUANTIDADE),0) HISTORICO_QUANTIDADE,
                      MAX(DADOS.HISTORICO_ID_SOLICITACAO) HISTORICO_ID_SOLICITACAO,
                      MAX(DADOS.HISTORICO_UNIDADE) HISTORICO_UNIDADE,
                      MAX(DADOS.HISTORICO_MARCA) HISTORICO_MARCA,
                      MAX(DADOS.HISTORICO_PRAZO_ENTREGA) HISTORICO_PRAZO_ENTREGA,
                      MAX(DADOS.HISTORICO_IPI) HISTORICO_IPI,
                      MAX(DADOS.HISTORICO_TOTAL) HISTORICO_TOTAL,
                      MAX(DADOS.HISTORICO_ID_PRODUTO) HISTORICO_ID_PRODUTO,
                      MAX(DADOS.HISTORICO_VENCEDOR) HISTORICO_VENCEDOR,
                      decode(to_char( MAX(DADOS.DT_ULTIMA_ALT) ,'yyyy'),to_char(sysdate,'yyyy'),to_char(MAX(DADOS.DT_ULTIMA_ALT),'dd/mm'),to_char(MAX(DADOS.DT_ULTIMA_ALT),'dd/mm/yyyy')) DT_ULTIMA_ALT,
                      MAX(DADOS.NM_ARQUIVO_ESPECIFICACAO) NM_ARQUIVO_ESPECIFICACAO,
                      decode(:cs_erp,1,decode(:cs_marca_combo,0,MAX(DADOS.COTACAO_MARCA),marcas_permitidas(max(DADOS.id_PRODUTO),:id_comprador_grupo,:cs_erp_outras,max(DADOS.ID_COTACAO))) ,MAX(DADOS.COTACAO_MARCA)) marcasperm,
                      MAX(DADOS.CD_PRODUTO_FORN) CD_PRODUTO_FORN,
                      MAX(DADOS.CS_TEM_ESTOQUE)  as \"cs_tem_estoque\",
                      MAX(DADOS.CS_OUTRA_MARCA)  as \"cs_outra_marca\",
                      LISTAGG(ENTREGA_ESTADO,'#$#') WITHIN GROUP (ORDER BY ENTREGA_ESTADO) AS ENTREGA_LOCAL,
                      MAX(DADOS.CS_IMPORTADO)  as \"cs_importado\",
                      MAX(DADOS.IMAGENS) IMAGENS
           FROM (SELECT ITC.ID_ITENS_COTACAO,
                        PROD.NM_PRODUTO PRODUTO,
                        PROD.CD_PRODUTO,
                        PROD.ROWID ROWID_PRODUTO,
                        PROD.CS_OBRIGATORIO_MARCA CS_OBRIGATORIO_MARCA,
                        PROD.NM_MARCA,
                        FAB.NM_FABRICANTE FABRICANTE,
                        PROD.NM_UNIDADE UNIDADE,
                        NVL(ITS.QT_ORIGINAL,ITS.QT_SOLICITADO) QUANTIDADE,
                        ITS.NR_PRAZO_MAXIMO_ENTREGA ENTREGA_PRAZO,
                        ITS.TE_OBSERVACAO ENTREGA_OBSERVACAO,
                        ENT.NM_RAZAO_SOCIAL ENTREGA_LOCAL,
                        ENT.NM_BAIRRO ENTREGA_BAIRRO,
                        ENT.NM_CIDADE ENTREGA_CIDADE,
                        ENT.SG_UF ENTREGA_ESTADO,
                        ENT.TE_ENDERECO ENTREGA_ENDERECO,
                        ENT.NR_CEP ENTREGA_CEP,
                        ITC.TE_OBSERVACAO COTACAO_OBSERVACAO,
                        ITC.NM_MARCA COTACAO_MARCA,
                        ITC.VL_ITEM COTACAO_PRECO,
                        ITC.NM_UNIDADE_COTADA COTACAO_UNIDADE,
                        ITC.QT_COTADO COTACAO_QUANTIDADE,
                        ITC.NR_PRZ_ENTREGA COTACAO_PRAZO_ENTREGA,
                        ITC.VL_IPI COTACAO_IPI,
                        (ITC.VL_ITEM * ITC.QT_COTADO)* (1+(ITC.VL_IPI/100)) COTACAO_TOTAL,
                        PROD.ID_PRODUTO ID_PRODUTO,
                        ENT.ID_ENTREGA ID_ENTREGA,
                        ITS.ID_FABRICANTE ID_FABRICANTE,
                        ITS.CD_REFERENCIA REFERENCIA,
                        ITS.NM_MARCA MARCA,
                        DECODE(HIS.CS_VENCEDOR,'S', HIS.DT_PEDIDO, HIS.DT_COTACAO) HISTORICO_DATA,
                        DECODE(HIS.CS_VENCEDOR,'S', HIS.VL_ITEM_PEDIDO, HIS.VL_ITEM) HISTORICO_PRECO,
                        DECODE(HIS.CS_VENCEDOR,'S', HIS.QT_PEDIDO, HIS.QT_COTADO) HISTORICO_QUANTIDADE,
                        HIS.NM_UNIDADE_COTADA HISTORICO_UNIDADE,
                        HIS.NM_MARCA HISTORICO_MARCA,
                        HIS.NR_PRZ_ENTREGA HISTORICO_PRAZO_ENTREGA,
                        HIS.ID_SOLICITACAO HISTORICO_ID_SOLICITACAO,
                        HIS.ID_PRODUTO HISTORICO_ID_PRODUTO,
                        HIS.VL_IPI HISTORICO_IPI,
                        DECODE(HIS.CS_VENCEDOR,'S', HIS.VL_ITEM_PEDIDO, HIS.VL_ITEM) * DECODE(HIS.CS_VENCEDOR, 'S', HIS.QT_PEDIDO, HIS.QT_COTADO) * (1 + (HIS.VL_IPI/100)) HISTORICO_TOTAL,
                        NVL(HIS.CS_VENCEDOR, 'P') HISTORICO_VENCEDOR,
                        HIS.DT_ULTIMA_ALT DT_ULTIMA_ALT,
                        PROD.NM_ARQUIVO_ESPECIFICACAO,
                        NVL(ITR.CS_TEM_ESTOQUE,1) CS_TEM_ESTOQUE,
                        NVL(ITR.CD_PRODUTO,'') CD_PRODUTO_FORN,
                        ITC.CS_OUTRA_MARCA, ITC.ID_COTACAO,
                        NVL(ITC.CS_IMPORTADO,'N') CS_IMPORTADO,
                        (SELECT NVL(LISTAGG(PI.NM_ARQUIVO,';') WITHIN GROUP (ORDER BY PI.ID_PRODUTO_IMAGEM),' ') FROM PRODUTOS_IMAGENS PI WHERE PI.ID_PRODUTO = PROD.ID_PRODUTO ) IMAGENS
                   FROM FABRICANTES FAB,
                        LOCAIS_ENTREGA ENT,
                        PRODUTOS PROD,
                        ITENS_SOLICITACAO ITS,
                        ITENS_COTACAO ITC,
                        ITENS_RECUSADOS ITR,
                        (SELECT
                                MAX(HISTTEMP.VL_ITEM) VL_ITEM,
                                SUM(HISTTEMP.QT_COTADO) QT_COTADO,
                                MAX(HISTTEMP.NM_UNIDADE_COTADA) NM_UNIDADE_COTADA,
                                MAX(HISTTEMP.NM_MARCA) NM_MARCA,
                                MAX(HISTTEMP.NR_PRZ_ENTREGA) NR_PRZ_ENTREGA,
                                MAX(HISTTEMP.DT_COTACAO) DT_COTACAO,
                                MAX(HISTTEMP.VL_IPI) VL_IPI,
                                MAX(HISTTEMP.CS_VENCEDOR) CS_VENCEDOR,
                                MAX(HISTTEMP.VL_ITEM_PEDIDO) VL_ITEM_PEDIDO,
                                SUM(HISTTEMP.QT_PEDIDO) QT_PEDIDO,
                                MAX(HISTTEMP.DT_PEDIDO) DT_PEDIDO,
                                MAX(HISTTEMP.ID_SOLICITACAO) ID_SOLICITACAO,
                                MAX(HISTTEMP.ID_FORNECEDOR) ID_FORNECEDOR,
                                HISTTEMP.ID_PRODUTO,
                                MAX(HISTTEMP.ID_ENTREGA) ID_ENTREGA,
                                MAX(HISTTEMP.DT_ULTIMA_ALT) DT_ULTIMA_ALT
                           FROM (SELECT decode(puc.id_cotacao,:id_cotacao,null,HITC.VL_ITEM) VL_ITEM ,
                                        decode(puc.id_cotacao,:id_cotacao,null,HITC.QT_COTADO) QT_COTADO,
                                        decode(puc.id_cotacao,:id_cotacao,null,HITC.NM_UNIDADE_COTADA) NM_UNIDADE_COTADA,
                                        decode(puc.id_cotacao,:id_cotacao,null,HITC.NM_MARCA) NM_MARCA,
                                        decode(puc.id_cotacao,:id_cotacao,null,HITC.NR_PRZ_ENTREGA) NR_PRZ_ENTREGA,
                                        decode(puc.id_cotacao,:id_cotacao,null,HCOT.DT_COTACAO) DT_COTACAO,
                                        decode(puc.id_cotacao,:id_cotacao,null,HITC.VL_IPI) VL_IPI,
                                        decode(puc.id_cotacao,:id_cotacao,null,HITC.CS_VENCEDOR) CS_VENCEDOR,
                                        HITC.VL_ITEM_PEDIDO,
                                        HITC.QT_PEDIDO,
                                        HPED.DT_PEDIDO,
                                        HITC.ID_SOLICITACAO,
                                        HITC.ID_FORNECEDOR,
                                        HITC.ID_PRODUTO,
                                        HITC.ID_ENTREGA,
                                        puc.dt_ultima_alt
                           FROM COTACOES HCOT,
                                PEDIDOS HPED,
                                ITENS_COTACAO HITC,
                               (select decode(id_cotacao,:id_cotacao,id_cotacao_ant,id_cotacao) id_cotacao, id_comprador, sg_uf, id_fornecedor, id_produto,dt_ultima_alt
                                from produto_ultimopreco_cotado puc
                                WHERE PUC.ID_COMPRADOR = :id_comprador_grupo
                                  AND PUC.SG_UF = :uf_comprador
                                  AND PUC.ID_FORNECEDOR = :id_fornecedor
                                 AND PUC.ID_PRODUTO IN (SELECT ID_PRODUTO
                                                        FROM ITENS_SOLICITACAO
                                                        WHERE ID_SOLICITACAO = :id_solicitacao
                                                       )
                               ) puc
                           WHERE PUC.ID_COTACAO = HCOT.ID_COTACAO
                             AND PUC.ID_COTACAO = HITC.ID_COTACAO
                             AND PUC.ID_PRODUTO = HITC.ID_PRODUTO
                             AND HITC.ID_PEDIDO = HPED.ID_PEDIDO (+)) HISTTEMP
                        GROUP BY HISTTEMP.ID_PRODUTO) HIS
                WHERE ITC.ID_COTACAO = :id_cotacao
                 AND ITS.ID_SOLICITACAO = :id_solicitacao
                 AND ITS.ID_PRODUTO = ITC.ID_PRODUTO
                 AND ITS.ID_ENTREGA = ITC.ID_ENTREGA
                 AND ITS.ID_PRODUTO = PROD.ID_PRODUTO
                 AND ITS.ID_ENTREGA = ENT.ID_ENTREGA
                 AND ITR.ID_FORNECEDOR (+)=  ITC.ID_FORNECEDOR
                 AND ITR.ID_PRODUTO(+) = ITC.ID_PRODUTO
                 AND ITS.ID_FABRICANTE = FAB.ID_FABRICANTE (+)
                 AND ITC.ID_PRODUTO = HIS.ID_PRODUTO(+)) DADOS
                GROUP BY DADOS.ROWID_PRODUTO
                ORDER BY 1 ASC
                ";

                $conexao = new Conexao();
                $conexao->conectar();
                $stmt = oci_parse($conexao->conexao, $sql);

                oci_bind_by_name($stmt, ':cs_erp', $defaults->cs_erp);
                oci_bind_by_name($stmt, ':cs_marca_combo', $defaults->cs_marca_combo);
                oci_bind_by_name($stmt, ':id_comprador_grupo', $defaults->id_comprador_grupo);
                oci_bind_by_name($stmt, ':cs_erp_outras', $defaults->cs_erp_outras);
                oci_bind_by_name($stmt, ':id_cotacao', $id_cotacao);
                oci_bind_by_name($stmt, ':uf_comprador', $defaults->sg_uf);
                oci_bind_by_name($stmt, ':id_fornecedor', $defaults->id_fornecedor);
                oci_bind_by_name($stmt, ':id_solicitacao', $defaults->id_solicitacao);

                oci_execute($stmt);
                $json = array();

                while($data = oci_fetch_array($stmt, OCI_ASSOC + OCI_RETURN_NULLS)){
                    array_walk($data, function (&$entry) {
                        $entry = utf8_encode($entry);
                    });
                    if(isset($data["MARCASPERM"])) {
                        $data["MARCASPERM"] = explode(",", $data["MARCASPERM"]);
                        $data["marcas_permitidas"] = $data["MARCASPERM"];
                    }else{
                        $data["MARCASPERM"] = null;
                        $data["marcas_permitidas"] = $data["MARCASPERM"];
                    }
                    $json[] = $data;
                }

                return json_encode($json);

            }catch (Exception $ex){

            }
        }

        public function sincronizarItens($registro_id){

            $sql = "
                    SELECT S.ID_SINCRONIZACAO AS \"id_sincronizacao\",
                           ITC.ID_ITENS_COTACAO AS \"id_itens_cotacao\",
                           ITC.ID_PRODUTO AS \"id_produto\",
                           ITC.ID_SOLICITACAO AS \"id_solicitacao\",
                           ITC.ID_COTACAO AS \"id_cotacao\",
                           ITC.NM_MARCA AS \"nm_marca\",
                           ITC.NR_PRZ_ENTREGA AS \"nr_prz_entrega\",
                           NVL(ITC.VL_ITEM,0) AS \"vl_item\",
                           NVL(ITC.QT_COTADO,0) AS \"qt_cotado\",
                           NVL(ITC.VL_IPI,0) AS \"vl_ipi\",
                           ITC.CS_IMPORTADO AS \"cs_importado\",
                           (SELECT CS_TEM_ESTOQUE FROM ITENS_RECUSADOS ITR WHERE ITR.ID_PRODUTO = ITC.ID_PRODUTO AND ITR.ID_FORNECEDOR = ITC.ID_FORNECEDOR) AS \"cs_tem_estoque\"
                      FROM ITENS_COTACAO ITC,
                           SINCRONIZACAO S,
                           DEVICES D
                     WHERE ITC.ID_ITENS_COTACAO = S.ID
                       AND S.ID_DEVICE = D.ID_DEVICE
                       AND S.ID_ACAO = 7
                       AND S.DT_DEVICE IS NULL
                       AND D.HS_DEVICE = :DEVICE
                       AND ITC.ID_ITENS_COTACAO IS NOT NULL
            ";

            try {
                $conexao = new Conexao();
                $conexao->conectar();
                $stmt = oci_parse($conexao->conexao, $sql);
                oci_bind_by_name($stmt, ':DEVICE', $registro_id);
                $rs = oci_execute($stmt);

                $json = array();
                $ids = array();
                while($data = oci_fetch_array($stmt, OCI_ASSOC)){
                    $ids[] = $data["id_sincronizacao"];
                    array_walk($data, function (&$entry) {
                        $entry = utf8_encode($entry);
                    });
                    $json[] = $data;
                }

                if(is_array($ids)){
                    $ins = $this->prepara_in($ids);
                    if($ins!="") {
                        $sql = "UPDATE SINCRONIZACAO SET DT_DEVICE = SYSDATE WHERE DT_DEVICE IS NULL " . $ins;
                        $dml = oci_parse($conexao->conexao, $sql);
                        oci_execute($dml);
                    }
                }

                return json_encode($json);

            }catch(Exception $ex){

            }

        }

        public function itens($id_pedido, $id_device){

            $sql = "
            SELECT IP.ID_PRODUTO as \"id_produto\",
                   IP.QT_PEDIDO as \"qt_pedido\",
                   IP.VL_ITEM_PEDIDO as \"vl_item_pedido\",
                   IP.NM_MARCA_PEDIDA as \"nm_marca_pedida\",
                   IP.VL_IPI as \"vl_ipi\",
                   P.CD_PRODUTO as \"cd_produto\",
                   P.CD_REFERENCIA as \"cd_referencia\",
                   P.NM_PRODUTO as \"nm_produto\",
                   P.NM_UNIDADE as \"nm_unidade\",
                   NVL(UTIL.RETORNA_ALIQUOTA_ICMS(UTIL.RETORNA_INTERFACE('CS_CALCULAR_ICMS',PP.ID_COMPRADOR_FATURA),NVL(IP.VL_ITEM_PEDIDO,0), IP.ID_PRODUTO, IP.ID_SOLICITACAO, IP.ID_FORNECEDOR, 0),0) AS \"vl_aliquota\",
                   C.ID_COMPRADOR as \"id_comprador\",
                   C.NM_FANTASIA as \"nm_fantasia\"
            FROM ITENS_COTACAO IP,
                 PRODUTOS P,
                 COMPRADORES C,
                 PEDIDOS PP
            WHERE PP.ID_PEDIDO = IP.ID_PEDIDO
            AND IP.ID_PRODUTO = P.ID_PRODUTO
            AND C.ID_COMPRADOR = P.ID_COMPRADOR
            AND IP.ID_PEDIDO = :PEDIDO
            ";

            try{
                $conexao = new Conexao();
                $conexao->conectar();
                $this->database_session($conexao->conexao, $id_device);
                $this->visto($conexao->conexao, $id_pedido);
                $this->pendente_visto($conexao->conexao, $id_pedido);
                $stmt = oci_parse($conexao->conexao, $sql);
                oci_bind_by_name($stmt, ':PEDIDO', $id_pedido);
                $rs = oci_execute($stmt);
                $json = array();
                while($data = oci_fetch_array($stmt, OCI_ASSOC)){
                    array_walk($data, function (&$entry) {
                        $entry = utf8_encode($entry);
                    });
                    $json[] = $data;
                }

                return json_encode($json);

            }catch (Exception $ex){

            }

        }

        private function database_session($conexao, $id_device){
            oci_execute(oci_parse($conexao,"BEGIN dbms_session.set_identifier(".$id_device."); END;"));
        }

        public function salvar_item($id_cotacao, $id_produto, $id_usuario, $cs_tem, $vl_item, $nm_marca, $qt_cotado, $nm_unidade, $nr_prazo, $vl_ipi, $cs_importado, $id_device){

            try{
                $retorno = 1;
                $cs_outra_marca = 0;
                $conexao = new Conexao();
                $conexao->conectar();

                $this->database_session($conexao->conexao, $id_device);
                $stmt = oci_parse($conexao->conexao, "BEGIN COTACAO_FORNECEDOR.SALVAR_ITEM(:ID_COTACAO, :ID_PRODUTO, :NM_MARCA, :CS_OUTRA_MARCA, TO_NUMBER(:QT_COTADO,'99999999D99'), :NM_UNIDADE_COTADA, TO_NUMBER(:VL_ITEM,'9999999999D9999'), :NR_PRZ_ENTREGA, TO_NUMBER(:VL_IPI,'90D99'), :ID_USUARIO, :CS_IMPORTADO, :CS_TEM_ESTOQUE, :RETORNO); END;");
                oci_bind_by_name($stmt, ":ID_COTACAO", $id_cotacao);
                oci_bind_by_name($stmt, ":ID_PRODUTO", $id_produto);
                oci_bind_by_name($stmt, ":NM_MARCA", $nm_marca);
                oci_bind_by_name($stmt, ":CS_OUTRA_MARCA", $cs_outra_marca);
                oci_bind_by_name($stmt, ":QT_COTADO", $qt_cotado);
                oci_bind_by_name($stmt, ":NM_UNIDADE_COTADA", $nm_unidade);
                oci_bind_by_name($stmt, ":VL_ITEM", $vl_item);
                oci_bind_by_name($stmt, ":NR_PRZ_ENTREGA", $nr_prazo);
                oci_bind_by_name($stmt, ":VL_IPI", $vl_ipi);
                oci_bind_by_name($stmt, ":ID_USUARIO", $id_usuario);
                oci_bind_by_name($stmt, ":CS_IMPORTADO", $cs_importado);
                oci_bind_by_name($stmt, ":CS_TEM_ESTOQUE", $cs_tem);
                oci_bind_by_name($stmt, ":RETORNO", $retorno);
                oci_execute($stmt);

                return $retorno;

            }catch (Exception $ex){

            }

        }

        public function salvar_cotacao($id_cotacao, $id_forma, $dt_validade_proposta, $vl_minimo_faturamento, $te_frete){

            try{

                $retorno = 1;
                $vl_desconto = 0;
                $cs_fechado = 0;
                $conexao = new Conexao();
                $conexao->conectar();

                if($dt_validade_proposta != ""){
                    $stmt = oci_parse($conexao->conexao, "BEGIN COTACAO_FORNECEDOR.ALTERAR_CABECALHO_COTACAO(:ID_COTACAO, TO_DATE(:DT_VALIDADE_PROPOSTA,'DD/MM/YYYY'), :ID_FORMA, :TE_FRETE, :VL_MIN_FATURAMENTO, :CS_FECHADO, :VL_DESCONTO, :RETORNO); END;");
                }else{
                    $stmt = oci_parse($conexao->conexao, "BEGIN COTACAO_FORNECEDOR.ALTERAR_CABECALHO_COTACAO(:ID_COTACAO, :DT_VALIDADE_PROPOSTA, :ID_FORMA, :TE_FRETE, TO_NUMBER(:VL_MIN_FATURAMENTO,'9999999999D9999'), :CS_FECHADO, :VL_DESCONTO, :RETORNO); END;");
                }
                oci_bind_by_name($stmt, ":ID_COTACAO", $id_cotacao);
                oci_bind_by_name($stmt, ":DT_VALIDADE_PROPOSTA", $dt_validade_proposta);
                oci_bind_by_name($stmt, ":ID_FORMA", $id_forma);
                oci_bind_by_name($stmt, ":TE_FRETE", $te_frete);
                oci_bind_by_name($stmt, ":VL_MIN_FATURAMENTO", $vl_minimo_faturamento);
                oci_bind_by_name($stmt, ":CS_FECHADO", $cs_fechado );
                oci_bind_by_name($stmt, ":VL_DESCONTO", $vl_desconto);
                oci_bind_by_name($stmt, ":RETORNO", $retorno);

                oci_execute($stmt);

                return $retorno;

            }catch (Exception $ex){

            }

        }

        public function enviar_cotacao($id_cotacao){

            try{

                $retorno = 1;
                $conexao = new Conexao();
                $conexao->conectar();
                $stmt = oci_parse($conexao->conexao, "BEGIN COTACAO_FORNECEDOR.ENVIAR(:ID_COTACAO, :RETORNO); END;");
                oci_bind_by_name($stmt, ":ID_COTACAO", $id_cotacao);
                oci_bind_by_name($stmt, ":RETORNO", $retorno);
                oci_execute($stmt);

                switch($retorno){
                    case 1:
                        return json_encode((object)array("OK" => true, "message" => "Cotação enviada com sucesso."));
                    case 2:
                        return json_encode((object)array("OK" => false, "message" => "Essa cotação já foi enviado para o cliente por outro usuário."));
                    case 3:
                        return json_encode((object)array("OK" => false, "message" => "Não foi possível registrar as alterações. Essa solicitação foi FECHADA pelo comprador (para receber os preços) enquanto você preenchia o formulário."));
                }

            }catch(Exception $ex){

            }

        }

        public function reativar_cotacao($id_cotacao){
            try{

                $retorno = 1;
                $conexao = new Conexao();
                $conexao->conectar();
                $stmt = oci_parse($conexao->conexao, "BEGIN COTACAO_FORNECEDOR.REATIVAR(:ID_COTACAO, :RETORNO); END;");

                oci_bind_by_name($stmt, ":ID_COTACAO", $id_cotacao);
                oci_bind_by_name($stmt, ":RETORNO", $retorno);
                oci_execute($stmt);

                switch($retorno){
                    case 1:
                        return json_encode((object)array("OK" => true, "message" => "Cotação reativada com sucesso."));
                    case 2:
                        return json_encode((object)array("OK" => false, "message" => "Essa cotação já foi enviado para o cliente por outro usuário."));
                    case 3:
                        return json_encode((object)array("OK" => false, "message" => "Não foi possível registrar as alterações. Essa solicitação foi FECHADA pelo comprador (para receber os preços) enquanto você preenchia o formulário."));
                }

            }catch(Exception $ex){

            }

        }

        public function limpar_cotacao($id_cotacao){
            try{
                $conexao = new Conexao();
                $conexao->conectar();
                $stmt = oci_parse($conexao->conexao, "BEGIN COTACAO_FORNECEDOR.LIMPAR(:ID_COTACAO); END;");
                oci_bind_by_name($stmt, ":ID_COTACAO", $id_cotacao);
                oci_execute($stmt);
            }catch(Exception $ex){

            }
        }

        private function pendente_visto($conexao, $id_pedido){
            $sql = "UPDATE PEDIDOS SET ID_SITUACAO = 23, DT_VISTO = SYSDATE WHERE ID_PEDIDO = :ID AND ID_SITUACAO = 22";
            try{
                $dml = oci_parse($conexao, $sql);
                oci_bind_by_name($dml, ':ID', $id_pedido);
                oci_execute($dml);
            }catch(Exception $ex){

            }
        }

        private function visto($conexao, $id_pedido){
            $sql = "UPDATE PEDIDOS SET CS_NOVO = 'N' WHERE ID_PEDIDO = :ID";
            try{
                $dml = oci_parse($conexao, $sql);
                oci_bind_by_name($dml, ':ID', $id_pedido);
                oci_execute($dml);
            }catch(Exception $ex){

            }
        }

        private function atualizar($conexao, $id_sincronizacao){

            $sql = "UPDATE SINCRONIZACAO SET DT_DEVICE = SYSDATE WHERE ID_SINCRONIZACAO = :ID";
            try{
                $dml = oci_parse($conexao, $sql);
                oci_bind_by_name($dml, ':ID', $id_sincronizacao);
                oci_execute($dml);
                oci_commit($conexao);
            }catch(Exception $ex){

            }
        }

        public function registrarDevice($id_usuario, $registration_id, $phone_id, $phone_number, $phone_api){

            try{
                $device = 0;
                $conexao = new Conexao();
                $conexao->conectar();

                $stmt = oci_parse($conexao->conexao, "BEGIN REST_APP.REGISTRAR_DEVICE(:USUARIO, :REGISTRO, :PHONE_ID, :PHONE_NUMBER, :PHONE_API, :DEVICE); END;");
                oci_bind_by_name($stmt, ":USUARIO", $id_usuario, 12);
                oci_bind_by_name($stmt, ":REGISTRO", $registration_id, 4000);
                oci_bind_by_name($stmt, ":PHONE_ID", $phone_id, 4000);
                oci_bind_by_name($stmt, ":PHONE_NUMBER", $phone_number, 50);
                oci_bind_by_name($stmt, ":PHONE_API", $phone_api, 100);
                oci_bind_by_name($stmt, ":DEVICE", $device, 12);
                oci_execute($stmt);

                return '{"OK":true, "id_device":'.$device.'}';

            }catch (Exception $ex){

            }
        }

        public function sendMessage()
        {
            define('__GOOGLE_GCM_HTTP_URL__', 'http://android.googleapis.com/gcm/send'); // HTTP CHOOSE
            define('__GOOGLE_API_KEY__', 'AIzaSyBv3yII9w317KBBtneXqBCAQcsrxsxXbT4');

            $data = array('numero' => '272727(' . rand(0, 20000) . ')',
                'comprador' => '102',
                'data' => date('Y-m-d H:i:s'),
                'situacao' => '13');

            $gcmIds = array();
            $gcmIds[] = "APA91bHrUzNg-K9xgnE1aVePgclOD6JhWuhJwfS2Ef5VL6ebQuJjcY7RKL5eRuUkrma8MpqBo5_ZRZQbgpbXlA-ppBtEpQm1UcacNzqr5dH98rbEH38IaesNml2l9LCKOAXLP1vM2NYQmEWjEZd2sHutim34QKlBgw";

            $fields = array('registration_ids' => $gcmIds,
                //'notification_key'=>'',
                'collapse_key' => 'my_type',
                'delay_while_idle' => false,
                'time_to_live' => (60 * 60 * 24),
                'restricted_package_name' => 'br.com.mercadonarede.mnrcotacao',
                'dry_run' => false,
                'data' => $data);

            // HEADER
            $headers = array('Authorization: key=' . __GOOGLE_API_KEY__, 'Content-Type: application/json');

            // OPEN CONNECTION
            $ch = curl_init();

            // SET CURL
            curl_setopt($ch, CURLOPT_URL, __GOOGLE_GCM_HTTP_URL__);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);


            // SEND POST
            $result = curl_exec($ch);
            print "<pre>";
            print_r($result); // RAW RESULT
            print "</pre>";
            echo '<br /><br />';

            // RESULT JSON
            $html = '';
            $resultJson = json_decode($result);
            print "<pre>";
            print_r($resultJson); // RAW RESULT
            print "</pre>";
        }

        public function x($obj){
            print "<pre style='background: #ffffcc; padding: 10px; color: #666; border: 1px dotted #666'>";
            print_r($obj);
            print "</pre>";
        }

    }
?>