<?php
//session_start();
function ValidUser($id_user,$code_user, $path) {
        $xmlstring=file_get_contents($path);
        $xml = simplexml_load_string($xmlstring);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);	

if (count ($xml)==1){
	if 	($array ['user']['id_user']==$id_user
			and $array ['user']['code_sess']==$code_user
			and $array ['user']['user_agent_sess']==$_SERVER['HTTP_USER_AGENT']){
				$_SESSION['id_user']=$id_user;
				$_SESSION['login_user']=$array ['user']['login'];
				$_SESSION['name_user']=$array ['user']['name'];
				//~ обновляем куки
				//setcookie("id_user", $_SESSION['id_user'], time()+3600*24*140);
				//setcookie("code_user", $code_user, time()+3600*24*14);	
				//setcookie("name_user", $array ['user']['name'], time()+3600*24*14);		
				return true;				
			}	
}
else{		
		for ($i=0; $i<count ($xml); $i++)
		{
		if 	($array ['user'][$i]['id_user']==$id_user
			and $array ['user'][$i]['code_sess']==$code_user
			and $array ['user'][$i]['user_agent_sess']==$_SERVER['HTTP_USER_AGENT'])			
			{
			//~ Данные верны, стартуем сессию
						$_SESSION['id_user']=$id_user;
						$_SESSION['login_user']=$array ['user'][$i]['login'];
						$_SESSION['name_user']=$array ['user'][$i]['name'];
						//~ обновляем куки
						//setcookie("id_user", $_SESSION['id_user'], time()+3600*24*14);
						//setcookie("code_user", time()+3600*24*14);
						//setcookie("name_user", $array ['user']['name'], time()+3600*24*14);		
			return true;			
			}		
		}	
}		
		return false;		
    }
function check() {
		if (isset($_SESSION['id_user']) and isset($_SESSION['login_user'])) return true;
		else {
			//~ проверяем наличие кук
			if (isset($_COOKIE['id_user']) and isset($_COOKIE['code_user'])) {
				//~ куки есть - сверяем с таблицей сессий			
				$id_user=$_COOKIE['id_user'];
				$code_user=$_COOKIE['code_user'];
				$path="auto.xml";// название файла xml (база данных)
				$ValidUser= ValidUser($id_user,$code_user,$path);
				if ($ValidUser)
					return true;				
			} else return false;
		}
	}
/* 
$check=check();



if ($check)
	$r='valid enter';
else $r='';
// Формируем массив для JSON ответа
   $result = array(
   'r' => $r,
  'name' => $_SESSION['name']
    ); 
// Переводим массив в JSON
   echo json_encode($result);  */
?>