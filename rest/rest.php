<?php
ini_set("display_errors","on");

   class Rest{

      public function login($email_usuario, $senha_usuario){

            try{

                  $sql = "select count(*) from usuario where email_usuario = '{$email_usuario}' and senha_md5_usuario = md5('{$senha_usuario}')";
                  
                  $conexao = conectar();
                  $stmt = mysqli_query($conexao, $sql);
                  $rs = mysqli_fetch_array($stmt);

                  return $rs[0];
            }catch(Exception $e){

            }

      }

      public function cadastrarUsuario($nm_usuario, $email_usuario, $senha_usuario){

         try{

            $conexao = conectar();
            $retorno = 1;

            $sql = "insert into usuario
                  (nm_usuario, senha_usuario, senha_md5_usuario, email_usuario) 
                  values 
                  ('{$nm_usuario}', '{$senha_usuario}', md5('{$senha_usuario}'), '{$email_usuario}')";
            
            mysqli_query($conexao,$sql);

            return $retorno;

         }catch(Exception $e){
            
            return mysqli_error($conexao);

         }

      }

      public function addMovimentacao($nm_movimentacao, $vl_movimentacao, $dt_movimentacao, $cs_identificador, $usuario, $id_categoria, $id_conta, $mes){

         try{

            $conexao = conectar();

            if($cs_identificador == 0){
               $vl_movimentacao = -$vl_movimentacao;
            }

            if($dt_movimentacao == ""){
               $dt_movimentacao = "01/".$mes."/2017";
            }


            $sql = "insert into movimentacao 
                  (nm_movimentacao, vl_movimentacao, dt_movimentacao, dt_cadastro, cs_identificador, cs_planejamento, id_usuario, id_categoria, id_conta) 
                  values 
                  ('{$nm_movimentacao}', {$vl_movimentacao}, STR_TO_DATE('{$dt_movimentacao}','%d/%m/%Y'), sysdate(), {$cs_identificador}, 0,{$usuario}, {$id_categoria}, {$id_conta})";
            
            mysqli_query($conexao,$sql);
            return "Adicionado";
         }catch(Exception $e){
            
            return mysqli_error($conexao);

         }

      }

      public function excluir_movimentacao($id_movimentacao, $id_usuario, $id_conta){

         try{

            $conexao = conectar();

            $sql = "
            delete
            from 
              movimentacao 
            where 
              id_movimentacao = {$id_movimentacao}
              and id_usuario = {$id_usuario}
              and id_conta = {$id_conta}
              ";
            $stmt = mysqli_query($conexao,$sql);

            return json_encode(array("message" => "Excluida com sucesso"));

         }catch(Exception $e){

            return "";

         }

      }

      public function listaMovimentacao($usuario, $mes){

         try{

            $conexao = conectar();

            $sql ="
                  select
                     m.id_movimentacao as \"id_movimentacao\",
                     m.nm_movimentacao as \"nm_movimentacao\", 
                     m.vl_movimentacao as \"vl_movimentacao\",
                     date_format(m.dt_movimentacao,'%d/%m/%Y') as \"dt_movimentacao\",
                     m.cs_identificador as \"cs_identificador\",
                     c.id_conta as \"id_conta\",
                     c.nm_conta as \"nm_conta\",
                     ca.id_categoria as \"id_categoria\"
                  from 
                     movimentacao m, conta c, categorias ca
                  where
                     m.id_conta = c.id_conta
                  and
                     m.id_categoria = ca.id_categoria
                  and
                     m.id_usuario = {$usuario}
                  and
                     month(m.dt_movimentacao) = {$mes}
                  and
                     m.cs_planejamento = 0
                  order by
                     m.dt_cadastro desc
                  ";

            $rs = mysqli_query($conexao,$sql);
            $json = array();

            while($data = mysqli_fetch_assoc($rs)){
               array_walk($data, function(&$entry){
                  if($entry!=null){
                     $entry = $entry;
                  }
               });
                  $json[] = $data;
            }

            return '{"movimentacao":'.json_encode($json).'}';

         }catch(Exception $e){

            return "Rapaz, acho que deu certo nao";

         }

      }

      private function totalValores($id_conta, $id_usuario){

         try{

            $conexao = conectar();

            $sql = "select sum(vl_movimentacao) as \"total_movimentacao\"
                    from movimentacao
                    where id_conta = {$id_conta}
                    and id_usuario = {$id_usuario}
                   ";
            $rs = mysqli_query($conexao, $sql);

            return mysqli_fetch_object($rs);

         }catch(Exception $e){

            return "";

         }

      }

      public function updateSaldo($id_conta, $id_usuario){

         try{

            $conexao = conectar();

            $total = $this -> totalValores($id_conta, $id_usuario);
            $saldo = $total -> total_movimentacao;

            $sql = "update conta 
                    set sd_conta = {$saldo}
                    where id_conta = {$id_conta}
                    and id_usuario = {$id_usuario}
                   ";
            $rs = mysqli_query($conexao, $sql);
            
         }catch(Exception $e){
            
            return "Rapaz, deu certo nao";

         }

      }

      public function presentSaldo($id_usuario){

         try{

            $conexao = conectar();

            $sql = "select sum(sd_conta) as \"saldo\" from conta where id_usuario = {$id_usuario}";

            $rs = mysqli_query($conexao, $sql);

            $data = mysqli_fetch_array($rs);
            $saldo_total = $data["saldo"];

            if($saldo_total == ""){
                  $saldo_total = "0.00";
            }

            return $saldo_total;

         }catch(Exception $e){

            return "";

         }

      }

      public function addCategoria($nm_categoria, $id_usuario, $id_tipo_categoria){

          try{
              $conexao = conectar();
              $sql = "insert into categorias (nm_categoria, id_usuario, id_tipo_categoria) values ('{$nm_categoria}', {$id_usuario}, {$id_tipo_categoria})";
              mysqli_query($conexao, $sql);
          }catch(Exception $e){
              return "";
          }
      }

      public function addConta($nm_conta,$id_usuario,$sd_conta){

         try{

            $conexao = conectar();

            $sql = "insert into conta (nm_conta, sd_conta, id_usuario) values ('{$nm_conta}', {$sd_conta}, {$id_usuario})";

            $rs = mysqli_query($conexao, $sql);

         }catch(Exception $e){

            return "Rapaz, acho que nao deu certo";

         }

      }

      public function listaConta($usuario){

         try{

            $conexao = conectar();

            $sql = "select id_conta as \"id_conta\",
                    nm_conta as \"nm_conta\",
                    sd_conta as \"sd_conta\"
                    from conta
                    where id_usuario = {$usuario}
                   ";
            $rs = mysqli_query($conexao, $sql);

            $json = array();

            while($data = mysqli_fetch_assoc($rs)){
               array_walk($data, function(&$entry){
                  if($entry!=null){
                     $entry = $entry;
                  }
               });
                  $json[] = $data;
            }

            return '{"conta":'.json_encode($json).'}';

         }catch(Exception $e){

            return "Rapaz, deu certo nao";

         }

      }

      public function excluir_conta($id_conta, $id_usuario){

         try{

               $conexao = conectar();

               $sql = "delete from conta where id_conta = {$id_conta} and id_usuario = {$id_usuario}";

               $rs = mysqli_query($conexao, $sql);

               return json_encode(array("message" => "Conta excluída com sucesso"));

         }catch(Exception $e){

            return "";

         }

      }

      public function categorias($id_usuario){

         try{

            $conexao = conectar();

            $sql = "select id_categoria as \"id_categoria\", nm_categoria as \"nm_categoria\" from categorias where id_usuario = {$id_usuario} order by nm_categoria";

            $rs = mysqli_query($conexao, $sql);

            $json = array();

            while($data = mysqli_fetch_assoc($rs)){
               array_walk($data, function(&$entry){
                  if($entry!=null){
                     $entry = $entry;
                  }
               });
                  $json[] = $data;
            }

            return '{"categorias":'.json_encode($json).'}';

         }catch(Exception $e){

            return "";

         }

      }

      public function listaTipoCategoria(){

          try{
              $conexao = conectar();
              $sql = "
              select
                id_tipo_categoria as id_tipo_categoria,
                nm_tipo_categoria as nm_tipo_categoria
              from 
                tipo_categoria";
              $rs = mysqli_query($conexao, $sql);
              $json = array();
              while($data = mysqli_fetch_assoc($rs)){
                  array_walk($data, function(&$entry){
                      if($entry!=null){
                          $entry = utf8_encode($entry);
                      }
                  });
                  $json[] = $data;
              }
//              print "<pre>";
//                print_r(json_encode($json));
//              print "</pre>";
              return json_encode($json);
          }catch(Exception $e){
              return "";
          }

      }

      public function listaPlanejamento($usuario){

         try{

            $conexao = conectar();

            $sql ="
                  select
                     m.id_movimentacao as \"id_movimentacao\",
                     m.nm_movimentacao as \"nm_movimentacao\", 
                     m.vl_movimentacao as \"vl_movimentacao\",
                     date_format(m.dt_movimentacao,'%d/%m/%Y') as \"dt_movimentacao\",
                     m.cs_identificador as \"cs_identificador\",
                     c.id_conta as \"id_conta\",
                     c.nm_conta as \"nm_conta\",
                     c.sd_conta as \"sd_conta\",
                     ca.id_categoria as \"id_categoria\",
                     ca.nm_categoria as \"nm_categoria\"
                  from 
                     movimentacao m, conta c, categorias ca
                  where
                     m.id_conta = c.id_conta
                  and
                     m.id_categoria = ca.id_categoria
                  and
                     m.id_usuario = {$usuario}
                  and
                     m.cs_planejamento = 1
                  order by
                     m.dt_cadastro desc
                  ";

            $rs = mysqli_query($conexao,$sql);
            $json = array();

            while($data = mysqli_fetch_assoc($rs)){
               array_walk($data, function(&$entry){
                  if($entry!=null){
                     $entry = $entry;
                  }
               });
                  $json[] = $data;
            }

            return '{"planejamento":'.json_encode($json).'}';                  

         }catch(Exception $e){

            return "";

         }

      }

   }
?>