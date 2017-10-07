						<!-------------- STEP 1 ---------------->					
						<div id="step-2">
							<h1>✖ step 2 - About You</h1>
								
							<form class="box-shadow-LV2">
							
								<!-- DISPLAY NAME -->
								<input type="text"		 id="display-name" value="display-name" string="display-name" autocomplete="off" spellcheck="false"/>
									<div class="hasLine" id="wrong" style="top:13px;"></div>

								<!-- URL NAME -->
								<input type="text"		 id="url-name" value="url-name" string="url-name" autocomplete="off" spellcheck="false"/>
									<div class="hasLine" id="wrong" style="top:90px;"></div>							
									
								<!--------- SUBMIT ---------->
								<div id="submit"><input type="submit" value="send"></div>

								
								<!-- reCAPTCHA issues -->
								<?php
								  //require_once('recaptcha/recaptchalib.php');
								  //$publickey = "your_public_key";
								  //echo recaptcha_get_html($publickey);
								?>		
								
							</form>						
						</div>
						
<script>
$(function(){
	$('#step-2').submit(function(e){
		var error = 0;
		
		/* VALIDATION */
		$('#step-2 input').each(function(){

			var id 	  = $(this).attr('id');
			var value = $(this).val();
	
			// display-name validation
			if(id == 'display-name'){
				if(value == 'display-name'){	//---> empty
					$(this).next().show().text('✖ any ideas?');
					error++;
				}
				else if (value.length > 23){	//---> length.limit
					$(this).next().show().text('✖ max length = 23!');
					error++;
				}
				else 							// OK!!
					$(this).next().hide();
			}

	
			// URL-name validation
			if(id == 'url-name'){
				var re = /^[a-z0-9\-\_]+$/i;
				
				if(value == 'url-name'){		//---> empty
					$(this).next().show().text('✖ write somethig!');
					error++;
				}
				else if (value.length > 30){	//---> length.limit
					$(this).next().show().text('✖ max length = 30!');
					error++;
				}
				else if (!re.test(value)){ 		//---> invalid characters (REGEX)
					$(this).next().show().text('✖ not allowed characters!');
					error++;
				}
				else 							//---> IF ALREADY EXISTS
					$('.loading').show();
					$.ajaxSetup({async: false});
					$.post('1-ajax.php?_escaped_fragment_=database-validation', {'email':value}, function(data){
						
						if(data.length !== 0) {
							$('#url-name').next().show().text('✖ already exists!');
							error++;
						}
						else
							$('#url-name').next().hide();	//---> OK!!
							$('.loading').hide();
					});
					$.ajaxSetup({async: true});
			}


		}); // END -> input.each()	

		
		/* ANY ERRORS! */
		if (error === 0){
			$('.loading').show();
		
			var mail 	= $('#email').val();
			var pass 	= $('#signup-form #password').val();
			var repass 	= $('#re-password').val();
			var name 	= $('#display-name').val();
			var url  	= $('#url-name').val();
			
			var array 	= {'mail':mail,'pass':pass,'repass':repass,'name':name,'url':url};
			
			/* CONNECT TO DABATASE */
			$.post('archive/database_register.php', array, function(data){
				$('.loading').hide();
				
				var log = data;
				var	message = log.split(':');

				// MESSAGE LOG	---- SUCCESS or ERROR!
				if (message[0] === 'ERROR')  { // <----- if ERROR
					$('#message-log').fadeIn().children('b').text(message[0]);
					$('#message-log').children('p').html(message[1]);
					setTimeout(function(){$('#message-log').fadeOut();}, 4000);	// <-- fadeOut after delay
				}
				else {
				
					/* go to STEP 3 */
					if (step_3 === 0) {
						$.get('1-ajax.php?_escaped_fragment_=step-3', function(data){
							$('#signup-form').append(data);
							step_3 = 1;
						});
					}
					else
						$('#step-3').show();
					
					$('a.steps').addClass('blocked');
					$('a[href="#step-3"]').removeClass('blocked').click();	
					
					// some useless .TEXT()
					$('#email_text h2').text(window.localStorage.getItem('display-name') + ', is it?');
					$('#email_text span').text(window.localStorage.getItem('email'));
					
					
				}
				
			});			
		}
		
		e.preventDefault();
	}); // END -> step 2 - SUBMIT
});

</script>