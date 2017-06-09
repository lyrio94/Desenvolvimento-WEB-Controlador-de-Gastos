<!doctype html>
<html>
<head>
	<meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" type="text/css" href="mdl/material.min.css">
      <script type="text/javascript" src="mdl/material.min.js"></script>
   	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
   	<link rel="stylesheet" href="cabecalho.css">
    <style>
        /*#modal{
	background-color: #fff;
	z-index: 99999999;
	border: 1px solid;
	padding: 100px;
	width: 10px;

}*/

        /*#renda.is-active::after{
            background: #7CB342;
        }
        #despesa.is-active::after{
            background: #E53935;
        }
        #historico.is-active::after{
            background: #F5F5F5;
        }*/

        .mdl-tabs.is-upgraded .mdl-tabs__tab.is-active:after{
            background: #424242;
        }
        .mdl-tabs__tab .mdl-tabs__ripple-container .mdl-ripple{
            background: #424242;
        }

        .mdl-textfield--floating-label.is-focused .mdl-textfield__label,.mdl-textfield--floating-label.is-dirty .mdl-textfield__label,.mdl-textfield--floating-label.has-placeholder .mdl-textfield__label{
            color: #FF4081;
        }
        .mdl-textfield__label:after{
            background-color: #ff4081;
        }

        .container{
            padding: 70px;
            border: 1px solid #424242;
            padding-bottom: 30px;
            padding-top: 40px;
            background-color: #EEEEEE;
            /*border-radius: 30px;*/
            margin-top: 70px;
            margin-left: 400px;
            margin-right: 350px;
            box-shadow: 3px 5px 10px #BDBDBD;
        }

        #cadastrar{
            background-color: #424242;
            color: #fff;
        }

        .campos{
            margin: 30px;
        }

        .campos > input{
            height: 10px;
            border: none;
            border-radius: 8px;
        }

        #data{
            text-align: center;
        }

        #nm_movimentacao, #dinheiro, #data{
            width: 300px;
        }

        select{
            background-color: #fff;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            height: 35px;
            width: 300px;
        }

        label{
            font-size: 13px;
            font-weight: bold;
            color: #424242;
        }

        .lblPlanejamento{
            margin-right: 10px;
        }

        .lblTipo{
            margin-right: 50px;
        }

        .lblConta{
            margin-right: 41px;
        }

        .lblCategoria{
            margin-right: 18px;
        }

        .lblNome{
            margin-right: 16px;
        }

        .lblValor{
            margin-right: 45px;
        }

        .lblData{
            margin-right: 48px;
        }

        .form-title{
            font-size: 25px;
            color: #424242;
            font-weight: bold;
        }

        #cadastrar{
            margin-left: 400px;
        }

        #dinheiro{
            text-align: right;
        }

        .contas-area{
            max-width: 30%;
            float: right;
        }

        .contas-area > #table_conta {
            width: 100%;
        }

        #saldo{
            background-color: #F5F5F5;
            float: right;
            z-index: 9999999;
            box-shadow: 1px 3px 10px #9E9E9E;
        }

        .saldo-total{
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            letter-spacing: 2px;
        }

        .lista_movimentacao{
            width: 100%;
        }

        .lista_movimentacao > table{
            width: 100%;
            border-spacing: 0px;
        }

        .valor{
            padding-left: 50px;
            padding-right: 50px;
        }

        #modal{
            padding: 5px;
            display: none;
            width: 55%;
            position: absolute;
            bottom:0;
            left: 20%;
            z-index: 100;
            background-color: #ffffff;
            border: 1px solid #E9E9E9;
            border-top-right-radius: 5px;
            border-top-left-radius: 5px;
            box-shadow: 0 0px 5px 5px #E9E9E9;
        }

        #modal2{
            padding: 5px;
            display: none;
            width: 45%;
            position: absolute;
            bottom:0;
            left: 30%;
            z-index: 100;
            background-color: #ffffff;
            border: 1px solid #E9E9E9;
            border-top-right-radius: 5px;
            border-top-left-radius: 5px;
            box-shadow: 0 0px 5px 5px #E9E9E9;
        }

        #btn-adicionar-conta, #btn-adicionar-categoria{
            float: right;
            top: 15px;
        }

        .to-saldo{
            color: #BDBDBD;
        }

        #sd_conta{
            text-align: right;
        }

        #formConta > table{
            padding: 10px;
        }

        .menu-adicao{
            position: fixed;
            bottom: 0;
            right: 20px;
        }

        .movimentacao-area{
            width: 75%;
        }

        .mdl-tabs__tab{
            font-size: 12px;
        }
        .mdl-tabs__tab-bar{
            width: 100%;
        }
        .linha_movimentacao{
            height: 50px;
        }


        /*.extrato{
            background-color: #EEEEEE;
            padding: 70px;
        }*/
    </style>
