<?php

/**
* Classe que gera logs do sistema como query e etc para auditoria e por segurança da funcionalidade do sistema.
* @package Connect
* @subpackage SisLog
*/
class SisLog extends Connect
{
	private $confLog;
	private $confAdress;
	private $array_server;
	private $id_perfil_log;
	private $query;
	private $adress;
	private $session;
	private $session_info;
	private $adress_info;
	private $server_info;
	private $get_info;
	private $post_info;

	function __construct(){
		$connect = Connect::open();
		$this->conn = $connect;	
		global $SIS_LOG;		
		global $GET_ADRESS_INFO;
		$this->confLog = $SIS_LOG;
		$this->confAdress = $GET_ADRESS_INFO ;
		// Abrindo conexão com o banco de dados.
	}

	/**
	 * Cria e registra no banco de dados as informações de log, os quas são os valores do SERVIDOR, SESSION, GET e POST juntamente com o parametro recebido.  
	 * @param string, recebe valores o salva para futuras consultas
	 * @return Null, esata função a principio não retorna nada. só joga no banco os dados deterninados. 
	**/

	public function create($query = null){
		if($this->confLog){
			$this->id_perfil_log = $_SESSION['sis_user']; // id logado na SESSION
			$this->id_perfil_log = $this->id_perfil_log['id_perfil'];
			$this->query = $query;
			$this->adress = $_SERVER['REMOTE_ADDR'];
			$this->adress_info = $this->getAdressDetails();
			$this->server_info = $this->arrayServer(); // DADOS $_SERVER.
			$this->session_info = $this->allSession(); // dados da $_SESSION
			$this->get_info = $this->allGet();
			$this->post_info = $this->allPost();
			
			// new SIS_debug($this->allPost(), 'allPost');

			$salvaRegistro = $this->conn->prepare("INSERT INTO sis_log (id_perfil, query, adress, adress_info, server_info, session_info, get_info, post_info) VALUES (:id_perfil, :query, :adress, :adress_info, :server_info, :session_info, :get_info, :post_info)");
			$salvaRegistro->bindValue(":id_perfil",$this->id_perfil_log);
			$salvaRegistro->bindValue(":query",$this->query);
			$salvaRegistro->bindValue(":adress",$this->adress);
			$salvaRegistro->bindValue(":adress_info",$this->adress_info);
			$salvaRegistro->bindValue(":server_info",$this->server_info);
			$salvaRegistro->bindValue(":session_info",$this->session_info);
			$salvaRegistro->bindValue(":get_info",$this->get_info);
			$salvaRegistro->bindValue(":post_info",$this->post_info);
			$salvaRegistro->execute();
			// $salvaRegistro->debugDumpParams();
		}
	}

	/**
	 * Gera as informações a serem salvas no banco com realação ao servidor.
	 * @return Retorna o Json de informações do Servidor
	*/
	private function arrayServer(){
		$this->array_server  = array(
			'HTTP_HOST',
			'REMOTE_ADDR',
			'HTTP_USER_AGENT',
			'HTTP_ACCEPT',
			'HTTP_ACCEPT_LANGUAGE',
			'HTTP_ACCEPT_ENCODING',
			'HTTP_REFERER',
			'HTTP_CONNECTION',
			'CONTENT_TYPE',	
			'PATH',		
			'SystemRoot',
			'COMSPEC',
			'PATHEXT',
			'SERVER_NAME',
			'SERVER_ADDR',
			'SERVER_PORT',
			'DOCUMENT_ROOT',
			'SERVER_ADMIN',
			'SCRIPT_FILENAME',
			'REMOTE_PORT',
			'REQUEST_METHOD',
			'QUERY_STRING',
			'PHP_SELF',
			'REQUEST_TIME'
			);

			foreach ($this->array_server as $key => $value) {
				$item_value= $_SERVER["$value"];
				$returnServer["$value"]="$item_value";
			}

			$returnServer = json_encode($returnServer);
			 //    Lista caso exista Erro.
			 // switch (json_last_error()) {
			 //        case JSON_ERROR_NONE:
			 //            echo ' - No errors';
			 //        break;
			 //        case JSON_ERROR_DEPTH:
			 //            echo ' - Maximum stack depth exceeded';
			 //        break;
			 //        case JSON_ERROR_STATE_MISMATCH:
			 //            echo ' - Underflow or the modes mismatch';
			 //        break;
			 //        case JSON_ERROR_CTRL_CHAR:
			 //            echo ' - Unexpected control character found';
			 //        break;
			 //        case JSON_ERROR_SYNTAX:
			 //            echo ' - Syntax error, malformed JSON';
			 //        break;
			 //        case JSON_ERROR_UTF8:
			 //            echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
			 //        break;
			 //        default:
			 //            echo ' - Unknown error';
			 //        break;
   			 //   }
    		return $returnServer;			
	}

	/**
	 * Gera a os valores da SESSAO e insere no Json 
	 * @return Retorna o Json de informações sa Sessão
	 * 
	*/
	private function allSession (){
		 return $returnSession = json_encode($_SESSION);
	}

	/**
	 * Gera a os valores da POST e insere no Json
	 * @return Retorna o Json de informações do Post
	*/
	private function allPost (){
		 return $returnPost = json_encode($_POST);
	}

	/**
	 * Gera a os valores da GET e insere no Json
	 * @return Retorna o Json de informações do Get
	*/
	private function allGet (){
		 return $returnGet = json_encode($_GET);
	}

	/**
	 * Esta função vai no site ipinfo e retorna a localizão do ip do usuário.  
	 * @link http://ipinfo.io/
	 * @return Retorna o Json de informações do do adress informado.
	*/
	private function getAdressDetails(){
		if($this->confAdress){
			$details = file_get_contents("http://ipinfo.io/{$this->adress}/json");
		}
		else{
			$details['ip'] = $this->adress;  
			$details = json_encode($details);
		}
		return $details;
	}
}

?>