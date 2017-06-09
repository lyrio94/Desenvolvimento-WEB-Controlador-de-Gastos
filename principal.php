<?php
$error = isset($_GET["error"]) ? $_GET["error"] : false;
$success = isset($_GET["scs"]) ? $_GET["scs"] : false;
//print $error."<br/>";
//print $success;
//die();
if($error){
    $alerta = 1;
}elseif($success){
    $alerta = 2;
}else{
    $alerta = 0;
}
//print $alerta;
//die();
?>
<!doctype html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<link rel="stylesheet" type="text/css" href="library/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="library/jquery-ui/css/smoothness/jquery-ui-1.10.4.custom.min.css">
		<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="nav.css">
		<style type="text/css">
			img{
				width: 40%;
			}
			h6{
				font-size: 20px;
				color: #EE6E73;
			}
			.parallax { 
				/* The image used */
				background-image: url("images/money2.jpg");

				/* Set a specific height */
				height: 500px; 

				/* Create the parallax scrolling effect */
				background-attachment: fixed;
				background-position: center;
				background-repeat: no-repeat;
				background-size: cover;
			}
			.parallax2 { 
				/* The image used */
				background-image: url("images/money2.jpg");

				/* Set a specific height */
				height: 500px;

				/* Create the parallax scrolling effect */
				background-attachment: fixed;
				background-position: center;
				background-repeat: no-repeat;
				background-size: cover;
			}
			.section-white{
				height: 350px;
				background-color: #fff;
			}
			.div1, .div2, .div3{
				text-align: center;
				font-size: 100px;
			}
			.info{
				text-align: justify;
			}
			p{
				font-size: 15px;
				color: #616161;
			}
			footer {
				position: fixed;
				height: 100px;
				bottom: 0;
				width: 100%;
			}
			.navbar-black{
				background-color: #000000;
				color: #ffffff;
			}
            .alert{
                display: none;
                position: absolute;
                top:0;
                width: 30%;
                left: 50%;
                margin-left: -54px;
                z-index: 10000;
             }
		</style>
	</head>
	<body>
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<a class="navbar-brand" href="#">WeCash</a>
				</div>
				<ul class="nav navbar-nav navbar-right">
					<li><a id="cadastro" href="#">Cadastro</a></li>
					<li><a id="login" href="#">Login</a></li>
				</ul>
			</div><!-- /.container-fluid -->
		</nav>
		<div class="parallax"></div>
		<div id="section" class="section-white row">
			<div class="col-md-4 info">
				<div class="div1">
					<span class="glyphicon glyphicon-cog"></span>
					<h3>Fácil de usar</h3>
				</div>
				<p>
					Esse controlador de gastos, é simples, fácil e bonito. Para você, nosso usuário, poder controlar todos os seus gastos e ter noção de como sua conta está.
				</p>
			</div>
			<div class="col-md-4 info">
				<div class="div2">
					<i class="glyphicon glyphicon-credit-card"></i>
					<h3>Controle total sobre seu orçamento</h3>
				</div>
				<p>
					Disponibilizaremos gráficos, relatórios, extratos e algumas outras ferramentas para um acompanhamento completo de suas finanças.
				</p>
			</div>
			<div class="col-md-4 info">
				<div class="div3">
					<i class="glyphicon glyphicon-user"></i>
					<h3>Usuário tem todo o poder</h3>
				</div>
				<p>
				O usuário é quem faz tudo: adiciona contas, rendas e/ou despesas, podendo excluí-las e editá-las. Informa metas para o mês e/ou ano e assim avisaremos se está perto ou longe de conquistá-las, entre outras funções.
				</p>
			</div>
		</div>
		<div class="parallax2"></div>
		<footer class="navbar-black navbar-fixed-bottom">
			<div class="row">
				<div class="col-md-4">
					Arex - Matricula<br/>
					Lucas Dimatteu - Matricula<br/>
					Victor Arantes - Matricula<br/>
				</div>	
			</div>
		</footer>
		<!-- MODAL CADASTRO -->
		<div id="modalCadastro" class="modal fade" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Cadastro</h4>
					</div>
					<div class="modal-body">
						<form id="formCadastro" name="formCadastro" method="post" action="rest/control.php?action=cadastrarUsuario">
							<div class="form-group">
								<label for="nome_c">Nome Completo:</label>
								<input type="text" id="nome_c" name="nome_usuario" class="form-control" placeholder="Victor Arantes">
							</div>
							<div class="form-group">
								<label for="email_c">Email:</label>
								<input type="email" id="email_c" name="email_usuario" class="form-control" placeholder="exemplo@gmail.com">
							</div>
							<div class="form-group">
								<label for="senha_c">Senha:</label>
								<input type="password" id="senha_c" name="senha_usuario" maxlength="6" class="form-control">
							</div>
							<div class="form-group">
								<label for="cSenha">Confirmar senha:</label>
								<input type="password" id="cSenha" name="cSenha" maxlength="6" class="form-control">
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
						<button type="button" class="btn btn-primary" id="cadastrar">Cadastrar</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		<!-- MODAL LOGIN -->
		<div id="modalLogin" class="modal fade" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Login</h4>
					</div>
					<div class="modal-body">
						<form id="formLogin" name="formLogin" method="post" action="rest/control.php?action=login">
							<div class="form-group">
								<label for="email_c">Email:</label>
								<input type="email" id="email_c" name="email_usuario" class="form-control" placeholder="exemplo@gmail.com">
							</div>
							<div class="form-group">
								<label for="senha_c">Senha:</label>
								<input type="password" id="senha_c" name="senha_usuario" maxlength="6" class="form-control">
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" id="logar">Login</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
        <span class="alert alert-danger" role="alert">
                <span class="alert-txt">AA</span>
            </span>
	</body>
</html>
<script type="text/javascript" src="library/jquery/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="library/jquery-ui/js/jquery-ui-1.10.4.min.js"></script>
<script type="text/javascript" src="library/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){

    $("html, body").animate({
        scrollTop: $("#section").offset().top - $(".navbar-header").height()
    }, 5000);


	$("#cadastro").on("click", function(){
		$("#modalCadastro").modal();
	});

	$("#login").on("click", function(){
		$("#modalLogin").modal();
	});

	$("#cadastrar").on("click", function(){
//	    console.log("Enviando");
        if($("#nome_c").val() == ""){
            alert("Preencha seu nome");
            return false;
        }
        if($("#email_c").val() == ""){
            alert("Preencha seu email");
            return false;
        }
        if($("#senha_c").val() == ""){
            alert("Preencha sua senha");
            return false;
        }
        if($("#cSenha").val() != $("#senha_c").val()){
            alert("As senhas não são as mesmas");
            return false;
        }
		$("#formCadastro").submit();
	});

	$("#logar").on("click", function(){
		$("#formLogin").submit();
	});

	switch(<?=$alerta;?>){
        case 1:
            alert("Usuário não cadastrado");
            $(".alert-txt").html("Usuário não cadastrado");
//            $(".alert").css("display", "block");
            break;
        case 2:
            alert("Usuário cadastrado com sucesso");
            break;
        case 0:
            break;
    }

});
</script>