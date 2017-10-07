var $_timeout;
/* ERROR NOTIFICATAION (function) */
function $error_message(data){
	var log = data;
	var	message = log.split(':');
	window.clearTimeout($_timeout);
	
	$('#message-log').fadeIn().children('b').text(message[0]);
	$('#message-log').children('p').html(message[1]);
	$_timeout = setTimeout(function(){$('#message-log').fadeOut();}, 3000);	// <-- fadeOut after delay
}




// END <functions>
// --------------------------------------------------------------------------------------------------------------- //
	
	/* AJAX calls */
	$(document).ready(function(){
		
		// AJAX 1 - user_information
		$('#user-information').load('archive/user-information.php', function(){
		
			// AJAX 2 - STATUS BAR
			$.get('archive/status-a.php', function(data){
				$('div#status-a').html(data);
				
				// AJAX 3 - if user has a COVER IMAGE
				var $cover = $('#cover').attr('data-file');
				if ($cover){
					var img = new Image();
					img.src = 'img/cover/' + $cover;
					img.onload = function(){
						//setInterval(function() {
						$('#cover').css('background', 'url(' + img.src + ')')
						//}, 5000)
						;
					};

				}
			});
		});
		
		
		// ASK-ME-ANYTHING (after 800px)
		var cache_question = false;
		$(window).scroll(function(){
			if ($(window).scrollTop() > 800 && cache_question === false) {
				cache_question = true;
				$('.loading').show();
				$('#user-questions').load('archive/user-questions.php');
			}
		});



// ERROR message log CLOSE
$('#message-log div').click(function(){
	$(this).parent().hide();
});


	/* showtext() LETTER by LETTER */
	var letter_interval;
	
				
	var showText = function (target, message, index, interval) {
		window.clearTimeout(letter_interval);
		
		if (index < message.length) {
			$(target).append(message[index++]); 
			letter_interval = setTimeout(function () { showText(target, message, index, interval); }, interval); 
		}
	};




	/* OPEN RPG MENU (left corner) */
	$('.rpg_menu').on('click','a.menu_trigger, .menu_overlay', function(e){
		$('.rpg_menu').toggleClass('open_class');
		$('.rpg_menu ul').hide();	
		$('.rpg_menu.open_class ul').fadeIn(1000);	
		
		var target = $('.npc_talk p');
		var text   = 'そのカエルは、幻覚をなめてはいけない！ 今日は何日だったかな？３３日かな？ハハ、そんな日はないか！今日は３４日だな！ 今日の天気予報は、午前は飴、午後は豹、夜はナメクジか。一応、傘を持っていこうかな... ';
		target.text('');
		showText(target, text, 0, 5);
		e.preventDefault();
	}); 
	// COIN EFFECT
	$('.rpg_menu li').hover(function(){
		var coin = new Audio("sound/coin.wav");
		coin.volume = 0.3;
		coin.play();
	}, function(){});
	// EXIT (esc)
	$(document).keyup(function(e) {
		if (e.keyCode === 27){
			if($('.rpg_menu').hasClass('open_class'))
				$('a.menu_trigger').click();
		}
		if (e.keyCode === 18) // ALT (double)
			$('a.menu_trigger').click();
	});


	/* AUTO-RESIZE (textarea) */
	$(document).on('keyup','textarea', function(){
		var scroll = $(document).scrollTop();
	
		if ($(this).val().length === 0) 
			$(this).height(0);
		else {
			$(this).height(0);
			$(this).height(this.scrollHeight);
		}
		$(document).scrollTop(scroll);
	});
	$('textarea').keyup();

	
	
	/* input FOCUS & BLUR */
    $(document).on('focus','input[type="text"]', function() {
		attr = $(this).attr('string');
		var value = $(this).val();
        if(value == attr) $(this).val('');
		
		if ($(this).attr('id') == 'fakepassword') {
			$(this).hide();
			$(this).next().show().focus();
		}
    }).on('blur','input[type="text"]', function() {
		var string = $(this).val();
		if(string !== '') $(this).val(string);
		else $(this).val(attr);
    });
	
		

		

				
		/* NAVGATION active class */		
		/* WE HAVE: */
		// #[data-to = dropdown] // #!state[data-to = group] // #target-to-show_[group-to-hide_]
		
		/* (OPEN) .active for dropdown */
		$(document).on('click','a[data-to="dropdown"]', function(){
				$('a[data-to="dropdown"]').removeClass('active'); 
				$(this).addClass('active');
				$('.hidden_mask').show();
		});
		// CLOSE dropdown - $(document).click
		$('.hidden_mask').on('click',function(){
			$('a[data-to="dropdown"]').removeClass('active');
			$(this).hide();
		});
				
				
	

				/* just toggle */ // dropdown - stalking options
				$('.dropdown').on('click','#option-notification,#option-chatroom', function(){
					$(this).children('div').toggleClass('active');
				});
				
				/* ##target (siblings hide) -- TAB */
				$(document).on('click','a[href^="##"]', function(e) {
					e.preventDefault();
					var target = $(this).attr('href').replace('#','');
					$(this).addClass('active').siblings().removeClass('active');
					$(target).show().siblings('div').hide();
					window.localStorage.setItem('inventory','#'+target);
				});
		
				$(document).on('click', 'a[href="#"]', function(e){
					e.preventDefault();
				});
		
	/* without HASH CHANGE */	// <a href="#archive/file.php">
	var cache_ = {
		'_profile.php' : $('div#profile'),
		'status-a.php' : $('div#status-a')
	};
	
	
	$(document).on('click','a[href^="#"][href*=".php"]', function(e){
		e.preventDefault();
		
		var group = $(this).attr('data-to');
		var file  = $(this).attr('href').replace('#','').replace('!','');
		
		$('.ajax-box#'+group).children('.conteudo').hide();
		$('a[data-to="'+group+'"]').removeClass('active');
		$(this).addClass('active');
		
		if (group === 'main-wrapper')
			window.location.hash = '!'+file;

		if (cache_[file])
			cache_[file].show();
		else {
			$('.loading').show();
		
			cache_[file] = $('<div class="conteudo"/>').appendTo('.ajax-box#'+ group)
			.load('archive/'+file, function(){
				$('.loading').hide();
			});
		}
	});

	var hash = window.location.hash;
	$('a[href="'+hash+'"]').click();
	if (!hash)
		$('a#profile').click();
	
	
			
});