


<!---------------------------------------------------------------------------------------------------------------------->				
					<div class="hasLine" id="signup-form">
					
						<!-------------- STEP 1 ---------------->
						<div id="step-1">
							<h1>✖ step 1 - New Account</h1>

							<form class="box-shadow-LV2">
							
								<!-- E-MAIL -->
								<input type="text"		 id="email" value="your e-mail" string="your e-mail" autocomplete="off" spellcheck="false"/>
									<div class="hasLine" id="wrong" style="top:13px;"></div>
									
								<!-- PASSWORD -->
								<input type="text"	   id="fakepassword" value="password" string="password"/>
								<input type="password" id="password" style="display:none;"/>	
									<div class="hasLine" id="wrong" style="top:90px;"></div>

								<!-- RE-PASSWORD -->
								<input type="text"	   id="fakepassword" value="re-password" string="re-password"/>
								<input type="password" id="re-password" style="display:none;"/>		
									<div class="hasLine" id="wrong" style="top:170px;"></div>

								<!--------- SUBMIT ---------->
								<div id="submit"><input type="submit" value="okay"></div>

							</form>
						</div>
						
					</div>
<!---------------------------------------------------------------------------------------------------------------------->						

					<!-- SIGNUP STEPS --->
					<a class="steps active" 	href="#step-1">  <div data-icon="" style="box-shadow:none;"></div></a>
					<a class="steps blocked"	href="#step-2">  <div data-icon="">	</div></a>
					<a class="steps blocked"	href="#step-3">  <div data-icon="">	</div></a>

					
<script>
$(function(){
	step_2 = 0;
	step_3 = 0;
	
	/* ONLOAD CACHE */ // HTML5 localStorage
		if(window.localStorage.getItem('sign-steps')) {
			var step = window.localStorage.getItem('sign-steps');

			
			//-----------------------> load STEP 1?
			if (step == '#step-1') {
				$.get('1-ajax.php?_escaped_fragment_=step-2', function(data){
					$('#signup-form').append(data);
					$('#step-2').hide();
					step_2 = 1;
					input_cached();			
				});
			} 
			else {		// CLEAN UP -- for --> (step2 e step3)
				$('a.steps').addClass('blocked').removeClass('active');	
				$('div[id^="step"]').hide();
			}
			
			//-----------------------> load STEP 2
			if (step === '#step-2') {
				$('a[href="#step-1"]').removeClass('blocked');
				$('a[href="#step-2"]').removeClass('blocked').addClass('active');	// active link	

				$.get('1-ajax.php?_escaped_fragment_=step-2', function(data){
					$('#signup-form').append(data);
					step_2 = 1;
					input_cached();
				});				
			}
			
			//-----------------------> load STEP 3
			if (step === '#step-3') {
				$('a[href="#step-3"]').removeClass('blocked').addClass('active');	// active link			
			
				$.get('1-ajax.php?_escaped_fragment_=step-3', function(data){
					$('#signup-form').append(data);
					step_3 = 1;
				});
			}	
		}
		input_cached();
		
		
	
	/* STEP 1 - SUBMIT */
	$('#step-1').submit(function(e){
		var error = 0;
		
		
		// START VALIDATION
		$('#step-1 input').each(function(){

			var id 	  = $(this).attr('id');
			var value = $(this).val();
			
			// E-MAIL validation -----------------------------------------//
			if(id == 'email'){
				var after_a = value.split('@');

				if (value == 'your e-mail'){			//---> EMPTY
					$(this).next().show().text('✖ write something!');
					error++;
				}										//---> invalid EMAIL
				else if (value.indexOf('@') === -1 || value.length < 7 || value.length > 254 || after_a[1].length < 2){	
					$(this).next().show().text('✖ invalid e-mail');
					error++;
				}
				else {									//---> ALREADY EXISTS
					$('.loading').show();
					 $.ajaxSetup({async: false});
					$.post('1-ajax.php?_escaped_fragment_=database-validation', {'email':value}, function(data){
						
						if(data.length !== 0) {
							$('#email').next().show().text('✖ already exists!');
							error++;
						}
						else
							$('#email').next().hide();	//---> OK!!
							$('.loading').hide();
					});
					$.ajaxSetup({async: true});
				}
			}
			
			// PASSWORD validation -----------------------------------------//
			if(id == 'password'){
				if (value == ''){						//---> EMPTY
					$(this).next().show().text('✖ empty password!');
					error++;
				}
				else if (value.length < 6){				//---> min.length
					$(this).next().show().text('✖ min.length = 6');
					error++;
				}
				else if (value.length > 72) {
					$(this).next().show().text('✖ max.length = 72');
					error++;
				}
				else  									//---> OK!!
					$(this).next().hide();
			} 	

			// RE-PASSWORD validation -----------------------------------------//
			if(id == 're-password'){
				if (value != $('#password').val()){		//---> DIFERENT from <password>
					$(this).next().show().text('✖ it\'s different!');
					error++;
				}
				else  									//---> OK!!
					$(this).next().hide();
			}

		}); // END -> input.each()
		

		
		/* IF ANY ERRORS --> go to STEP 2 */
		if (error === 0){
			if (step_2 === 0) {			// if not cached
				$.get('1-ajax.php?_escaped_fragment_=step-2', function(data){
					$('#signup-form').append(data);
					step_2 = 1;
				});
			}
			else $('#step-2').show();	// if cached, just show it!
			
			window.localStorage.setItem('sign-steps','#step-2');	
			$('a[href="#step-2"]').removeClass('blocked').click();	
		}
		
		
		
		
		e.preventDefault();
	}); // END -> step 1 - SUBMIT
	
	
// some fix
$('#step-1 input').keyup(function(){
	$('a[href="#step-2"]').addClass('blocked');
});
	
	
/* SIGNUP STEPS --> NAVIGATION */
$('a.steps').click(function(e){
	if(!$(this).hasClass('blocked')){
		var id = $(this).attr('href');
		//------------//
		$('div[id^="step"]').hide();			// show & hide DIV
		$('div'+id).show();
		//------------//
		$('a.steps').removeClass('active');		// active link
		$(this).addClass('active');
		//------------//
		window.localStorage.setItem('sign-steps',id);
	}
	e.preventDefault();
});	
	
});
//------------------------------------------------------------------------------//

</script>
