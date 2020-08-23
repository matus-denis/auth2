<?php
//session_start();
// проверка свободного логина или email
function ValidLoginEmail($login,$email) {
        $xmlstring=file_get_contents("auto.xml");
        $xml = simplexml_load_string($xmlstring);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
		$array_login = array();
		$array_email = array();
		if (count ($xml)==1)
		{
			$array_login [0]= $array ['user']['login'];
			$array_email [0] = $array ['user']['email'];
		}
		else
		{
			for ($i=0; $i<count ($xml); $i++)
			{
			$array_login [$i] = $array ['user'][$i]['login'];
			$array_email [$i] = $array ['user'][$i]['email'];
			}
		}
		if (in_array($login, $array_login)|| in_array($email, $array_email))
		return false;
	else 
		return true;     
    }
	
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
	// функция вычисляет количество пользователей в базе
	function last_id_user ($path) { 
		$xmlstring=file_get_contents($path);
        $xml = simplexml_load_string($xmlstring);       	
		$last_id_user=count ($xml);// количество пользователей в базе		
		return $last_id_user;
	}

// =======сохранение данных о пользователе в базу данных=====//
if (isset($_POST["login"])
	and isset($_POST["password"])
	and isset($_POST["email"])
	and isset($_POST["name"]))
{

	$valLogMail=ValidLoginEmail($_POST["login"],$_POST["email"]);

	if ($valLogMail){
		$error ='';
		$path="auto.xml";// название файла базы данных(xml)
		$id_user=last_id_user ($path)+1;	
		$xml = simplexml_load_file($path);
		$user_xml = $xml->addChild('user');
		$user_xml->addChild('id_user', $id_user);
		$user_xml->addChild('login', $_POST["login"]);
		$salt='qwsdcvrtfgvb';
		$pass=md5($salt.$_POST["password"]);
		$user_xml->addChild('password', $pass);
		$r_code = generateCode(15);
		$user_xml->addChild('code_sess', $r_code);		
		$user_xml->addChild('user_agent_sess', $_SERVER['HTTP_USER_AGENT']);
		$user_xml->addChild('email', $_POST["email"]);
		$user_xml->addChild('name', $_POST["name"]);
		// сохранение в файл
		$xml->asXML($path);
	}
	else 
		$error="пользователь с таким логином или email уже существует";
	// ==========================================================//

	//====вывод информации о добавленном пользователе==========//
	
		// Формируем массив для JSON ответа
		$result = array(
			'login' => $_POST["login"],
			'password' => $_POST["password"],
			'email' => $_POST["email"],
			'name' => $_POST["name"],
			'error'=> $error
		); 

		// Переводим массив в JSON
		echo json_encode($result); 

	// ==========================================================//
}
?>