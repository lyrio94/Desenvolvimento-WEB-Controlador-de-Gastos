<!doctype html>
<html>
<head>
	<meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" type="text/css" href="mdl/material.min.css">
      <script type="text/javascript" src="mdl/material.min.js"></script>
   	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
   	<link rel="stylesheet" href="cabecalho.css">
   	<link rel="stylesheet" href="renda.css">
</head>
<body>
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header mdl-layout--fixed-tabs">
	<?php include "cabecalho.php";?>
	<main class="mdl-layout__content">
		<section class='mdl-layout__tab-panel' id='tab_movimentacao'>
        	<div class='page-content' id='conteudo_movimentacao'>
            <div class='container'>
               <form id="formulario" name="formulario" method="post">
                  <input type='hidden' name='usuario' value='1'>
                  <div class="form-title">Controle seus gastos</div>
                  <!-- <div class="campos">
                     <label class="lblPlanejamento">Planejamento:</label>
                     <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-1">
                        <input type="radio" id="option-1" class="mdl-radio__button" name="options" value="S">
                        <span class="mdl-radio__label">Sim</span>
                     </label>
                     <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-2">
                        <input type="radio" id="option-2" class="mdl-radio__button" name="options" value="N">
                        <span class="mdl-radio__label">Não</span>
                     </label>
                  </div> -->
                  <div class="campos">
                     <label class="lblTipo" for="tipo">Tipo:</label>
                     <select id="tipo" name="tipo">
                        <option value="1">Renda</option>
                        <option value="0">Despesa</option>
                     </select>
                  </div>
                  <div class="campos">
                     <label class="lblConta" for="conta">Conta:</label>
                     <select id="conta" name="conta">
                     </select>
                     <div id="add">
                        <a href="#" id="add_conta"><img src="imagens/add.png"></a>
                     </div>
                  </div>
                  <div class="campos">
                     <label class="lblCategoria" for="categoria">Categoria:</label>
                     <select id="categoria" name="categoria">
                     </select>
                  </div>
                  <div class="campos">
                     <label class="lblNome" for="nm_renda">Descrição:</label>
                     <input type='text' class="mdl-textfield mdl-js-textfield" id='nm_movimentacao' name='nm_movimentacao' autofocus />
                  </div>
                  <div class="campos">
                     <label class="lblValor" for="vl_renda">Valor:</label>
                     <input type='text' class="mdl-textfield mdl-js-textfield" id='dinheiro' name='vl_movimentacao' maxlength="7" />
                  </div>
                  <div class="campos">
                     <label class="lblData" for="dt_renda">Data:</label>
                     <input type='text' class='mdl-textfield mdl-js-textfield' id='data' name='dt_movimentacao' maxlength='10' maxlength="10" />
                  </div>
                  <div class="button">
                     <button id="cadastrar" class="mdl-button mdl-js-button mdl-button--raised">Salvar</button>
                  </div>
               </form>
            </div>
         </div>
      </section>
   	<section class='mdl-layout__tab-panel is-active' id='tab_historico'>
     	   <div class='page-content' id='conteudo_historico'>
            <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" id="table_conta">
               <thead>
                  <th></th>
                  <th class="mdl-data-table__cell--non-numeric">Conta</th>
                  <th>Saldo</th>
               </thead>
               <tbody>
               </tbody>
            </table>
            <div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
               <div class="mdl-tabs__tab-bar months">
                  <a href="#janeiro" class="mdl-tabs__tab" id="mes_jan" data-mes="1">Janeiro</a>
                  <a href="#fevereiro" class="mdl-tabs__tab" id="mes_fev" data-mes="2">Fevereiro</a>
                  <a href="#marco" class="mdl-tabs__tab" id="mes_mar" data-mes="3">Março</a>
                  <a href="#abril" class="mdl-tabs__tab" id="mes_abr" data-mes="4">Abril</a>
                  <a href="#maio" class="mdl-tabs__tab" id="mes_mai" data-mes="5">Maio</a>
                  <a href="#junho" class="mdl-tabs__tab" id="mes_jun" data-mes="6">Junho</a>
                  <a href="#julho" class="mdl-tabs__tab" id="mes_jul" data-mes="7">Julho</a>
                  <a href="#agosto" class="mdl-tabs__tab" id="mes_ago" data-mes="8">Agosto</a>
                  <a href="#setembro" class="mdl-tabs__tab" id="mes_set" data-mes="9">Setembro</a>
                  <a href="#outubro" class="mdl-tabs__tab" id="mes_out" data-mes="10">Outubro</a>
                  <a href="#novembro" class="mdl-tabs__tab" id="mes_nov" data-mes="11">Novembro</a>
                  <a href="#dezembro" class="mdl-tabs__tab" id="mes_dez" data-mes="12">Dezembro</a>
               </div>

               <div class="mdl-tabs__panel" id="janeiro">
                  <div>
                     <table>                  
                     </table>
                  </div>
               </div>
               <div class="mdl-tabs__panel" id="fevereiro">
                  <div>
                     <table>                  
                     </table>
                  </div>
               </div>
               <div class="mdl-tabs__panel" id="marco">
                  <div>
                     <table>                  
                     </table>
                  </div>
               </div>
               <div class="mdl-tabs__panel" id="abril">
                  <div>
                     <table>                  
                     </table>
                  </div>
               </div>
               <div class="mdl-tabs__panel" id="maio">
                  <div>
                     <table>                  
                     </table>
                  </div>
               </div>
               <div class="mdl-tabs__panel" id="junho">
                  <div>
                     <table>                  
                     </table>
                  </div>
               </div>
               <div class="mdl-tabs__panel" id="julho">
                  <div>
                     <table>                  
                     </table>
                  </div>
               </div>
               <div class="mdl-tabs__panel" id="agosto">
                  <div>
                     <table>                  
                     </table>
                  </div>
               </div>
               <div class="mdl-tabs__panel" id="setembro">
                  <div>
                     <table>                  
                     </table>
                  </div>
               </div>
               <div class="mdl-tabs__panel" id="outubro">
                  <div>
                     <table>                  
                     </table>
                  </div>
               </div>
               <div class="mdl-tabs__panel" id="novembro">
                  <div>
                     <table>                  
                     </table>
                  </div>
               </div>
               <div class="mdl-tabs__panel" id="dezembro">
                  <div>
                     <table>                  
                     </table>
                  </div>
               </div>
            </div>
      	</div>
   	</section>
      <section class='mdl-layout__tab-panel' id='tab_planejamento'>
         <div class='page-content' id='conteudo_planejamento'>
            <table id="table-planejamento">
            </table>
         </div>
      </section>
	</main>
   <div id="modal">
      <div class="formConta-title">
         Adicione uma conta
      </div>
      <form id="formConta" name="formConta" method="post" action="rest/control.php?action=addConta">
         <input type="hidden" name="usuario" value="1">
         <table>
            <tr>
               <td>Nome:</td>
               <td><input type="text" id="nm_conta" name="nm_conta" value=""></td>
            </tr>
            <tr>
               <td>Saldo Inicial:</td>
               <td><input type="text" id="sd_conta" name="sd_conta" value=""></td>
            </tr>
            <tr>
               <td><button class="mdl-js-button mdl-button--raised" id="btn_add_conta">Cadastrar</button></td>
            </tr>
         </table>
      </form>
   </div>
