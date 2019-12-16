<?php

/**
 * Módulo para aglomerar e trabalhar todas as configurações determinada em config.php, juntamente com todos os require's de todos os outros módulos.
 * @author Thiago Rodrigues.
*/

// ==  Iniciando a SESSÂO == ]
	ob_start(); // agra tenho que ter certesa do que isso faz.
	session_start();
// ========================= ]

//     ====     REQUIRES     ====       ]   
	// ARQUIVO DE CONFIGURAÇÃO
	require("conf/conf.php");  

	// PHPMail classe para envio de email;
	require_once("phpmailer/PHPMailerAutoload.php");

	// MÓDULO com a classe de depuração do sistema
	include_once("SIS_debug.class.php");

	// MÓDULO DE FUNÇÕES DE TRATAMENTO
	include_once("Tratamento.class.php"); 
	
	// MÓDULO com a classe para recebimento de valores externos
	include_once("ValidarVariavel.class.php");

	// MÓDULO DE FUNÇÕES DE CONEXÃO COM O BANCO E SUAS FUNCIONALIDADES
	require("Mysql.class.php");

	// MÓDULO COM A CLASSE PARA ENTRADA NO SISTEMA E VALIDAÇÃO DOS MESMOS, RECUPERAR, SENHA E ATUALIZAR;
	require("Usuario.class.php");

	// MÓDULO QUE DEFINE E CARREGA OS VALORES DE ACORDO COM A LINGUAGEM DO SITE
	require_once("idioma.class.php");

	// MÓDULO COM A CLASSE QUE GERA LOGS COM BASE NO USUÁRIO E ETC.
	require_once("SisLog.class.php");

	// MÓDULO FUNÇÕES GLOBAIS DO SISTEMA
	require_once("SisFunctions.class.php");

	// MÓDULO DE CONTROLE DOS QUESTIONÁRIOS
	require_once("Questionario.class.php");

	// MÓDULO DE FUNÇÔES FUNÇÔES AJAX
	require_once("SisAjax.class.php");

// =================================== ]


// ======= VARIAVEIS DE AMBIENTE ======= ]

	$SELF = $_SERVER['PHP_SELF'];

// ===================================== ]


// ======= VARIAVEIS DE SISTEMA ======= ]

	//CLASSE PARA RETORNO DE TEXTO
	$str = new String;
	// CLASSE PARA GERAÇÃO DE LOG DE SISTEMA.
	$log = new SisLog;

// ==================================== ]

//     ======    LOG ERROS     ======     ] 

	if($SIS_local == 'homologacao'){
		error_reporting(E_ALL ^ E_NOTICE);
		ini_set("display_errors", 1 );
	}
	elseif($SIS_local == 'depuracao'){
		error_reporting(E_ALL | E_STRICT ^ E_NOTICE );
		ini_set("display_errors", 1 );
	}
	else{ // Sem exibição de erro algum.
		error_reporting(0);
		ini_set("display_errors", 0 );
	}
// ====================================== ]

// ========= Definição de Header ======== ]
	
	// header( 'Content-Type: text/html; charset=utf-8' );

// ====================================== ]


?>