</head>
<body>
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header mdl-layout--fixed-tabs">
	<?php include "cabecalho.php";?>
	<main class="mdl-layout__content">
		<section class='mdl-layout__tab-panel' id='tab_movimentacao'>
        	<div class='page-content' id='conteudo_movimentacao'>
            <div class='container'>
               <form id="formulario" name="formulario" method="post">
                  <input type='hidden' name='usuario' value='<?=$_SESSION["id_usuario"]?>'>
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
                     <select id="conta" name="conta"></select>
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
               <div class="contas-area">
                <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" id="table_conta">
                   <thead>
                      <th></th>
                      <th class="mdl-data-table__cell--non-numeric">Conta</th>
                      <th>Saldo</th>
                   </thead>
                   <tbody>
                   </tbody>
                </table>
               </div>
               <div class="movimentacao-area">
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
           </div>
   	</section>
      <section class='mdl-layout__tab-panel' id='tab_planejamento'>
         <div class='page-content' id='conteudo_planejamento'>
            <h1>Em breve</h1>
         </div>
      </section>
        <div class="menu-adicao">
            <button id="adicionar" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored" data-change="add">
                <i class="material-icons">add</i>
            </button>
            <ul id="menuAdicionar" class="mdl-menu mdl-menu--top-right mdl-js-menu mdl-js-ripple-effect" data-mdl-for="adicionar">
                <li class="mdl-menu__item menu-action" data-action="1">Conta</li>
                <li class="mdl-menu__item menu-action" data-action="2">Categoria</li>
            </ul>
        </div>
        <div id="modal" class="mdl-modal__bottom">
            <form id="formConta" name="formConta" method="post" action="rest/control.php?action=addConta">
                <input type="hidden" id="usuario" name="usuario" value='<?=$_SESSION["id_usuario"]?>'>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 30%;padding-right:10px;">
                    <input class="mdl-textfield__input" type="text" id="nm_conta" name="nm_conta">
                    <label class="mdl-textfield__label" for="nm_conta">Nome Conta</label>
                </div>
                <i class="material-icons to-saldo">more_vert</i>
                <div class="mdl-textfield mdl-js-textfield" style="width: 20%;">
                    <input class="mdl-textfield__input" type="text" id="sd_conta" name="sd_conta">
                    <label class="mdl-textfield__label" for="sd_conta">Saldo</label>
                </div>
                <button type="button" id="btn-adicionar-conta" class="mdl-button mdl-js-button mdl-js-ripple-effect">
                    Adicionar
                </button>
            </form>
        </div>
        <div id="modal2" class="mdl-modal__bottom">
            <form id="formCategoria" name="formCategoria" method="post" action="rest/control.php?action=addCategoria">
                <input type="hidden" id="usuario" name="usuario" value='<?=$_SESSION["id_usuario"]?>'>
                <div class="mdl-textfield mdl-js-textfield" style="width: 40%;">
                    <input class="mdl-textfield__input" type="text" id="nm_categoria" name="nm_categoria">
                    <label class="mdl-textfield__label" for="nm_categoria">Nome Categoria</label>
                </div>
                <select id="tipo_categoria" style="width: 30%;">

                </select>
                <button type="button" id="btn-adicionar-categoria" class="mdl-button mdl-js-button mdl-js-ripple-effect">
                    Adicionar
                </button>
            </form>
        </div>
	</main>
