//============проверка условий заполнения формы регистрации=================//
function validate(){
   //значения из полей формы
   var login=document.forms['registration']['login'].value;
   var pass=document.forms['registration']['password'].value;  
   var confirm_password=document.forms['registration']['confirm_password'].value;   
   var email=document.forms['registration']['email'].value;
   var name=document.forms['registration']['name'].value;
  
   //Если поле  пустое выведем сообщение 
   if (login.length==0){
      document.getElementById('loginf').innerHTML='*данное поле обязательно для заполнения';
    }
    else document.getElementById('loginf').innerHTML='';
   if (pass.length==0){
      document.getElementById('passwordf').innerHTML='*данное поле обязательно для заполнения';
    }
   else document.getElementById('passwordf').innerHTML='';
   
   if (confirm_password.length==0){
      document.getElementById('confirm_passwordf').innerHTML='*данное поле обязательно для заполнения';
    }
   else document.getElementById('confirm_passwordf').innerHTML='';
   
   //Проверим содержит ли значение введенное в поле email символы @ и .
   at=email.indexOf("@");
   dot=email.indexOf(".");
   
   if (email.length==0){
      document.getElementById('emailf').innerHTML='*данное поле обязательно для заполнения';
    }
    else if (at<1 || dot <1)  {
		document.getElementById('emailf').innerHTML='*email введен не верно';
	}
	 else   document.getElementById('emailf').innerHTML='';
         
    if (name.length==0){
      document.getElementById('namef').innerHTML='*данное поле обязательно для заполнения';
     }
   else document.getElementById('namef').innerHTML='';
      
   // если не заполнено одно из полей программа дальше не выполняется
   if (login.length==0||pass.length==0||confirm_password.length==0||email.length==0||name.length==0)
		return false;
	else if (pass!=confirm_password){
		document.getElementById('passwordf').innerHTML='*пароли не совпадают';
		document.getElementById('confirm_passwordf').innerHTML='*пароли не совпадают';
		return false;
	}
	 else if (at<1 || dot <1) 	return false;
		
   else 
	return true;
} 

//================регистрация=======================================================================//
$( document ).ready(function() {
    $("#btn_reg").click(
		function(){
			var val=validate();			
			if (val)			
			SendFormReg('result_form', 'form_reg', 'registration.php');			
			return false; 
		}
	);
});
 
function SendFormReg(result_form, form_reg, url) {
    $.ajax({
        url:     url, //url страницы (registration.php)
        type:     "POST", //метод отправки
        dataType: "html", //формат данных
        data: $("#"+form_reg).serialize(),  // Сеарилизуем объект
        success: function(response) { //Данные отправлены успешно
        	result = $.parseJSON(response);			
			if (result.error==''){ // если ошибок нет
        	$('#result_form').html('<span style="color:red">Пользователь добавлен в базу.</span><br>логин: '
			+result.login+'<br>пароль: '+result.password+'<br>email: '+result.email+'<br>name: '+result.name);
			$('#form_reg')[0].reset();// очистка формы после отправки
			}
			else 
				$('#result_form').html('<br><span style="color:red">ОШИБКА: </span>'+result.error);
    	},
    	error: function(response) { // Данные не отправлены
            $('#result_form').html('Ошибка. Данные не отправлены.');
    	}
 	});
}
//=======================================================================//

//================авторизация=======================================================================//

$( document ).ready(function() {
	$("#btn_auth").click(
		function(){			
			SendFormAuth('result_form', 'form_auth', 'authorization.php');				
			return false; 
		}
	);
});

   function SendFormAuth(result_form, form_auth, url) {
    $.ajax({
        url:     url, //url страницы (authorization.php)
        type:     "POST", //метод отправки
        dataType: "html", //формат данных
        data: $("#"+form_auth).serialize(),  // Сеарилизуем объект
        success: function(response) { //Данные отправлены успешно
        	result = $.parseJSON(response);
			if (result.name!='')
      	$('#content').html('<span style="color:red">HELLO  </span> '+result.name);
		else
			$('#result_form2').html('<br><span style="color:red">Не верный логин или пароль</span>');
			//$('#form_auth')[0].reset();// очистка формы после отправки
    	},
    	error: function(response) { // Данные не отправлены
            $('#result_form').html('Ошибка. Данные не отправлены.');
    	}
 	});
}
