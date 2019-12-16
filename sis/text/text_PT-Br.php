<?php
/**
 * Módulo o qual vai alocar as informações para o idioma determinado
 * @author Thiago Rodrigues 
 * @version Pt-BR.
 * @package String.
**/ 


// ========= Configuração de Mensagens de Alerta ================ ]
// Temas disponiveis: default, primary, success, info, warning, danger, link

// testos padroes
$StrAlert['cadastro_ok']['success'] = 'Cadatro Realizado com Sucesso!';
$StrAlert['atualizado_ok']['success'] = 'Atualizado com Sucesso!';
$StrAlert['excluido_ok']['warning'] = 'Excluido com Sucesso!';
$StrAlert['erro']['warning'] = 'Ocorreu algum erro entre em contato com o Adminitrador';
$StrAlert['questionario_cadatro_ok']['success'] = 'Questionário Criado Con sucesso';

// Padrão usado: $StrAlert['key_mensagem']['tema']; 
$StrAlert['cadastro_user_ok']['info'] = 'Cadatro Realizado com Sucesso! Por favor verifique sua caixa de email para ativar sua conta. ';
$StrAlert['cadastro_erro']['danger'] = 'Ouve algum erro entre em contato com o Adiminitrador atravez do formulário de Contato.';
$StrAlert['cadastro_ativado']['info'] = 'Seu cadastro foi ativado, Bem vindo ao QiEstudo!';
$StrAlert['usuario_ja_cadastrado']['warning'] = 'Este usuário ja existe por favor tente outro.';
$StrAlert['user_ja_logado']['danger'] = 'Sua conta foi acessada em outro lugar, se não foi você por favor atualize sua senha.';
$StrAlert['user_espirou']['warning'] = 'Sua conta foi desconectadapara protejer sua conta. caso deseje acessar o sistema novamente por favor por favor entre novamente com seus dados.';
$StrAlert['senha_alterada']['info'] = 'Senha Alterada com Sucesso.';
$StrAlert['usuario_nao_ativo']['info'] = 'Seu Usuário parece já ter cadastro no QiEstudo, porem sua conta ainda não foi ativada, por favor verifique sua Caixa de email e ative sua conta, caso esteja tendo algum problema por favor entre em contato com o suporte.';
$StrAlert['email_rec_enviado']['info'] = 'Email Enviado com Sucesso. Por favor verifique sua Caixa de Email.';
$StrAlert['login_ok']['success'] = "Login efetuado com sucesso!"; 
$StrAlert['login_erro']['danger'] = ""; 
$StrAlert['logoff_ok']['info'] = "LogOff efetuado com sucesso!";
// Cadastro Usuário
$StrAlert['email_sem_cadastro']['warning'] = "O login digitado não existe em noso sistema, não gostaria de realizar um novo cadastro?";
$StrAlert['user_senha_invalido']['danger'] = "Usuário ou Senha Invalido, por favor verifique e tente novamente.";
$StrAlert['erro_primeiro_nome']['danger'] = "Por favor, preencha o campo <strong>Primeiro Nome</strong> corretamente";
$StrAlert['erro_sobrenome']['danger'] = "Por favor, preencha o campo <strong>Sobrenome</strong> corretamente";
$StrAlert['erro_login']['danger'] = "Por favor, preencha o campo <strong>Login</strong> corretamente";
$StrAlert['erro_cadastro_login']['danger'] = "Por favor, utilize outro <strong>Login</strong> para cadastro pois este ja foi utilizado";
$StrAlert['erro_email']['danger'] = "Por favor, preencha o campo <strong>Email</strong> corretamente";
$StrAlert['erro_cadastro_email']['danger'] = "Por favor, utilize outro <strong>Email</strong> para cadastro pois este ja foi utilizado";
$StrAlert['erro_pass']['danger'] = "Por favor, preencha o campo <strong>Senha e Repita Senha</strong> corretamente";
$StrAlert['erro_dif_pass']['danger'] = "Por favor, utilize a mesma senha nos dois campos de <strong>Senha</strong>";
$StrAlert['erro_cpf']['danger'] = "Por favor, preencha o campo <strong>CPF</strong> corretamente";
$StrAlert['erro_data_nascimento']['danger'] = "Por favor, preencha corretamene com uma <strong>Data</strong> valida";
$StrAlert['erro_cep']['danger'] = "Por favor, preencha o campo <strong>CEP</strong> corretamente";
$StrAlert['erro_rua']['danger'] = "Por favor, preencha o campo <strong>Rua</strong> corretamente";
$StrAlert['erro_numero']['danger'] = "Por favor, preencha o campo <strong>Numero</strong> corretamente";
$StrAlert['erro_bairro']['danger'] = "Por favor, preencha o campo <strong>Bairro</strong> corretamente";
$StrAlert['erro_cidade']['danger'] = "Por favor, preencha o campo <strong>Cidade</strong> corretamente";
$StrAlert['erro_estado']['danger'] = "Por favor, preencha o campo <strong>Estado</strong> corretamente";
// Cadastro Questionarios
$StrAlert['nome_questionario']['danger'] = "Preencha o nome do Questionário!"; 
$StrAlert['data_cadastro']['danger'] = "Preencha uma data valida para o questionário"; 
$StrAlert['quantidade_perguntas']['danger'] = "Preencha um numero valido de quantidade de perguntas"; 
$StrAlert['ano']['danger'] = "Preencha o ano do Questionário"; 
$StrAlert['img_questionario_nao_perm']['danger'] = "Por favor utiliza um tipo de imagem Valida."; 
// ======================

// ============================================== ]


