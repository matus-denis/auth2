<?php
session_start();
//	Функция генерации случайной строки
	function generateCode($length) { 
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789"; 
		$code = ""; 
		$clen = strlen($chars) - 1;   
		while (strlen($code) < $length) { 
			$code .= $chars[mt_rand(0,$clen)];   
		} 
		return $code; 
	}
	
function ValidUser($login,$pass,$path) {
        $xmlstring=file_get_contents($path);
        $xml = simplexml_load_string($xmlstring);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
		$name='';		
if (count ($xml)==1){
	if 	($array ['user']['login']==$login
			and $array ['user']['password']==$pass)
			{				
			$r_code = generateCode(15);
			// запись в базу нового значения "code_sess"			
			 $xml->user[$i]->code_sess = $r_code;
			 $xml->user[$i]->user_agent_sess = $_SERVER['HTTP_USER_AGENT'];
			 // сохранение в файл
			$xml->asXML($path);
			/// echo $users->asXML();

			$_SESSION['id_user']=$array ['user']['id_user'];
			$_SESSION['name_user']=$array ['user']['name'];
			$_SESSION['login_user']=$login;	
			//~ ставим куки на 2 недели			
			setcookie("id_user", $array ['user']['id_user'], time()+3600*24*14);
			setcookie("code_user", $r_code, time()+3600*24*14);
			setcookie("name_user", $array ['user']['name'], time()+3600*24*14);			
			$name=$array ['user']['name'];					
			}
}	
else{					
		for ($i=0; $i<count ($array ['user']); $i++)
		{
		if 	($array ['user'][$i]['login']==$login
			and $array ['user'][$i]['password']==$pass)
			{			
			$r_code = generateCode(15);
			// запись в базу нового значения "code_sess"			
			 $xml->user[$i]->code_sess = $r_code;
			 $xml->user[$i]->user_agent_sess = $_SERVER['HTTP_USER_AGENT'];
			 // сохранение в файл
			$xml->asXML($path);			

			$_SESSION['id_user']=$array ['user'][$i]['id_user'];
			$_SESSION['name_user']=$array ['user'][$i]['name'];
			$_SESSION['login_user']=$login;	
			//~ ставим куки на 2 недели
			//setcookie("id_user", $array ['user'][$i]['id_user'], time()+3600*24*14);
			setcookie("id_user", $array ['user'][$i]['id_user'], time()+3600*24*14);
			setcookie("code_user", $r_code, time()+3600*24*14);
			setcookie("name_user", $array ['user'][$i]['name'], time()+3600*24*14);
			//setcookie("code_user", $r_code, time()+3600*24*14);
			$name=$array ['user'][$i]['name'];			
			break;
			}		
		}	
	}		
		return $name;		
    }
	
	
$path="auto.xml";// название файла xml

$xml = simplexml_load_file($path);

//error='';
$login = ($_POST['login']);
$salt='qwsdcvrtfgvb';
$pass=md5($salt.$_POST["password"]); //~ хеш пароля с солью

$nameValUser = ValidUser($login,$pass,$path);

	// Формируем массив для JSON ответа
	
    $result = array(
    	
		'name' => $nameValUser
		
    ); 

    // Переводим массив в JSON
    echo json_encode($result); 
?>