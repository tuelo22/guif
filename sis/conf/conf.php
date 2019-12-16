<?php
/**
 * Módulo de configuraçao do sistema.
 * Somente determina os parametros de configuração para funcionalidade do sistema.
 * @author Thiago Rodrigues 
 * @package Config
**/
// ==== Definindo tipo de desevolvimento, Omologação, ou Desevolvimento ou Produção. ===== ]

	// $SIS_local = "depuracao";
	$SIS_local = "homologacao";
	// $SIS_local = "producao";

// ======================================================================================= ]

// ===== LOCAL DE DESEVOLVIMENTO ==== ]

	// $SIS_dev_local = "note";
	$SIS_dev_local = "note_gn";
	// $SIS_dev_local = "note_thiago";
	// $SIS_dev_local = "online";

// ================================== ]

//  ======== LOG DE SISTEMA ========= ]

	//  Ativa ou desativa o Log do Sistema
	$SIS_LOG = true;
	// Ativa ou desativa a informações do ip do cliente. OBS: esta opção pode gerar uma sobrecarga ou lentidão do sistema.
	$GET_ADRESS_INFO = false;

// ================================== ]


// ==========   BANCO DE DADOS   ===============]

	// NOTE do trabalho
	if($SIS_dev_local == "note_gn"){
		$SIS_mysql['db'] = 'descomplica';
		$SIS_mysql['user'] = 'root';
		$SIS_mysql['host'] = '127.0.0.1';
		$SIS_mysql['pass'] = 'susepro';
		$SIS_mysql['type'] = 'mysql';
	}

// =============================================]

// ==== CONFIGURAÇÔES DE UPLOADS PERMITIDOS ====]

$SIS_TypeFile = array(
			'jpg' => 'image/jpeg', 
			'png' => 'image/png',
			'pdf' => 'application/pdf',
			);

// =============================================]


// ========= CONFIGURAÇÔES DE PHPMail ==========]

	// NOTE do trabalho
	if($SIS_dev_local == "note_gn"){
		$SIS_PHPMail['Host'] = 'kamek.neephost.com';
		$SIS_PHPMail['SMTPAuth'] = true;
		$SIS_PHPMail['Username'] = 'sistema@qiestudo.com.br';
		$SIS_PHPMail['Password'] = '1q2w3e#@!';
		$SIS_PHPMail['From'] = 'sistema@qiestudo.com.br';
		$SIS_PHPMail['FromName'] = 'Sistema QiEstudo';
	}
	
	// ONLINE
	if($SIS_dev_local == 'online'){		
		$SIS_PHPMail['Host'] = 'kamek.neephost.com';
		$SIS_PHPMail['SMTPAuth'] = true;
		$SIS_PHPMail['Username'] = 'sistema@qiestudo.com.br';
		$SIS_PHPMail['Password'] = '1q2w3e#@!';
		$SIS_PHPMail['From'] = 'sistema@qiestudo.com.br';
		$SIS_PHPMail['FromName'] = 'Sistema QiEstudo';
	}
// =============================================]

// ============  HTTP URL - PATCH SERVER     ===========]

	if($SIS_dev_local == 'online'){		
		$SIS_HTTP_SERVER = 'http://qiestudo.com.br/';
		$SIS_FILE_PATH = '/home/qiestudocom/public_html/sis/uploads/';
		$SIS_QUEST_FOLDER ='questionario/';
	}
	
	if($SIS_dev_local == 'note_gn'){		
		$SIS_HTTP_SERVER = 'http://localhost:8080/qiestudo/trunk/';
		$SIS_FILE_PATH = 'C:/wamp/www/qiestudo/trunk/sis/uploads/';
		$SIS_QUEST_FOLDER ='questionario/';
	}


// =============================================]


?>