</div>
</body>
</html>
<script type="text/javascript" src="../library/jquery/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="../library/jquery-mask/jquery.mask.min.js"></script>
<script src="mascara.js"></script>
<script type="text/javascript" src="Util.js"></script>
<script type="text/javascript">
$(document).ready(function(){

   // $("#conta").change(function(){
   //    id_conta = $(this).val();
   // });

   $('#dinheiro').mask('0.000.000,00', {reverse: true});

   $("#modal").hide();

   $("#cadastrar").click(function(evt){
      
      var cs_identificador = $("#tipo").val();
      var id_conta = $("#conta").val();
      var id_categoria = $("#categoria").val();
      var nm_movimentacao = $("#nm_movimentacao").val();
      var vl_movimentacao = $("#dinheiro").val().replace(".","").replace(",",".");
      var dt_movimentacao = $("#data").val();
      var mes = verificarData();

      evt.preventDefault();
      // alert(cs_identificador+","+id_conta+","+nm_movimentacao+","+vl_movimentacao+","+dt_movimentacao);
      var action = "rest/control.php?action=addMovimentacao&mes="+mes;
      $("#formulario").attr("action",action);
      $("#formulario").submit();

   });

   $("#data").on("keypress", function(){
      // console.log($(this).val());
      mascaraData($(this).val());
   });

   // $("#dinheiro").on("keypress", function(){
   //    mascaraDinheiro($(this).val());
   // });

   $("input").click(function(){
      $(this).select();
   });

   $("#add_conta").click(function(){
      $("#modal").show();
   });

   $("#btn_add_conta").click(function(){
      $("#formConta").submit();
      $("#modal").close();
   });

   var mes = verificarData();
   listaMovimentacao(mes);
   listaConta();
   algumaCoisa();
   categorias();
   // verificarData();

   $("#planejamento").on("click",function(){
      listaPlanejamento(mes);
   });

});

