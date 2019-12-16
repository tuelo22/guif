<?php

/**  
* ESTA CLASSE TEM FUNÇÃO DE GERENCIAR TODOS OS DADOS RELACIONADOS AO USUARIO, COMO:
* lOGIN, lOGOUT, ALTERA USUARIO, CADASTRAR USUARIO, ALTERA SENHA, ETCC. 
* @author Thiago Rodrigues 
* @version 1.0;
* @package Connect;
* @category Usuario;
*/
class Usuario extends Connect
{
	/**
	 * @var object $sonn Objeto de conexão com o banco de dados;
	 * @var string $iv usado Usado para gerar a senha a ser salva no banco de dados;
	 * @var string $iv_size Usado para gerar a senha a ser salva no banco de dados;
	 * @var array[] $vetor_dados Recebe o vetor de Dados para o cadastro do usuário;
	 * @var string $pass Senha de acesso do usuário;
	 * @var string $login Usuario ou email de acesso do usuário;
	 * @var string $SIS_PHPMail
	 * @var string $str
	 * @var string $self
	 * @var string $httpServer
	 * @var string $linkCadastroOk
	 * @var string $linkErroVetorDadosNaoRecebidos
	 * @var string $linkUsuarioJaExiste
	 * @var string $linkUserSenhaInvalida
	 * @var string $linkUserSenhaIncorreto
	 * @var string $linkUserUsuarioLogado
	 * @var string $linkUserUsuarioEspirado
	 * @var string $linkUserAlteracaoOk
	 * @var string $linkUserNaoAtivo
	 * @var string $linkUserEnviado
	 * @var string $linkUserSemCadastro
	 * @var string $linkUserAtivado
	 * @var string $linkUserError
	 * @var string $secaoCadastro
	 * @var string $secaoLogin
	 * @var string $secaoLoginOk
	 * @var string $secaoLoginHome
	 * @var string $secaoRecuperaSenha
	 * @var string $acaoRecuperarSenha
	 * @var string $acaoAtivarCadastro
	 * @var string $linkUserUserLogin
	 * @var string $sis_local
	**/

	private $conn;	
	private $iv;
	private $iv_size;
	private $crypt_user;
	private $vetor_dados;
	private $pass;
	private $login;
	private $SIS_PHPMail;
	private $str;
	private $self;
	private $httpServer;
	private $sis_local;
	// Valores de configuração de cadastro
	private $linkCadastroOk = 'sisMsg=cadastro_user_ok'; 
	private $linkErroVetorDadosNaoRecebidos = 'sisMsg=cadastro_erro';
	private $linkUsuarioJaExiste = 'sisMsg=usuario_ja_cadastrado' ;
	private $linkUserSenhaInvalida = 'sisMsg=user_senha_invalido';
	private $linkUserSenhaIncorreto = 'sisMsg=user_senha_incorreto';
	private $linkUserUsuarioLogado = 'sisMsg=user_ja_logado';
	private $linkUserUsuarioEspirado = 'sisMsg=user_espirou';
	private $linkUserAlteracaoOk = 'sisMsg=senha_alterada';
	private $linkUserNaoAtivo = 'sisMsg=usuario_nao_ativo';
	private $linkUserEnviado = 'sisMsg=email_rec_enviado';
	private $linkUserSemCadastro = 'sisMsg=email_sem_cadastro';
	private $linkUserAtivado = 'sisMsg=cadastro_ativado';
	private $linkUserUserLogin = 'sisMsg=login_ok';
	private $linkUserUserLogOff = 'sisMsg=logoff_ok';

	private $linkUserError = 'sisMsg=sis_error';

	// SECAO 
	private $secaoCadastro = 'secao=cadastrar';
	private $secaoLogin = '';
	private $secaoLoginOk = '';
	private $secaoLoginHome = '';
	private $secaoRecuperaSenha = 'secao=Recuperar Senha';

