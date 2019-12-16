<?php

/**
 * CASSE ValidarVariavel Clase responsavel por receber valores do usuario atraves do Get ou Post
 * @author Thiago Rodrigues
 * @version 1.0 
**/

class ValidarVariavel extends Tratamentos {
	/**
	 * Recebe o valor da variavel com base no name="" dela, podendo receber parametros o qual a variavel recebida ja é tratada para ser usada no sistema 
	 * Tipos reconhecdos string, int, date.
	 * @param mixed, Recebe o name="" que pode vir por POST ou GET.
	 * @param mixed, Define qual tipo de valor está sendo recebido.
	 * @param boolean, define se quero depurar ou não o valor que está sendo recebido.
	 * @example módos possveis: int | date | string | file | 
	 * @return mixed, ele retorna o valor recebido ja tratado ou false, porem já dando um minimo tratamento para segurança.
	**/
	public function get($var, $type = 'string', $debug = null){
		global $_POST, $_GET; //		
		
		if(isset($_GET[$var])){
			$string = $_GET[$var];
		}
		else if (isset($_POST[$var])) {
			$string = $_POST[$var];
		}
		if($debug){
			new SIS_debug($string, "$var");
		}
		if($type){
			if ($type == 'int') {
				$string = $this -> tratar_int($string);
			}
			elseif ($type == 'date') {
				$string = $this -> tratar_data_br_sql($string);
			}
			elseif ($type == 'file') {
				if($_FILES[$var]['error']== 0){
					$string = $_FILES[$var];					
				}else{
					$string = false;
				}
			}
			elseif ($type == 'array'){
				return $string;
			}
			else{ // Caso não seja int ou data ele vai cair em string....
				$string = $this -> tratar_string($string);
			}			
		}
		else{ // Caso não seja int ou data ele vai cair em string....
				$string = $this -> tratar_string($string);
		}
		return $string;
	}

}

// public function gera_vetor_tratamento_funcoes(){
//         $classes = get_class_methods('tratamento');
//         //echo "<pre>"; var_dump($classes); echo "</pre>";
//         foreach ($classes as  $value) {
//             $array_classes[] = $value;
//         }
//         return $array_classes;
//     }

?>