var listaConta = function(){
   U.Ajax.execute({"url":"rest/control.php", "query":"action=listaConta&usuario=1", "method":"POST","assincrony":true, "oncallback":function(retorno){
      var dados = eval("("+retorno+")");

      $("#conta").append($("<option>").append("Escolher"));

      for(var i = 0;i < dados.conta.length;i++){

         if(dados.conta[i].sd_conta == ""){
            dados.conta[i].sd_conta == 0.00; 
         }

         $("#table_conta > tbody").append(
            $("<tr>").addClass("t_cancel").append(
               $("<td>").append(
                  $("<i>").addClass("material-icons cancel_conta").data("conta",dados.conta[i].id_conta).css("cursor","pointer").append("cancel")
               )
            ).append(
               $("<td>").append(dados.conta[i].nm_conta)
            ).append(
               $("<td>").append(
                  (dados.conta[i].sd_conta > 0.00 ? $("<span>").addClass("saldo").css("color","#7CB342").append("R$ "+dados.conta[i].sd_conta.replace(".",",").replace("-","")) : $("<span>").addClass("saldo").css("color","#E53935").append("R$ "+dados.conta[i].sd_conta.replace(".",",").replace("-","")))
               )
            )
         )

         $("#conta").append(
            $("<option>").attr("value",dados.conta[i].id_conta).append(dados.conta[i].nm_conta)
         );
      }

      presentSaldo();

      $(".cancel_conta").click(function(){

         var id_conta = $(this).data("conta");
         // alert(id_conta);
         excluir_conta(id_conta);

      });
      
   }});
}

var presentSaldo = function(){

   U.Ajax.execute({"url":"rest/control.php", "query":"action=presentSaldo","method":"POST", "assincrony":true, "oncallback":function(retorno){

      $(".header-current__total").append("R$ "+retorno.replace(".",","));

   }});

}