	private $acaoRecuperarSenha = 'acao=Recuperar';
	private $acaoAtivarCadastro = 'acao=ativar';

	// private $var;
	function __construct(){
		// Abrindo conexão com o banco de dados.
		$connect = Connect::open($this->login_action);
		$this->conn = $connect;	
		// pegandp tamanho do ventor
		$this->iv_size = mcrypt_get_iv_size(MCRYPT_CAST_256, MCRYPT_MODE_OFB);
		$this->iv = mcrypt_create_iv($this->iv_size, MCRYPT_DEV_RANDOM);	
		$this->mail = new PHPMailer();
		global $SIS_PHPMail;
		$this->SIS_PHPMail = $SIS_PHPMail;
		$this->str = new String();
		global $SELF;
		$this->self = $SELF;
		global $SIS_HTTP_SERVER;
		$this->httpServer = $SIS_HTTP_SERVER;
		$this->log = new SisLog();
		global $SIS_local;
		$this->sis_local = $SIS_local;
	}

	/**
	 * @param string Recebe o email ou o usuário enviado pelo formulário.
	 * @param string Recebe a senha enviada pelo formulário.
	 * @param bool|false Determina se vou depurar o metodo de login ou não.
	 * @return mixed Retorna a seção do usuário logado e gera o cookie de acesso. 
	**/
	public function login($login, $pass, $depure = false){
		$this->login = $login;
		$this->pass = $pass;
		$log = new SisLog;
		if($this->sis_local == 'producao') : $depure = false; endif;
		//  caso o bonitão não preencha os dois, coisa basica.
		if((!$this->login) || (!$this->pass)){
			if(!$depure){
				header("Location: $SELF?{$this->secaoLogin}&{$this->linkUserSenhaInvalida}");
				exit();				
			}
		}
		if($depure){
			echo "<pre> Dados de acesso: </pre>
				<pre><b>Login:</b> {$this->login} </pre>
				<pre><b>Senha:</b> {$this->pass} </pre>
				=============================
			"; 
		}
		
		// Iniciando a analise dos dados recebidos 
		$query = new Connect();
		$query->login_action = true;		
		$buscaUsuario = $query->open()->prepare("SELECT * FROM per_perfil WHERE (login_key =:login or email =:login)");
		$buscaUsuario->bindValue(":login", strtolower($login));
		// $buscaUsuario->bindValue(":email", strtolower($login));		
		$buscaUsuario->execute();

		// $buscaUsuario->debugDumpParams();
		// verificando se otive resultado
		$result = $buscaUsuario->rowCount();

		// new SIS_debug($result, '$result');
		// new SIS_debug($login, '$login');

		if($result == 1){ // melhorar isso,
			$vetorDados = $buscaUsuario -> fetchAll(PDO::FETCH_ASSOC);	 // extraindo o vetor com o vetor interno de dados, devido a ser somente 1 vetor vou ter que extrair isso.		
			$vetorDadosUsuario = $vetorDados[0]; // devido a ser somente 1 não a necessidade de percorrer vetores.
			if($depure){
				echo "<pre><b>Dados do usuario no banco de dados</b>";
				var_dump($vetorDadosUsuario);
				echo "</pre>";				
			}
			// new SIS_debug($vetorDadosUsuario, '$vetorDadosUsuario');
			// Se ele não tiver ativo quer dizer que ja fez o cadastro mais não ativou a conta ainda.
			if($vetorDadosUsuario['ativo'] == 0){
				if(!$depure){
					header("Location: $SELF?{$this->secaoLogin}&{$this->linkUserNaoAtivo}");
					exit();					
				}
			}
			// verificando se o usuario digitado tem uma senha valida. 
			// O resultado disto tem que ser o mesmo login de acesso.
			$decrypt_user = mcrypt_decrypt(MCRYPT_CAST_256, $pass, $vetorDadosUsuario['crypt_user'], MCRYPT_MODE_OFB, $vetorDadosUsuario['iv']);
			
			// new SIS_debug($vetorDadosUsuario['login'], '$vetorDadosUsuario[login_key]');

			// Senha Correta. perfeitamente igual.
			if($vetorDadosUsuario['login_key'] === $decrypt_user){
				// gerando sessão de permições e dados do usuário.
				    // new SIS_debug($vetorDadosUsuario, '$vetorDadosUsuario');
					// echo "Logado";
					unset($_SESSION['sis_user']);
					$vetor_dados_session['id_perfil'] = $vetorDadosUsuario['id_perfil'];
					$vetor_dados_session['primeiro_nome'] = $vetorDadosUsuario['primeiro_nome'];
					$vetor_dados_session['login'] = $vetorDadosUsuario['login'];
					$vetor_dados_session['id_tipo_perfil'] = $vetorDadosUsuario['id_tipo_perfil'];
					$vetor_dados_session['idioma'] = $vetorDadosUsuario['idioma'];
					$vetor_dados_session['id_session'] = session_id();
					$vetor_dados_session['session_time'] = time();
					$vetor_dados_session['adress'] = $_SERVER['REMOTE_ADDR'];
					$_SESSION['sis_user']= $vetor_dados_session;
					if($depure){
						echo "<pre> <b>SESSION</b>";
						var_dump($_SESSION);
						echo "</pre>";
						break;
					}

					// $return_check = $this->check_user($vetorDadosUsuario['id_perfil']);
					if(is_array($_SESSION['sis_user'])){
						$this->gera_hitorico_usuario(1);
					}
					header("Location: $SELF?{$this->secaoLoginOk}&{$this->linkUserUserLogin}");
					exit();
					// new SIS_debug($_SESSION, '$_SESSION Valor da Session Dentro da Classe');					
					// session_destroy();
			}
			// Senha Incorreta.
			else{
				header("Location: $SELF?{$this->secaoLogin}&{$this->linkUserSenhaInvalida}");
				exit();
			}
		}
		elseif ($result > 1) { 
			// se for maior 1 que dizer que tem algum tipo de problema no login melhora ou realizar log disto
			$log->create('mais de um resultado verificar');
		}
		else{ 
			// caso não tenha resultado, isso é não a usupario cadastrado enquestão, vou optar por redirecionar parao cadastro.
			header("Location: $SELF?{$this->secaoLogin}&{$this->linkUserSemCadastro}");			
			// exit();			
		}
	}

