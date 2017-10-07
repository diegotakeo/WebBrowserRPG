
/* DRAGGABLE (function) */
function drag_event(where){

	$(where + ' img.preview').draggable({
	  drag: function(event, ui) {
		if(ui.position.top>0) { ui.position.top = 0; }
		var maxtop = ui.helper.parent().height()-ui.helper.height();
		if(ui.position.top<maxtop) { ui.position.top = maxtop; }
		if(ui.position.left>0) { ui.position.left = 0; }
		var maxleft = ui.helper.parent().width()-ui.helper.width();
		if(ui.position.left<maxleft) { ui.position.left = maxleft; }
	  },
	  scroll: false
	});	
}
// ---------------------------------------------------------------------------------- //

/* Slider (function) */
function slider_event(img_width, img_height, where){

	var that = $(where + ' img.preview');
	
	// HACK --> prevent disproportion
	if (img_width < img_height)	{
		var y = img_width;
		that.width(y).height('auto');
	}
	else {
		var y = img_height;
		that.height(y).width('auto');
	}
	
	
		$(where + ' .slider').slider({
			step: 5,
			min : 300,
			max : y + 250,
			value: y,
			slide: function(event, ui) {  
				var zoom = ui.value; 
				if (img_width < img_height)	var x = {width:  zoom + 'px'};
				else						var x = {height: zoom + 'px'};
				
				that.stop(true).css(x);
				
					// HACK --> prevent offset
					var position = that.position();
					var left = position.left;
					var top  = position.top;
				
					var w = -(that.width()-300);
					var h = -(that.height()-300);
					
					if (left <= w) that.css('left', w + 'px');
					if (top  <= h) that.css('top', h + 'px');

			}
		}); 
}
// ---------------------------------------------------------------------------------- //

// ---------------------------------------------------------------------------------- //


	/* IMAGE PREVIEW (100% client-side) */
     function file_input(input) {
            if (input.files && input.files[0]) {	// hasFile
				if(input.files[0].size < 5000000){	// file.size < 5MB
					// loading.gif
					$('#drag-box_ label span').html('<img src="img/loader_bb.gif" style="margin-left:18px;">');
					$('.loading').show();

					
					file_to_upload = input.files[0]; // <-- var FILE to the SERVER
					var reader = new FileReader();

					reader.onload = function (e) {

						var $error = false;
						
						var img = new Image();
						img.src = e.target.result;
						
						// ERROR -> any IMAGE
						img.onerror = function(){
							$error_message('ERROR: Can\'t find any image');
							$('.loading').hide();
							$error = true;
						}
						if(!$error) {
							/* SUCCESSFUL -> go to preview */
							img.onload = function() {
								$('#preview_ img.preview').attr('src', img.src);
								
								// functions
								drag_event('#preview_');							// draggable
								slider_event(img.width,img.height,'#preview_');		// slider
								
								$('a[href="#preview_"]').show().click();			// ...
								$('#drag-box_ label span').text('+');				// --> remove loading.gif
								$('.loading').hide();								// 
								
								$('#preview_ input').attr('data-info','file_upload');	// $DATA for SUBMIT (if)
							}
						}
						
						
					}; //end - reader.onload

					reader.readAsDataURL(input.files[0]);
				}
				else {
					$error_message('ERROR: It\'s over 9000!<br> Your file size must be less than 5MB');
				}
            }		
        }

// ---------------------------------------------------------------------------------- //  
		
