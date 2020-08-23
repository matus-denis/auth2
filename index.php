<?php
session_start();
?>
<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Манао</title>
  
<script type="text/javascript" src="jquery-3.2.1.min.js"></script>  
<!--  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>-->
  <script src="ajax.js"></script>
</head>

<body>
<?php
$r='';
include_once 'check.php';
$check=check();
//print $check;
//print $_SESSION['name_user'];
if (isset($_SESSION['name_user']))
$r.='<span style="color:red">HELLO  </span> '.$_SESSION['name_user'].'<br/>';
else
{
$r.='
<div id="content">
<p>РЕГИСТРАЦИЯ</p>
    <form name="registration" method="post" id="form_reg" action="" >
        <input type="text" name="login" placeholder="login" />
			<span style="color:red" id="loginf"></span><br>
        <input type="password" name="password" placeholder="password" />
			<span style="color:red" id="passwordf"></span><br>
		<input type="password" name="confirm_password" placeholder="confirm_password" />
			<span style="color:red" id="confirm_passwordf"></span><br>
		<input type="email" name="email" placeholder="email" />	
			<span style="color:red" id="emailf"></span>		<br>
		<input type="text" name="name" placeholder="name" />
			<span style="color:red" id="namef"></span><br>
	    <input type="button" id="btn_reg" value="Отправить" />
    </form>
    <br>
    <div id="result_form"></div> 
<p>АВТОРИЗАЦИЯ</p>	
	<form name="authorization" method="post" id="form_auth" action="" >
        <input type="text" name="login" placeholder="login" />
			<span style="color:red" id="loginf"></span><br>
        <input type="password" name="password" placeholder="password" />
			<span style="color:red" id="passwordf"></span><br>		
        <input type="button" id="btn_auth" value="Отправить" />		
    </form>
    <br>  
	 <div id="result_form2"></div> 
</div> 
';
}
print $r;
?>
</body>
</html>