	/**
	 * Esta função sómente tem a função de destruir a sessão do usuário e salvar no histórico do mesmo
	 * @return mixed Redireciona para o caminho determinado caso o logoff seja valido.
	 * Caso não seja um logoff valido retora null
	 * Tambem salva no banco de dados a hora e ip de logoff.
	**/
	public function logoff(){		
		if($_SESSION['sis_user']){
			$this->gera_hitorico_usuario('0');
			unset($_SESSION['sis_user']);
			header("Location: $SELF?{$this->secaoLoginOk}&{$this->linkUserUserLogOff}");
			exit();
		}
		else{
			return false;
		}
	}

	/**
	 * @param mixed, Recebe um vetor par inserir no banco de dados, conforme a necessidade do usuario.
	 * os dados vão ser dinamicos assim caso exista um novo campo não vai ser necessário atualiza este código.
	 * @return boolean. Retorna true para caso seja inserido com sucesso ou false para caso ocorra algum erro. 
	**/
	public function cadastrar($vetor_dados){

		global $SELF;		

		$this->vetor_dados=$vetor_dados;
		
		$buscaUsuario = $this->conn->prepare("SELECT login, email FROM per_perfil WHERE (login_key=:login or email =:email)");		
		// new SIS_debug($buscaUsuario);
		if(is_array($this->vetor_dados)){
			if((!$this->vetor_dados['login']) || (!$this->vetor_dados['email'])){
				header("Location: $SELF?{$this->secaoCadastro}&{$this->linkErroVetorDadosNaoRecebidos}");		
				exit();
			}
			foreach ($this->vetor_dados as $key => $value) {
				if($key == 'login'){
					$buscaUsuario->bindValue(":$key",strtolower($value));
				}
				if($key == 'email'){
					$buscaUsuario->bindValue(":$key",strtolower($value));					
				}
			}	
			unset($key); unset($value);			
		}
		else{
			header("Location: $SELF?{$this->secaoCadastro}&{$this->linkErroVetorDadosNaoRecebidos}");		
			exit();
		}
		$buscaUsuario->execute();	
		$result = $buscaUsuario->rowCount();
		// new SIS_debug($result,"$result", true);	
		// Busca as colunas para um comparação no vetor recebido. evitando possiveis vulnerabilidades.
		$buscaColunas = $this->conn->query("SHOW COLUMNS FROM per_perfil");
		$colunas = $buscaColunas -> fetchAll();
		foreach ($colunas as $key => $value) {
			$vetor_coluna[] = $value["Field"];
		}	
		// Se for 0 quer dizer que nem o email e login ja existem :)
		if($result == '0'){
			// inserindo valor login_key
			if($this->vetor_dados['login']){
				$this->vetor_dados['login_key']= strtolower($this->vetor_dados['login']); //chave de login.
				$this->vetor_dados['email'] = strtolower($this->vetor_dados['email']); // deixando email com letras em caixa baixa.
			}

			// trabalhando com a senha de cadastro. só entro aqui caso tenha esses dados.
			if($this->vetor_dados['pass']){
				$this->crypt_user = mcrypt_encrypt(MCRYPT_CAST_256, $this->vetor_dados['pass'], $this->vetor_dados['login_key'], MCRYPT_MODE_OFB, $this->iv);
				$this->vetor_dados['iv'] = $this->iv;
				$this->vetor_dados['crypt_user'] = $this->crypt_user;	
			}

			// Gerando uma rash para ativação do cadatro do usuáro
			// Com base na data e outros dados vou gerar uma rash
			$strHash = time()."-{$id_perfil}"; // usando time pra mudar e o id do usuário, não vejo necessidade disso mais pra deixar bonito. :D
			$userHash = hash('sha256', $strHash );

			if($userHash){
				$this->vetor_dados['recuperacao_hash'] = $userHash;
			} 

			// trabalhando com o vetor recebido, e gerando a Query Dinamica
			$quant_itens = count($this->vetor_dados);
			foreach ($this->vetor_dados as $key => $value){
				$count_itens++;
				if($quant_itens != $count_itens ){
					$v = ", ";
				}
				if(in_array($key, $vetor_coluna)){
					$set.= "$key{$v}";
					$set_value.=":$key{$v}";					
				}
				unset($v);
			}
			unset($key); unset($value);		
			// Peparando para inserir os valores.
			$cadastraUsuario = $this->conn->prepare("INSERT INTO per_perfil ($set) VALUES ($set_value) ");
			// depositando os valores
			foreach ($this->vetor_dados as $key => $value) {
				if(in_array($key, $vetor_coluna)){
					$cadastraUsuario->bindValue(":$key", $value);
				}
			}
			$return_execute = $cadastraUsuario->execute();
			// new SIS_debug($return_execute, 'retrurn', true);break;exit();
			// echo "<pre>";var_dump($return_execute);echo"</pre>";break;
			if($return_execute){

				// Gerando o email de contato para ativação da Conta. 
				$mail = $this->mail;
				$mail->CharSet = 'UTF-8';
				$mail->IsSMTP(); 
				$mail->setLanguage('Pt-BR');
				$mail->Host = $this->SIS_PHPMail['Host'];
				$mail->SMTPAuth = $this->SIS_PHPMail['SMTPAuth'];
				$mail->Username = $this->SIS_PHPMail['Username'];
				$mail->Password = $this->SIS_PHPMail['Password'];
				// FROM
				$mail->From = $this->SIS_PHPMail['From'];
				$mail->FromName = $this->SIS_PHPMail['FromName'];

				// Email de Destintário
				$mail->AddAddress($vetor_dados['email'], $vetor_dados['primeiro_nome']);
				// new SIS_debug($vetor_dados, 'vetor_dados', true);
				// Mandando uma Copia pra mim. não preciso de cópia ....
				// $mail->AddBCC($this->SIS_PHPMail['From'], $this->SIS_PHPMail['FromName']);

				$mail->IsHTML(true);

				$url_ativar = "{$this->httpServer}{$this->self}?{$this->secaoLogin}&{$this->acaoAtivarCadastro}&h={$userHash}";
				$mailCode = array('[NOME]', '[URL_ATIVAR]');
				$mailChange = array("{$vetor_dados['primeiro_nome']}", "$url_ativar");
				// new SIS_debug($mailChange, 'mailChange', true);
				$mail->Subject = "{$vetor_dados['primeiro_nome']}, {$this->str->show('mailCatratroSubject')}";
				$mail->Body = str_replace($mailCode, $mailChange, $this->str->show('mailCadastroBodyHtml'));
				$mail->AltBody = $this->str->show('mailCadastroBody');
				// new SIS_debug(str_replace($mailCode, $mailChange, $this->str->show('mailCadastroBodyHtml')), 'corpo mail', true);
				$enviado = $mail->Send();
				// Limpando subjects
				$mail->ClearAllRecipients();
				// se foi enviado é uma vitória o/
				if($enviado){					
					header("Location: $SELF?{$this->secaoCadastro}&{$this->linkCadastroOk}");
					exit();
				}
				else{
					new SIS_debug($mail->ErrorInfo, "Erro PHPMailer");
				}				
			}
			else{
				$this->log->create('Ouve um erro no cadastro do usuário em questão, verificar.');
				header("Location: {$this->self}");
				exit();
			}			
		}
		// Caso exista vou pensar em algo.
		else{
			header("Location: $SELF?{$this->linkUsuarioJaExiste}");
			exit();
		}
	}

