/* Janela Modal */
function modal_window(){		 
		var alturaTela = $(document).height(),
			larguraTela = $(document).width(),
			target = '#window';
		
	 
		//fundo preto
		$('#mascara').css({'width':larguraTela,'height':alturaTela});
		$('#mascara').fadeTo("slow",0.9);
 
		var left = ($(document).width() /2) - ( $(target).width() / 2 );
		var top = ($(window).height() / 2) - ( $(target).height() / 2 );
	 
		$(target).css({'top':top,'left':left});
		$(target).show();  
 
	// fechar janela
	$('#mascara, #fechar').click(function(e){
		e.preventDefault();
		$('#mascara').hide();
		$('#window').hide();
	});
}


// --------------------------------------------------------------------------------------------------- //
$(function(){
input_cached();	// <-- localStorage

// ERROR message log CLOSE
$('#message-log div').click(function(){
	$(this).parent().hide();
});

/* LOGIN SUBMIT */
$('#login_block form').submit(function(e){
	$('.loading').show();
	var email 		= $('#email', this).val();
	var password 	= $('#password', this).val();
	
	if (email == 'your e-mail') 
		email = '';

	var array		=  {'email':email, 'password':password};
	
	$.post('archive/database_login.php', array, function(data){
			$('.loading').hide();
			
			var log = data;
			var	message = log.split(':');
			
			// MESSAGE LOG
			if (message[0] === 'ERROR') { // <----- if ERROR
				$('#message-log').fadeIn().children('b').text(message[0]);
				$('#message-log').children('p').html(message[1]);
				setTimeout(function(){$('#message-log').fadeOut();}, 3000);	// <-- fadeOut after delay
			}
			else
				window.location = 'index.php?user='+message[1];
			
	});
	e.preventDefault();
});

// --------------------------------------------------------------------------------------------------- //

		/* Smooth Back-to-Top */
		$('#go_top').bind('click',function(){
		  $('html, body').animate({
			scrollTop:0
		  }, $(window).scrollTop() / 2);
		  return false;
		});
		// show after 
		$(window).scroll(function() {
			if ($(this).scrollTop()>600) {
				$('#go_top').fadeIn();
			} else {
				$('#go_top').fadeOut();
			}
		});
		
		
		
		/* videos WINDOW */
			var video = 0;
			$('#videos').click(function(event){
				event.preventDefault();
				modal_window();
				if (video === 0)
					$('#window div').load('1-ajax.php?_escaped_fragment_=videos', function(){video = 1;});
			});

			
	
	
	
	/* input FOCUS & BLUR */
    $(document).on('focus', 'input[type="text"]', function() {
		attr = $(this).attr('string');
		var value = $(this).val();
        if(value == attr) $(this).val('');
		
		if ($(this).attr('id') == 'fakepassword') {
			$(this).hide();
			$(this).next().show().focus();
		}
    }).on('blur', 'input[type="text"]', function() {
		var string = $(this).val();
		if(string !== '') $(this).val(string);
		else $(this).val(attr);
    });
	
   
	/* input[password] FOCUS & BLUR */
	$(document).on('blur', 'input[type="password"]', function(){
		if ($(this).val() == '') {
			$(this).hide();
			$(this).prev().show();
		}
	});

	/* LOGIN DROP DOWN */
	$('#login-with').click(function(e){
		$('#social-login').toggleClass('display-block');
	});
		
			// CLOSE
			$(document).click(function(e){
				if($(e.target).closest('#social-login').length != 0) return false
				if($(e.target).closest('#login-with').length != 0) return false
				$('#social-login').removeClass('display-block');

			});	
			
	/* DOCUMENTATION DROP DOWN */ //#b = #doc-container
	$('#doc').click(function(e){
		e.preventDefault();
		$('#developers-section').toggleClass('display-block');
	});
	$('a .doc-nav').click(function(e){
		e.preventDefault();
		if($(this).hasClass('active')) {
			$('.doc-nav p').text('+');
			$('a .doc-nav').removeClass('active');
			$('#y').removeClass('display-block');
		} 
		else {
			$('.doc-nav p').text('+');
			$('p', this).text('-');
			$('a .doc-nav').removeClass('active');
			$(this).addClass('active');
			$('#y').addClass('display-block');
		}
	});

	
	
	/* AJAX REQUEST */
	// For each .ajax-box, keep a data object containing a mapping of
	// url-to-container for caching puposes.
	$('.ajax-box').each(function(){
		$(this).data( 'bbq', {
			cache: {}
		});
	});

	// For all links who support AJAX, pushs the appropriate state onto the
	// history when clicked.
	$(document).on('click','a[href^="#!"]', function(e){
		var state = {},
		
			// Get the id of the .ajax-box target to insert the data.
			id = $(this).attr('data-to'),
			
			// Get the url from the link's href attribute, stripping any leading #!
			url = $(this).attr('href').replace(/^#!/, '');
	
	
		// Set the state! - index.php#key=value
		state[ id ] = url;
		$.bbq.pushState( state );
		
		// And finally, prevent the default link click behavior by returning false.
		return false;
	});
	
	
	// Bind an event to window.hashchange that, when the history state changes,
	// iterates over all .ajax-box, getting their appropriate url from the current state. 
	// If that .ajax-box url has changed, display either our
	// cached content or fetch new content to be displayed
	$(window).bind('hashchange', function(e) {
	
		// Iterate over all .ajax-box existent
		$('.ajax-box').each(function(){
			var that = $(this),
				id = that.attr('id'),
				
				// Get the stored data for this .ajax-box
				data = that.data('bbq'),
				
				// Get the state of the .ajax-box from the hash, based on the
				// approppriate id property.( index.php#boxID=state )
				state = $.bbq.getState( id ) || '';
			
			
			// JUST FOR INDEX
			if (id === 'x' && state == '' ){
			if (data.cache[ state ]) 
				data.cache[ state ].show();
			else {
				data.cache[ state ] = $('<div/>')
					.appendTo(that)
					.load('1-ajax.php?_escaped_fragment_=index');
			}
			};
			
			// JUST FOR CONFIRMED EMAIL page
			if (id === 'x' && state == 'confirmed' ){
				// remove LocalStorage
				window.localStorage.removeItem('email');
				window.localStorage.removeItem('url-name');
				window.localStorage.removeItem('sign-steps');
				window.localStorage.removeItem('display-name');
			};
	
	
			// JUST FOR DOC section.show()
			if (id === 'y' && state != ''){
				
				$('.doc-nav p').text('+');
				$('a[href="#!' + state + '"] .doc-nav p').text('-');
				
				$('a .doc-nav').removeClass('active');
				$('a[href="#!' + state + '"] .doc-nav').addClass('active');
				$('#y').addClass('display-block');
			};
			
			
			
			// If the state hasn't changed, do nothing and skip to the next .ajax-box
			if (data.state === state) { return; } 
		
		
			// Store the state for the next time around.
			data.state = state;
			
			
				
			$('a[href^="#!"]#'+that.attr('id')).removeClass('active');	// Remove .active class from any previously "active" link(s).
			that.children('div').hide();								// Hide any visible ajax content	
			state && $('a[href="#!' + state + '"]').addClass('active');	// Add .active class to 'active nav link(s), only if state isn't empty.
			
			
			if (data.cache[ state ]) {
				// Since the loaded ajax content is already in the cache, it doesn't need to be
				// loaded again, so let's just show it!
				data.cache[ state ].show();
			} else {
				// Create container for this url content and store a reference to it in
				// the cache.
				data.cache[ state ] = $('<div/>')
				
					.appendTo(that)
					.load('1-ajax.php?_escaped_fragment_=' + state);
			};
			
			
		
		}); // END -- .each
	});	// END -- .bind
	
	$(window).trigger( 'hashchange' );

	
});

/* INPUT cached */
function input_cached() {
		//-------- SET EACH VALUE
		$('input').each(function(){
			var id = $(this).attr('id');
			if (window.localStorage.getItem(id)) 
				$(this).val(window.localStorage.getItem(id));	
		});
		//-------- KEYUP SAVE
		$(document).on('keyup','input', function(){
			var id 	  = $(this).attr('id');
			var value = $(this).val();
			
			if (id != 'password' && id != 're-password')
				window.localStorage.setItem(id,value);
		});
		//-----------------// password fix
		$('input[type="password"]').each(function(){
			if($(this).val() != '') {
				$(this).show();
				$(this).prev().hide();
			}	
		});	
}

