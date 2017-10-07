
$(function(){

// ---------------------------------------------------------------------------------------------------------------------------- //	
/* THIS_PAGE_USER IMAGE */

var $split  = $('#avatar img').attr('src').split('/');
user_image  = 'img/avatar/small/'+$split[2]; // (img/avatar/small/xxx.jpg)

// temp_stuff
$('.the-answer > img').attr('src', user_image);


// ---------------------------------------------------------------------------------------------------------------------------- //	

	/* delete & edit QUESTION (block) */
	// delete button
	$('#asking-box').on('click','.a-delete', function(){
		var $_this 	 = $(this);
		var parent 	 = $_this.closest('.ask-block');
		var mongo_id = parent.find('.mongo_id').text();
		var name	 = parent.find('b').text();
		
		var array	 = {'mongo_id': mongo_id, 'display_name': name, 'data': 'delete_question'};

		$.post('archive/user-questions_database-update.php', array, function(){
			$_this.closest('.ask-block').next('.answer').remove();
			$_this.closest('.ask-block').remove();
		});
	});

	
// ---------------------------------------------------------------- //	
	
	// edit button
	$('#asking-box').on('click','.a-edit', function(){
		var that = $(this).closest('.text').children('p');
		var text = that.html().replace(/<br>/g,'&#10;');
		
		that.replaceWith('<form method="post" class="edit-question">\
							<textarea maxlength="140" spellcheck="false" data-cancel>'+text+'</textarea>\
						  </form>');
						  
		$('textarea').keyup();

		// show nav ~ (send & edit)
		$(this).siblings(".a-delete").replaceWith('<a href="#" class="a-cancel">✖ Cancel</a>');
		$(this).replaceWith('<a href="#" class="a-submit">△ Send it</a>');	
		
		
		
		
			// send button
			$('.a-submit').click(function(){
				var $_this 	= $(this);
				var that 	= $_this.closest('.text').find('textarea');
				var text 	= that.val().replace(/\n/g,'<br>');
				
				var parent 	 = $_this.closest('.ask-block');
				var mongo_id = parent.find('.mongo_id').text();
				var name	 = parent.find('b').text();
				
				var array 	 = {data: 'edit_question', 'mongo_id': mongo_id, 'display_name': name, 'text': text};
				
				$.post('archive/user-questions_database-update.php', array, function(data){
					that.parent().replaceWith('<p>'+data+'</p>');
					$_this.siblings(".a-cancel").replaceWith('<a href="#" class="a-delete">✖ Delete</a>');
					$_this.replaceWith('<a href="#" class="a-edit">△ Edit</a>');	
				});
			});	
			
			
			
			// cancel button
			$('.a-cancel').click(function(){
				var that = $(this).closest('.text').find('textarea');
				var text = that.val().replace(/\n/g,'<br>');
				
				that.parent().replaceWith('<p>'+text+'</p>');
				$(this).siblings(".a-submit").replaceWith('<a href="#" class="a-edit">△ Edit</a>');	
				$(this).replaceWith('<a href="#" class="a-delete">✖ Delete</a>');
			});
	});
	
	
// -------------------------------------------------------------------------------------------------------------------------------------------------------------------------- //	

	
	/* remove & edit ANSWER (block) */
	$('#asking-box').on('click','.nav a',function(){
		var block = $(this).closest('.ask-block');
			
		// remove button
		if ($(this).text() == 'x') {
			$('.loading').show();
		
			var text = '';
			var ask_block = block.prev();
			var mongo_id = ask_block.find('.mongo_id').text();
			var name	 = ask_block.find('b').text();

			var array_ = {data: 'delete_answer', 'mongo_id': mongo_id, 'display_name': name};
	
			
			$.post('archive/user-questions_database-update.php', array_, function(){
				ask_block.find('.half_star').remove();
				$('.loading').hide();
			});
		}
		
		
		
		
		// edit button
		else {
			var that = $(this).parent().prev('.text');
			var text = that.children('p').html().replace(/<br>/g,'\n');
		}
		
		
		
		
		
		var that = block.children('data.the-write');

		$('.loading').show();
		
		// if textarea already exists
		if (that.length != 0) {
			$.post('archive/user-questions_decode.php', {'text': text}, function(data){
				that.show().find('textarea').val(data); 
				$('.loading').hide();
			});
		}
		// else, load it!
		else {						
			$.post('archive/user-questions_textarea.php', {'text': text}, function(data){
				block.prepend(data);
				$('.loading').hide();
			});
		}
		
		
// ---------------------------------------------------------------- //			
		
		
			// CLEAN it
			block.prev('.ask-block').children('.half_star').remove(); 	// remove '★ Answered'
			block.children('data.the-answer').hide();					// hide the-answer
			block.addClass('write');									// add .write class
			block.find('textarea').keyup();								// bind textarea counter
		
	});
	
	
// -------------------------------------------------------------------------------------------------------------------------------------------------------------------------- //	
	
	/* SUBMIT callback */
	$('#user-questions').on('submit','form', function(){
		// GET it
		var text = $('textarea', this).val().replace(/\n/g,'<br>');

// ------------------------------------ //			
		
		/* if QUESTION */
		if ($(this).attr('id') == 'question') {
			var array = {'text': text};
			
			
			// if ANONYMOUS
			if ($('#as-anonymous').attr('checked') == 'checked')
				array['anonymous'] = true;

				
			// UPDATE DATABASE
			$.post('archive/user-questions_database.php', array, function(data){
				$('#asking-box').prepend(data);
				
				// clean up
				$('textarea',this).val('').height(0).keyup();
			});
		}
		
// ---------------------------------------------------------------- //			
		
		/* if ANSWER */
		else {
			var that 		= $(this).parent();
			var that_parent = that.parent();
			var answer 		= that.siblings('data.the-answer');
			
			var ask_block	= $(this).closest('.ask-block').prev();
			var mongo_id 	= ask_block.children('.mongo_id').text();
			var name		= ask_block.find('b').text();
			
			var array  		= {'text': text, 'img':user_image, 'mongo_id': mongo_id, 'display_name': name};
			

					
					if (answer.length != 0) 		 // if answer already exists
						array.data = 'edit_answer';	 // <--- EDIT
						
					else 							// if not, load it!
						array.data = 'add_answer';	// <--- ADD_NEW
					
					
						$.post('archive/user-questions_database-update.php', array, function(data){
							// if answer already exists
							if (answer.length != 0) {
								answer.show();
								answer.find('p').html(data);
							}
							// if not, load it!
							else
								that_parent.prepend(data);
								
							that_parent.prev('.ask-block').append('<div class="half_star"></div>');
							that_parent.removeClass('write');		// remove .write class
							that.hide();							// remove data.the-write
						});

					
		}
		
		
// ------------------------ //	
		
		
		$(this).children('span').children('data').text(140);
		return false;
	});


// ---------------------------------------------------------------------------------------------------------------------------- //		

/* TEXT AREA (length counter) */
$(document).on('keyup','textarea', function(){
	var caracter = $(this).val().length;
	$(this).parent().find('span data').text(140-caracter);
	
	if(caracter > 0) $(this).siblings('.hidden').show();
	else 			 $(this).siblings('.hidden').hide();
});



// show NAV (hover)
$('#asking-box').on('mouseover','.ask-block', function(){
	if(!$(this).hasClass('active'))
		$('.nav',this).css('visibility', 'visible');
}).on('mouseout', function(){
	if(!$(this).hasClass('active'))
		$('.nav',this).css('visibility', 'hidden');
});



// show ANSWER (click)
$('#asking-box').on('click','.ask-block', function(e){
	if($(e.target).closest('.nav').length != 0) return false
	if($(e.target).closest('.ask-block:not(.write)').find('form').length != 0) return false


	var that = $(this).next('.answer');		
	that.toggleClass('display-block');
	
	if (!$(this).hasClass('answer') && that.length != 0) {
		$(this).toggleClass('active');
		if ($(this).hasClass('active'))
			$('.nav',this).show();
	}
});



	$('.loading').hide();
});