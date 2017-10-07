<style>
/* NAVIGATION 
--------------------------------------------------------------------------------------------------------------- */

#cover-left 			 {position:absolute;  left:-50px; width:50px; top:20px;}
#cover-left a div	 	 {background:#cecece; color:#666; height:50px; margin-bottom:1px; box-shadow:inset -10px 0px 10px rgba(1,1,1,.5);}

#cover-left a.active div {background:#faffb7; color:#86895e;}

a[data-to="cover-div"]  div:before {font-size:25pt; line-height:50px; margin-left:8px;}
 
a[href="#preview__"].active div {background:#FF596D; color:#fff;}
a[href="#preview__"] div {
	width:50px; 
	height:50px; 
	color:#555;
	background:#ccc;
	position:absolute;
	right:-50px;
	top:20px;
	box-shadow:inset 8px 0px 7px rgba(1,1,1,.5);
}
a[href="#preview__"] div:before {font-size:20pt; margin-left:10px;}

.cover-submit {
	position:absolute; 
	bottom:10px;
	right:15px;
	border:1px solid #464E7D;
	box-shadow:2px 2px 0px rgba(1,1,1,.5),4px 4px 0px rgba(1,1,1,.4); 	
}




/* DEFAULT BOXES 
--------------------------------------------------------------------------------------------------------------- */
.cover-div {display:none; height:400px; background:url(img/bg_7.png); border-bottom:1px solid #666;}
#current__ {display:block;}
.cover-prev {cursor:move;}

	#url__ div:hover,
	#drag-box__ label:hover,
	#drag-box__ label.hover
	  {border-color:#333; color:#333; background: rgba(9,9,9,.1);}

	#drag-box__ {padding-top:75px;}
	#drag-box__ .upload-label span  {font-size:90pt; line-height:150px; text-align:center;}
	#drag-box__ .upload-label {
		display:block;
		width: 250px; 
		height:250px; 
		margin:0 auto;
		z-index:7; 
		cursor:pointer;
		border:2px dashed #666;
		text-align:center;
		}
		
		
	#url__ input {width:730px; margin-left:90px;}
	#url__ input:focus ~ .icon:before {color:#333;}
	#url__ div {
		border:2px dashed #666; 
		width:200px; 
		height:200px; 
		position:absolute;
		right: 60px;
		bottom:40px;
		text-align:center; 
		padding-top:120px;
		font-size:28pt;
		cursor:pointer;
	}
	
	#url__ div:before {margin:-100px -40px; font-size:60pt;}
		

	#archive__ img {height:100px; float:left; margin:10px; box-shadow:5px 5px 5px rgba(0,0,0,0.5); opacity:0.5; cursor:pointer;}
	#archive__ img:hover {opacity:1;}
	
	.archive_nav {position:absolute; right:0; top:0;}
	.archive_nav a {height:400px; width:60px; float:right; line-height:400px; text-align:center; font-size:20pt;}
	.archive_nav a:hover {background-color:rgba(0,0,0,0.05); color:#333;}
</style>

<div id="cover-change-window">
		
				<div id="cover-left">
					<a href="#current__" 	data-to="cover-div" class="active">		<div data-icon=""></div>	</a>
					<a href="#archive__" 	data-to="cover-div">					<div data-icon=""></div>	</a>
					<a href="#drag-box__" 	data-to="cover-div">					<div data-icon=""></div>	</a>
					<a href="#url__"		data-to="cover-div">					<div data-icon=""></div>	</a>
				</div>
				<a href="#" id="close">X</a>
			
			
				<a href="#preview__" data-to="cover-div" style="display:none;">	<div data-icon=""></div> </a>
				
				
				
	<!-- IMG PREVIEW -->
	<!--------------------------------------->
	<div id="preview__" class="cover-prev cover-div">
		<input type="submit" class="cover-submit" value="★ --> ok">
	</div>
	<!-------------------------------------->

	
			<!-- 1 // CURRENT IMG -->
			<!--------------------------------------->
			<div id="current__" class="cover-prev cover-div">
				<input type="submit" class="cover-submit" data-info="current" value="★ --> ok">
			</div>
			<!-------------------------------------->

			
			<!-- 2 // ARCHIVE -->
			<!--------------------------------------->
			<div id="archive__" class="cover-div">
				<div class="archive_nav">
					<a href="#" class="a_next">></a>
					<a href="#" class="a_prev"><</a>
				</div>
			</div>
			<!-------------------------------------->
			
	
			<!-- 3 // UPLOAD -->
			<!-------------------------------------->
			<div id="drag-box__" class="cover-div noSelect">
				<input type="file" id="upload-cover" name="upload-cover" style="display:none;" onchange="$file_input(this);"/>
				
				<label class="upload-label" for="upload-cover">
					<span>+</span>
					<p>Drag-n-drop your image or click here to upload</p>
				</label>

				<!--[if IE]><p style="color:#666; position:absolute; bottom:-150px;">not working on IE</p><![endif]-->
			</div>
			<!-------------------------------------->
			
			

			<!-- 4 // BY URL -->
			<!-------------------------------------->
			<div id="url__" class="cover-div">
				<input type="text" id="get-url-cover" value="type img url here..." string="type img url here..."/>
				<label for="get-url-cover" class="icon" data-icon=""></label>		
					
				<div class="noSelect" data-icon="">
					<p>get it!</p>
				</div>
			</div>
			<!-------------------------------------->

</div>
				
				
				
<script src="js/draggable_background.js"></script>
<script>
// ----------------------------------------------------------------------------------------------------------- //


	/* upload > IMAGE PREVIEW (100% client-side) */
     function $file_input(input) {
            if (input.files && input.files[0]) {	// hasFile
				if(input.files[0].size < 5000000){	// file.size < 5MB
					// loading.gif
					$('#drag-box__ label span').html('<img src="img/loader_bb.gif" style="margin-left:18px;">');
					$('.loading').show();

					
					cover_to_upload = input.files[0]; // <-- var FILE to the SERVER
					
					
					var reader = new FileReader();

					reader.onload = function (e) {
						// CALLBACKS
						$('#preview__').css({'background': 'url('+e.target.result+') 0 0' });
						$('a[href="#preview__"]').show().click();
						
						$('#drag-box__ label span').text('+');	// remove loading.gif
						$('.loading').hide();
						
						$('#preview__ input').attr('data-info','file_upload');	// $DATA for SUBMIT (if)
 

					};

					reader.readAsDataURL(input.files[0]);
				}
				else
					$error_message('ERROR: Your file size must be less than 5MB');
				
            }		
        }


$(function(){

// BACKGROUND DRAGGABLE!! ^^
$('.cover-prev').backgroundDraggable();


// ---------------------------------------------------------------------------------- //

	/* DRAG 'N DROP FILE */
	var _drag_file = function(e) {
        e.stopPropagation();
        e.preventDefault();
		$('#drag-box__ label').addClass('hover');
		$('#drop-mask').show();

    };
	
    var _drag_leave = function(e) {
        e.stopPropagation();
        e.preventDefault();
		$('#drag-box__ label').removeClass('hover');
		$('#drop-mask').hide();
    };
	
	
		_drop_file = function(e){
        e.stopPropagation();
        e.preventDefault();	
		$('#drag-box__ label').removeClass('hover');
		$('#drop-mask').hide();
		
		 var file = e.dataTransfer;
		$file_input(file);
	};
	
	$('#drop-mask').unbind('drop');
    var dropArea = document.getElementById('drop-mask');
	document.addEventListener('dragover',  _drag_file);
	dropArea.addEventListener('dragleave', _drag_leave);
    dropArea.addEventListener('drop', 	   _drop_file);

	
// some fix
$('#cover').on('click', 'a#change', function(){
	if($('#avatar-change-window').length)
		dropArea.removeEventListener('drop', drop_file);
		
	dropArea.addEventListener('drop', _drop_file);
});
	
// ---------------------------------------------------------------------------------- //



		/* BY URL */
		$('#url__ div').click(function(){
			var url = $('#get-url-cover').val();
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
						img.onload = function() {
								/* SUCCESSFUL -> go to preview */
								// set URL
								$('#preview__').css('background-image', 'url('+url+')');
									
									$('a[href="#preview__"]').show().click();			// ...
									$('.loading').hide();								// hide loading.gif
									
									
									$('#preview__ input').attr('data-info','by_url');	// $DATA for SUBMIT (if)
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
		var url = $('#cover').css('background-image'), 	// url(img/cover/xxx.jpg)
			src  = url.replace(/^.*\/|\.[^.]*$/g, '');	// (xxx.jpg)
		$('#current__').css('background-image', 'url(img/image/'+src+'.jpg)');
		
		
		
		/* ARCHIVE */
		$('#archive__').on('click', 'img', function(){
			$('.loading').show();
			
			var url = $(this).attr('src').split('/');
			var img = new Image();
			img.src = 'img/image/'+url[2];

			img.onload = function() {
				// IMG LOADED -> go to preview
				$('#preview__').css('background-image', 'url('+img.src+')');
				$('a[href="#preview__"]').show().click();
				
				$('#preview__ input').attr('data-info','archive');	// $DATA for SUBMIT (if)
				$('.loading').hide();
			}
		});		
		// archive PAGINATION
		var cover_cache = {};
		var page = 0;
		$('a[href="#archive__"], .archive_nav a').on('click', function(){
			$('#archive__ > .conteudo').hide(); 
			
			if ($(this).hasClass('a_next'))
				page = page +1;
			if ($(this).hasClass('a_prev'))
				page = page -1;
			if (page < 0)
				page = 0;
				
			if (cover_cache[page])
				cover_cache[page].show();
			else {
				$('.loading').show();
				cover_cache[page] = $('<div class="conteudo"/>').appendTo('#archive__')
				.load('archive/img-cover-archive_ajax.php?page='+page, function(){
					$('.loading').hide();
				});
			}
		});
		
// ---------------------------------------------------------------------------------- //
		
		
		/* SUBMIT CALLBACK */
		$('.cover-submit').click(function(){
		
			$('.loading').show();

			var that 	 = $(this).parent(),
				position = that.css('backgroundPosition').split(' '),
				left 	 = parseInt(position[0]),		// X
				top 	 = parseInt(position[1]),		// Y
			
				img  = that.css('background-image'),	// SOURCE
				src  = img.replace(/^url\(["']?/, '').replace(/["']?\)$/, ''),
		
				$error = false,
				$data  = $(this).attr('data-info');

				var array = {'src':src, 'top':top, 'left':left};
			

					$.ajaxSetup({async: false});
					/* current_ */ // <-- change POSITION (server)
					if ($data == 'current'){
						$.post('archive/img-cover-position.php', array, function(data){
							if(data){
								$error = true;
								$error_message(data);
							}
							else
								$error = false;	
						});
					}
					
					/* achive__ */ // <-- change POSITION & update DATABASE (server)
					if ($data == 'archive'){
						$.post('archive/img-cover-archive.php', array, function(data){
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
						$.post('archive/img-cover-by_url.php', array, function(data){
							if(data){
								$error = true;
								$error_message(data);
							}
							else
								$error = false;	
						});
					}
					$.ajaxSetup({async: true});
					
					
					/* upload file */ // <-- TO THE SERVER
					if ($data == 'file_upload'){
						if (cover_to_upload) {
							var data;
							fdata = new FormData();  					// <-- DATA TO SEND
							fdata.append('file' , cover_to_upload);
							fdata.append('top'  , top  );
							fdata.append('left' , left );

							var xhr = new XMLHttpRequest();
							xhr.open('POST', 'archive/img-cover-upload.php', false);

							
							xhr.onload = function(){					// <-- callback FUNCTION
								if (this.status == 200){
									
									if (this.response){
										$error = true;
										error_message(this.response);
									}
									else
										$error = false;									
								}
							}
							// SEND IT!
							xhr.send(fdata);
						}
					}
					
					
					
					
					/* NO ERRORS */ // <-- continue with JAVASCRIPT
					if (!$error) {
						// set COVER background
						$('#cover').css({'background-image': 'url(' + src + ')', 'background-position': left+'px '+top+'px'});
					
	
						$('#cover #close').click(); // <-- close window				
					}
					$('.loading').hide();
		});		
		
// ---------------------------------------------------------------------------------- //
/* some useless configurations */

	// SHOW & HIDDEN (a#change)
	var a = $('#cover a#change').remove();
	$('#cover').on('click','a#change', function(){
		$(this).remove();
	});
	
	// #CLOSE
	$('#cover #close').click(function(){
		$('div#change-cover .conteudo').hide();
		$('#cover').append(a);
		
		// TOOGLE DROP (avatar & cover)
		var dropArea = document.getElementById('drop-mask');
		dropArea.removeEventListener('drop', _drop_file);
		if($('#window div').length)
			dropArea.addEventListener('drop', drop_file);
	});

	
	
	// SHOW & HIDDEN (submit:hover)
	$('.cover-prev').hover(function(){
		$('.cover-submit').show();
	},function(){
		$('.cover-submit').hide();
	});

	
		
	// MOZILLA HACK -- input[file]	
	$('#drag-box_ .upload-label').click(function(){
		$('#drag-box_ input[name="hidden-file"]').click();
	});	
		
		
// ---------------------------------------------------------------------------------- //		
		
});


// function SUFFIX
function endsWith(str, suffix) {
    return str.indexOf(suffix, str.length - suffix.length) !== -1;
}

</script>