	/**
	 * @param string, hash Recebe a rash de ativação da conta do usuario em questão, 
	 * para a tivaçao é necessário a busca de usuáro caso retorne true ele atualiza e ativa-o.
	 * @return encaminha o usuario para o caminho deterninado do pela sessão e acao.
	**/
	public function ativar_cadastro($hash){
		$ativarCadastro = $this->conn->prepare("SELECT id_perfil FROM per_perfil WHERE recuperacao_hash = :recuperacao_hash and ativo = 0 ");
		$ativarCadastro->bindValue(':recuperacao_hash', $hash);
		$ativarCadastro->execute();
		$result = $ativarCadastro->rowCount();
		// new SIS_debug($result, 'result', true);
		if($result == 1){
			unset($result); //isso vai resetar o valor da variavel antes de ser reutilizada			
			$vetor_dados = $ativarCadastro-> fetchAll(PDO::FETCH_ASSOC);
			$vetor_dados = $vetor_dados[0];
			// Ativando a conta e exvluind a hash
			$ativandoCadastro = $this->conn->prepare("UPDATE per_perfil SET ativo = 1, recuperacao_hash = null WHERE id_perfil = :id_perfil");
			$ativandoCadastro->bindValue('id_perfil', $vetor_dados['id_perfil']);
			$result = $ativandoCadastro->execute();
			// Atualizado com sucesso.
			if($result == 1){
				// Direciono para o novo Caminho
				header("Location: $SELF?{$this->secaoLogin}&{$this->linkUserAtivado}");
				exit();
			}
		}
		else{
			unset($_SESSION);
			header("Location: $SELF?{$this->secaoLoginHome}&{$this->linkUserError}");			
			exit();
		}
	}


