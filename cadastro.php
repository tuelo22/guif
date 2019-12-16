<?php

// Geting Sis Func Class
require("sis/sis.php");

 $cadastro = 'active';


// CLASSES
  $query = new Connect();
  $var = new ValidarVariavel();

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
     <br>
     <form method="post" class="form-horizontal">
        <div class="col-md-12">
          
        <?php echo $html_notification ?>
        </div>
        <div class='clearfix'></div>
        <fieldset>
        <!-- Text input-->
        <div class = "well">
		
        <!-- Form Name -->
        <legend><h1>Cadastro</h1></legend>
        <div class="form-group">
          <label class="col-md-4 control-label" for="nome">Nome</label>  
          <div class="col-md-4">
          <input id="nome" name="nome" placeholder="Nome" class="form-control input-md" required="" type="text">
          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="sobrenome">Sobrenome</label>  
          <div class="col-md-4">
          <input id="sobrenome" name="sobrenome" placeholder="Sobrenome" class="form-control input-md" required="" type="text">
          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="email">Email</label>  
          <div class="col-md-4">
          <input id="email" name="email" placeholder="Email" class="form-control input-md" required="" type="email">
          </div>
        </div>

        <!-- Password input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="pass">Senha</label>
          <div class="col-md-4">
            <input id="pass" name="pass" placeholder="Senha" class="form-control input-md" required="" type="password">
          </div>
        </div>

        <!-- Password input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="pass2">Repita a senha</label>
          <div class="col-md-4">
            <input id="pass2" name="pass2" placeholder="Repita Senha " class="form-control input-md" required="" type="password">
          </div>
        </div>

        <!-- Multiple Radios (inline) -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="sexo">Sexo</label>
          <div class="col-md-4"> 
            <label class="radio-inline" for="sexo-0">
              <input name="sexo" id="sexo-0" value="m" checked="checked" type="radio">
              Masculino
            </label> 
            <label class="radio-inline" for="sexo-1">
              <input name="sexo" id="sexo-1" value="f" type="radio">
              Feminino
            </label>
          </div>
        </div>      

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="cpf">CPF</label>  
          <div class="col-md-4">
          <input id="cpf" name="cpf" placeholder="CPF" class="form-control input-md" required="" type="text">
          </div>
        </div>

        <!-- Select Basic -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="id_cidade">Cidade</label>
          <div class="col-md-4">
            <select id="id_cidade" name="id_cidade" class="form-control">
            <option value="1">RJ</option>
            <option value="2">SP</option>
            <option value="3">ES</option>
            <option value="4">PB</option>
            </select>
          </div>
        </div>

        <!-- Button (Double) -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="salvar">Salvar</label>
          <div class="col-md-8">
            <button id="salvar" type="submit" name="acao" value="Salvar" class="btn btn-success">Salvar</button>
            <button id="cancelar" type="reset" name="cancelar" class="btn btn-danger">Cancelar </button>
          </div>
        </div>
        </fieldset>
        </form>       
  </div>
  </div>
 
  <!-- Footer -->
  <?php require("html_form/footer.php") ?>
  <!-- /footer -->
  <!-- SCRIPT -->
  <?php require("html_form/footer_scripts.php") ?>
  <!-- /SCRIPT -->



</body>
</html>
