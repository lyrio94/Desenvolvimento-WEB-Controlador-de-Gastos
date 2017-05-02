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
	      		<a href="#" class="brand-logo">WeCash</a>
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
							<a href="#">Não tem uma conta? Sem problemas, cadastre-se aqui.</a>
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
					</form>
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
					<li><a class="grey-text text-lighten-3" href="#!"> - Alexandre Lyrio - 00000000</a></li>
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