	public function atualizar_dados($vetor_dados){

	}

	/**
	 * @param string, Recebe o email do usuario para a recuperação da senha.
	 * Assim sera enviado um email para o usuário com o link de recuperação de senha
	 * @return boolean, true para o envio do email or false para algum tip de problema
	**/
	public function solicitar_senha($email){
		new SIS_debug($email, '$email');
		$solicitarSenha = $this->conn->prepare("SELECT id_perfil, idioma, primeiro_nome, ativo FROM per_perfil WHERE email = :email");
		$solicitarSenha->bindValue(':email', $email);
		$solicitarSenha->execute();
		$result = $solicitarSenha->rowCount();
		// Achou o usuário
		if($result == 1){
			$vetorDados = $solicitarSenha->fetchAll(PDO::FETCH_ASSOC);
			$vetorDados = $vetorDados[0];
			// new SIS_debug($vetorDados, '$vetorDados');
			$id_perfil = $vetorDados['id_perfil'];
			$idioma = $vetorDados['idioma'];
			// Se ele não tiver ativo quer dizer que ja fez o cadastro mais não ativou a conta ainda.
			if($vetorDados['ativo'] == 0){
				header("Location: $SELF?{$this->secaoLogin}&{$this->linkUserNaoAtivo}");
				exit();
			}
			$primeiro_nome = $vetorDados['primeiro_nome'];
			// Com base na data e outros dados vou gerar uma rash
			$strHash = time()."-{$id_perfil}"; // usando time pra mudar e o id do usuário, não vejo necessidade disso mais pra deixar bonito. :D
			$userHash = hash('sha256', $strHash );
			// inserindo a rash no banco de dados do usupario
			$insertHash = $this->conn->prepare("UPDATE per_perfil SET recuperacao_hash = :recuperacao_hash, recuperacao_data = NOW() WHERE id_perfil = :id_perfil");
			$insertHash->bindValue(':recuperacao_hash', $userHash);
			$insertHash->bindValue(':id_perfil', $id_perfil);
			$result = $insertHash->execute();
			// Foi atualizado com sucesso, 
			// preparando Email a ser enviado ao usuário.
			if($result){
				$mail = $this->mail;
				$mail->CharSet = 'UTF-8';
				$mail->IsSMTP(); 
				$mail->setLanguage('Pt-BR');
				$mail->Host = $this->SIS_PHPMail['Host'];
				$mail->SMTPAuth = $this->SIS_PHPMail['SMTPAuth'];
				$mail->Username = $this->SIS_PHPMail['Username'];
				$mail->Password = $this->SIS_PHPMail['Password'];
				// FROM
				$mail->From = $this->SIS_PHPMail['From'];
				$mail->FromName = $this->SIS_PHPMail['FromName'];

				// Email de Destintário
				$mail->AddAddress($email, $primeiro_nome);
				// Mandando uma Copia pra mim.
				$mail->AddBCC($this->SIS_PHPMail['From'], $this->SIS_PHPMail['FromName']);

				$mail->IsHTML(true);

				$url_recuperar = "{$this->httpServer}{$this->self}?{$this->secaoRecuperaSenha}&{$this->acaoRecuperarSenha}&h={$userHash}";
				$mailCode = array('[NOME]', '[URL_RECUPERAR]');
				$mailChange = array("$primeiro_nome", "$url_recuperar");
				
				$mail->Subject = "$primeiro_nome, {$this->str->show('mailRecuperacaoSubject')}";
				$mail->Body = str_replace($mailCode, $mailChange, $this->str->show('mailRecuperacaoBodyHtml'));
				$mail->AltBody = $this->str->show('mailRecuperacaoBody');
				// new SIS_debug(str_replace($mailCode, $mailChange, $this->str->show('mailRecuperacaoBodyHtml')), 'corpo mail', true);
				$enviado = $mail->Send();

				// Limpando subjects
				$mail->ClearAllRecipients();
				// se foi enviado é uma vitória o/
				if($enviado){
					header("Location: $SELF?{$this->secaoLogin}&{$this->linkUserEnviado}");
					exit();
				}
				else{
					new SIS_debug($mail->ErrorInfo, "Erro PHPMailer");
				}
			}
		}
		else{
			header("Location: $SELF?{$this->secaoCadastro}&{$this->linkUserSemCadastro}");
			exit();
		}
	}

