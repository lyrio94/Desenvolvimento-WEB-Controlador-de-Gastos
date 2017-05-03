<div class='container'>
	<form id="formRenda" name="formRenda" method="post" action="rest/control.php?action=addRenda">
      <input type='hidden' name='usuario' value='1'>
		<div class="form-title">Cadastre sua renda</div>
		<div class="campos">
			<label class="lblNome" for="nm_renda">Nome:</label>
			<input type='text' class="mdl-textfield mdl-js-textfield" id='nm_renda' name='nm_renda' value="" autofocus />
		</div>
		<div class="campos">
			<label class="lblValor" for="vl_renda">Valor:</label>
			<input type='text' class="mdl-textfield mdl-js-textfield" id='dinheiro' name='vl_renda' value="" maxlength="7" />
		</div>
		<div class="campos">
			<label class="lblData" for="dt_renda">Data:</label>
			<input type='text' class='mdl-textfield mdl-js-textfield' id='data' name='dt_renda' maxlength='10' maxlength="10" />
		</div>
		<div class="button">
		   <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Cadastrar</button>
		</div>
   </form>
</div>