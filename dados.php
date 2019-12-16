<?php

// Geting Sis Func Class
require("sis/sis.php");

 $reclame = 'active';

// CLASSES
  $query = new Connect();
  $var = new ValidarVariavel();

  $acao = $var->get('acao', 'string');

  if($id){
      
      $id = $var->get('id', 'int');

      $query = $query->open();
      $busca_query = $query->prepare("SELECT * FROM instituicao_ins WHERE ins_id = :id");
      $busca_query->bindValue(':id', $id);
      $valid = $busca_query->execute();
      $dados = $busca_query->fetch(PDO::FETCH_ASSOC);    
      // new sis_debug($dados);  
      
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

      <div class="panel panel-primary">
          <div class="panel-heading">
              <h3 class="panel-title"></h3>
          </div>
          <div class="panel-body">
              <div  class="col-sm-12 col-md-12 " >                
                  <div class="page-header">
                    <h1><?php echo  $dados['ins_nome'] ?></h1>
                  </div>
                  <div class="well">
                      <?php 

                        if($coments){

                        }
                        else{
                            echo  "<p>Ainda não existem comentários sobre a instituição</p>";
                        }

                       ?>
                  </div>
                  <div class=" panel panel-info col-sm-3 col-md-3" >
                      <div>
                        <h2>2014</h2>
                      </div>
                      <div id="canvas-holder">
                        <canvas id="chart-area" width="500" height="500"/>
                      </div>
                  </div>
                  <div class=" panel panel-info col-sm-3 col-md-3" >
                      <div>
                        <h2>2015</h2>
                      </div>
                      <div id="canvas-holder">
                        <canvas id="chart-area2" width="500" height="500"/>
                      </div>
                  </div>                  
              </div>
              <script>
                var doughnutData = [
                    {
                      value: 300,
                      color:"#F55",
                      highlight: "#FF5A5E",
                      label: "Ruim"
                    },
                    {
                      value: 50,
                      color: "#973CB6",
                      highlight: "#5AD3D1",
                      label: "Medio"
                    },
                    {
                      value: 100,
                      color: "#5EC64D",
                      highlight: "#FFC870",
                      label: "Bom"
                    },
                    {
                      value: 40,
                      color: "#29AAE2",
                      highlight: "#A8B3C5",
                      label: "Exelente"
                    }

                  ];

                  var doughnutData2 = [
                    {
                      value: 100,
                      color:"#F55",
                      highlight: "#FF5A5E",
                      label: "Ruim"
                    },
                    {
                      value: 50,
                      color: "#973CB6",
                      highlight: "#5AD3D1",
                      label: "Medio"
                    },
                    {
                      value: 50,
                      color: "#5EC64D",
                      highlight: "#FFC870",
                      label: "Bom"
                    },
                    {
                      value: 300,
                      color: "#29AAE2",
                      highlight: "#A8B3C5",
                      label: "Exelente"
                    }

                  ];

                  window.onload = function(){
                    var ctx = document.getElementById("chart-area").getContext("2d");
                    window.myDoughnut = new Chart(ctx).Doughnut(doughnutData, {responsive : true});

                    var ctx = document.getElementById("chart-area2").getContext("2d");
                    window.myDoughnut = new Chart(ctx).Doughnut(doughnutData2, {responsive : true});
                  };
              </script>
          </div>
          <div class="page-header">
            <h1>Resenhas </h1>
          </div>
          <h3>Thiago Rodrigues Melo </h3>
          <div class="well">
              Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit eveniet mollitia culpa sint quam, eaque labore earum ut tenetur consequuntur illo totam blanditiis, laborum! Maxime, dolorem eaque facilis officia nostrum!
          </div>
          <h3>Luiz Slva </h3>          
          <div class="well">
              Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit eveniet mollitia culpa sint quam, eaque labore earum ut tenetur consequuntur illo totam blanditiis, laborum! Maxime, dolorem eaque facilis officia nostrum!
          </div>
          <h3>Leandro Rodigues </h3>          
          <div class="well">
              Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit eveniet mollitia culpa sint quam, eaque labore earum ut tenetur consequuntur illo totam blanditiis, laborum! Maxime, dolorem eaque facilis officia nostrum!
          </div>
      </div>
                    

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