	/**
	 * @param string 'hash' recebe a hash e verifica se existe alguma no banco para realizar a atualização da seha do usuário
	 * @param string, recebe a nova senha para atualização do banco de dados.
	 * @return boolean retorna true or false, para o cadastro da senha
	**/
	public function recuperar_senha($hash, $newpass){
		$log = new SisLog;		
		$recuperarSenha = $this->conn->prepare("SELECT id_perfil, login_key FROM per_perfil WHERE recuperacao_hash = :recuperacao_hash ");
		$recuperarSenha->bindValue(':recuperacao_hash', $hash);
		$recuperarSenha->execute();
		$result = $recuperarSenha->rowCount();
		// igual a 1 está ok e existe.
		if(($result == 1) && ($newpass == true)){
			unset($result); //isso vai resetar o valor da variavel antes de ser reutilizada
			// Iniciando a Criação da nova Senha para atualizar no banco de dados, 
			$vetor_dados = $recuperarSenha-> fetchAll(PDO::FETCH_ASSOC);
			$vetor_dados = $vetor_dados[0];
			$this->crypt_user = mcrypt_encrypt(MCRYPT_CAST_256, $newpass, $vetor_dados['login_key'], MCRYPT_MODE_OFB, $this->iv);
			// $this->vetor_dados['iv'] = $this->iv;
			// $this->vetor_dados['crypt_user'] = $this->crypt_user;	

			$salvandoNovaSenha = $this->conn->prepare("UPDATE per_perfil SET iv = :iv, crypt_user = :crypt_user, atualizacao_data = NOW(), recuperacao_hash = null WHERE id_perfil = :id_perfil");
			$salvandoNovaSenha->bindValue('iv', $this->iv);
			$salvandoNovaSenha->bindValue('crypt_user', $this->crypt_user);
			$salvandoNovaSenha->bindValue('id_perfil', $vetor_dados['id_perfil']);
			$result = $salvandoNovaSenha->execute();	
			 // Caso seja true quer dizer que está ok o/ 
			if($result){
				header("Location: $SELF?{$this->secaoLogin}&{$this->linkUserAlteracaoOk}");
				exit();
			}
			
		}
		// se for maior que 1 temos que ver o que está acotecendo
		elseif ($result > 1) {
			unset($_SESSION); // eliminar só por garantia a sessão. ou par atrolar u.u
			$log->create("Quando realizado a busca do usuario pelo HASH retornou mais de um resultado quantidade Retornada: $result");
		}
		// se não exsir o cara ta tentando sacanear...
		else{
			unset($_SESSION);
			header("Location: $SELF?{$this->secaoLoginHome}&{$this->linkUserError}");			
			exit();
		}
	}

