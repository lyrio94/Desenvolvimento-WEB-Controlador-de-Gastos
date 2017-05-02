<!doctype html>
<html>
	<head>
		<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="library/materialize/css/materialize.min.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<style type="text/css">
			img{
				width: 40%;
			}
			.responsive-text{
				vertical-align: middle;
			}
			h6{
				font-size: 20px;
				color: #EE6E73;
			}
			.parallax-container {
      		height: 500px;
    		}
		</style>
	</head>
	<body>
		<div class="navbar-fixed">
			<nav>
	    		<div class="nav-wrapper">
	      		<a href="#" class="brand-logo">Logo</a>
	      		<ul id="nav-mobile" class="right hide-on-med-and-down">
	        			<li><a href="#modal1">Login</a></li>
	      		</ul>
	    		</div>
	  		</nav>
	  	</div>
		<div id="modal1" class="modal" method="post" action="rest/control.php?action=login">
			<div class="modal-content">
				<h4>Modal Header</h4>
				<div class="row">
					<form class="col s12">
						<div class="row">
						<div class="input-field col s12">
							<input id="email" type="email" class="validate">
								<label for="email" data-error="wrong" data-success="right">Email</label>
						</div>
						<div class="row">
						<div class="input-field col s12">
							<input id="password" type="password" class="validate">
							<label for="password">Password</label>
						</div>
						</div>
						<div class="row">
						<div class="col s12">
							<a href="cadastro.php">Não tem uma conta? Sem problemas, cadastre-se aqui.</a>
						</div>
						</div>
					</form>
				</div>
  			</div>
			</div>
			<div class="modal-footer">
				<button class="modal-action modal-close btn red waves-effect waves-light" type="submit" name="action">Submit
    				<i class="material-icons right">send</i>
  				</button>
			</div>
		</div>
		<div class="parallax-container">
    		<div class="parallax"><img src="images/money2.jpg"></div>
  		</div>
  		<div class="section white">
    		<div class="row container">
      		<div class="col s4">
      			<i class="large material-icons">settings</i>
      			<h5>Fácil de usar</h5>
      			<p>
      				Esse controlador de gastos, é simples, fácil e bonito. Para você, nosso usuário, poder controlar todos os seus gastos e ter noção de como sua conta está.
      			</p>
		      </div>
		      <div class="col s4">
		      	<i class="large material-icons">credit_card</i>
		        	<h5>Controle total sobre seu orçamento</h5>
		        	<p>
		        		Disponibilizaremos gráficos, relatórios, extratos e algumas outras ferramentas para um acompanhamento completo de suas finanças.
		        	</p>
		      </div>
		      <div class="col s4">
		      	<i class="material-icons large">person_pin</i>
		        	<h5 class="center-align">Usuário tem todo o poder</h5>
		        	<p>
		        		O usuário é quem faz tudo: adiciona contas, rendas e/ou despesas, podendo excluí-las e editá-las. Informa metas para o mês e/ou ano e assim avisaremos se está perto ou longe de conquistá-las, entre outras funções.
		        	</p>
		     	</div>
    		</div>
  		</div>
  		<div class="parallax-container">
    		<div class="parallax"><img src="images/money4.jpg"></div>
  		</div>
  		<footer class="page-footer">
         <div>
         	<div class="row container">
            	<div class="col s6">
               	<img src="images/responsive.png">
              	</div>
              	<div class="col s6">
                	<ul>
                  	<li><a class="grey-text text-lighten-3" href="#!">UniCeub</a></li>
                  	<li><a class="grey-text text-lighten-3" href="#!">Alunos:</a></li>
                  	<li><a class="grey-text text-lighten-3" href="#!"> - Lucas Dimatteu - 00000000</a></li>
                  	<li><a class="grey-text text-lighten-3" href="#!"> - Victor Arantes - 00000000</a></li>
                	</ul>
              	</div>
            </div>
         </div>
         <div class="footer-copyright">
            <div class="container">
            	© 2017 Copyright
         	</div>
         </div>
      </footer>
	</body>
</html>
<script type="text/javascript" src="library/jquery/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="library/materialize/js/materialize.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('.parallax').parallax();
	$('.modal').modal();

	$("form").submit(function(evt){
		if($("#email").val().length == 0 ){
			evt.preventDefault();
			return false;
		}
		if($("#senha").val().length == 0){
			evt.preventDefault();
			return false;
		}
	});

});
</script>