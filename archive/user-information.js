function htmlentities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}


$(function(){


	// show EDIT (hover)
	$('.left-side').hover(function(){
		$('.user_info a div').show();
	},function(){
		$('.user_info a div').hide();
	});

	/* click EDIT */
	$('.user_info a').click(function(){
		$('.loading').show();
	
		var id = $(this).parent().attr('id');

			$('#'+id+' a, #'+id+' .info').hide();
			$('#'+id+' .inputs').html('<form method="post">');
		


		
		// IF PESONAL INFO
		if (id == 'user-personal'){
		
			// $_GET <-- to the server
			var array = {};
			$('#user-personal p').each(function(){
				txt = $(this).text().replace('\t','').split(':');
				array[txt[0]] = $.trim(txt[1]); // eg. {age:16, ...}
			});



			// SEND TO SERVER <-- transform <p> into INPUTS
			$.get('archive/user-personal-form.php', array, function(data){
				$('#user-personal form').html(data);
				$('.loading').hide();
			});
			
			
		// IF DESCRIPTION
		} else {
			// transform in TEXT AREA
			var text = $('#'+id+' p').html().replace(/\s+/g, ' ').replace(/<br>/g,'&#10;');
			$('#'+id+' form').html('<input type="submit" value="ok"><p><textarea name="description" cols="50" rows="5" spellcheck="false" maxlength="500">'+text+'</textarea></p>');
			$('textarea').keyup();
			$('.loading').hide();
		}


	});


		
		/* SUBMIT callback */
		$('.user_info').on('submit','form', function(){
			$('.loading').show();
			
			var $this 	 = $(this);
			var this_id	 = $(this).parent().parent().attr('id');
			
			var array = {};
			var text  = '';

			
			
			// GET it
			if(this_id == 'user-personal') {
			
				// each INPUT
				array = $(this).serializeArray();
				$.each(array, function(i, input){
					if(input.value)	
						text += '<p><b>'+input.name+':</b> '+htmlentities(input.value)+'</p>';
				});
				
				
			}
			else {
			
				// TEXTAREA value
				var txt = $('textarea',this).val();
				text  = '<p>'+htmlentities(txt).replace(/\r?\n/g, '<br>')+'</p>';
				
				array['description'] = txt.replace(/\r?\n/g, '<br>');
			}

			// SEND to DATABASE
			$.post('archive/user-information_database.php', array, function(data){
				if (data)
					$error_message(data);

				else {
					// SET it (with javascript)
					$this.remove();
					$('#' + this_id + ' .info').html(text).show();
					$('#' + this_id + ' a').show();
					
					if (this_id === 'user-personal')
						$('#user-description').addClass('hasLine');
				}
				
				$('.loading').hide();
			});
			

				
			return false;
		});	
		
		
		
		

	/* ADD INFO */ // <-- newly registered user
	$('#_info').click(function(){
		$('.loading').show();
		var box = $(this).next();

			
			$(this).hide();
			box.show();
			box.children('.inputs').html('<form method="post">');
			box.children('a').hide();
		

			// get INPUTS <-- from server
			$.get('archive/user-personal-form_empty.php', function(data){
				$('#user-personal form').html(data);
				
				if ($('#user-description').is(':visible'))
					$('#user-description').addClass('hasLine');
					
				$('.loading').hide();
			});
	});

	/* ADD DESCRIPTION */ // <-- newly registered user
	$('#_description').click(function(){

		var box = $('#user-description');

			
			$(this).hide();
			box.show();
			box.children('.inputs').html('<form method="post">');
			box.children('a').hide();
			
			
			// get TEXT AREA <-- from server
			$('#user-description form').html('<input type="submit" value="ok"> <p><textarea name="description" cols="50" rows="5" spellcheck="false" maxlength="500"></textarea></p>');
			$('textarea').keyup();
		
		
			if ($('#user-personal').is(':visible'))
					$('#user-description').addClass('hasLine');
	});
	

});
