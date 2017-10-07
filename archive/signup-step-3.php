<style>
#email_text {
	background:#fff; 
	width:330px; 
	border-left:3px dashed #333; 
	padding:20px 30px 0; 
	position:relative;
	}
	
#step-3 h2 	{font-size:17pt;}
#step-3 p 	{margin-top:18px;}

#step-3 span {
	display:inline-block;
	font-size:16pt;
	background:#fffeb1; 
	padding:13px 36px;
	min-width:330px;
	margin-left:-33px;
	border-top: 1px solid #999;
	border-left:3px dashed #333; 
	word-break: break-all;
	}
	
	
.mail-options:before {width:150px; height:5px; margin:12px -150px; }
.mail-options {
	position:absolute;
	right:0px;
	color:#fff;
	text-align:center;
	width:160px;
	padding:15px;
	font-size:15pt;
	border:1px solid #333;
}

#re-send 			{background:#418C73;}
#re-send:active 	{background:#2c604f;}
#re-delete 			{background:#f45467; top:59px; box-shadow:inset 0px 10px 10px rgba(1,1,1,.5), 15px 15px 15px rgba(1,1,1,.5);}
#re-delete:active 	{background:#cb4555;}


#delete-confirm {
	position:absolute; 
	right:0;
	top:200px;
	background:#fff;
	width:230px;
	height:100px;
	border:1px solid #333;
	display:none;
	}

#delete-confirm:before {
	width:5px; 
	height:100px; 
	top:-100px; 
	left:130px;
	}	
	
#delete-confirm data {display:block; margin:15px 20px -10px;}	
	
#delete-confirm a:hover div {background: #666;}
#delete-confirm a div{
	float:left; 
	color:#fff; 
	background:#555; 
	padding:10px 20px; 
	width:114px;
	text-align:center;
	font-size:15pt;
	}

a:active #new-account {background:#464d78;}
#new-account {
	position:absolute; 
	color:#ebebeb; 
	background:#5c669e; 
	padding:10px 15px; 
	bottom:-49px; 
	left:10px; 
	font-size:15pt;
	box-shadow:inset 0px 5px 5px rgba(1,1,1,.5)
	}
</style>
						<!----------------- STEP 3 ---------------->					
						<div id="step-3">
							<h1>✖ step 3 - Email Validation</h1>
							
							<!-------------------------------------->
							<a href="#"><div class="mail-options hasLine" id="re-send">send it again!</div></a>
							<a href="#"><div class="mail-options hasLine" id="re-delete">✖ delete this!</div></a>

							
							<!-------------------------------------->
							<div id="delete-confirm" class="hasLine">
								<data>Are you sure about deleting this account?</data><br>
								
							<a href="#">	<div id="yes">はい </div></a>
							<a href="#">	<div id="no"> いいえ</div></a>
							</div>
							
							
							<!-------------------------------------->
							<div id="email_text" class="box-shadow-LV2">
								<h2><!--DISPLAY-NAME--></h2>
								
								<p>
								We've just sent the e-mail to your inbox or spam box. <br>
								It should arrive after a few minutes.<br><br>
								Go take a look ^^<br><br>
								</p>
								<span><!--EMAIL--></span>
								
								<a href="#"><div id="new-account">create a new account</div></a>
							</div>
							
							<!-------------------------------------->
							
							
							
						</div>
						
<script>
$(function(){

// some useless .TEXT()
$('#email_text h2').text(window.localStorage.getItem('display-name') + ', was it?');// <-- display-name
$('#email_text span').text(window.localStorage.getItem('email'));					// <-- email

//----------------------------------------------------------------------------------//

	$('#step-3 a').click(function(e){
		var id = $(this).children().attr('id');
	
	
		/* create new account */
		if (id === 'new-account')
			cleanup();				
		
		
		// show & hide <delete>
		if (id === 're-delete')
			$('#delete-confirm').toggleClass('display-block');
			
		if (id === 'no')
			$('#delete-confirm').removeClass('display-block');
			
			
		/* DELETE ACCOUNT */
		if (id === 'yes') {
			$('.loading').show();
			
			$.post('1-ajax.php?_escaped_fragment_=database-delete', function(data){
				var log = data;
				var	message = log.split(':');
				
				// MESSAGE LOG
				$('.loading').hide();
				$('#message-log').fadeIn().children('b').html(message[0]);
				$('#message-log').children('p').html(message[1]);			
				setTimeout(function(){$('#message-log').fadeOut();}, 4000);	// <-- fadeOut after DELAY
				
				// deleted! --> go to STEP 1
				if (message[0] == '✖ Deleted <br>'){
					$('#message-log').css('background', 'url(img/noise_a.png) repeat-x #666').css('color','#DBDBDB');
					cleanup();
				}
			});
		}
		
		/* RE-SEND EMAIL */
		if (id === 're-send'){
			$('.loading').show();
			
			$.post('archive/send_mail.php', function(data){
				$('.loading').hide();
				
				var log = data;
				var	message = log.split(':');
				
				// MESSAGE LOG
				$('#message-log').fadeIn().children('b').html(message[0]);
				$('#message-log').children('p').html(message[1]);
				if (message[0] != 'ERROR') 
					$('#message-log').css('background', 'url(img/noise_a.png) repeat-x #6dc17c').css('color','#000'); // SUCCESS!
				
				// <-- fadeOut after DELAY
				setTimeout(function(){$('#message-log').fadeOut();}, 4000);	

			});			
			
		}


		
		e.preventDefault();
	});
});


// CLEAR INPUTS --> go to STEP 1
function cleanup(){
	$('a.steps').addClass('blocked').removeClass('active');	
	$('div[id^="step"]').hide();
	
	$('a[href="#step-1"]').removeClass('blocked').addClass('active');
	$('#step-1').show();
	
	$('#email').val('your e-mail');
	$('#signup-form #password, #re-password').val('').blur();
	$('#display-name').val('display-name');
	$('#url-name').val('url-name');
	
	window.localStorage.removeItem('sign-steps');
	$('#signup-form input').each(function(){
		var id = $(this).attr('id');
		window.localStorage.removeItem(id);
	});	
}
</script>