<?php

// Geting Sis Func Class
require("sis/sis.php");

 $avalie = 'active';

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
<legend><h1>Avaliacao</h1></legend>

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

<!-- Multiple Radios -->
<div class="form-group">
  <label class="col-md-4 control-label" for="avaliacao">Avaliação</label>
  <div class="col-md-4">
  <div class="radio">
    <label for="avaliacao-0">
      <input name="avaliacao" id="avaliacao-0" value="5" type="radio">
      Exelente
    </label>
  </div>
  <div class="radio">
    <label for="avaliacao-1">
      <input name="avaliacao" id="avaliacao-1" value="4" type="radio">
      Bom
    </label>
  </div>
  <div class="radio">
    <label for="avaliacao-2">
      <input  checked="checked" name="avaliacao" id="avaliacao-3" value="3" type="radio">
      Médio 
    </label>
  </div>
  <div class="radio">
    <label for="avaliacao-3">
      <input name="avaliacao" id="avaliacao-3" value="2" type="radio">
      Ruim
    </label>
  </div>
  <div class="radio">
    <label for="avaliacao-4">
      <input name="avaliacao" id="avaliacao-4" value="1" type="radio">
      Péssimo
    </label>
  </div>
  </div>
</div>

<!-- Multiple Radios -->
<div class="form-group">
  <label class="col-md-4 control-label" for="frutos">Frutos</label>
  <div class="col-md-4">
  <div class="radio">
    <label for="frutos-0">
      <input name="frutos" id="frutos-0" value="s" checked="checked" type="radio">
      Sim
    </label>
  </div>
  <div class="radio">
    <label for="frutos-1">
      <input name="frutos" id="frutos-1" value="n" type="radio">
      Não
    </label>
  </div>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="textarea">Avaliação</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="textarea" name="textarea"></textarea>
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