</div>
</body>
</html>
<script type="text/javascript" src="../library/jquery/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="library/jquery-mask/jquery.mask.min.js"></script>
<script src="mascara.js"></script>
<script type="text/javascript" src="Util.js"></script>
<script type="text/javascript">
$(document).ready(function(){
alert();
   // $("#conta").change(function(){
   //    id_conta = $(this).val();
   // });
    $(".mdl-button--fab").click(function(evt){
        if($(this).data("change") == "close"){
            changeButtonIcon();
            if(($("#modal").show()) || ($("#modal2").show())){
                $(".mdl-modal__bottom").hide();
            }
        }
    });

   $('#dinheiro').mask('0.000.000,00', {reverse: true});
   $('#sd_conta').mask('0.000.000,00', {reverse: true});

   $("#getOut").on("click",function(){
         $.get("rest/control.php?action=logout");
   });

   $("#cadastrar").click(function(evt){
      
      var cs_identificador = $("#tipo").val();
      var id_conta = $("#conta").val();
      var id_categoria = $("#categoria").val();
      var nm_movimentacao = $("#nm_movimentacao").val();
      var vl_movimentacao = $("#dinheiro").val().replace(/\./g,"").replace(",",".");
      var dt_movimentacao = $("#data").val();
      var mes = verificarData();

      evt.preventDefault();
//      alert(cs_identificador+","+id_conta+","+nm_movimentacao+","+vl_movimentacao+","+dt_movimentacao);
      var action = "rest/control.php?action=addMovimentacao&mes="+mes;
//      $("#formulario").attr("action",action);
//      $("#formulario").submit();
       $.post(action,{
           "nm_movimentacao" : nm_movimentacao,
           "vl_movimentacao" : vl_movimentacao,
           "dt_movimentacao" : dt_movimentacao,
           "id_categoria" : id_categoria,
           "id_conta" : id_conta,
           "cs_identificador" : cs_identificador,
           "id_usuario" : $("[name=usuario]").val()
       }).success(function(data){
           location.reload();
       });

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

//   $("body").click(function(evt){
//      $("#modal").toggle(100);
//   });

   $(".menu-action").click(function(){
       switch($(this).data("action")){
           case 1:
               $("#modal").toggle(100);
               changeButtonIcon();
               break;
           case 2:
               $("#modal2").toggle(100);
               changeButtonIcon();
               break;
       }
   });

   $("#btn-adicionar-conta").click(function(){
       var mes = verificarData();
       var saldo = $("#sd_conta").val().replace(/\./g,"").replace(",",".");
       if($("#nm_conta").val() == ""){
           alert("Informe o nome da conta");
           return false;
       }else if(saldo == ""){
           alert("Informe o saldo da conta ou o saldo não pode começar com 0");
           return false;
       }else{
           $.post($("#formConta").attr("action"),
               {
                   "id_usuario": $("[name=usuario]").val(),
                   "nm_conta": $("#nm_conta").val(),
                   "sd_conta": saldo
               }
           ).success(function(data){
               $("#nm_conta, #sd_conta").val("");
               listaMovimentacao(mes);
               listaConta();
               $("#modal").toggle(100);
               changeButtonIcon();
           }).error(function(data){
               console.log(data);
           });
       }
   });

   $("#btn-adicionar-categoria").click(function(){
       if($("#nm_categoria").val() == "") {
           alert("Informe o nome da categoria");
           return false;
       }else if($("#tipo_categoria").val() == 0){
           alert("Escolha um tipo de categoria");
           return false;
       }else{
           $.post($("#formCategoria").attr("action"),
               {
                   "id_usuario" : $("[name=usuario").val(),
                   "nm_categoria" : $("#nm_categoria").val(),
                   "id_tipo_categoria" : $("#tipo_categoria").val()
               }
           ).success(function(data){
               $("#nm_categoria").val("");
               $("#modal2").toggle(100);
               categorias();
               changeButtonIcon();
//               console.log(data);
           });
       }
   });

   var mes = verificarData();
   listaMovimentacao(mes);
   listaConta();
   algumaCoisa();
   categorias();
   listaTipoCategoria();
   // verificarData();

   $("#planejamento").on("click",function(){
      listaPlanejamento(mes);
   });

});

var listaTipoCategoria = function(){
    $("#tipo-categoria").empty();
    U.Ajax.execute({"url":"rest/control.php?action=listaTipoCategoria", "method":"POST", "assincrony":true, "oncallback":function(retorno){
       var dados = eval("("+retorno+")");
//       console.log("JSON: "+ dados);
        $("#tipo_categoria").append(
            $("<option>").val(0).html("Escolher")
        )
       for(var i = 0;i < dados.length;i++){
           $("#tipo_categoria").append(
               $("<option>").val(dados[i].id_tipo_categoria).html(dados[i].nm_tipo_categoria)
           )
       }
       componentHandler.upgradeAllRegistered();
    }});
}

var changeButtonIcon = function(){
    $(".mdl-button--fab").empty();
    if($(".mdl-button--fab").data("change") == "add"){
        $(".mdl-button--fab").append($("<i>").addClass("material-icons").text("close"));
        $(".mdl-button--fab").data("change", "close");
    }else{
        $(".mdl-button--fab").append($("<i>").addClass("material-icons").text("add"));
        $(".mdl-button--fab").data("change", "add");
    }
}

var listaConta = function(){
    $("#conta").empty();
    $("#table_conta > tbody").empty();
   U.Ajax.execute({"url":"rest/control.php", "query":"action=listaConta&usuario="+$("[name=usuario]").val(), "method":"POST","assincrony":true, "oncallback":function(retorno){
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
            $("<option>").attr("value",dados.conta[i].id_conta).html(dados.conta[i].nm_conta)
         );
      }

      componentHandler.upgradeAllRegistered();
      presentSaldo();

      $(".cancel_conta").click(function(){

         var id_conta = $(this).data("conta");
         // alert(id_conta);
         excluir_conta(id_conta, $("[name=usuario").val());

      });
      
   }});
}

