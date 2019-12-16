<?php

/**
 * Classe de conexão com o banco de dados, 
 * @author Thiago Rodrigues 
 * @version 1.01 
 */
class Connect{

 	private $type;
 	private $host;
 	private $db;
 	private $user;
 	private $pass;
 	private $option;
 	public $pdo;
 	public $login_action = false;

 	function __construct() { 		
	}

	/**
	 * Abre a conexão com o banco de dados 
	 * @param mixed, recebe um vetor o qual vai ser usado para determinar um usupario diferente do determinado em config.php, em texte
	 * @version 0.1
	 * @return mixed retorna o objeto de conexão com o banco pronto para ser utilizado 
	**/
 	public function open(){
 		// Dados de conexão e etc....
 		global $SIS_mysql; 		
 		$this->type = $SIS_mysql['type']; 
 		$this->host = $SIS_mysql['host']; 
 		$this->db = $SIS_mysql['db']; 
 		$this->user = $SIS_mysql['user']; 
 		$this->pass = $SIS_mysql['pass']; 
 		if($this->login_action == false){
	 		$this->option = array(
	 			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',
	 			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET character_set_connection=utf8', 			
	 			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET character_set_client=utf8',
	 			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET character_set_results=utf8',
	 		); 			
 		}	

 		if(!$this->db){echo "<pre> <b>db</b> não foi preenchido corretamente </pre>";}
		if(!$this->user){echo "<pre> <b>user</b> não foi preenchido corretamente </pre>";}
		if(!$this->host){echo "<pre> <b>host</b> não foi preenchido corretamente </pre>";}
		if(!$this->pass){echo "<pre> <b>pass</b> não foi preenchido corretamente </pre>";}
		if(!$this->type){echo "<pre> <b>type</b> não foi preenchido corretamente </pre>";}

	 	// 	// Caso tenha um usuário e senha definido. creio que va ser pouco usado isso aqui.
	 	// 	if(is_array($user_e_pass)){
	 	// 		if(isset($user_e_pass['user'])){
	 	// 			$this -> user = $user_e_pass['user'];
	 	// 		}
	 	// 		if(isset($user_e_pass['pass'])){
	 	// 			$this -> pass = $user_e_pass['pass']; 					
	 	// 		}
	 	// 	}


	 	//Iniciando a Conexão com om Banco de Dados;
 		try {
 			$this->pdo = new PDO("{$this->type}:host={$this->host};dbname={$this->db}", $this->user, $this->pass, $this->option); 			
 		} catch (PDOException $e) {
 			echo "<pre>".$e->getMessage()."</pre>"; 			
 		}
 		return $this->pdo;
  	}

  	/**
  	 * Busca todas as colunas da tebalea e retorna um vetor associativo
  	 * @param string $tablea Recebe o nome da tabela a ser buscada.
  	 * @return array[] Retorna o vetor com todas as colunas da tabela. 
  	*/
  	public function buscaColunasTabela($tabela){
  		// Busca as colunas para um comparação no vetor recebido. evitando possiveis vulnerabilidades.
		$buscaColunas = $this->open()->query("SHOW COLUMNS FROM {$tabela}");
		$colunas = $buscaColunas -> fetchAll();
		foreach ($colunas as $key => $value) {
			$vetor_coluna[] = $value["Field"];
		}
		if(is_array($vetor_coluna)){
			return $vetor_coluna;
		}
  	}
} 

/**
 * Seria uma classe e funçoes para servir e receber as query, desnecessário.
 * @deprecated nunca foi utilizada :) 
 *
*/	
class Query extends Connect
{
	// private $queryString;
	// private $user_e_pass;
	// private $debug;
	public function Select($queryString, $user_e_pass = null, $debug = null ){

		// Gerando Select
		$result = $this->open()->query($queryString);		
		
		return $result;
	}
}

?>