<?php
/**
 * Moódulo de cotrole de Questionários, como cadastro atualização cadatro deperguntas e etc...
 * @author Thiago Rodrigues;
 * @package Connect;
 * @version 1.0;
 * @category Questionários;
**/

class Questionarios extends Connect
{	
	function __construct(){
		// Abrindo conexão com o banco de dados.
		$connect = Connect::open();
		$this->conn = $connect;	
		$this->log = new SisLog();
	}

	/**
	 * Cadatra o os questionários no Banco, 
	 * Segue o mesmo padrão de cadastro de Usuários, recebe um vetor com todas as informações para ser adicionado ao sistema.
	 * @param array[] $vetorDadosQuestionario Recebe o vetor a ser adicionado no  Banco de dados
	 * @return bool true para quando for salvo corretamente, false quando não for salvo.
	**/
	public function cadastarQuestionarios($vetorDadosQuestionario){		
		
		$vetor_coluna = $this->buscaColunasTabela('que_questionario');

		// trabalhando com o vetor recebido, e gerando a Query Dinamica
		$quant_itens = count($vetorDadosQuestionario);
		foreach ($vetorDadosQuestionario as $key => $value){
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
		// Query para inccerir os valores no banco.
		$insertQuestionario = $this->conn->prepare("INSERT INTO que_questionario ($set) VALUES ($set_value)");
		// Preparando os valores 
		foreach ($vetorDadosQuestionario as $colun => $valor_item) {
			if(in_array($colun, $vetor_coluna)){
				$insertQuestionario->bindValue(":$colun", $valor_item);
			}
		}
		$return_execute = $insertQuestionario->execute();

		if($return_execute){
			return true;
		}
		else{
			return false;
		}
	}

	/**
	 * Cadatra o os questionários no Banco, 
	 * Segue o mesmo padrão de cadastro de Usuários, recebe um vetor com todas as informações para ser adicionado ao sistema.
	 * @param array[] $vetorDadosQuestionario Recebe o vetor a ser adicionado no  Banco de dados
	 * @return bool true para quando for salvo corretamente, false quando não for salvo.
	**/
	public function atualizarQuestionarios($vetorDadosQuestionario){
		
		global $SIS_FILE_PATH, $SIS_QUEST_FOLDER;
		new SIS_debug($vetorDadosQuestionario, 'vetorDadosQuestionario');

		$vetor_coluna = $this->buscaColunasTabela('que_questionario');

		$id_questionario = $vetorDadosQuestionario['id_questionario'];
		unset($vetorDadosQuestionario['id_questionario']);
		// trabalhando com o vetor recebido, e gerando a Query Dinamica
		$quant_itens = count($vetorDadosQuestionario);
		foreach ($vetorDadosQuestionario as $key => $value){
			$count_itens++;
			if($quant_itens != $count_itens ){
				$v = ", ";
			}
			if(in_array($key, $vetor_coluna)){
				$set = "$key";
				$set_value =":$key{$v}";	
				$query_values.="{$set} = {$set_value}";				
			}
			unset($v);
		}
		// trbalhando com o arquivo enviado 
		$file = $vetorDadosQuestionario['img_questionario'];
		
		if($file['error'] == 0){

			$ext = explode(".", $file['name']);
			$newFileName = "{$file['name']}";
			$destFile = "{$SIS_FILE_PATH}{$SIS_QUEST_FOLDER}{$newFileName}";
			// new SIS_debug($destFile , '$destFile ', true);
			if(move_uploaded_file($file['tmp_name'], $destFile)){
				$vetorDadosQuestionario['img_questionario'] = $newFileName;
			}
		}
		// new SIS_debug($vetorDadosQuestionario, 'vetorDadosQuestionario', true );

		// Query para inccerir os valores no banco.
		$insertQuestionario = $this->conn->prepare("UPDATE que_questionario SET {$query_values} WHERE id_questionario = :id_questionario");
		// new SIS_debug("UPDATE que_questionario {$query_values}", 'query update', true);
		// Preparando os valores 
		foreach ($vetorDadosQuestionario as $colun => $valor_item) {
			if(in_array($colun, $vetor_coluna)){
				$insertQuestionario->bindValue(":$colun", $valor_item);
			}
		}
		// id Questionario.
		$insertQuestionario->bindValue(":id_questionario", $id_questionario);
		$return_execute = $insertQuestionario->execute();

		if($return_execute){
			return true;
		}
		else{
			return false;
		}
	}

	/**
	 * Função utilizada para Exclusão dos Questionarios e suas Respecitvas perguntas e Opções de Resposta
	 * @param int $id_questionario Recebe o id do questionário o qual vai ser Excluido.
	 * @return bool true para quando for salvo corretamente, false quando não for salvo.
	**/
	public function excluirQuestinario($id_questionario){
		try{
			$excluirQuestinario = $this->conn;
			$excluirQuestinario->beginTransaction();

			// Excluundo Opção Respostas
			$opcaoResposta = $excluirQuestinario->prepare("DELETE FROM que_opcao_resposta WHERE id_pergunta IN (SELECT id_pergunta FROM que_pergunta WHERE id_questionario = :id_questionario)");
			$opcaoResposta->bindValue(':id_questionario', $id_questionario);
			$returnTransacton['opcaoResposta'] = $opcaoResposta->execute();

			// Excluindo perguntas 
			$pergunta = $excluirQuestinario->prepare("DELETE FROM que_pergunta WHERE id_questionario= :id_questionario");
			$pergunta->bindValue(':id_questionario', $id_questionario);
			$returnTransacton['pergunta'] = $pergunta->execute();

			// Excluindo Questionario
			$questionario = $excluirQuestinario->prepare("DELETE FROM que_questionario WHERE id_questionario = :id_questionario");
			$questionario->bindValue(':id_questionario', $id_questionario);
			$returnTransacton['questionario'] = $questionario->execute();
			// new SIS_debug($id_questionario, 'id_questionario');
			// new SIS_debug($returnTransacton, 'returnTransacton', true);
			if(is_array($returnTransacton)){
				if(in_array(false, $returnTransacton)){
					$this->log->create(json_encode($returnTransacton)."Erro na Exclusao");					
					return $result = false;
				}else{ // Caso não tenha erro ele salva normalmente				
				return $result = $excluirQuestinario->commit();				
				}
			}
		}
		catch(Exception $e) {
			echo "<pre>".$e->getMessage()."</pre>";
			$excluirQuestinario->rollBack();			
		}

		// new SIS_debug($returnTransacton, 'returnTransacton');

		
		// new SIS_debug($result, 'result');
		// // $excluindo_questionario = $excluirQuestinario->prepare();
		// // $excluindo_questionario->bindValue(':id_questionario', $id_questionario);
	}

	/**
	 * Cadatra o as perguntas no Banco para o eusqetionário em questão, 
	 * Segue o mesmo padrão de cadastro de Usuários, recebe um vetor com todas as informações para ser adicionado ao sistema.
	 * @param array[] $vetorDadosPerguntaQuestionario Recebe o vetor a ser adicionado no Banco de dados
	 * @return bool true para quando for salvo corretamente, false quando não for salvo.
	**/
	public function cadastarPerguntasQuestionarios($vetorDadosPerguntaQuestionario){

		// $vetor_coluna = $this->buscaColunasTabela('que_pergunta');

		// new SIS_debug($vetorDadosPerguntaQuestionario, 'vetorDadosPerguntaQuestionario', true);
		// verificação basica
		if(is_array($vetorDadosPerguntaQuestionario)){
			// Separando oerguntas de Opções de Resposta
			foreach ($vetorDadosPerguntaQuestionario as $key_pergunta => $dados_perguntas) {
				if(!is_array($dados_perguntas)){
					$vetorPergunta[$key_pergunta] = $dados_perguntas;					
				}else{// Vetor de Opcão de Resp
					foreach ($dados_perguntas as $key_opcao => $dados_opcao_resp) {
						if($opcaoCorreta == $key_opcao){ // deteminando a opção correta.
							$vetorOpcaoResposta[$key_opcao]['correta'] = '1';
						}else{
							$vetorOpcaoResposta[$key_opcao]['correta'] = '0';
						}
						$vetorOpcaoResposta[$key_opcao][$key_pergunta] = $dados_opcao_resp;
					}
				}
			}
		}
		// new SIS_debug($opcaoCorreta, 'opcaoCorreta');
		new SIS_debug($vetorPergunta, 'vetorPergunta');
		// new SIS_debug($vetorOpcaoResposta, 'vetorOpcaoResposta', true);
		if(!$vetorPergunta['id_questionario']){
			return false;
		}
		try{
			$transactionCadastarPergunta = $this->conn;
			$transactionCadastarPergunta->beginTransaction();
			// Perguntas 
			$cadastraPergunta = $transactionCadastarPergunta->prepare("INSERT INTO que_pergunta (id_questionario, pergunta, id_tipo_pergunta, id_sub_tipo_pergunta, ordem_pergunta, opcao_correta) VALUES (:id_questionario, :pergunta, :id_tipo_pergunta, :id_sub_tipo_pergunta, :ordem_pergunta, :opcao_correta) ");
			$cadastraPergunta->bindValue(':id_questionario', $vetorPergunta['id_questionario']);
			$cadastraPergunta->bindValue(':pergunta', $vetorPergunta['pergunta']);
			$cadastraPergunta->bindValue(':id_tipo_pergunta', $vetorPergunta['id_tipo_pergunta']);
			$cadastraPergunta->bindValue(':id_sub_tipo_pergunta', $vetorPergunta['id_sub_tipo_pergunta']);
			$cadastraPergunta->bindValue(':ordem_pergunta', $vetorPergunta['ordem_pergunta']);
			$cadastraPergunta->bindValue(':opcao_correta', $vetorPergunta['opcao_correta']);
			$returnTransacton['pergunta'] = $cadastraPergunta->execute();			
			// Pegando Dados Pergunta
			$lastIdPergunta =  $transactionCadastarPergunta->lastInsertId();
			// Opcação Resosta 
			foreach ($vetorOpcaoResposta as $row => $valor) {
				// new SIS_debug($valor, 'valor');
				// new SIS_debug($lastIdPergunta, 'lastIdPergunta');
				// new SIS_debug($valor['array_opcao_respota_questionario'], 'array_opcao_respota_questionario');
				// new SIS_debug($valor['correta'], 'correta');
				// new SIS_debug($valor['array_ordem_opcao_respota'], 'array_ordem_opcao_respota');

				$cadastrarOpcaoResposta = $transactionCadastarPergunta->prepare("INSERT INTO que_opcao_resposta (id_pergunta, resposta, ordenacao) VALUES (:id_pergunta, :resposta, :ordencao)");
				$cadastrarOpcaoResposta->bindValue(':id_pergunta', $lastIdPergunta);
				$cadastrarOpcaoResposta->bindValue(':resposta', $valor['array_opcao_respota_questionario']);
				$cadastrarOpcaoResposta->bindValue(':ordencao', $valor['array_ordem_opcao_respota']);
				$returnTransacton["opcao_respota_{$row}"] = $cadastrarOpcaoResposta->execute();
			}

			if(is_array($returnTransacton)){
				if(in_array(false, $returnTransacton)){
					$this->log->create(json_encode($returnTransacton)."Erro na Exclusao");					
					return $result = false;
				}else{ // Caso não tenha erro ele salva normalmente				
				return $result = $transactionCadastarPergunta->commit();				
				}
			}
		}
		catch(Exception $e) {
			echo "<pre>".$e->getMessage()."</pre>";
			$excluirQuestinario->rollBack();			
		}
	}	


	/**
	 * 
	**/
	public function atualizarPerguntasQuestionarios($vetorDadosPerguntaQuestionario){

	}

	/**
	 * Função utilizada para Exclusão de pergunta e suas Respecitvas Opções de Resposta
	 * @param int $id_pergunta Recebe o id da pergunta a qual vai ser Excluida.
	 * @return bool true para quando for salvo corretamente, false quando não for salvo.
	**/
	public function excluirPergunta($id_pergunta){
		// new SIS_debug($id_pergunta, 'id_pergunta', true);
		try{
			$excluirPergunta = $this->conn;
			$excluirPergunta->beginTransaction();

			// Excluundo Opção Respostas
			$opcaoResposta = $excluirPergunta->prepare("DELETE FROM que_opcao_resposta WHERE id_pergunta = :id_pergunta");
			$opcaoResposta->bindValue(':id_pergunta', $id_pergunta);
			$returnTransacton['opcaoResposta'] = $opcaoResposta->execute();

			// Excluindo perguntas 
			$pergunta = $excluirPergunta->prepare("DELETE FROM que_pergunta WHERE id_pergunta = :id_pergunta");
			$pergunta->bindValue(':id_pergunta', $id_pergunta);
			$returnTransacton['pergunta'] = $pergunta->execute();			
			// new SIS_debug($id_pergunta, 'id_pergunta');
			// new SIS_debug($returnTransacton, 'returnTransacton', true);
			if(is_array($returnTransacton)){
				if(in_array(false, $returnTransacton)){
					$this->log->create(json_encode($returnTransacton)."Erro na Exclusao");					
					return $result = false;
				}else{ // Caso não tenha erro ele salva normalmente				
				return $result = $excluirPergunta->commit();				
				}
			}
		}
		catch(Exception $e) {
			echo "<pre>".$e->getMessage()."</pre>";
			$excluirQuestinario->rollBack();			
		}

		// new SIS_debug($returnTransacton, 'returnTransacton');

		
		// new SIS_debug($result, 'result');
		// // $excluindo_questionario = $excluirQuestinario->prepare();
		// // $excluindo_questionario->bindValue(':id_questionario', $id_questionario);
	}

	/**
	 * Busca no nome do Questionário em com base no id em questão 
	 * @param int $id_questionario Recebe o id o qual será realizado a busca no banco de dados
	 * @return string Retorna a string com base no parametro recebido.
	**/
	public function buscaNomeQuestionario($id_questionario){

		if(!$id_questionario){
			return false;
		}
				
		$buscaNomeQuestionario = $this->conn->prepare("SELECT nome_questionario, DATE_FORMAT(data_cadastro, '%Y') as ano FROM que_questionario WHERE id_questionario = :id_questionario");
		$buscaNomeQuestionario -> bindValue(':id_questionario', $id_questionario);
		$execute = $buscaNomeQuestionario -> execute();
		if($execute){
			$row = $buscaNomeQuestionario-> fetch(PDO::FETCH_ASSOC);
			if(is_array($row)){
				return $row['nome_questionario']." - ". $row['ano'];
			}
		}
	}

	
}
?>