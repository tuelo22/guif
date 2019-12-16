<?php


/**
 * Esta classe tem por função receber e determinar o idioma do sistema com base na SESSÃO, 
 * Dentro dessa classe esite o metodo para gear o texto com base no codigo, assim quando for 
 * relizar mudança de idioma ou converter para outro se torna mais facil futuramente 
 * @author Thiago Rodrigues 
 * @package Connect
 * @subpackage String
**/

class String extends Connect
{	
	private $str;	
	private $sis_local;
	function __construct(){
		$this->idioma = $_SESSION['sis_user']['language'];		
		global $SIS_local;
		$strTemp = $SIS_local;
		$this->sis_local = $strTemp;
		if($this->idioma == 'PT-Br'){
			require('text/text_PT-Br.php');
		}
		elseif($this->idioma == 'US-Eng'){
			require('text/text_US-Eng.php');
		}
		else{
			require('text/text_PT-Br.php');
		}
		$this->str = $StrTexto;
		$this->strAlert = $StrAlert;
	}
	
	/**
	 * Exibe com base na chave recebida o texto com o idioma determinado.
	 * @param string, Recebe a chave que tem que ser igual a do ventor de tradução, caso não retorna uma mensagem de erro
	 * @return string, retorna o texto solicitado.
	**/
	function show($key){		
		if($key){
			if(array_key_exists($key, $this->str)){
				return $this->str[$key];
			}
			else{
				if(($this->sis_local == 'depuracao')|| ($this->sis_local == 'homologacao'))
				return "Texto não Encontrado, ou não traduzido [$key]";
			}			
		}
		else{ // caso não tenha nenhum resultado eu não retorno nada.
			return "";
		}
	}

	/**
	 * Recebe a chave do alerta a ser informado também é capas de recer um vetor de alertas a serem informados. 
	 * @param string|array[] $key REcebe o Vetor ou o String chave para exibição do alerta na tela.
	 * @return string| null Retorna o html com a cor já pre determinada no módulo de idioma e exibe na tela. Caso não tenha a chave ela ira retornar null 
	**/
	public function showAlert($key){
		if($key){
			if(is_array($key)){
				$vetor_key = $key;
				foreach ($vetor_key as $key) {
					if(array_key_exists($key, $this->strAlert)){
						// somente se achar algo ele executa o return
						$return_ok = true;
						foreach ($this->strAlert[$key] as $style => $text) {
							if(($style == 'info')|| ($style == 'success')){
								$id = "loginAlertOk";
							}else{
								$id = "loginAlert";
							}
							$html_notification.= "
					            <div id='{$id}' class='alert alert-{$style} alert-dismissible fade in col-md-8 col-md-offset-2 div-alert ' role='alert'>
					              <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					               {$text}
					            </div>    
					    	";		
						}
							
					}
				}
			}
			else{
				if(array_key_exists($key, $this->strAlert)){
					// somente se achar algo ele executa o return
					$return_ok = true;
					foreach ($this->strAlert[$key] as $style => $text) {
						if(($style == 'info')|| ($style == 'success')){
							$id = "loginAlertOk";
						}else{
							$id = "loginAlert";
						}
						$html_notification.= "
				            <div id='{$id}' class='alert alert-{$style} alert-dismissible fade in col-md-8 col-md-offset-2 div-alert ' role='alert'>
				              <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				               {$text}
				            </div>    
				    	";								
					}
				}				
			}
		}
		if($return_ok){
			return $html_notification;
		}
	}
}

?>