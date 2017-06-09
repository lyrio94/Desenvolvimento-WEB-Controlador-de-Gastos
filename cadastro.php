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
	      		<a href="#" class="brand-logo">
						WeCash
					</a>
	      		<ul id="nav-mobile" class="right hide-on-med-and-down">
	        			<li><a href="#modal1">Login</a></li>
	      		</ul>
	    		</div>
	  		</nav>
	  	</div>
		<div id="modal1" class="modal">
			<div class="modal-content">
				<h4>Login</h4>
				<div class="row">
					<form class="col s12" method="post">
						<div class="row">
							<div class="input-field col s12">
								<input id="email" type="email" class="validate">
								<label for="email" data-error="wrong" data-success="right">Email</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s12">
								<input id="password" type="password" class="validate">
								<label for="password">Password</label>
							</div>
						</div>
						<div class="row">
							<div class="col s12">
								<a href="#">Não tem uma conta? Sem problemas, cadastre-se aqui.</a>
							</div>
						</div>
						<button class="modal-action btn red lighten-1 waves-effect waves-light" type="submit" name="action">Login
    						<i class="material-icons right">send</i>
  						</button>
					</form>
				</div>
			</div>
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
	$('.modal').modal();

	$("#cadastrar").on("click", function(evt){
		if($("#nome_usuario").val() == ""){
			evt.preventDefault();
			return false;
		}
		if($("#email").val() == ""){
			evt.preventDefault();
			return false;
		}
		if($("#password").val() == ""){
			evt.preventDefault();
			return false;
		}
		$.post("rest/control.php",{"acao":"cadastrarUsuario", "nome_usuario":$("#nome_usuario").val(), "email_usuario":$("#email").val(), "senha_usuario":$("#password").val()});
	});



});
</script>