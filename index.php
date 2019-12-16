<?php

// Geting Sis Func Class
require("sis/sis.php");
$inicio = 'active';

  $query = new Connect();
  $var = new ValidarVariavel();
   
  $query = $query->open();
  $busca_query = $query->query(" select ava_idinstituicao, 
                                             count(*) qtd, 
                                                 ins_nome, 
												 cid_nome, 
											   e.est_nome 
	                               from avaliacao_ava inner join instituicao_ins on ava_idinstituicao = ins_id 
								                      inner join cidade_cid c on ins_idcidade = c.cid_id  
													  inner join estado_est e on c.est_id = e.est_id   
		                          where ava_qualificacao = 1 group by ava_idinstituicao order by count(*) desc");      
												  
  $ruim = $busca_query->fetch(PDO::FETCH_ASSOC);      
  unset($busca_query);
     
   $busca_query = $query->query(" select ava_idinstituicao, 
                                             count(*) qtd, 
                                                 ins_nome, 
												 cid_nome, 
											   e.est_nome 
	                               from avaliacao_ava inner join instituicao_ins on ava_idinstituicao = ins_id 
								                      inner join cidade_cid c on ins_idcidade = c.cid_id  
													  inner join estado_est e on c.est_id = e.est_id   
		                          where ava_qualificacao = 3 group by ava_idinstituicao order by count(*) desc");      
												  
  $medio = $busca_query->fetch(PDO::FETCH_ASSOC);      
  unset($busca_query);
  
   

  $busca_query = $query->query(" select ava_idinstituicao, 
                                             count(*) qtd, 
                                                 ins_nome, 
												 cid_nome, 
											   e.est_nome 
	                               from avaliacao_ava inner join instituicao_ins on ava_idinstituicao = ins_id 
								                      inner join cidade_cid c on ins_idcidade = c.cid_id  
													  inner join estado_est e on c.est_id = e.est_id   
		                          where ava_qualificacao = 4 group by ava_idinstituicao order by count(*) desc");      
												  
  $bom = $busca_query->fetch(PDO::FETCH_ASSOC);      
  unset($busca_query);
  
   
 
  $busca_query = $query->query(" select ava_idinstituicao, 
                                             count(*) qtd, 
                                                 ins_nome, 
												 cid_nome, 
											   e.est_nome 
	                               from avaliacao_ava inner join instituicao_ins on ava_idinstituicao = ins_id 
								                      inner join cidade_cid c on ins_idcidade = c.cid_id  
													  inner join estado_est e on c.est_id = e.est_id   
		                          where ava_qualificacao = 5 group by ava_idinstituicao order by count(*) desc");      
												  
  $exelente = $busca_query->fetch(PDO::FETCH_ASSOC);      
  unset($busca_query);
  

  

?>
<!DOCTYPE html>
<html lang="en">
  <?php require 'html_form/header.php'; ?>
<body>
	<!-- Fixed navbar -->
  <?php require("html_form/menu.php"); ?>
	<!-- /.navbar -->

  <div class="container">
    <div class="row">
					<div class="col-md-3">
						<div class="grey-box-icon b1"> 
							<h4>Pessimo</h4>
							<img src="img/ruim.png" alt="">
							<p><?php echo $ruim["ins_nome"]; ?></p>
                            <p><?php echo $ruim["cid_nome"]; 
                					 echo " - "; 
							         echo $ruim["est_nome"];?></p>
						</div><!--grey box -->
					</div><!--/span3-->
					<div class="col-md-3">
						<div class="grey-box-icon b2"> 
							<h4>Medio</h4>
							<img src="img/medio.png" alt="">
							<p><?php echo $medio["ins_nome"]; ?></p>
                            <p><?php echo $medio["cid_nome"]; 
                					 echo " - "; 
							         echo $medio["est_nome"];?></p>
						</div><!--grey box -->
					</div><!--/span3-->
					<div class="col-md-3">
						<div class="grey-box-icon b3"> 
							<h4>Bom</h4>
							<img src="img/bom.png" alt="">
							<p><?php echo $bom["ins_nome"]; ?></p>
                            <p><?php echo $bom["cid_nome"]; 
                					 echo " - "; 
							         echo $bom["est_nome"];?></p>
						</div><!--grey box -->
					</div><!--/span3-->
					<div class="col-md-3">
						<div class="grey-box-icon b4">  
							<h4>Excelente</h4>
							<img src="img/exelente.png" alt="">
							<p><?php echo $exelente["ins_nome"]; ?></p>
                            <p><?php echo $exelente["cid_nome"]; 
                					 echo " - "; 
							         echo $exelente["est_nome"];?></p>
						</div><!--grey box -->
					</div><!--/span3-->
				</div>
    </div>  
	<hr>
      <section class="container">
      <div class="row">
      	<div class="col-md-12" style="text-align: justify">
      	<h1 class="title-box_primary">Sobre nós</h1> 
         <p>A Guif tem como objetivo ser um centro de consulta de intuições, podendo ser classificada um termômetro da qualidade do ensino sobre a visão dos estudantes aos quais as instituições prestam serviços.</p>
         <p>Hoje o único órgão que realiza o controle da qualidade do ensino brasileiro é o MEC, que estipula algumas metas mínimas para a qualidade de uma instituição, o que não inclui a parte administrativa.</p>
         <p>Acreditamos que a visão do MEC não abrange as reais necessidades do aluno, em termos de atendimento, infra estrutura e na qualidade em si dos professores.</p>    

      </div>
      </section>      
    	 
  <!-- Footer -->
  <?php require("html_form/footer.php") ?>
  <!-- /footer -->
  <!-- SCRIPT -->
  <?php require("html_form/footer_scripts.php") ?>
  <!-- /SCRIPT -->
    
</body>
</html>
