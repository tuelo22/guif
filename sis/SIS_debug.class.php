<?php

//     ====     FUNÇÔES DE DESEVOLVIMENTO      ====     

/**
 * Classe SIS_debug, para depuração do sistema. 
**/ 
class SIS_debug {
	/**
	 * Função a qual recebe e retora as informações detalhadas da variavel recebida no teste, como por exemplo tempo de execução, uso de memória, tipo de variáel
	 * @param mixed $variavel  Recebe a variavel, vetor que vai ser debugado, 
	 * @param string $var_name Recebe a variavel e imprime seu respctivo nome.
	 * @param bool Define se vai exexutar um break ou exit no final do debug
	 * @return string, retorna as informações detalhadas da variavel recebida.
	**/

	/** @var string $time Varivel utilizada para armazenar o valor atual do tempo para a determina o tempo de execução da Função SIS_debug */
	public $time;
	
	public function SIS_debug($variavel, $var_name = null, $break = null){	
		global $SIS_local;		
		$var_name = htmlspecialchars($var_name);
		if($SIS_local == "homologacao"){
			if($variavel){
				$this -> startExec();				 				
				echo "<pre style='background-color:#EBEBEB; padding: 3px; border: 1px solid silver; border-radius: 10px; z-index: 100;'>\n"; 
				if($var_name){
					echo "<b>Variavel Recebida:</b> <b style='color: blue;'>$var_name</b><br />";				
				}
				if(!is_object($variavel)){
					echo "<b>Memory:</b>"; echo"<b style='color: green;' >".$this -> sizeofvar($variavel). "</b>";
				}
				echo "<br /><b>Variavel Saida</b>: ";
				strip_tags(var_dump($variavel)); 
				echo "<b>Tempo de Execucao </b> <b style ='color: red;' >".$this -> endExec()."</b>";
				echo"</pre>\n ";						
			}
			else{
				echo"<pre style='background-color:#EBEBEB; padding: 3px; border: 1px solid silver; border-radius: 10px; z-index: 100; '>\n";
				echo "<b>Variavel Recebida:</b> <b style='color: blue;'>$var_name</b> <br><b>Variavel Saida</b>: ";
				echo "<b style ='color: red;'>Null</b> \n";
				echo "</pre>";
			}
			if($break){
				break;exit(); 
			}
		}
	}

	/**
	 * Recebe um numero em bits e tranforma em suas respcivas casas decimais, isso é, kb, mb ...
 	 * @param int $size Recebe o valor em bit
	 * @return retorna o valor na formatado por exemplo em b, Kb, Gb, Tb.
	**/
	private function convert_memory_use($size){
		 $unit=array('b','kb','mb','gb','tb','pb');
    	 return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
	}

	/**
	 * Determina a o tamanho da variavel em Bit.
	 * @param string $var Recebe a varaivel a ser analisada
	 * @return retorna o tamanho da variavel recebida.
	**/
	public function sizeofvar($var) {
	    $start_memory = memory_get_usage();
	    $tmp = unserialize(serialize($var));
	    return $this-> convert_memory_use(memory_get_usage() - $start_memory);
	}

	/**
	 * Obtem o tempo atual do sistema
	 * @return time, retorna o tempo atual do servidor.
	**/
	private function getTime(){
	      return microtime(TRUE);
	   }
	    
    /**
     * Calcula o tempo inicial que a função foi chamada
     * @return null
    **/
	public function startExec(){
	      global $time;
	      $time = $this -> getTime();
	   }
	    
    /**
     * Calcula o tempo de execução da função.
     * @return int Retorna o tempo de execução do script
    **/
	public function endExec(){
	      global $time;      
	      $finalTime = $this->getTime();
	      $execTime = $finalTime - $time;
	      return number_format($execTime, 6) . ' s';
	   }
}
// ================================================ ]

?>