<?php

// Geting Sis Func Class
require("sis/sis.php");
$inicio = 'active';
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
<form class="form-horizontal">
<fieldset>

<!-- Form Name -->
<legend>Cadastar Curso</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="nome_curso">Nome do Curso</label>  
  <div class="col-md-4">
  <input id="nome_curso" name="nome_curso" placeholder="Diga o nome do Curso" class="form-control input-md" required="" type="text">
    
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="acao"></label>
  <div class="col-md-4">
    <button id="acao" name="acao" class="btn btn-primary">Salvar</button>
  </div>
</div>

</fieldset>
</form>



	</div>
</body>
</html>