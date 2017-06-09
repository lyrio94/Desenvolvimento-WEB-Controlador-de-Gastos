//Funções de máscara para os campos DATA, CPF, CNPJ, CEP E FINANCEIRO, TELEFONE E FINANCEIRO, CELULAR, VALORES

	function mascaraData(data){
		var strData = "";
		strData = strData + data;

		if(strData.length == 2){
			strData = strData + "/";
			document.forms[0].data.value = strData;
		}
		if(strData.length == 5){
			strData = strData + "/";
			document.forms[0].data.value = strData;
		}
	};

	function mascaraCpf(cpf){
		var strCpf = "";
		strCpf = strCpf + cpf;

		if(strCpf.length == 3){
			strCpf = strCpf + ".";
			document.forms[0].cpf.value = strCpf;
		}
		if(strCpf.length == 7){
			strCpf = strCpf + ".";
			document.forms[0].cpf.value = strCpf;
		}
		if(strCpf.length == 11){
			strCpf = strCpf + "-";
			document.forms[0].cpf.value = strCpf;
		}
	};

	function mascaraCnpj(cnpj){
		var strCnpj = "";
		strCnpj = strCnpj + cnpj;

		if(strCnpj.length == 2){
			strCnpj = strCnpj + ".";
			document.forms[0].cnpj.value = strCnpj;
		}
		if(strCnpj.length == 6){
			strCnpj = strCnpj + ".";
			document.forms[0].cnpj.value = strCnpj;
		}
		if(strCnpj.length == 9){
			strCnpj = strCnpj + "/";
			document.forms[0].cnpj.value = strCnpj;
		}
		if(strCnpj.length == 14){
			strCnpj = strCnpj + "-";
			document.forms[0].cnpj.value = strCnpj;
		}
	};

	function mascaraCep(cep){
		var strcep = "";
		strcep = strcep + cep;

		if(strcep.length == 5){
			strcep = strcep + "-";
			document.forms[0].cep.value = strcep;
		}
	};

	function mascaraCep_Finan(cep_finan){
		var strCep_finan = "";
		strCep_finan = strCep_finan + cep_finan;

		if(strCep_finan.length == 5){
			strCep_finan = strCep_finan + "-";
			document.forms[0].cep_finan.value = strCep_finan;
		}
	};

	function mascaraTelefone(telefone){
		
		var strTel = "";
		strTel = strTel + telefone;

		if(strTel.length == 2){
			strTel = "(" + strTel + ")";
			document.forms[0].telefone.value = strTel;
		}
		if(strTel.length == 8){
			strTel = strTel + "-";
			document.forms[0].telefone.value = strTel;
		}
		if(strTel.length == 13){
			strTel =  strTel + " " + "/" + " " +"(";
			document.forms[0].telefone.value = strTel;
		}
		if(strTel.length == 19){
			strTel = strTel + ")";
			document.forms[0].telefone.value = strTel;
		}
		if(strTel.length == 24){
			strTel = strTel + "-";
			document.forms[0].telefone.value = strTel;
		}
	};

	function mascaraTel_Finan(telefone_finan){

		var strTel_finan = "";
		strTel_finan = strTel_finan + telefone_finan;

		if(strTel_finan.length == 2){
			strTel_finan = "(" + strTel_finan + ")";
			document.forms[0].telefone_finan.value = strTel_finan;
		}
		if(strTel_finan.length == 8){
			strTel_finan = strTel_finan + "-";
			document.forms[0].telefone_finan.value = strTel_finan;
		}
		if(strTel_finan.length == 13){
			strTel_finan = strTel_finan + " " + "/" + " " + "(";
			document.forms[0].telefone_finan.value = strTel_finan;
		}
		if(strTel_finan.length == 19){
			strTel_finan = strTel_finan + ")";
			document.forms[0].telefone_finan.value = strTel_finan;
		}
		if(strTel_finan.length == 24){
			strTel_finan = strTel_finan + "-";
			document.forms[0].telefone_finan.value = strTel_finan;
		}
	};

	function mascaraCelular(celular){

		var strCelular = "";
		strCelular = strCelular + celular;

		if(strCelular.length == 2){
			strCelular = "(" + strCelular + ")";
			document.forms[0].celular.value = strCelular;
		}
		if(strCelular.length == 8){
			strCelular = strCelular + "-";
			document.forms[0].celular.value = strCelular;
		}
	};

	function mascaraDinheiro(dinheiro){

		var strDinheiro = "";
		strDinheiro = strDinheiro + dinheiro;

		if(strDinheiro.length == 4){
			strDinheiro = strDinheiro + ",";
			document.forms[0].dinheiro.value = strDinheiro;
		}

	};