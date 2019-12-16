<?php
/**
* Classe com todas as funções com relação a requisições em Ajax, 
* @author Thiago Rodrigues
* @package Connect
*/
class FuncoesAjax extends Connect
{	
	function __construct(){
		// Abrindo conexão com o banco de dados.
		$connect = Connect::open();
		$this->conn = $connect;	
	}

	/**
	 * Recebe um numero do CEP e retorna um Json com os dados do endereço caso não exista ele não retorna nada.
	 * @param int $cep Recebe o valor a ser buscado.
	 * @return array[] imprime um Json contendo as informações solicitadas 
	*/
	public function consultarCep($cep){
		$reg = simplexml_load_file("http://cep.republicavirtual.com.br/web_cep.php?formato=xml&cep=" . $cep);

		$dados['sucesso'] = (string) $reg->resultado;
		$dados['rua']     = (string) $reg->tipo_logradouro . ' ' . $reg->logradouro;
		$dados['bairro']  = (string) $reg->bairro;
		$dados['cidade']  = (string) $reg->cidade;
		$dados['estado']  = (string) $reg->uf;		 
		echo json_encode($dados);
	}

	/**
	 * Recebe o login digitado no formulário de cadastro e verifica no banco de dados se existe alguma imformação. 
	 * @param string $login Recebe o valor a ser buscado.
	 * @return array[] imprime um Json contendo as informações solicitadas 
	*/
	public function verificarLogin($login){

		if($login){
			$login_test = preg_replace("/[^a-zA-Z0-9_]/", "", $login);
			if(($login_test === $login) && (strlen($login) >= 5)){
				$buscaLogin = $this->conn->prepare("SELECT login_key FROM per_perfil where login_key =:login_key");
				$buscaLogin->bindValue(':login_key', strtolower($login));
				$buscaLogin->execute();
				$quantidade = $buscaLogin->rowCount();
				// Se for 0 quer dizer que não existe no cadastro.
				$estilo['quantidade'] = $quantidade;				
			}
			else{
				$estilo['quantidade'] = 1;	
			}
		}
		else{
			$estilo['quantidade'] = null;
		}		
		echo json_encode($estilo);
	}

	/**
	 * Recebe o login digitado no formulário de cadastro e verifica no banco de dados se existe alguma imformação. 
	 * @param string $email Recebe o valor a ser buscado.
	 * @return array[] imprime um Json contendo as informações solicitadas 
	*/
	public function verificarEmail($email){

		if($email){
			$buscaEmail = $this->conn->prepare("SELECT email FROM per_perfil where email =:email");
			$buscaEmail->bindValue(':email', strtolower($email));
			$buscaEmail->execute();
			$quantidade = $buscaEmail->rowCount();
			// Se for 0 quer dizer que não existe no cadastro.
			$estilo['quantidade'] = $quantidade;
		}
		else{
			$estilo['quantidade'] = null;
		}		
		echo json_encode($estilo);
	}
}

?>