$(function(){

$("img.preview").each(function() {
  this.onselectstart = function() { return false; };
});

	/* DRAG 'N DROP FILE */
    var drag_file = function(e) {
        e.stopPropagation();
        e.preventDefault();
		$('.box-a').addClass('hover');
		$('#drop-mask').show();
    };
	
    var drag_leave = function(e) {
        e.stopPropagation();
        e.preventDefault();
		$('.box-a').removeClass('hover');
		$('#drop-mask').hide();
    };
	
	
		drop_file = function(e){
        e.stopPropagation();
        e.preventDefault();	
		$('.box-a').removeClass('hover');
		$('#drop-mask').hide();
		
		 var file = e.dataTransfer;
		file_input(file);
	};

    var dropArea = document.getElementById('drop-mask');
	
	if($('#change-cover div').length)
		dropArea.removeEventListener('drop', _drop_file);
		
	document.addEventListener('dragover', drag_file);
	dropArea.addEventListener('dragleave', drag_leave);
    dropArea.addEventListener('drop', drop_file);

	
// some fix
$('#avatar #change').click(function(){
	if($('#change-cover div').length)
		dropArea.removeEventListener('drop', _drop_file);
		
	dropArea.addEventListener('drop', drop_file);
});
	
// ---------------------------------------------------------------------------------- //  


		/* BY URL */
		$('#url_ .box-a').click(function(){
			var url = $('#get-url').val();
			var ext = url.toLowerCase();
			
			// if -> !empty
			if (url.length != 0) {
				// IF -> is image
				if (endsWith(ext,'.jpg') || endsWith(ext,'.jpeg') || endsWith(ext,'.png') || endsWith(ext,'.gif')) {
					$('.loading').show();	// loading.gif
					
					
					var $error = false;
					
					var img = new Image();
					img.src = url;
					
					// ERROR -> any IMAGE
					img.onerror = function(){
						$error_message('ERROR: Can\'t find any image');
						$('.loading').hide();
						$error = true;
					}
					if(!$error) {
						/* SUCCESSFUL -> go to preview */
						img.onload = function() {
							$('#preview_ img.preview').attr('src', url);
							
							// functions
							drag_event('#preview_');							// draggable
							slider_event(img.width,img.height,'#preview_');		// slider
							
							$('a[href="#preview_"]').show().click();			// ...
							$('.loading').hide();								// hide loading.gif
							
							$('#preview_ input').attr('data-info','by_url');	// $DATA for SUBMIT (if)
						}
					}
				}
				
				// ERROR -> empty URL
				else if (url == 'type img url here...')
					$error_message('ERROR: empty string. Write something!');

				// ERROR -> not image
				else 
					$error_message('ERROR: The URL must end with <br> JPG, JPEG, PNG or GIF');

			}
			

		});
// ---------------------------------------------------------------------------------- //
		
		/* CURRENT IMG */
		var url  = $('#avatar img').attr('src'); // img/avatar/xxx.jpg
		var url_ = url.split('/');
		var src  = 'img/image/'+url_[2];


			var $error = false;
			
			var img = new Image();
			img.src = src;
			
			// ERROR -> any IMAGE
			img.onerror = function(){
				$error_message('ERROR: Can\'t find any image');
				$('.loading').hide();
				$error = true;
			}
			if(!$error) {
				img.onload = function() {
					$('#current_ img.preview').attr('src', src);
					drag_event('#current_');							// draggable
					slider_event(img.width,img.height,'#current_');		// slider
				}
			}
	
		
// ---------------------------------------------------------------------------------- //	

		/* SUBMIT CALLBACK */
		$('.avatar-submit').click(function(){
			$('.loading').show();
			
			var $error = false,
				$data  = $(this).attr('data-info'),
		
				img  = $(this).parent().find('img'),
				src	 = img.attr('src'),			// source
				position = img.position(),
				top	 = -position.top,			// Y
				left = -position.left;			// X

			
			
			// GD Library DAMN HACK! <-- 300 = 100% 
			//(resize-value issue)
			var original_img = new Image();
			original_img.src = src;
			original_img.onload = function(){
					gd_w = (img.width()*300)/original_img.width; // <-- x/300 = resized/original
					dif  = gd_w - 300;
					gd_w = 300  - dif;	// because, x < 300 = ZOOM IN
					
					// (crop-value issue)
					var top_  = top;
					var left_ = left;
						
						// if ZOOM IN (+)
						if (img.width() > original_img.width+100){
							gd_w = 270 - (-((original_img.width - img.width()) * 80) / 250);
							// X e Y (issue)
							top_  = top  - ((img.height() - original_img.height) -100);
							left_ = left - 150;
						}



					var array = {'src':src, 'width':gd_w, 'top':top_, 'left':left_};
			
					$.ajaxSetup({async: false});
					/* current_ */ // <-- change POSITION (server)
					if ($data == 'current'){
						$.post('archive/img-avatar-position.php', array, function(data){
							$('.loading').hide();
							if(data){
								$error = true;
								$error_message(data);
							}
							else
								$error = false;	
						});
					}

					
					/* by url_ */
					if ($data == 'by_url'){
						$.post('archive/img-avatar-by_url.php', array, function(data){
							$('.loading').hide();
							if(data){
								$error = true;
								$error_message(data);
							}
							else
								$error = false;	
						});
					}
					
					/* upload file */ // <-- TO THE SERVER
					if ($data == 'file_upload'){
						if (file_to_upload) {
							var data;
							fdata = new FormData();  					// <-- DATA TO SEND
							fdata.append('file' , file_to_upload);
							fdata.append('width', gd_w );
							fdata.append('top'  , top  );
							fdata.append('left' , left );

							var xhr = new XMLHttpRequest();
							xhr.open('POST', 'archive/img-avatar-upload.php', false);

							
							xhr.onload = function(){					// <-- callback FUNCTION
								if (this.status == 200){
									$('.loading').hide();
									
									if (this.response){
										$error = true;
										$error_message(this.response);
									}
									else
										$error = false;									
								}
							}
							// SEND IT!
							xhr.send(fdata);
						}
					}
					$.ajaxSetup({async: true});

					
					/* NO ERRORS */ // <-- continue with JAVASCRIPT
					if (!$error) {
						var w 	 = (img.width()*200/300);		// width
							top	 = -top  * 200/300;				// Y
							left = -left * 200/300;				// X
					

						// set AVATAR image
						$('#avatar img').attr('src',src).width(w).css({'top':top,'left':left});
					
	
						$('#window #close').click(); // <-- close window		
					}


			}
		});
		

// ---------------------------------------------------------------------------------- //		

		
					/* fechar janela */
					$('#window #close').click(function(e){
						e.preventDefault();
						$('#mascara, #window, .drop-mask').hide();
						$('#drop-cover').show();
						
						toggle_drop();	
					});		
					$(document).keydown(function(e){
						if(e.which == 27) {
							$('#mascara, #window, .drop-mask').hide();
							$('#drop-cover').show();		

							toggle_drop();					
						};
					});		


					
	// MOZILLA HACK -- input[file]	
	$('#drag-box_ .upload-label').click(function(){
		$('#drag-box_ input[name="hidden-file"]').click();
	});

	
});

// function SUFFIX
function endsWith(str, suffix) {
    return str.indexOf(suffix, str.length - suffix.length) !== -1;
}

// TOGGLE DROP (avatar & cover)
function toggle_drop(){
	 var dropArea = document.getElementById('drop-mask');
	 
	dropArea.removeEventListener('drop', drop_file);
	if($('#change-cover div').length)
		dropArea.addEventListener('drop', _drop_file);
}
