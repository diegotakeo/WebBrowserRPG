<script>
	$(function(){
		/* KEYBOARD (macro) */
		$(document).keyup(function(e){
			if (e.keyCode === 81)	// ---- q
				$('a[href="##skills"]').click();
			if (e.keyCode === 87)	// ---- w
				$('a[href="##weapons"]').click();
			if (e.keyCode === 69)	// ---- e
				$('a[href="##dishes"]').click();
				
		});
		// LOCAL STORAGE (load)
		var cookie = window.localStorage.getItem('inventory');
		$('a[href="'+cookie+'"]').click();
		
		
		/* EQUIPAMENT */
		$('.backpack').on('click','.equip', function(){
					$_this    = $(this);
					$object   = $_this.parent().siblings('div'); // $('.item_information')
				var data_type = $object.data('type'); 			// ex. data-type = weapon/clothing
				var data_id   = $object.data('id');
				var slot 	  = $('#weapons .'+data_type);
				
				
				/* CLOTHING [...] */
				if (data_type === 'clothing')
					$('.clothing').addClass('highlight');
					
				
				/* WEAPON */
				else {
					// SWITCH if $exists
					if (slot.children('div').length != 0){
						$('.backpack').append(
						'<div>'+slot.html()+'\
						<div class="item_action noSelect">\
							<div class="equip" data-icon="✖">Equip</div>\
							<div class="upgrade" data-icon="★">Level Up!</div>\
							<div class="sell" data-icon="¥">Sell</div>\
						</div>\
						</div>');
					}
					
					slot.removeClass('empty_stuff').html($object);
					$_this.parent().parent().remove();
					
				}
		});
		
			/* [...] CLOTHING */
			$('#weapons').on('click','.highlight', function(){
				// SWITCH if $exists
				if ($(this).children('div').length != 0){
					$('.backpack').append(
					'<div>'+$(this).html()+'\
					<div class="item_action noSelect">\
						<div class="equip" data-icon="✖">Equip</div>\
						<div class="upgrade" data-icon="★">Level Up!</div>\
						<div class="sell" data-icon="¥">Sell</div>\
					</div>\
					</div>');
				}
				
				$(this).removeClass('empty_stuff').html($object);
				$('.clothing').removeClass('highlight');
				$_this.parent().parent().remove();
			});
	});	
</script>

<?php 
	session_start();
	$mypage = $_SESSION['mypage'];
	$user	= $_SESSION['this_page'];

	/* DATABASE STUFF */
	include 'config.php';
	$collection = $database->backpack;
	$query 		= array('url-name' => $user);
	$documents  = $collection->find($query)->sort(array('_id' => 1)); //remove sort, DO IT ON THE LOOP
	
	// SET BACKPACK LIST
	foreach($documents as $document){
		$_id[]   = $document['_id'];
		$level[] = $document['level'];
		$use[]   = $document['use'];
	}
	if (isset($_id)) {
		$collection = $database->inventory; // use friggen memcached! PREVENT RE-ACCESS TO DB
		$query = array('_id' => array('$in' => $_id));
		$documents = $collection->find($query)->sort(array('_id' => 1));
		
		// SET "ITEMS" INFORMATION
		foreach($documents as $document){
			$name[]   = $document['name'];
			$name_[]  = $document['name_'];
			$effect[] = $document['effect'];
			$slots[]  = $document['slots'];
			$type[]   = (isset($document['type'])) ? $document['type'] : 'clothing';
		}
	}
?>









<!------------------------------------------------------------------------------------------------------------------------------------>	
<!-- LEFT SIDE // HEALTH, NAVIGATION, EQUIP -->	

	<div id="inventory">
		<div style="width:300px; float:left;">
			<!-- HEALTH -->
			<div class="health hasArrow">
				<a href="#"> <span data-icon="">Hospital</span> </a>
				<a href="#"> <span data-icon="">Dishes</span>   </a>
			</div>
			
			<!-- NAVIGATION -->
			<div class="inventory_nav">
				<a href="##skills"	data-to="equipament" class="active"><div data-icon=""></div></a>
				<a href="##weapons"	data-to="equipament"><div data-icon=""></div></a>
				<a href="##dishes"	data-to="equipament"><div data-icon=""></div></a>
			</div>
			
			<!-- EQUIPAMENT  (ajax/tabs) -->
			<div class="ajax-box equipament">
				<div id="skills" class="hasArrow">
					<div class="empty_stuff"><span data-icon="">ブリザド Lv.01</span></div>
					<div class="empty_stuff"><span data-icon="">サンダー Lv.02</span></div>
					<div class="empty_stuff"><span data-icon="">ファイア Lv.01</span></div>
					<div class="empty_stuff"><span data-icon="">Tackle Lv.03</span></div>
				</div>
				<div id="weapons" class="hasArrow">
					<div class="empty_stuff weapon"   data-icon=""> <span>no weapon</span></div>
					<div class="empty_stuff clothing" data-icon="" id="I"> <span>no equip - I</span></div>
					<div class="empty_stuff clothing" data-icon="" id="II"> <span>no equip - II</span></div>
					<div class="empty_stuff clothing" data-icon="" id="III"> <span>no equip - III</span></div>
				</div>
				<div id="dishes" class="hasArrow">
					<div class="empty_stuff"><span data-icon="">empty...</span></div>
					<div id="dishes_info" class="hasLine">
						<div> <div class="progress" style="width:300px;"></div> <div></div><div></div><div></div><div></div><div></div><div></div></div>
						<div> <div class="progress" style="width:100px; bottom:0;"></div> <div></div><div></div><div></div><div></div><div></div><div></div></div>
					</div>
				</div>
			</div>
			
		</div>

		
<!------------------------------------------------------------------------------------------------------------------------------------>	
<!-- RIGHT SIDE // BACKPACK -->	
		
		<div style="width:500px; float:right;">
			<div class="backpack hasLine">
				<span id="label">backpack</span>
				<span id="money">¥ <?php echo $_SESSION['money'];?></span>
				<!------------------------------------->
				<?php
				if (isset($_id)) {
					$i = 0;
					foreach($_id as $id) {	
						$star  = '';
						$empty = '';
						$_slots = $slots[$i] - $level[$i];
						for ($x = 0; $x < $level[$i]; $x++)
							$star = $star.'★';
						for ($x = 0; $x < $_slots; $x++)
							$empty = $empty.'☆';
						
							
						echo '
						<div>
							<div class="item_information" data-type="'.$type[$i].'" data-id="'.$id.'">
								<span>'.$name[$i].' '.$star.$empty.'</span>
								<p>'.$name_[$i].'</p>
								<data>+'.$effect[$i].'</data>
							</div>';
							if ($mypage) {
							echo '
							<div class="item_action noSelect">
								<div class="equip" data-icon="✖">Equip</div>
								<div class="upgrade" data-icon="★">Level Up!</div>
								<div class="sell" data-icon="¥">Sell</div>
							</div>';
							}
						echo '	
						</div>';
						$i++;
					}
				}
				else 
					echo '<div style="text-align:center; line-height:130px; border:2px dashed #999;"><span>empty backpack...</span></div>';
				?>
			</div>
		</div>
	</div>