	/**
	 * Usa os valores da session, id_perfil, e session_time, para verificar se o usupario logado e valido a na instancia em questão 
	 * @return retorna o pach de usuário logado, caso o usuário logado esteja na ultima sessão ele retorna corretamente.
	**/
	public function check_user(){

		if(!is_array($_SESSION['sis_user'])){ // se não existir ele não está logado.
			return false;
		}

		$return = $this->check_session_id_user($_SESSION['sis_user']['id_perfil']);
		if($return){ // é igual está ok
			if((time() - $_SESSION['sis_user']['session_time']) >= 3600 ){
				unset($_SESSION['sis_user']);
				header("Location: $SELF?{$this->secaoLogin}&{$this->linkUserUsuarioEspirado}");
				exit();
			}
			else{
				$_SESSION['sis_user']['session_time'] = time();
				return $_SESSION['sis_user']['id_tipo_perfil'];				
			}
		}
		else{
			unset($_SESSION['sis_user']); // destruindo a sessão dele pois ele já esta logado em outro lugar......
			header("Location: $SELF?{$this->secaoLogin}&{$this->linkUserUsuarioLogado}");
			exit();
		}
	}

	/**
	 * Busca no banco de dados e retorna true para usuário encontrado ou false para usuário não encontrado
	 * É realizado uma buca no sistema com base no email ou login e a verifcaçãp e realizada com base no login_key
	 * @param string $dado Recebe o dado a ser buscado
	 * @return bool.
	**/
	public function buscaUsuario($dado){
		
		$buscaUsuario = $this->conn->prepare("SELECT login_key FROM per_perfil WHERE (login_key=:dado or email =:dado)");		
		$buscaUsuario->bindValue(':dado', $dado);
		$buscaUsuario->execute();
		$quant = $buscaUsuario->rowCount();
		if($quant == 1){
			return true;
		}
		else{
			return false;
		}
	}