var presentSaldo = function(){

   U.Ajax.execute({"url":"rest/control.php", "query":"action=presentSaldo&id_usuario="+$("[name=usuario]").val(),"method":"POST", "assincrony":true, "oncallback":function(retorno){
       var saldo = (retorno < 0.00) ? $(".header-current__total").css("color", "#E53953") : $(".header-current__total").css("color", "#7CB342");
       $(".header-current__total").empty();
       $(".header-current__total").append("R$ "+retorno.replace(".",","));
       componentHandler.upgradeAllRegistered();
   }});

}

var listaMovimentacao = function(mes){

   // var mes = verificarData();
   $(".lista_movimentacao > table").empty();
   $(".lista_movimentacao > table").addClass("table-movimentacao-lista");
   
   U.Ajax.execute({"url":"rest/control.php", "query":"action=listaMovimentacao&usuario="+$("[name=usuario]").val()+"&mes="+mes, "method":"POST","assincrony":true, "oncallback":function(retorno){
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
                     "usuario": $("[name=usuario]").val(),
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
       componentHandler.upgradeAllRegistered();
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
   
   U.Ajax.execute({"url":"rest/control.php", "query":"action=listaPlanejamento&usuario="+$("[name=usuario]").val(), "method":"POST","assincrony":true, "oncallback":function(retorno){
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
                     "usuario": $("[name=usuario").val(),
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

    $("#categoria").empty();

   U.Ajax.execute({"url":"rest/control.php", "query":"action=categorias&id_usuario=<?=$_SESSION['id_usuario']?>", "method":"POST", "assincrony":true, "oncallback":function(retorno){
      var dados = eval("("+retorno+")");

      $("#categoria").append($("<option>").append("Escolher"));

      for(var i = 0;i < dados.categorias.length;i++){

         $("#categoria").append(
            $("<option>").attr("value", dados.categorias[i].id_categoria).append(dados.categorias[i].nm_categoria)
         )

      }
       componentHandler.upgradeAllRegistered();
   }});

}

var excluir_movimentacao = function(id, usuario, id_conta){

   // alert(id+","+usuario+","+id_conta);
   $.post("rest/control.php",{"action": "excluir_movimentacao", "id_movimentacao": id, "id_usuario": usuario, "id_conta": id_conta}).success(function(data){
      console.log(data);
   }).fail(function(){
      alert("Não foi possível excluir essa movimentação");
   });

   var mes = verificarData();
   listaMovimentacao(mes);
   listaConta();

}

var excluir_conta = function(id_conta, id_usuario){

   // alert(id_conta);
   $.post("rest/control.php",{"action": "excluir_conta", "id_conta": id_conta, "id_usuario": id_usuario}).done(function(data){
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