var listaMovimentacao = function(mes){

   // var mes = verificarData();
   $(".lista_movimentacao > table").empty();
   
   U.Ajax.execute({"url":"rest/control.php", "query":"action=listaMovimentacao&usuario=1&mes="+mes, "method":"POST","assincrony":true, "oncallback":function(retorno){
      var dados = eval("("+retorno+")");
      // alert(retorno);

      var table = $(".lista_movimentacao > table");
      var id;

      for(var i = 0;i < dados.movimentacao.length;i++){

         var vl_movimentacao = dados.movimentacao[i].vl_movimentacao;
         var nm_movimentacao = dados.movimentacao[i].nm_movimentacao;

         if(dados.movimentacao[i].cs_identificador == "0"){
            vl_movimentacao = dados.movimentacao[i].vl_movimentacao.replace("-","");
         }

         if(dados.movimentacao[i].nm_movimentacao == ""){
            nm_movimentacao = dados.movimentacao[i].nm_categoria;
         }

         table.append(
            $("<tr class='linha_movimentacao'>").data("cs_identificador",dados.movimentacao[i].cs_identificador).append(
               $("<td>").append(
                  (dados.movimentacao[i].cs_identificador == "0" ? $("<i>").addClass("material-icons id").css("color","#E53935").append("monetization_on") : $("<i>").addClass("material-icons id").css("color","#7CB342").append("monetization_on"))
               )
            ).append(
               $("<td>").append(
                  nm_movimentacao
               )
            ).append(
               $("<td>").append(
                  dados.movimentacao[i].nm_conta
               )
            ).append(
               $("<td>").append(
                  "R$ "+vl_movimentacao.replace(".",",")
               )
            ).append(
               $("<td>").append(
                  dados.movimentacao[i].dt_movimentacao
               )
            ).append(
               $("<td>").append(
                  $("<i>").addClass("material-icons edit").css("cursor","pointer").append("edit")
               )
            ).append(
               $("<td>").append(
                  $("<i>").addClass("material-icons excluir").data("movimento",{
                     "id_movimentacao":dados.movimentacao[i].id_movimentacao,
                     "usuario": "1",
                     "id_conta": dados.movimentacao[i].id_conta
                  }).css("cursor","pointer").append("cancel")
               )
            ).hover(
               function(){
                  ($(this).data("cs_identificador") == "0" ? $(this).css("background-color","#E57373") : $(this).css("background-color","#A5D6A7"));
               },
               function(){
                  $(this).css("background-color","#F5F5F5");
               }
            )
         )
         
      }
         // $("tr").hover(function(){
         //    $(this).css("background","#000");
         // }, function(){
         //    $(this).css("background","#fff");
         // })
         $(".excluir").click(function(evt){

            var id_movimentacao = $(this).data("movimento").id_movimentacao;
            var usuario = $(this).data("movimento").usuario;
            var id_conta = $(this).data("movimento").id_conta;
            // alert(id+","+usuario+","+id_conta);

            excluir_movimentacao(id_movimentacao,usuario,id_conta);
         });

         $(".edit").click(function(){
            
            $(this).empty();
            $(this).removeClass("edit");
            
            $(this).append("save").click(function(){
               $(this).empty();
               $(this).addClass("edit");
               $(this).append("edit");
            })


         });
      
   }});
}

