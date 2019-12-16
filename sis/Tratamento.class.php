<?php

/**
* Esta classe somente vai ser usada na outra classe chamada "validar_variavel", pois ela quem vai utlizar as funções 
* da classe "tratamentos" e organizar, os valores recebidos.
* 
**/

/**
* Esta classe vai ter função de somente tratar valores conforme for sendo necessário
* Patrão de criação de Função:
* 1) iniciar pela palavrar "tratar", 
* 2) segunda palavra o tipo de campo isto é para funções não exclusivas mais vamos seguir esse padrão, quando for só esse elemeto ele trata para o tipo determinado, int, string etc...
* 3) De, isso é o tipo de dado que vai er recebido, 
* 4) Para o dado de destino.
**/
class Tratamentos {

	public $result;

	/**
	 * Recebe Data nor formato sql ou Br descobre o formado recebido e tranforma a data no patrão sql, EUA.
	 * Também é raalizado a verificação de a data é uma data valida
	 * @param string, Recebe uma data no formato BR ou SQL ,  
	 * @return date|null, retorna da data no formato SQL, caso a data não seja uma data valida é retornado null
	**/
	public function tratar_data_br_sql ($string){
		// retirando os espaços. 
		$string = trim($string);
		// modificando os itens para somente traço, tudo qu for difernte de numero ele tranforma em traço ;*		
		$string = preg_replace( "/[^0-9]/i", "-", $string );
		// trasnformando em vetor
		$vet_string = explode("-", $string);
		foreach ($vet_string as $key => $value) {			
			if(strlen($value) == 4){
				if($key == 0){ // se for 0 que dizer que chegou no padrão EUA AAAA/mm/dd
					if(checkdate($vet_string[1], $vet_string[2], $vet_string[0])){
						$data_saida = $vet_string[0]."-".$vet_string[1]."-".$vet_string[2];						
					}
				}
				if($key == 2 ){ // se for 2 quer dizer que chegou no padrão BR dd/mm/aaaa
					if(checkdate($vet_string[1], $vet_string[0], $vet_string[2])){
						$data_saida = $vet_string[2]."-".$vet_string[1]."-".$vet_string[0];					
					}
				}
			}			
		}
		return $this->result=$data_saida;
	}
	/**
	 * Recebe a data no formato SQL, isso é, formato americano 9999-99-99 (ano-mes-dia) e formata para o padrao BR
	 * @param date $data Receba a data a qual ira ser tratada.
	 * @return string Retorna a data no formato PT-Br
	**/
	public function tratar_data_sql_br($data){
		if($data){
			$array_data = explode('-', $data);
			$data_tratada_br = $array_data[2]."/".$array_data[1]."/".$array_data[0];
			return $data_tratada_br;
		}
	}

	/**
	 * Recebe os valores e lima todos os dados que não seja numeros, 
	 * @example Aeiou~123~!@#$%... dentre outros.
	 * @param int, deveria receber um nunero, 
	 * @return int, retorna somente o valor inteiro.
	**/
	public function tratar_int($int){
		$int = trim($int);
		$int = preg_replace("/[^0-9]/i","", $int);
		return $this->result=$int;
	}

	/**
	 * Retira todas as tags em HTML e espaços antes e depois do valor recebido. 
	 * @param mixed, $string recebe uma string. sem tratamento algum.
	 * @return string, retorna valores sem formatações e espaços
	**/

	public function tratar_string($string){
		$string = trim($string);
		// if($this->getCodificacao($string) == 'UTF-8'){
		// 	$string = utf8_encode(htmlspecialchars($string, ENT_QUOTES));
		// }
		// else{
			$string = utf8_decode(htmlspecialchars($string, ENT_QUOTES));
		// }
		// $string = utf8_decode(addslashes($string));
		return $this->result=$string;
	}

	private function getCodificacao($string){
		return mb_detect_encoding($string.'x', 'UTF-8, ISO-8859-1');
	}
	
		
}

?>