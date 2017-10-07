$(function(){

				
		/* Janela Modal */
			$('a[data-to="window"]').click(function(){
				var target = '#window';
				
				//fundo preto
				$('#mascara').fadeTo(500,0.5);
		 
				var left = ($(document).width() /2) - ( $(target).width() / 2 );
				var top = ($(window).height() / 2) - ( $(target).height() / 2 );
			 
				$(target).css({'top':top,'left':left}).show();
			});
		 // add .close().window script to the archive.php loaded

		 
		 
		 /* #target-to-SHOW[group-to-hide] */
		$(document).on('click','a[href$="_"]', function(){
			var id = $(this).attr('href').replace('#','');	// target
			var group = $(this).attr('data-to');			// group
			
			$('div[class~="'+group+'"]').hide();
			$('div[id="'+id+'"]').show();
			
			$('a[data-to="'+group+'"]').removeClass('active');
			$(this).addClass('active');
			
			return false;
		});
		 
		 
		 
});