var listaPlanejamento = function(){
   
   U.Ajax.execute({"url":"rest/control.php", "query":"action=listaPlanejamento&usuario=1", "method":"POST","assincrony":true, "oncallback":function(retorno){
      var dados = eval("("+retorno+")");
      // alert(retorno);

      var table = $("#table-planejamento");
      var id;

      table.empty();

      for(var i = 0;i < dados.planejamento.length;i++){

         var vl_movimentacao = dados.planejamento[i].vl_movimentacao;
         var nm_movimentacao = dados.planejamento[i].nm_movimentacao;

         if(dados.planejamento[i].cs_identificador == "0"){
            vl_movimentacao = dados.planejamento[i].vl_movimentacao.replace("-","");
         }

         if(dados.planejamento[i].nm_movimentacao == ""){
            nm_movimentacao = dados.planejamento[i].nm_categoria;
         }

         table.append(
            $("<thead>").append(
               $("<tr>").append(
                  $("<th>").append(dados.planejamento[i].nm_conta)
               ).append(
                  $("<th>").append(dados.planejamento[i].sd_conta)
               )
            )
         ).append(
            $("<tr class='linha_movimentacao'>").data("cs_identificador",dados.planejamento[i].cs_identificador).append(
               $("<td>").append(nm_movimentacao)  
            ).append(
               $("<td>").append(dados.planejamento[i].nm_categoria)
            ).append(
               $("<td>").append(dados.planejamento[i].dt_movimentacao)
            ).append(
               $("<td>").append(
                  $("<i>").addClass("material-icons edit").css("cursor","pointer").append("done")
               )
            ).append(
               $("<td>").append(
                  $("<i>").addClass("material-icons excluir").data("movimento",{
                     "id_movimentacao":dados.planejamento[i].id_movimentacao,
                     "usuario": "1",
                     "id_conta": dados.planejamento[i].id_conta
                  }).css("cursor","pointer").append("cancel")
               )
            )
         )
         
         if(parseInt(dados.planejamento[i].sd_conta) > 0){
            $("td:eq(2)").css("color","green");
         }else if(parseInt(dados.planejamento[i].sd_conta) < 0){
            $("td:eq(2)").css("color","red");
         }else{
            $("td:eq(2)").css("color","#000");
         }

      }

         // $("tr").hover(function(){
         //    $(this).css("background","#000");
         // }, function(){
         //    $(this).css("background","#fff");
         // })
         $(".excluir").click(function(evt){

            var id_movimentacao = $(this).data("movimento").id_movimentacao;
            var usuario = $(this).data("movimento").usuario;
            var id_conta = $(this).data("movimento").id_conta;
            // alert(id+","+usuario+","+id_conta);

            excluir_movimentacao(id_movimentacao,usuario,id_conta);
         });

         $(".edit").click(function(){
            
            $(this).empty();
            $(this).removeClass("edit");
            
            $(this).append("save").click(function(){
               $(this).empty();
               $(this).addClass("edit");
               $(this).append("edit");
            })


         });
      
   }});
}

var categorias = function(){

   U.Ajax.execute({"url":"rest/control.php", "query":"action=categorias", "method":"POST", "assincrony":true, "oncallback":function(retorno){
      var dados = eval("("+retorno+")");

      $("#categoria").append($("<option>").append("Escolher"));

      for(var i = 0;i < dados.categorias.length;i++){

         $("#categoria").append(
            $("<option>").attr("value", dados.categorias[i].id_categoria).append(dados.categorias[i].nm_categoria)
         )

      }
   }})

}

var excluir_movimentacao = function(id, usuario, id_conta){

   // alert(id+","+usuario+","+id_conta);
   $.post("rest/control.php",{"action": "excluir_movimentacao", "id_movimentacao": id, "usuario": usuario, "id_conta": id_conta}).success(function(data){
      alert(data);
   }).fail(function(){
      alert("Não foi possível excluir essa movimentação");
   });

   var mes = verificarData();
   listaMovimentacao(mes);

}

var excluir_conta = function(id_conta){

   // alert(id_conta);
   $.post("rest/control.php",{"action": "excluir_conta","id_conta": id_conta}).done(function(data){
      alert(data);
      listaConta();
   });

}

//TODO: MENSAGENS!! SEM ALERTAS!!

