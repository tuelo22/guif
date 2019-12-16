<?php

// Geting Sis Func Class
require("sis/sis.php");
$inicio = 'active';

  $query = new Connect();
  $var = new ValidarVariavel();

  $query = $query->open();
  $busca_query = $query->prepare("SELECT cid_nome, cid_id, cid_est FROM cidade_cid");    
  $busca_query->bindValue(1, "%$consulta%", PDO::PARAM_STR);
  $valid = $busca_query->execute();
  $cidade = $busca_query->fetchAll(PDO::FETCH_ASSOC);    
  
?>
<!DOCTYPE html>
<html lang="en">

<style>
	html{
		background: white;
	}
</style>
<?php require 'html_form/header.php'; ?>
<head>
	<meta charset="UTF-8">
	<title></title>
</head>
<body>
	<div class="container">
	<form class="form-horizontal">
	<fieldset>

	<!-- Form Name -->
	<legend>Cadastrar Instituição </legend>

	<!-- Text input-->
	<div class="form-group">
	  <label class="col-md-4 control-label" for="nome_instituicao">Instituição</label>  
	  <div class="col-md-4">
	  <input id="nome_instituicao" name="nome_instituicao" placeholder="Instituição" class="form-control input-md" required="" type="text">
	    
	  </div>
	</div>

	<!-- Text input-->
	<div class="form-group">
	  <label class="col-md-4 control-label" for="instituicao_cidade">Cidade</label>  
	  <div class="col-md-4">
	  <input id="instituicao_cidade" name="instituicao_cidade" placeholder="Cidade Instituição" class="form-control input-md" required="" type="text">
	    
	  </div>
	</div>

	<!-- Text input-->
	<div class="form-group">
	  <label class="col-md-4 control-label" for="instituicao_complemento">Complemento</label>  
	  <div class="col-md-4">
	  <input id="instituicao_complemento" name="instituicao_complemento" placeholder="Complemento endereço instituição" class="form-control input-md" required="" type="text">
	    
	  </div>
	</div>

	<!-- Text input-->
	<div class="form-group">
	  <label class="col-md-4 control-label" for="instituicao_numero">Numero</label>  
	  <div class="col-md-4">
	  <input id="instituicao_numero" name="instituicao_numero" placeholder="Numero" class="form-control input-md" required="" type="text">
	    
	  </div>
	</div>

	<!-- Select Basic -->
	<div class="form-group">
	  <label class="col-md-4 control-label" for="id_tipo_instituicao">Tipo de Instituição</label>
	  <div class="col-md-4">
	    <select id="id_tipo_instituicao" name="id_tipo_instituicao" class="form-control">
	      <option value="0">Selecione</option>
	    </select>
	  </div>
	</div>

	<!-- Button -->
	<div class="form-group">
	  <label class="col-md-4 control-label" for="salvar"></label>
	  <div class="col-md-4">
	    <button id="salvar" name="salvar" class="btn btn-success">Salvar</button>
	  </div>
	</div>

	</fieldset>
	</form>


	</div>
</body>
</html>