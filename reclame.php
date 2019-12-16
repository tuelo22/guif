<?php

// Geting Sis Func Class
require("sis/sis.php");

 $reclame = 'active';

// CLASSES
  $query = new Connect();
  $var = new ValidarVariavel();

  $query = $query->open();
  $busca_query = $query->prepare("SELECT ins_id, ins_nome FROM instituicao_ins where ins_ativo = 1");    
  $busca_query->bindValue(1, "%$consulta%", PDO::PARAM_STR);
  $valid = $busca_query->execute();
  $instituicao = $busca_query->fetchAll(PDO::FETCH_ASSOC);          
  
  $busca_query = $query->prepare("SELECT cur_idcurso, cur_nome FROM curso_cur");    
  $busca_query->bindValue(1, "%$consulta%", PDO::PARAM_STR);
  $valid = $busca_query->execute();
  $curso = $busca_query->fetchAll(PDO::FETCH_ASSOC);   
  
  $busca_query = $query->prepare("SELECT cur_idcurso, cur_nome FROM curso_cur");    
  $busca_query->bindValue(1, "%$consulta%", PDO::PARAM_STR);
  $valid = $busca_query->execute();
  $cidade = $busca_query->fetchAll(PDO::FETCH_ASSOC);   
  
  $acao = $var->get('acao', 'string');

  if($acao == 'Salvar'){


      $nome = $var->get('nome', 'string');
      $sobrenome = $var->get('sobrenome', 'string');
      $email = $var->get('email', 'string');
      $pass = $var->get('pass', 'string');
      $pass2 = $var->get('pass2', 'string');
      $sexo = $var->get('sexo', 'string');      
      $cpf = $var->get('cpf', 'string');
      $id_cidade = $var->get('id_cidade', 'int');
      $query = $query->open();

      $cadastro = $query-> prepare("INSERT INTO  usuario_uso  (uso_nome,  uso_sobrenome,  uso_senha, uso_email, uso_idcidade,  uso_sexo, uso_cpf, uso_idperfil) VALUES (:uso_nome,  :uso_sobrenome,  :uso_senha, :uso_email, :uso_idcidade,  :uso_sexo, :uso_cpf, :uso_idperfil) ");
      $cadastro->bindValue(':uso_nome', $nome);
      $cadastro->bindValue(':uso_sobrenome', $sobrenome);
      $cadastro->bindValue(':uso_senha', $pass);
      $cadastro->bindValue(':uso_email', $email);
      $cadastro->bindValue(':uso_idcidade', $id_cidade);
      $cadastro->bindValue(':uso_sexo', $sexo);
      $cadastro->bindValue(':uso_cpf', $cpf);
      $cadastro->bindValue(':uso_idperfil', '');
      $valid = $cadastro->execute();

      if($valid){
        $html_notification = $str->showAlert('cadastro_user_ok');
      }  
        // new SIS_debug($valid, 'valid');

}



?>
<!DOCTYPE html>
<html lang="en">
<?php require 'html_form/header.php'; ?>
<body>
  <!-- Fixed navbar -->
  <?php require("html_form/menu.php"); ?>
  <!-- /.navbar -->
  <div class="container">
     <br>
      <?php echo $html_notification ?>
     <br>

  <form class="form-horizontal">
<fieldset>
<div class= "well">
<!-- Form Name -->
<legend><h1>Avaliação</h1></legend>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="instituicao">Instiuição</label>
  <div class="col-md-4">
    <select id="instituicao" name="instituicao" class="form-control">
      <option value="0">Selecione</option>
      <?php  
	   foreach ($instituicao as $linha => $dados_coluna) 
	   {
	     echo "
         <option value='{$dados_coluna['ins_id']}'>{$dados_coluna['ins_nome']}</option>";
	   }
	  ?>	  
    </select>
  </div>
    <div class="col-md-4">
    <a class="fancybox fancybox.iframe" href="adicionar_instituicao.php"><button id="" name="" class="btn btn-primary " >Adicionar Instituição</button></a>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="curso">Curso</label>
  <div class="col-md-4">
    <select id="curso" name="curso" class="form-control">
      <option value="0">Selecione</option>
	  <?php  
	   foreach ($curso as $linha => $dados_coluna) 
	   {
	     echo "
         <option value='{$dados_coluna['cur_idcurso']}'>{$dados_coluna['cur_nome']}</option>";
	   }
	  ?>	
    </select>
  </div>  
    <div class="col-md-4">
    <a class="fancybox fancybox.iframe" href="adicionar_curso.php"><button id="" name="" class="btn btn-primary " >Adicionar Curso</button></a>

  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="textarea">Reclamação</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="textarea" name="textarea">Descreva sua reclamação com 1000 caracteres.</textarea>
  </div>
</div>

<!-- Button (Double) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="cadastrar"></label>
  <div class="col-md-8">
    <button id="cadastrar" name="cadastrar" class="btn btn-success">Cadastrar</button>
    <button id="cancelar" name="cancelar" class="btn btn-danger">Cancelar</button>
  </div>
</div>

</fieldset>
</form>
  </div>
 
  <!-- Footer -->
  <?php require("html_form/footer.php") ?>
  <!-- /footer -->
  <!-- SCRIPT -->
  <?php require("html_form/footer_scripts.php") ?>
  <!-- /SCRIPT -->



</body>
</html>