// ======= Configurações Globais Email ===========]

	$StrTexto['menu_cadastrar'] = 'Cadastrar';
	$StrTexto['menu_contato'] = 'Contato';
	$StrTexto['menu_objetivo'] = 'Objetivo';
	$StrTexto['menu_btn_login'] = 'Entrar';
	$StrTexto['menu_raking'] = 'Ranking';
	$StrTexto['menu_novo_questionario'] = 'Listar Questionários Disponiveis';
	$StrTexto['menu_questionario_per'] = 'Questionário Personalizado';
	$StrTexto['menu_meus_questionarios'] = 'Meus Questionários';
	$StrTexto['menu_historico'] = 'Histórico';
	$StrTexto['menu_meus_dados'] = 'Meus Dados';
	$StrTexto['menu_logoff'] = 'Logoff';
	$StrTexto['menu_admin_usuarios'] = 'Usuários';
	$StrTexto['menu_admin_questionario'] = 'Questionários';
	$StrTexto['menu_admin_dicas'] = 'Dicas Questionários';





// ============================================== ]


$StrTexto['sis_error'] = 'Ocorreu um erro do sistema, por favor entre em contato com o Administrador.';


// ======= Configurações Globais Email ===========]

	$Email_footer_HTML = 'Att, <br><p style="font-size:14px" ><a href="mailto:sistema@qiestudo.com.br"><b>QiEstudo</b></a> - Venha aprender com a gente.</p>';
	$Email_footer = 'QiEstudo - Venha aprender com a gente.';

// ============================================== ]

// ========Email de Recuperação de Senha ======== ] 

	$StrTexto['mailRecuperacaoSubject'] = 'Procedimento Para Recuperação de Senha';
	$StrTexto['mailRecuperacaoBodyHtml'] = "
		<div style='font-family: Arial;' >
			<h2 style='font-family:Times New Roan;'>
				<img src='http://qiestudo.com.br/img/logo_smal_mail.png' alt='QiEstudo'>					
			</h2>
			<p>Olá, </p>
			<p>[NOME], vejo que você solicitou uma recuperação de senha.</p>
			<p>Para Recuperar sua senha Basta Clicar em:</p>
			<p><a href='[URL_RECUPERAR]' title='Recuperar Senha' target='_blank'><button style='color: #FFF; background-color: #337AB7; border-color: #2E6DA4; display: inline-block; padding: 6px 12px; margin-bottom: 0px; font-size: 14px; font-weight: 400; line-height: 1.42857; text-align: center; white-space: nowrap; vertical-align: middle; cursor: pointer; -moz-user-select: none; background-image: none; border: 1px solid transparent; border-radius: 4px; '>Recuperar Senha</button></a></p>	
			<p>E assim atualizar com a nova Senha </p>
			<p>Caso não consiga acessar pela url por favor copie e cole em seu navegador o seguinte código: </p>
			<p>[URL_RECUPERAR]</p>
			<p>Caso não tenha Solicitado a Recuperação de senha, por favor desconsidere esse email, ou entre em contato com o suporte. </p>
			<div style='background-color: #ECFFF4; border-top: 1px solid #8AEC71; padding: 10px;'>
				{$Email_footer_HTML}
			</div>
		</div>";
	$StrTexto['mailRecuperacaoBody'] = "
		QiEstudo, 

		Olá,

		[NOME] vejo que você solicitou uma recuperação de senha. 

		Para Recuperar sua senha copie esse link a seguir e cole no seu navegador \"[URL_RECUPERAR]\" (sem as aspas), 

		E assim atualizar com a nova Senha, 

		Caso não tenha Solicitado a Recuperação de senha, por favor desconsidere esse email, ou entre em contato com o suporte para mais informações. 

		{$Email_footer}";


// ============================================== ]







// ========Email Ativação de Cadastro ======== ] 

	$StrTexto['mailCatratroSubject'] = 'Procedimento para ativação de conta no QiEstudo';
	$StrTexto['mailCadastroBodyHtml'] = "
		<div style='font-family: Arial;' >
			<h2 style='font-family:Times New Roan;'>
				<img src='http://qiestudo.com.br/img/logo_smal_mail.png' alt='QiEstudo'>					
			</h2>
			<p>Olá, [NOME], </p>
			<p>Seja bem vindo ao QiEstudo!</p>
			<p>Vamos ativar sua conta?</p>
			<p>Para realizar a ativação da sua conta basta clicar no link abaixo:</p>
			<p><a href='[URL_ATIVAR]' title='Ativar Conta' target='_blank'><button style='color: #FFF; background-color: #337AB7; border-color: #2E6DA4; display: inline-block; padding: 6px 12px; margin-bottom: 0px; font-size: 14px; font-weight: 400; line-height: 1.42857; text-align: center; white-space: nowrap; vertical-align: middle; cursor: pointer; -moz-user-select: none; background-image: none; border: 1px solid transparent; border-radius: 4px; '>Ativar Conta</button></a></p>	
			<p>Caso esteja tendo dificuldades, por favor copie e cole em seu navegador a seguinte url:</p>
			<p>[URL_ATIVAR]</p>
			<p>Caso esteja tendo algum problema ou gostaria de nos ajudar com sua opinião, por favor entre em contato.</p>
			<div style='background-color: #ECFFF4; border-top: 1px solid #8AEC71; padding: 10px;'>
				{$Email_footer_HTML}
			</div>
		</div>";
	$StrTexto['mailCadastroBody'] = "
		Olá, [NOME]  Bem Vindo ao QiEstudo, 
		Vamos ativar sua Conta?

		Para realizar a ativação por favor copie e cole em seu navegador a seguinte url:
		[URL_ATIVAR]
		Caso esteja tendo algum problema ou gostaria de nos ajudar com sua opinião por favor entre em contato, 
		
		{$Email_footer}";


// ============================================== ]

// $StrTexto['sisMsgCadastro_'] = '';



?>