$(function(){

	// if there is AVAIBLE POINTS (to share)
	if ($('#attr #count').text() != 0){
		
		$('span[data^="+"]').show();
		
		cache_attr = {};
		plus = 0;
		
		//		['#379125','#6cd258','#306e59','#59cda6','#354772','#5775bc','#7a2a2a','#da3c3b','#817e3e','#d0d15f'];
		color = ['#379125','#6cd258','#517f2d','#80c848','#2c734d','#3bb172','#83a831','#acdc40','#298c60','#3bcb8b'];
		
		/* CLICK (event) */
		$('span[data]').click(function(){
			id	= $(this).parent().attr('id');	// return str,def,wis,agi,vit

			
			var num 	 = 	$('#'+id+' .progress-num').children('.atual').text();	// GET atual number (for progress bar percentage)
			var count	 =  $('#attr data#count').text();							// GET pontos disponíveis
			var count_	 = count;
			
			// parseInt()
			var num 	 = parseInt(num,'10');	
			var count	 = parseInt(count);
			
			
			// To calcule PLUS for each attr(str,def,wis,agi,vit)
			if(cache_attr[id])	plus = parseInt(cache_attr[id]);
			else {				plus = 0; cache_attr[id] = 0;}
			

			if ($(this).attr('data').substring(0,1) == '+') {
				if(count != 0){
				var count	= count-1;
				plus		= plus+1;
				}
			}else {
				var count 	= count+1;
				plus		= plus-1;
			};

			/* #COLOR & WIDTH (progress bar repeat) */
			if(num+plus < 11) {
				// (unidade)
				var progress = 0;	// dezena = 0
				var w = num+plus; 	// get unidade
			}
			else if (num+plus < 100) {
				// (dezena)
				var progress = (num+plus).toString().substring(0,1);	// get dezena  (bar nº)
				var w 		 = (num+plus).toString().substring(1,2); 	// get unidade (bar width)
				if(w == 0) {
					// some trick hack
					var w = 10; 
					var progress = progress-1;
				}
			}
			else {
				// (centena)
				var progress = (num+plus).toString().substring(1,2);	// get dezena  (bar nº)
				var w = (num+plus).toString().substring(2,3);			// get unidade (bar width)
				if(w == 0){
					// more trick hacks =3
					var w = 10;
					if(progress == 0)
						var progress = 10;	
					
					var progress = progress-1;
				}
			}
			
			// Verifica mudança na DEZENA (nº de barras)
			if (progress != cache_attr[id+'dezena']) {
				if($(this).text() == '-') {
					// Exclui barra
					$('.bar#'+id+' .progress-bar .progress:last-child').remove();
					$('.bar#'+id+' .first').css('background-color',color[progress]);
				}
				else{
					// Acrescenta barra
					$('.bar#'+id+' .progress-bar').append('<div class="progress" style="background-color:'+color[progress]+'"></div>');
					$('.bar#'+id+' .first').css('background-color',color[progress]);
				}
			}
			
			cache_attr[id+'dezena'] = progress;
			
			
				// SET IT!
				cache_attr[id] = plus;
				
				$('#'+id+' .progress-num').children('.plus').text(plus+' + ');	// set ADITION NUMBER(plus)
				$('#'+id+' .progress:last-child').css('width',w+'0%');			// set PROGRESS BAR WIDTH
				$('#attr data#count').text(count);								// set attr point(s) avaible
				$('form input[name="'+id+'"]').val(plus);						// set input VALUE (to send to the server)
				
				
				
					// show or hide MINUS(-) && PLUS(string)
					if (plus != 0) 	$('span[data="-'+id+'"], #'+id+' .plus').show();
					else			$('span[data="-'+id+'"], #'+id+' .plus').hide();
					
					
					// show or hide SUBMIT BUTTON
					var val = 0;
					var x = 0;
					$('#user-status input[type="hidden"]').each(function(){	// verify throught INPUTS if VALUE != 0
						x = $(this).val();
						val = val+parseInt(x);
					});
					if (val != 0) $('#attr-submit').show();
					else 		  $('#attr-submit').hide();	
				
				
				
			/* ADD e SUBTRACT ---> HEALTH POINTS */
			if (id == 'vit'){
				var hp_num  = $('#hp').next().text().split('/');
				
				if ($(this).attr('data').substring(0,1) == '+') {
					if (count_ != 0)	var max_hp  = (parseInt(hp_num[1]))+10;
					else				var max_hp	= hp_num[1];
				}
				else
					var max_hp  = (parseInt(hp_num[1]))-10;
					
				
				var percent = (hp_num[0]*100)/max_hp; 
				$('#hp').next().text(hp_num[0]+'/'+max_hp);
				$('#hp .progress').width(percent-1+'%');
			}
				
		});	
		// END ------ CLICK
		
		
		
		
		
		/* SUBMIT callback */
		$('#user-status form').submit(function(){
			$('.loading').show();
			var array = $(this).serializeArray();
			
			/* DATABASE UPDATE */ 
			$.post('archive/database_status-a.php', array, function(data){
				$('.loading').hide();
			
				if (data)
					$error_message(data);

				else {
					// do somethings with JAVASCRIPT
					$.each(array, function(i, input){
						// GET it
						var num = $('#'+input.name+' .atual').text();
						
						// parseInt() e calculate RESULT
						var num 		= parseInt(num,'10');			
							input.value = parseInt(input.value);
						var result		= num+input.value;
						
						if (result.toString().length == 1){
							var result = '0' + result;
						}
						
						// SET it !!
						$('#'+input.name+' .atual').text(result);
					});

					
					// CLEAR IT ALL!!
					cache_attr = {};
					plus = 0;
					$('span[data^="-"], .bar .plus').hide();
					$('#user-status input[type="hidden"]').val(0);	
					$('#attr-submit').hide();

					if ($('#attr data#count').text() == 0) 	$('span[data^="+"]').hide(); 	// if (count == 0) hide('+')
			
				}
			});	// END --- $.POST	
			
			return false;
		});		
		// END ------ SUBMIT
		
		
		
		
	};
	// END -- IF (count != 0)
});