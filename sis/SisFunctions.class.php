<?php
/**
 * Funções de utilização global do sistema, 
 * @author Thiago Rodrigues;
 * @version 1.0;
 * @version Funções.
**/
class SisFuncoes extends Connect
{	
	private $session;
	private $self;
	function __construct(){
		$this->session = $_SESSION['sis_user']['id_tipo_perfil'];
		// Abrindo conexão com o banco de dados.
		$connect = Connect::open();
		$this->conn = $connect;	
		global $SELF;
		$this->self = $SELF;
	}

	/**
	 * Verifica se a requisição da pagina é valida de acordo com o paramatro de secao com relação ao perfil do usuário .
	 * @param string $secao Recebe a secao a ser verificada
	 * @param string $pagina Pagina a ser realizado a verificação isso é, seu parametro.
	 * @param int $nivel Com base nesse nivel que va ser verificado se tem permissão de entrar na pagina em questão, por padrão seu valor é 0 dnado permissão a todos.
	 * @example padrão de validação 0 não logado, 1 logado usuário comum, 2 colaborador, 3 administrador.
	 * @return bool Caso tenha permissão ele ira retornar true caso não false.
	**/
	public function verificaPermissaoSecao($secao, $pagina, $nivel = 0){
		// verificando se as variaves foram preenchidas.
		if($secao == $pagina){
			// verificando os niveis de permissão
			if($this->session >= $nivel) {
				return true;
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	}

	/**
	 * Verifica se o arquivo é permitido com base no binario dele.
	 * Podendo receber uma string para limitar a 1 file, array para varios tipo de arquivos e por fim nulo verificando se está na listagem global de permissões
	 * @param file[] $file Aquivo a ser verificado.
	 * @param array[] | string | null Recebe o delimitador de arquivos permitidos, 
	 * @return bool Retorna true para o aruivo valido e false para aquivo não valido. 
	**/
	public function checkTypeFile($file, $type = null){
		global $SIS_TypeFile;
		$arrayType = $SIS_TypeFile;
		$binType = $file['type'];
		if(is_array($file)){
			if($type){
				if(is_array($type)){
					$key = array_search($binType, $arrayType);
					if($key){
						if(in_array($key, $type)){
							return true;
						}else{
							return false;
						}
					}else{
						return false;
					}
				}else{
					if($binType == $arrayType[$type]){
						return true;
					}else{
						return false;
					}
				}
			}else{
				if(in_array($binType, $arrayType)){
					return true;
				}else{
					return false;
				}
			}
		}else{
			return false;
		}
	}
	
	/**
	 * Gera um option com base na tabela determinada somente é necessário passar o nome da tablea e caso esteje selecionado o id do mesmo.
	 * @param string $tabela Recebe o nome da tabela a qual vai ser gerado os Options.
	 * @param int $selecionado quando o valor é recebido ele deixa o <option> ja elecionado.
	 * @return string Retorna a listagem de Option.
	**/
	public function geraOptions($tabela, $selecionado = null){
		// Peando a chave primaria para o value do Option
		$buscarChavePrimaria = $this->conn->query("SHOW COLUMNS FROM {$tabela}");
		if(is_object($buscarChavePrimaria)){
			$vertor_colunas = $buscarChavePrimaria->fetchAll();
			foreach ($vertor_colunas as $value) {
				if($value['Key'] == 'PRI' ){
					$primary_key = $value['Field'];
				}
			}
			$buscarOptions = $this->conn->query("SELECT $primary_key as chave_primaria, nome FROM {$tabela}");
			$vetor_options = $buscarOptions->fetchAll(PDO::FETCH_ASSOC);
			$html_options= "<option> Selecione </option>";
			foreach ($vetor_options as $option){
				if($selecionado == $option['chave_primaria']) : $html_selecionado = 'selected'; endif;
				$html_options.="<option {$html_selecionado} value='{$option['chave_primaria']}'>{$option['nome']}</option>\n";
				unset($html_selecionado);
			}
			if($html_options){
				return $html_options;			
			}					
		}
	}

	/**
	 * Gera o Grid de informações para inicialmente qualquer tipo de tabela ou informação. 
	 * @param string $tabela Tabela para qual vai ser gerado o Grid,
	 * @param array[] $vetorColunas Recebe a chave o nome da Coluna no Banco e o valore Recebido é o nome o qual ira aparecer na tela
	 * @param array[] | null $vetorFiltro Recebe caso aja o Vetor com os Filtros para busca.
	 * @param string | null $busca Recebe um paramatro para ser realizado uma busca no sistema.
	 * @param string | null $fatorExclusao Fator Exclusão determina um fator de exclusão receber um valor para determnar um WHERE na listagem.
	 * @param string | null $acaoEditar Determina a ação do Caminho para o botao Editar
	 * @param string | null $acaoExcluir Determina a ação do Caminho para o botao Exluir
	 * @param string | null $mensPerExclusao Determina a mensagem de Exclusão personalizada
	 * @return Retorna o Grid com cabesalho e body OBS. não é retornado a tag <table>.
	**/
	public function geraGrid($tabela, $vetorColunas, $vetorFiltro = null, $busca = null, $fatorExclusao = null, $acaoEditar = null, $acaoExcluir = null, $mensPerExclusao = null){

		// Gerando O vetor de colunas existentes Colunas, e sua chave primaria
		$buscarColunas = $this->conn->query("SHOW COLUMNS FROM {$tabela}");
		if(is_object($buscarColunas)){
			$vertor_colunas_temp = $buscarColunas->fetchAll(PDO::FETCH_ASSOC);
			foreach ($vertor_colunas_temp as $value) {				
				$vertorColunasBanco[] = $value['Field'];
				if($value['Key'] == 'PRI' ){
					$primary_key = $value['Field'];
				}				
			}
			// Gerando o Cont para remover o" , " Posso MELHORAR #PENDENTE
			foreach ($vetorColunas as $contColuna => $nome ) {
				if(in_array($contColuna, $vertorColunasBanco)){
					$quant_itens++;					
				}
			}			
			// Verificando a veracidade dos dados Recebidos e gerando a query para gerar o Grid
			foreach ($vetorColunas as $coluna => $nomeColuna) {
				$count_itens++;				
				if(in_array($coluna, $vertorColunasBanco)){
					if($quant_itens != $count_itens ){
						$v = ", ";
					}
					$colunasQuery.="$coluna{$v}";
					$htmlCabesalho.="<th>$nomeColuna</th>"; 
				}
				unset($v);
			}
			$html_return.="<thead><tr>$htmlCabesalho</tr></thead>";

			// Adicionando o fator de Exclusão
			if($fatorExclusao){
				$query_exclusao = "WHERE $fatorExclusao";
			}
			

			// new SIS_debug($colunasQuery, '$colunasQuery Colunas da Busca');
			// new SIS_debug($htmlCabesalho, '$htmlCabesalho Cabesalhos');			
			// new SIS_debug("SELECT {$colunasQuery}, $primary_key FROM {$tabela} {$query_exclusao}", "Depurando Query");
			$gerandoGrid = $this->conn->query("SELECT {$colunasQuery}, $primary_key FROM {$tabela} {$query_exclusao} ");
			$arrayGrid = $gerandoGrid->fetchAll(PDO::FETCH_ASSOC);
			// echo $gerandoGrid->rowCount(); break;
			$html_return.="<tbody class='table-body'>";
			foreach ($arrayGrid as $linhaColuna) {
				$html_return.="<tr>";
				foreach ($linhaColuna as $nome_coluna => $valorColuna) {
					if($nome_coluna != $primary_key ){ // para aparecer o nome tem que ser direfente da chave primaria
						$html_return.="<td>{$valorColuna}</td>";						
					}
					else{
						$html_key_coluna = $nome_coluna;
						$html_value_key_coluna = $valorColuna;
					}
				}
				// Alterar e Excluir.
				if(($acaoEditar)||($acaoExcluir)){
					$html_return.="<td>";
					if($acaoEditar){
						$html_return.="<a href='{$this->self}?{$acaoEditar}&{$html_key_coluna}={$html_value_key_coluna}'>
					    				<button class='btn btn-info btn-sm'>
					    					<span class='glyphicon glyphicon-edit'></span>    				
					    				</button>
					    				</a>";						
					}
					if($acaoExcluir){
						if(!$mensPerExclusao){
							$html_mensagem_exclusao = "Realmente Deseja excluir este item ?";							
						}
					   	$html_return.="
					    				<button data-toggle='modal' data-target='.huehue_{$html_value_key_coluna}' class='btn btn-danger btn-sm'>
					    					<span class='glyphicon glyphicon-remove'></span>    					
					    				</button>						    			
										<div class='modal fade huehue_{$html_value_key_coluna}' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true'>
										  <div class='modal-dialog modal-sm'>
										    <div class='modal-content'>
										    	<div class='modal-header'>
										    		<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
										    		<h4 class='modal-title'>Excluir</h4>
										    	</div>
										    	<div class='modal-body' >
										    		<p>$html_mensagem_exclusao</p>
										    	</div>
										    	<div class='modal-footer' >
													<button type='button' class='btn btn-default' data-dismiss='modal'>Cancelar</button>
        											<a href='{$this->self}?{$acaoExcluir}&{$html_key_coluna}={$html_value_key_coluna}'>
        												<button type='button' class='btn btn-danger'><span class='glyphicon glyphicon-trash' > </span> Excluir</button>
        											</a>
										    	</div>										     
										    </div>
										  </div>
										</div>
						    			";						
					}
					$html_return.="</td>";
				}
				$html_return.="</tr>";
			}
			$html_return.="</tbody>";
			return $html_return;
		}else{
			return "Banco não Encontrado";			 
		}
	}


	/**
	 * 
	**/
	public function storageFile($file, $folder){
		
		
	}
}

?>