var verificarData = function(){

   var data = new Date();
   var mes = data.getMonth()+1;
   // alert(mes);

   switch(mes){
      case 1:
         $("#mes_jan").addClass("is-active");
         $("#janeiro").addClass("is-active");
         $("#janeiro > div").addClass("lista_movimentacao");
      break;

      case 2:
         $("#mes_fev").addClass("is-active");
         $("#fevereiro").addClass("is-active");
         $("#fevereiro > div").addClass("lista_movimentacao");
      break;

      case 3:
         $("#mes_mar").addClass("is-active");
         $("#marco").addClass("is-active");
         $("#marco > div").addClass("lista_movimentacao");
      break;

      case 4:
         $("#mes_abr").addClass("is-active");
         $("#abril").addClass("is-active");
         $("#abril > div").addClass("lista_movimentacao");
      break;

      case 5:
         $("#mes_mai").addClass("is-active");
         $("#maio").addClass("is-active");
         $("#maio > div").addClass("lista_movimentacao");
      break;

      case 6:
         $("#mes_jun").addClass("is-active");
         $("#junho").addClass("is-active");
         $("#junho > div").addClass("lista_movimentacao");
      break;

      case 7:
         $("#mes_jul").addClass("is-active");
         $("#julho").addClass("is-active");
         $("#julho > div").addClass("lista_movimentacao");
      break;

      case 8:
         $("#mes_ago").addClass("is-active");
         $("#agosto").addClass("is-active");
         $("#agosto > div").addClass("lista_movimentacao");
      break;

      case 9:
         $("#mes_set").addClass("is-active");
         $("#setembro").addClass("is-active");
         $("#setembro > div").addClass("lista_movimentacao");
      break;

      case 10:
         $("#mes_out").addClass("is-active");
         $("#outubro").addClass("is-active");
         $("#outubro > div").addClass("lista_movimentacao");
      break;

      case 11:
         $("#mes_nov").addClass("is-active");
         $("#novembro").addClass("is-active");
         $("#novembro > div").addClass("lista_movimentacao");
      break;

      case 12:
         $("#mes_dez").addClass("is-active");
         $("#dezembro").addClass("is-active");
         $("#dezembro > div").addClass("lista_movimentacao");
      break;

   }

   return mes;

}

var algumaCoisa = function(){

   $("#mes_fev").click(function(){
      var mes = $(this).data("mes");
      // alert(mes);
      $("#fevereiro > div").addClass("lista_movimentacao");
      listaMovimentacao(mes);
   });

   $("#mes_mar").click(function(){
      var mes = $(this).data("mes");
      // alert(mes);
      $("#marco > div").addClass("lista_movimentacao");
      listaMovimentacao(mes);
   });
   
   $("#mes_abr").click(function(){
      var mes = $(this).data("mes");
      // alert(mes);
      $("#abril > div").addClass("lista_movimentacao");
      listaMovimentacao(mes);
   });   

   $("#mes_mai").click(function(){
      var mes = $(this).data("mes");
      // alert(mes);
      $("#maio > div").addClass("lista_movimentacao");
      listaMovimentacao(mes);
   }); 
   
   $("#mes_jun").click(function(){
      var mes = $(this).data("mes");
      // alert(mes);
      $("#junho > div").addClass("lista_movimentacao");
      listaMovimentacao(mes);
   }); 
   
   $("#mes_jul").click(function(){
      var mes = $(this).data("mes");
      // alert(mes);
      $("#julho > div").addClass("lista_movimentacao");
      listaMovimentacao(mes);
   }); 

   $("#mes_ago").click(function(){
      var mes = $(this).data("mes");
      // alert(mes);
      $("#agosto > div").addClass("lista_movimentacao");
      listaMovimentacao(mes);
   }); 

   $("#mes_set").click(function(){
      var mes = $(this).data("mes");
      // alert(mes);
      $("#setembro > div").addClass("lista_movimentacao");
      listaMovimentacao(mes);
   }); 

   $("#mes_out").click(function(){
      var mes = $(this).data("mes");
      // alert(mes);
      $("#outubro > div").addClass("lista_movimentacao");
      listaMovimentacao(mes);
   }); 

   $("#mes_nov").click(function(){
      var mes = $(this).data("mes");
      // alert(mes);
      $("#novembro > div").addClass("lista_movimentacao");
      listaMovimentacao(mes);
   }); 

   $("#mes_dez").click(function(){
      var mes = $(this).data("mes");
      // alert(mes);
      $("#dezembro > div").addClass("lista_movimentacao");
      listaMovimentacao(mes);
   }); 
}
</script>