	/**
	 * Busca com base na sessão atua os dados do usuário em questão 
	 * @param string $key Quando exitir ira retornar o dados especificado, caso não ira retornar um vetor de dados, 
	 * @return array | string Retorna o array da sessão ou o dado especificado 
	**/
	public function dadosUsuarioSession($key = null){
		$session = $_SESSION['sis_user'];
		if($session){
			if(!$key){
				return $session;
			}else{
				if(array_key_exists($key, $session)){
					return $session[$key];

				}else{
					return null;
				}
			}
		}
	}

	/**
	 * Salva no Banco de Dados o histórico de login e Logoff do usuário. 
 	 * @param boolean, $acao, 1 para login 0 para logoff.
	**/
	private function gera_hitorico_usuario($acao){
		$queryHistorico = $this->conn->prepare("INSERT INTO per_login_historico (id_perfil, login_logoff, id_session, adress) VALUES (:id_perfil, :login_logoff, :id_session, :adress)");  
		// id_perfil, login_logoff, data_login_logoff, id_session, adress
		$queryHistorico->bindValue(':id_perfil', $_SESSION['sis_user']['id_perfil'] );
		$queryHistorico->bindValue(':login_logoff', $acao);
		$queryHistorico->bindValue(':id_session', $_SESSION['sis_user']['id_session']);
		$queryHistorico->bindValue(':adress', $_SESSION['sis_user']['adress']);
		$queryHistorico->execute();
	}

	/**
	 * @param int $id_perfil, recebe o id do usuário em questão e verifica o ultimo registro de login no histórico
	 * @return boolean, caso o usuário esteja logado retorna true caso não retorna false; 
	**/
	private function check_session_id_user($id_perfil = null){
		if($id_perfil == null){ // caso seja nulo eu pego da sessão.
			$id_perfil = $_SESSION['sis_user']['id_perfil'];
		}
		$queryVerifica = $this->conn->prepare("SELECT id_session from per_login_historico WHERE id_perfil = :id_perfil AND login_logoff = 1 ORDER BY id_login_historico DESC LIMIT 1");
		$queryVerifica->bindValue(':id_perfil', $id_perfil);
		$queryVerifica->execute();		
		$vetor_verifica = $queryVerifica->fetchAll(PDO::FETCH_ASSOC);
		$id_session_banco = $vetor_verifica[0]['id_session']; // ultima id_session do Banco de Dados para o usuário em questão.
		if($_SESSION['sis_user']['id_session'] == $id_session_banco){ // se a sessão atual for igual a ultima sessão do banco prova que o usuário em questão está novamente logado em outro lugar.
			return true;
		}
		else{
			return false;
		}		
	}


	/**
	 * 
	**/
}

?>