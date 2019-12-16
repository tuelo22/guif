<?php

// Geting Sis Func Class
require("sis/sis.php");

 $reclame = 'active';

// CLASSES
  $query = new Connect();
  $var = new ValidarVariavel();

  $acao = $var->get('acao', 'string');

  if($acao == 'buscar'){

      $consulta = $var->get('consulta', 'string');

      $query = $query->open();
      $busca_query = $query->prepare("SELECT * FROM instituicao_ins WHERE ins_nome LIKE ? ");
      $busca_query->bindValue(1, "%$consulta%", PDO::PARAM_STR);
      $valid = $busca_query->execute();
      $row = $busca_query->fetchAll(PDO::FETCH_ASSOC);      
      
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

<div class="col-sm-12 col-md-12 ">

<?php 

if($row){
    $cont = 0;
    foreach ($row as $linha => $dados_coluna) {
        // new sis_debug($dados_coluna);
        $cont ++;      
      // SELECT count(ava_qualificacao) FROM `avaliacao_ava` WHERE ava_idinstituicao = 1
        $busca_query = $query->prepare("SELECT count(ava_qualificacao) as total FROM `avaliacao_ava` WHERE ava_idinstituicao =  :id ");
        $busca_query->bindValue(':id', $dados_coluna['ins_id']);
        $valid = $busca_query->execute();
        $total = $busca_query->fetch(PDO::FETCH_ASSOC);  
        $total = $total['total'] *4 ;
        // new sis_debug($total);
        $busca_query = $query->prepare("SELECT SUM(ava_qualificacao) as bom FROM `avaliacao_ava` WHERE ava_idinstituicao =  :id");
        $busca_query->bindValue(':id', $dados_coluna['ins_id']);
        $valid = $busca_query->execute();
        $bom = $busca_query->fetch(PDO::FETCH_ASSOC);  
        $bom = $bom['bom'];
        // new sis_debug($bom);
        $media = 100*($bom/$total);
        if($media >= 80){
          $color = 'progress-bar-success';
          $grau = "Esta é exelente Universiade ";
        }
        elseif($media >= 50){
          $color = 'progress-bar-warning';
          $grau = " Acho melhor você pensar bem!";
        }
        elseif($media <= 30){
          $color = 'progress-bar-danger';
          $grau = "Não recomendo esta Universiade";
        }
        elseif($media <= 5){
          $color = 'progress-bar-danger';
          $grau = "Ainda não temos dados :z";
        }


        // new sis_debug($media);
        echo "
        <div class='col-sm-6 col-md-4'>
              <div class='thumbnail'>      
                <div class='caption'>
                  <h3>{$dados_coluna['ins_nome']}</h3>
                  <h4>{$dados_coluna['cidade']}</h4>
                  <h4>{$dados_coluna['uf']}</h4>
                  <hr>
                  <p>{$grau}</p>
                  <div class='progress'>
                    <div class='progress-bar {$color}' role='progressbar' aria-valuenow='20' aria-valuemin='0' aria-valuemax='100' style='width: $media%'>
                      <span class='sr-only'>20% Complete</span>
                    </div>
                  </div>
                  <p>
                    <a href='dados.php?id={$dados_coluna['ins_id']}' class='btn btn-primary' role='button'>Saiba mais!</a>
                  </p>
                </div>
              </div>
            </div>
          ";

if($cont == 3){
  $cont = 0; 
  echo "<div class='clearfix'></div>";
}



    }
}
else{
  echo "não encontrado";
}


?>


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
