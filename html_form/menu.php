	<!-- Fixed navbar -->
	<div class="well">
	<div class="navbar navbar-inverse">
		<div class="container">
			<div class="navbar-header">
				<!-- Button for smallest screens -->
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
				
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav pull-right mainNav">
						<li class="c2 <?php echo $inicio ?> "><a href="index.php">Inicio</a></li>
                    	<li class="c5 <?php echo $cadastro ?>"><a href="cadastro.php">Cadastro</a></li>
						<li class="c1 <?php echo $reclame ?>"><a  href="reclame.php">Reclame</a></li>
						<li class="c3 <?php echo $avalie ?>"><a  href="avalie.php">Avalie</a></li>
					</ul>
				</div>
			<!--/.nav-collapse -->
			</div>
	                <div class='collapse navbar-collapse' id='bs-example-navbar-collapse-1'>	                    
	                    <form  class='navbar-form navbar-right' action='' method='post'>
	                        <div class='form-group'>
	                          <input type='text' name='login' placeholder='Usuário' class='form-control'>
	                        </div>
	                        <div class='form-group'>
	                          <input type='password' name='pass' placeholder='Senha' class='form-control'>
	                        </div>
	                        <button type='submit' name='acao' value='login' class='btn btn-success'>Entrar</button>
	                    </form>
	                </div>
		</div>
	<!-- /.navbar -->

	<!-- Logo Buscas -->
	<div class="container container-busca">
	    <div class="col-md-4 container-logo visible-xxss-block">
	       <a href="index.php"> <img src="img/logo.png" alt=""></a>
	    </div>
	    <div class="col-md-8 container-busca">
	          <form action="busca.php" method="get" class="navbar-form" role="search">
	            <div class="form-group">
          			<input type="text" name="consulta" placeholder="Buscar Instituições" class="form-control" style="width:500px" >
        		</div>
        		<button type='submit' name='acao' value='buscar' class="btn btn-success visible-xxs-block">Buscar</button>
	            
	         </form>
	    </div>
	  </div>

  <!-- /Logo Buscas -->
</div>