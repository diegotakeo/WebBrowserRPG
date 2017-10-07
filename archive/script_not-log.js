
/* Local Storage E-MAIL */
if (window.localStorage.getItem('email')) 
	$('#email').val(window.localStorage.getItem('email'));	
	
$('#email').on('keyup',function(){
	var value = $(this).val();
	window.localStorage.setItem('email',value);
});


/* LOGIN SUBMIT */
$('#login').on('submit', function(e){

	$('.loading').show();
	var email 		= $('#email').val();
	var password 	= $('#password').val();

	if (email == 'your e-mail')
		email = '';

	var array =  {'email':email, 'password':password};
	
	$.post('archive/database_login.php', array, function(data){
			$('.loading').hide();
			
			var log  = data;
			var log_ = log.split(':');
			
			if(log_[0] != 'SUCCESS')
				$error_message(data);
			else
				location.reload();
			
	});
	e.preventDefault();
});


    // [...]
	/* input[password] FOCUS & BLUR */
	$('input[type="password"]').on('blur', function(){
		if ($(this).val() == '') {
			$(this).hide();
			$(this).prev().show();
		}
	});