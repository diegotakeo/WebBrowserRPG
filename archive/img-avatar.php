

<!-- CSS file -->
<link rel="stylesheet" type="text/css"  href="archive/img-avatar.css" />



<div id="avatar-change-window">
			
			
			<!-- NAVIGATION -->
			<!--------------------------------------->
			<div id="file-box-nav" class="noSelect">		<!-- [data-to] just to group links in the same category -->
				<a href="#current_" 	data-to="file-box-div" class="active">	<span>current img</span>	</a>
				<a href="#archive_"		data-to="file-box-div">					<span>archive</span>		</a>
				<a href="#drag-box_"	data-to="file-box-div">					<span>upload file</span>	</a>
				<a href="#url_"			data-to="file-box-div">					<span>by url</span>			</a>
			</div>	
			<!--------------------------------------->
				<a href="#preview_"		data-to="file-box-div">					<span>✪</span>		</a>
			
	<!-- IMG PREVIEW -->
	<!--------------------------------------->
	<div id="preview_" class="img-prev file-box-div noSelect">
		<div class="containment">
			<img class="preview" src="#">
		</div>
		
		<div class="slider"></div>
		<input type="submit" value="ok" class="avatar-submit">
	</div>
	<!-------------------------------------->

	
			<!-- 1 // CURRENT IMG -->
			<!--------------------------------------->
			<div id="current_" class="img-prev file-box-div noSelect">
				<div class="containment">
					<img class="preview" src="#">
				</div>
				
				<div class="slider"></div>
				<input type="submit" value="ok" class="avatar-submit" data-info="current">
			</div>
			<!-------------------------------------->

	
			<!-- 3 // UPLOAD -->
			<!-------------------------------------->
			<div id="drag-box_" class="file-box-div box-a box-shadow-LV0 noSelect">
				<input type="file" id="upload-perfil" name="hidden-file" style="display:none;" onchange="file_input(this);"/>
				
				<label class="upload-label">
					<span>+</span>
					<p>Drag-n-drop your image or click here to upload</p>
				</label>

				<!--[if IE]><p style="color:#666; position:absolute; bottom:-150px;">not working on IE</p><![endif]-->
			</div>
			<!-------------------------------------->
			
			

			<!-- 4 // BY URL -->
			<!-------------------------------------->
			<div id="url_" class="file-box-div">
				<input class="with-ico" type="text" id="get-url" value="type img url here..." string="type img url here..."/>
				<label for="get-url" class="icon" data-icon=""></label>		
				
				<div class="box-a box-shadow-LV0 noSelect" data-icon="">
					<p>get it!</p>
				</div>
			</div>
			<!-------------------------------------->
		
		
		<a href="#" id="close">X</a>

		
</div>		
		
		
		
		
		
	<!----------------------------------------------------------------------------------------------->
	<script src="js/jquery-ui/js/jquery-ui-1.10.3.custom.min.js"></script>
	<link  href="js/jquery-ui/css/custom-theme/jquery-ui-1.10.3.custom.min.css" rel="stylesheet">
	
	<script src="archive/img-avatar.js"></script>
	<!----------------------------------------------------------------------------------------------->

	